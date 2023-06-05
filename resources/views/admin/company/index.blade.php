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
                <h1 class="page-header">Company  <a style="background: #5EB495; border-color: #5EB495;" class="btn btn-sm btn-primary pull-right" href="{!! route('company.create') !!}"> <i class="fa fa-plus fa-fw"></i> Add New Company</a></h1>

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
                                    <h6 class="main-content-label mb-1">Company Filter</h6>
                                    </div>
                                    <div class="panel-body row">
                                    <div class="col-md-12" style="margin-top: 15px;">
                                    {!! Form::open(array('method' => 'POST',
                                    'route' => array('company.paginate'), 'id' => 'ajaxForm')) !!}
                                    <div class="row">
                                
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                            <label for="name" class="control-label">Name</label>
                                                {!! Form::text('name', null, array('class' => 'form-control name')) !!}
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                            <label for="name" class="control-label">Type</label>
                                                <select class="form-control type" name="type">
                                                    <option value="">Select</option>
                                                    <option value="Private Limited Company">Private Limited Company</option>
                                                    <option value="Public Limited Company">Public Limited Company</option>
                                                    <option value="Section 8 Company (NGO)">Section 8 Company (NGO)</option>
                                                    <option value="Micro Companies">Micro Companies</option>
                                                    <option value="Small Companies">Small Companies</option>
                                                    <option value="Medium Companies">Medium Companies</option>
                                                    <option value="Limited By Shares">Limited By Shares</option>
                                                    <option value="Limited by Guarantee">Limited by Guarantee</option>
                                                    <option value="Unlimited Company">Unlimited Company</option>
                                                    <option value="Holding Company">Holding Company</option>
                                                    <option value="Subsidiary Company">Subsidiary Company</option>
                                                    <option value="Listed Company">Listed Company</option>

                                                    <option value="Unlisted Company">Unlisted Company</option>
                                                </select>
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
                                        <div class="col-sm-3 margintop20">
                                            <div class="form-group">
                                                {!! Form::hidden('form-search', 1) !!}
                                                {!! Form::submit('Filter', array('class' => 'btn btn-primary')) !!}
                                                <a href="{!! route('company.index') !!}" class="btn btn-success">Reset Filter</a>
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

                        <form action="{{ route('company.action') }}" method="post">
                        <!--     <div class="row"> -->
                            <div class="col-md-3 pull-right padding0" style="text-align: right; margin-bottom: 15px;padding-right: 0px !important;">
                                {!! lang('Show') !!} {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!} {!! lang('entries') !!}
                            </div>
                            <div class="col-md-3 padding0" style="padding-left: 0px !important; margin-bottom: 15px;">
                                {!! Form::hidden('page', 'search') !!}
                                {!! Form::hidden('_token', csrf_token()) !!}
                                <!-- {!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => 'Search company by name')) !!} -->
                            </div>
                           <!--  </div> -->
                            <table id="paginate-load" data-route="{{ route('company.paginate') }}" class="table table-hover">
                            </table>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop

