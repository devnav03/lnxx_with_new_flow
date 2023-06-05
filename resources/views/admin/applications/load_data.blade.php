<thead>
<tr style="background: #5EB495;"> 
    <th class="text-center" style="color: #fff;">#</th>
    <th class="text-center" style="color: #fff;">App No.</th>
    <!-- <th class="text-center" style="color: #fff;">Image</th> -->
    <th style="color: #fff;">Name</th>
   <!--  <th style="color: #fff;">Email</th>  -->   
    <th style="color: #fff;">Mobile</th> 
<!--     <th style="color: #fff;text-align: center;">Basic Information</th> -->
    <th style="color: #fff;text-align: center;">Employment</th>
    <!-- <th style="color: #fff;text-align: center;">Product Requested</th> -->
    <th style="color: #fff;text-align: center;">Video KYC</th>
    <th style="color: #fff;text-align: center;">Consent Form</th>
    <th style="color: #fff;text-align: left;">Products</th>
    <th style="color: #fff;" width="6%" class="text-center">Current Status</th>
    <th style="color: #fff;text-align: left;">Date</th>
    <th style="color: #fff;" class="text-center">Action</th>
</tr>
</thead>
<tbody>
<?php $index = 1; ?>

@foreach($data as $detail)
<tr id="order_{{ $detail->id }}">
    <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
    <td class="text-center"> {{ $detail->ref_id }} </td>
    
   <!--  <td>
    @if($detail->profile_image)
        <img src="{!! asset($detail->profile_image)  !!}" style="width: 45px;height: 45px; border-radius: 50%;"> 
    @else
    @if($detail->salutation == 'Mrs.' && $detail->salutation == 'Miss')
        <img src="{!! asset('img/female_icon.jpg')  !!}" style="width: 45px;height: 45px; border-radius: 50%;">  
    @else
        <img src="{!! asset('img/male_icon.jpg')  !!}" style="width: 45px;height: 45px; border-radius: 50%;">
    @endif
    @endif
    </td> --> 
    <td>{!! $detail->name !!}</td>
    <!-- <td>{!! $detail->email !!}</td> -->
    <td>{!! $detail->mobile !!}</td>
   <!--  <td class="text-center"> @if($detail->name) <i class="fa fa-check"></i> @else  <i class="fa fa-times"></i> @endif </td> -->

    <td class="text-center"> @if($detail->cm_type != null)  <i class="fa fa-check"></i>  @else  <i class="fa fa-times"></i> @endif </td>
  <!--   <td class="text-center"> @if($detail->pr_id) <i class="fa fa-check"></i> @else  <i class="fa fa-times"></i> @endif </td> -->

    <td class="text-center"> @if($detail->video) <i class="fa fa-check"></i> @else  <i class="fa fa-times"></i> @endif </td>
    <td class="text-center"> @if($detail->consent_form) <i class="fa fa-check"></i> @else <!--  <i class="fa fa-times"></i> --> <i class="fa fa-check"></i> @endif </td>

   <td> {{ $detail->service }} </td>

    <td class="text-center">
        {{ $detail->status }}
        <!-- <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('customer.toggle', $detail->id) !!}" title="@if($detail->status == 0) Deactive @else Active @endif">
            {!! Html::image('img/' . $detail->status . '.gif') !!}
        </a> -->
    </td>
    <td> {{ date('d M, Y', strtotime($detail->created_at)) }} </td>
    
    <td class="text-center col-md-1">
        <a class="btn btn-xs btn-primary" style="padding: 4px 6px; line-height: 16px;min-height: 18px; font-size: 12px;" href="{{ route('applications.edit', [$detail->id]) }}"><i class="fa fa-eye"></i></a>
        <a class="btn btn-xs btn-primary" style="padding: 4px 6px; line-height: 16px;min-height: 18px; font-size: 12px;" href="{{ route('update-applications', [$detail->id]) }}"><i class="fa fa-pen"></i></a>
        
    </td>    
</tr>
@endforeach
@if (count($data) < 1)
<tr>
    <td class="text-center" colspan="12">No Data Found</td>
</tr>
@else
<tr>
    <td colspan="12">
        {!! paginationControls($page, $total, $perPage) !!}
    </td>
</tr>
@endif
</tbody>



<style type="text/css">
    
.table thead th, .table thead td,
.table th, .table td {
    font-size: 12px;
    padding: 11px 9px;
}

</style>


