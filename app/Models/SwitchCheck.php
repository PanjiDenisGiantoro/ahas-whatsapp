<?php

namespace App\Models;
use Carbon\Carbon;
use App\Models\Blast;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Number;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class SwitchCheck extends Model
{
	public static function sendSingle($campaign)
	{
		$isSenderConnected = Number::where('body', $campaign->sender)
                ->where('status', 'connected')
                ->first();
            if ($isSenderConnected) 
            {
                Campaign::where('id',$campaign->id)->update(['status'=>'processing']);
                $statusCampaign = Campaign::where('id', $campaign->id)->first();
                    
                if ($statusCampaign->status == 'paused') 
                {
                        return 'paused';
                }
                    $data = [];
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
                            $existName = strpos($campaign->message, '{name}');
                            if ($existName !== false) 
                            {
                                $name = Contact::whereNumber(
                                    $blast->receiver
                                )->first()->name;
                                $message = str_replace(
                                    '{name}',
                                    $name,
                                    $campaign->message
                                );
                            } else {
                                $message = $campaign->message;
                            }
                            $data[] = [
                                'campaign_id' => $campaign->id,
                                'receiver' => $blast->receiver,
                                'message' => $message,
                                'sender' => $campaign->sender,
                            ];
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
                        } catch (\Throwable $th) {
                            Log::info($th);
                            $blasts->each(function ($item) {
                                $item->status = 'failed';
                                $item->save();
                            });

                            // reset $data
                            $data = [];
                        }
                    }

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
                return 'success';
	}

	public static function switchHandle($campaign,$sender)
	{
		
		$isSenderConnected = Number::where('body', $sender)
                ->where('status', 'connected')
                ->first();
            if ($isSenderConnected) 
            {
                Campaign::where('id',$campaign->id)->update(['status'=>'processing']);
                $statusCampaign = Campaign::where('id', $campaign->id)->first();
                    
                if ($statusCampaign->status == 'paused') 
                {
                        return 'paused';
                }
                    $data = [];
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
                            $existName = strpos($campaign->message, '{name}');
                            if ($existName !== false) 
                            {
                                $name = Contact::whereNumber(
                                    $blast->receiver
                                )->first()->name;
                                $message = str_replace(
                                    '{name}',
                                    $name,
                                    $campaign->message
                                );
                            } else {
                                $message = $campaign->message;
                            }
                            $data[] = [
                                'campaign_id' => $campaign->id,
                                'receiver' => $blast->receiver,
                                'message' => $message,
                                'sender' => $sender,
                            ];
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
                             $blasts->each(function ($item) 
                             {
                                $item->status = 'success';
                                $item->save();
                                $numSuccess = DB::table('numbers')->where('body',$item->sender)->first();
                                if($numSuccess)
                                {
                                	$sdv = DB::table('switch_devices')->where('number_id',$numSuccess->id)->first();
                                	if($sdv)
                                	{
                                		DB::table('switch_device_log')->insert([
                                			'switch_device_id'=>$sdv->id,
                                			'campaign_id'=>$campaign->id,
                                			'created_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString()
                                		]);
                                	}
                                }
                             });
                             $data = [];
                        } catch (\Throwable $th) {
                            Log::info($th);
                            $blasts->each(function ($item) {
                                $item->status = 'failed';
                                $item->save();
                            });

                            // reset $data
                            $data = [];
                        }
                    }

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
                return 'success';
	}
}