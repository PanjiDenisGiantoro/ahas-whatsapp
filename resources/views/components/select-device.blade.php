<select class="form-control" id="device_idd" name="device_id" style="font-size: 12px;">
        <option value="" >Pilih Prangkat</option>
        @php $aktif = '' @endphp
        @foreach ($numbers as $device)
            @if(Session::has('selectedDevice') && Session::get('selectedDevice') == $device->body)
            <option value="{{$device->body}}" selected s>
                {{$device->body}} ({{$device->status == 'Connected'?'online':'offline'}})
            @php $aktif = $device->body.' '.'('.$device->status.')' @endphp
            </option>
            @else
            <option value="{{$device->body}}">
                {{$device->body}} ({{$device->status}})
            </option>
            @endif
        @endforeach
</select>                                                 
<script>
    //  on select device
    $('#device_idd').on('change', function() {
        var device = $(this).val();
      
        // ajax to home.setSessionSelectedDevice
        $.ajax({
            url: "{{route('home.setSessionSelectedDevice')}}",
            type: "POST",
            data: {
                _token: "{{csrf_token()}}",
                device: device
            },
            success: function(data) {
                // reload page
                location.reload();
            }
        });
      
    });
</script>