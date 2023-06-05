@extends('frontend.layouts.app')
@section('content')

<section class="profile">
<div class="container">  
<div class="row">  
<div class="col-md-10 offset-md-1">
<div class="profile-box">
@if(session()->has('profile_update'))
    <div class="alert alert-success" role="alert">Your profile has been successfully updated</div>
@endif 
@if(session()->has('profile_emirates_not_match'))
  <div class="alert alert-danger" role="alert">Your profile image not match with emirates id</div>
@endif 
@if(session()->has('emirates_id_number_not_match'))
  <div class="alert alert-danger" role="alert">Emirates ID's front photo not match with emirates ID number </div>
@endif 
@if(session()->has('emirates_not_face'))
      <div class="alert alert-danger" role="alert">Emirates id not valid</div>
@endif 
@if(session()->has('emirates_id_not_valid'))
      <div class="alert alert-danger" role="alert">Emirates id not valid</div>
@endif 
@if(session()->has('profile_not_face'))
      <div class="alert alert-danger" role="alert">Profile image not valid</div>
@endif 

<form action="{{ route('profile-update') }}" enctype="multipart/form-data" method="POST">
  {{ csrf_field() }}
<div class="row">  
<div class="col-md-3">
  @if($user->profile_image)
  <img class="p_img" id="blah" src="{!! asset($user->profile_image) !!}" alt="">
  @else
  <img src="{!! asset('assets/frontend/images/user_profile.png')  !!}" id="blah" class="p_img">
  @endif
  <input type="file" accept="image/png, image/jpeg, image/png" class="mgn20" id="imgInp" name="profile_image"> 
</div>
<div class="col-md-9">
<div class="row">  
<div class="col-md-4">
<label style="color: #fff; font-weight: 500; margin-bottom: 3px;">Name*</label>  
<input type="text" style="border: 0px; border-radius: 0px; margin-bottom: 16px; font-size: 14px; height: 42px;" value="{{ $user->name }}" name="name" required="true" class="form-control">
@if ($errors->has('name'))
<span class="text-danger">{{$errors->first('name')}}</span>
@endif
</div>
<div class="col-md-4">
<label style="color: #fff; font-weight: 500; margin-bottom: 3px;">Middle Name</label>  
<input type="text" style="border: 0px; border-radius: 0px; margin-bottom: 16px; font-size: 14px; height: 42px;" value="{{ $user->middle_name }}" name="middle_name" class="form-control">
@if ($errors->has('middle_name'))
<span class="text-danger">{{$errors->first('middle_name')}}</span>
@endif
</div>
<div class="col-md-4">
<label style="color: #fff; font-weight: 500; margin-bottom: 3px;">Last Name*</label>  
<input type="text" style="border: 0px; border-radius: 0px; margin-bottom: 16px; font-size: 14px; height: 42px;" value="{{ $user->last_name }}" name="last_name" required="true" class="form-control">
@if ($errors->has('last_name'))
<span class="text-danger">{{$errors->first('last_name')}}</span>
@endif
</div>
<div class="col-md-6 mgn20">
<label>Email*</label>  
<input type="email" value="{{ $user->email }}" name="email" required="true" class="form-control" readonly="">
@if ($errors->has('email'))
<span class="text-danger">{{$errors->first('email')}}</span>
@endif
</div>

<div class="col-md-6 mgn20">
<label>Mobile*</label>  
<input type="number" value="{{ $user->mobile }}" name="mobile" required="true" class="form-control" readonly="">
@if ($errors->has('mobile'))
<span class="text-danger">{{$errors->first('mobile')}}</span>
@endif
</div>

<div class="col-md-6 mgn20">
<label>Gender*</label>  
<select name="gender" class="form-control" required="true">
  <option value="Male" @if($user->gender == 'Male') selected @endif>Male</option>
  <option value="Female" @if($user->gender == 'Female') selected @endif>Female</option>
  <option value="Other" @if($user->gender == 'Other') selected @endif>Other</option>
</select>
@if($errors->has('gender'))
  <span class="text-danger">{{$errors->first('gender')}}</span>
@endif
</div>
<div class="col-md-6 mgn20">
<label>DOB*</label>  
@if($user->date_of_birth)
<input type="text"  value="{{ date('d M, Y', strtotime($user->date_of_birth)) }}" name="date_of_birth" required="true" class="form-control member_joining">
@else
<input type="text" placeholder="Enter your date of birth*" max="2004-08-01" value="{{ old('mobile') }}" name="date_of_birth" required="true" class="form-control member_joining">
@endif

@if ($errors->has('date_of_birth'))
<span class="text-danger">{{$errors->first('date_of_birth')}}</span>
@endif
</div> 
 
</div>
</div>

<div class="col-md-4">
    <label class="sub-label">Marital Status*</label>
    <select name="marital_status" onChange="MaritalStatus(this);" class="form-control">
      <option value="Single" @if($result) @if($result->marital_status == "Single") selected @endif @endif >Single</option>
      <option value="Married" @if($result) @if($result->marital_status == "Married") selected @endif @endif >Married</option>
      <option value="Others" @if($result) @if($result->marital_status == "Others") selected @endif @endif >Others</option>
    </select>
  </div>

  <div class="col-md-4 wife_name" @if($result) @if($result->marital_status != "Married") style="display: none;" @endif @else style="display: none;" @endif >
    <div class="form-group">
      <label class="sub-label">Spouse Name</label>
      <input name="wife_name" class="form-control" @if($result) @if($result->marital_status == "Married") @endif value="{{ $result->wife_name }}" @else value="{{ old('wife_name') }}" @endif type="text">
      @if($errors->has('wife_name'))
      <span class="text-danger">{{$errors->first('wife_name')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-4 wife_name" @if($result) @if($result->marital_status != "Married") style="display: none;" @endif @else style="display: none;" @endif >
    <div class="form-group">
      <label class="sub-label">Spouse DOB</label>
      <input name="spouse_date_of_birth" id="spouse_date_of_birth" class="form-control" @if($result) @if($result->marital_status == "Married") @endif value="{{ $result->spouse_date_of_birth }}" @else value="{{ old('spouse_date_of_birth') }}" @endif type="text">
      <!-- <i class="fa-solid fa-calendar"></i> -->
      @if($errors->has('spouse_date_of_birth'))
      <span class="text-danger">{{$errors->first('spouse_date_of_birth')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-4 wife_name" @if($result) @if($result->marital_status != "Married") style="display: none;" @endif @else style="display: none;" @endif >
    <div class="form-group">
      <label class="sub-label">Wedding Anniversary Date</label>
      <input name="wedding_anniversary_date" id="date_of_joining" class="form-control" @if($result) @if($result->marital_status == "Married") @endif value="{{ $result->wedding_anniversary_date }}" @else value="{{ old('wedding_anniversary_date') }}" @endif type="text">
      <!-- <i class="fa-solid fa-calendar"></i> -->
      @if($errors->has('wedding_anniversary_date'))
      <span class="text-danger">{{ $errors->first('wedding_anniversary_date') }}</span>
      @endif
    </div>
  </div>

  <div class="col-md-4">
    <label class="sub-label">Employment Type*</label>
    <select name="cm_type" class="form-control" required="true" onChange="RelationChange(this);">
      <option value="">Select</option>
      <option value="1" @if($cm_type == '') selected @endif @if($cm_type == 1) selected @endif>Salaried</option>
      <option value="2" @if($cm_type == 2) selected @endif>Self Employed</option>
      <option value="3" @if($cm_type == 3) selected @endif>Pension</option>
    </select>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label class="sub-label">Emirates ID Number*</label>
      <input name="eid_number" pattern="\d*" class="form-control" maxlength="15" minlength="15" value="{{ $user->eid_number }}" required="true" type="text">
      <div class="invalid_text" style="color: #f00;display: none;">Emirates ID is already exist. Try again</div> 
      @if($errors->has('eid_number'))
      <span class="text-danger">{{$errors->first('eid_number')}}</span>
      @endif
    </div>
  </div>

<div class="col-md-12"></div>
  <div class="col-md-4 mgnt20">
    <div class="form-group">
      <label class="sub-label">Upload front photo of Emirates id <span style="font-size: 13px;">(allowed file types (.jpg, .jpeg, *.png only) with maximum size 2mb.)*</span></label>
      @if(\Auth::user()->emirates_id)
        <input type="file" accept="image/png, image/jpg, image/jpeg" id="imgInp5" style="box-shadow: none; margin-top: 3px;" name="emirates_id_front">
        <img src="{!! asset(\Auth::user()->emirates_id) !!}" id="blah5" class="img-responsive" style="max-height: 110px; margin-top: 10px;">
      @else
          <input type="file" required="true" accept="image/png, image/jpg, image/jpeg" id="imgInp5" style="box-shadow: none; margin-top: 3px;" name="emirates_id_front">
          <img src="" id="blah5" class="img-responsive" style="max-height: 110px; margin-top: 10px;">
      @endif
      @if($errors->has('emirates_id_front'))
        <span class="text-danger">{{$errors->first('emirates_id_front')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-4 mgnt20">
    <div class="form-group">
      <label class="sub-label">Upload back photo of Emirates id <span style="font-size: 13px;">(allowed file types (.jpg, .jpeg, *.png only) with maximum size 2mb.)*</span></label>
      @if(\Auth::user()->emirates_id_back)
        <input type="file" accept="image/png, image/jpg, image/jpeg" id="imgInp1" style="box-shadow: none; margin-top: 3px;" name="emirates_id_back">
         <img src="{!! asset(\Auth::user()->emirates_id_back) !!}" id="blah1" class="img-responsive" style="max-height: 110px; margin-top: 10px;">
      @else
        <input type="file" required="true" accept="image/png, image/jpg, image/jpeg" id="imgInp1" style="box-shadow: none; margin-top: 3px;" name="emirates_id_back">
        <img src="" id="blah1" class="img-responsive" style="max-height: 110px; margin-top: 10px;">
      @endif
      @if($errors->has('emirates_id_back'))
        <span class="text-danger">{{$errors->first('emirates_id_back')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-4 mgnt20">
    <div class="form-group">
      <label class="sub-label">Upload passport photo <span style="font-size: 13px;">(allowed file types (.jpg, .jpeg, *.png only) with maximum size 2mb.)</span></label>
      @if(isset($result->passport_photo))
        <input type="file" accept="image/png, image/jpg, image/jpeg" id="imgInp2" style="box-shadow: none; margin-top: 3px;" name="passport_photo">
        <img src="{!! asset($result->passport_photo) !!}" id="blah2" class="img-responsive" style="max-height: 110px; margin-top: 10px;">
      @else
        <input type="file" accept="image/png, image/jpg, image/jpeg" id="imgInp2" style="box-shadow: none; margin-top: 3px;" name="passport_photo">
        <img src="" id="blah2" class="img-responsive" style="max-height: 110px; margin-top: 10px;">
      @endif
      @if($errors->has('passport_photo'))
        <span class="text-danger">{{$errors->first('passport_photo')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-4 mgnt20">
    <div class="form-group">
      <label class="sub-label">Passport Number*</label>
      <input name="passport_number" maxlength="16" class="form-control" required="true" @if($result) value="{{ $result->passport_number }}" @else value="{{ old('passport_number') }}" @endif type="text">
      @if($errors->has('passport_number'))
      <span class="text-danger">{{$errors->first('passport_number')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-4 mgnt20">
    <div class="form-group">
      <label class="sub-label">Passport Expiry Date*</label>
      <input name="passport_expiry_date" required="true" id="my_date_picker"  class="form-control" @if(isset($result->passport_expiry_date)) value="{{ $result->passport_expiry_date }}" @else value="{{ old('passport_expiry_date') }}" @endif type="text">
      @if($errors->has('passport_expiry_date'))
      <span class="text-danger">{{$errors->first('passport_expiry_date')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-12 mgnt20">
    <label style="color: #fff;font-size: 17px; font-weight: 600;">Bank Details</label>
  </div>
  <div class="col-md-4">
    <label class="sub-label">Account Number*</label>
    <input name="account_number" class="form-control" required="true" @if($coman) value="{{ $coman->account_number }}" @else value="{{ old('account_number') }}" @endif type="number">
  </div>
  <div class="col-md-4">
    <label class="sub-label">Bank Name*</label>
    <input name="bank_name" class="form-control" required="true" @if($coman) value="{{ $coman->bank_name }}" @else value="{{ old('bank_name') }}" @endif type="text">
  </div>
  <div class="col-md-4">
    <label class="sub-label">IBAN Number*</label>
    <input name="iban_number" class="form-control" required="true" @if($coman) value="{{ $coman->iban_number }}" @else value="{{ old('iban_number') }}" @endif type="text">
  </div>
  

  <div class="col-md-12 mgnt20">
    <label style="color: #fff;font-size: 17px; font-weight: 600;">Address Details</label>
  </div>
  <div class="col-md-4">
    <label class="sub-label">Residential Address Line 1*</label>
    <input name="residential_address_line_1" class="form-control" required="true" @if($address) value="{{ $address->residential_address_line_1 }}" @else value="{{ old('residential_address_line_1') }}" @endif type="text">
  </div>
  <div class="col-md-4">
    <label class="sub-label">Residential Address Line 2</label>
    <input name="residential_address_line_2" class="form-control" @if($address) value="{{ $address->residential_address_line_2 }}" @else value="{{ old('residential_address_line_2') }}" @endif type="text">
  </div>
  <div class="col-md-4">
    <label class="sub-label">Residential Address Line 3</label>
    <input name="residential_address_line_3" class="form-control" @if($address) value="{{ $address->residential_address_line_3 }}" @else value="{{ old('residential_address_line_3') }}" @endif type="text">
  </div>
  <div class="col-md-4 mgnt20">
    <label class="sub-label">Nearest Landmark*</label>
    <input name="residential_address_nearest_landmark" class="form-control" required="true" @if($address) value="{{ $address->residential_address_nearest_landmark }}" @else value="{{ old('residential_address_nearest_landmark') }}" @endif type="text">
  </div>

  <div class="col-md-4 mgnt20">
    <label class="sub-label">Emirate*</label>
    <input name="residential_emirate" class="form-control" required="true" @if($address) value="{{ $address->residential_emirate }}" @else value="{{ old('residential_emirate') }}" @endif type="text">
  </div>

  <div class="col-md-4 mgnt20">
    <label class="sub-label">PO Box No*</label>
    <input name="residential_po_box" class="form-control" required="true" @if($address) value="{{ $address->residential_po_box }}" @else value="{{ old('residential_po_box') }}" @endif type="text">
  </div>

  <div class="col-md-4 mgnt20">
    <label class="sub-label">Residence Type*</label>
    <select name="resdence_type" class="form-control" required="true">
        <option value="">Select</option>
        @if($address)
        <option value="Shared" @if($address->resdence_type == 'Shared') selected @endif >Shared</option>
        <option value="Rented" @if($address->resdence_type == 'Rented') selected @endif >Rented</option>
        <option value="Owned" @if($address->resdence_type == 'Owned') selected @endif >Owned</option>
        <option value="Employer Provided" @if($address->resdence_type == 'mployer Provided') selected @endif >Employer Provided</option>
        <option value="Living With Parents" @if($address->resdence_type == 'Living With Parents') selected @endif >Living With Parents</option>
        @else
        <option value="Shared">Shared</option>
        <option value="Rented">Rented</option>
        <option value="Owned">Owned</option>
        <option value="Employer Provided">Employer Provided</option>
        <option value="Living With Parents">Living With Parents</option>
        @endif
      </select>
  </div>

  <div class="col-md-4 mgnt20">
    <label class="sub-label">Annual Rent</label>
    <input name="annual_rent" class="form-control" @if($address) value="{{ $address->annual_rent }}" @else value="{{ old('annual_rent') }}" @endif type="text">
  </div>

  <div class="col-md-4 mgnt20">
    <label class="sub-label">Duration At Current Address*</label>
    <input name="duration_at_current_address" class="form-control" required="true" @if($address) value="{{ $address->duration_at_current_address }}" @else value="{{ old('duration_at_current_address') }}" @endif type="text">
  </div>


<div class="col-md-12 submit_field text-center">
    <input type="submit" name="submit" class="emirates_front_btn" value="Update" style="border: 0px; height: 45px;">
</div>


</div>
</div>
</form>
</div>
</div>
</div>
</div>
</section>

<style type="text/css">
.sub-label {
  color: #fff;
  font-weight: 500;
  margin-bottom: 3px;
}
.mgnt20{
  margin-top: 20px;
}

.form-control {
    border: 0px;
    border-radius: 0px;
    margin-bottom: 16px;
    font-size: 14px;
    height: 42px;
}




</style>

<script type="text/javascript">
  
  function MaritalStatus(that) {
    if (that.value == "Married") {
      $(".wife_name").show();
      // $(".wife_name input").attr("required", true);
    } else {
      $(".wife_name").hide();
      // $(".wife_name input").removeAttr('required');
    }
  }

</script>


@endsection    