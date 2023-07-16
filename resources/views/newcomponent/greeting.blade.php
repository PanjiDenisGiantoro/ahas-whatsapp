
<x-layout-dashboard title="Contacts">
    <div class="app-content">
        <link href="{{asset('plugins/datatables/datatables.min.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/select2/css/select2.css')}}" rel="stylesheet">
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


                <div class="card-header d-flex justify-content-between">

                    {{--                      <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#selectNomor"><i class="material-icons-outlined">contacts</i>Fetch From Groups WA</button>--}}
                    <div class="d-flex justify-content-right">

                        <button type="button" id="buttonadd" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#addTag"><i class="material-icons-outlined">add</i>Add</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title">Greeting</h5>
                            </div>
                            <div class="card-body">
                                <table id="datatablegreet" class="table table-striped table-bordered table-hover" style="width:100%;border-radius: 1em;">
                                    <thead class="bg-primary" >
                                    <tr style="color: whitesmoke">
                                        <th style="color: whitesmoke">Name</th>
                                        <th style="color: whitesmoke">Number</th>
                                        <th style="color: whitesmoke">No. Polisi</th>
                                        <!-- <th style="color: whitesmoke">Status</th> -->
                                        <th style="color: whitesmoke" class="d-flex justify-content-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($data as $dt)
                                        <tr>
                                            <td>{{$dt->name}}</td>
                                            <td>{{$dt->number}}</td>
                                            <td>{{$dt->jenis_motor}}</td>
                                            <!-- <td>
                                                <div class="d-flex justify-content-center">
                                                    @if($dt->status == 1)
                                                <button type="button" class="btn btn-outline-primary " data-bs-toggle="modal" data-bs-target="#editTemplate{{$dt->id}}">
                                                            Greeting
                                                        </button>
                                                    @else
                                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#editTemplate{{$dt->id}}">
                                                            Bye
                                                        </button>
                                                    @endif
                                            </div>
                                        </td> -->
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{route('bye',$dt->id)}}" class="btn btn-success mt-3 "><i class="material-icons-outlined">send</i>Bye</a>
                                                </div>
                                            </td>
                                        </tr>
                                        {{--                                        modal editTemplate{{$dt->id}}--}}

                                        <div class="modal fade" id="editTemplate{{$dt->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Pesan
                                                            @if($dt->status == 1)
                                                                Greeting
                                                            @elseif($dt->status == 2)
                                                                Bye
                                                            @else
                                                                -
                                                            @endif
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('t.u') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="templateMessage">Pesan Greeting</label>
                                                                <textarea class="form-control" id="templatemessage" name="templateMessage" readonly rows="3">{{$dt->templates->templateMessage ?? ''}}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="templateMessage">Pesan GoodBye</label>
                                                                <textarea class="form-control" id="templatemessage" name="templateMessage"readonly rows="3">{{$dt->templates->templateGoodBye ?? ''}}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach


                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- Modal select sender --}}
    <div class="modal fade" id="selectNomor" tabindex="-1" aria-labelledby="SelectNomorModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('fetch.groups')}}" method="POST" enctype="multipart/form-data">
                        @csrfπ
                        <label for="" class="form-label">Sender ?</label>
                        @if(Session::has('selectedDevice'))
                            <input type="text" name="sender" class="form-control" id="sender" value="{{Session::get('selectedDevice')}}" readonly>
                        @else
                            <input type="text" name="senderrr" value="Please Select Sender Firsst" class="form-control" id="sender" required>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Fetch</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addTag" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 100%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('g.sc')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">

                            <label for="templateName">PANDUAN PENGAMBILAN TAG KONTAK </label>
                            <table class="table table-bordered table-responsive">
                                <tr>
                                    <th>
                                        Nama
                                    </th>
                                    <td>
                                        {name}
                                    </td>
                                    <th>
                                        Number
                                    </th>
                                    <td>
                                        {number}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        No Polisi
                                    </th>
                                    <td>
                                        {nopol}
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="templateMessage">Sender</label>
                                <input type="text" class="form-control" id="sender" name="sender"  value="{{Session::get('selectedDevice')}}" readonly required>

                            </div>
                            <div class="col-md-6">
                                <label for="number" class="form-label">Number</label>
                                <input type="text" name="number" class="form-control" id="number" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name" required>

                            </div>
                            <div class="col-md-6">
                                <label for="jenis_motor" class="form-label">No. Polisi</label>
                                <input type="text" name="jenis_motor" class="form-control" id="jenis_motor" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="type" class="form-label">Type Message</label><br>
                                <select name="type" id="type" class="js-states form-control"  required >
                                    <option value="" selected >Select One</option>
                                    <option value="text">Text Message</option>
                                    <option value="image">Image Message</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="jenis_motor" class="form-label">Template Greeting</label><br>
                                <select name="template_greeting" class="form-control" id="template_greeting" required>
                                    <option value="">--Pilih Template--</option>
                                    @foreach($template as $t)
                                        <option value="{{$t->id}}">{{$t->templateName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <label for="Greeting" class="form-label">Template Greeting</label><br>
                        <textarea name="templateGreeting" class="form-control" id="templateGreeting"  readonly></textarea>
                        <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" id="buttonfile" data-bs-target="#pilihFileSayang">
                            Pilih File
                        </button>
                        <input type="text" name="gambar1" class="form-control" id="gambar1" >
                        <label for="GoodBye" class="form-label">Template GoodBye</label><br>
                        <textarea name="templateGoodBye" class="form-control" id="templateGoodBye"  readonly></textarea>
                        <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" id="buttonfile2" data-bs-target="#pilihFileSayang2">
                            Pilih File
                        </button>
                        <input type="text" name="gambar2" class="form-control" id="gambar2" >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="pilihFileSayang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih file dari penyimpanan berkas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4" id="appendFile">
                        @if($files->isEmpty())
                            <p align="center">Belum ada file yang di upload</p>
                        @endif
                        <div class="table-responsive" >
                            <table class="table table-striped" id="example2">
                                <thead>
                                <th>Pilih</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Ukuran</th>
                                <th>Tanggal Upload</th>
                                <th>Priview</th>
                                </thead>
                                <tbody>
                                @foreach($files as $key => $file)
                                    @php $ext = $file->format;
                                             $spl = explode('/',$ext);
                                    @endphp
                                    <tr>
                                        <td>
                                            {{$key+1}}
                                            <input type="radio" name="aqil" id="file-take-{{$file->id}}" value="{{url('new/assets/berkas/'.$file->name_saved)}}" onclick="preTake('file-take-{{$file->id}}')">

                                        </td>
                                        <td>{{$file->name}}</td>
                                        <td>
                                            {{$file->format}}
                                        </td>
                                        <td>
                                            {{$file->size}}
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($file->date)->format('d F Y')}} {{\Carbon\Carbon::parse($file->created_at)->format('H:i:s')}}
                                        </td>
                                        <td>
                                            @switch($spl[0])
                                                @case('image')
                                                    <img src="{{url('new/assets/berkas/'.$file->name_saved)}}" style="width: 100%;">
                                                    @break
                                                @case('application')
                                                    <i class="fa fa-file-text-o"></i>
                                                    @break
                                                @default
                                                    <i class="fa fa-file"></i>
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>



                    </div><!--//row-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" onclick="takePictureBeh()" class="btn btn-primary" data-bs-dismiss="modal">Konfirmasi</button>
                    <input type="hidden" id="preTake">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pilihFileSayang2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih file dari penyimpanan berkas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4" id="appendFile">
                        @if($files->isEmpty())
                            <p align="center">Belum ada file yang di upload</p>
                        @endif
                        <div class="table-responsive" >
                            <table class="table table-striped" id="example">
                                <thead>
                                <th>Pilih</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Ukuran</th>
                                <th>Tanggal Upload</th>
                                <th>Priview</th>
                                </thead>
                                <tbody>
                                @foreach($files as $key => $file)
                                    @php $ext = $file->format;
                                             $spl = explode('/',$ext);
                                    @endphp
                                    <tr>
                                        <td>
                                            {{$key+1}}
                                            <input type="radio" name="aqil" id="file-take-{{$file->id}}" value="{{url('new/assets/berkas/'.$file->name_saved)}}" onclick="preTake2('file-take-{{$file->id}}')">

                                        </td>
                                        <td>{{$file->name}}</td>
                                        <td>
                                            {{$file->format}}
                                        </td>
                                        <td>
                                            {{$file->size}}
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($file->date)->format('d F Y')}} {{\Carbon\Carbon::parse($file->created_at)->format('H:i:s')}}
                                        </td>
                                        <td>
                                            @switch($spl[0])
                                                @case('image')
                                                    <img src="{{url('new/assets/berkas/'.$file->name_saved)}}" style="width: 100%;">
                                                    @break
                                                @case('application')
                                                    <i class="fa fa-file-text-o"></i>
                                                    @break
                                                @default
                                                    <i class="fa fa-file"></i>
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>



                    </div><!--//row-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" onclick="takePictureBeh2()" class="btn btn-primary" data-bs-dismiss="modal">Konfirmasi</button>
                    <input type="hidden" id="preTake2">
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('js/pages/datatables.js')}}"></script>
    <script src="{{asset('js/pages/select2.js')}}"></script>
    <script src="{{asset('plugins/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>

    <script>

        $('#datatablegreet').DataTable({
            "responsive": true,
            // "desc"
            "order": []

        })
        $('#example').DataTable({
            "searching": true,
            "columnDefs": [
                { "orderable": false, "targets": 0 }
            ]
        });
        $('#example2').DataTable({
            "searching": true,
            "columnDefs": [
                { "orderable": false, "targets": 0 }
            ]
        });

        function hides(){
            $('#buttonfile').hide();
            $('#buttonfile2').hide();
            $('#gambar1').hide();
            $('#gambar2').hide();
        }
        hides();
        function preTake(id) {
            var url = $('#'+id).val();
            $('#preTake').val(url);
            console.log(url);
        }
        function takePictureBeh(){

            var preTake = $('#preTake').val();
            $('#gambar1').val(preTake);
        }
        function preTake2(id) {
            var url = $('#'+id).val();
            $('#preTake2').val(url);
        }

        function takePictureBeh2(){
            var preTake = $('#preTake2').val();
            $('#gambar2').val(preTake);
        }
        $(document).ready(function () {

            $('#type').on('change',function (){
                var type = $(this).val();
                if (type === 'text'){
                    hides();
                }else if (type === 'image'){
                    $('#buttonfile').show(300);
                    $('#buttonfile2').show(300);
                    $('#gambar1').show(300);
                    $('#gambar2').show(300);
                }
            })



            $('#template_greeting').on('change',function (){
                let id = $(this).val();
                // csrf
                let _token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: "{{route('fetch.template')}}",
                    type: "POST",
                    data: {id:id, _token:_token},

                    success: function (data) {
                        $('#templateGreeting').val(data.templateMessage);
                        $('#templateGoodBye').val(data.templateGoodBye);
                    },
                    error: function (data) {
                        alert('Error:', data);
                    }
                })
            })
        });
    </script>
    <script>
        $('#buttonadd',).on('click',function (){
            if($('#sender').val() == ''){
                alert('Pilih Sender Terlebih Dahulu');
            }
        })
    </script>
</x-layout-dashboard>
