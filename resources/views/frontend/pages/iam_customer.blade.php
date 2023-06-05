@extends('frontend.layouts.app')
@section('content')

<section class="sign_up">
<div class="container">
<div class="row">
<div class="col-md-8 mx-auto">
<div class="row">
<!--<div class="col-md-6 sign_up_content">
<h3>Welcome Back!</h3>
<h5>Login to continue.</h5>
<div style="text-align:center">
<img src="{!! asset('assets/frontend/images/Artboard_158.png')  !!}" style="padding-bottom: 20px; max-width: 300px;" class="img-responsive">
</div>
</div> -->
<div class="col-md-3"></div>
<div class="col-md-6 sign_up_field" style="padding-bottom: 50px;">
<!-- <a href="{{ route('home') }}"><img src="{!! asset('assets/frontend/images/cross.png') !!}" class="home-cross"></a> -->
<a href="{{ route('home') }}" style="text-align: center; display: block; padding-top: 45px;"><img style="max-height: 70px;" src="{!! asset('assets/frontend/images/lnxx_logo.svg')  !!}" alt="logo" class="img-responsive"> </a>

<h3 style="margin-top: 50px; margin-bottom: 15px;">I am customer</h3>
<a href="{{ route('sign-in') }}">	
<div class="con-box">
<h4 style="font-weight: normal; font-size: 19px; margin-bottom: 11px;">Existing customer login</h4>
<a class="con_btn" href="{{ route('sign-in') }}">
<img src="{!! asset('assets/frontend/images/rectangle.png')  !!}" class="pre_hover">
<img src="{!! asset('assets/frontend/images/Rectangle_right.png')  !!}" class="af_hover">
</a>
</div>
</a>


<a href="{{ route('sign_up') }}">	
<div class="con-box" style="margin-top: 25px;">
<h4 style="font-weight: normal; font-size: 19px; margin-bottom: 11px;">Create new account</h4>
<a class="con_btn" href="{{ route('sign_up') }}">
<img src="{!! asset('assets/frontend/images/rectangle.png')  !!}" class="pre_hover">
<img src="{!! asset('assets/frontend/images/Rectangle_right.png')  !!}" class="af_hover">
</a>
</div>
</a>

<!-- <form action="{{ route('enter-login-otp') }}" method="post">
{{ csrf_field() }}	
<div class="form-group mob_input">
	<input type="text" class="form-control" required="true" placeholder="Enter Mobile / Email" name="username">
	<img src="{!! asset('assets/frontend/images/mobile_register.png')  !!}" alt="logo" class="input-img">
	@if($errors->has('username'))
       <span class="text-danger">{{$errors->first('username')}}</span>
    @endif 
</div>

<div class="btn-box" style="text-align: center;">
<button class="btn">Sign In</button>
<p style="margin-bottom: 0px; margin-top: 15px;">Or</p>
<p><a style="margin-top: 10px;" href="{{ route('sign_up') }}">Create New Account</a></p>
</div>
</form> -->


<!-- <form action="{{ route('enter-login-otp') }}" id="enter-login-otp" method="post">
{{ csrf_field() }}	
<div class="form-group mob_input">
	<input id="phone" type="number" class="form-control" required="true" placeholder="Enter mobile number*" name="username" style="padding-left: 55px;">
	<span style="position: absolute; top: 12px; font-size: 14px; left: 20px;">+971</span>
	<img src="{!! asset('assets/frontend/images/mobile_register.png') !!}" alt="logo" class="input-img">
	@if($errors->has('username'))
       <span class="text-danger">{{$errors->first('username')}}</span>
    @endif 
    <div class="already_exist" style="color: #f00; font-size: 12px; padding-top: 2px;"></div>
    <div class="valid_no" style="color: #f00;"> Enter your 9-digit mobile number-otp </div>
    <div id="recaptha-container" style="margin-top: 12px;"></div>
    <input type="hidden" name="verify" value="0" id="verify">
<div id="sentMessage" style="color: green;font-size: 12px; padding-top: 2px;display: none;"></div>
<div id="sucessMessage" style="color: green;font-size: 12px;padding-top: 2px;display: none;"></div>
</div>
<div class="form-group mob_input otp_field" style="margin-top: 25px; display: none;">
	<input type="number" class="form-control" required="true" id="number-otp" maxlength="6" placeholder="Enter OTP*" name="otp">
	<img src="{!! asset('assets/frontend/images/otp.png')  !!}" alt="logo" class="input-img">
	<div class="otp_lab">Please enter the OTP sent on your mobile number</div>
	<div class="not_verify" style="color: #f00; font-size: 12px; padding-top: 2px;"></div>
	<div class="otp_verify" style="color: green; font-size: 12px; padding-top: 2px;"></div>
    <div id="error" style="color: #f00;font-size: 12px; padding-top: 2px;display: none;"></div>
	@if(session()->has('otp_not_match'))
	<div class="errors_otp" style="color: #f00; font-size: 12px; padding-top: 2px;">Invalid OTP</div>
	@endif
</div>
<div class="btn-box" style="text-align: center;">
<a class="btn enter-login-otp" style="color: #fff;width: 138px; margin: 0 auto; cursor: pointer;" onclick="sendCode();">Sign In</a>
<a onclick="verifyCode();" class="verify_otp" style="background: #60B392; color: #fff; margin: 0 auto; font-size: 14px; cursor: pointer; width: 120px; border-radius: 25px; padding: 10px 15px;display: none;">Verify Code</a>
<p style="margin-bottom: 0px; margin-top: 15px;">Or</p>
<p><a style="margin-top: 10px;" href="{{ route('sign_up') }}">Create New Account</a></p>
</div>
</form> -->


</div>
</div>
</div>
</div>

</div>
</div>
</section>



<style type="text/css">
	
.con-box img {
    max-width: 33%;
}

</style>




@endsection