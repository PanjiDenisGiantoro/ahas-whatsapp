<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;
class FileManagerController extends Controller
{
    //

    public function index(Request $request){
        //return $_SERVER['REQUEST_URI'];
        if(count($request->all()) > 0)
        {
            if($request->namefile != null)
            {   
                $files = DB::table('system_storages')
                ->where('name', 'like', '%' . $request->namefile. '%')
                ->where('user_id',Auth::user()->id)
                ->orderBy('created_at','DESC')
                ->get();
            }elseif ($request->diupload != null) {
                $files = DB::table('system_storages')
                ->where('date',$request->diupload)
                ->where('user_id',Auth::user()->id)
                ->orderBy('created_at','DESC')
                ->get();
            }else{
                if($request->diupload != null && $request->namefile != null)
                {
                    $files = DB::table('system_storages')
                    ->where('date',$request->diupload)
                    ->where('name', 'like', '%' . $request->namefile. '%')
                    ->where('user_id',Auth::user()->id)
                    ->orderBy('created_at','DESC')
                    ->get();
                }else{
                    $files = DB::table('system_storages')
                    ->where('user_id',Auth::user()->id)
                    ->orderBy('created_at','DESC')
                    ->limit(4)
                    ->get();
                }
            }
            
        }else{
            $files = DB::table('system_storages')
            ->where('user_id',Auth::user()->id)
            ->orderBy('created_at','DESC')
            ->limit(4)
            ->get();
        }; 
        return view('pages.file-manager',compact('files','request'));
    }

    public function uploadFileMultiple($file,$oke)
    {
            $result ='';
           // $file = $request->file($oke);
            if($file != null){
                $name = $file->getClientOriginalName();
                $extension = explode('.',$name);
                $extensionGet = strtolower(end($extension));
                $nameOnly = implode('', $extension);
                $nameStr = str_replace($extensionGet, '', $nameOnly);
                $nameStr1 = str_replace(' ', '', $nameStr);
                $key = strtotime(Carbon::now('Asia/Jakarta')).'-'.$oke.'-'.Auth::user()->id.'-'.Auth::user()->username.'-'.$nameStr1;
                $tmp_file_name = "{$key}.{$extensionGet}";
                $tmp_file_path = "new/assets/".$oke."/";
                $file->move($tmp_file_path,$tmp_file_name);
                $result = $tmp_file_name;
            }
        return $result;
    }

    public function store(Request $request)
    {
        $file = $request->file('file');
        $confPostSize = intval(ini_get('post_max_size')) * 1000; 
        $confMaxSize = intval(ini_get('upload_max_filesize')) * 1000; 
        $confMaxUpFile = intval(ini_get('max_file_uploads')); 
        $banyakFile =  count($request->file('file'));
        if($banyakFile > $confMaxUpFile)
        {
            return redirect()->back()->with('error','Upload file gagal jumlah file yang anda upload total nya lebih besar dari configurasi max_file_uploads di php.ini anda ('.$confMaxUpFile.') file sedangkan jumlah file yg ada upload ('.$banyakFile.') File , Ubah terlebih dahulu konfigurasi php.ini lalu lakukan restart server dan upload file kembali');
        }
        $arrSize = [];
        foreach ($file as $key => $value) {
            $sizeFirst = $value->getSize();
            $realSize = round($sizeFirst / 1000);
            $mbOrKb = '';
            if($realSize > 10000)
            {
                $okeSize = floor($realSize / 1000);
                $mbOrKb = 'MB';
            }else{
                $okeSize = $realSize - 1;
                $mbOrKb = 'KB';
            }
            $name = $value->getClientOriginalName();
            if($realSize > $confPostSize)
            {
               $realPostSize = round($confPostSize / 1000);
               return redirect()->back()->with('error','Upload file gagal file anda '.$name.' Ukurannya lebih besar dari configurasi post_max_size di php.ini anda ('.$realPostSize.' MB) sedangkan file anda berukuran ('.$okeSize.') MB , Ubah terlebih dahulu konfigurasi php.ini lalu lakukan restart server dan upload file kembali');
            }
            if($realSize > $confMaxSize)
            {
               $realMaxSize = round($confMaxSize / 1000);
               return redirect()->back()->with('error','Upload file gagal file anda '.$name.' Ukurannya lebih besar dari configurasi post_max_size di php.ini anda ('.$realMaxSize.' MB) sedangkan file anda berukuran ('.$okeSize.') MB Ubah terlebih dahulu konfigurasi php.ini lalu lakukan restart server dan upload file kembali');
            }
            $arrSize[$key] = $okeSize.' '.$mbOrKb;
        }
        //return $arrSize;
        $banyak = 0;
        foreach ($file as $i => $v) {
            $nameSaved = $this->uploadFileMultiple($v,'berkas');
            $format = $v->getClientMimeType();
            $name = $v->getClientOriginalName();
            DB::table('system_storages')->insert([
                'user_id'=>Auth::user()->id,
                'name_saved'=>$nameSaved,
                'name'=>$name,
                'size'=>$arrSize[$i],
                'format'=>$format,
                'date'=>Carbon::now('Asia/Jakarta')->format('Y-m-d'),
                'created_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString(),
                'updated_at'=>Carbon::now('Asia/Jakarta')->toDateTimeString()
            ]);
            $banyak++;
        }
        return redirect()->back()->with('success','Berhasil mengupload '.$banyak.' file!');
    }

    public function deleteFile($id)
    {
        $data = DB::table('system_storages')->where('id',$id)->first();
        $name = '';
        if($data)
        {
            $name = $data->name_saved;
            unlink('new/assets/berkas/'.$name);
            DB::table('system_storages')->where('id',$id)->delete();
        }
        return redirect()->back()->with('success','Berhasil menghapus file '.$name.'!');
    }

    public function loadMore(Request $request)
    {
        $not = $request->arr;
        $files = DB::table('system_storages')
                    ->whereNotIn('id',$not)
                    ->orderBy('created_at','DESC')
                    ->limit(4)
                    ->get();
        $html = '';
        $arrHtml = '';
        $banyak = 0;
        foreach ($files as $key => $file) {
             $ext = $file->format;
             $spl = explode('/',$ext);
             array_push($not,$file->id);
             $icon = '';
             switch ($spl[0]) {
                 case 'image':
                     $icon = '<img src="'.url('new/assets/berkas/'.$file->name_saved).'" style="width: 100%;">';
                     break;
                case 'application':
                     $icon = '<i class="fa fa-file-text-o"></i>';
                     break;
                 default:
                     $icon = '<i class="fa fa-file"></i>';
                     break;
             }
            $html .= '<div class="col-6 col-md-4 col-xl-3 col-xxl-2">
                        <div class="app-card app-card-doc shadow-sm h-100">
                            <div class="app-card-thumb-holder p-3">
                                <span class="icon-holder">
                                    '.$icon.'
                                </span>
                                 <a class="app-card-link-mask" href="#file-link"></a>
                            </div>
                            <div class="app-card-body p-3 has-card-actions">
                                
                                <h4 class="app-doc-title truncate mb-0">
                                    <a href="#file-link" title="'.$file->name.'">'.$file->name.'</a>
                                </h4>
                                <div class="app-doc-meta">
                                    <ul class="list-unstyled mb-0">
                                        <li><span class="text-muted">Tipe:</span> '.$file->format.'</li>
                                        <li><span class="text-muted">Ukuran:</span> '.$file->size.'</li>
                                        <li><span class="text-muted">Diupload :</span> 
                                            '.Carbon::parse($file->date)->format('d F Y').' '.Carbon::parse($file->created_at)->format('H:i:s').'
                                        </li>
                                    </ul>
                                </div><!--//app-doc-meta-->
                                
                                <div class="app-card-actions">
                                     <div class="dropdown">
                                        <div class="dropdown-toggle no-toggle-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                            </svg>
                                        </div>
                                        <!--//dropdown-toggle-->
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" download href="'.url('new/assets/berkas/'.$file->name_saved).'">
                                                        <i class="fa fa-download"></i> Download
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item" href="'.url('file-manager-delete/'.$file->id).'"
                                                        onclick="return confirm("Yakin untuk mengahapus file?, aksi ini tidak bisa di batalkan ketika di klik OK")">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a>
                                                </li>
                                        </ul>
                                    </div><!--//dropdown-->
                                </div><!--//app-card-actions-->
                            </div><!--//app-card-body-->
                        </div><!--//app-card-->
                    </div><!--//col-->';
                    $banyak++;
        }
        foreach ($not as $i => $v) {
            $arrHtml .= '<input type="hidden" name="arr[]" value="'.$v.'">';
        }
        return response()->json(['html'=>$html,'arr'=>$arrHtml,'banyak'=>$banyak]);
    }
}
