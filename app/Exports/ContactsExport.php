<?php

namespace App\Exports;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactsExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements  FromCollection,WithCustomValueBinder,WithColumnWidths,WithHeadings
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
        return Contact::whereUserId(Auth::user()->id)->whereTagId($this->tag)->get(['name','number','jenis_data','jenis_kpb','nama_ahas','no_ahas','sub_area','bulan','tanggal_expired','deskripsi','tanggal_lahir','no_mesin','KM','status_valid']);
    }
    public function headings(): array
    {
        return [
            'Nama',
            'No Hp',
            'Jenis Data',
            'Jenis KPB',
            'Nama AHAS',
            'No AHAS',
            'Sub Area',
            'Bulan',
            'Tanggal Expired',
            'Deskripsi',
            'Tanggal Lahir',
            'No Mesin',
            'KM',
            'Status'
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
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 20,
            'M' => 20,
            'N' => 20,
        ];
    }
}
