@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading"><h1 class="text-center">@if($ldms_general_setting_data->site_logo)<img src="{{url('public/logo', $ldms_general_setting_data->site_logo)}}" style="width: 35px; height: auto; display: inline-block;">@endif {{$ldms_general_setting_data->site_title}}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">{{trans('file.User Name')}}</label>

                            <div class="col-md-6 input-group">
                            	<span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                                <input id="name" type="text" class="form-control" name="name" value="admin" required autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">{{trans('file.Password')}}</label>

                            <div class="col-md-6 input-group">
                            	<span class="input-group-addon" id="basic-addon1"><i class="fa fa-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password" value="admin" required>
                            </div>
                        </div>
                        @if ($errors->has('name'))
                        <div class="form-group">
                            <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('name') }}</div>
                            </div> 
                        </div>                             
                        @endif                               
                                
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{trans('file.Remember Me')}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    {{trans('file.Login')}}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{trans('file.Forgot Your Password?')}}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
