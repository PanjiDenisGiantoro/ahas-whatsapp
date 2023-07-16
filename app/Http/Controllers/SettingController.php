<?php
namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use mysqli;
use Session;
class SettingController extends Controller
{
 
 public function __construct()
 {
// $this->middleware('admin')->except('activate_license','install','test_database_connection');

 }

 public function index(){
    return view('pages.admin.settings');
 }

 public function checkDb(Request $data)
{

 $error_message = null;
 try {
     $host = $data->host.':'.$data->port;
     $db = mysqli_connect($host,$data->username,$data->password,$data->database);

        if($db->connect_errno){
            $error_message = 'Koneksi Gagal .'. $db->connect_error;
        }
    } catch(\Throwable $th) 
    {
        $error_message = 'Koneksi Gagal Cek Server Database Anda Apakah Sudah Menyala?';
    }
    foreach ($data->all() as $key => $value) {
        Session::put($key,$value);
    }
    if($error_message != null)
    {
        return redirect()->back()->with('error',$error_message);
    }   
    return redirect()->back()->with('success','Koneksi berhasil');

}

public function checkNode(Request $request)
{
    foreach ($request->all() as $key => $value) {
        Session::put($key,$value);
    }
    if(fsockopen($request->url_node,$request->port_node))
    {
        return response()->json(['data'=>'Port '.$request->port_node.' Berhasil Terkonesi','color'=>'green']);
    }
    else
    {
        return response()->json(['data'=>'Port '.$request->port_node.' Gagal Terkonesi','color'=>'red']);
    }
}

 public function setServer(Request $request)
 {
    $urlnode = $request->url_node.':'.$request->port_node;
    $this->setEnv('TYPE_SERVER','other');
    $this->setEnv('PORT_NODE',$request->port_node);
    $this->setEnv('WA_URL_SERVER',$urlnode);
 }
 
 public function setEnv(string $key,string $value){
 
     $env = array_reduce(file(base_path('.env'), FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES), 
     function($carry, $item)
     {
         list($key, $val) = explode('=', $item, 2);
         $carry[$key] = $val;
         return $carry;
     }, []);
     $env[$key] = $value;
     foreach($env as $k => &$v)
     $v = "{$k}={$v}";
    file_put_contents(base_path('.env'),implode("\r\n",$env));
 }

 public function install(Request $request)
 {
    if(env('APP_INSTALLED')=== true){
     return redirect('/');

     }

     $mysql_user_version = ['distrib' => '', 'version' => null, 'compatible' => false];
     if(function_exists('exec') || function_exists('shell_exec'))
     {
         $mysqldump_v = function_exists('exec') ? exec('mysqldump --version') : shell_exec('mysqldump --version');
         if($mysqld = str_extract($mysqldump_v, '/Distrib(?P<destrib>.+),/i'))
         {
             $destrib = $mysqld['destrib'] ?? null;
             $mysqld = explode('-', mb_strtolower($destrib), 2);
             $mysql_user_version['distrib'] = $mysqld[1] ?? 'mysql';
             $mysql_user_version['version'] = $mysqld[0];
             if($mysql_user_version['distrib'] == 'mysql' && $mysql_user_version['version'] >= 5.6)
             {
                $mysql_user_version['compatible'] = true;
             }
             elseif($mysql_user_version['distrib'] == 'mariadb' && $mysql_user_version['version'] >= 10)
             {
                $mysql_user_version['compatible'] = true;

             }
         }
     }
 
     $requirements = [
             "php" => ["version" => 7.4, "current" => phpversion()],
             "mysql" => ["version" => 5.6, "current" => $mysql_user_version],
             "php_extensions" => [
             "curl" => false,
             "fileinfo" => false,
             "intl" => false,
             "json" => false,
             "mbstring" => false,
             "openssl" => false,
             "mysqli" => false,
             "zip" => false,
             "ctype" => false,
             "dom" => false,
             ],
     ];
     $php_loaded_extensions = get_loaded_extensions();
     foreach($requirements['php_extensions'] as $name => &$enabled)
     {
        $enabled = in_array($name, $php_loaded_extensions);
     }
     return view('install',[
         'requirements' => $requirements
         ]);
     }

     public function postInstall(Request $request)
     {
        foreach ($request->all() as $key => $value) {
            Session::put($key,$value);
        }
         /** CREATE DATABASE CONNECTION STARTS **/
            $db_params =[];
            $db_params['host'] =$request->host.':'.$request->port;
            $db_params['database'] =$request->name;
            $db_params['username'] =$request->username;
            $db_params['password'] =$request->password;
            
             // try {
             //     $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
             //     $db = DB::select($query, [$request->name]);
             // } catch (Exception $e) {
             //     \Schema::getConnection()->getDoctrineSchemaManager()->dropDatabase($request->name);
             // }
             
            $schemaName = $request->name;
            $charset = config("database.connections.mysql.charset",'utf8mb4');
            $collation = config("database.connections.mysql.collation",'utf8mb4_unicode_ci');

             try{
                Config::set("database.connections.mysql", array_merge(config('database.connections.mysql'), $db_params));
                config(["database.connections.mysql.database" => null]);
               // \Schema::getConnection()->getDoctrineSchemaManager()->dropDatabase($request->name);
                $query = "CREATE DATABASE IF NOT EXISTS $schemaName CHARACTER SET $charset COLLATE $collation;";
                DB::statement($query);
                config(["database.connections.mysql.database" => $schemaName]);
               
             }catch(\Exception $e){
               // return redirect()->back()->with('error', $e->getMessage());
                 return response()->json(['data'=>'Instalasi gagal mohon cek lagi konfigurasi anda '.$e->getMessage().' ','color'=>'red']);
             }
         /** CREATE DATABASE CONNECTION ENDS **/


         /** CREATE DATABASE TABLES STARTS **/
             try {
                     DB::purge('mysql');
                     Config::set("database.connections.mysql", array_merge(config('database.connections.mysql'), $db_params));
                     DB::connection()->getPdo();
                     DB::transaction(function() {
                     DB::unprepared(File::get(base_path('database/wanojs.sql')));
                });                
                
                }catch(\Exception $e){
                    return response()->json(['data'=>'Instalasi gagal mohon cek lagi konfigurasi anda gg'.$e->getMessage().' ','color'=>'red']);
             }
         
         /** CREATE DATABASE TABLES ENDS **/
         /** SETTING .ENV VARS STARTS **/
        $this->setServer($request); // node server
        $env = array_reduce(file(base_path('.env'), FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES), 
        function($carry, $item)
        {
            list($key, $val) = explode('=', $item, 2);
            $carry[$key] = $val;
            return $carry;

         }, []);

         if(isset($_SERVER['REQUEST_SCHEME']))
         {
            $urll = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}";
         } else {
            $urll = $_SERVER['HTTP_HOST'];
         }
        $env['DB_HOST'] = $db_params['host'];
        $env['DB_DATABASE'] = $db_params['database'];
        $env['DB_USERNAME'] = $db_params['username'];
        $env['DB_PASSWORD'] = $db_params['password'];
        $env['APP_URL'] = $urll;
        $env['APP_INSTALLED'] = 'true';

        foreach($env as $k => &$v)
        {
            $v = "{$k}={$v}";
            file_put_contents(base_path('.env'), implode("\r\n", $env));
        }

        /** SETTING .ENV VARS ENDS **/
         /** CREATE ADMIN USER STARTS **/
         if(!$user = User::where('email',$request->email_admin)->first())
         {
             $user = new User;
             $user->username = $request->username_admin;
             $user->email = $request->email_admin;
             $user->password = Hash::make($request->password_admin);
             $user->email_verified_at = date('Y-m-d');
             $user->level = 'admin';
             $user->active_subscription = 'lifetime';
             $user->save();
         }
         /** CREATE ADMIN USER END **/
             Auth::loginUsingId($user->id,true);
             //return redirect('home');
             return response()->json(['data'=>'Instalasi Berhasil Anda Akan Diarahkan Ke Halaman Admin','color'=>'green']);
     }
}