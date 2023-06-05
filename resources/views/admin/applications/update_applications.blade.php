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
                <!-- <h1 class="page-header">Update Application</h1> -->
                <h1 style="font-size: 16px;font-weight: normal;display: block;margin-bottom: 0px;" class="page-header"> Application No #{{ $result->ref_id }} &nbsp;&nbsp; | &nbsp;&nbsp; Application For : {{ $service->name }} <a class="noPrint btn btn-sm btn-primary pull-right" href="{!! route('applications.index') !!}"> All Applications </a> <a style="margin-right: 10px; color: #fff;" class="noPrint btn btn-sm btn-primary pull-right" href="{{ route('applications.edit', $result->id) }}"> View Details</a></h1>

                <div class="agile-tables">
                    <div class="w3l-table-info">
                        {{-- for message rendering --}}
                        @if (Session::has('app_status_update'))
                            <div class="alert alert-success">
                                <button data-dismiss="alert" class="close">
                                    &times;
                                </button>
                                <i class="fa fa-check-circle"></i> &nbsp;
                                Application status successfully updated
                            </div>
                        @endif

                        @if (Session::has('email_notifications_update'))
                            <div class="alert alert-success">
                                <button data-dismiss="alert" class="close">
                                    &times;
                                </button>
                                <i class="fa fa-check-circle"></i> &nbsp;
                                Email notifications sent successfully
                            </div>
                        @endif

                        
                        <div class="panel panel-default">
                        <div class="row row-sm">
                            <div class="col-lg-6">
                                <div class="card custom-card">
                                    <div class="card-body" style="min-height: 504px;">
                                        <h6 class="main-content-label mb-1">Update Status</h6>
                                        <form method="post" action="{{ route('update-applications-status') }}">
                                            @csrf
                                        <label for="status_id" style="margin-top: 20px;">Select Status*</label>
                                        <select class="form-control" name="status_id" required="true">
                                            @foreach($applications_status as $status)
                                            <option @if($status->id == $result->status) selected @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="comment" style="margin-top: 20px;">Comment</label>
                                        <textarea style="resize: none;height: 120px;" class="form-control" name="comment"> </textarea>

                                        <input type="hidden" name="app_id" value="{{$result->id}}">

                                        <button type="submit" style="background: #5EB495; color: #fff;border: 0px; margin-top: 15px; padding: 8px 20px;">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <h6 class="main-content-label mb-1">Email Notification</h6>
                                        <form method="post" action="{{ route('email-notification') }}">
                                        @csrf

                                        <label for="email" style="margin-top: 20px;">To*</label>
                                        <input class="form-control" value="{{ $result->email }}" type="email" name="email" required="true">

                                        <label for="subject" style="margin-top: 20px;">Subject*</label>
                                        <input class="form-control" value="Lnxx Application No #{{ $result->ref_id }} For {{ $service->name }}" type="text" name="subject" required="true">
                                    
                                        <label for="message" style="margin-top: 20px;">Message</label>
                                        <textarea style="resize: none;height: 120px;" class="form-control" name="message"> </textarea>

                                        <label style="margin-top: 12px;"><input type="checkbox" value="1" name="attachment" style="margin-top: 4px;float: left; margin-right: 8px;"> Attachment</label>
                                        
                                        <div class="clearfix"></div>
                                        <input type="hidden" name="app_id" value="{{$result->id}}">
                                        <button type="submit" style="background: #5EB495; color: #fff;border: 0px; margin-top: 15px; padding: 8px 20px;">Send</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

     
                                    @if(count($app_status) != 0)
                                    <div class="card custom-card">
                                    <div class="card-body">
                                    <h3 style="font-size: 19px; margin-bottom: 15px;">Application Status</h3>
                                        <table style="width: 100%;">
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Comment</th>
                                                <th>Updated By</th>
                                            </tr>
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach($app_status as $app_status)
                                            @php
                                                $i++;
                                            @endphp
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ date('d M, Y', strtotime($app_status->created_at)) }}</td>
                                                    <td>{{ $app_status->application_status }}</td>
                                                    <td>{{ $app_status->comment }}</td>
                                                    <td>{{ $app_status->name }} {{ $app_status->middle_name }} {{ $app_status->last_name }}</td>
                                                </tr>
                                            @endforeach 
                                        </table>
                                        </div>
                                    </div>
                                    @endif


                                    @if(count($EmailNotifications) != 0)
                                    <div class="card custom-card">
                                    <div class="card-body">
                                    <h3 style="font-size: 19px; margin-bottom: 15px;">Email Notifications</h3>
                                        <table style="width: 100%;">
                                            <tr>
                                                <th>#</th>
                                                <th>Email</th>
                                                <th>Subject</th>
                                                <th>Message</th>
                                                <th>Attachment</th>
                                                <th>Date</th>
                                                <th>Sent By</th>
                                            </tr>
                                            @php
                                                $i = 0;
                                            @endphp
                                            @foreach($EmailNotifications as $EmailNoti)
                                            @php
                                                $i++;
                                            @endphp
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $EmailNoti->email }}</td>
                                                    <td>{{ $EmailNoti->subject }}</td>
                                                    <td>{{ $EmailNoti->message }}</td>
                                                    
                                                    <td> @if($EmailNoti->attachment == 1) Yes @else No @endif</td>

                                                    <td>{{ date('d M, Y', strtotime($EmailNoti->created_at)) }}</td>
                                                    <td>{{ $EmailNoti->name }} {{ $EmailNoti->middle_name }} {{ $EmailNoti->last_name }}</td>
                                                </tr>
                                            @endforeach 
                                        </table>
                                        </div>
                                    </div>
                                    @endif
                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
tbody, td, tfoot, th, thead, tr{    
    border: 1px solid #f3f3f3;
    padding: 10px;
}

</style>

@stop

