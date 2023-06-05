@extends('admin.layouts.admin')
@section('css')
<!-- tables -->
<link rel="stylesheet" type="text/css" href="{!! asset('css/table-style.css') !!}" />
<!-- //tables -->
@endsection
@section('content')

<div class="agile-grids">   
    <div class="grids">       
        <div class="row">
            <div class="col-md-12">                
                <h1 class="page-header">Follow Up</h1>

            <table class="table table-hover">
            <tr style="background: #5EB495">
                <th style="color: #fff">Name</th>
                <th style="color: #fff">Reason</th>
                <th style="color: #fff">Time</th>
                <th style="color: #fff">Note</th>
                <th style="color: #fff">Email</th>
                <th style="color: #fff">Mobile</th>
                <th style="color: #fff">Product</th>
                @if(Auth()->user()->user_type == 1)
                <th style="color: #fff">Agent</th>
                @endif

    
            </tr>
            @foreach($service as $data)
            <tr>
                <td>{{ $data->name }} {{ $data->mname }} {{ $data->lname }}  </td>
                <td>{{ $data->reason_for_follow_up }}</td>
                <td>{{ $data->time }}</td>
                <td>{{ $data->note }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->number }}</td>
                <td>{{ $data->product }}</td>

                @if(Auth()->user()->user_type == 1)
                <td>{{ $data->user_name }} {{ $data->middle_name }} {{ $data->last_name }}  </td>

                @endif

            </tr>
            @endforeach

            </table>
            @if(count($service) == 0)
                <p style="text-align: center;">No follow up for today</p>
            @endif
</div>
</div>
</div>
  </div>
@stop