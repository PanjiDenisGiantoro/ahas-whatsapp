<x-layout-auth>
    @slot('title','Daftar Akun System')
    @slot('header','AWASS')
     <div class="row g-0 app-auth-wrapper" >
        <div class="col-12 col-md-7 col-lg-4 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto"> 
                    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"><img class="logo-icon me-2" 
                       src="new/assets/images/favicon-32x32.png" alt="logo"></a></div>
                    <h2 class="auth-heading text-center mb-5">Daftar Akun System</h2>
                    <div class="auth-form-container text-start">
                        <form class="auth-form login-form" action="{{url('register')}}" method="POST">
                        @csrf  
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
                                <label class="sr-only" for="username">Email</label>
                                <input id="email" name="email" type="text" class="form-control signin-email" 
                                placeholder="Email" required="required">
                            </div><!--//form-group-->
                            <div class="email mb-3">
                                <label class="sr-only" for="username">Username</label>
                                <input id="username" name="username" type="text" class="form-control signin-email" 
                                placeholder="Username" required="required">
                            </div><!--//form-group-->
                            <div class="password mb-3">
                                <label class="sr-only" for="password">Password</label>
                                <input id="password" name="password" type="password" class="form-control signin-password" placeholder="Password" required="required">
                            </div><!--//form-group-->
                            <div class="text-center">
                                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Daftar</button>
                            </div>
                        </form>
                        
                        <div class="auth-option text-center pt-5">Sudah punya akun? Login<a class="text-link" href="{{url('login')}}" > Disini</a>.</div>
                    </div><!--//auth-form-container-->  

                </div><!--//auth-body-->
            
                <footer class="app-auth-footer">
                    <div class="container text-center py-3">
                         <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
                       
                    </div>
                </footer><!--//app-auth-footer-->   
            </div><!--//flex-column-->   
        </div><!--//auth-main-col-->
        <div class="col-12 col-md-8 h-100 auth-background-col" style="background-color: #44cb94;">
            <div class="auth-background-holder" style="background-image: url('new/assets/images/back.png');
                                                       background-size: contain;
                                                       height: 100vh;
                                                       min-width: 500px;
                                                       min-height: 100%"   >
            </div>
            <div class="auth-background-mask"></div>
        </div><!--//auth-background-col-->
    
    </div><!--//row-->
</x-layout-auth>