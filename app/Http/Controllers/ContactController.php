<?php

namespace App\Http\Controllers;

use App\Exports\ContactsExport;
use App\Imports\ContactImport;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
{

    public function index($tag){



        $contacts = Contact::whereUserId(Auth::user()->id)->whereTagId($tag)->get();

        $tagData = Tag::with('contacts')->get()->find($tag);
        return view('pages.contact',[
            'contacts' => $contacts,
            'tag' => $tagData,
            'id' => $tag
        ]);
    }

    public function store(Request $request){

        // $request->validate([
        //     'number' => ['unique:contacts']
        // ]);
        $cek = Contact::where('tag_id',$request->tag)->where('number',$request->number)->where('name',$request->name)->first();
        if($cek)
        {
            return back()->with('alert',[
                'type' => 'danger',
                'msg' => 'Contact telah ada pada daftar '.$cek->name.' !'
            ]);
        }
        Contact::create([
            'user_id' => Auth::user()->id,
            'tag_id' => $request->tag,
            'name' => $request->name,
            'number' => $request->number,
            'nama_ahas' => $request->nama_ahas,
            'sub_area' => $request->sub_area,
            'bulan' => $request->bulan,
            'jenis_kpb' => $request->jenis_kpb,
            'jenis_data' => $request->jenis_data,
            'no_ahas' => $request->no_ahas,
            'tanggal_expired' => $request->tanggal_expired,
            'tanggal_lahir' => $request->tanggal_lahir,
            'deskripsi' => $request->deskripsi,
            'no_mesin' => $request->no_mesin,
            'KM' => $request->KM
        ]);

        return back()->with('alert',[
            'type' => 'success',
            'msg' => 'Contact added!'
        ]);


    }


    public function import(Request $request){
        try {
            Excel::import(new ContactImport($request->tag),$request->file('fileContacts')->store('temp'));
            return back()->with('alert',[
                'type' => 'success',
                'msg' => 'Success Import'
            ]);
        } catch (\Throwable $th) {
            return back()->with('alert',[
                'type' => 'danger',
                'msg' => 'Something Erorr'

            ]);
        }



    }
    public function export(Request $request){

        return  Excel::download(new ContactsExport($request->tag),'contacts.xlsx');
    }

    public function destroyAll(Request $request){

        Contact::whereTagId($request->tag)->delete();
        return back()->with('alert',[
            'type' => 'success',
            'msg' => 'All contacts are deleted.'
        ]);
    }

    public function destroy($id){
        Contact::find($id)->delete();
        return back()->with('alert',[
            'type' => 'success',
            'msg' => 'Contact '.$id. ' deleted.'
        ]);
    }

    public function update(Request $request,$id){
        Contact::find($id)->update([
            'name'=>$request->name,
            'number'=>$request->number
        ]);
        return back()->with('alert',[
            'type' => 'success',
            'msg' => 'Contact berhasil di update.'
        ]);
    }
}
