

<div class="app align-content-stretch d-flex flex-wrap" style="padding-top: 0;">

    <div class="app-sidebar">

        <div class="logo">
            <!--  <a href="{{route('home')}}" class="logo-icon" style="background-image: url('new/assets/images/wanojsmain.png');"></a> -->
            <div class="">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: black;">
                    <span class="logo-text">Keluar</span>
                    <i class="fa fa-sign-out"></i>                   
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" style="display: none;">
                    @csrf
                </form>
                <br>
                <span class="logo-text">Masuk sebagai : {{Auth::user()->username}}</span>
                <i class="fa fa-user"></i>
            </div>
        </div>

        <div class="app-menu">
            <ul class="accordion-menu">
                <li class="sidebar-title">
                    Menu
                </li>

                <li class="{{request()->is('home') ? 'active-page' : ''}}">
                    <a href="{{route('home')}}" class=""><i class="fa fa-dashboard" style="color: black;"></i>Beranda</a>
                </li>

                <li class="{{request()->is('device') ? 'active-page' : ''}}">
                    <a href="{{route('device')}}" class=""><i class="fa fa-user" style="color: black;"></i>Device</a>
                </li>

                @if(Session::has('selectedDevice'))

                    <li class="{{request()->is('g.i') ? 'active-page' : ''}}">
                        <a href="{{route('g.i')}}" class=""><i class="fa fa-dashboard" style="color: black;"></i>Greeting</a>
                    </li>

                    <li class="{{request()->is('tag') ? 'active-page' : ''}}">
                        <a href="{{route('tag')}}"><i class="fa fa-address-book-o"></i>Kontak</a>
                    </li>
                    {{-- <li class="{{request()->is('cron') ? 'active-page' : ''}}">
                        <a href="{{route('campaign.cron')}}" class=""><i class="fa fa-file"></i>Otomatis Pesan</a>
                    </li> --}}
                    <li class="{{request()->is('campaign/create') ? 'active-page' : ''}}">
                        <a href="{{route('campaign.create')}}" class=""><i class="fa fa-bullhorn"></i>Blast Message</a>
                    </li>

                    <li class="{{request()->is('campaigns') ? 'active-page' : ''}}">
                        <a href="{{route('campaign.lists')}}" class=""><i class="fa fa-list"></i>History Message</a>
                    </li>

                    <li class="{{request()->is('message/test') ? 'active-page' : ''}}">
                        <a href="{{route('messagetest')}}" class=""><i class="fa fa-paper-plane"></i>Single Message</a>
                    </li>

                @endif
                
                {{-- <li class="{{request()->is('g.i') ? 'active-page' : ''}}">
                    <a href="{{route('g.i')}}" class=""><i class="fa fa-dashboard" style="color: black;"></i>Greeting</a>
                </li> --}}



                {{-- <li class="{{request()->is('rest-api') ? 'active-page' : ''}}">
                    <a href="{{route('rest-api')}}"><i class="fa fa-globe"></i>Integrasi API</a>
                </li> --}}
                
                {{-- <li class="{{request()->is('user/change-password') ? 'active-page' : ''}}">
                    <a href="{{route('changePassword')}}"><i class="fa fa-cog"></i>Pengaturan</a>
                </li> --}}

                {{-- <li class="{{request()->is('admin_switch_devie') ? 'active-page' : ''}}">
                    <a href="{{url('admin_switch_devie')}}"><i class="fa fa-exchange"></i>Switch Device</a>
                </li> --}}

                <li class="{{request()->is('t.i') ? 'active-page' : ''}}">
                    <a href="{{route('t.i')}}" class=""><i class="fa fa-dashboard" style="color: black;"></i>Template Pesan</a>
                </li>

                <li class="{{request()->is('autoreply') ? 'active-page' : ''}}">
                    <a href="{{route('autoreply')}}" class=""><i class="fa fa-reply"></i>{{__('system.autoreply')}}</a>
                </li>

                <li class="{{request()->is('file-manager') ? 'active-page' : ''}}">
                    <a href="{{route('file-manager')}}" class=""><i class="fa fa-file"></i>Penyimpanan Berkas</a>
                </li>

                @if(Auth::user()->level == 'admin')
                    <li class="sidebar-title">
                        Administrator
                    </li>

                    <li class="{{request()->is('admin/manage-user') ? 'active-page' : ''}}">
                        <a href="{{route('admin.manageUser')}}"><i class="fa fa-users"></i>Pengaturan Pengguna</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="app-container">
        <div class="search">
            <form>
                <input class="form-control" type="text" placeholder="Type here..." aria-label="Search">
            </form>
            <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
        </div>

        <!-- <div class="app-header" > -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card widget widget-stats">
                    <div class="card-body">
                        <div class="widget-stats-container d-flex">
                            <div class="widget-stats-icon widget-stats-icon-primary">
                                <i class="fa fa-calendar"></i>
                            </div>
                            
                            <div class="widget-stats-content flex-fill">
                                <span class="widget-stats-title">Status Langganan :</span>
                                <span class="widget-stats-amount"></span>
                                <p style="color: {{Auth::user()->is_expired_subscription ? 'red' : 'green'}};">{{Auth::user()->expired_subscription}}
                            </div>

                            <div class="widget-stats-icon widget-stats-icon-primary">
                                <i class="fa fa-bell"></i>
                            </div>
                            
                            <div class="widget-stats-content flex-fill">
                                <span class="widget-stats-title">Notifikasi : </span>
                                <span class="widget-stats-amount"></span>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($message=Session::get('success') || $message=Session::get('error'))
                <div class="col-sm-12" id="alert-beh">
                    <div class="card widget widget-stats">
                        <div class="card-body" style="padding-top: 50px; background-color: #dff0fe;background-clip: , padding-box;">
                            <p align="right"><a style="cursor: pointer;color: white;" onclick="removeAlert();" class="btn btn-danger btn-sm">Tutup <em class="fa fa-lg fa-close"></em></a></p>
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-primary">
                                    <i class="fa fa-bell"></i>
                                </div>
                                
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Pemberitahuan : </span>
                                    <span class="widget-stats-amount"></span>
                                    @if($message=Session::get('success'))
                                        <div class="alert alert-success alert-style-light mt-2" role="alert">
                                            <p align="center" style="color: black">  <em style="color: green;" class="fa fa-lg fa-check">&nbsp;</em>  {{$message}}</p>
                                        </div>
                                    @endif 

                                    @if($message=Session::get('error'))
                                        <div class="alert alert-error alert-style-light mt-2" role="alert">
                                            <p align="center" style="color: black;">  <em style="color: red" class="fa fa-lg fa-close">&nbsp;</em>  {{$message}}</p>
                                        </div>
                                    @endif  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>