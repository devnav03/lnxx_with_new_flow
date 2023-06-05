@extends('frontend.layouts.app')
@section('content')

<section class="personal_details edu_dt">
<div class="container">  
<div class="row">  
<div class="col-md-7">
<div class="personal_details_box">
<h1 class="app_form_head">Application Form</h1> 
<h2 style="margin-bottom: 15px;">Your Financial Details</h2>
<!-- <h6>Please enter your information to check the offer.</h6> -->

<form action="{{ route('save-products-requested') }}" method="post">
{{ csrf_field() }}  

<div class="row">

<div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Variable Income (in AED)</label>
      <input name="variable_income" style="margin-bottom: 0px;" pattern="\d*" maxlength="6" class="form-control" @if($result) value="{{ $result->variable_income }}" @else value="{{ old('variable_income') }}" @endif type="text">
      @if($errors->has('variable_income'))
      <span class="text-danger">{{$errors->first('variable_income')}}</span>
      @endif
    </div>
</div>
<div class="col-md-6"></div>

<input type="hidden" name="request_page" value="1">
  @if(in_array(3, $services))
  <div class="col-md-12">
    <h5 style="font-size: 17px; margin-top: 15px;">Details for credit card</h5>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Required credit card limit (in AED)</label>
      <input name="credit_card_limit" pattern="\d*" maxlength="6" class="form-control" @if($result) value="{{ $result->credit_card_limit }}" @else value="{{ old('credit_card_limit') }}" @endif type="text">
      @if($errors->has('credit_card_limit'))
      <span class="text-danger">{{$errors->first('credit_card_limit')}}</span>
      @endif
    </div>
  </div>
  @endif
  <div class="col-md-12">
    <label style="font-weight: 500; margin-bottom: 1px;">Do you have any exisiting credit card?</label><br>
      <span>No</span>&nbsp; <label class="switch">
      <input type="checkbox" class="cred_value" @if($result) @if($result->exist_credit == 1) checked="true" @endif @endif name="exist_credit" onclick="credvalue(this.value);" value="1"> 
    <span class="slider round"></span>
    </label>&nbsp; <span>Yes</span>
  </div>

  <div class="col-md-12 exist_credit" @if($result) @if($result->exist_credit == 0) style="display: none;"  @endif @else style="display: none;" @endif >
  <div class="row">
  <div class="col-md-12" style="margin-top: 15px;">
    <label style="font-size: 14px; margin-top: -10px;">Details of existing credit card</label>
  </div>
  <!-- <div class="col-md-6 exist_credit_field">
    <div class="form-group">
      <label class="sub-label">Details of cards*</label>
      <select name="details_of_cards" class="form-control" required="true">
        @if($result)
        <option value="Credit Card" @if($result->details_of_cards == 'Credit Card') selected @endif>Credit Card</option>
        <option value="Debit Card" @if($result->details_of_cards == 'Debit Card') selected @endif>Debit Card</option>
        @else
        <option value="Credit Card">Credit Card</option>
        <option value="Debit Card">Debit Card</option>
        @endif
      </select>
      @if($errors->has('details_of_cards'))
      <span class="text-danger">{{$errors->first('details_of_cards')}}</span>
      @endif
    </div>
  </div> -->

  <div class="col-md-6 exist_credit_field">
    <div class="form-group">
      <label class="sub-label">Bank name*</label>
      <select name="credit_bank_name" class="form-control">
          <option value="">Select</option>
          @foreach($banks as $bank)
          <option value="{{ $bank->id }}" @if($result) @if($result->credit_bank_name == $bank->id) selected @endif @endif >{{ $bank->name }}</option>
          @endforeach
      </select>

      @if($errors->has('credit_bank_name'))
      <span class="text-danger">{{$errors->first('credit_bank_name')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-6 exist_credit_field">
    <div class="form-group">
      <label class="sub-label">Card limit (in AED)*</label>
      <input name="card_limit" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->card_limit }}" @else value="{{ old('card_limit') }}" @endif type="text">
      @if($errors->has('card_limit'))
      <span class="text-danger">{{$errors->first('card_limit')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-6 exist_credit_field">
    <div class="form-group">
      <label class="sub-label">Member since*</label>
      <input name="credit_member_since" id="credit_member_since" class="form-control member_joining" @if($result) value="{{ $result->credit_member_since }}" @else value="{{ old('credit_member_since') }}" @endif type="text">
      <i class="fa-solid fa-calendar"></i>
      @if($errors->has('credit_member_since'))
      <span class="text-danger">{{$errors->first('credit_member_since')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-12" @if(isset($result->card_limit2)) @if($result->card_limit2 != '') style="display:none;" @endif @endif>
    <a class="add_more_btn credit_card1_open"> + Add More</a>
  </div> 
  </div>

  <div class="row credit_card1" @if(isset($result->card_limit2)) @if($result->card_limit2 == '') style="display:none;" @endif @else style="display:none;"  @endif>

    <div class="col-md-12">
      <div style="border-top: 1px solid #f3f3f3;padding-bottom: 5px;"><a class="del_fdt" onclick="credit_card1del();"> Delete</a></div>
    </div>
  <!--   <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Details of cards</label>
      <select name="details_of_cards2" class="form-control" required="true">
        @if($result)
        <option value="Credit Card" @if($result->details_of_cards2 == 'Credit Card') selected @endif>Credit Card</option>
        <option value="Debit Card" @if($result->details_of_cards2 == 'Debit Card') selected @endif>Debit Card</option>
        @else
        <option value="Credit Card">Credit Card</option>
        <option value="Debit Card">Debit Card</option>
        @endif
      </select>
      @if($errors->has('details_of_cards2'))
      <span class="text-danger">{{$errors->first('details_of_cards2')}}</span>
      @endif
    </div>
  </div> -->

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Bank name</label>
      <select name="credit_bank_name2" class="form-control">
          <option value="">Select</option>
          @foreach($banks as $bank)
          <option value="{{ $bank->id }}" @if($result) @if($result->credit_bank_name2 == $bank->id) selected @endif @endif >{{ $bank->name }}</option>
          @endforeach
      </select>

      @if($errors->has('credit_bank_name2'))
      <span class="text-danger">{{$errors->first('credit_bank_name2')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Card limit (in AED)</label>
      <input name="card_limit2" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->card_limit2 }}" @else value="{{ old('card_limit2') }}" @endif type="text">
      @if($errors->has('card_limit2'))
      <span class="text-danger">{{$errors->first('card_limit2')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Member since</label>
      <input name="credit_member_since2" class="form-control member_joining" @if($result) value="{{ $result->credit_member_since2 }}" @else value="{{ old('credit_member_since2') }}" @endif type="text">
      <i class="fa-solid fa-calendar"></i>
      @if($errors->has('credit_member_since2'))
      <span class="text-danger">{{$errors->first('credit_member_since2')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-12" @if(isset($result->card_limit3)) @if($result->card_limit3 != '') style="display:none;" @endif @endif>
    <a class="add_more_btn credit_card2_open"><span>+</span> Add More</a>
  </div> 
  </div>

  <div class="row credit_card2" @if(isset($result->card_limit3)) @if($result->card_limit3 == '') style="display:none;" @endif @else style="display:none;"  @endif>
    <div class="col-md-12">
      <div style="border-top: 1px solid #f3f3f3;padding-bottom: 5px;"><a class="del_fdt" onclick="credit_card2del();"> Delete</a></div>
    </div>
    <!-- <div class="col-md-6">
      <div class="form-group">
        <label class="sub-label">Details of cards</label>
        <select name="details_of_cards3" class="form-control" required="true">
          @if($result)
          <option value="Credit Card" @if($result->details_of_cards3 == 'Credit Card') selected @endif>Credit Card</option>
          <option value="Debit Card" @if($result->details_of_cards3 == 'Debit Card') selected @endif>Debit Card</option>
          @else
          <option value="Credit Card">Credit Card</option>
          <option value="Debit Card">Debit Card</option>
          @endif
        </select>
        @if($errors->has('details_of_cards3'))
        <span class="text-danger">{{$errors->first('details_of_cards3')}}</span>
        @endif
      </div>
    </div> -->

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Bank name</label>
      <select name="credit_bank_name3" class="form-control">
          <option value="">Select</option>
          @foreach($banks as $bank)
          <option value="{{ $bank->id }}" @if($result) @if($result->credit_bank_name3 == $bank->id) selected @endif @endif >{{ $bank->name }}</option>
          @endforeach
      </select>
      @if($errors->has('credit_bank_name3'))
      <span class="text-danger">{{$errors->first('credit_bank_name3')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Card limit (in AED)</label>
      <input name="card_limit3" class="form-control" id="credit_card2input" pattern="\d*" maxlength="6" @if($result) value="{{ $result->card_limit3 }}" @else value="{{ old('card_limit3') }}" @endif type="text">
      @if($errors->has('card_limit3'))
      <span class="text-danger">{{$errors->first('card_limit3')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Member since</label>
      <input name="credit_member_since3" class="form-control member_joining" @if($result) value="{{ $result->credit_member_since3 }}" @else value="{{ old('credit_member_since3') }}" @endif type="text">
      <i class="fa-solid fa-calendar"></i>
      @if($errors->has('credit_member_since3'))
      <span class="text-danger">{{$errors->first('credit_member_since3')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-12" @if(isset($result->card_limit4)) @if($result->card_limit4 != '') style="display:none;" @endif @endif>
    <a class="add_more_btn credit_card3_open"><span>+</span> Add More</a>
  </div> 
  </div>

  <div class="row credit_card3" @if(isset($result->card_limit4)) @if($result->card_limit4 == '') style="display:none;" @endif @else style="display:none;"  @endif>

    <div class="col-md-12">
      <div style="border-top: 1px solid #f3f3f3;padding-bottom: 5px;"><a class="del_fdt" onclick="credit_card3del();"> Delete</a></div>
    </div>

  <!--   <div class="col-md-6">
      <div class="form-group">
        <label class="sub-label">Details of cards</label>
        <select name="details_of_cards4" class="form-control" required="true">
          @if($result)
          <option value="Credit Card" @if($result->details_of_cards4 == 'Credit Card') selected @endif>Credit Card</option>
          <option value="Debit Card" @if($result->details_of_cards4 == 'Debit Card') selected @endif>Debit Card</option>
          @else
          <option value="Credit Card">Credit Card</option>
          <option value="Debit Card">Debit Card</option>
          @endif
        </select>
        @if($errors->has('details_of_cards4'))
        <span class="text-danger">{{$errors->first('details_of_cards4')}}</span>
        @endif
      </div>
    </div> -->

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Bank name</label>
      <select name="credit_bank_name4" class="form-control">
          <option value="">Select</option>
          @foreach($banks as $bank)
          <option value="{{ $bank->id }}" @if($result) @if($result->credit_bank_name4 == $bank->id) selected @endif @endif >{{ $bank->name }}</option>
          @endforeach
      </select>
      @if($errors->has('credit_bank_name4'))
      <span class="text-danger">{{$errors->first('credit_bank_name4')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Card limit (in AED)</label>
      <input name="card_limit4" class="form-control" id="credit_card3input" pattern="\d*" maxlength="6" @if($result) value="{{ $result->card_limit4 }}" @else value="{{ old('card_limit4') }}" @endif type="text">
      @if($errors->has('card_limit4'))
      <span class="text-danger">{{$errors->first('card_limit4')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Member since</label>
      <input name="credit_member_since4" class="form-control member_joining" @if($result) value="{{ $result->credit_member_since4 }}" @else value="{{ old('credit_member_since4') }}" @endif type="text">
      <i class="fa-solid fa-calendar"></i>
      @if($errors->has('credit_member_since4'))
      <span class="text-danger">{{$errors->first('credit_member_since4')}}</span>
      @endif
    </div>
  </div>
  </div>
</div>
</div>

  <div class="row" style="background: #f7f7f7; margin-top: 20px;">
  <div class="col-md-12">
    <h5 style="font-size: 17px; margin-top: 15px;">Details for personal loan</h5>
  </div>
  @if(in_array(1, $services))
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Required loan amount (in AED)</label>
      <input name="loan_amount" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->loan_amount }}" @else value="{{ old('loan_amount') }}" @endif type="text">
      @if($errors->has('loan_amount'))
      <span class="text-danger">{{$errors->first('loan_amount')}}</span>
      @endif
    </div>
  </div>
  @endif
  
  <div class="col-md-12" style="margin-bottom: 15px;">
    <label style="font-weight: 500; margin-bottom: 1px;">Do you have any exisiting personal loan?</label><br>
      <span>No</span>&nbsp; <label class="switch">
      <input type="checkbox" class="personal_value" @if($result) @if($result->exist_personal == 1) checked="true" @endif @endif name="exist_personal" onclick="Personalvalue(this.value);" value="1"> 
    <span class="slider round"></span>
    </label>&nbsp; <span>Yes</span>
  </div>

  <div class="col-md-12 exist_personal" @if($result) @if($result->exist_personal == 0) style="display: none;"  @endif @else style="display: none;" @endif>
  <div class="row">
  <div class="col-md-12">
    <label style="font-size: 14px; margin-top: -10px;">Details of existing financial products</label>
  </div>
  
  <div class="col-md-6 exist_personal_field">
    <div class="form-group">
      <label class="sub-label">Bank name*</label>
      <select name="loan_bank_name" class="form-control">
          <option value="">Select</option>
          @foreach($banks as $bank)
          <option value="{{ $bank->id }}" @if($result) @if($result->loan_bank_name == $bank->id) selected @endif @endif >{{ $bank->name }}</option>
          @endforeach
      </select>
      @if($errors->has('loan_bank_name'))
      <span class="text-danger">{{$errors->first('loan_bank_name')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-6 exist_personal_field">
    <div class="form-group">
      <label class="sub-label">Original loan amount (in AED)*</label>
      <input name="original_loan_amount" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->original_loan_amount }}" @else value="{{ old('original_loan_amount') }}" @endif type="text">
      @if($errors->has('original_loan_amount'))
      <span class="text-danger">{{$errors->first('original_loan_amount')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-6 exist_personal_field">
    <div class="form-group">
      <label class="sub-label">EMI (in AED)*</label>
      <input name="loan_emi" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->loan_emi }}" @else value="{{ old('loan_emi') }}" @endif type="text">
      @if($errors->has('loan_emi'))
      <span class="text-danger">{{$errors->first('loan_emi')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6 exist_personal_field">
    <div class="form-group">
      <label class="sub-label">No. of EMI Paid (in AED)</label>
      <input name="loan_member_since" class="form-control remove_valid" @if($result) value="{{ $result->loan_member_since }}" @else value="{{ old('loan_member_since') }}" @endif pattern="\d*" maxlength="4" type="text">
      @if($errors->has('loan_member_since'))
      <span class="text-danger">{{$errors->first('loan_member_since')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-12" @if(isset($result->loan_emi2)) @if($result->loan_emi2 != '') style="display:none;" @endif @endif>
    <a class="add_more_btn loan_bus2_open"><span>+</span> Add More</a>
  </div> 
  </div>

  <div class="row bus_lon2" @if(isset($result->loan_emi2)) @if($result->loan_emi2 == '') style="display:none; background: #f7f7f7;" @else style="background: #f7f7f7;" @endif @else style="display:none;background: #f7f7f7;"  @endif>
  <div class="col-md-12">
      <div style="border-top: 1px solid #f3f3f3;padding-bottom: 5px;"><a class="del_fdt" onclick="bus_lon2del();"> Delete</a></div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Bank name</label>
     <!--  <input name="loan_bank_name2" class="form-control" @if($result) value="{{ $result->loan_bank_name2 }}" @else value="{{ old('loan_bank_name2') }}" @endif type="text"> -->
      <select name="loan_bank_name2" class="form-control">
          <option value="">Select</option>
          @foreach($banks as $bank)
          <option value="{{ $bank->id }}" @if($result) @if($result->loan_bank_name2 == $bank->id) selected @endif @endif >{{ $bank->name }}</option>
          @endforeach
      </select>
      @if($errors->has('loan_bank_name2'))
      <span class="text-danger">{{$errors->first('loan_bank_name2')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Original loan amount (in AED)</label>
      <input name="original_loan_amount2" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->original_loan_amount2 }}" @else value="{{ old('original_loan_amount2') }}" @endif type="text">
      @if($errors->has('original_loan_amount2'))
      <span class="text-danger">{{$errors->first('original_loan_amount2')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">EMI (in AED)</label>
      <input name="loan_emi2" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->loan_emi2 }}" @else value="{{ old('loan_emi2') }}" @endif type="text">
      @if($errors->has('loan_emi2'))
      <span class="text-danger">{{$errors->first('loan_emi2')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">No. of EMI Paid (in AED)</label>
      <input name="loan_member_since2" class="form-control" @if($result) value="{{ $result->loan_member_since2 }}" @else value="{{ old('loan_member_since2') }}" @endif pattern="\d*" maxlength="4" type="text">
      @if($errors->has('loan_member_since2'))
      <span class="text-danger">{{$errors->first('loan_member_since2')}}</span>
      @endif
    </div>
  </div>
  
  <div class="col-md-12" @if(isset($result->loan_emi3)) @if($result->loan_emi3 != '') style="display:none;" @endif @endif>
    <a class="add_more_btn loan_bus3_open"><span>+</span> Add More</a>
  </div>
  </div>

  <div class="row bus_lon3"  @if(isset($result->loan_emi3)) @if($result->loan_emi3 == '') style="display:none;background: #f7f7f7;" @else style="background: #f7f7f7;"  @endif @else style="display:none;background: #f7f7f7;"  @endif>
  <div class="col-md-12">
      <div style="border-top: 1px solid #f3f3f3;padding-bottom: 5px;"><a class="del_fdt" onclick="bus_lon3del();"> Delete</a></div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Bank name</label>
      <select name="loan_bank_name3" class="form-control">
          <option value="">Select</option>
          @foreach($banks as $bank)
          <option value="{{ $bank->id }}" @if($result) @if($result->loan_bank_name3 == $bank->id) selected @endif @endif >{{ $bank->name }}</option>
          @endforeach
      </select>
      @if($errors->has('loan_bank_name3'))
      <span class="text-danger">{{$errors->first('loan_bank_name3')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Original loan amount (in AED)</label>
      <input name="original_loan_amount3" pattern="\d*" maxlength="6" class="form-control" @if($result) value="{{ $result->original_loan_amount3 }}" @else value="{{ old('original_loan_amount3') }}" @endif type="text">
      @if($errors->has('original_loan_amount3'))
      <span class="text-danger">{{$errors->first('original_loan_amount3')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">EMI (in AED)</label>
      <input name="loan_emi3" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->loan_emi3 }}" @else value="{{ old('loan_emi3') }}" @endif type="text">
      @if($errors->has('loan_emi3'))
      <span class="text-danger">{{$errors->first('loan_emi3')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">No. of EMI Paid (in AED)</label>
      <input name="loan_member_since3" class="form-control" @if($result) value="{{ $result->loan_member_since3 }}" @else value="{{ old('loan_member_since3') }}" @endif pattern="\d*" maxlength="4" type="text">
      @if($errors->has('loan_member_since3'))
      <span class="text-danger">{{$errors->first('loan_member_since3')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-12" @if(isset($result->loan_emi4)) @if($result->loan_emi4 != '') style="display:none;" @endif @endif>
    <a class="add_more_btn loan_bus4_open"><span>+</span> Add More</a>
  </div>
  </div>

  <div class="row bus_lon4" @if(isset($result->loan_emi4)) @if($result->loan_emi4 == '') style="display:none;background: #f7f7f7;" @else style="background: #f7f7f7;"  @endif @else style="display:none;background: #f7f7f7;"  @endif>
  <div class="col-md-12">
      <div style="border-top: 1px solid #f3f3f3;padding-bottom: 5px;"><a class="del_fdt" onclick="bus_lon4del();"> Delete</a></div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Bank name</label>
      <select name="loan_bank_name4" class="form-control">
          <option value="">Select</option>
          @foreach($banks as $bank)
          <option value="{{ $bank->id }}" @if($result) @if($result->loan_bank_name4 == $bank->id) selected @endif @endif >{{ $bank->name }}</option>
          @endforeach
      </select>
      @if($errors->has('loan_bank_name4'))
      <span class="text-danger">{{$errors->first('loan_bank_name4')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Original loan amount (in AED)</label>
      <input name="original_loan_amount4" pattern="\d*" maxlength="6" class="form-control" @if($result) value="{{ $result->original_loan_amount4 }}" @else value="{{ old('original_loan_amount4') }}" @endif type="text">
      @if($errors->has('original_loan_amount4'))
      <span class="text-danger">{{$errors->first('original_loan_amount4')}}</span>
      @endif
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">EMI (in AED)</label>
      <input name="loan_emi4" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->loan_emi4 }}" @else value="{{ old('loan_emi3') }}" @endif type="text">
      @if($errors->has('loan_emi4'))
      <span class="text-danger">{{$errors->first('loan_emi4')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">No. of EMI Paid (in AED)</label>
      <input name="loan_member_since4" class="form-control" @if($result) value="{{ $result->loan_member_since4 }}" @else value="{{ old('loan_member_since4') }}" @endif pattern="\d*" maxlength="4" type="text">
      @if($errors->has('loan_member_since4'))
      <span class="text-danger">{{$errors->first('loan_member_since4')}}</span>
      @endif
    </div>
  </div>
  </div>
  </div>
  </div>
  

  <div class="row">

  <div class="col-md-12" style="margin-bottom: 15px;margin-top: 15px;">
      <label style="font-weight: 500; margin-bottom: 1px;">Do you have any exisiting mortgage loan?</label><br>
        <span>No</span>&nbsp; <label class="switch">
        <input type="checkbox" class="mortgage_value" @if($result) @if($result->exist_mortgage == 1) checked="true" @endif @endif name="exist_mortgage" onclick="Mortgagevalue(this.value);" value="1"> 
      <span class="slider round"></span>
      </label>&nbsp; <span>Yes</span>
    </div>

  <div class="col-md-12 exist_mortgage" @if($result) @if($result->exist_mortgage == 0) style="display: none;"  @endif @else style="display: none;" @endif >
  <div class="row">

  <div class="col-md-12">
    <h5 style="font-size: 17px; margin-top: 15px;">Details of existing mortgage loan</h5>
  </div>
  
  <div class="col-md-6 exist_mortgage_field">
    <div class="form-group">
      <label class="sub-label">Loan amount (in AED)*</label>
      <input name="mortgage_loan_amount" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->mortgage_loan_amount }}" @else value="{{ old('mortgage_loan_amount') }}" @endif type="text">
      @if($errors->has('mortgage_loan_amount'))
      <span class="text-danger">{{$errors->first('mortgage_loan_amount')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6 exist_mortgage_field">
    <div class="form-group">
      <label class="sub-label">Purchase price/current market valuation (in AED)*</label>
      <input name="purchase_price" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->purchase_price }}" @else value="{{ old('purchase_price') }}" @endif type="text">
      @if($errors->has('purchase_price'))
      <span class="text-danger">{{$errors->first('purchase_price')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6 exist_mortgage_field">
    <div class="form-group">
      <label class="sub-label">Type of loan*</label>
      <select name="type_of_loan" class="form-control" required="true">
        @if($result)
        <option value="Primary Sale" @if($result->type_of_loan == 'Primary Sale') selected @endif>Primary Sale</option>
        <option value="Secondary Sale" @if($result->type_of_loan == 'Secondary Sale') selected @endif>Secondary Sale</option>
        <option value="Buyout" @if($result->type_of_loan == 'Buyout') selected @endif>Buyout</option>
        <option value="Equity" @if($result->type_of_loan == 'Equity') selected @endif>Equity</option>
        <option value="Top up" @if($result->type_of_loan == 'Top up') selected @endif>Top up</option>
        @else
        <option value="Primary Sale">Primary Sale</option>
        <option value="Secondary Sale">Secondary Sale</option>
        <option value="Buyout">Buyout</option>
        <option value="Equity">Equity</option>
        <option value="Top up">Top up</option>
        @endif
      </select>
      @if($errors->has('type_of_loan'))
      <span class="text-danger">{{$errors->first('type_of_loan')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6 exist_mortgage_field">
    <div class="form-group">
      <label class="sub-label">Term of loan*</label>
      <input name="term_of_loan" class="form-control" @if($result) value="{{ $result->term_of_loan }}" @else value="{{ old('term_of_loan') }}" @endif type="text">
      @if($errors->has('term_of_loan'))
      <span class="text-danger">{{$errors->first('term_of_loan')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6 exist_mortgage_field">
    <div class="form-group">
      <label class="sub-label">End use of property*</label>
      <select name="end_use_of_property" class="form-control" required="true">
        @if($result)
        <option value="Self use" @if($result->end_use_of_property == 'Self use') selected @endif>Self use</option>
        <option value="Rental" @if($result->end_use_of_property == 'Rental') selected @endif>Rental</option>
        @else
        <option value="Self use">Self use</option>
        <option value="Secondary Sale">Secondary Sale</option>
        @endif
      </select>
      @if($errors->has('end_use_of_property'))
      <span class="text-danger">{{$errors->first('end_use_of_property')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6 exist_mortgage_field">
    <div class="form-group">
      <label class="sub-label">Interest rate*</label>
      <input name="interest_rate" class="form-control" pattern="\d*" maxlength="3" @if($result) value="{{ $result->interest_rate }}" @else value="{{ old('interest_rate') }}" @endif type="text">
      @if($errors->has('interest_rate'))
      <span class="text-danger">{{$errors->first('interest_rate')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6 exist_mortgage_field">
    <div class="form-group">
      <label class="sub-label">EMI (in AED)*</label>
      <input name="mortgage_emi" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->mortgage_emi }}" @else value="{{ old('mortgage_emi') }}" @endif type="text">
      @if($errors->has('mortgage_emi'))
      <span class="text-danger">{{$errors->first('mortgage_emi')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6 exist_mortgage_field">
      <div class="form-group">
        <label class="sub-label">No. of EMI Paid (in AED)</label>
        <input name="mortgage_member_since" class="form-control remove_valid" @if($result) value="{{ $result->mortgage_member_since }}" @else value="{{ old('mortgage_member_since') }}" @endif pattern="\d*" maxlength="4" type="text">
        @if($errors->has('mortgage_member_since'))
        <span class="text-danger">{{$errors->first('mortgage_member_since')}}</span>
        @endif
      </div>
  </div>

  <div class="col-md-12" @if(isset($result->mortgage_loan_amount2)) @if($result->mortgage_loan_amount2 != '') style="display:none;" @endif @endif>
    <a class="add_more_btn mortgage_loan2_open"><span>+</span> Add More</a>
  </div> 
  </div>

  <div class="row mortgage_loan2" @if(isset($result->mortgage_loan_amount2)) @if($result->mortgage_loan_amount2 == '') style="display:none;" @else style="background: #f7f7f7;" @endif @else style="display:none;"  @endif>
  <div class="col-md-12">
      <div style="border-top: 1px solid #f3f3f3;padding-bottom: 5px;"><a class="del_fdt" onclick="mortgage_loan2del();"> Delete</a></div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Loan amount (in AED)</label>
      <input name="mortgage_loan_amount2" pattern="\d*" maxlength="6" class="form-control" @if($result) value="{{ $result->mortgage_loan_amount2 }}" @else value="{{ old('mortgage_loan_amount2') }}" @endif type="text">
      @if($errors->has('mortgage_loan_amount2'))
      <span class="text-danger">{{$errors->first('mortgage_loan_amount2')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Purchase price/current market valuation (in AED)</label>
      <input name="purchase_price2" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->purchase_price2 }}" @else value="{{ old('purchase_price2') }}" @endif type="text">
      @if($errors->has('purchase_price2'))
      <span class="text-danger">{{$errors->first('purchase_price2')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Type of loan</label>
      <select name="type_of_loan2" class="form-control" required="true">
        @if($result)
        <option value="Primary Sale" @if($result->type_of_loan2 == 'Primary Sale') selected @endif>Primary Sale</option>
        <option value="Secondary Sale" @if($result->type_of_loan2 == 'Secondary Sale') selected @endif>Secondary Sale</option>
        <option value="Buyout" @if($result->type_of_loan2 == 'Buyout') selected @endif>Buyout</option>
        <option value="Equity" @if($result->type_of_loan2 == 'Equity') selected @endif>Equity</option>
        <option value="Top up" @if($result->type_of_loan2 == 'Top up') selected @endif>Top up</option>
        @else
        <option value="Primary Sale">Primary Sale</option>
        <option value="Secondary Sale">Secondary Sale</option>
        <option value="Buyout">Buyout</option>
        <option value="Equity">Equity</option>
        <option value="Top up">Top up</option>
        @endif
      </select>
      @if($errors->has('type_of_loan2'))
      <span class="text-danger">{{$errors->first('type_of_loan2')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Term of loan</label>
      <input name="term_of_loan2" class="form-control" @if($result) value="{{ $result->term_of_loan2 }}" @else value="{{ old('term_of_loan2') }}" @endif type="text">
      @if($errors->has('term_of_loan2'))
      <span class="text-danger">{{$errors->first('term_of_loan2')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">End use of property</label>
      <select name="end_use_of_property2" class="form-control" required="true">
        @if($result)
        <option value="Self use" @if($result->end_use_of_property2 == 'Self use') selected @endif>Self use</option>
        <option value="Rental" @if($result->end_use_of_property2 == 'Rental') selected @endif>Rental</option>
        @else
        <option value="Self use">Self use</option>
        <option value="Secondary Sale">Secondary Sale</option>
        @endif
      </select>
      @if($errors->has('end_use_of_property2'))
      <span class="text-danger">{{$errors->first('end_use_of_property2')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Interest rate</label>
      <input name="interest_rate2" class="form-control" pattern="\d*" maxlength="3" @if($result) value="{{ $result->interest_rate2 }}" @else value="{{ old('interest_rate2') }}" @endif type="text">
      @if($errors->has('interest_rate2'))
      <span class="text-danger">{{$errors->first('interest_rate2')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">EMI (in AED)</label>
      <input name="mortgage_emi2" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->mortgage_emi2 }}" @else value="{{ old('mortgage_emi2') }}" @endif type="text">
      @if($errors->has('mortgage_emi2'))
      <span class="text-danger">{{$errors->first('mortgage_emi2')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
      <div class="form-group">
        <label class="sub-label">No. of EMI Paid (in AED)</label>
        <input name="mortgage_member_since2" class="form-control" @if($result) value="{{ $result->mortgage_member_since2 }}" @else value="{{ old('mortgage_member_since2') }}" @endif pattern="\d*" maxlength="4" type="text">
        @if($errors->has('mortgage_member_since2'))
        <span class="text-danger">{{$errors->first('mortgage_member_since2')}}</span>
        @endif
      </div>
    </div>
  <div class="col-md-12" @if(isset($result->mortgage_loan_amount3)) @if($result->mortgage_loan_amount3 != '') style="display:none;" @endif @endif>
    <a class="add_more_btn mortgage_loan3_open"><span>+</span> Add More</a>
  </div>
  </div>

  <div class="row mortgage_loan3" @if(isset($result->mortgage_loan_amount3)) @if($result->mortgage_loan_amount3 == '') style="display:none;background: #fff;" @else style="background: #f7f7f7;" @endif @else style="display:none;background: #fff;"  @endif>
  
  <div class="col-md-12">
      <div style="border-top: 1px solid #f3f3f3;padding-bottom: 5px;"><a class="del_fdt" onclick="mortgage_loan3del();"> Delete</a></div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Loan amount (in AED)</label>
      <input name="mortgage_loan_amount3" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->mortgage_loan_amount3 }}" @else value="{{ old('mortgage_loan_amount3') }}" @endif type="text">
      @if($errors->has('mortgage_loan_amount3'))
      <span class="text-danger">{{$errors->first('mortgage_loan_amount3')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Purchase price/current market valuation (in AED)</label>
      <input name="purchase_price3" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->purchase_price3 }}" @else value="{{ old('purchase_price3') }}" @endif type="text">
      @if($errors->has('purchase_price3'))
      <span class="text-danger">{{$errors->first('purchase_price3')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Type of loan</label>
      <select name="type_of_loan3" class="form-control" required="true">
        @if($result)
        <option value="Primary Sale" @if($result->type_of_loan3 == 'Primary Sale') selected @endif>Primary Sale</option>
        <option value="Secondary Sale" @if($result->type_of_loan3 == 'Secondary Sale') selected @endif>Secondary Sale</option>
        <option value="Buyout" @if($result->type_of_loan3 == 'Buyout') selected @endif>Buyout</option>
        <option value="Equity" @if($result->type_of_loan3 == 'Equity') selected @endif>Equity</option>
        <option value="Top up" @if($result->type_of_loan3 == 'Top up') selected @endif>Top up</option>
        @else
        <option value="Primary Sale">Primary Sale</option>
        <option value="Secondary Sale">Secondary Sale</option>
        <option value="Buyout">Buyout</option>
        <option value="Equity">Equity</option>
        <option value="Top up">Top up</option>
        @endif
      </select>
      @if($errors->has('type_of_loan3'))
      <span class="text-danger">{{$errors->first('type_of_loan3')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Term of loan</label>
      <input name="term_of_loan3" class="form-control" @if($result) value="{{ $result->term_of_loan3 }}" @else value="{{ old('term_of_loan3') }}" @endif type="text">
      @if($errors->has('term_of_loan3'))
      <span class="text-danger">{{$errors->first('term_of_loan3')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">End use of property</label>
      <select name="end_use_of_property3" class="form-control" required="true">
        @if($result)
        <option value="Self use" @if($result->end_use_of_property3 == 'Self use') selected @endif>Self use</option>
        <option value="Rental" @if($result->end_use_of_property3 == 'Rental') selected @endif>Rental</option>
        @else
        <option value="Self use">Self use</option>
        <option value="Secondary Sale">Secondary Sale</option>
        @endif
      </select>
      @if($errors->has('end_use_of_property3'))
      <span class="text-danger">{{$errors->first('end_use_of_property3')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Interest rate</label>
      <input name="interest_rate3" class="form-control" pattern="\d*" maxlength="3" @if($result) value="{{ $result->interest_rate3 }}" @else value="{{ old('interest_rate3') }}" @endif type="text">
      @if($errors->has('interest_rate3'))
      <span class="text-danger">{{$errors->first('interest_rate3')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">EMI (in AED)</label>
      <input name="mortgage_emi3" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->mortgage_emi3 }}" @else value="{{ old('mortgage_emi3') }}" @endif type="text">
      @if($errors->has('mortgage_emi3'))
      <span class="text-danger">{{$errors->first('mortgage_emi3')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
      <div class="form-group">
        <label class="sub-label">No. of EMI Paid (in AED)</label>
        <input name="mortgage_member_since3" class="form-control" @if($result) value="{{ $result->mortgage_member_since3 }}" @else value="{{ old('mortgage_member_since3') }}" @endif pattern="\d*" maxlength="4" type="text">
        @if($errors->has('mortgage_member_since3'))
        <span class="text-danger">{{$errors->first('mortgage_member_since3')}}</span>
        @endif
      </div>
    </div>
  <div class="col-md-12" @if(isset($result->mortgage_loan_amount4)) @if($result->mortgage_loan_amount4 != '') style="display:none;" @endif @endif>
    <a class="add_more_btn mortgage_loan4_open"><span>+</span> Add More</a>
  </div>
  </div>

  <div class="row mortgage_loan4" @if(isset($result->mortgage_loan_amount4)) @if($result->mortgage_loan_amount4 == '') style="display:none;background: #fff;" @else style="background: #f7f7f7;" @endif @else style="display:none;background: #fff;"  @endif>
  <div class="col-md-12">
      <div style="border-top: 1px solid #f3f3f3;padding-bottom: 5px;"><a class="del_fdt" onclick="mortgage_loan4del();"> Delete</a></div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Loan amount (in AED)</label>
      <input name="mortgage_loan_amount4" pattern="\d*" maxlength="6" class="form-control" @if($result) value="{{ $result->mortgage_loan_amount4 }}" @else value="{{ old('mortgage_loan_amount4') }}" @endif type="text">
      @if($errors->has('mortgage_loan_amount4'))
      <span class="text-danger">{{$errors->first('mortgage_loan_amount4')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Purchase price/current market valuation (in AED)</label>
      <input name="purchase_price4" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->purchase_price4 }}" @else value="{{ old('purchase_price4') }}" @endif type="text">
      @if($errors->has('purchase_price4'))
      <span class="text-danger">{{$errors->first('purchase_price4')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Type of loan</label>
      <select name="type_of_loan4" class="form-control" required="true">
        @if($result)
        <option value="Primary Sale" @if($result->type_of_loan4 == 'Primary Sale') selected @endif>Primary Sale</option>
        <option value="Secondary Sale" @if($result->type_of_loan4 == 'Secondary Sale') selected @endif>Secondary Sale</option>
        <option value="Buyout" @if($result->type_of_loan4 == 'Buyout') selected @endif>Buyout</option>
        <option value="Equity" @if($result->type_of_loan4 == 'Equity') selected @endif>Equity</option>
        <option value="Top up" @if($result->type_of_loan4 == 'Top up') selected @endif>Top up</option>
        @else
        <option value="Primary Sale">Primary Sale</option>
        <option value="Secondary Sale">Secondary Sale</option>
        <option value="Buyout">Buyout</option>
        <option value="Equity">Equity</option>
        <option value="Top up">Top up</option>
        @endif
      </select>
      @if($errors->has('type_of_loan4'))
      <span class="text-danger">{{$errors->first('type_of_loan4')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Term of loan</label>
      <input name="term_of_loan4" class="form-control" @if($result) value="{{ $result->term_of_loan4 }}" @else value="{{ old('term_of_loan4') }}" @endif type="text">
      @if($errors->has('term_of_loan4'))
      <span class="text-danger">{{$errors->first('term_of_loan4')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">End use of property</label>
      <select name="end_use_of_property4" class="form-control" required="true">
        @if($result)
        <option value="Self use" @if($result->end_use_of_property4 == 'Self use') selected @endif>Self use</option>
        <option value="Rental" @if($result->end_use_of_property4 == 'Rental') selected @endif>Rental</option>
        @else
        <option value="Self use">Self use</option>
        <option value="Secondary Sale">Secondary Sale</option>
        @endif
      </select>
      @if($errors->has('end_use_of_property4'))
      <span class="text-danger">{{$errors->first('end_use_of_property4')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">Interest rate</label>
      <input name="interest_rate4" class="form-control" pattern="\d*" maxlength="3" @if($result) value="{{ $result->interest_rate4 }}" @else value="{{ old('interest_rate4') }}" @endif type="text">
      @if($errors->has('interest_rate4'))
      <span class="text-danger">{{$errors->first('interest_rate4')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="sub-label">EMI (in AED)</label>
      <input name="mortgage_emi4" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->mortgage_emi4 }}" @else value="{{ old('mortgage_emi4') }}" @endif type="text">
      @if($errors->has('mortgage_emi4'))
      <span class="text-danger">{{$errors->first('mortgage_emi4')}}</span>
      @endif
    </div>
  </div>
  <div class="col-md-6">
      <div class="form-group">
        <label class="sub-label">No. of EMI Paid (in AED)</label>
        <input name="mortgage_member_since4" class="form-control" @if($result) value="{{ $result->mortgage_member_since4 }}" @else value="{{ old('mortgage_member_since4') }}" @endif pattern="\d*" maxlength="4" type="text">
        @if($errors->has('mortgage_member_since4'))
        <span class="text-danger">{{$errors->first('mortgage_member_since4')}}</span>
        @endif
      </div>
    </div>
  </div>
  </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <label class="sub-label">Expected monthly average spend (in AED)</label>
       <input name="expected_monthly_average_spend" class="form-control" @if($result) value="{{ $result->expected_monthly_average_spend }}" @else value="{{ old('expected_monthly_average_spend') }}" @endif pattern="\d*" maxlength="7" type="text">                                                                 
    </div>
  </div>

  <div class="row" style="background: #f7f7f7;">
    <div class="col-md-12" style="margin-bottom: 15px;margin-top: 15px;">
      <label style="font-weight: 500; margin-bottom: 1px;">Do you have any exisiting business loan?</label><br>
        <span>No</span>&nbsp; <label class="switch">
        <input type="checkbox" class="business_value" @if($result) @if($result->exist_business == 1) checked="true" @endif @endif name="exist_business" onclick="Businessvalue(this.value);" value="1"> 
      <span class="slider round"></span>
      </label>&nbsp; <span>Yes</span>
    </div>

    <div class="col-md-12 exist_business" @if($result) @if($result->exist_business == 0) style="display: none;"  @endif @else style="display: none;" @endif>
    <div class="row">
    <div class="col-md-12">
    <h5 style="font-size: 17px; margin-top: 15px;">Details of existing business loan</h5>
    </div>
    <div class="col-md-6 exist_business_fields">
      <div class="form-group">
        <label class="sub-label">Loan amount (in AED)</label>
        <input name="business_loan_amount" pattern="\d*" maxlength="6" class="form-control" @if($result) value="{{ $result->business_loan_amount }}" @else value="{{ old('business_loan_amount') }}" @endif type="text">
        @if($errors->has('business_loan_amount'))
          <span class="text-danger">{{$errors->first('business_loan_amount')}}</span>
        @endif
      </div>
    </div>

    <div class="col-md-6 exist_business_fields">
      <div class="form-group">
        <label class="sub-label">EMI (in AED)</label>
        <input name="business_loan_emi" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->business_loan_emi }}" @else value="{{ old('business_loan_emi') }}" @endif type="text">
        @if($errors->has('business_loan_emi'))
        <span class="text-danger">{{$errors->first('business_loan_emi')}}</span>
        @endif
      </div>
    </div>

    <div class="col-md-6 exist_business_fields">
      <div class="form-group">
        <label class="sub-label">No. of EMI Paid (in AED)</label>
        <input name="business_member_since" class="form-control remove_valid" @if($result) value="{{ $result->business_member_since }}" @else value="{{ old('business_member_since') }}" @endif pattern="\d*" maxlength="4" type="text">
        @if($errors->has('business_member_since'))
        <span class="text-danger">{{$errors->first('business_member_since')}}</span>
        @endif
      </div>
    </div>

    <div class="col-md-12" @if(isset($result->business_loan_amount2)) @if($result->business_loan_amount2 != '') style="display:none;" @endif @endif>
    <a class="add_more_btn loan_busin2_open"><span>+</span> Add More</a>
    </div>
  </div>

  <div class="row loan_busin2" @if(isset($result->business_loan_amount2)) @if($result->business_loan_amount2 == '') style="display:none;" @endif @else style="display:none;"  @endif>

    <div class="col-md-12">
      <div style="border-top: 1px solid #f3f3f3;padding-bottom: 5px;"><a class="del_fdt" onclick="loan_busin2del();"> Delete</a></div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label class="sub-label">Loan amount (in AED)</label>
        <input name="business_loan_amount2" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->business_loan_amount2 }}" @else value="{{ old('business_loan_amount2') }}" @endif type="text">
        @if($errors->has('business_loan_amount2'))
        <span class="text-danger">{{$errors->first('business_loan_amount2')}}</span>
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="sub-label">EMI (in AED)</label>
        <input name="business_loan_emi2" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->business_loan_emi2 }}" @else value="{{ old('business_loan_emi2') }}" @endif type="text">
        @if($errors->has('business_loan_emi2'))
        <span class="text-danger">{{$errors->first('business_loan_emi2')}}</span>
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="sub-label">No. of EMI Paid (in AED)</label>
        <input name="business_member_since2" class="form-control" @if($result) value="{{ $result->business_member_since2 }}" @else value="{{ old('business_member_since2') }}" @endif pattern="\d*" maxlength="4" type="text">
        @if($errors->has('business_member_since2'))
        <span class="text-danger">{{$errors->first('business_member_since2')}}</span>
        @endif
      </div>
    </div>
    <div class="col-md-12" @if(isset($result->business_loan_amount3)) @if($result->business_loan_amount3 != '') style="display:none;" @endif @endif>
    <a class="add_more_btn loan_busin3_open"><span>+</span> Add More</a>
    </div>
  </div>

  <div class="row loan_busin3" @if(isset($result->business_loan_amount3)) @if($result->business_loan_amount3 == '') style="display:none;" @endif @else style="display:none;"  @endif>
    <div class="col-md-12">
      <div style="border-top: 1px solid #f3f3f3;padding-bottom: 5px;"><a class="del_fdt" onclick="loan_busin3del();"> Delete</a></div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="sub-label">Loan amount (in AED)</label>
        <input name="business_loan_amount3" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->business_loan_amount3 }}" @else value="{{ old('business_loan_amount3') }}" @endif type="text">
        @if($errors->has('business_loan_amount3'))
        <span class="text-danger">{{$errors->first('business_loan_amount3')}}</span>
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="sub-label">EMI (in AED)</label>
        <input name="business_loan_emi3" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->business_loan_emi3 }}" @else value="{{ old('business_loan_emi3') }}" @endif type="text">
        @if($errors->has('business_loan_emi3'))
        <span class="text-danger">{{$errors->first('business_loan_emi3')}}</span>
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="sub-label">No. of EMI Paid (in AED)</label>
        <input name="business_member_since3" class="form-control" @if($result) value="{{ $result->business_member_since3 }}" @else value="{{ old('business_member_since3') }}" @endif pattern="\d*" maxlength="4" type="text">
        @if($errors->has('business_member_since3'))
        <span class="text-danger">{{$errors->first('business_member_since3')}}</span>
        @endif
      </div>
    </div>
    <div class="col-md-12" @if(isset($result->business_loan_amount3)) @if($result->business_loan_amount3 != '') style="display:none;" @endif @endif>
    <a class="add_more_btn loan_busin4_open"><span>+</span> Add More</a>
    </div>
  </div>

  <div class="row loan_busin4" @if(isset($result->business_loan_amount4)) @if($result->business_loan_amount4 == '') style="display:none;" @endif @else style="display:none;"  @endif>
    <div class="col-md-12">
      <div style="border-top: 1px solid #f3f3f3;padding-bottom: 5px;"><a class="del_fdt" onclick="loan_busin4del();"> Delete</a></div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="sub-label">Loan amount (in AED)</label>
        <input name="business_loan_amount4" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->business_loan_amount4 }}" @else value="{{ old('business_loan_amount4') }}" @endif type="text">
        @if($errors->has('business_loan_amount4'))
        <span class="text-danger">{{$errors->first('business_loan_amount4')}}</span>
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="sub-label">EMI (in AED)</label>
        <input name="business_loan_emi4" class="form-control" pattern="\d*" maxlength="6" @if($result) value="{{ $result->business_loan_emi4 }}" @else value="{{ old('business_loan_emi4') }}" @endif type="text">
        @if($errors->has('business_loan_emi4'))
        <span class="text-danger">{{$errors->first('business_loan_emi4')}}</span>
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="sub-label">No. of EMI Paid (in AED)</label>
        <input name="business_member_since4" class="form-control" @if($result) value="{{ $result->business_member_since4 }}" @else value="{{ old('business_member_since4') }}" @endif pattern="\d*" maxlength="4" type="text">
        @if($errors->has('business_member_since4'))
        <span class="text-danger">{{$errors->first('business_member_since4')}}</span>
        @endif
      </div>
    </div>
  </div>
  
  </div>
  </div>

  <div class="row">
  <div class="col-md-12 text-center">
    <a href="{{ route('cm-details') }}" class="back_btn">Back</a> &nbsp;&nbsp;
    <button type="submit">Proceed</button>
  </div>
</div>
</form>
</div>
</div>
<div class="col-md-5">
   <div class="service-step">
    <h3>All fields marked with an asterisk (*) are mandatory.</h3>
<!--     <p>Thank you for taking the time to complete our form. In order to process your request, we need to collect certain information from you. Please make sure to fill out all of the required fields marked with an asterisk (*). These fields are essential for us to understand your needs and provide you with the best possible service.</p><br>
    <p>If you have any questions about which fields are required, please don't hesitate to contact us. We're here to help you every step of the way.</p> -->
  </div>
<div class="service-step">
<h3>Complete and accurate information helps us bring you the best products suited to you at the fastest pace!</h3>
<!-- <ul style="padding-left: 15px; color: rgba(0, 0, 0, 0.5);">
<li>Visit our website. This will help us understand your financial needs and determine which products and services are best for you.</li>
<li>Submit your application and wait for a response. We'll review your information and get back to you as soon as possible with a decision.</li>
<li>If your application for credit cards and loans is approved, you'll be able to access the limits that have been set for those products. The limits will likely be based on your credit score, income, and other financial information that you provided as part of the application process.</li>
</ul> -->
</div>

</div>

</div>
</div>
</section>


@endsection    