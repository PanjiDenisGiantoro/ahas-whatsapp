<?php

namespace App\Models;
use DB;
use Illuminate\Support\Facades\Http;
class CheckNumberValidate 
{
    public function checkIt($number)
    {
        $senderJustSee = DB::table('numbers')->where('status','connected')->first();
        if($senderJustSee)
        {
             $data = [
                'token' => $senderJustSee->body,
                'number' => $number,
            ];
            $params = json_decode($this->hitNode($data,'backend-check-valid-number'));
            $result = json_decode(json_encode($params),true);
            if(isset($result['message']))
            {
                if($result['message'] == 'valid')
                {
                    DB::table('contacts')->where('number',$number)->update([
                        'status_valid' => 'true'
                    ]);
                }elseif ($result['message'] == 'not_valid') 
                {
                    DB::table('contacts')->where('number',$number)->update([
                        'status_valid' => 'false'
                    ]);
                }
                return $result['message'];
            }
        }else{
            return false;
        }
    }

    public function hitNode($data,$url)
    {
        try {

            $post = Http::withOptions(['verify' => false])->asForm()->post(env('WA_URL_SERVER').'/'.$url,$data);
            return $post->body();
            if(json_decode($post)->status === true){
                //not do anything just checked number
            }
            return $post;
        } catch (\Throwable $th) {
            return 'Make sure your server Node already running!';
        }
    }
}