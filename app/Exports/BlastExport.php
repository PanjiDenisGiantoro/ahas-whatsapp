<?php

namespace App\Exports;

use App\Models\Blast;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BlastExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements  FromCollection,WithCustomValueBinder,WithColumnWidths,WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $tag;

    public function __construct($tag)
    {
        $this->tag = $tag;
    }
    public function collection()
    {
//        ddd($this->tag);

       return
           Blast::leftJoin('contacts','contacts.id','=','blasts.id_contact')
               ->leftJoin('campaigns','campaigns.id','=','blasts.campaign_id')
//            ->whereUserId(Auth::id())
               ->where('blasts.user_id',Auth::id())
               ->where('campaign_id',$this->tag)
               ->select('campaigns.name','contacts.jenis_kpb','contacts.name','blasts.receiver','blasts.status','contacts.no_mesin','contacts.deskripsi','contacts.tanggal_expired','contacts.KM')->get();
//       ddd($dd);
//        return Contact::whereUserId(Auth::user()->id)->whereTagId($this->tag)->get(['name','number','jenis_data','jenis_kpb','nama_ahas','no_ahas','sub_area','bulan','tanggal_expired']);
    }
    public function headings(): array
    {
        return [
            'Nama Customer',
            'Jenis KPB',
            'Receiver',
            'Status',
            'Nomor Mesin',
            'Deskripsi',
            'Tanggal Expired',
            'KM',
        ];
    }
    public function columnWidths(): array
    {

        return [
            'A' => 20,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
        ];
    }
}
