<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Installation System Requirement</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="shortcut icon" href="new/assets/images/favicon-32x32.png"> 
    
    <!-- FontAwesome JS-->
    <script defer src="new/assets/plugins/fontawesome/js/all.min.js"></script>
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="new/assets/css/portal.css">

</head> 

<body class="app app-404-page">   	
   
    <div class="container mb-5">
    	<div class="app-branding text-center mb-5">
		</div><!--//app-branding--> 
		
		    <div class="row">
			    <div class="col-md-4">
				    <div class="app-card p-5 text-center shadow-sm">
					    <p align="center">Requirement</p>
					    <p align="center">Pastikan spesifikasi server anda  memenuhi kebutuhan system dibawah ini, demi kelancaran system</p>
					    <table class="ui celled table">
							<tbody>
								<tr>
									<td class="six column wide">{{ __('PHP') }}</td>
									<td>>= {{ $requirements['php']['version'] }}</td>
								</tr>
								<tr>
									<td class="six column wide">{{ __('MySQL') }}</td>
									<td>>= {{ $requirements['mysql']['version'] }}</td>
								</tr>
								<tr>
									<td class="six column wide">{{ __('No Js') }}</td>
									<td>>= 13</td>
								</tr>
								</tbody>
						</table>

						<table class="ui celled table">
							<thead>
								<tr>
									<th>{{ __('PHP Extension') }}</th>
									<th class="center aligned">{{ __('Enabled') }}</th>
								</tr>
							</thead>
							<tbody>
							@foreach($requirements['php_extensions'] as $name => $enabled)
							<tr>
								<td>{{ ucfirst($name) }}</td>
								<td class="center aligned">
									{!! $enabled ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>' !!}
								</td>
							</tr>
							@endforeach
							</tbody>
					</table>
				 </div>
			    </div><!--//col-->
			    <div class="col-md-4">
			    	<form class="auth-form login-form" method="POST" action="{{url('settings/check_database_connection')}}">
			    		@csrf
				    <div class="app-card p-5 text-center shadow-sm">
					   <p align="center">Database Setting</p>   
					    @if($message=Session::get('success'))
                        <div class="alert bg-teal" role="alert">
                           <p align="center" style="color: green">  <em class="fa fa-lg fa-check">&nbsp;</em>  {{$message}}</p>
                        </div>
                    	@endif 
                    	@if($message=Session::get('error'))
                        <div class="alert bg-teal" role="alert">
                           <p align="center" style="color: red">  <em class="fa fa-lg fa-close">&nbsp;</em>  {{$message}}</p>
                        </div>
                    	@endif    
							<div class="email mb-3">
								<input id="host" name="host" type="text" class="form-control signin-email" placeholder="Host" required="required" value="{{ Session::get('host') }}">
							</div><!--//form-group-->
							<div class="email mb-3">
								<input id="port" name="port" type="text" class="form-control signin-email" placeholder="Port" required="required" value="{{ Session::get('port') }}">
							</div><!--//form-group-->
							<div class="email mb-3">
								<input id="username" name="username" type="text" class="form-control signin-email" placeholder="Username" required="required" value="{{ Session::get('username') }}">
							</div><!--//form-group-->
							<div class="email mb-3">
								<input id="password" name="password" type="text" class="form-control signin-email" placeholder="Password" value="{{ Session::get('password') }}" >
							</div><!--//form-group-->
							<div class="email mb-3">
								<input id="name" name="name" type="text" class="form-control signin-email" placeholder="Nama Database" required="required" value="{{ Session::get('name') }}">
							</div><!--//form-group-->
							<div class="text-center">
								<button type="submit" id="db_konek" class="btn app-btn-primary w-100 theme-btn mx-auto">Cek Koneksi</button>
							</div>
				    </div>
				 </form>
			    </div><!--//col-->
			    <div class="col-md-4">
			    	<div class="app-card p-5 text-center shadow-sm">
					   <p align="center">Node Wa Server</p>      
							<div class="email mb-3">
								<input  id="url_node" type="text" class="form-control signin-email" placeholder="Url Node Server" value="{{ Session::get('url_node') }}">
							</div><!--//form-group-->
							<div class="email mb-3">
								<input  id="port_node" value="{{ Session::get('port_node') == NULL?'3000': Session::get('port_node')}}" type="text" class="form-control signin-email" placeholder="Port Node Server">
							</div><!--//form-group-->
							<div class="text-center">
								<button type="button" onclick="checkNode()" id="node_konek" class="btn app-btn-primary w-100 theme-btn mx-auto">Cek Koneksi</button>
								<p align="center" id="jalan_node_cek" style="display: none;">Proses pengecekan berjalan .. Mohon Tunggu!</p>
								<div id="hasil_node">
									
								</div>
							</div>
				    </div>
				    <div class="app-card p-5 text-center shadow-sm">
							<div class="text-center">
							<p align="center">Admin Setting Login</p>      
							</div>
							 
							<div class="email mb-3">
								<input id="email_admin" name="email_admin" type="text" class="form-control signin-email" placeholder="Email" required="required" value="{{ Session::get('email_admin') }}">
							</div><!--//form-group-->
							<div class="email mb-3">
								<input id="username_admin" name="username_admin" type="text" class="form-control signin-email" placeholder="Username" required="required" value="{{ Session::get('username_admin') }}">
							</div><!--//form-group-->
							<div class="email mb-3">
								<label class="sr-only" for="signin-email">Password</label>
								<input id="password_admin" name="password_admin" type="text" class="form-control signin-email" placeholder="Password" required="required" value="{{ Session::get('password_admin') }}">
							</div><!--//form-group-->
							<div class="text-center">
								<button type="button" onclick="installSekarang()" class="btn app-btn-primary w-100 theme-btn mx-auto">Install Sekarang</button>
								<p align="center" id="jalan" style="display: none;">Proses instalasi berjalan .. Mohon Tunggu!</p>
							</div>
				    </div>
			    </div><!--//col-->
		    </div><!--//row-->
		
    </div><!--//container-->

    <!-- Javascript -->          
    <script src="new/assets/plugins/popper.min.js"></script>
    <script src="new/assets/plugins/bootstrap/js/bootstrap.min.js"></script>  
    <!-- Charts JS -->
    <script src="new/assets/plugins/chart.js/chart.min.js"></script> 
   
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript">
    	function installSekarang() {
    		var url_node = $('#url_node').val();
            var port_node = $('#port_node').val();
            var host = $('#host').val();
            var port = $('#port').val();
            var password = $('#password').val();
            var name = $('#name').val();
            var username = $('#username').val();
            var email_admin = $('#email_admin').val();
            var password_admin = $('#password_admin').val();
            var username_admin = $('#username_admin').val();
            if(url_node == '')
            {
            	alert('Harap isi url node');
            }else{
            	if(port_node == '')
            	{
            		alert('Harap isi port node');
            	}else{
            		if(host == '')
            		{
            			alert('Harap isi port node');
            		}else{
            			if(port == '')
            			{
            				alert('Harap isi port node');
            			}else{
            				//if(password == '')
            				//{
            					//alert('Harap isi password databaa');
            				//}else{
            					if(name == '')
            					{
            						alert('Harap isi nama database');
            					}else{
            						if(username == '')
            						{
            							alert('Harap isi username database');
            						}else{
            							if(email_admin == '')
            							{
            								alert('Harap isi email admin');
            							}else{
            								if(username_admin == '')
            								{
            									alert('Harap isi username admin');
            								}else{
            									if(password_admin == '')
            									{
            										alert('Harap isi password admin');
            									}else{	
            										$('#db_konek').hide();
											    	$('#node_konek').hide();
											        $('#jalan').show();
											            var CSRF_TOKEN = "{{ csrf_token() }}";
											              $.ajaxSetup({
											                  headers: {
											                    'X-CSRF-TOKEN': CSRF_TOKEN
											                  }
											              });
											              var formData = new FormData();
											              formData.append('url_node', url_node);
											              formData.append('port_node', port_node);
											              formData.append('host', host);
											              formData.append('username', username);
											              formData.append('name', name);
											              formData.append('port', port);
											              formData.append('password', password);
											              formData.append('email_admin', email_admin);
											              formData.append('username_admin', username_admin);
											              formData.append('password_admin', password_admin);
											              $.ajax({
											                  url: "{{url('install_apps_final')}}",  
											                  type: 'POST',
											                  data: formData,
											                success:function(data){
											                	alert(data.data);
											                	window.location.href ="{{url('home')}}";
											                },
											                error: function(data){
											                  alert(data.responseJSON.message);
											                  $('#db_konek').show();
												    		  $('#node_konek').show();
												              $('#jalan').hide();
											                },
											                cache: false,
											                contentType: false,
											                processData: false
											              });
											    	
            									}	
            								}
            							}
            						}
            					}
            				//}
            			}
            		}
            	}
            }
    	}

    	function checkNode() {
    		
            var url_node = $('#url_node').val();
            var port_node = $('#port_node').val();
            if(url_node == '')
            {
            	alert('Harap isi url node');
            }else{
            	if(port_node == '')
            	{
            		alert('Harap isi port node');
            	}else{
            		$('#db_konek').hide();
    				$('#node_konek').hide();
    				$('#jalan_node_cek').show();
    				$('#hasil_node').empty();
            		 var CSRF_TOKEN = "{{ csrf_token() }}";
		              $.ajaxSetup({
		                  headers: {
		                    'X-CSRF-TOKEN': CSRF_TOKEN
		                  }
		              });
		              var formData = new FormData();
		              formData.append('url_node', url_node);
		              formData.append('port_node', port_node);
		              $.ajax({
		                  url: "{{url('settings/check_node_port')}}",  
		                  type: 'POST',
		                  data: formData,
		                success:function(data){
		                   $('#db_konek').show();
    					  $('#node_konek').show();
    					  $('#jalan_node_cek').hide();
		                   var html = `<div class="alert bg-teal" role="alert">
			                           <p align="center" style="color: `+data.color+`">
			                           `+data.data+`
			                           </p>
			                        </div>`;
			        		$('#hasil_node').append(html);
		                    //console.log(data.html);
		                },
		                error: function(data){
		                  $('#db_konek').show();
    					  $('#node_konek').show();
    					  $('#jalan_node_cek').hide();
		                  alert(data.responseJSON.message);
		                },
		                cache: false,
		                contentType: false,
		                processData: false
		              });
            	}
            }
    	}
    	    
    </script>
</body>
</html> 

