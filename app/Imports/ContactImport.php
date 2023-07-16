<?php

namespace App\Imports;

use App\Models\Contact;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ContactImport implements ToCollection , WithStartRow
{
    /**
    * @param Collection $collection
    */
        protected $tag;
    public function __construct($tag)
    {
        $this->tag = $tag;
    }
    public function startRow(): int
    {
        return 2;
    }
    public function collection(Collection $collection)
    {
   
        foreach($collection as $row){

/*backup data no mesin 26-12-22*/
/*
            $conta = Contact::where('name',$row[0])->where('number',$row[1])->where('tag_id',$this->tag)->count();
            if($conta == 0){
                Contact::create([
                    'user_id' => Auth::user()->id,
                    'tag_id' => $this->tag,
                    'name' => $row[0],
                    'number' => $row[1],
                    'nama_ahas' => $row[4],
                    'sub_area' => $row[6],
                    'bulan' => $row[7],
                    'jenis_kpb' => $row[3],
                    'jenis_data' => $row[2],
                    'no_ahas' => $row[5],
                    'tanggal_expired' => $row[8],
                    'deskripsi' => $row[9],
                    'tanggal_lahir' => $row[10],
                    'no_mesin' => $row[10],
                ]);
            }else{
                Contact::where('name',$row[0])->where('number',$row[1])->where('tag_id',$this->tag)->update([
                    'user_id' => Auth::user()->id,
                    'tag_id' => $this->tag,
                    'name' => $row[0],
                    'number' => $row[1],
                    'nama_ahas' => $row[4],
                    'sub_area' => $row[6],
                    'bulan' => $row[7],
                    'jenis_kpb' => $row[3],
                    'jenis_data' => $row[2],
                    'no_ahas' => $row[5],
                    'tanggal_expired' => $row[8],
                    'deskripsi' => $row[9],
                    'tanggal_lahir' => $row[10],
                    'no_mesin' => $row[11],
                ]);
            }*/

            $numbleng = strlen($row[1]);
            if ($numbleng > 10){
                Contact::updateOrCreate([
                    'user_id' => Auth::user()->id,
                    'tag_id' => $this->tag,
                    'name' => $row[0],
                    'number' => $row[1],
                    'nama_ahas' => $row[4],
                    'sub_area' => $row[6],
                    'bulan' => $row[7],
                    'jenis_kpb' => $row[3],
                    'jenis_data' => $row[2],
                    'no_ahas' => $row[5],
                    'tanggal_expired' => $row[8],
                    'deskripsi' => $row[9],
                    'tanggal_lahir' => $row[10],
                    'no_mesin' => $row[11],
                    'KM' => $row[12],
//                    'status_valid' => 'true'
                ]);


            }


        }
      
    }
}
