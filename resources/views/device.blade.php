<x-layout-dashboard title="Home">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <div class="app-content" style="margin-top: 0;">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex gap-4">
                            <h5 class="">Perangkat Tertaut </h5><span class="text-warning text-sm">Kamu punya {{$limit_device}} prangkat yg bisa di tautkan</span>
                        </div>
                        <p align="left"><button type="button" class="btn btn-primary  btn-rounded " data-bs-toggle="modal" data-bs-target="#addDevice"><i class="fa fa-plus"></i>  Tambah </button></p>
                        <div class="table-responsive" >
                            <table class="table table-striped" id="example">
                                <thead>
                                <th>Nomor</th>
                                <th hidden>URL Webhook</th>
                                <th>Pesan Terkirim</th>
                                <th>Status</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                @foreach ($numbers as $number)
                                <tr>
                                    <td>{{$number['body']}}</td>
                                    <td hidden>
                                        <form action="" method="post">
                                            @csrf
                                            <input type="text" id="webhook" class="form-control form-control-solid-bordered" data-id="{{$number['body']}}" name="" value="{{$number['webhook']}}" id="">
                                        </form>
                                    </td>
                                    <td>{{$number['messages_sent']}}</td>
                                    <td><span class="badge badge-{{ $number['status'] == 'Connected' ? 'success' : 'danger'}}">{{$number['status']}}</span></td>
                                    <td>
                                        <div class="d-flex justify-content-center">

                                            <a href="{{route('scan',$number->body)}}" class="btn btn-warning btn-sm"  style="font-size: 10px;"><i class="fa fa-qrcode"></i></a>
                                            <form action="{{route('deleteDevice')}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <input name="deviceId" type="hidden" value="{{$number['id']}}">
                                                <button type="submit"  onclick="return confirm('yakin mau menghapus?')" name="delete" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
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
    </div>
    <div class="modal fade" id="addDevice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="{{route('addDevice')}}" method="POST">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Perangkat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <label for="sender" class="form-label">Nomor</label>
                        <input type="number" name="sender" class="form-control" id="nomor"  required>
                        <p class="text-small text-danger">*Gunkaan kode 62 ( tanpa + )</p>
                        <label for="urlwebhook" class="form-label">Url webhook</label>
                        <input type="text" name="urlwebhook" class="form-control" id="urlwebhook">
                        <p class="text-small text-danger">*Boleh dikosongi</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit"  name="submit" class="btn btn-primary">Simpan</button>

                    </div>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;
        $('#webhook').keydown(function(){
            clearTimeout(typingTimer);

            typingTimer = setTimeout(function(){
                $.ajax({
                    method : 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url : '{{route('setHook')}}',
                    data : {
                        number : $('#webhook').data('id'),
                        webhook : $('#webhook').val()
                    },
                    dataType : 'json',
                    success : (result) => {

                    },
                    error : (err) => {
                        console.log(err);
                    }
                })
            }, doneTypingInterval);
        })
        $(document).ready(function () {
            $('#example').DataTable();
        });
        function removeAlert() {
            $('#alert-beh').remove();
        }

    </script>

</x-layout-dashboard>