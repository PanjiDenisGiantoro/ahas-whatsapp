<x-layout-dashboard title="Auto Replies">
  
    <div class="app-content">
        <link href="{{asset('plugins/datatables/datatables.min.css')}}" rel="stylesheet">

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
          <h5 class="card-title">Switch Device Schema</h5>

         
            <button type="button" class="btn btn-primary  btn-sm" onclick="addSds()" >
                Add New
            </button>
          </div>
          <div class="card-body">
              <table id="datatable1" class="display" style="width:100%">
                  <thead>
                      <tr>
                          <th>Number</th>
                          <th>Kuota Switch On</th>
                          <th>Number To Siwtch</th>
                          <th>Status</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                    <tbody>
                         @foreach ($data as $key => $item)    
                         <tr>
                            <td>{{$item['number']}} : ({{$item['status_number']}})</td>
                            <td>{{$item['kuota']}}</td>
                            <td>{{$item['child_number']}} : {{$item['child_status']}}</td>
                            <td>
                                @if($item['status_switch'] == 'enable')
                                    <span class="badge badge-success">Enable</span>
                                @else
                                     <span class="badge badge-danger">Disable</span>
                                @endif
                            </td>

                            <td class="d-flex justify-content-center">
                                <button type="button" class="btn btn-primary btn-sm" onclick="editSds({{$item['id']}})">
                                    Edit
                                </button>
                                 <button type="button" class="btn btn-warning btn-sm" onclick="detailSds({{$item['id']}})">
                                    Detail
                                </button>
                                <form action="{{url('admin_switch_device_delete/'.$item['id'])}}" 
                                    onsubmit="return confirm('Are you sure will delete this schema ? all data schema also will deleted')">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- modal edit -->
                        <div class="modal fade" id="modalSds_edit_{{$item['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel_edit_{{$item['id']}}"></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{url('admin_switch_device_update/'.$item['id'])}}" method="POST" enctype="multipart/form-data" id="formUser">
                                            @csrf
                                            <label for="active_subscription" class="form-label">Number</label><br>
                                                <select name="number_id" required id="active_subscription" class="form-control">
                                                    @foreach($numbersEdit as $keySelected => $itemSelected)
                                                        <option value="{{$itemSelected->id}}" 
                                                              {{$itemSelected->id == $item['number_id'] ? 'selected':''}}>
                                                            {{$itemSelected->body}} : ({{$itemSelected->status}})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            <label for="limit_device" class="form-label">Kuota On Switch</label>
                                                <input type="number" name="kuota" required id="limit_device" class="form-control" value="{{$item['kuota']}}">
                                             <label for="active_subscription" class="form-label">Number To Switch</label><br>
                                                <select name="number_id_parent" required id="active_subscription" class="form-control">
                                                    @foreach($numbersEdit as $keySelected => $itemSelected)
                                                        <option value="{{$itemSelected->id}}" 
                                                              {{$itemSelected->id == $item['id_child'] ? 'selected':''}}>
                                                            {{$itemSelected->body}} : ({{$itemSelected->status}})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            <label for="active_subscription" class="form-label">Status</label><br>
                                                <select name="status" required id="active_subscription" class="form-control">
                                                    <option value="enable" {{$item['status_switch'] == 'enable' ? 'selected':''}}>Enable</option>
                                                    <option value="disable" {{$item['status_switch'] == 'disable' ? 'selected':''}}>Disable</option>
                                                </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" id="modalButton_edit_{{$item['id']}}" name="submit" class="btn btn-primary">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal edit -->
                        <!-- modal detail -->
                        <div class="modal fade" id="modalSds_detail_{{$item['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel_detail_{{$item['id']}}"></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if(!empty($log))
                                        @foreach($log[$item['id']] as $keyLog => $itemLog)
                                            <p>Campaign : {{$itemLog['campaign_name']}}</p>
                                            <p>Total Sent : {{$itemLog['total']}}</p>
                                        @endforeach
                                        @else
                                        <p>Belum ada log!</p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal detail -->
                        @endforeach
                
                  <tfoot></tfoot>
              </table>
          </div>
      </div>
  </div>

</div>


<!-- Modal Add -->
<div class="modal fade" id="modalSds_add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel_add"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{url('admin_switch_device_store')}}" method="POST" enctype="multipart/form-data" id="formUser">
                    @csrf
                    <label for="active_subscription" class="form-label">Number</label><br>
                        <select name="number_id" required id="active_subscription" class="form-control">
                            @foreach($numbers as $key => $item)
                                <option value="{{$item->id}}">{{$item->body}} : ({{$item->status}})</option>
                            @endforeach
                        </select>
                    <label for="limit_device" class="form-label">Kuota On Switch</label>
                        <input type="number" required name="kuota" id="limit_device" class="form-control" value="">
                    <label for="active_subscription" class="form-label">Number To Switch</label><br>
                        <select name="number_id_parent" required id="active_subscription" class="form-control">
                            @foreach($numbers as $key => $item)
                                <option value="{{$item->id}}">{{$item->body}} : ({{$item->status}})</option>
                            @endforeach
                        </select>
                    <label for="active_subscription" required class="form-label">Status</label><br>
                        <select name="status" id="active_subscription" class="form-control">
                            <option value="enable">Enable</option>
                            <option value="disable">Disable</option>
                        </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="modalButton_add" name="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
    
<!--             </div>
        </div>
    </div> -->



    <script src="{{asset('js/pages/datatables.js')}}"></script>
  
    <script src="{{asset('plugins/datatables/datatables.min.js')}}"></script>

 
    <script>
       function addSds()
       {
            $('#modalLabel_add').html('Add Switch Device Schema');
            $('#modalButton_add').html('Add');
            $('#modalSds_add').modal('show');
       }

       function editSds(id)
       {
            $('#modalLabel_edit_'+id).html('Edit Switch Device Schema');
            $('#modalButton_edit_'+id).html('Edit');
            $('#modalSds_edit_'+id).modal('show');
       }

       function detailSds(id)
       {
            $('#modalLabel_detail_'+id).html('Detail Log Switch Device Schema');
            //$('#modalButton_detail_'+id).html('Edit');
            $('#modalSds_detail_'+id).modal('show');
       }
    </script>
</x-layout-dashboard>





