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
                <h1 class="page-header">All Leads</h1>

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
                    <h6 class="main-content-label mb-1">Assign Lead Filter</h6>
                </div>
                <div class="panel-body row">
                    <div class="col-md-12" style="margin-top: 15px;">
                        {!! Form::open(array('method' => 'POST',
                        'route' => array('open.lead.paginate'), 'id' => 'ajaxForm')) !!}
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="name" class="control-label">Customer Name</label>
                                    {!! Form::text('name', null, array('class' =>
                                    'form-control name')) !!}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="product_type"
                                        class="control-label">Customer Email</label>
                                    {!! Form::text('email', null, array('class' =>
                                    'form-control email')) !!}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                <label>Mobile</label>
									<div class="input-group telephone-input"></div> 
                                    <input type="tel" class="form-control" name="number" id="mobile-number number" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="product_type"
                                        class="control-label">Agent/Employee Reference ID</label>
                                    {!! Form::text('reference', null, array('class' =>
                                    'form-control reference')) !!}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="product_type"
                                        class="control-label">Source Type</label>
                                        <select name="source" class="form-control minimal source" aria-label="Default select example">
                                            <option value="">Select</option>
                                                <?php $get_source = \DB::table('lead_source')->get(); ?>
                                                @foreach($get_source as $get_source)
                                                <option value="{{$get_source->name}}">{{ $get_source->name }}</option>
                                                @endforeach
                                            </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="product_type"
                                        class="control-label">Product Type</label>
                                        <select name="product" class="form-control minimal product" aria-label="Default select example">
                                            <option value="">Select</option>
                                            <?php $get_type = \DB::table('services')->where('status', 1)->get(); ?>
                                            @foreach($get_type as $get_type)
                                            <option value="{{$get_type->name}}">{{$get_type->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                                                        

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="product_type" class="control-label">From Date</label>
                                {!! Form::date('from', null, array('class' => 'form-control from')) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="to" class="control-label">To Date</label>
                                {!! Form::date('to', null, array('class' => 'form-control to')) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="alloted_to" class="control-label">Lead Owner</label>
                                <select name="alloted_to" class="form-control minimal alloted_to" aria-label="Default select example">
                                    <option value="">Select</option>
                                    <?php $get_user_type = App\Models\User::where('status', 1)->where('user_type', 4)->orWhere('user_type', 3)->get(); ?>
                                        @foreach($get_user_type as $get_user_type)
                                        <option value="{{$get_user_type->id}}">{{$get_user_type->name}}</option>
                                        @endforeach
                                </select>
                           </div>
                        </div>


                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="status" class="control-label">Lead Status</label>
                                <select class="form-control lead_status" name="lead_status">
                                    <option value="">Select</option>
                                    <option value="OPEN">OPEN</option>
                                    <option value="INPROCESS">IN PROCESS</option>
                                    <option value="REMINDER">REMINDER</option>
                                </select>
                            </div>
                        </div>
                     

                        <div class="col-sm-4 margintop20">
                            <div class="form-group">
                                {!! Form::hidden('form-search', 1) !!}
                                {!! Form::submit('Search', array('class' => 'btn
                                    btn-primary')) !!}
                                <a href="{!! route('leads.lead_open_leads') !!}" class="btn btn-success">Reset Filter</a>
                                <a style="color: #fff;" onclick="ExportExcel();" class="btn btn-success ExportExcel">Export CSV</a>    
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

                        <form action="{{ route('open.lead.action') }}" method="post">
                        <!--     <div class="row"> -->
                        <div class="col-md-3 pull-right padding0" style="text-align: right; margin-bottom: 15px;">
                                {!! lang('Show') !!} {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!} {!! lang('entries') !!}
                            </div>
                            <div class="col-md-3 padding0">
                                {!! Form::hidden('page', 'search') !!}
                                {!! Form::hidden('_token', csrf_token()) !!}
                               <!--  {!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => 'Search customer by name')) !!} -->
                            </div>
                           <!--  </div> -->
                            <table id="paginate-load" data-route="{{route('open.lead.paginate')}}" class="table table-hover">
                            </table>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img src="{{asset('img/logo-black.png')}}" alt="logo">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="showDetails">
      </div>
     <!--  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> -->
    </div>
  </div>
</div>

<style type="text/css">
@media (min-width: 622px) { 
#exampleModalCenter .modal-dialog {
    max-width: 620px;
}  
#exampleModalCenter label{
    margin-top: 15px;
}
#exampleModalCenter .form-row{
    margin-right: -15px;
    margin-left: -15px;
}
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script>
function view_details(id){
    $.ajax({
        type: 'GET',
        url : "{{url('admin/admin-all-view-details')}}", 
        data: {id:id},
        success: function(response){
                $("#showDetails").html(response)
        }
        });    
}
function savedata(id){
    swal({
            title: "Are you sure?",
            // text: "Do you want to change status "+msg,
            text: "Do you want update details",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, save change!",
            closeOnConfirm: true
            }, function (isConfirm) {
                var name = $('#m_name').val();
                var mname = $('#m_mname').val();
                var lname = $('#m_lname').val();
                var email = $('#m_email').val();
                var number = $('#m_number').val();
                var product = $('#m_product').val();
                var source = $('#m_source').val();
                var status = $('#m_status').val();
                var assign_to = $('#m_assign_to').val();
                $.ajax({
                    type: 'GET',
                    url : "{{url('admin/save-view-details')}}", 
                    data: {id:id, name:name, mname:mname, lname:lname, email:email, number:number, product:product, source:source, status:status, assign_to:assign_to},
                    success: function(response){
                        toastr.options.timeOut = 1500;
                        toastr.success('Details Update Succesfully');
                    }
                    });        
            });   
}
</script>
<script>                                                    
    $(function () {
        $('#daterange-btn').daterangepicker(
        {
            ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate  : moment()
        },
        function (start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
        );
    });
</script>


<script type="text/javascript">
function ExportExcel(){
    var name = $(".name").val();
    var email = $(".email").val();
    var number = $(".number").val();
    var from = $(".from").val();
    var to = $(".to").val();
    var lead_status = $(".lead_status").val();
    var source = $(".source").val();
    var product = $(".product").val();
    var alloted_to = $(".alloted_to").val();
    var reference = $(".reference").val();
    var url = 1;
    $.ajax({
        type: "GET",
        url: "{{ route('lead_open_leads_expo') }}",
        data: {'name' : name, 'email' : email, 'number' : number, 'from' : from, 'to' : to, 'url' : url, 'lead_status' : lead_status, 'product' : product, 'alloted_to' : alloted_to, 'reference' : reference},
        success: function(data){
            if (data.status == 200) {
                window.location.href = data.url;
            }
        }
    });
}
</script>

<style type="text/css">
#ajaxForm .btn.btn-primary {
    background: #15a552;
    border-color: #15a552;
}       
</style>

@stop

