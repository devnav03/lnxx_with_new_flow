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
                <h1 class="page-header">Card Type Information<a class="btn btn-sm btn-primary pull-right" href="{!! route('card-type.index') !!}" > <i class="fa fa-solid fa-arrow-left"></i> All Card Categories</a></h1>
                
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
                                @if($route == 'card-type.create')
                                    {!! Form::open(array('method' => 'POST', 'route' => array('card-type.store'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                @elseif($route == 'card-type.edit')
                                    {!! Form::model($result, array('route' => array('card-type.update', $result->id), 'method' => 'PATCH', 'id' => 'card-type-form', 'class' => '', 'files'=>'true')) !!}
                                @else
                                    Nothing
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-6">
                                         <div class="form-group"> 
                                            {!! Form::label('name', lang('Name'), array('class' => '')) !!}
                                            {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        </div>
                                        <div class="form-group"> 
                                            <label style="font-size: 14px;font-weight: 500;">Select Bank</label>
                                            <ul style="padding: 0px; list-style: none;">
                                                @foreach($banks as $bank)   
                                                    <li style="margin-bottom: 6px;"><label><input @if(isset($bank_id)) @if(in_array($bank->id, $bank_id)) checked="" @endif @endif style="float: left; margin-top: 3px; margin-right: 7px;" type="checkbox" value="{{ $bank->id }}" name="bank[]"> {{ $bank->name }} </label></li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    </div> 

                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                            {!! Form::label('image', lang('Card Image'), array('class' => '')) !!}
                                            @if(!empty($result->image))
                                            <input name="image" type='file' class="form-control" accept="image/png, image/jpeg" id="imgInp" style="padding-top: 6px; border: 0px;" />
                                            @else
                                            <input name="image" type='file' class="form-control" accept="image/png, image/jpeg" required="true" id="imgInp" style="padding-top: 6px; border: 0px;" />
                                            @endif
                                            <img id="blah" style="max-width: 55%;margin-top:10px;" src="#" alt="" />
                                        </div>
                                        @if(!empty($result->image))
                                            <div class="form-group"> 
                                                 {!! Html::image(asset($result->image),'' ,array('width' => 200 ,'class'=>'img-responsive') ) !!}
           
                                            </div>
                                        @endif
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
    
imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}    

</script>

@stop

