<x-layout-auth>
    @slot('title','AWASS')
{{--    @slot('header','Ahass WhatsApp Sender System')--}}
    @slot('header','a WhatsApp Sender System')
     <div class="row g-0 app-auth-wrapper" >
        <div class="col-12 col-md-7 col-lg-4 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto"> 
                    <!--<div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"><img class="logo-icon me-2"-->
                    <!--   src="images/awass-title.png" alt="logo"></a></div>-->
                    <h2 class="auth-heading text-center mb-3">AWASS</h2>
                    <p class="text-center mb-4">A WHATSAPP SENDER SYSTEM</p>
                    <div class="auth-form-container text-start">
                        <form class="auth-form login-form" action="{{url('login')}}" method="POST">
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
                                <input id="username" name="username" type="text" class="form-control signin-email" 
                                placeholder="Email Or Username" required="required">
                            </div><!--//form-group-->
                            <div class="password mb-3">
                                <label class="sr-only" for="password">Password</label>
                                <input id="password" name="password" type="password" class="form-control signin-password" placeholder="Password" required="required">
                                <!-- <div class="extra mt-3 row justify-content-between">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="RememberPassword">
                                            <label class="form-check-label" for="RememberPassword">
                                            Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="forgot-password text-end">
                                            <a href="reset-password.html">Forgot password?</a>
                                        </div>
                                    </div>
                                </div> -->
                            </div><!--//form-group-->
                            <div class="text-center">
                                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Masuk</button>
                            </div>
                        </form>
                        
{{--                        <div class="auth-option text-center pt-5">Belum punya akun? Daftar<a class="text-link" href="{{url('register')}}" > Disini</a>.</div>--}}
                    </div><!--//auth-form-container-->  

                </div><!--//auth-body-->
            
                <footer class="app-auth-footer">
                    <div class="container text-center py-3">
                         <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
{{--                  <small class="copyright">Designed with <span class="sr-only">code</span><i class="fas fa-code" style="color: #fb866a;"></i> by <a class="app-link" href="#" target="_blank">AWASS</a> ITC</small> --}}
                       
                    </div>
                </footer><!--//app-auth-footer-->   
            </div><!--//flex-column-->   
        </div><!--//auth-main-col-->
        <div class="col-12 col-md-8 h-100 auth-background-col" style="background-color: #004AAD;">
            <div class="auth-background-mask"></div>
            <div class="auth-background-overlay p-3 ">
                <div class="d-flex flex-column align-content-end h-100">
                    <div class="h-100"
{{--                    image --}}
                    style="background-image: url('images/awass.png'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
                    </div>
                </div>
            </div><!--//auth-background-overlay-->
        </div><!--//auth-background-col-->

    </div><!--//row-->
</x-layout-auth>