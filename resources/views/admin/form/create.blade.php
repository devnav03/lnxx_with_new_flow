@extends('admin.layouts.admin')
@section('content')
@include('admin.layouts.messages')
@php
    $route  = \Route::currentRouteName();    
@endphp
<div class="agile-grids">   
    <div class="grids">       
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">Form Information<a class="btn btn-sm btn-primary pull-right" href="{!! route('forms.index') !!}" > <i class="fa fa-solid fa-arrow-left"></i> All Form's Field</a></h1>
                
                <div class="panel panel-widget forms-panel">
                    <div class="card custom-card">
            <div class="card-body">
            <div class="panel panel-widget forms-panel" style="float: left;width: 100%; padding-bottom: 20px;">
                <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <!-- <div class="form-title">
                                <h4>Service Information</h4>                        
                            </div> -->
                            <div class="form-body">
                                @if($route == 'forms.create')
                                    {!! Form::open(array('method' => 'POST', 'route' => array('forms.store'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                @elseif($route == 'forms.edit')
                                    {!! Form::model($result, array('route' => array('forms.update', $result->id), 'method' => 'PATCH', 'id' => 'forms-form', 'class' => '', 'files'=>'true')) !!}
                                @else
                                    Nothing
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                        <label style="margin-bottom: 3px;">Field's Label</label><br>
                                        <p style="font-size: 16px;">{{ $result->label }}</p>
                                        </div> 
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                        <label style="margin-bottom: 3px;">Field's Name</label><br>
                                        <p style="font-size: 16px;">{{ $result->name }}</p>
                                        </div> 
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                        <label style="margin-bottom: 3px;">Form Type</label><br>
                                        <p style="font-size: 16px;">
                                            @if($result->form_type == 1)
                                                Address
                                            @endif
                                            @if($result->form_type == 2)
                                                Basic Information
                                            @endif
                                            @if($result->form_type == 3)
                                                Education
                                            @endif
                                            @if($result->form_type == 4)
                                                Credit Cards 
                                            @endif
                                            @if($result->form_type == 5)
                                                Personal Loan 
                                            @endif
                                        </p>
                                        </div> 
                                    </div>

                                    <input type="hidden" name="field_id" value="{{ $result->id }}">

                                    <div class="col-md-12" style="border-top: 1px solid #eee; padding-top: 20px;">
                                        <label style="color: #000; font-size: 15px; font-weight: bold;">Assign field to Bank</label>
                                        <div class="form-group"> 
                                            <ul style="padding: 0px; list-style: none;">
                                                <li style="margin-bottom: 6px;"><label><input style="float: left; margin-top: 3px; margin-right: 7px;"  type="checkbox" class="selectall" name="text"> Select all</label></li>

                                                @foreach($banks as $bank)   
                                                    <li style="margin-bottom: 6px;"><label><input style="float: left; margin-top: 3px; margin-right: 7px;" @if(isset($service_id)) @if(in_array($bank->id, $service_id)) checked="" @endif @endif  type="checkbox" value="{{ $bank->id }}" name="bank[]"> {{ $bank->name }} </label></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                   

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-default w3ls-button">Submit</button> 
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
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
$('.selectall').click(function() {
    if ($(this).is(':checked')) {
        $('.col-md-12 input').attr('checked', true);
    } else {
        $('.col-md-12 input').attr('checked', false);
    }
});  

</script>

@stop

