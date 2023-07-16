<?php



namespace App\Http\Controllers;

use App\Models\Cron;

use App\Models\Number;

use App\Models\TemplateMessage;

use Carbon\Carbon;

use DB;

use App\Models\Tag;

use Illuminate\Http\Request;

use Auth;

class CampaignController extends Controller

{

    public function index(Request $request)

    {

        $template = TemplateMessage::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->get();

        $files = DB::table('system_storages')

                    ->where('user_id',Auth::user()->id)

                    ->orderBy('created_at','DESC')

                    //->limit(4)

                    ->get();
                    
        $connectedContacts = Number::where('status', 'Connected')
            ->get();

        return view('pages.campaign-create', [
            'tags' => $request->user()->tags()->withCount('contacts')->get(),
            'files'=> $files,
            'templates'=> $template,
            'connectedContacts' => $connectedContacts
        ]);

    }



    public function gettemplate(Request $request){

        $template = TemplateMessage::where('id',$request->template)->first();

        if ($template) {

            return response()->json([

                'status' => 'success',

                'data' => $template

            ]);

        }else{



            return response()->json([

                'status' => 'error',

                'data' => 'Template tidak ditemukan'

            ]);

        }

    }

    public function lists (Request $request)

    {



        $campaigns = $request->user()->campaigns()->withCount(['blasts','blasts as blasts_pending' => function($q){

            return $q->where('status', 'pending');

        }])->withCount(['blasts as blasts_success' => function($q){

            return $q->where('status', 'success');

        }])->withCount(['blasts as blasts_failed' => function($q){

            return $q->where('status', 'failed');

        }])->orderBy('id', 'desc')->get();        

        return view('pages.campaign-lists', [

           'campaigns' => $campaigns,

        ]);

    }



    public function show (Request $request, $id)

    {

        $campaign = $request->user()->campaigns()->find($id);

        if ($request->ajax()) {

           



            switch ($campaign->type) {

                case 'text':

                    return view('ajax.autoreply.textshow', [

                        'keyword' => 'PREVIEW MESSAGE',

                        'text' => json_decode($campaign->message)->text

                    ])->render();

                    break;

                case 'image':

                    return  view('ajax.autoreply.imageshow', [

                        'keyword' => 'PREVIEW MESSAGE',

                        'caption' => json_decode($campaign->message)->caption,

                        'image' => json_decode($campaign->message)->image->url,

                    ])->render();

                    break;

                case 'button':

                    // if exists property image in $campaign->message



                    return  view('ajax.autoreply.buttonshow', [

                        'keyword' => 'PREVIEW MESSAGE',

                        'message' => json_decode($campaign->message)->text ?? json_decode($campaign->message)->caption,

                        'footer' => json_decode($campaign->message)->footer,

                        'buttons' => json_decode($campaign->message)->buttons,

                        'image' => json_decode($campaign->message)->image->url ?? null,

                    ])->render();

                    break;

                case 'template':



                    $templates = [];

                    // if exists template 1



                    return  view('ajax.autoreply.templateshow', [

                        'keyword' => 'PREVIEW MESSAGE',

                        'message' => json_decode($campaign->message)->text ?? json_decode($campaign->message)->caption,

                        'footer' => json_decode($campaign->message)->footer,

                        'templates' => json_decode($campaign->message)->templateButtons,

                        'image' => json_decode($campaign->message)->image->url ?? null,

                    ])->render();

                    break;

                default:

                    # code...

                    break;

            }

        }



        

    }

    public function destroyAll (Request $request)

    {

        $campaign = $request->user()->campaigns()->delete();

       session()->flash('alert' , [

        'type' => 'success',

        'msg' => 'All campaigns deleted',

       ]);



        

      



        return redirect()->back();

    }



    public function pause (Request $request, $id)

    {

        $campaign = $request->user()->campaigns()->find($id);

        $campaign->status = 'paused';

        $campaign->save();

        session()->flash('alert' , [

            'type' => 'success',

            'msg' => 'Campaign paused',

           ]);

        return json_encode([

            'status' => 'success',

            'msg' => 'Campaign paused',

        ]);

    }



    public function resume (Request $request, $id)

    {

        $campaign = $request->user()->campaigns()->find($id);



        // faild if there is campaign in status processing or waiting

        $campaigns = $request->user()->campaigns()->whereSender($campaign->sender)->whereIn('status', ['processing','waiting'])->get();

   

        if ($campaigns->count() > 0) {

             session()->flash('alert' , [

            'type' => 'danger',

            'msg' => 'You have another campaign in status processing or waiting'

              ]);

         

        } else {



            $campaign->status = 'processing';

            $campaign->save();

            session()->flash('alert' , [

                'type' => 'success',

                'msg' => 'Campaign resumed',

               ]);

        }





         return json_encode([

            'status' => 'error',

            'msg' => 'You have another campaign in status processing or waiting',

        ]);

    }

    public function cron(Request $request){



        $number = Number::where('user_id',Auth::user()->id)->get();

        $cron = Cron::where('id_cron',1)->first();

        $templateulang = TemplateMessage::where('templateType' ,'Ulang Tahun')->get();

        $templatepromo = TemplateMessage::where('templateType' ,'Promo')->get();

        $templatekpb = TemplateMessage::where('templateType' ,'Sudah Servis')->get();

        $template = TemplateMessage::all();



        return view('pages.cron', [

            'tags' => $request->user()->tags,

            'number'=>$number,

            'cron'=>$cron,

            'templateulang'=>$templateulang,

            'templatepromo'=>$templatepromo,

            'templatekpb'=>$templatekpb,

            'template'=>$template

        ]);

    }

    public function cron_ulang(Request $request){

        $request->merge([

            'update_at' => Carbon::now()

        ]);

        Cron::where('id_cron', 1)->update(['auto_ulang_tahun' => $request->ulang]);

        return json_encode([

            'status' => 'success',

            'msg' => 'Cron berhasil diubah',

        ]);

    }

    public function cron_kpb(Request $request){

        $request->merge([

            'update_at' => Carbon::now()

        ]);

        Cron::where('id_cron', 1)->update(['auto_kpb' => $request->kpb]);

        return json_encode([

            'status' => 'success',

            'msg' => 'Cron berhasil diubah',

        ]);

    }

    public function cron_promo(Request $request){

        $request->merge([

            'update_at' => Carbon::now()

        ]);

        Cron::where('id_cron', 1)->update(['auto_promo' => $request->promo]);

        return json_encode([

            'status' => 'success',

            'msg' => 'Cron berhasil diubah',

        ]);

    }

    public function cron_save(Request $request){

        $update = Cron::where('id_cron', 1)->update([

            'nomor' => $request->nomor,

        ]);



        return redirect()->back();

    }

    public function cron_save_batch(Request $request){

        $update = Cron::where('id_cron', 1)->update([

            'pesan_ulang' => $request->pesan_ulang,

            'pesan_promo' => $request->pesan_promo,

            'pesan_kpb' => $request->pesan_kpb,

            'pesan_servis' => $request->pesan_servis,

        ]);



        return redirect()->back();



    }





}

