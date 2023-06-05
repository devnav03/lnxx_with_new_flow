<thead>
<tr style="background: #5EB495;"> 
 <!--    <th class="text-center" style="color: #fff;">#</th> -->
    <th style="color: #fff;">Created At</th>
    <th style="color: #fff;">Name</th>
    <th style="color: #fff;">Product</th>
    <th style="color: #fff;">Status</th>
    <th style="color: #fff;" class="text-center">Action</th>
</tr>
</thead>
<tbody>
<?php $index = 1; ?>

@foreach($data as $detail)
<tr id="order_{{ $detail->id }}">
    <!-- <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td> -->
    <td> {{ date('d M, Y', strtotime($detail->created_at)) }} </td>
    <td>{!! $detail->name !!}</td>
    <td>@if($detail->product) {!! $detail->product !!} @else N/A @endif </td>
    <td> {{ $detail->lead_status }} </td>
    

    <td class="text-center col-md-1">
        <button type="button" class="btn btn-primary" title="Start on boarding" onclick="get_popup({{$detail->id}});" data-toggle="modal" data-target=".bd-example-modal-lg"><!-- View --> <i class="fa fa-plus"></i> </button>
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