<?php

namespace App\Http\Controllers;

use App\Models\Blast as ModelsBlast;
use App\Models\Contact;
use App\Models\Cron;
use App\Models\LogCron;
use App\Models\Number;
use App\Models\TemplateMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use DB;
use Illuminate\Support\Facades\Log;

class MessagesController extends Controller
{
    
    public function index(Request $request){
        $template = TemplateMessage::where('user_id', Auth::user()->id)->get();
         $files = DB::table('system_storages')
                    ->where('user_id',Auth::user()->id)
                    ->orderBy('created_at','DESC')
                    //->limit(4)
                    ->get();
        return view('pages.messagetest',[
            //'numbers' => $request->user()->numbers()->latest()->paginate(10),
            'files'=>$files,
            'templates'=>$template
        ]);
       
    }


    public function textMessageTest(Request $request){
        $data = [
            'type' => 'text',
            'token' => $request->sender,
            'number' => $request->number,
            'text' => $request->message
        ];
        $number = Number::whereBody($request->sender)->first();
        if($number->status == 'Disconnect'){
            return redirect()->back()->with('alert',['type' => 'danger','msg' => 'Sender is disconnected']);
        }
        $sendMessage = json_decode($this->postMsg($data,'backend-send-text'));
        if(!$sendMessage->status){
           return redirect()->back()->with('alert',['type' => 'danger','msg' => $sendMessage->msg ?? $sendMessage->message]);
        }
        $number->messages_sent += 1;
        $number->save();
        return redirect()->back()->with('alert',['type' => 'success','msg' => 'Message sent, '. json_encode($sendMessage->data)]);
    }


    public function imageMessageTest(Request $request){
        //return $request->all();
        $url = $request->url;
        $fileName = pathinfo($url, PATHINFO_FILENAME);
        //return $fileName;
        $data = [
            'type' => $request->type,
            'token' => $request->sender,
            'url' => $request->url,
            'number' => $request->number,
            'caption' => $request->message,
            'fileName' => $fileName,
            'type' => $request->type
        ];
        $number = Number::whereBody($request->sender)->first();
        if ($number->status == 'Disconnect') {
            return redirect()->back()->with('alert', ['type' => 'danger', 'msg' => 'Sender is disconnected']);
        }
        $sendMessage = json_decode($this->postMsg($data,'backend-send-media'));
        if (!$sendMessage->status) {
            return redirect()->back()->with('alert', ['type' => 'danger', 'msg' => $sendMessage->msg ?? $sendMessage->message]);
        }
        $number->messages_sent += 1;
        $number->save();
        return redirect()->back()->with('alert', ['type' => 'success', 'msg' => 'Message sent, ' . json_encode($sendMessage->data)]);
    
       

    }
    public function buttonMessageTest(Request $request){
        
        if(!$request->has('button')){
            return redirect()->back()->with('alert',['type' => 'danger','msg' => 'No buttons selected']);
        }
        $buttons = [
          
        ];
        if(count($request->button) > 0){
            for($i = 1; $i <= count($request->button); $i++){
                $buttons[] = ['displayText' => $request->button[$i]];
            }
        }

        
        $data = [
            'token' => $request->sender,
            'number' => $request->number,
            'button' => json_encode($buttons),
            'message' => $request->message,
            'footer' => $request->footer ?? '',
            'image' => $request->url ?? '',
        ];
       
        $number = Number::whereBody($request->sender)->first();
        if($number->status == 'Disconnect'){
            return redirect()->back()->with('alert',['type' => 'danger','msg' => 'Sender is disconnected']);
        }
        $sendMessage = json_decode($this->postMsg($data,'backend-send-button'));
        if (!$sendMessage->status) {
            return redirect()->back()->with('alert', ['type' => 'danger', 'msg' => $sendMessage->msg ?? $sendMessage->message]);
        }
        $number->messages_sent += 1;
        $number->save();
        return redirect()->back()->with('alert', ['type' => 'success', 'msg' => 'Message sent, ' . json_encode($sendMessage->data)]);
    
       
    }
    public function templateMessageTest(Request $request){
      if(!$request->has('template')){
            return redirect()->back()->with('alert',['type' => 'danger','msg' => 'No template selected']);
        }
        
        $templates = [];

            $ii = 0;
            try {
                //code...
                foreach($request->template as $template){
                    $ii++;
                 $allowType = ['callButton', 'urlButton','idButton'];
                 $type = explode('|', $template)[0] . 'Button';
                 $text = explode('|', $template)[1];
                 $urlOrNumber = explode('|', $template)[2];
    
                 if (!in_array($type, $allowType)) {
                    return back()->with('alert', [
                        'type' => 'danger',
                        'msg' => 'The Templates are not valid!'
                    ]);
                 }
    
                $ty = explode('|', $template)[0];
                $type = $ty ==  'id' ? 'quickReplyButton' : $type;
                if($ty == 'url') {
                    $typePurpose = 'url';
                } else if($ty == 'call'){
                    $typePurpose = 'phoneNumber';
                } else {
                    $typePurpose = 'id';
                }
                $templates[] = ["index" => $ii, $type => ["displayText" => $text, $typePurpose => $urlOrNumber]];
            }
            } catch (\Throwable $th) {
               return redirect()->back()->with('alert',['type' => 'danger','msg' => 'The Templates are not valid!']);
            }
            
        
        $data = [
            'token' => $request->sender,
            'number' => $request->number,
            'button' => json_encode($templates),
            'text' => $request->message,
            'footer' => $request->footer ?? '',
            'image' => $request->url ?? '',
        ];
       

        $number = Number::whereBody($request->sender)->first();
        if($number->status == 'Disconnect'){
            return redirect()->back()->with('alert',['type' => 'danger','msg' => 'Sender is disconnected']);
        }
        $sendMessage = json_decode($this->postMsg($data,'backend-send-template'));
        if (!$sendMessage->status) {
            return redirect()->back()->with('alert', ['type' => 'danger', 'msg' => $sendMessage->msg ?? $sendMessage->message]);
        }
        $number->messages_sent += 1;
        $number->save();
        return redirect()->back()->with('alert', ['type' => 'success', 'msg' => 'Message sent, ' . json_encode($sendMessage->data)]);
    }


    public function listMessageTest(Request $request){
       if(!$request->has('list')){
            return redirect()->back()->with('alert',['type' => 'danger','msg' => 'No list selected']);
        }

        $section['title'] = $request->title;
      
        $i = 0;
        foreach ($request->list as $menu) {
            $i++;
            $section['rows'][] = [
                'title' => $menu,
                'rowId' => 'id' . $i,
                'description' => '',
            ];
        }
       
        $data = [
            'token' => $request->sender,
            'number' => $request->number,
            'list' => json_encode($section),
            'text' => $request->message,
            'footer' => $request->footer ?? '',
            'title' => $request->title,
            'buttonText' => $request->buttontext,
        ];
     
        $number = Number::whereBody($request->sender)->first();
        if($number->status == 'Disconnect'){
            return redirect()->back()->with('alert',['type' => 'danger','msg' => 'Sender is disconnected']);
        }
        $sendMessage = json_decode($this->postMsg($data,'backend-send-list'));
       
        if (!$sendMessage->status) {
            return redirect()->back()->with('alert', ['type' => 'danger', 'msg' => $sendMessage->msg ?? $sendMessage->message]);
        }
        $number->messages_sent += 1;
        $number->save();
        return redirect()->back()->with('alert', ['type' => 'success', 'msg' => 'Message sent, ' . json_encode($sendMessage->data)]);
       


       
       
    }
    

    public function auto_ulang_tahun(Request $request){
        $cek = Cron::where('id_cron', 1)->first();
        if ($cek->auto_ulang_tahun == 1) {

            $number = Number::where('id', $cek->nomor)->first();
            $template = TemplateMessage::where('id', $cek->pesan_ulang)->first();

            try {
                $datas = Contact::where('tanggal_lahir', date('Y-m-d'))
                    ->get();
//                ddd($datas);
//                Log:
//                info($datas);


                // foreach destination and push to data
                foreach ($datas as $blast) {
                    // if there is {name} in message, replace it with contact name
                    $contact = Contact::whereNumber($blast->number)->first();
                    // replace {name} to name contact if there is name
                    if ($contact->name && $contact->number) {
                        $message = str_replace(
//                            name,id
                            ['{name}', '{nama_ahas}'],
                            [$contact->name, $contact->nama_ahas],
//                                '{name}',
//                                $contact->name,
                            $template->templateMessage
                        );
                        $data = [
                            'api_key' => 'uuh33HHGq2yMxyxOFqfY3zgctLjNjp',
                            'sender' => $number->body,
                            'number' => $contact->number,
                            'message' => $template->templateMessage,
                        ];
//
                        $number = Number::whereBody($number->body)->first();
                        if($number->status == 'Disconnect'){
//                            return redirect()->back()->with('alert',['type' => 'danger','msg' => 'Sender is disconnected']);
                        }
                        $sendMessage = json_decode($this->postMsg($data,'backend-send-text'));
                        if(!$sendMessage->status){
//                            return redirect()->back()->with('alert',['type' => 'danger','msg' => $sendMessage->msg ?? $sendMessage->message]);
                        }
                        $number->messages_sent += 1;
                        $number->save();
                        LogCron::create([
                            'no_cron' => 'Ultah'.date('Y-m-d'),
                            'user_id' =>  $cek->nomor,
                            'sender' => $number->body,
                            'receiver' => $contact->number,
                            'message' => $template->templateMessage,
                            'status' => 'success',
                            'type' => 'auto',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                    }
                }
            } catch (\Throwable $th) {
                Log::info($th);
            }
        }
    }
    public function postMsg($data,$url){
        try {

            $post = Http::withOptions(['verify' => false])->asForm()->post(env('WA_URL_SERVER').'/'.$url,$data);
            return $post->body();
            if(json_decode($post)->status === true){
                $c = Number::whereBody($data['sender'])->first();
                $c->messages_sent += 1;
                $c->save();
            }
            return $post;
        } catch (\Throwable $th) {
            return json_encode(['status' => false,'msg' => 'Make sure your server Node already running!']);
        }
    }

}
