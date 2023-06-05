@php
$route  = \Route::currentRouteName();
@endphp

<footer class="footer">
<div class="container">
<div class="row">
<div class="col-md-4">
<img src="{!! asset('assets/frontend/images/lnxx_logo.svg')  !!}" class="img-responsive">
<p>An online financial services platform for UAE's citizens.</p>
</div>

<div class="col-md-5">
<ul class="footer-menu">
<li style="width: 100%;margin-bottom: 6px;"><a href="{{ route('home') }}">Home</a></li>
@if($route == 'get-started') 
<li style="width: 100%;margin-bottom: 6px;"><a href="#About">About US</a></li>
@else
<li style="width: 100%;margin-bottom: 6px;"><a href="{{ route('home') }}#abouttag">About US</a></li>
@endif
<li style="width: 100%;margin-bottom: 6px;"><a href="{{ route('user-dashboard') }}">Credit Cards</a></li>
<li style="width: 100%;margin-bottom: 6px;"><a href="{{ route('user-dashboard') }}">Personal Loan</a></li>
<li style="width: 100%;margin-bottom: 6px;"><a href="{{ route('user-dashboard') }}">Business Loan</a></li>
<li style="width: 100%;margin-bottom: 6px;"><a href="{{ route('user-dashboard') }}">Mortgage Loan</a></li>
<li style="width: 100%;margin-bottom: 6px;"><a href="{{ route('contact-us') }}">Contact Us</a></li>
</ul>
</div>

<div class="col-md-3">
  
<div style="width: 100%;float: left;height: 1px;"></div>
<ul class="footer-menu">
<li style="width: 100%;margin-bottom: 6px;"><a href="{{ route('community') }}">Community</a></li> 
<li style="width: 100%;margin-bottom: 6px;"><a href="{{ route('disclaimer') }}">Disclaimer</a></li>
<li style="width: 100%;margin-bottom: 6px;"><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
<li style="width: 100%;margin-bottom: 6px;"><a href="{{ route('terms-and-conditions') }}">Terms & Conditions</a></li>
</ul>
<ul class="social">
<li><a href="https://twitter.com/LnxxWorld" target="_blank"><i class="fa fa-twitter"></i></a></li>	
<li><a href="https://www.instagram.com/lnxxworld/" target="_blank"><i class="fa fa-instagram"></i></a></li>
<li><a target="_blank" href="https://www.facebook.com/lnxxworld"><i class="fa fa-facebook"></i></a></li>
<li><a target="_blank" href="https://www.youtube.com/channel/UCogdDueCxjhSHoFq88No7pw"><i class="fa fa-youtube"></i></a></li>
<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
</ul> 
</div>
</div>
<p style="text-align: center; max-width: 100%; color: #737373; font-weight: 600;">© lnxx 2022 | All Rights Reserved</p>
</div>
</footer>
 