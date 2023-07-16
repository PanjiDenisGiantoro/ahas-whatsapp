<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class RegisterController extends Controller
{
    public function index(){
        return view('auth.register');
    }

    public function store(Request $request){
       
         $username = $request->username;
         $email = $request->email;
         $emailCheck = User::where('email',$email)->first();
         if(!$emailCheck)
         {
            $usernameCheck = User::where('username',$username)->first();
            if(!$usernameCheck)
            {
                $oneDay = Carbon::now('Asia/Jakarta')->addDays(1);
                $register = User::create([
                        'username' =>$request->username,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'api_key' => '',
                        'chunk_blast' => 0,
                        'limit_device'=>1,
                        'active_subscription'=>'active',
                        'subscription_expired'=>$oneDay,
                     ]);
                $user = User::find($register->id);
                Auth::login($user);
                return redirect('home')->with('success','Anda berhasil mendaftar , anda mendapatkan kuota 1 device dengan semua fitur active, yang dapat di gunakan sampai '.$oneDay.' setelah itu silahkan hubugi admin untuk jangka waktu yg lebih panjang dengan pembayaran yg telah di tentukan');
            }else{
                return back()->with('error','username anda sudah terdaftar silahkan login dengan password anda');
            }
         }else{
            return back()->with('error','email anda sudah terdaftar silahkan login dengan password anda');
         }
       
    }
}
