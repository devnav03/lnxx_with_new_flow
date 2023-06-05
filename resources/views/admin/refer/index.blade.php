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
                <h1 class="page-header">Refers</h1>

                <div class="agile-tables">
                    <div class="w3l-table-info">
                        {{-- for message rendering --}}
                        @include('admin.layouts.messages')

                        <div class="panel panel-default">
                        <div class="row row-sm">
                            <div class="col-lg-12 col-md-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                    <div>
                                        <h6 class="main-content-label mb-1">Filter</h6>
                                    </div>
                                    <div class="panel-body row">
                                    <div class="col-md-12" style="margin-top: 15px;">
                                    {!! Form::open(array('method' => 'POST',
                                    'route' => array('refers.paginate'), 'id' => 'ajaxForm')) !!}
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                            <label for="name" class="control-label">Invitee Name</label>
                                            {!! Form::text('invitee_name', null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                            <label for="name" class="control-label">Name</label>
                                            {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="product_type" class="control-label">Email</label>
                                                {!! Form::text('email', null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="product_type" class="control-label">Mobile</label>
                                                {!! Form::number('mobile', null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-3" style="padding-right: 0px;">
                                            <div class="form-group">
                                                <label for="product_type" class="control-label">From Date</label>
                                                {!! Form::date('from', null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-3" style="padding-right: 0px;">
                                            <div class="form-group">
                                                <label for="to" class="control-label">To Date</label>
                                                {!! Form::date('to', null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="status" class="control-label">Status</label>
                                                <select class="form-control" name="status">
                                                    <option value="">Select</option>
                                                    <option value="1">Register</option>
                                                    <option value="102">Not registered</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-sm-3 margintop20">
                                            <div class="form-group">
                                                {!! Form::hidden('form-search', 1) !!}
                                                {!! Form::submit('Search', array('class' => 'btn btn-primary')) !!}
                                                <a href="{!! route('refers.index') !!}" class="btn btn-success">Reset Filter</a>
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        </div>

                        <form action="{{ route('refers.action') }}" method="post">
                        <!--     <div class="row"> -->
                            <div class="col-md-3 pull-right padding0" style="text-align: right; margin-bottom: 15px;padding-right: 0px !important;">
                                {!! lang('Show') !!} {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!} {!! lang('entries') !!}
                            </div>
                            <div class="col-md-3 padding0" style="padding-left: 0px !important; margin-bottom: 15px;">
                                {!! Form::hidden('page', 'search') !!}
                                {!! Form::hidden('_token', csrf_token()) !!}
                                <!-- {!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => 'Search...')) !!} -->
                            </div>
                           <!--  </div> -->
                            <table id="paginate-load" data-route="{{ route('refers.paginate') }}" class="table table-hover">
                            </table>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css"> 
.panel.panel-default input {
    padding-right: 10px;
}

#ajaxForm .btn.btn-primary {
    background: #15a552;
    border-color: #15a552;
}
</style>


@stop

