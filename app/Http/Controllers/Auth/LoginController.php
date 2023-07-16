<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    
    public function index(){
        return view('auth.login');
    }

    public function store(Request $request){
        
     $cred = $request->username;
     $data = User::where('email',$cred)->orWhere('username',$cred)->first();
     if($data)
     {
         if(!Hash::check($request->password, $data->password))
            {
                return back()->with('error','Password anda salah');
            }else
            {
                $user = User::find($data->id);
                Auth::login($user);
                return redirect('home');
            }
     }else{
        return back()->with('error','email atau username anda tidak ditemukan');
     }
    }
}
