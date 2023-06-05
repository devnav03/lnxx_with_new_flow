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
                <h1 class="page-header">Application Status<a class="btn btn-sm btn-primary pull-right" href="{!! route('application-status.index') !!}" > <i class="fa fa-solid fa-arrow-left"></i> All Application Status</a></h1>
                
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
                                @if($route == 'application-status.create')
                                    {!! Form::open(array('method' => 'POST', 'route' => array('application-status.store'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                @elseif($route == 'application-status.edit')
                                    {!! Form::model($result, array('route' => array('application-status.update', $result->id), 'method' => 'PATCH', 'id' => 'application-status-form', 'class' => '', 'files'=>'true')) !!}
                                @else
                                    Nothing
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-6">
                                         <div class="form-group"> 
                                            {!! Form::label('name', lang('Name'), array('class' => '')) !!}
                                            {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        </div> 
                                        <div class="row">
                
                                 
                                    <div class="col-md-12">
                                         <button type="submit" class="btn btn-default w3ls-button">Submit</button> 
                                    </div>
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
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}    

</script>

@stop

