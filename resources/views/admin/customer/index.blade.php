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
                <h1 class="page-header">Customers</h1>

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
                                        <h6 class="main-content-label mb-1">Customers Filter</h6>
                                    </div>
                                    <div class="panel-body row">
                                    <div class="col-md-12" style="margin-top: 15px;">
                                    {!! Form::open(array('method' => 'POST',
                                    'route' => array('customer.paginate'), 'id' => 'ajaxForm')) !!}
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                            <label for="name" class="control-label">Name</label>
                                            {!! Form::text('name', null, array('class' => 'form-control name')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="product_type" class="control-label">Email</label>
                                                {!! Form::text('email', null, array('class' => 'form-control email')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="product_type" class="control-label">Mobile</label>
                                                {!! Form::number('mobile', null, array('class' => 'form-control mobile')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                            <label for="user_id" class="control-label">Lnxx Id</label>
                                                {!! Form::text('user_id', null, array('class' => 'form-control user_id')) !!}
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
                                        <div class="col-sm-4 margintop20">
                                            <div class="form-group">
                                                {!! Form::hidden('form-search', 1) !!}
                                                {!! Form::submit('Search', array('class' => 'btn btn-primary')) !!}
                                                <a href="{!! route('customer') !!}" class="btn btn-success">Reset Filter</a>
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


                        <form action="{{ route('customer.action') }}" method="post">
                            <div class="col-md-3 pull-right padding0" style="text-align: right; margin-bottom: 15px;">
                                {!! lang('Show') !!} {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!} {!! lang('entries') !!}
                            </div>
                            <div class="col-md-3 padding0">
                                {!! Form::hidden('page', 'search') !!}
                                {!! Form::hidden('_token', csrf_token()) !!}
                               <!--  {!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => 'Search customer by name')) !!} -->
                            </div>

                            <table id="paginate-load" data-route="{{ route('customer.paginate') }}" class="table table-hover">
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
.panel.panel-default input {
    padding-right: 10px;
}

#ajaxForm .btn.btn-primary {
    background: #15a552;
    border-color: #15a552;
}       
</style>

<script type="text/javascript">
    
function get_popup(id) {
        $.ajax({
                type: 'GET',
                url: "{{url('admin/customer/applications')}}",
                data: {
                    id: id
                },
            })
            .done(function(xhr) {
                if (xhr.status == 200) {
                    $("#app_list").html(xhr.responce);
                    $("#user_name").html(xhr.user_name);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    }

</script>

<script type="text/javascript">
function ExportExcel(){
    var name = $(".name").val();
    var email = $(".email").val();
    var mobile = $(".mobile").val();
    var from = $(".from").val();
    var to = $(".to").val();
    var user_id = $(".user_id").val();
    var url = 1;
    $.ajax({
        type: "GET",
        url: "{{ route('export_cus_excel') }}",
        data: {'name' : name, 'email' : email, 'mobile' : mobile, 'from' : from, 'to' : to, 
        'user_id' : user_id, 'url' : url},
        success: function(data){
            if (data.status == 200) {
                window.location.href = data.url;
            }
        }
    });
}
</script>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 940px;">
        <div class="modal-content" style="padding: 20px;padding-bottom: 0px;">
            <h4 style="font-weight: normal;font-size: 18px; margin-bottom: 10px;">Customer Name: <span id="user_name"></span></h4>
            <table style="width: 100%;" id="app_list">
            </table>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



@stop

