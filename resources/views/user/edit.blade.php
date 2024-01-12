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
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
@include('partials.topMenu')
<title>LDMS</title>
@if($errors->has('email'))
 <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>{{ $errors->first('email') }}</strong></div>

@endif


<div class="col-md-12 panel">
<center><h3><strong>{{trans('file.Edit User')}}</strong></h3> </center>
{!! Form::open(['route' => ['user.update',$ldms_user_data->id], 'method' => 'PUT']) !!}
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<strong>{{trans('file.User Name')}}:</strong>	
			{{Form::text('name',$value = $ldms_user_data->name,array('required' => 'required', 'class' => 'form-control mar-t-b'))}}

			<strong>{{trans('file.Email')}}:</strong>
			{{Form::email('email',$value = $ldms_user_data->email,array('required' => 'required', 'class' => 'form-control mar-t-b'))}}	

			<strong>{{trans('file.Role')}}:</strong>
			<select name="role_id" class="form-control mar-t-b">
				@foreach($ldms_role_all as $role)
					@if($role->id == $ldms_user_data->role_id)
						<option value='{{$role->id}}'>{{$role->title}}</option>
					@endif
				@endforeach

				@foreach($ldms_role_all as $role)
					@if($role->id != $ldms_user_data->role_id)
						<option value='{{$role->id}}'>{{$role->title}}</option>
					@endif
				@endforeach
			</select>
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

	$('#genbutton').click(function(){
      $.get('../password', function(data){
        $("input[name='password']").val(data);
        alert('Password has set to  "' + data +'"');
      });
    });

 var ldms_experiedDate = $('#ldms_experiedDate');
 ldms_experiedDate.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y', strtotime('+2 day')); ?>",
     autoclose: true,
     todayHighlight: true
     });


 </script>
</body>
