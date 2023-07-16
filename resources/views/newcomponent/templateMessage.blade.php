<x-layout-dashboard title="Template Pesan">



    <div class="app-content" style="">

        {{-- <link href="{{asset('plugins/datatables/datatables.min.css')}}" rel="stylesheet"> --}}

        {{-- <link href="{{asset('plugins/select2/css/select2.css')}}" rel="stylesheet"> --}}

        <link href="{{asset('css/custom.css')}}" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.css"/>

        <div class="content-wrapper">

            <div class="container">

                @if (session()->has('alert'))

                    <x-alert>

                        @slot('type',session('alert')['type'])

                        @slot('msg',session('alert')['msg'])

                    </x-alert>

                @endif

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <ul>

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif





                <div class="row">

                    <div class="col">

                        <div class="card">

                            <div class="card-body rounded-lg">

                                <h3 class="mb-3">Template Pesan</h3>

                                <button type="button" class="btn btn-primary btn-xs mb-4" data-bs-toggle="modal" data-bs-target="#addAutoRespond"><i class="material-icons-outlined">add</i> Tambah</button>

                                <div class="table-responsive" >

                                    <table class="table table-bordered table-striped  table-hover" id="dataCari" style="border-radius: 20px">

                                        <thead class="bg-primary " >

                                        <tr style="color: whitesmoke">

                                            <th style="color: whitesmoke">No</th>

                                            <th style="color: whitesmoke">Nama Template</th>

                                            <th style="color: whitesmoke">Tipe</th>

                                            <th style="color: whitesmoke">Pesan</th>

                                            {{-- <th>Pesan Goodbye</th> --}}

                                            <th class="text-center" style="color: whitesmoke">Aksi</th>

                                        </tr>

                                        </thead>

                                        <tbody>

                                        @php

                                            $no=1;

                                            $template = \Illuminate\Support\Facades\DB::table('template_messages')->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->orderBy('id', 'desc')->get();

                                            //$template = \App\Models\TemplateMessage::all();

                                        @endphp

                                        @foreach($template as $tem)

                                            <tr>



                                                <td>

                                                    {{$no++}}

                                                </td>

                                                <td>

                                                    {{$tem->templateName}}

                                                </td>

                                                <td>

                                                    {{$tem->templateType}}

                                                </td>

                                                <td>

                                                    {{$tem->templateMessage}}

                                                </td>

                                                {{-- <td>

                                                    {{$tem->templateGoodBye ?? '-'}}

                                                </td> --}}

                                                <td>
                                                    <div class="d-flex justify-content-center">
{{--                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#editModal"--}}

{{--                                                           data-bs-id={{$tem->id}}--}}

{{--                                                           data-bs-name={{$tem->templateName}}--}}

{{--                                                           data-bs-type={{$tem->templateType}}--}}

{{--                                                           data-bs-message={{$tem->templateMessage}}>--}}

{{--                                                            <i class="material-icons-outlined">edit_note</i>--}}

{{--                                                        </a>--}}

{{--                                                        button modal --}}

                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$tem->id}}" data-bs-id={{$tem->id}} data-bs-name={{$tem->templateName}} data-bs-type={{$tem->templateType}} data-bs-message={{$tem->templateMessage}}><i class="material-icons-outlined">edit_note</i> Edit</button>

                                                        <form action="{{route('t.d')}}" method="POST">
                                                            @method('delete')

                                                            @csrf

                                                            <input type="hidden" name="id" value="{{$tem->id}}">

                                                            <button type="submit" name="delete"  onclick="return confirm('yakin mau menghapus?')" class="btn btn-danger btn-sm"><i class="material-icons">delete_outline</i>Delete</button>

                                                        </form>
                                                    </div>

                                                </td>

                                            </tr>

                                            <div class="modal fade" id="editModal{{$tem->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                                <div class="modal-dialog modal-lg">

                                                    <div class="modal-content">

                                                        <div class="modal-header">

                                                            <h5 class="modal-title" id="exampleModalLabel">Perbarui Template Pesan</h5>

                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                                        </div>

                                                        <form action="{{ route('t.u') }}" method="POST" enctype="multipart/form-data">

                                                            @csrf

                                                            @method('PUT')

                                                            <div class="modal-body">

                                                                <div hidden class="form-group mb-3">

                                                                    <label for="id">ID</label>

                                                                    <input type="text" class="form-control" id="id" name="id" placeholder="Nama Template" value="{{$tem->id}}">

                                                                </div>

                                                                <div class="form-group mb-3">

                                                                    <label for="templatename">Nama Template</label>

                                                                    <input type="text" class="form-control" id="templatename" name="templateName" placeholder="Nama Template" value="{{$tem->templateName}}">

                                                                </div>

                                                                <div class="form-group mb-3">

                                                                    <label for="templateType">Tipe Template</label>

                                                                    <select name="templateType" id="templateType" class="form-control" required>

                                                                        <option value="">Pilih Template</option>

{{--                                                                        <option value="Ulang Tahun"--}}

{{--                                                                        @if($tem->templateType == 'Ulang Tahun')--}}

{{--                                                                        selected--}}

{{--                                                                        @endif--}}

{{--                                                                        > Ulang Tahun</option>--}}

                                                                        <option value="Greeting"

                                                                                @if($tem->templateType == 'Greeting')

                                                                                    selected

                                                                                @endif

                                                                        >Template Greeting </option>



                                                                        <option value="Promo"

                                                                                @if($tem->templateType == 'Promo')

                                                                                    selected

                                                                                @endif

                                                                        >Template Promo</option>

                                                                        <option value="Sudah Servis"

                                                                                @if($tem->templateType == 'Sudah Servis')

                                                                                    selected

                                                                                @endif

                                                                        >Template Sudah Servis </option>

                                                                    </select>

                                                                </div>

                                                                <div class="form-group">

                                                                    <label for="templateMessage">Isi Pesan</label>

                                                                    <textarea class="form-control" id="templatemessage" name="templateMessage" rows="3">{{$tem->templateMessage}}"</textarea>

                                                                </div>

                                                                @if($tem->templateType == 'Greeting')
                                                                <div class="form-group">

                                                                    <label for="templateMessage">Pesan GoodBye</label>

                                                                    <textarea class="form-control" id="templateGoodbye" name="templateGoodbye" rows="3">{{$tem->templateGoodBye}}</textarea>

                                                                </div>
                                                                @endif

                                                            </div>

                                                            <div class="modal-footer">

                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                                <button type="submit" name="submit" class="btn btn-primary">Perbarui</button>

                                                            </div>

                                                        </form>

                                                    </div>

                                                </div>

                                            </div>



                                        @endforeach

                                        </tbody>

                                    </table>

                                </div>



                            </div>

                        </div>

                    </div>



                </div>



            </div>

        </div>

    </div>



    <div class="modal fade" id="addAutoRespond" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" style="width: 100%">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">Tambah Template Pesan</h5>


                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <form action="{{ route('t.s') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="modal-body">

                        <div class="form-group mb-3">

                            <label for="templateName">PANDUAN PENGAMBILAN TAG KONTAK </label>
                            <table class="table table-bordered table-responsive">
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <td>
                                        {name}
                                    </td>
                                    <th>
                                        Nama Ahas
                                    </th>
                                    <td>
                                        {nama_ahas}
                                    </td>
                                    <th>
                                        tanggal_expired
                                    </th>
                                    <td>
                                        {tanggal_expired}
                                    </td>

                                </tr>
                                <tr>
                                    <th>
                                        jenis_kpb
                                    </th>
                                    <td>
                                        {jenis_kpb}
                                    </td>
                                    <th>
                                        deskripsi
                                    </th>
                                    <td>
                                        {deskripsi}
                                    </td>
                                    <th>
                                        sub_area
                                    </th>
                                    <td>
                                        {sub_area}
                                    </td>

                                </tr>
                                <tr>
                                    <th>
                                        KM
                                    </th>
                                    <td>
                                        {KM}
                                    </td>
                                    <th>
                                        jenis_data
                                    </th>
                                    <td>
                                        {jenis_data}
                                    </td>
                                    <th>
                                        no_ahas
                                    </th>
                                    <td>
                                        {no_ahas}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        tanggal_lahir
                                    </th>
                                    <td>
                                        {tanggal_lahir}
                                    </td>
                                    <th>
                                        no_mesin
                                    </th>
                                    <td>
                                        {no_mesin}
                                    </td>
                                    <th>
                                        bulan
                                    </th>
                                    <td>
                                        {bulan}
                                    </td>
                                </tr>


                                </tr>
                            </table>

                        </div>

                        <div class="form-group mb-3">

                            <label for="templateName">Nama Template</label>

                            <input type="text" class="form-control" id="templateName" name="templateName" placeholder="Nama Template">

                        </div>

                        <div class="form-group mb-3">

                            <label for="templateType">Tipe Template</label>

                            <select name="templateType" id="templateTypes" class="form-control" required>

                                <option value="">Pilih Template</option>

{{--                                <option value="Ulang Tahun"> Ulang Tahun</option>--}}

                                <option value="Promo">Template Promo</option>

                                <option value="Sudah Servis">Template Sudah Servis </option>

                                <option value="Greeting">Template Greeting </option>

                            </select>

                        </div>

                        <div class="form-group">

                            <label for="templateMessage" id="pesantemplate">Isi Pesan</label>

                            <textarea class="form-control" id="templateMessage" name="templateMessage" rows="3"></textarea>

                        </div>

                        <div class="form-group" id="goodbye" style="display: none">

                            <label for="templateMessage">Template Goodbye</label>

                            <textarea class="form-control" id="templateGoodbye" name="templateGoodbye" rows="3"></textarea>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <button type="submit" name="submit" class="btn btn-primary">Tambah</button>

                    </div>

                </form>

            </div>

        </div>

    </div>









    {{-- <script src="{{asset('js/pages/datatables.js')}}"></script> --}}

    {{-- <script src="{{asset('js/pages/select2.js')}}"></script> --}}



    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.js"></script>



    {{-- <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script> --}}

    <script src="{{asset('js/autoreply.js')}}"></script>

    <script>

        $(document).ready(function () {

            $(function() {

                $('#dataCari').DataTable();

            });



            $('#templateTypes').on('change', function() {

                if ( this.value == 'Greeting')

                {

                    $("#goodbye").show();

                }

                else

                {

                    $("#goodbye").hide();

                }

            });

        // });



        // var exampleModal = document.getElementById('editModal')

        // exampleModal.addEventListener('show.bs.modal',   function (event) {

        //     var button = event.relatedTarget

        //     var id = button.getAttribute('data-bs-id')

        //     var templatename = button.getAttribute('data-bs-name')

        //     var templatemessage = button.getAttribute('data-bs-message')

        //     var templatetype = button.getAttribute('data-bs-type')

        //

        //     var inputid = exampleModal.querySelector('.modal-body #id')

        //     var inputname = exampleModal.querySelector('.modal-body #templatename')

        //     var inputmessage = exampleModal.querySelector('.modal-body #templatemessage')

        //     // var inputtype = exampleModal.querySelector('.modal-body #templateType') history input type

        //     //selected option value in select tag in modal body with id templateType in editModal modal body with id editModal

        //     var selected = exampleModal.querySelector('.modal-body #templateType option[value="'+templatetype+'"]')

        //



            // inputid.value = id

            // inputname.value = templatename

            // inputmessage.value = templatemessage

            // selected.setAttribute('selected', 'selected')



        })

    </script>



</x-layout-dashboard>
