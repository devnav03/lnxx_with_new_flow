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
                <h1 class="page-header">Blogs Listing  <a class="btn btn-sm btn-primary pull-right" href="{!! route('blogs.create') !!}"> <i class="fa fa-plus fa-fw"></i> Add Blog</a></h1>

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
                                    <h6 class="main-content-label mb-1">Blogs Filter</h6>
                                    </div>
                                    <div class="panel-body row">
                                    <div class="col-md-12" style="margin-top: 15px;">
                                    {!! Form::open(array('method' => 'POST',
                                    'route' => array('blogs.paginate'), 'id' => 'ajaxForm')) !!}
                                    <div class="row">
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                        <label for="title" class="control-label">Title</label>
                                            {!! Form::text('title', null, array('class' => 'form-control title')) !!}
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                            <label for="name" class="control-label">Created By</label>
                                                {!! Form::text('name', null, array('class' => 'form-control name')) !!}
                                            </div>
                                        </div>
                                      
                                   
                            
                                        
                                        <div class="col-sm-3" style="padding-right: 0px;">
                                            <div class="form-group">
                                                <label for="product_type" class="control-label">From Date</label>
                                                {!! Form::date('from', null, array('class' => 'form-control from')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-3" style="padding-right: 0px;">
                                            <div class="form-group">
                                                <label for="to" class="control-label">To Date</label>
                                                {!! Form::date('to', null, array('class' => 'form-control to')) !!}
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="status" class="control-label">Status</label>
                                                <select class="form-control app_status" name="status">
                                                    <option value="">Select</option>
                                                        <option value="1">Active</option>
                                                        <option value="102">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                
                                

                                        <div class="col-sm-4 margintop20">
                                            <div class="form-group">
                                                {!! Form::hidden('form-search', 1) !!}
                                                {!! Form::submit('Filter', array('class' => 'btn btn-primary')) !!}
                                                <a href="{!! route('blogs.index') !!}" class="btn btn-success">Reset Filter</a>
                                              <!--   <a style="color: #fff;"  onclick="ExportExcel();" class="btn btn-success ExportExcel">Export CSV</a> -->
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

                        <form action="{{ route('blogs.action') }}" method="post">
                            <div class="col-md-3 text-right pull-right padding0 marginbottom10" style="text-align: right;">
                                {!! lang('Show') !!} {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!} {!! lang('entries') !!} 
                            </div>
                            <div class="col-md-3 padding0 marginbottom10" style="padding-left: 0px !important;  margin-bottom: 15px;">
                                {!! Form::hidden('page', 'search') !!}
                                {!! Form::hidden('_token', csrf_token()) !!}
                               <!--  {!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => 'Search..')) !!} -->
                            </div>
                            <table id="paginate-load" data-route="{{ route('blogs.paginate') }}" class="table table-hover">
                            </table>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
#ajaxForm input{
    padding-right: 10px;
}    

</style>

@stop

