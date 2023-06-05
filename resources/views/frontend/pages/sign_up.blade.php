@extends('frontend.layouts.app')
@section('content')
<style type="text/css">
.sn_form .col-md-3 {
    padding-right: 0px;
}
</style>
<section class="sign_up">
<div class="container">
<div class="row">
<div class="col-md-8 mx-auto">
<div class="row">
<div class="col-md-6 sign_up_content">
<h3>Start your journey with Lnxx </h3>
<h5>Create new account</h5>
<div style="text-align:center">
<img src="{!! asset('assets/frontend/images/Artboard_5.png')  !!}" style="padding-bottom: 20px;" class="img-responsive">
</div>
</div>
<div class="col-md-6 sign_up_field">
<!-- <a href="{{ route('home') }}"><img src="{!! asset('assets/frontend/images/cross.png') !!}" class="home-cross"></a> -->	
<h3>Create New Account</h3>
<p>Let's get you started!</p>
<form action="{{ route('register-email') }}" id="sn_form" class="sn_form" method="post">
{{ csrf_field() }}
<div class="row">	
	<div class="col-md-3" style="padding-right: 0px;">
	    <select name="salutation" class="form-control" style="padding-left: 1px; padding-right: 0px; font-size: 13px;" required="true">
	  	<option value="">Salutation*</option>
	    <option value="Mr.">Mr.</option>
	    <option value="Mrs.">Mrs.</option>
	    <option value="Miss.">Miss</option>
	    <option value="Dr.">Dr.</option>
	    <option value="Prof.">Prof.</option>
	    <option value="Rev.">Rev.</option>
	    <option value="Other">Other</option>
	    </select>
	</div>
    <div class="col-md-9">
		<div class="form-group">
			<input type="text" class="form-control" maxlength="16" style="padding-left: 10px;" required="true" placeholder="First name*" name="name">
			@if($errors->has('name'))
		       <span class="text-danger">{{$errors->first('name')}}</span>
		    @endif
		</div>
    </div>

    <div class="col-md-6">
		<div class="form-group">
			<input type="text" class="form-control" maxlength="16" style="padding-left: 10px;" placeholder="Middle name" name="middle_name">
			@if($errors->has('middle_name'))
		       <span class="text-danger">{{$errors->first('middle_name')}}</span>
		    @endif
		</div>
    </div>
    <div class="col-md-6">
		<div class="form-group">
			<input type="text" class="form-control" maxlength="16" style="padding-left: 10px;" required="true" placeholder="Last name*" name="last_name">
			@if($errors->has('last_name'))
		       <span class="text-danger">{{$errors->first('last_name')}}</span>
		    @endif
		</div>
    </div>

</div>
<div class="form-group mob_input">
	<!--<select name="countryCode" id="">
		<option data-countryCode="DZ" value="213">Algeria (+213)</option>
		<option data-countryCode="AD" value="376">Andorra (+376)</option>
		<option data-countryCode="AO" value="244">Angola (+244)</option>
		<option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
		<option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
		<option data-countryCode="AR" value="54">Argentina (+54)</option>
		<option data-countryCode="AM" value="374">Armenia (+374)</option>
		<option data-countryCode="AW" value="297">Aruba (+297)</option>
		<option data-countryCode="AU" value="61">Australia (+61)</option>
		<option data-countryCode="AT" value="43">Austria (+43)</option>
		<option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
		<option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
		<option data-countryCode="BH" value="973">Bahrain (+973)</option>
		<option data-countryCode="BD" value="880">Bangladesh (+880)</option>
		<option data-countryCode="BB" value="1246">Barbados (+1246)</option>
		<option data-countryCode="BY" value="375">Belarus (+375)</option>
		<option data-countryCode="BE" value="32">Belgium (+32)</option>
		<option data-countryCode="BZ" value="501">Belize (+501)</option>
		<option data-countryCode="BJ" value="229">Benin (+229)</option>
		<option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
		<option data-countryCode="BT" value="975">Bhutan (+975)</option>
		<option data-countryCode="BO" value="591">Bolivia (+591)</option>
		<option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
		<option data-countryCode="BW" value="267">Botswana (+267)</option>
		<option data-countryCode="BR" value="55">Brazil (+55)</option>
		<option data-countryCode="BN" value="673">Brunei (+673)</option>
		<option data-countryCode="BG" value="359">Bulgaria (+359)</option>
		<option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
		<option data-countryCode="BI" value="257">Burundi (+257)</option>
		<option data-countryCode="KH" value="855">Cambodia (+855)</option>
		<option data-countryCode="CM" value="237">Cameroon (+237)</option>
		<option data-countryCode="CA" value="1">Canada (+1)</option>
		<option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
		<option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
		<option data-countryCode="CF" value="236">Central African Republic (+236)</option>
		<option data-countryCode="CL" value="56">Chile (+56)</option>
		<option data-countryCode="CN" value="86">China (+86)</option>
		<option value="57">Colombia (+57)</option>
		<option value="269">Comoros (+269)</option>
		<option value="242">Congo (+242)</option>
		<option value="682">Cook Islands (+682)</option>
		<option value="506">Costa Rica (+506)</option>
		<option value="385">Croatia (+385)</option>
		<option value="53">Cuba (+53)</option>
		<option value="90392">Cyprus North (+90392)</option>
		<option value="357">Cyprus South (+357)</option>
		<option value="42">Czech Republic (+42)</option>
		<option value="45">Denmark (+45)</option>
		<option value="253">Djibouti (+253)</option>
		<option value="1809">Dominica (+1809)</option>
		<option value="1809">Dominican Republic (+1809)</option>
		<option value="593">Ecuador (+593)</option>
		<option value="20">Egypt (+20)</option>
		<option value="503">El Salvador (+503)</option>
		<option value="240">Equatorial Guinea (+240)</option>
		<option value="291">Eritrea (+291)</option>
		<option value="372">Estonia (+372)</option>
		<option value="251">Ethiopia (+251)</option>
		<option value="500">Falkland Islands (+500)</option>
		<option value="298">Faroe Islands (+298)</option>
		<option value="679">Fiji (+679)</option>
		<option value="358">Finland (+358)</option>
		<option value="33">France (+33)</option>
		<option value="594">French Guiana (+594)</option>
		<option value="689">French Polynesia (+689)</option>
		<option value="241">Gabon (+241)</option>
		<option value="220">Gambia (+220)</option>
		<option value="7880">Georgia (+7880)</option>
		<option value="49">Germany (+49)</option>
		<option value="233">Ghana (+233)</option>
		<option value="350">Gibraltar (+350)</option>
		<option value="30">Greece (+30)</option>
		<option value="299">Greenland (+299)</option>
		<option value="1473">Grenada (+1473)</option>
		<option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
		<option data-countryCode="GU" value="671">Guam (+671)</option>
		<option data-countryCode="GT" value="502">Guatemala (+502)</option>
		<option data-countryCode="GN" value="224">Guinea (+224)</option>
		<option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
		<option data-countryCode="GY" value="592">Guyana (+592)</option>
		<option data-countryCode="HT" value="509">Haiti (+509)</option>
		<option data-countryCode="HN" value="504">Honduras (+504)</option>
		<option data-countryCode="HK" value="852">Hong Kong (+852)</option>
		<option data-countryCode="HU" value="36">Hungary (+36)</option>
		<option data-countryCode="IS" value="354">Iceland (+354)</option>
		<option data-countryCode="IN" value="91">India (+91)</option>
		<option data-countryCode="ID" value="62">Indonesia (+62)</option>
		<option data-countryCode="IR" value="98">Iran (+98)</option>
		<option data-countryCode="IQ" value="964">Iraq (+964)</option>
		<option data-countryCode="IE" value="353">Ireland (+353)</option>
		<option data-countryCode="IL" value="972">Israel (+972)</option>
		<option data-countryCode="IT" value="39">Italy (+39)</option>
		<option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
		<option data-countryCode="JP" value="81">Japan (+81)</option>
		<option data-countryCode="JO" value="962">Jordan (+962)</option>
		<option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
		<option data-countryCode="KE" value="254">Kenya (+254)</option>
		<option data-countryCode="KI" value="686">Kiribati (+686)</option>
		<option data-countryCode="KP" value="850">Korea North (+850)</option>
		<option data-countryCode="KR" value="82">Korea South (+82)</option>
		<option data-countryCode="KW" value="965">Kuwait (+965)</option>
		<option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
		<option data-countryCode="LA" value="856">Laos (+856)</option>
		<option value="371">Latvia (+371)</option>
		<option value="961">Lebanon (+961)</option>
		<option value="266">Lesotho (+266)</option>
		<option value="231">Liberia (+231)</option>
		<option value="218">Libya (+218)</option>
		<option value="417">Liechtenstein (+417)</option>
		<option value="370">Lithuania (+370)</option>
		<option value="352">Luxembourg (+352)</option>
		<option value="853">Macao (+853)</option>
		<option value="389">Macedonia (+389)</option>
		<option value="261">Madagascar (+261)</option>
		<option value="265">Malawi (+265)</option>
		<option value="60">Malaysia (+60)</option>
		<option value="960">Maldives (+960)</option>
		<option value="223">Mali (+223)</option>
		<option value="356">Malta (+356)</option>
		<option value="692">Marshall Islands (+692)</option>
		<option value="596">Martinique (+596)</option>
		<option value="222">Mauritania (+222)</option>
		<option value="269">Mayotte (+269)</option>
		<option value="52">Mexico (+52)</option>
		<option value="691">Micronesia (+691)</option>
		<option value="373">Moldova (+373)</option>
		<option value="377">Monaco (+377)</option>
		<option value="976">Mongolia (+976)</option>
		<option value="1664">Montserrat (+1664)</option>
		<option value="212">Morocco (+212)</option>
		<option value="258">Mozambique (+258)</option>
		<option value="95">Myanmar (+95)</option>
		<option value="264">Namibia (+264)</option>
		<option value="674">Nauru (+674)</option>
		<option value="977">Nepal (+977)</option>
		<option value="31">Netherlands (+31)</option>
		<option value="687">New Caledonia (+687)</option>
		<option value="64">New Zealand (+64)</option>
		<option value="505">Nicaragua (+505)</option>
		<option value="227">Niger (+227)</option>
		<option value="234">Nigeria (+234)</option>
		<option value="683">Niue (+683)</option>
		<option value="672">Norfolk Islands (+672)</option>
		<option value="670">Northern Marianas (+670)</option>
		<option value="47">Norway (+47)</option>
		<option value="968">Oman (+968)</option>
		<option value="680">Palau (+680)</option>
		<option value="507">Panama (+507)</option>
		<option value="675">Papua New Guinea (+675)</option>
		<option value="595">Paraguay (+595)</option>
		<option value="51">Peru (+51)</option>
		<option value="63">Philippines (+63)</option>
		<option value="48">Poland (+48)</option>
		<option value="351">Portugal (+351)</option>
		<option value="1787">Puerto Rico (+1787)</option>
		<option value="974">Qatar (+974)</option>
		<option value="262">Reunion (+262)</option>
		<option value="40">Romania (+40)</option>
		<option value="7">Russia (+7)</option>
		<option value="250">Rwanda (+250)</option>
		<option value="378">San Marino (+378)</option>
		<option value="239">Sao Tome &amp; Principe (+239)</option>
		<option value="966">Saudi Arabia (+966)</option>
		<option value="221">Senegal (+221)</option>
		<option value="381">Serbia (+381)</option>
		<option value="248">Seychelles (+248)</option>
		<option value="232">Sierra Leone (+232)</option>
		<option value="65">Singapore (+65)</option>
		<option value="421">Slovak Republic (+421)</option>
		<option value="386">Slovenia (+386)</option>
		<option value="677">Solomon Islands (+677)</option>
		<option value="252">Somalia (+252)</option>
		<option value="27">South Africa (+27)</option>
		<option value="34">Spain (+34)</option>
		<option value="94">Sri Lanka (+94)</option>
		<option value="290">St. Helena (+290)</option>
		<option value="1869">St. Kitts (+1869)</option>
		<option value="1758">St. Lucia (+1758)</option>
		<option value="249">Sudan (+249)</option>
		<option value="597">Suriname (+597)</option>
		<option value="268">Swaziland (+268)</option>
		<option value="46">Sweden (+46)</option>
		<option value="41">Switzerland (+41)</option>
		<option value="963">Syria (+963)</option>
		<option value="886">Taiwan (+886)</option>
		<option value="7">Tajikstan (+7)</option>
		<option value="66">Thailand (+66)</option>
		<option value="228">Togo (+228)</option>
		<option value="676">Tonga (+676)</option>
		<option value="1868">Trinidad &amp; Tobago (+1868)</option>
		<option value="216">Tunisia (+216)</option>
		<option value="90">Turkey (+90)</option>
		<option value="7">Turkmenistan (+7)</option>
		<option value="993">Turkmenistan (+993)</option>
		<option value="1649">Turks &amp; Caicos Islands (+1649)</option>
		<option value="688">Tuvalu (+688)</option>
		<option value="256">Uganda (+256)</option>
		<option value="44">UK (+44)</option>
		<option value="380">Ukraine (+380)</option>
		<option value="971">United Arab Emirates (+971)</option>
		<option value="598">Uruguay (+598)</option>
		<option value="1">USA (+1)</option>
		<option value="7">Uzbekistan (+7)</option>
		<option value="678">Vanuatu (+678)</option>
		<option value="379">Vatican City (+379)</option>
		<option value="58">Venezuela (+58)</option>
		<option value="84">Vietnam (+84)</option>
		<option value="84">Virgin Islands - British (+1284)</option>
		<option value="84">Virgin Islands - US (+1340)</option>
		<option value="681">Wallis &amp; Futuna (+681)</option>
		<option value="969">Yemen (North)(+969)</option>
		<option value="967">Yemen (South)(+967)</option>
		<option value="260">Zambia (+260)</option>
		<option value="263">Zimbabwe (+263)</option>
</select> -->

	<input type="number" id="phone" style="padding-left: 85px;" class="form-control" required="true" placeholder="Enter mobile number*" name="mobile">
	<!-- <span style="position: absolute; top: 12px; font-size: 14px; left: 20px;">+971</span> -->
	<select class="countryCode" onChange="countryCode();" style="position: absolute; top: 0px; font-size: 14px; left: 20px; padding-left: 5px;" name="countryCode" required="true">
		<option value="+971">+971</option>
        <option value="+91">+91</option>
	</select>
   <!--  <div id="recaptcha-container"></div> -->
	<!-- <input type="number" onKeyPress="if(this.value.length==9) return false;" class="form-control" required="true" placeholder="Enter mobile number*" name="mobile"> -->

	<img src="{!! asset('assets/frontend/images/mobile_register.png')  !!}" alt="logo" class="input-img">
	<div class="valid_no" style="color: #888;"><!-- Enter your 9-digit mobile number-otp --></div>
	@if($errors->has('mobile'))
       <span class="text-danger">{{$errors->first('mobile')}}</span>
    @endif
   <div id="recaptha-container" style="margin-top: 12px;"></div>

<!-- 	<button type="button" class="btn btn-info" onclick="otpSend();">Send OTP</button>  -->

</div>

<div class="form-group mob_input otp_field" style="margin-top: 25px; display: none;">
	<input type="number" class="form-control" required="true" id="number-otp" maxlength="6" placeholder="Enter OTP*" name="otp">
	<img src="{!! asset('assets/frontend/images/otp.png')  !!}" alt="logo" class="input-img">
	<div class="otp_lab">Please enter the OTP sent on your mobile number</div>
	<div class="not_verify" style="color: #f00; font-size: 12px; padding-top: 2px;"></div>
	<div class="otp_verify" style="color: green; font-size: 12px; padding-top: 2px;"></div>

	@if(session()->has('otp_not_match'))
	<div class="errors_otp" style="color: #f00; font-size: 12px; padding-top: 2px;">Invalid OTP</div>
	@endif
	<!-- <div class="alert alert-danger hide" id="error-message"></div>
    <div class="alert alert-success hide" id="sent-message"></div> -->
</div>
<input type="hidden" name="verify" value="0" id="verify">
<div class="already_exist" style="color: #f00; font-size: 12px; padding-top: 2px;"></div>
<!-- <div class="otp_sent" style="color: green; font-size: 12px; padding-top: 2px;"></div>  -->
<div id="error" style="color: #f00;font-size: 12px; padding-top: 2px;display: none;"></div>
<div id="sentMessage" style="color: green;font-size: 12px; padding-top: 2px;display: none;"></div>
<div id="sucessMessage" style="color: green;font-size: 12px; padding-top: 2px;display: none;"></div>

<!-- <div class="form-group">
<p><input type="checkbox" required="true" value="1" name="terms_conditions"> I accept the <a href="#">Terms and Conditions</a></p>
</div> -->

<div class="btn-box" style="text-align: center;">
 <a onclick="sendCode();" class="sent_otp" style="background: #60B392; color: #fff; margin: 0 auto; font-size: 14px; cursor: pointer; width: 106px; border-radius: 25px; padding: 10px 15px;">Send OTP</a>	
<a onclick="verifyCode();" class="verify_otp" style="background: #60B392; color: #fff; margin: 0 auto; font-size: 14px; cursor: pointer; width: 120px; border-radius: 25px; padding: 10px 15px;display: none;">Verify Code</a>

<label class="lab_hide" style="float: left; display: none; width: 100%;padding-top: 10px;text-align: left;"><input style="margin-top: 3px;" type="checkbox" value="1" required="true"> By signing up i accept the <a style="display: inline; font-weight: normal; font-size: 15px;" target="blank" href="/terms-and-conditions">terms and conditions</a> </label>

<button class="btn" id="elementID" disabled="disabled" style="display: none;">Next</button>
<p style="margin-bottom: 0px; margin-top: 15px;">Or</p>
<p style="font-size: 16px">Already have an account? <a style="margin-top: 10px;display: inline; font-size: 16px;" href="{{ route('sign-in') }}">Sign In</a></p>
</div>
</form>

</div>

</div>


</div>
</div>

</div>
</div>
</section>


<style type="text/css">
@media(min-width: 1024px){
.sign_up .col-md-8 {
    margin-top: 70px;
}
}
</style>



@endsection