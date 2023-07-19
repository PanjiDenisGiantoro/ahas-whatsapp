<?php

namespace App\Console\Commands;

use App\Models\Blast;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Number;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Polyfill\Intl\Idn\Info;
use DB;
class StartBlast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:blast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For Blasting Message';

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
        $waitingCampaigns = Campaign::where('status', 'waiting')
            ->orWhere('status', 'processing')
            ->where('schedule', '<=', now())
            ->get();

        foreach ($waitingCampaigns as $campaign)
        {
            //$campaign = $campaign;
            $isSenderConnected = Number::where('body', $campaign->sender)
                ->where('status', 'Connected')
                ->first();

            if ($isSenderConnected)
            {
                //$campaign->status = 'processing';
                //$campaign->save();
                Campaign::where('id',$campaign->id)->update(['status'=>'processing']);
                $statusCampaign = Campaign::where('id', $campaign->id)->first();

                if ($statusCampaign->status == 'paused')
                {
                    return $this->info('paused!');
                }
                $data = [];
                // $get = rand(30, 50);
                $blastcount = Blast::where('campaign_id', $campaign->id)
                    ->where('status', 'pending')
                    ->count();
                if ($blastcount > 0)
                {
                    $blasts = Blast::where('campaign_id', $campaign->id)
                        ->where('status', 'pending')
                        ->limit(10)
                        ->get();
                    foreach ($blasts as $blast)
                    {
                        // if exist {name} in message
                        $existName = strpos($campaign->message, '{name}');
//                            $existName = strpos($campaign->message,
//                                ['{name}', '{nama_ahas}','{tanggal_expired}','{jenis_kpb}','{deskripsi}'],
//                            );
                        if ($existName !== false)
                        {
//                                $name = Contact::whereNumber(
//                                    $blast->receiver
//                                )->where('tag_id' , $campaign->tag)->first();

                            // $name = Contact::leftJoin("blasts","contacts.id","=","blasts.id_contact")
                            //     ->where('blasts.id_contact',$blast->id_contact)
                            //     ->first();

                            $name = Contact::leftJoin("blasts", "contacts.id", "=", "blasts.id_contact")
                                ->where('blasts.id_contact', $blast->id_contact)
                                ->select('contacts.*') // Select all columns from contacts table
                                ->orderBy('contacts.id', 'desc') // Order by id column in contacts table
                                ->first();

                            $message = str_replace(
                                ['{name}', '{nama_ahas}','{tanggal_expired}','{jenis_kpb}','{deskripsi}','{sub_area}','{KM}','{jenis_data}','{no_ahas}','{tanggal_lahir}','{no_mesin}','{bulan}'],
                                [$name->name, $name->nama_ahas, $name->tanggal_expired, $name->jenis_kpb, $name->deskripsi, $name->sub_area,$name->KM,$name->jenis_data,$name->no_ahas,$name->tanggal_lahir,$name->no_mesin,$name->bulan],
//
                                $campaign->message
                            );
//                                $message = str_replace(
//                                    '{name}',
//                                    [$name->name, $name->deskripsi],
//                                    $campaign->message
//                                );
//                                $message = str_replace(
//                                    '{name}',
//                                    $name,
//                                    $campaign->message
//                                );
                        } else {
                            $message = $campaign->message;
                        }
                        $data[] = [
                            'campaign_id' => $campaign->id,
                            'receiver' => $blast->receiver,
                            'message' => $message,
                            'sender' => $campaign->sender,
                        ];
                        //DB::table('blasts')->where('id',$blast->id)->update(['status'=>'success']);
                    }

                    try {

                        $proc = Http::withOptions(['verify' => false])
                            ->asForm()
                            ->post(
                                env('WA_URL_SERVER') . '/backend-blast',
                                [
                                    'data' => json_encode($data),
                                    'delay' => 1,
                                ]
                            );
                        Log::info($proc);


                        $blasts->each(function ($item) {
                            $item->status = 'success';
                            $item->save();
                        });
                        $data = [];
                        //checkBlastPending($campaign, $isCampaignNotPaused);
                    } catch (\Throwable $th) {
                        Log::info($th);
                        // if in blasts still have status pending change status to finish
                        $blasts->each(function ($item) {
                            $item->status = 'failed';
                            $item->save();
                        });

                        // reset $data
                        $data = [];
                        //checkBlastPending($campaign, $isCampaignNotPaused);
                    }

                }
                //}

                //checkBlastPending($campaign, $isCampaignNotPaused);

                $statusCampaignCheck = Campaign::where('id', $campaign->id)->first();
                if($statusCampaignCheck)
                {
                    if ($statusCampaignCheck->status != 'paused')
                    {
                        $blastcountCheck = Blast::where('campaign_id', $campaign->id)
                            ->where('status', 'pending')
                            ->count();
                        if($blastcountCheck <= 0)
                        {
                            Campaign::where('id',$campaign->id)->update(['status'=>'finish']);
                        }
                    }
                }
            }
        }

        return $this->info('sucess!');
    }
}
