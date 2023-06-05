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
                <h1 class="page-header">Applications</h1>
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
                                    <h6 class="main-content-label mb-1">Applications Filter</h6>
                                    </div>
                                    <div class="panel-body row">
                                    <div class="col-md-12" style="margin-top: 15px;">
                                    {!! Form::open(array('method' => 'POST',
                                    'route' => array('applications.paginate'), 'id' => 'ajaxForm')) !!}
                                    <div class="row">
                                        <div class="col-sm-2">
                                        <div class="form-group">
                                        <label for="ref_id" class="control-label">Application No.</label>
                                            {!! Form::number('ref_id', null, array('class' => 'form-control ref_id')) !!}
                                        </div>
                                        </div>
                                        <div class="col-sm-2">
                                        <div class="form-group">
                                        <label for="user_id" class="control-label">Lnxx Id</label>
                                            {!! Form::text('user_id', null, array('class' => 'form-control user_id')) !!}
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="name" class="control-label">Name</label>
                                            {!! Form::text('name', null, array('class' => 'form-control name')) !!}
                                        </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="email" class="control-label">Email</label>
                                                {!! Form::text('email', null, array('class' => 'form-control email')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="product_type" class="control-label">Mobile</label>
                                                {!! Form::number('mobile', null, array('class' => 'form-control mobile')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-2" style="padding-right: 0px;">
                                            <div class="form-group">
                                                <label for="product_type" class="control-label">From Date</label>
                                                {!! Form::date('from', null, array('class' => 'form-control from')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-2" style="padding-right: 0px;">
                                            <div class="form-group">
                                                <label for="to" class="control-label">To Date</label>
                                                {!! Form::date('to', null, array('class' => 'form-control to')) !!}
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="service_id" class="control-label">Product Type</label>
                                                <select class="form-control service_id" name="service_id">
                                                    <option value="">Select</option>
                                                    @foreach($services as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="status" class="control-label">Applications Status</label>
                                                <select class="form-control app_status" name="status">
                                                    <option value="">Select</option>
                                                    @foreach($applications_status as $app_status) 
                                                        <option value="@if($app_status->id == 0) 102 @else {{ $app_status->id }} @endif">{{ $app_status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                            <label for="reference_number" class="control-label">Reference ID</label>
                                                {!! Form::text('reference_number', null, array('class' => 'form-control reference_number')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="cm_type" class="control-label">Employment Type</label>
                                                <select name="cm_type" class="form-control cm_type">
                                                <option value="">Select</option>
                                                <option value="1">Salaried</option>
                                                <option value="2">Self Employed</option>
                                                <option value="3">Pension</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 margintop20">
                                            <div class="form-group">
                                                {!! Form::hidden('form-search', 1) !!}
                                                {!! Form::submit('Search', array('class' => 'btn btn-primary')) !!}
                                                <a href="{!! route('applications.index') !!}" class="btn btn-success">Reset Filter</a>
                                                <a style="color: #fff;"  onclick="ExportExcel();" class="btn btn-success ExportExcel">Export CSV</a>
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


                        <form action="{{ route('applications.action') }}" method="post">
                            <div class="col-md-3 pull-right padding0" style="text-align: right; margin-bottom: 15px;">
                                {!! lang('Show') !!} {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!} {!! lang('entries') !!}
                            </div>
                            <div class="col-md-3 padding0">
                                {!! Form::hidden('page', 'search') !!}
                                {!! Form::hidden('_token', csrf_token()) !!}
                        
                            </div>

                            <table id="paginate-load" data-route="{{ route('applications.paginate') }}" class="table table-hover">
                            </table>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
#paginate-load .fa-times{
    color: #f00;
}   
#paginate-load .fa-check{
    color: green;
} 

#ajaxForm .btn.btn-primary {
    background: #15a552;
    border-color: #15a552;
}       
</style>

<script type="text/javascript">
function ExportExcel(){
    var ref_id = $(".ref_id").val();
    var name = $(".name").val();
    var email = $(".email").val();
    var mobile = $(".mobile").val();
    var from = $(".from").val();
    var to = $(".to").val();
    var service_id = $(".service_id").val();
    var status = $(".app_status").val();
    var reference_number = $(".reference_number").val();
    var cm_type = $(".cm_type").val();
    var user_id = $(".user_id").val();
    
    var url = 1;
    $.ajax({
        type: "GET",
        url: "{{ route('export_app_excel') }}",
        data: {'name' : name, 'ref_id' : ref_id, 'email' : email, 'mobile' : mobile, 'from' : from, 'to' : to, 'service_id' : service_id, 'status' : status, 'reference_number' : reference_number, 'cm_type' : cm_type, 'user_id' : user_id, 'url' : url},
        success: function(data){
            if (data.status == 200) {
                window.location.href = data.url;
            }
        }
    });
}
</script>

@stop

