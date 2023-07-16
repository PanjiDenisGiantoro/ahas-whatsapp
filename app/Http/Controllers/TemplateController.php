<?php



namespace App\Http\Controllers;



use App\Models\TemplateMessage;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;



class TemplateController extends Controller

{

    public function index()

    {

        $data = DB::table('template_messages')->where('user_id',Auth::user()->id)->get();

        return view('newcomponent.templateMessage', compact('data'));

    }



    public function getTemplate()

    {

        $datas = TemplateMessage::all();

        return DataTables::of($datas)

            ->editColumn('action', function ($data) {

                $editAksesoris = '

                <div class="text-center">

                    <a href="#" data-bs-toggle="modal" data-bs-target="#editModal"

                        data-bs-id="'.$data->id.'"

                        data-bs-name="'.$data->templateName.'"

                        data-bs-type="'.$data->templateType.'"

                        data-bs-message="'.$data->templateMessage.'">

                        <i class="material-icons-outlined">edit_note</i>

                    </a>

                </div>

                ';

                return $editAksesoris;

            })

            ->rawColumns(['action'])

            ->make(true);

    }



    public function saveTemplate(Request $request)

    {

        $form_data = array(

            'templateName' => $request->templateName,

            'templateType' => $request->templateType,

            'templateMessage' => $request->templateMessage,

            'templateGoodBye' => $request->templateGoodbye,

            'user_id' => Auth::user()->id

        );



        TemplateMessage::create($form_data);



        return back();

    }



    public function editTemplate(Request $request)

    {

        $form_data = array(

            'templateName' => $request->templateName,

            'templateType' => $request->templateType,

            'templateMessage' => $request->templateMessage,

            'templateGoodBye' => $request->templateGoodbye,



            'user_id' => Auth::user()->id



        );



        TemplateMessage::where('id', $request->id)->update($form_data);



        return back();

    }

    public function fetchtemplate(Request $request)

    {

        $id = $request->id;

        $data = TemplateMessage::find($id);

        return response()->json($data);

    }

    public function destroy(Request $request) {

        DB::table('template_messages')->where('id', $request->id)->delete();

        return back()->with('alert', [

            'type' => 'success',

            'msg' => 'Success delete Template Pesan!'

        ]);
    }
}

