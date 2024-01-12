<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LDMS</title>
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap-datepicker.min.css')?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap-select.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/font-awesome.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/jquery-ui.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/main.css')?>" type="text/css">
</head>
<body>
@include('partials.topMenu')
<title>LDMS</title>
@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<div class="col-md-12 panel">
    <center><h3><strong>{{trans('file.General Setting')}}</strong></h3> </center>
    {!! Form::open(['route' => 'setting.generalStore', 'files' => true, 'method' => 'post']) !!}
        <div class="row">
            <div class="col-md-3 col-md-offset-3">
                <div class="form-group">
                    <label><strong>{{trans('file.Site Title')}} *</strong></label>
                    <input type="text" name="site_title" class="form-control" required value="@if($ldms_general_setting_data){{$ldms_general_setting_data->site_title}}@endif"/>
                </div>
                <div class="form-group">
                    <label><strong>{{trans('file.Notify By')}} *</strong></label>
                    <div class="radio">
                    	@if($ldms_general_setting_data->notify_by == 'email')
					  	<label><input type="radio" name="notify_by" value="email" checked /> {{trans('file.Email')}}</label> &nbsp;
					  	<label><input type="radio" name="notify_by" value="sms"> {{trans('file.SMS')}}</label>
					  	@else
					  	<label><input type="radio" name="notify_by" value="email" /> {{trans('file.Email')}}</label> &nbsp;
					  	<label><input type="radio" name="notify_by" value="sms" checked> {{trans('file.SMS')}}</label>
					  	@endif
					</div>
                </div>
                <div class="form-group">
                    <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><strong>{{trans('file.Site Logo')}}</strong></label>
                    <input type="file" name="site_logo" class="form-control"/>
                </div>
                @if($errors->has('site_logo'))
               <span>
                   <strong>{{ $errors->first('site_logo') }}</strong>
                </span>
                @endif
                <div class="form-group">
                    <label><strong>{{trans('file.Time Zone')}}</strong></label>
                    <input type="hidden" name="timezone_hidden" value="{{env('APP_TIMEZONE')}}">
                    <select name="timezone" class="selectpicker form-control" data-live-search="true" title="Select TimeZone...">
                        @foreach($zones_array as $zone)
	                        @if(env('APP_TIMEZONE') == $zone['zone'])
	                        	<option value="{{$zone['zone']}}" selected>{{$zone['diff_from_GMT'] . ' - ' . $zone['zone']}}</option>
	                        @else
	                        	<option value="{{$zone['zone']}}">{{$zone['diff_from_GMT'] . ' - ' . $zone['zone']}}</option>
	                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>

 <script type="text/javascript" src="<?php echo asset('public/js/jquery-3.2.0.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-ui.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap3.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap-datepicker.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap-select.js')?>"></script>
 <script type="text/javascript">
 	$('.selectpicker').selectpicker();
 	
 </script>

</body>