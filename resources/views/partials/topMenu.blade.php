<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ action("DocumentController@ldmsCreate") }}">@if($ldms_general_setting_data->site_logo)<img src="{{url('public/logo', $ldms_general_setting_data->site_logo)}}" style="width: 20px; height: auto; display: inline-block;">@endif {{$ldms_general_setting_data->site_title}}</a>
    </div>

    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown text-center">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
          <i class="fa fa-language" aria-hidden="true"></i>
          {{trans('file.Language')}} <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="{{ url('language-switch/en') }}"> English</a></li>
          <li><a href="{{ url('language-switch/es') }}"> Español</a></li>
          <li><a href="{{ url('language-switch/ar') }}"> عربى</a></li>
          <li><a href="{{ url('language-switch/pr') }}"> Português</a></li>
          <li><a href="{{ url('language-switch/fr') }}"> Français</a></li>
          <li><a href="{{ url('language-switch/ru') }}"> русский</a></li>
          <li><a href="{{ url('language-switch/de') }}"> Deutsche</a></li>
          <li><a href="{{ url('language-switch/ma') }}"> Malay</a></li>
          <li><a href="{{ url('language-switch/tr') }}"> Türk</a></li>
          <li><a href="{{ url('language-switch/nl') }}"> Nederlands</a></li>
        </ul>
      </li>
      <li class="dropdown text-center">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
          <i class="fa fa-user" aria-hidden="true"></i>
          {{ Auth::user()->name }} <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="{{ action("DocumentController@ldmsCreate") }}"><i class="fa fa-tachometer"></i> {{trans('file.Dashboard')}}</a></li>
          <li><a href="{{ action("DocumentController@ldmsUpdateProfile") }}"><i class="fa fa-support"></i> {{trans('file.User Options')}}</a></li>
          <?php
            $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
            $ldms_role_data = Db::table('roles')->where('id', $ldms_user_data->role_id)->first();
          ?>
          @if($ldms_role_data->id == 4)
          <li><a href="{{ action("RolesController@create") }}"><i class="fa fa-support"></i> {{trans('file.Create Role')}}</a></li>
          <li><a href="{{ action("UserController@create") }}"><i class="fa fa-support"></i> {{trans('file.Create User Account')}}</a></li>
          <li><a href="{{route('setting.general')}}"><i class="fa fa-cog"></i> {{trans('file.General Setting')}}</a></li>
          <li><a href="{{route('setting.mail')}}"><i class="fa fa-envelope"></i> {{trans('file.Mail Setting')}}</a></li>
          <li><a href="{{route('setting.sms')}}"><i class="fa fa-paper-plane"></i> {{trans('file.SMS Setting')}}</a></li> 
          @endif
        </ul>
      </li>
      <li>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
          <i class="fa fa-bell" aria-hidden="true"></i><span class="badge"><?php echo count($ldms_expired_documents_all) + count($ldms_close_expired_documents_all);?></span>
        </a>

        <ul class="dropdown-menu" role="menu">
          <li><a class="danger" href="{{ action("DocumentController@ldmsExpiredDocuments") }}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo count($ldms_expired_documents_all);?> {{trans('file.Documents Expired')}}</a></li>
          <li><a class="warning" href="{{ action("DocumentController@ldmsCloseToBeExpiredDocuments") }}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo count($ldms_close_expired_documents_all);?> {{trans('file.Documents Expiring Soon')}}</a></li>
        </ul>
      </li>
      <li>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i> {{trans('file.LOGOUT')}}
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
      </form>
      </li>
    </ul>
  </div><!-- /.container-fluid -->
</nav>
