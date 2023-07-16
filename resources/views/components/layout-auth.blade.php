<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>{{ $title }} | {{$header}}</title> 
    
    <!-- Meta -->
      <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
    <link rel="shortcut icon" href="new/assets/images/favicon-32x32.png"> 
    
    <!-- FontAwesome JS-->
    <script defer src="new/assets/plugins/fontawesome/js/all.min.js"></script>
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="new/assets/css/portal.css">

</head> 

<body class="app app-login p-0">    
{{$slot}}

</body>

    <script src="{{asset('plugins/jquery/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/perfectscroll/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('plugins/pace/pace.min.js')}}"></script>
<script src="{{asset('js/main.min.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
</body>
</html>