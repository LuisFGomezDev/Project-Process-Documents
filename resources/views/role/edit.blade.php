<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap-datepicker.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/font-awesome.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/jquery-ui.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/main.css')?>" type="text/css"> 
</head>
<body>
@include('partials.topMenu')
<title>LDMS</title>
@if($errors->has('title'))
 <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>{{ $errors->first('title') }}</strong></div>

@endif

<div class="col-md-12 panel">
    <center><h3><strong>{{trans('file.Edit Role')}}</strong></h3> </center>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<strong>{{trans('file.Role Title')}}:</strong>
			{!! Form::open(['route' => ['role.update',$data->id], 'method' => 'PUT']) !!}
			{{Form::text('title',$value = $data->title,array('required' => 'required', 'class' => 'form-control mar-t-b awesome'))}}
			<input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
		</div>
	</div>
</div> 

{!! Form::close() !!}
<script type="text/javascript" src="<?php echo asset('public/js/jquery-3.2.0.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-ui.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap-datepicker.min.js')?>"></script>
<script type="text/javascript">
 var ldms_experiedDate = $('#ldms_experiedDate');
 ldms_experiedDate.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y', strtotime('+2 day')); ?>",
     autoclose: true,
     todayHighlight: true
     });


 </script>
</body>
