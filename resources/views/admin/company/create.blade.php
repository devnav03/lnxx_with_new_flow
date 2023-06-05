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
                <h1 class="page-header">Company Information<a class="btn btn-sm btn-primary pull-right" href="{!! route('company.index') !!}" > <i class="fa fa-solid fa-arrow-left"></i> All Companies</a></h1>
                
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
                                @if($route == 'company.create')
                                    {!! Form::open(array('method' => 'POST', 'route' => array('company.store'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                @elseif($route == 'company.edit')
                                    {!! Form::model($result, array('route' => array('company.update', $result->id), 'method' => 'PATCH', 'id' => 'company-form', 'class' => '', 'files'=>'true')) !!}
                                @else
                                    Nothing
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                            {!! Form::label('name', lang('Name'), array('class' => '')) !!}
                                            {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        </div> 
                                    </div>  
                                    <div class="col-md-6">
                                      <label class="sub-label">Type</label>
                                        <select name="type" class="form-control" required="true">
                                          <option value="">Select</option>
                                          <option value="Private Limited Company" @if(isset($result)) @if($result->type == "Private Limited Company") selected @endif @endif >Private Limited Company</option>
                                          <option value="Public Limited Company" @if(isset($result)) @if($result->type == "Public Limited Company") selected @endif @endif >Public Limited Company</option>
                                          <option value="Section 8 Company (NGO)" @if(isset($result)) @if($result->type == "Section 8 Company (NGO)") selected @endif @endif >Section 8 Company (NGO)</option>
                                        <option value="Micro Companies" @if(isset($result)) @if($result->type == "Micro Companies") selected @endif @endif >Micro Companies</option>
                                        <option value="Small Companies" @if(isset($result)) @if($result->type == "Small Companies") selected @endif @endif >Small Companies</option>
                                        <option value="Medium Companies" @if(isset($result)) @if($result->type == "Medium Companies") selected @endif @endif >Medium Companies</option>
                                        <option value="Limited By Shares" @if(isset($result)) @if($result->type == "Limited By Shares") selected @endif @endif >Limited By Shares</option>
                                        <option value="Limited by Guarantee" @if(isset($result)) @if($result->type == "Limited by Guarantee") selected @endif @endif >Limited by Guarantee</option>
                                        <option value="Unlimited Company" @if(isset($result)) @if($result->type == "Unlimited Company") selected @endif @endif >Unlimited Company</option>
                                        <option value="Holding Company" @if(isset($result)) @if($result->type == "Holding Company") selected @endif @endif >Holding Company</option>
                                        <option value="Subsidiary Company" @if(isset($result)) @if($result->type == "Subsidiary Company") selected @endif @endif >Subsidiary Company</option>
                                        <option value="Listed Company" @if(isset($result)) @if($result->type == "Listed Company") selected @endif @endif >Listed Company</option>
                                        <option value="Unlisted Company" @if(isset($result)) @if($result->type == "Unlisted Company") selected @endif @endif >Unlisted Company</option>
                                        </select>
                                      </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                            {!! Form::label('email', lang('Email'), array('class' => '')) !!}
                                            {!! Form::email('email', null, array('class' => 'form-control')) !!}
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                            {!! Form::label('mobile', lang('Mobile'), array('class' => '')) !!}
                                            {!! Form::number('mobile', null, array('class' => 'form-control')) !!}
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                            {!! Form::label('address', lang('Address'), array('class' => '')) !!}
                                            {!! Form::text('address', null, array('class' => 'form-control')) !!}
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


@stop

