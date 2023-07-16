<x-layout-dashboard title="File manager">
    <link id="theme-style" rel="stylesheet" href="new/assets/css/portal.css">
   <div class="pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0">Daftar Berkas</h1>
                    </div>
                    <div class="col-auto">
                         <div class="page-utilities">
                            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                                <div class="col-auto">
                                    <form class="docs-search-form row gx-1 align-items-center" action="{{url('file-manager')}}">
                                        <div class="col-auto">
                                            <input type="text" id="search-docs" name="namefile" class="form-control search-docs" placeholder="contoh : Data penjualan" value="{{$request->namefile}}">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn app-btn-secondary">Cari</button>
                                        </div>
                                    </form>
                                </div><!--//col-->
                                <div class="col-auto">
                                    <form class="docs-search-form row gx-1 align-items-center" action="{{url('file-manager')}}">
                                        <div class="col-auto">
                                            <input type="date" required id="search-docs" name="diupload" class="form-control search-docs" placeholder="Search" value="{{$request->diupload}}">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn app-btn-secondary">Filter Tanggal</button>
                                        </div>
                                    </form>
                                </div><!--//col-->
                                <div class="col-auto">
                                    <label class="btn app-btn-primary" href="#" for="simpan-file" id="upload-file-btn">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-upload me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                      <path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                    </svg>Upload File
                                  </label>
                                  <small style="display: none;" id="tunggu-upload">
                                    <b style="color: red;">Proses upload file mohon tunggu ... </b>
                                 </small>
                                  <form id="post-file" method="post" style="display: none;" action="{{url('file-manager-store')}}"
                                   enctype="multipart/form-data">
                                    @csrf
                                      <input type="file" name="file[]" multiple id="simpan-file">
                                  </form>
                                </div>
                            </div><!--//row-->
                        </div><!--//table-utilities-->
                    </div><!--//col-auto-->
                </div><!--//row-->
                
                <div class="row g-4" id="appendFile">
                    @if($files->isEmpty())
                        <p align="center">Belum ada file yang di upload</p>
                    @endif
                    @php $notArr = []; @endphp
                    @foreach($files as $key => $file)
                    
                    <div class="col-6 col-md-4 col-xl-3 col-xxl-2">
                        <div class="app-card app-card-doc shadow-sm h-100">
                            <div class="app-card-thumb-holder p-3">
                                @php $ext = $file->format;
                                     $spl = explode('/',$ext);
                                     array_push($notArr,$file->id);
                                @endphp
                                <span class="icon-holder">
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
                                    
                                </span>
                                 <a class="app-card-link-mask" href="#file-link"></a>
                            </div>
                            <div class="app-card-body p-3 has-card-actions">
                                
                                <h4 class="app-doc-title truncate mb-0">
                                    <a href="#file-link" title="{{$file->name}}">{{$file->name}}</a>
                                </h4>
                                <div class="app-doc-meta">
                                    <ul class="list-unstyled mb-0">
                                        <li><span class="text-muted">Tipe:</span> {{$file->format}}</li>
                                        <li><span class="text-muted">Ukuran:</span> {{$file->size}}</li>
                                        <li><span class="text-muted">Diupload :</span> 
                                            {{\Carbon\Carbon::parse($file->date)->format('d F Y')}} {{\Carbon\Carbon::parse($file->created_at)->format('H:i:s')}}
                                        </li>
                                    </ul>
                                </div><!--//app-doc-meta-->
                                
                                <div class="app-card-actions">
                                     <div class="dropdown">
                                        <div class="dropdown-toggle no-toggle-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                            </svg>
                                        </div>
                                        <!--//dropdown-toggle-->
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" download href="{{url('new/assets/berkas/'.$file->name_saved)}}">
                                                        <i class="fa fa-download"></i> Download
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item" href="{{url('file-manager-delete/'.$file->id)}}"
                                                        onclick="return confirm('Yakin untuk mengahapus file?, aksi ini tidak bisa di batalkan ketika di klik OK')">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a>
                                                </li>
                                        </ul>
                                    </div><!--//dropdown-->
                                </div><!--//app-card-actions-->
                            </div><!--//app-card-body-->
                        </div><!--//app-card-->
                    </div><!--//col-->
                   @endforeach
                </div><!--//row-->
                <form id="arrNotIn" style="display: none;">
                    @foreach($notArr as $vf)
                        <input type="hidden" name="arr[]" value="{{$vf}}">
                    @endforeach
                </form>
                @if($request->namefile != null)
                     <p align="center">
                        <br>
                        <b>Menampilkan hasil filter nama file {{$request->namefile}} {{count($notArr)}} Hasil</b>
                    </p>
                @elseif($request->diupload != null)
                    <p align="center">
                        <br>
                        <b>Menampilkan hasil filter tanggal upload file  {{\Carbon\Carbon::parse($request->diupload)->format('d F Y')}} {{count($notArr)}} Hasil</b>
                    </p>
                @else
                <nav class="app-pagination mt-5">
                    @if(!$files->isEmpty())
                    <p align="center" id="load-more-btn">
                        <button onclick="lebihBanyak()" type="button" class="btn app-btn-secondary">Tamppilkan Lebih Banyak</button>
                    </p>
                    <p align="center" id="tunggu-load-more" style="display: none;">
                         <small>
                            <b style="color: black;">Proses memuat mohon tunggu ... </b>
                        </small>
                    </p>
                     <p align="center" id="semua-load-more" style="display: none;">
                         <button  type="button" class="btn app-btn-secondary">Semua File Sudah Di Tampilkan</button>
                    </p>
                    @endif
                </nav><!--//app-pagination-->
                @endif
            </div><!--//container-fluid-->
        </div><!--//app-content-->
    <script>
        $('#simpan-file').on('change',function(){
           $('#upload-file-btn').hide();
           $('#tunggu-upload').show();
           $('#post-file').submit();
        })
        function removeAlert() {
            $('#alert-beh').remove();
        }

        function lebihBanyak()
        {
                    $('#load-more-btn').hide();
                    $('#tunggu-load-more').show();
                     var CSRF_TOKEN = "{{ csrf_token() }}";
                      $.ajaxSetup({
                          headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                          }
                      });
                      var formData = new FormData(document.getElementById("arrNotIn"));
                      $.ajax({
                          url: "{{url('file-manager-load-more')}}",  
                          type: 'POST',
                          data: formData,
                        success:function(data){
                          if(data.banyak > 0)
                          {
                            $('#arrNotIn').empty();
                            $('#arrNotIn').append(data.arr);
                            $('#appendFile').append(data.html);
                            $('#load-more-btn').show();
                            $('#tunggu-load-more').hide();
                          }else{
                            $('#load-more-btn').hide();
                            $('#tunggu-load-more').hide();
                            $('#semua-load-more').show();
                          }
                          
                        },
                        error: function(data){
                          $('#load-more-btn').show();
                          $('#tunggu-load-more').hide();
                          alert(data.responseJSON.message);
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                      });
        }
    </script>
</x-layout-dashboard>