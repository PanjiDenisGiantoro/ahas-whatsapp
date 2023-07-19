<?php

namespace App\Http\Controllers;

use App\Models\GreetingCustomer;
use App\Models\Tag;
use App\Models\TemplateMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GreetingController extends Controller
{
    public function index()
    {
        $dt = Carbon::now();

        $data = GreetingCustomer::with('templates')->whereDate('masuk', '=', date('Y-m-d'))->orderBy('created_at', 'DESC')->get();
        $template = TemplateMessage::where('templateType', 'greeting')->where('user_id',Auth::user()->id)->get();
        $files = DB::table('system_storages')
            ->where('user_id',Auth::user()->id)
            ->orderBy('created_at','DESC')
            ->get();

        return view('newcomponent.greeting', compact('data','template','files'));
    }

    public function saveCustomer(Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);

        $greet =  GreetingCustomer::create([
            'name' => $request->name,
            'number' => $request->number,
            'jenis_motor' => $request->jenis_motor,
            'masuk' => Carbon::now()->toDateTimeString(),
            'idtemplate' => $request->template_greeting,
            'sender' => $request->sender,
            'image_greeting' => $request->gambar1,
            'image_bye' => $request->gambar2,
        ]);

        $template = TemplateMessage::where('id', $request->template_greeting)->first();

        $greet->update([
            'status' => '1'
        ]);

        $entah = new \App\Http\Controllers\MessagesController;
        if($greet->image_greeting == null) {
            // send as text
            $entah->postMsg([
                'type' => 'text', 
                'token' => $greet->sender,
                'number' => $greet->number,
                'text' => str_replace(['{name}', '{number}','{nopol}'], [$greet->name, $greet->number,$greet->jenis_motor], $template->templateMessage),
            ], 'backend-send-text');
        } else {
            // send with media
            $entah->postMsg([
                'type' => "image", 
                'token' => "6282128350067", 
                'url' => $greet->image_greeting, 
                'number' => "6289627654005", 
                'caption' => str_replace(['{name}', '{number}','{nopol}'], [$greet->name, $greet->number,$greet->jenis_motor], $template->templateMessage), 
                'fileName' => pathinfo($greet->image_greeting, PATHINFO_FILENAME)
            ], 'backend-send-media');
        }


        return back()->with('alert',[
            'type' => 'success',
            'msg' => 'Success add tag!'
        ]);
    }
    public function greeting($id,Request $request){

        $greet = GreetingCustomer::with('templates')->find($id);


                                                    return back()->with('alert',[
                                                        'type' => 'success',
                                                        'msg' => 'Success send message!'
                                                    ]);
    }

    public function bye($id){

        $greet = GreetingCustomer::with('templates')->find($id);
        $greet->update([
            'status' => '2'
        ]);

        $entah = new \App\Http\Controllers\MessagesController;
        if($greet->image_bye == null) {
            // send as text
            $entah->postMsg([
                'type' => 'text', 
                'token' => $greet->sender,
                'number' => $greet->number,
                'text' => str_replace(['{name}', '{number}','{nopol}'], [$greet->name, $greet->number,$greet->jenis_motor], $greet->templates->templateGoodBye),
            ], 'backend-send-text');
        } else {
            // send with media
            $entah->postMsg([
                'type' => "image", 
                'token' => "6282128350067", 
                'url' => $greet->image_bye,
                'number' => "6289627654005", 
                'caption' => str_replace(['{name}', '{number}','{nopol}'], [$greet->name, $greet->number,$greet->jenis_motor], $greet->templates->templateGoodBye), 
                'fileName' => pathinfo($greet->image_greeting, PATHINFO_FILENAME)
            ], 'backend-send-media');
        }


        return back()->with('alert',[
            'type' => 'success',
            'msg' => 'Success send message!'
        ]);
    }

    public function tes()
    {
        $data = [
            'api_key' => 'uuh33HHGq2yMxyxOFqfY3zgctLjNjp',
            'sender' => 'Sender',
            'number' => 'receiver',
            'message' => 'Your caption',
            'url' => 'Url Media',
            'type' => 'audio / video / image / pdf / xls /xlsx /doc /docx /zip'//Choose One
                                                    ];
                                                    $curl = curl_init();

                                                    curl_setopt_array($curl, array(
                                                        CURLOPT_URL => env('WA_URL_SERVER').'/send-media',
                                                      CURLOPT_RETURNTRANSFER => true,
                                                      CURLOPT_ENCODING => '',
                                                      CURLOPT_MAXREDIRS => 10,
                                                      CURLOPT_TIMEOUT => 0,
                                                      CURLOPT_FOLLOWLOCATION => true,
                                                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                      CURLOPT_CUSTOMREQUEST => 'POST',
                                                      CURLOPT_POSTFIELDS => json_encode($data),
                                                      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
                                                    ));

                                                    $response = curl_exec($curl);

                                                    curl_close($curl);
                                                    echo $response;
    }

}
