<thead>
<tr style="background: #5EB495;"> 
    <!-- <th class="text-center" style="width: 100px;color: #fff;">Sr. No.</th> -->
    <th style="color: #fff;">Lead Age</th>
    <th style="color: #fff;">Name</th>
    <!-- <th style="color: #fff; text-align:center;">Email</th>
    <th style="color: #fff; text-align:center;">Mobile</th> -->
    <th style="color: #fff;">Reference </th>
    <th style="color: #fff; text-align:center;">Created By</th>
    <th style="color: #fff;text-align: center;">Assigned At</th>
    <th style="color: #fff;text-align: center;">Assigned To</th>
    <th style="color: #fff; text-align:center;" class="text-center">Action</th>
</tr>
</thead>
<tbody>
<?php $index = 1; ?>


@foreach($data as $detail)
    <tr id="order_{{ $detail->id }}">
    <!-- <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td> -->
<?php   
    $age = dateDiffInDays($detail->updated_at);
    if($age != 0){
        // $age = $age - 1;
    }
?>
    <td class="text-center"> {{ $age }} @if($age == 0 || $age == 1) Day @else Days @endif </td>   
    <td><a style="color: #000;text-transform: capitalize;" href="{!! route('lead.edit', [$detail->id]) !!}">{!! $detail->salutation!!} {!! $detail->name !!}</a></td>
    <td> @if($detail->reference) {!! $detail->reference !!} @else N/A  @endif </td>
    <!-- <td class="text-center">{!! $detail->number !!}</td> -->
    <?php 
    $uploade_by = App\Models\User::select('name')->where('id', $detail->uploaded_by)->first();
    @$up_name =  $uploade_by->name
    ?>
    <td class="text-center">{!! $up_name !!}</td>
    <td class="text-center"> {!! date('d M, Y', strtotime($detail->updated_at)) !!} </td>
    <?php $get_emp = App\Models\User::select('name')->where('id', $detail->alloted_to)->first();
    @$assigned_name = $get_emp->name;
    ?>
    <td class="text-center">
        {!! $assigned_name !!}
    </td>
    
    <td class="text-center col-md-2">
    <button type="button" class="btn btn-primary" style="padding: 3px 10px; min-height: 18px;" onclick="set_id({{$detail->id}})" data-toggle="modal" data-target="#exampleModal">
        <i class="fa fa-recycle" aria-hidden="true" title="Re-Assign"></i>
    </button>
    <button type="button" style="padding: 3px 10px; min-height: 18px;" class="btn btn-primary" onclick="view_details({{$detail->id}})" data-toggle="modal" data-target="#exampleModalCenter" title="View Details">
    @if($detail->seen == '')
        <i class="fa fa-eye" id="unseen_eye{{$detail->id}}"></i>
    @else
        <i class="fa fa-eye" id="seen_eye{{$detail->id}}"></i>
    @endif
    </button>    
    </td>    
</tr>
@endforeach
@if (count($data) < 1)
<tr>
    <td class="text-center" colspan="10">No Data Found</td>
</tr>
@else
<tr>
    <td colspan="10">
        {!! paginationControls($page, $total, $perPage) !!}
    </td>
</tr>
@endif
</tbody>
