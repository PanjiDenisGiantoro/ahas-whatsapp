
<x-layout-dashboard title="Message Test">
    <style>
        .app-content .page-description
        {
            margin-bottom: 0;
            padding : 0;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <div class="app-content">
        @if (session()->has('alert'))
            <x-alert>
                @slot('type',session('alert')['type'])
                @slot('msg',session('alert')['msg'])
            </x-alert>
        @endif
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="page-description page-description-tabbed">
                                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#text" type="button" role="tab" aria-controls="hoaccountme" aria-selected="true">Text</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#image" type="button" role="tab" aria-controls="security" aria-selected="false">Media</button>
                                        </li>
                                        {{--                                <li class="nav-item" role="presentation">--}}
                                        {{--                                    <button class="nav-link" id="integrations-tab" data-bs-toggle="tab" data-bs-target="#button" type="button" role="tab" aria-controls="integrations" aria-selected="false">Button</button>--}}
                                        {{--                                </li>--}}
                                        {{--                                <li class="nav-item" role="presentation">--}}
                                        {{--                                    <button class="nav-link" id="integrations-tab" data-bs-toggle="tab" data-bs-target="#template" type="button" role="tab" aria-controls="integrations" aria-selected="false">Template</button>--}}
                                        {{--                                </li>--}}
                                        {{--                                <li class="nav-item" role="presentation">--}}
                                        {{--                                    <button class="nav-link" id="integrations-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab" aria-controls="integrations" aria-selected="false">List</button>--}}
                                        {{--                                </li>--}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="text" role="tabpanel" aria-labelledby="account-tab">
                                <div class="card">
                                    {{-- please select deviec --}}
                                    <div class="card-body">
                                        @if(!Session::has('selectedDevice'))
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="alert alert-danger" role="alert">
                                                        <strong>Please select device first</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <h5>Text Message</h5>
                                            <div class="example-container">
                                                <div class="example-content">
                                                    <form action="{{route('textMessageTest')}}" method="POST" id="formSendMsg">
                                                        @csrf
                                                        <label for="textmessage" class="form-label">Whatsapp Account</label>
                                                        <input type="number" value={{Session::get('selectedDevice')}} name="sender" id="sender" class="form-control" readonly>

                                                        <label for="number" class="form-label">Number Destination</label>
                                                        <input type="text" name="number" class="form-control" id="number" required>
                                                        {{--                                                template--}}
                                                        <label for="template" class="form-label">Template</label>
                                                        <select name="template" id="template" class="form-control"  >
                                                            <option value="">Pilih Template</option>
                                                            @foreach ($templates as $template)
                                                                <option value="{{$template->id}}">{{$template->templateName}} - {{$template->templateType}}</option>
                                                            @endforeach
                                                        </select>
                                                        <label for="textmessage" class="form-label">Message</label>
                                                        <textarea class="form-control" name="message" id="textmessage" cols="30" required></textarea>
                                                        <button type="submit" name="sendMsg" class="btn btn-success mt-3"><i class="material-icons-outlined">send</i>Send</button>
                                                    </form>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="security-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Media Message </h5>
                                        <div class="example-container">
                                            <div class="example-content">
                                                <form action="{{route('imageMessageTest')}}" method="POST" id="formSendMsg">
                                                    @csrf
                                                    <label for="textmessage" class="form-label">Whatsapp Account</label>
                                                    <input type="number" value={{Session::get('selectedDevice')}} name="sender" id="sender" class="form-control" readonly>

                                                    <label for="number" class="form-label">Number Destination</label>
                                                    <input type="number" name="number" class="form-control " id="number" required>
                                                    <label for="template" class="form-label">Template</label>
                                                    <select name="template" id="templatemedia" class="form-control"  >
                                                        <option value="">Pilih Template</option>
                                                        @foreach ($templates as $template)
                                                            <option value="{{$template->id}}">{{$template->templateName}} - {{$template->templateType}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="file-uploader">
                                                        <label class="form-label mt-4">Media Url *Select from file manager,or fill manual</label><br>
                                                        <span class="text-danger text-sm">make sure the URL goes directly to the media.</span>
                                                        <div class="chose-area"></div>
                                                    </div>
                                                    {{--  radio select flex,,  --}}
                                                    <div class="form-group mt-4">
                                                        <label class="form-label">Media Type</label>
                                                        {{-- dif flex gap 4 --}}

                                                        <div class="d-flex ">

                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="customRadioInline1" name="type" class="custom-control-input" value="image" checked>
                                                                <label class="custom-control-label" for="customRadioInline1">Image (jpg,jpeg,png,pdf)</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="customRadioInline2" name="type" class="custom-control-input" value="video">
                                                                <label class="custom-control-label" for="customRadioInline2">Video</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="customRadioInline3" name="type" class="custom-control-input" value="audio">
                                                                <label class="custom-control-label" for="customRadioInline3">Audio</label>
                                                            </div>
                                                            {{-- pdf,xls,xlsx,doc,docx,zip,mp3 --}}
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="customRadioInline4" name="type" class="custom-control-input" value="pdf">
                                                                <label class="custom-control-label" for="customRadioInline4">pdf</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="customRadioInline5" name="type" class="custom-control-input" value="xls">
                                                                <label class="custom-control-label" for="customRadioInline5">xls</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="customRadioInline6" name="type" class="custom-control-input" value="xlsx">
                                                                <label class="custom-control-label" for="customRadioInline6">xlsx</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="customRadioInline7" name="type" class="custom-control-input" value="doc">
                                                                <label class="custom-control-label" for="customRadioInline7">doc</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="customRadioInline8" name="type" class="custom-control-input" value="docx">
                                                                <label class="custom-control-label" for="customRadioInline8">docx</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="customRadioInline9" name="type" class="custom-control-input" value="zip">
                                                                <label class="custom-control-label" for="customRadioInline9">zip</label>
                                                            </div>





                                                        </div>
                                                    </div>




                                                    <label for="textmessage" class="form-label mt-4">Caption</label>
                                                    <input type="text" name="message" class="form-control" id="textmessagemedia" required>
                                                    <button type="submit" name="sendMsg" class="btn btn-success mt-3"><i class="material-icons-outlined">send</i>Send</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="button" role="tabpanel" aria-labelledby="integrations-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Button Message</h5>
                                        <div class="example-container">
                                            <div class="example-content">
                                                <form action="{{route('buttonMessageTest')}}" method="POST" id="formSendMsg">
                                                    @csrf
                                                    <label for="textmessage" class="form-label">Whatsapp Account</label>
                                                    {{-- input --}}
                                                    <input type="text" value={{Session::get('selectedDevice')}} name="sender" id="sender" class="form-control" readonly>
                                                    <label for="number" class="form-label">Number Destination</label>
                                                    <input type="number" name="number" class="form-control" id="number" required>

                                                    <label for="template" class="form-label">Template</label>
                                                    <select name="template" id="templatebutton" class="form-control" required >
                                                        <option value="">Pilih Template</option>
                                                        @foreach ($templates as $template)
                                                            <option value="{{$template->id}}">{{$template->templateName}} - {{$template->templateType}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="file-uploader">
                                                        <label for="textmessage" class="form-label">Message</label>
                                                        <input type="text" name="message" class="form-control" id="textmessagebutton" required>
                                                        <label for="footer" class="form-label">Footer message *optional</label>

                                                        <input type="text" name="footer" class="form-control" id="footer" >
                                                        <div class=" file-uploader">
                                                            <label class="form-label mt-4">Image *optional</label><br>

                                                            <div class="chose-area"></div>
                                                        </div>
                                                        <button class="btn btn-sm btn-primary mt-4" type="button" id="addbutton">+ Button</button>
                                                        <div id="button-area">

                                                        </div>
                                                        <button type="submit" name="sendMsg" class="btn btn-success mt-3"><i class="material-icons-outlined">send</i>Send</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="template" role="tabpanel" aria-labelledby="integrations-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Template Message</h5>
                                        <div class="example-container">
                                            <div class="example-content">
                                                <form action="{{route('templateMessageTest')}}" method="POST" id="formSendMsg">
                                                    @csrf
                                                    <label for="textmessage" class="form-label">Whatsapp Account</label>
                                                    {{-- input --}}
                                                    <input type="text" value={{Session::get('selectedDevice')}} name="sender" id="sender" class="form-control" readonly>
                                                    <label for="number" class="form-label">Number Destination</label>
                                                    <input type="number" name="number" class="form-control" id="number" required>

                                                    <label for="template" class="form-label">Template</label>
                                                    <select name="template" id="templatetemplate" class="form-control" required >
                                                        <option value="">Pilih Template</option>
                                                        @foreach ($templates as $template)
                                                            <option value="{{$template->id}}">{{$template->templateName}} - {{$template->templateType}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="textmessage" class="form-label">Message</label>
                                                    <input type="text" name="message" class="form-control" id="textmessagetemplate" required>
                                                    <label for="footer" class="form-label">Footer message *optional</label>
                                                    <input type="text" name="footer" class="form-control" id="number" >
                                                    <div class=" file-uploader">
                                                        <label class="form-label mt-4">Image *optional</label><br>

                                                        <div class="chose-area"></div>
                                                    </div>
                                                    <button class="btn btn-sm btn-primary mt-4" type="button" id="addtemplate">+ Template</button>
                                                    <div id="template-area">

                                                    </div>
                                                    {{-- <label for="template1" class="form-label">Template 1</label>
                                                    <input type="text" placeholder="TYPE|Your text here|UrlOrPhoneNumber" name="template1" id="template" class="form-control">
                                                    <label for="template2" class="form-label">Template 2</label>
                                                    <input type="text" placeholder="TYPE|Your text here|UrlOrPhoneNumber" name="template2" id="template2" class="form-control">  --}}
                                                    <span class="text-danger">example Button link : <span class="badge badge-secondary">url|Visit me|https://m-pedia.id</span> <br> example Call button : <span class="badge badge-secondary">call|Call me|6282298859671</span>  <br> The type only have two options, call and url!</span>
                                                    <br>
                                                    <button type="submit" name="sendMsg" class="btn btn-success mt-3"><i class="material-icons-outlined">send</i>Send</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="integrations-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>List Message</h5>
                                        <div class="example-container">
                                            <div class="example-content">
                                                <form action="{{route('listMessageTest')}}" method="POST" id="formSendMsg">
                                                    @csrf
                                                    <label for="textmessage" class="form-label">Whatsapp Account</label>
                                                    {{-- input --}}
                                                    <input type="text" value={{Session::get('selectedDevice')}} name="sender" id="sender" class="form-control" readonly>
                                                    <label for="number" class="form-label">Number Destination</label>
                                                    <input type="number" name="number" class="form-control" id="number" required>


                                                    <label for="template" class="form-label">Template</label>
                                                    <select name="template" id="templatetitlelist" class="form-control" required >
                                                        <option value="">Pilih Template</option>
                                                        @foreach ($templates as $template)
                                                            <option value="{{$template->id}}">{{$template->templateName}} - {{$template->templateType}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="textmessage" class="form-label">Message</label>
                                                    <input type="text" name="message" class="form-control" id="textmessage" required>
                                                    <label for="footer" class="form-label">Footer message *optional</label>
                                                    <input type="text" name="footer" class="form-control" id="textmessagetitlelist" >
                                                    <label for="footer" class="form-label">Title List</label>
                                                    <input type="text" name="title" class="form-control" id="title" required>
                                                    <label for="buttontext" class="form-label">Text Button </label>

                                                    <input type="text" name="buttontext" class="form-control" id="buttontext" >

                                                    <button class="btn btn-sm btn-primary mt-4" type="button" id="addList">+ List</button>
                                                    <div id="list-area">

                                                    </div>
                                                    <button type="submit" name="sendMsg" class="btn btn-success mt-3"><i class="material-icons-outlined">send</i>Send</button>
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
</x-layout-dashboard>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script><script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $('#template').on('change',function(){
        let template = $(this).val();
        //    ajax template

        $.ajax({
            url: "{{route('campaign.gettemplate')}}",
            type: "GET",
            data: {
                template:template,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                console.log(response);
                if(response.status == 'success'){
                    $('#textmessage').val(response.data.templateMessage);
                }else{
                    $('#textmessage').val('');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    })
    $('#templatemedia').on('change',function(){
        let template = $(this).val();
        //    ajax template

        $.ajax({
            url: "{{route('campaign.gettemplate')}}",
            type: "GET",
            data: {
                template:template,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                console.log(response);
                if(response.status == 'success'){
                    $('#textmessagemedia').val(response.data.templateMessage);
                }else{
                    $('#textmessagemedia').val('');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    })
    $('#templatebutton').on('change',function(){
        let template = $(this).val();
        //    ajax template

        $.ajax({
            url: "{{route('campaign.gettemplate')}}",
            type: "GET",
            data: {
                template:template,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                console.log(response);
                if(response.status == 'success'){
                    $('#textmessagebutton').val(response.data.templateMessage);
                }else{
                    $('#textmessagebutton').val('');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    })
    $('#templatetemplate').on('change',function(){
        let template = $(this).val();
        //    ajax template

        $.ajax({
            url: "{{route('campaign.gettemplate')}}",
            type: "GET",
            data: {
                template:template,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                console.log(response);
                if(response.status == 'success'){
                    $('#textmessagetemplate').val(response.data.templateMessage);
                }else{
                    $('#textmessagetemplate').val('');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    })
    $('#templatetitlelist').on('change',function(){
        let template = $(this).val();
        //    ajax template

        $.ajax({
            url: "{{route('campaign.gettemplate')}}",
            type: "GET",
            data: {
                template:template,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                console.log(response);
                if(response.status == 'success'){
                    $('#textmessagetitlelist').val(response.data.templateMessage);
                }else{
                    $('#textmessagetitlelist').val('');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    })
    function takePictureBeh() {
        var url = $('#preTake').val();
        $('#test-media-file-1').val(url);
    }

    function preTake(id) {
        var url = $('#'+id).val();
        $('#preTake').val(url);
        console.log(url);
    }
    // when tab change, find .chose-area in active tab

    $('.nav-link').on('click', function(e) {


        var choseAreaImage = $('#image').find('.chose-area');
        choseAreaImage.html('');
        //find data-bs-target in this
        var target = $(this).data('bs-target');
        if(target == '#button'){
            var choseAreaImage = $('#image').find('.chose-area');
            choseAreaImage.html('');
            let choseAreaTemplate = $('#template').find('.chose-area');
            choseAreaTemplate.html('');
            var choseArea = $('#button').find('.chose-area');
            choseArea.html(
                `<div class="input-group ">
                <span class="input-group-btn">
                    <a  class="btn btn-primary text-white imagetest" data-bs-toggle="modal" data-bs-target="#pilihFileSayang">
                        <i class="fa fa-file-o"></i> Pilih
                    </a>
                </span>
                    <input id="test-media-file-1" class="form-control" type="text" name="image" required="">
            </div>`
            )
            $('#imagetest').filemanager('file')



        } else if(target == '#image'){
            let choseAreaButton = $('#button').find('.chose-area');
            choseAreaButton.html('');
            let choseAreaTemplate = $('#template').find('.chose-area');
            choseAreaTemplate.html('');
            var choseArea = $('#image').find('.chose-area');
            choseArea.html(
                `  <div class="input-group ">
                                                <span class="input-group-btn">
                                                    <a  class="btn btn-primary text-white imagetest" data-bs-toggle="modal" data-bs-target="#pilihFileSayang">
                                                            <i class="fa fa-file-o"></i> Pilih
                                                    </a>
                                                </span>
                                                    <input id="test-media-file-1" class="form-control" type="text" name="image" required="">
                                                </div>`
            )
            $('#imagetest').filemanager('file')
        }
        else if(target == '#template'){
            let choseAreaButton = $('#button').find('.chose-area');
            choseAreaButton.html('');

            let choseAreaImage = $('#image').find('.chose-area');
            choseAreaImage.html('');

            var choseArea = $('#template').find('.chose-area');
            choseArea.html(
                `  <div class="input-group ">
                                                <span class="input-group-btn">
                                                    <a  class="btn btn-primary text-white imagetest" data-bs-toggle="modal" data-bs-target="#pilihFileSayang">
                                                            <i class="fa fa-file-o"></i> Pilih
                                                    </a>
                                                </span>
                                                    <input id="test-media-file-1" class="form-control" type="text" name="image" required="">
                                                </div>`
            )
            $('#imagetest').filemanager('file')
        }
    });

    // add button when click addbutton maximum 3, if click addbutton more than 3, it will not add button
    $('#addbutton').click(function(){
        var button = $('#button-area').children().length;
        if(button < 3){
            $('#button-area').append('<div class="form-group"><label for="button'+(button+1)+'" class="form-label">Button '+(button+1)+'</label><input type="text" name="button['+(button+1)+']" id="button'+(button+1)+'" class="form-control" required></div>');
        }
    });
    $('#addtemplate').click(function(){
        var template = $('#template-area').children().length;
        if(template < 3){

            $('#template-area').append('<div class="form-group"><label for="template'+(template+1)+'" class="form-label">Template '+(template+1)+'</label><input type="text" placeholder="TYPE|Your text here|UrlOrPhoneNomor"  name="template['+(template+1)+']" id="template'+(template+1)+'" class="form-control" required></div>');
        }
    });

    $('#addList').click(function(){
        var list = $('#list-area').children().length;
        if(list < 5){

            $('#list-area').append('<div class="form-group"><label for="list'+(list+1)+'" class="form-label">list '+(list+1)+'</label><input type="text"  name="list['+(list+1)+']" id="list'+(list+1)+'" class="form-control" required></div>');
        }
    });


    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
