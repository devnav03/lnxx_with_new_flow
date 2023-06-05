@extends('admin.layouts.admin')
@section('css')
<!-- tables -->
<style>
form{
overflow: auto;
}
</style>
<link rel="stylesheet" type="text/css" href="{!! asset('css/table-style.css') !!}" />
<!-- //tables -->
@endsection
@section('content')

<div class="agile-grids">   
    <div class="grids">       
        <div class="row">
            <div class="col-md-12">                
                <h1 class="page-header">Contact Enquiries <!-- <a class="btn btn-sm btn-primary pull-right" href="{!! route('export-enquiry') !!}" style="margin-left: 10px;"> <i class="fa fa-download fa-fw"></i> Export Excel </a> --> </h1>

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
                                    <h6 class="main-content-label mb-1">Contact Enquiry Filter</h6>
                                    </div>
                                    <div class="panel-body row">
                                    <div class="col-md-12" style="margin-top: 15px;">
                                    {!! Form::open(array('method' => 'POST',
                                    'route' => array('contact-enquiry.paginate'), 'id' => 'ajaxForm')) !!}
                                    <div class="row">
                                
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                            <label for="name" class="control-label">Name</label>
                                                {!! Form::text('name', null, array('class' => 'form-control name')) !!}
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                            <label for="email" class="control-label">Email</label>
                                                {!! Form::email('email', null, array('class' => 'form-control email')) !!}
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                            <label for="email" class="control-label">Mobile</label>
                                                {!! Form::number('mobile', null, array('class' => 'form-control mobile')) !!}
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                            <label for="subject" class="control-label">Subject</label>
                                                {!! Form::text('subject', null, array('class' => 'form-control subject')) !!}
                                            </div>
                                        </div>

                                      
                                        <div class="col-sm-3 margintop20">
                                            <div class="form-group">
                                                {!! Form::hidden('form-search', 1) !!}
                                                {!! Form::submit('Filter', array('class' => 'btn btn-primary')) !!}
                                                <a href="{!! route('contact-enquiry.index') !!}" class="btn btn-success">Reset Filter</a>
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

                        <form action="#" method="post">
                            <div class="col-md-3 text-right pull-right padding0 marginbottom10" style="text-align: right;">
                                {!! lang('Show') !!} {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!} {!! lang('entries') !!}
                            </div>
                            <div class="col-md-3 padding0 marginbottom10" style="padding-left: 0px !important;  margin-bottom: 15px;">
                                {!! Form::hidden('page', 'search') !!}
                                {!! Form::hidden('_token', csrf_token()) !!}
                                <!-- {!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => 'Search')) !!} -->
                            </div>
                            <table id="paginate-load" data-route="{{ route('contact-enquiry.paginate') }}" class="table table-hover">
                            </table>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop


