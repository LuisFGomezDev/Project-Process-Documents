<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LDMS</title>
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap-datepicker.min.css')?>" type="text/css"> 
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
    <center><h3><strong>{{trans('file.Mail Setting')}}</strong></h3> </center>
    {!! Form::open(['route' => 'setting.mailStore', 'method' => 'post']) !!}
        <div class="row">
            <div class="col-md-3 col-md-offset-3">
                <div class="form-group">
                    <label><strong>{{trans('file.Mail Host')}} *</strong></label>
                    <input type="text" name="mail_host" class="form-control" value="{{env('MAIL_HOST')}}" required />
                </div>
                <div class="form-group">
                    <label><strong>{{trans('file.Mail Address')}} *</strong></label>
                    <input type="text" name="mail_address" class="form-control" value="{{env('MAIL_FROM_ADDRESS')}}" required />
                </div>
                <div class="form-group">
                    <label><strong>{{trans('file.Mail From Name')}} *</strong></label>
                    <input type="text" name="mail_name" class="form-control" value="{{env('MAIL_FROM_NAME')}}" required />
                </div>
                <div class="form-group">
                    <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><strong>{{trans('file.Mail Port')}} *</strong></label>
                    <input type="text" name="port" class="form-control" value="{{env('MAIL_PORT')}}" required />
                </div>
                <div class="form-group">
                    <label><strong>{{trans('file.Password')}} *</strong></label>
                    <input type="password" name="password" class="form-control" value="" required />
                </div>
                <div class="form-group">
                    <label><strong>{{trans('file.Encryption')}} *</strong></label>
                    <input type="text" name="encryption" class="form-control" value="{{env('MAIL_ENCRYPTION')}}" required />
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>

<script type="text/javascript" src="<?php echo asset('public/js/jquery-3.2.0.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-ui.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap-datepicker.min.js')?>"></script>

</body>