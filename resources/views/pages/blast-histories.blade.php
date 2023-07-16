<x-layout-dashboard title="Auto Replies">
  
    <div class="app-content">
        <link href="{{asset('plugins/datatables/datatables.min.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/select2/css/select2.css')}}" rel="stylesheet">
{{--        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">--}}
{{--        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">--}}
        <link href="{{asset('css/custom.css')}}" rel="stylesheet">
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
               
           
                
    
<div class="row mt-4">
  <div class="col">
      <div class="card">
          <div class="card-header d-flex justify-content-between">
          <h5 class="card-title">Histories</h5>

         
             
          </div>
          <div class="card-body">
              <table id="datatable1" class="display" style="width:100%">
                  <thead>
                      <tr>
                          <th>Nama Group / Campaign</th>
                          <th>Nama</th>
                          <th>Type Kendaraan</th>
                          <th>KM</th>
                          <th>Receiver</th>
                          <th>Aktif</th>
                          <th>Status</th>
                        <th>Last Update</th>
                          {{-- <th class="d-flex justify-content-center">Action</th> --}}
                      </tr>
                  </thead>
                  <tbody>
                     @foreach ($histories as $history)
                         
                     <tr>
                        <td>{{$history->campaings->name ?? ''}}</td>
                        <td>{{$history->nomers->name ?? ''}}</td>
                        <td>{{$history->nomers->deskripsi ?? ''}}</td>
                        <td>{{$history->nomers->KM ?? ''}}</td>
                        <td>{{$history->receiver}}</td>
                        <td>
                           Aktif
                        </td>
                        <td>
                            @php
                                if($history->status == 'pending')
                                {
                                    echo '<span class="badge badge-warning">Pending</span>';
                                }
                                elseif($history->status == 'success')
                                {
                                    echo '<span class="badge badge-success">Success</span>';
                                }
                                elseif($history->status == 'failed')
                                {
                                    echo '<span class="badge badge-danger">Failed</span>';
                                }
                            @endphp
                            </td>

                        <td>{{$history->updated_at}}</td>
                       
                      </tr>
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



        <script src="{{asset('js/pages/datatables.js')}}"></script>
    <script src="{{asset('js/pages/select2.js')}}"></script>
    <script src="{{asset('plugins/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
  <script src="{{asset('js/autoreply.js')}}"></script>
{{--    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>--}}
{{----}}
{{--    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>--}}
{{----}}
{{--    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>--}}

</x-layout-dashboard>





