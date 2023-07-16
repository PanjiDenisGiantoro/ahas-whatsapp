<?php



namespace App\Http\Controllers;



use App\Models\Number;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Contracts\Session\Session;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Auth;

use Session as ses;

use Carbon\Carbon;



class HomeController extends Controller

{





    public function index(Request $request){

        $users = DB::table('users')->leftJoin('regencies','regencies.id','=','users.kota')

            ->leftJoin('blasts','blasts.user_id','=','users.id')

            ->selectRaw('count(blasts.id) as total_blast,regencies.name')

            ->groupBy('regencies.name')

            ->where('users.id','!=',2)

            ->get();



        $range = DB::table('users')->leftJoin('regencies','regencies.id','=','users.kota')

            ->leftJoin('blasts','blasts.user_id','=','users.id')

            ->selectRaw('count(blasts.id) as total_blast,regencies.name')

            ->groupBy('regencies.name')

            ->where('users.id','!=',2)

            ->orderBy('total_blast','DESC')

            ->limit(5)

            ->get();

        if (Auth::user()->level == 'admin') {

            $motor_type = DB::table('contacts')
                // ->where('user_id',Auth::id())
                ->where('deskripsi', '!=', null)
                ->select('deskripsi', DB::raw('count(*) as total'))
                ->groupBy('deskripsi')
                ->limit(5)
                ->get();

            $user_blasts = DB::table('blasts')
                ->leftJoin('users', 'users.id', '=', 'blasts.user_id')
                // ->whereDate('created_at', Carbon::today())
                ->select('nama_ahas','sender', DB::raw('count(*) as total'))
                ->groupBy('sender','nama_ahas')
                ->limit(5)
                ->orderBy('total', 'DESC')
                ->get();

            $jenis_data = DB::table('contacts')
                // ->leftJoin('users', 'users.id', '=', 'contacts.user_id')
                ->where('jenis_data', '!=', null)
                ->select('jenis_data', DB::raw('count(*) as total'))
                ->groupBy('jenis_data')
                ->limit(5)
                ->get();

            $nama_ahas = DB::table('contacts')
                // ->leftJoin('users', 'users.id', '=', 'contacts.user_id')
                ->where('nama_ahas', '!=', null)
                ->select('nama_ahas', DB::raw('count(*) as total'))
                ->groupBy('nama_ahas')
                ->limit(5)
                ->get();

        } else {

            $motor_type = DB::table('contacts')
                ->where('user_id', Auth::id())
                ->where('deskripsi', '!=', null)
                ->select('deskripsi', DB::raw('count(*) as total'))
                ->groupBy('deskripsi')
                ->limit(5)
                ->get();

            $user_blasts = DB::table('blasts')
                ->where('user_id', Auth::id())
                // ->whereDate('created_at', Carbon::today())
                ->select('sender', DB::raw('count(*) as total'))
                ->groupBy('sender')
                ->limit(5)
                ->get();

            $jenis_data = DB::table('contacts')
                ->where('user_id', Auth::id())
                ->where('jenis_data', '!=', null)
                ->select('jenis_data', DB::raw('count(*) as total'))
                ->groupBy('jenis_data')
                ->limit(5)
                ->get();

            $nama_ahas = DB::table('contacts')
                ->where('user_id', Auth::id())
                ->where('nama_ahas', '!=', null)
                ->select('nama_ahas', DB::raw('count(*) as total'))
                ->groupBy('nama_ahas')
                ->limit(5)
                ->get();

        }

        $numbers = Number::whereStatus('Connected')->get();

        return view('home',[

            'numbers' => $request->user()->numbers()->latest()->paginate(15),


            'limit_device' => $request->user()->limit_device,

            'users' => $users,

            'range' => $range,

            'motor_type'    => $motor_type,

            'user_blasts'=> $user_blasts,

            'jenis_data'  => $jenis_data,

            'nama_ahas' => $nama_ahas
        ]);

    }



    public function store(Request $request){

        $limit_device = Auth::user()->limit_device;

        $deviceadded = $request->user()->numbers()->count();

        if($limit_device <= $deviceadded){

            return redirect()->back()->with('alert',['type' => 'danger','msg' => 'You have reached your limit of devices']);

        }

        $request->validate([

            'sender' => ['required','min:10','unique:numbers,body']

        ]);

        Number::create([

            'user_id' => Auth::user()->id,

            'body' => $request->sender,

            'webhook' => $request->urlwebhook,

            'status' => 'Disconnect',

            'messages_sent' => 0

        ]);



        return back()->with('alert',[

            'type' => 'success',

            'msg' => 'Devices Added!'

        ]);

    }

    public function destroy(Request $request){

        Number::find($request->deviceId)->delete();

        ses::forget('selectedDevice');

        return back()->with('alert',[

            'type' => 'success',

            'msg' => 'Devices Deleted!'

        ]);

    }





    public function setHook(Request $request){

        $n = Number::whereBody($request->number)->first();

        $n->webhook = $request->webhook;

        $n->save();

        return true;

    }



    public function setSelectedDeviceSession(Request $request){

        session()->put('selectedDevice', $request->device);

        return true;

    }



    public function device(Request $request){



        $numbers = Number::whereStatus('Connected')->get();





        return view('device',[

            'numbers' => $request->user()->numbers()->latest()->paginate(15),



            'limit_device' => $request->user()->limit_device,

//            'users' => $users,

        ]);

    }













}

