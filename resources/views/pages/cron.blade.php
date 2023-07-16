<x-layout-dashboard title="Auto Replies">

    <div class="app-content" style="">
        {{-- <link href="{{asset('plugins/datatables/datatables.min.css')}}" rel="stylesheet"> --}}
        {{-- <link href="{{asset('plugins/select2/css/select2.css')}}" rel="stylesheet"> --}}
        <link href="{{asset('css/custom.css')}}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
              rel="stylesheet">
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
                                <div class="card-body">
                                    <!--                                        card header-->
                                    <div class="card-header">
                                        <h5>
                                            CRON Number
                                        </h5>
                                        <hr>
                                    </div>


                                    <form action="{{route('campaign.save')}}" method="post">

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3 col-3 col-sm-12">
                                                    <label for="name" class="m-4">Nomor Auo Cron</label>
                                                </div>
                                                <div class="col-md-6 col-6 col-sm-12">
                                                    @csrf
                                                    <select name="nomor" id="nomor" class="form-control" required>


                                                        <option value="">Pilih Nomor</option>
                                                        @foreach($number as $numbers)
                                                            <option value="{{$numbers->id}}"
                                                            @php

                                                            if ($numbers->id == $cron->nomor){
                                                                echo "selected";
                                                            }
                                                            @endphp
                                                            >{{$numbers->body}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 col-6 col-sm-12">

                                                    <button type="submit" class="btn btn-primary" id="simpan">Save CRON</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

            </div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header">
                                        <h5>
                                            CRON Message Setting
                                        </h5>
                                        <hr>
                                    </div>




                                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="form-group">

                                            <div class="row">
                                                <div class="col-md-3 col-3 col-sm-12">
                                                    <label for="name" class="m-4">Birthday Message Automation</label>
                                                </div>
                                                <!--                                                    <div class="row">-->
                                                <div class="col-md-6 col-6   col-sm-12">
                                                    <input type="checkbox" checked  class="form-control ulang" data-toggle="toggle" data-on="Aktif" data-off="Tidak Aktif" data-onstyle="primary" data-offstyle="danger"data-size="sm"name="cek"  >
                                                    <!--                                                        select template-->
                                                    <!--                                                    </div>-->
                                                </div>

                                            </div>
                                            <!--                                                slider -->
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3 col-3 col-sm-12">
                                                    <label for="name" class="m-4">KPB Message Automation</label>
                                                </div>
                                                <div class="col-md-6 col-6 col-sm-12">
                                                    <input type="checkbox" checked  class="form-control kpb" data-toggle="toggle" data-on="Aktif" data-off="Tidak Aktif" data-onstyle="primary" data-offstyle="danger"data-size="sm"name="cek"  >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3 col-3 col-sm-12">
                                                    <label for="name" class="m-4">Promotion Message Automation</label>
                                                </div>
                                                <div class="col-md-6 col-6 col-sm-12">
                                                    <input type="checkbox" checked  class="form-control promo" data-toggle="toggle" data-on="Aktif" data-off="Tidak Aktif" data-onstyle="primary" data-offstyle="danger"data-size="sm"name="cek"  >
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <!--                                        card header-->
                                    <div class="card-header">
                                        <h5>
                                            CRON Message
                                        </h5>
                                        <hr>
                                    </div>


                                    <form action="{{route('campaign.save_batch')}}"method="post">
                                        @csrf
                                        <div class="col-12 col-md-12 col-lg-12 col-xl-12" style="display: none" id="vulang">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3 col-3 col-sm-12">
                                                        <label for="name" class="m-4">Birthday Message Automation</label>
                                                    </div>
                                                    <!--                                                    <div class="row">-->
                                                    <div class="col-md-6 col-6   col-sm-12">
                                                        <select name="pesan_ulang" id="template" class="form-control ">

                                                            <option value="">Pilih Template</option>
                                                            @foreach($templateulang as $templates)
                                                                <option value="{{$templates->id}}"
                                                                @php

                                                                if ($templates->id == $cron->pesan_ulang){
                                                                    echo "selected";
                                                                }
                                                                @endphp
                                                                >{{$templates->templateName}}</option>
                                                            @endforeach
                                                        </select>
                                                        <!--                                                    </div>-->
                                                    </div>
                                                </div>
                                                <!--                                                slider -->
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-12 col-xl-12" style="display: none" id="vkpb">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3 col-3 col-sm-12">
                                                        <label for="name" class="m-4">AUto KPB</label>
                                                    </div>
                                                    <div class="col-md-6 col-6 col-sm-12">
                                                        <select name="pesan_kpb" id="template" class="form-control ">

                                                            <option value="">Pilih Template</option>
                                                            @foreach($templatekpb as $templates)
                                                                <option value="{{$templates->id}}"
                                                                @php

                                                                if ($templates->id == $cron->pesan_kpb){
                                                                    echo "selected";
                                                                }
                                                                @endphp
                                                                >{{$templates->templateName}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-12 col-xl-12" style="display: none" id="vpromo">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-3 col-3 col-sm-12">
                                                        <label for="name" class="m-4">AUto Promo</label>
                                                    </div>
                                                    <div class="col-md-6 col-6 col-sm-12">
                                                        <select name="pesan_promo" id="template" class="form-control ">

                                                            <option value="">Pilih Template</option>
                                                            @foreach($templatepromo as $templates)
                                                                <option value="{{$templates->id}}"
                                                                @php

                                                                if ($templates->id == $cron->pesan_promo){
                                                                    echo "selected";
                                                                }
                                                                @endphp
                                                                >{{$templates->templateName}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3 col-3 col-sm-12">
                                                    <label for="name" class="m-4">AUto Service</label>
                                                </div>
                                                <div class="col-md-6 col-6 col-sm-12">
                                                    <select name="pesan_servis" id="template" class="form-control ">
                                                        <option value="">Pilih Template</option>
                                                        @foreach($template as $templates)
                                                            <option value="{{$templates->id}}"
                                                                    @php
                                                                        if ($templates->id == $cron->pesan_servis){
                                                                            echo "selected";
                                                                        }
                                                                    @endphp
                                                            >{{$templates->templateName}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-12 col-xl-12">

                                            <!--                                                button simpan-->
                                            <div class="form-group
                                                ">
                                                <div class="row m-4">
                                                    <button type="submit" class="btn btn-primary btn-sm">Update Cron</button>
                                                </div>
                                            </div>
                                            <!--                                            -->
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <!--  -->
    {{-- <script src="{{asset('js/pages/datatables.js')}}"></script> --}}
    {{-- <script src="{{asset('js/pages/select2.js')}}"></script> --}}
    <script src="{{asset('plugins/datatables/datatables.min.js')}}"></script>
    {{-- <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script> --}}
    <script src="{{asset('js/autoreply.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

    <script>
        <?php
        $data = \Illuminate\Support\Facades\DB::table('cron')->where('id_cron', 1)->first();
        if ($data->auto_ulang_tahun == 1) { ?>
        $('#vulang').show();
        <?php  } else { ?>
        $('#vulang').hide();
        <?php }
        ?>
        <?php
        if ($data->auto_kpb == 1) { ?>
        $('#vkpb').show();
        <?php  } else { ?>
        $('#vkpb').hide();
        <?php }
        ?>
        <?php
        if ($data->auto_promo == 1) { ?>
        $('#vpromo').show();
        <?php  } else { ?>
        $('#vpromo').hide();
        <?php }
        ?>


        $('.ulang').change(function() {
            if($(this).prop('checked') == true){
                $('#vulang').show();
                //   ajax
                $.ajax({
                    url: '{{route('campaign.cron_ulang')}}',
                    type: 'POST',
                    dataType: 'json',
                    //scrf
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {ulang: '1'},
                })
                    .done(function() {
                        console.log("success");
                    })
            }else{
                $('#vulang').hide();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{route('campaign.cron_ulang')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: {ulang: '0'},
                })
                    .done(function() {
                        console.log("success");
                    })
            }
        });

        $('.kpb').change(function() {
            if($(this).prop('checked') == true){
                $('#vkpb').show();

                //   ajax
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{route('campaign.cron_kpb')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: {kpb: '1'},
                })
                    .done(function() {
                        console.log("success");
                    })
            }else{
                $('#vkpb').hide();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{route('campaign.cron_kpb')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: {kpb: '0'},
                })
                    .done(function() {
                        console.log("success");
                    })
            }
        });


        $('.promo').change(function() {
            if($(this).prop('checked') == true){
                //   ajax
                $('#vpromo').show();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{route('campaign.promo')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: {promo: '1'},
                })
                    .done(function() {
                        console.log("success");
                    })
            }else{
                $('#vpromo').hide();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{route('campaign.promo')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: {promo: '0'},
                })
                    .done(function() {
                        console.log("success");
                    })
            }
        });

    </script>


</x-layout-dashboard>