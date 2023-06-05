@extends('frontend.layouts.app')
@section('content')

<section class="cus_dashboard">
<div class="container">  
<div class="row"> 
<div class="col-md-9">
@if(count($relations) != 0)
<div class="lorem_dashboard">
  <h2 class="rel_head" style="margin-top: 0px">My Relationships</h2>
  <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->
  <ul style="padding: 0px;list-style: none;">
    @foreach($relations as $relation)
    <li>
        <div class="service-sel">
          <h5 style="font-size: 17px; font-weight: 600;">{{ $relation->name }}</h5>
          <p style="font-size: 14px;margin-bottom: 0px;">Status: @if($relation->status == 0)<span style="font-size: 14px; color: #5EB495;"> Pending </span>@endif </p>
          <p style="font-size: 14px;margin-bottom: 0px;">Reference No: #{{ $relation->ref_id }} </p>
          <p style="font-size: 14px;">Applied at: {!! date('d M, Y', strtotime($relation->created_at)) !!}</p>
          @if($relation->data_id) @else <a href="{{ route('address-details') }}" style="background: #5EB495; color: #fff; padding: 5px 10px; margin-bottom: 10px;font-size: 13px;display: inline-flex;">Continue to your application</a>@endif
        </div>
    </li>
    @endforeach
  </ul>
  <div class="paginate"> 
    {{ $relations->links() }}
  </div>
</div>
@endif

</div>
<div class="col-md-3">
<div class="info_sidebar" style="padding-bottom: 30px; margin-top: 0px; margin-bottom: 30px;">
  <h5 style="margin-bottom: 10px;">Refer & Earn</h5>
  <img src="{!! asset('assets/frontend/images/refer_earn.png')  !!}" style="margin-bottom: 25px;" class="img-responsive">
  <p style="font-size: 13px;"><b style="font-size: 14px;">Invite your friends to the Lnxx family!</b><br>
    <b style="font-size: 14px;">Refer your friends to Lnxx <br>and get rewarded!</b><br>
Special Offer: Get an AED 100 coupon of xyz as a token of our appreciation as soon as the friend you refer gets a product through Lnxx!</p>
  <a href="#" data-toggle="modal" data-target="#exampleModal" style="background: #5EB495; color: #fff; padding: 8px 20px; border-radius: 12px; font-size: 14px;"><i class="fa fa-share" style="margin-right: 6px;"></i> Invite </a>
</div>  
<div class="dashboard_sidebar">
<h3>Application Update</h3> 
  <div class="row">
    <div class="col-md-3">
      <img src="{!! asset('assets/frontend/images/property_img.png')  !!}" class="img-responsive">
    </div>
    <div class="col-md-9">
      <h5 style="line-height: 21px; margin-top: 0px; font-weight: 500; font-size: 14px;">Application no #130092 approved</h5>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <img src="{!! asset('assets/frontend/images/property_img.png')  !!}" class="img-responsive">
    </div>
    <div class="col-md-9">
      <h5 style="line-height: 21px; margin-top: 0px; font-weight: 500; font-size: 14px;">Application no #130093 KYC is pending</h5>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <img src="{!! asset('assets/frontend/images/property_img.png')  !!}" class="img-responsive">
    </div>
    <div class="col-md-9">
      <h5 style="line-height: 21px; margin-top: 0px; font-weight: 500; font-size: 14px;">Application no #130094 employment details not match</h5>
    </div>
  </div>
</div>

<div class="info_sidebar">
  <img src="{!! asset('assets/frontend/images/cal_side.png')  !!}" alt="scan" class="img-responsive">
  <h5>Information bulletin</h5>
  <p>Lnxx never requests any payment process loans through its agents.</p>
</div>

</div>

</div>
</div>
</section>
@if(session()->has('already_refer_friend'))
@php
$refer_email = \Session::get('refer_email');
$refer_name = \Session::get('refer_name');
$refer_mobile = \Session::get('refer_mobile');
@endphp
@else 
@php
$refer_email = '';
$refer_name = '';
$refer_mobile = '';
@endphp
@endif

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Refer a Friend</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -9px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if(session()->has('already_refer_friend'))
          <p style="color: #f00;">Oops, you referred someone who was already registered.</p>
        @endif
        @if(session()->has('refer_friend'))
          <p style="color: green;">Invitation sent successfully</p>
        @endif

        <form method="post" action="{{ route('refers') }}">
          <div class="form-group">
            <label class="sub-label">Name*</label>
            <input name="name" class="form-control" value="{{ $refer_name }}" required="true" type="text">
            @if($errors->has('name'))
            <span class="text-danger">{{$errors->first('name')}}</span>
            @endif
          </div>
          <div class="form-group">
            <label class="sub-label">Mobile Number*</label>
            <input name="mobile" class="form-control" value="{{ $refer_mobile }}" required="true" type="number">
            @if($errors->has('mobile'))
            <span class="text-danger">{{$errors->first('mobile')}}</span>
            @endif
          </div>
          {{ csrf_field() }}  
          <div class="form-group">
            <label class="sub-label">Email ID*</label>
            <input name="email" class="form-control" value="{{ $refer_email }}" required="true" type="email">
            @if($errors->has('email'))
            <span class="text-danger">{{$errors->first('email')}}</span>
            @endif
          </div>
          <div class="col-md-12 text-center">
            <button class="ref_btn" type="submit">Submit</button>
          </div>
        </form>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

@endsection    

<script type="text/javascript">
  
function Selectser() {
  
  var service_id = [];
    $('input.ser_chk[type=checkbox]').each(function () {
        if (this.checked)
          service_id.push($(this).val());
    });

  if(service_id != ''){
    $('#elementID').removeAttr('disabled');
    document.getElementById("elementID").style.background = "#000";
  } else {
    $('#elementID').attr('disabled','disabled');
    document.getElementById("elementID").style.background = "rgba(9, 15, 5, 0.5)";
  }


}

</script>