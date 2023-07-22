<x-layout-dashboard title="Contacts">
    <div class="app-content">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
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


                <style>
                    .select2-container {
                        display: block !important;
                    }
                </style>

                <div class="card-header d-flex justify-content-between">
                    <form action="{{route('deleteAll')}}" method="POST">
                        @method('delete')
                        @csrf
                        <input type="hidden" name="tag" value="{{$tag->id}}">
                        <button type="submit" onclick="return confirm('yakin mau menghapus semua daftar kontak?')" name="deleteAll" class="btn btn-danger "><i class="material-icons-outlined">contacts</i>Hapus Semua</button>
                    </form>

                    <div class="d-flex justify-content-right">
                        <button type="button" class="btn btn-success mx-2" onclick="validateNumbers()">
                            Validasi Nomor
                        </button>
                        <form action="{{route('exportContact')}}" method="POST">
                            @csrf
                            <input type="hidden" name="tag" value="{{$tag->id}}">
                            <button type="submit" name="" class="btn btn-warning "><i class="material-icons">download</i>Export (xlsx)</button>
                        </form>
                        <button type="button" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#importContacts"><i class="material-icons-outlined">upload</i>Import (xlsx)</button>
                        <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#addNumber"><i class="material-icons-outlined">add</i>Add</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title">Contact lists from <span class="badge badge-primary">{{$tag->name}}</span></h5>
                                <!-- <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#selectNomor"><i class="material-icons-outlined">contacts</i>Hapus semua</button>
                                <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#selectNomor"><i class="material-icons-outlined">contacts</i>Generate Kontak</button>
                                <div class="d-flex justify-content-right">
                                    <form action="" method="POST">
                                        <button type="submit" name="export" class="btn btn-warning "><i class="material-icons">download</i>Export (xlsx)</button>
                                    </form>
                                    <button type="button" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#importExcel"><i class="material-icons-outlined">upload</i>Import (xlsx)</button>
                                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#addNumber"><i class="material-icons-outlined">add</i>Tambah</button>
                                </div> -->
                            </div>
                            <div class="card-body">
                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Nomor</th>
                                        <th>Nama AHAS</th>
                                        <th>Status Valid</th>
                                        <th class="">Edit</th>
                                        <th class="">Hapus</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($contacts as $contact)

                                        <tr>
                                            <td>{{$contact->name}}</td>
                                            <td>{{$contact->number}}</td>
                                            <td>{{$contact->nama_ahas}}</td>
                                            <td>{{$contact->status_valid}}</td>
                                            <td>

                                                <button type="submit" data-bs-toggle="modal" data-bs-target="#ganti_kontak{{$contact->id}}" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-edit"></i></button>

                                            </td>
                                            <td>
                                                <form action="{{route('contactDeleteOne',$contact->id)}}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$contact->id}}">
                                                    <button type="submit" name="delete" onclick="return confirm('yakin mau menghapus?')" class="btn btn-danger btn-sm"><i class="material-icons">delete_outline</i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="ganti_kontak{{$contact->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <form action="{{url('contact_edit/'.$contact->id)}}" method="POST">
                                                @csrf
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Kontak</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <label for="sender" class="form-label">Nomor</label>
                                                            <input type="number" name="number" class="form-control"  required value="{{$contact->number}}">
                                                            <label for="urlwebhook" class="form-label">Nama</label>
                                                            <input type="text" name="name" class="form-control" required
                                                                   value="{{$contact->name}}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit"  name="submit" class="btn btn-primary">Simpan</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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
    <div class="modal fade" id="addNumber" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('addcontact')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-1">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>

                        <div class="form-group mb-1">
                            <label for="number" class="form-label">Number</label>
                            <input type="number" name="number" class="form-control" id="number" required>
                        </div>

                        <div class="form-group mb-1">
                            <label for="" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" required>
                        </div>

                        <div class="form-group mb-1">
                            <label for="number" class="form-label">Jenis Data</label>
                            <select name="jenis_data" id="jenis_data" class="form-control">
                                <option value="Reg Non DM">Reg Non DM</option>
                                <option value="Reg DM">Reg DM</option>
                            </select>
                        </div>

                        <div class="form-group mb-1">
                            <label for="number" class="form-label">Jenis KPB</label>
                            <select name="jenis_kpb" id="jenis_kpb" class="form-control">
                                <option value="Reg Non DM">Reg Non DM</option>
                                <option value="Reg DM">Reg DM</option>
                            </select>
                        </div>

                        <div class="form-group mb-1">
                            <label for="number" class="form-label">Nama AHAS</label>
                            <input type="text" name="nama_ahas" class="form-control" id="nama_ahas" required>
                        </div>

                        <div class="form-group mb-1">
                            <label for="number" class="form-label">NO AHASS</label>
                            <input type="number" name="no_ahas" class="form-control" id="no_ahas" required>
                        </div>

                        <div class="form-group mb-1">
                            <label for="number" class="form-label">Sub Area</label>
                            <input type="text" name="sub_area" class="form-control" id="sub_area" required>
                        </div>

                        <div class="form-group mb-1">
                            <label for="number" class="form-label">Bulan</label>
                            <select name="bulan" id="bulan" class="form-control" required>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>

                        <div class="form-group mb-1">
                            <label for="number" class="form-label">Tanggal Expired</label>
                            <input type="date" name="tanggal_expired" class="form-control" id="tanggal_expired" required>
                        </div>

                        <div class="form-group mb-1">
                            <label for="deskripsi" class="form-label">Deskripsi Kendaraan</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi"></textarea>
                        </div>

                        <div class="form-group mb-1">
                            <label for="no_mesin" class="form-label">No Mesin</label>
                            <input type="text" name="no_mesin" class="form-control" id="no_mesin" required>
                        </div>

                        <div class="form-group mb-1">
                            <label for="KM" class="form-label">KM</label>
                            <input type="text" name="KM" class="form-control" id="KM" required>
                        </div>

                        <input type="hidden" name="tag" value="{{$tag->id}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="importContacts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Contacts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('importContacts')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="fileContacts" class="form-label">Name</label>
                        <input type="file" name="fileContacts" class="form-control" id="fileContacts" required>

                        <input type="hidden" name="tag" value="{{$tag->id}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="validate-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Validasi Nomor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Progress: <span id="progress"></span> dari <span id="total"></span></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.socket.io/4.4.1/socket.io.min.js" integrity="sha384-fKnu0iswBIqkjxrhQCTZ7qlLHOFEgNkRmK2vaO/LbTZSXdJfAu6ewRBdwHPhBo/H" crossorigin="anonymous"></script>
    <script src="{{asset('js/pages/datatables.js')}}"></script>
    <script src="{{asset('js/pages/select2.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        const tag = `{{ $id }}`
        const socket = io('{{env('WA_URL_SERVER')}}', {
            transports: ['websocket', 'polling', 'flashsocket']
        })

        $(document).ready(function () {
            $('#example').DataTable({
                order: []
            });
        });

        function validateNumbers()
        {
            $("#validate-modal").modal('show')

            $("#validate-modal #total").text('0')
            $("#validate-modal #progress").text('0')

            socket.emit('validateWANumber', tag)
        }

        socket.on('validateNumberProgress', ({total, progress}) => {
            $("#validate-modal #total").text(total)
            $("#validate-modal #progress").text(progress)
        })

        socket.on('validateNumberDone', () => {
            alert('Selesai')
            window.location.reload()
        })

        socket.on('validateNumberError', () => {
            $("#validate-modal #progress").text('Reconnecting ...')
            $.get("{{ url('/reconnect-wa') }}", function(){
                setTimeout(function(){
                    socket.emit('validateWANumber', tag)
                }, 2000)
            })
        })
    </script>
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>

</x-layout-dashboard>