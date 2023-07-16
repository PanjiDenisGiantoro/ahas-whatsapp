<?php

namespace App\Console\Commands;

use App\Http\Controllers\BlastController;
use App\Models\Blast as ModelsBlast;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Cron;
use App\Models\LogCron;
use App\Models\Number;
use App\Models\TemplateMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */


    public function handle()
    {
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
}
