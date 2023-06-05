<style type="text/css">
*{
	font-size: 10px;
	font-family: sans-serif;
}
.sec-page p{
	float: left;
}
.clearfix{
	clear: both;
}
table, th, td {
	border: 1px solid #888;
	border-collapse: collapse;
	text-align: left;
	padding: 5px;
}
</style>

<div id="page1-div" style="position:relative;width:100%;">
<img style="width: 100%;" src="{{ $home }}/assets/frontend/images/target001.png" alt="background image"/>
<p style="font-family: sans-serif;position: absolute; top: 600px; width: 100%; margin:0 auto; left:0; right:0; text-align: center;color: #1b4e9c;font-size: 44px; font-weight: 600;" class="ft10">MORTGAGE</p>
<p style="font-family: sans-serif;position: absolute; top: 650px; width: 100%; margin:0 auto; left:0; right:0; text-align: center;color: #1b4e9c;font-size: 44px; font-weight: 600;" class="ft10">LOAN APPLICATION</p>
<p style="font-family: sans-serif;position: absolute; top: 700px; width: 100%; margin:0 auto; left:0; right:0; text-align: center; color: #1b4e9c;font-size: 44px; font-weight: 600;" class="ft10">FORM</p>
</div>
<div class="clearfix"></div>
<div class="sec-page" style="position:relative;width:100%;">
<img style="width: 100%; height: " src="{{ $home }}/assets/frontend/images/sec_top.png" alt="background image"/>
<div class="clearfix"></div>
<p style="margin-top: 20px; line-height: 15px;">Unless otherwise defined in this application form, capitalised terms shall have the meaning assigned to them in the Mortgage Loan Terms and Conditions of<br>
First Abu Dhabi Bank PJSC and the General Terms and Conditions of First Abu Dhabi Bank PJSC, which can be found on bankfab.com</p>
<div class="clearfix"></div>
<p style="width: 100%;"><b style="font-size: 12px;">Application Details</b></p>
<div class="clearfix"></div>

<div style="float: left; width: 100%;">
<p style="width: 100px;display: block;">Applicant Type</p> 
<p style="margin-left: 80px;display: block;">Single</p> <p style="margin-left: 110px;"><img style="margin-top: -8px; margin-left: 5px;" src="{{ $home }}/assets/frontend/images/checkbox.png" alt="background image"/></p> <p style="margin-left: 150px;">Joint</p> <p style="margin-left: 170px;"><img src="{{ $home }}/assets/frontend/images/unchecked.png" style="margin-top: -8px; margin-right: 6px; margin-left: 5px;" alt="background image"/> </p> <p style="margin-left: 200px;">If joint, please specify the total number of applicants</p><div style="width: 270px;
    border-bottom: 1px solid #888; display: inline-block; margin-left: 435px; margin-top: 18px;"> </div>
</div>
<div class="clearfix"></div>
<div style="float: left; width: 100%;">
<p style="display: inline;">and their relationship </p><div style="width: 490px;
    border-bottom: 1px solid #888;  display: inline-block; margin-left: 100px; margin-top: 19px;"> </div>
</div>
</div>
<div class="clearfix"></div>

<div class="tri-page" style="position:relative;width:100%;">
<div class="clearfix"></div>
<p style="width: 100%;"><b style="font-size: 12px;">Personal Details</b></p>
<div class="clearfix"></div>
<p style="float: left;">Title &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="border-bottom: 1px solid #888; width: 250px;float: left; margin-left: 60px;padding-left: 7px;">{{ $result->salutation }}</span></p>
<div class="clearfix"></div>
<p style="float: left;">Full Name (as in passport) &nbsp;&nbsp; <span style="margin-left: 140px; float: left; border-bottom: 1px solid #888; width: 470px;padding-left: 7px;">{{ $result->name }} {{ $result->middle_name }} {{ $result->last_name }}</span></p>
<div class="clearfix"></div>

<p style="width: 50%;float: left;">Date of Birth <span style="border-bottom: 1px solid #888; width: 250px;float: left; margin-left: 70px;padding-left: 7px;">{{ $result->date_of_birth }}</span></p> <p style="width: 50%; float: left; margin-left: -50%;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nationality <span style="padding-left: 7px; border-bottom: 1px solid #888; width: 200px;float: left; margin-left: 70px;">
	@foreach($country as $country1)       
            @if($country1->id == $result->nationality) 
            {{ $country1->country_name }} @endif
            @endforeach </span></p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Highest Educational Qualification  @if($UserEducation) <span style="border-bottom: 1px solid #888; width: 450px;float: left; margin-left: 150px;"> {{ $UserEducation->education }} </span> @else <span style="border-bottom: 1px solid #888; width: 450px;float: left; margin-left: 150px;margin-top: 12px;"> </span>  @endif   </p>

<div class="clearfix"></div>

<p style="float: left;width: 100%;">Marital Status <span style="border-bottom: 1px solid #888; width: 350px;float: left; margin-left: 75px; padding-left: 7px;"> {{ $result->marital_status }}  </span> </p>

<div class="clearfix"></div>
<p style="float: left;width: 100%;">Number of Dependents (including spouse)  <span style="border-bottom: 1px solid #888; width: 300px;float: left; margin-left: 200px;margin-top: 12px;padding-left: 7px;">  </span> </p>

<div class="clearfix"></div>
<p style="float: left;width: 100%;">Emirate of Residence <span style="border-bottom: 1px solid #888; width: 500px;float: left;margin-top: 12px; margin-left: 100px;"> </span> </p>

@if($result->years_in_uae)
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Years of Residence in the UAE <span style="border-bottom: 1px solid #888; width: 350px;float: left; margin-left: 150px;padding-left: 7px;"> {{ $result->years_in_uae }} </span> </p>
<div class="clearfix"></div>
@endif

<div class="clearfix"></div>
<p style="float: left;width: 100%;">Name of Next of Kin in the UAE <span style="border-bottom: 1px solid #888; width: 450px;float: left; margin-left: 150px;margin-top: 12px;"> </span> </p>

<div class="clearfix"></div>
<p style="float: left; width: 100%;">Telephone No. <span style="border-bottom: 1px solid #888; width: 350px;float: left; margin-left: 80px;margin-top: 11px;"> </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Name of Next of Kin in Home Country (for expatriates) <span style="border-bottom: 1px solid #888; width: 350px;float: left; margin-left: 280px;margin-top: 12px;"> </span> </p>

<div class="clearfix"></div>
<p style="float: left;width: 100%;">Telephone No. <span style="border-bottom: 1px solid #888; width: 250px;float: left; margin-left: 80px;margin-top: 11px;"> </span> </p>

<div class="clearfix"></div>
<p style="float: left;width: 100%;">Etihad Guest No. (if applicable) <span style="border-bottom: 1px solid #888; width: 400px;float: left; margin-left: 150px;margin-top: 12px;"> </span> </p>
</div>

<div class="clearfix"></div>

<div class="four-page" style="position:relative;width:100%;">
<div class="clearfix"></div>
<p style="width: 100%;"><b style="font-size: 12px;">Identity Details</b></p>
<div class="clearfix"></div>
<table style="width: 100%;margin-bottom: 50px;">
<tr>
<th>Type of ID</th>
<th>ID No.</th>
<th>Date of Issue</th>
<th>Date of Expiry</th>
<th>Place of Issue</th>
</tr>	
<tr>
<td>Passport</td>
<td>{{ $result->passport_number }}</td>
<td></td>
<td>{{ $result->passport_expiry_date }}</td>
<td></td>
</tr>
<tr>
<td>Visa</td>
<td>{{ $result->visa_number }}</td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td>Emirates ID</td>
<td>{{ $result->eid_number }}</td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td>Khulasat-Al-Qaid</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td>Labour Card</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td>Driving Licence</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
</table>

<div class="clearfix"></div>
<p style="width: 100%;"><b style="font-size: 12px;">Contact & Address Details</b></p>
<div class="clearfix"></div>
<table style="width: 100%;">
<tr>
<td rowspan="2"></td>
<td colspan="3">Office</td>
<td colspan="3">Residence</td>
<td colspan="3">Home Country (for expatriates)</td>
</tr>
<tr>
<td>Country Code</td>
<td>Area Code</td>
<td>No.</td>

<td>Country Code</td>
<td>Area Code</td>
<td>No.</td>

<td>Country Code</td>
<td>Area Code</td>
<td>No.</td>
</tr>

<tr>
<td>Mobile No.</td>
<td>+971</td>
<td></td>
<td>{{ $result->mobile }}</td>

<td> </td>
<td> </td>
<td> </td>

<td> </td>
<td> </td>
<td> </td>
</tr>

<tr>
<td>Telephone No.</td>
<td></td>
<td></td>
<td></td>

<td></td>
<td></td>
<td></td>

<td></td>
<td></td>
<td></td>
</tr>

<tr>
<td>Fax No.</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
</table>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Email Address <span style="border-bottom: 1px solid #888; width: 600px;float: left; margin-left: 70px; padding-left: 7px;"> {{ $result->email }} </span> </p>
<div class="clearfix"></div>
@if($app_data)
@if($app_data->residential_address_line_1)
<p style="float: left;width: 100%;">P.O. Box No.  <span style="border-bottom: 1px solid #888; width: 600px;float: left; margin-left: 70px; @if($app_data->residential_po_box) @else margin-top: 12px; @endif "> {{ $app_data->residential_po_box }} </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Building Name  <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 70px; @if($app_data->residential_address_line_1) @else margin-top: 12px; @endif "> {{ $app_data->residential_address_line_1 }} </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Flat/Unit No. <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 70px; @if($app_data->residential_address_line_2) @else margin-top: 12px; @endif "> {{ $app_data->residential_address_line_2 }} </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Area/Street. <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 70px; @if($app_data->residential_address_line_3) @else margin-top: 12px; @endif "> {{ $app_data->residential_address_line_3 }} </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Landmark <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 70px; @if($app_data->residential_address_nearest_landmark) @else margin-top: 12px; @endif "> {{ $app_data->residential_address_nearest_landmark }} </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">City/Emirate <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 70px;  @if($app_data->residential_emirate) @else margin-top: 12px; @endif "> {{ $app_data->residential_emirate }} </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">City (for home country)  <span style="border-bottom: 1px solid #888; width: 400px;float: left; margin-left: 120px; @if($app_data->permanent_address_city) @else margin-top: 12px; @endif "> {{ $app_data->permanent_address_city }} </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Country  <span style="border-bottom: 1px solid #888; width: 400px;float: left; margin-left: 50px;"> @foreach($country as $country)       
                @if($country->id == $app_data->permanent_address_country)
                    {{ $country->country_name }}
                @endif
            @endforeach  </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Zip Code <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 60px; @if($app_data->permanent_address_zipcode) @else margin-top: 12px; @endif "> {{ $app_data->permanent_address_zipcode }} </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Mailing Address <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 90px; @if($app_data->mailing_address_line) @else margin-top: 12px; @endif "> {{ $app_data->mailing_address_line }} </span> </p>
@endif
@else

<div class="clearfix"></div>
<p style="float: left;width: 100%;">P.O. Box No.  <span style="border-bottom: 1px solid #888; width: 600px;float: left; margin-left: 70px; margin-top: 12px;"> </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Building Name  <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 70px; margin-top: 12px;">  </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Flat/Unit No. <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 70px; margin-top: 12px;"> </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Area/Street. <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 70px; margin-top: 12px;"> </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Landmark <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 70px; margin-top: 12px;"> </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">City/Emirate <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 70px; margin-top: 12px;"> </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">City (for home country)  <span style="border-bottom: 1px solid #888; width: 400px;float: left; margin-left: 120px; margin-top: 12px;"> </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Country  <span style="border-bottom: 1px solid #888; width: 400px;float: left; margin-left: 50px; margin-top: 12px;"> </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Zip Code <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 60px; margin-top: 12px;"> </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Mailing Address <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 90px; margin-top: 12px;"> </span> </p>

<div class="clearfix"></div>

@endif
</div>
<div class="clearfix"></div>
<div class="five-page" style="position:relative;width:100%;">
<p style="width: 100%;"><b style="font-size: 12px;">Employment Details</b></p>
<div class="clearfix"></div>
<p style="float: left;">Current Employment Status</p>
<p style="margin-left: 30px; float: left;">Employed</p> <p style="margin-left:4px;float: left;"><img style="margin-top: -5px; margin-left: 5px;" @if($result->cm_type == 1) src="{{ $home }}/assets/frontend/images/checkbox.png" @else src="{{ $home }}/assets/frontend/images/unchecked.png" @endif alt="background image"/></p> <p style="margin-left: 20px;float: left;">Pensioner</p> <p style="margin-left: 4px;float: left;"><img @if($result->cm_type == 3) src="{{ $home }}/assets/frontend/images/checkbox.png" @else src="{{ $home }}/assets/frontend/images/unchecked.png" @endif  style="margin-top: -5px; margin-right: 6px; margin-left: 4px;" alt="background image"/> </p>

<p style="margin-left: 20px;float: left;">Self-Employed</p> <p style="margin-left: 4px;float: left;"><img src="{{ $home }}/assets/frontend/images/unchecked.png" @if($result->cm_type == 2) src="{{ $home }}/assets/frontend/images/checkbox.png" @else src="{{ $home }}/assets/frontend/images/unchecked.png" @endif style="margin-top: -5px; margin-right: 6px; margin-left: 4px;" alt="background image"/> </p>

<p style="margin-left: 20px;float: left;">Other</p> <p style="margin-left: 4px;"><img src="{{ $home }}/assets/frontend/images/unchecked.png" style="margin-top: -5px; margin-right: 6px; margin-left: 4px;" alt="background image"/> </p>
<div class="clearfix"></div>

@if($result->cm_type == 1)
<p style="width: 100%;"><b style="font-size: 12px;">Salaried</b></p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Name of Employer/Company <span style="border-bottom: 1px solid #888; width: 520px;float: left; margin-left: 140px; padding-left: 7px;"> {{ $result->company_name }} </span> </p>
<div class="clearfix"></div>
<p style="float: left;">Employment Category</p>
<p style="margin-left: 30px; float: left;">Permanent</p> <p style="margin-left:4px;float: left;"><img style="margin-top: -5px; margin-left: 5px;" src="{{ $home }}/assets/frontend/images/unchecked.png" alt="background image"/></p> <p style="margin-left: 20px;float: left;">Fixed Term</p> <p style="margin-left: 4px;float: left;"><img src="{{ $home }}/assets/frontend/images/unchecked.png" style="margin-top: -5px; margin-right: 6px; margin-left: 4px;" alt="background image"/> </p>

<p style="margin-left: 20px;float: left;">Temporary</p> <p style="margin-left: 4px;float: left;"><img src="{{ $home }}/assets/frontend/images/unchecked.png" src="{{ $home }}/assets/frontend/images/unchecked.png" style="margin-top: -5px; margin-right: 6px; margin-left: 4px;" alt="background image"/> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Company Address <span style="border-bottom: 1px solid #888; width: 550px;float: left; margin-left: 100px; padding-left: 7px;margin-top: 12px;"> </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 50%;">Department <span style="border-bottom: 1px solid #888; width: 200px;float: left; margin-left: 80px; padding-left: 7px;margin-top: 12px;"> </span> </p>
<p style="float: left;width: 50%; margin-left: -50%;"> &nbsp;&nbsp;&nbsp; Designation <span style="border-bottom: 1px solid #888; width: 280px;float: left; margin-left: 70px; padding-left: 7px;margin-top: 12px;"> </span> </p>
<div class="clearfix"></div>

<p style="float: left;width: 50%;">Employee No. <span style="border-bottom: 1px solid #888; width: 200px;float: left; margin-left: 80px; padding-left: 7px;margin-top: 12px;"> </span> </p>
<p style="float: left;width: 50%;margin-left: -50%;"> &nbsp;&nbsp;&nbsp; Date of Employment <span style="border-bottom: 1px solid #888; width: 250px;float: left; margin-left: 110px; padding-left: 7px;"> {{ $result->date_of_joining }} </span> </p>

<div class="clearfix"></div>
@endif
<div class="clearfix"></div>


@if($result->cm_type == 2)
<p style="width: 100%;"><b style="font-size: 12px;">Self-Employed</b></p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Name of Business <span style="border-bottom: 1px solid #888; width: 540px;float: left; margin-left: 100px; padding-left: 7px;"> {{ $result->self_company_name }} </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Nature of Business <span style="border-bottom: 1px solid #888; width: 540px;float: left; margin-left: 100px; padding-left: 7px;"> {{ $result->profession_business }} </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Date of Inception <span style="border-bottom: 1px solid #888; width: 540px;float: left; margin-left: 90px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Emirate <span style="border-bottom: 1px solid #888; width: 560px;float: left; margin-left: 40px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>

<p style="float: left;width: 100%;">Trade Licence No. <span style="border-bottom: 1px solid #888; width: 520px;float: left; margin-left: 110px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>

<p style="float: left;width: 100%;">Trade Licence Expiry Date <span style="border-bottom: 1px solid #888; width: 520px;float: left; margin-left: 140px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>

<p style="float: left;width: 100%;">If you are a Board Member, what is your share of the capital (%)? <span style="border-bottom: 1px solid #888; width: 350px;float: left; margin-left: 300px; padding-left: 7px;"> {{ $result->percentage_ownership }} </span> </p>
<div class="clearfix"></div>

<p style="float: left;width: 100%;">Total no. of Partners/Directors <span style="border-bottom: 1px solid #888; width: 450px;float: left; margin-left: 150px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>

<p style="float: left;width: 100%;">Total % of their shares <span style="border-bottom: 1px solid #888; width: 550px;float: left; margin-left: 110px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>

@endif

<div class="clearfix"></div>
<p style="width: 100%;"><b style="font-size: 12px;">Bank Accounts</b></p>
<div class="clearfix"></div>
<p style="float: left;">Is your salary transferred to the Bank?</p>
<p style="margin-left: 30px; float: left;">Yes</p> <p style="margin-left:4px;float: left;"><img style="margin-top: -5px; margin-left: 5px;" src="{{ $home }}/assets/frontend/images/unchecked.png" alt="background image"/></p> <p style="margin-left: 20px;float: left;">No</p> <p style="margin-left: 4px;float: left;"><img src="{{ $home }}/assets/frontend/images/unchecked.png" style="margin-top: -5px; margin-right: 6px; margin-left: 4px;" alt="background image"/> </p>

<div class="clearfix"></div>
<p style="width: 100%;margin-top: 30px;"><b style="font-size: 12px;">Existing Accounts with the Bank</b></p>
<div class="clearfix"></div>
<p style="float: left;">Savings</p> <p style="margin-left:4px;float: left;"><img style="margin-top: -5px; margin-left: 5px;" src="{{ $home }}/assets/frontend/images/unchecked.png" alt="background image"/></p> <p style="margin-left: 20px;float: left;">Current</p> <p style="margin-left: 4px;float: left;"><img src="{{ $home }}/assets/frontend/images/unchecked.png" style="margin-top: -5px; margin-right: 6px; margin-left: 4px;" alt="background image"/> </p>

<p style="margin-left: 20px; float: left;">Call/Fixed</p> <p style="margin-left:4px;float: left;"><img style="margin-top: -5px; margin-left: 5px;" src="{{ $home }}/assets/frontend/images/unchecked.png" alt="background image"/></p> <p style="margin-left: 20px;float: left;">Loan</p> <p style="margin-left: 4px;float: left;"><img src="{{ $home }}/assets/frontend/images/unchecked.png" style="margin-top: -5px; margin-right: 6px; margin-left: 4px;" alt="background image"/> </p>

<p style="margin-left: 20px; float: left;">Credit Card</p> <p style="margin-left:4px;float: left;"><img style="margin-top: -5px; margin-left: 5px;" src="{{ $home }}/assets/frontend/images/unchecked.png" alt="background image"/></p> <p style="margin-left: 20px;float: left;">Other</p> <p style="margin-left: 4px;float: left;"><img src="{{ $home }}/assets/frontend/images/unchecked.png" style="margin-top: -5px; margin-right: 6px; margin-left: 4px;" alt="background image"/> </p>

<div class="clearfix"></div>
<p style="float: left;width: 50%;">CIF ID <span style="border-bottom: 1px solid #888; width: 280px;float: left; margin-left: 35px; margin-top: 12px; padding-left: 7px;">  </span> </p>

<p style="float: left;width: 50%; margin-left: -50%;"> &nbsp;&nbsp;&nbsp; Account No. <span style="border-bottom: 1px solid #888; width: 280px;float: left; margin-left:70px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>

<p style="width: 100%;"><b style="font-size: 12px;">Other Bank Account Details</b></p>

<div class="clearfix"></div>
<p style="float: left;width: 50%;">Name of the Bank <span style="border-bottom: 1px solid #888; width: 600px;float: left; margin-left: 80px; margin-top: 12px; padding-left: 7px;">  </span> </p>

<div class="clearfix"></div>
<p style="float: left;width: 50%;">Branch <span style="border-bottom: 1px solid #888; width: 280px;float: left; margin-left: 35px; margin-top: 12px; padding-left: 7px;">  </span> </p>

<p style="float: left;width: 50%; margin-left: -50%;"> &nbsp;&nbsp;&nbsp; Account Type <span style="border-bottom: 1px solid #888; width: 280px;float: left; margin-left:80px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 100%;">Account No. <span style="border-bottom: 1px solid #888; width: 600px;float: left; margin-left: 70px; margin-top: 11px; padding-left: 7px;">  </span> </p>

<div class="clearfix"></div>
<p style="width: 100%;"><b style="font-size: 12px;">Personal References</b></p>
<div class="clearfix"></div>
<p style="width: 100%;"><b style="font-size: 11px;">Reference No. 1</b></p>
<div class="clearfix"></div>
<p style="float: left;width: 50%;">Name of a relative or friend in the UAE <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 170px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 50%;">Mobile No. <span style="border-bottom: 1px solid #888; width: 260px;float: left; margin-left: 55px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<p style="float: left;width: 50%; margin-left: -50%;"> &nbsp;&nbsp;&nbsp; Residence Telephone No <span style="border-bottom: 1px solid #888; width: 225px;float: left; margin-left:125px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>

<p style="float: left;width: 50%;">Relationship <span style="border-bottom: 1px solid #888; width: 260px;float: left; margin-left: 55px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<p style="float: left;width: 50%; margin-left: -50%;"> &nbsp;&nbsp;&nbsp; Office Telephone No <span style="border-bottom: 1px solid #888; width: 235px;float: left; margin-left:115px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>
<div class="clearfix"></div>
<p style="width: 100%;"><b style="font-size: 11px;">Reference No. 2</b></p>
<div class="clearfix"></div>
<p style="float: left;width: 50%;">Name of a relative or friend in the UAE <span style="border-bottom: 1px solid #888; width: 500px;float: left; margin-left: 170px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 50%;">Mobile No. <span style="border-bottom: 1px solid #888; width: 260px;float: left; margin-left: 55px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<p style="float: left;width: 50%; margin-left: -50%;"> &nbsp;&nbsp;&nbsp; Residence Telephone No <span style="border-bottom: 1px solid #888; width: 225px;float: left; margin-left:125px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>

<p style="float: left;width: 50%;">Relationship <span style="border-bottom: 1px solid #888; width: 260px;float: left; margin-left: 55px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<p style="float: left;width: 50%; margin-left: -50%;"> &nbsp;&nbsp;&nbsp; Office Telephone No <span style="border-bottom: 1px solid #888; width: 235px;float: left; margin-left:115px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>

<p style="width: 100%;"><b style="font-size: 12px;">Developer Details (if applicable)</b></p>
<div class="clearfix"></div>
<p style="float: left;width: 50%;">Name of the Developer <span style="border-bottom: 1px solid #888; width: 560px;float: left; margin-left: 100px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 50%;">Name of the Project  <span style="border-bottom: 1px solid #888; width: 560px;float: left; margin-left: 100px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 50%;">Project Phase  <span style="border-bottom: 1px solid #888; width: 580px;float: left; margin-left: 80px; margin-top: 12px; padding-left: 7px;">  </span> </p>

<div class="clearfix"></div>


<p style="width: 100%;"><b style="font-size: 12px;">Address of Property</b></p>
<div class="clearfix"></div>

<p style="float: left;width: 50%;">Building Name <span style="border-bottom: 1px solid #888; width: 260px;float: left; margin-left: 55px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<p style="float: left;width: 50%; margin-left: -50%;"> &nbsp;&nbsp;&nbsp; Flat/Unit No <span style="border-bottom: 1px solid #888; width: 275px;float: left; margin-left:70px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>

<p style="float: left;width: 50%;">Area/Street <span style="border-bottom: 1px solid #888; width: 260px;float: left; margin-left: 55px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<p style="float: left;width: 50%; margin-left: -50%;"> &nbsp;&nbsp;&nbsp; Landmark <span style="border-bottom: 1px solid #888; width: 275px;float: left; margin-left:70px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>

<p style="float: left;width: 50%;">P.O. Box No. <span style="border-bottom: 1px solid #888; width: 260px;float: left; margin-left: 55px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<p style="float: left;width: 50%; margin-left: -50%;"> &nbsp;&nbsp;&nbsp; City/Emirate <span style="border-bottom: 1px solid #888; width: 275px;float: left; margin-left:70px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>
<p style="width: 100%;"><b style="font-size: 12px;">Seller’s Details (if the property was purchased from the secondary market)</b></p>
<div class="clearfix"></div>
<p style="float: left;width: 50%;">Seller’s Name <span style="border-bottom: 1px solid #888; width: 590px;float: left; margin-left: 70px; margin-top: 12px; padding-left: 7px;">  </span> </p>
<div class="clearfix"></div>
<p style="float: left;width: 50%;">Seller’s Address <span style="border-bottom: 1px solid #888; width: 580px;float: left; margin-left: 80px; margin-top: 12px; padding-left: 7px;">  </span> </p>

<div class="clearfix"></div>
<p style="float: left;width: 100%;">Payment Schedule for Developer/Contractor (for property under construction)</p>
<div class="clearfix"></div>
<table style="width: 100%;">
<tr>
<td>No</td>
<td>Amount Due</td>
<td>Payable by Customer/Bank</td>
<td>Date of Payment</td>
<td>Source of Funding</td>
</tr>	
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>	
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>	
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>	
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>	
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>	
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>	
<tr>
<td>TOTAL</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>	


</table>


<div class="clearfix"></div>

</div>

