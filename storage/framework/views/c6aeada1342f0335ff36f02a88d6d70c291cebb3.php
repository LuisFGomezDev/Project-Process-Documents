<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo e(action("DocumentController@ldmsCreate")); ?>"><?php if($ldms_general_setting_data->site_logo): ?><img src="<?php echo e(url('public/logo', $ldms_general_setting_data->site_logo)); ?>" style="width: 20px; height: auto; display: inline-block;"><?php endif; ?> <?php echo e($ldms_general_setting_data->site_title); ?></a>
    </div>

    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown text-center">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
          <i class="fa fa-language" aria-hidden="true"></i>
          <?php echo e(trans('file.Language')); ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="<?php echo e(url('language-switch/en')); ?>"> English</a></li>
          <li><a href="<?php echo e(url('language-switch/es')); ?>"> Español</a></li>
          <li><a href="<?php echo e(url('language-switch/ar')); ?>"> عربى</a></li>
          <li><a href="<?php echo e(url('language-switch/pr')); ?>"> Português</a></li>
          <li><a href="<?php echo e(url('language-switch/fr')); ?>"> Français</a></li>
          <li><a href="<?php echo e(url('language-switch/ru')); ?>"> русский</a></li>
          <li><a href="<?php echo e(url('language-switch/de')); ?>"> Deutsche</a></li>
          <li><a href="<?php echo e(url('language-switch/ma')); ?>"> Malay</a></li>
          <li><a href="<?php echo e(url('language-switch/tr')); ?>"> Türk</a></li>
          <li><a href="<?php echo e(url('language-switch/nl')); ?>"> Nederlands</a></li>
        </ul>
      </li>
      <li class="dropdown text-center">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
          <i class="fa fa-user" aria-hidden="true"></i>
          <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="<?php echo e(action("DocumentController@ldmsCreate")); ?>"><i class="fa fa-tachometer"></i> <?php echo e(trans('file.Dashboard')); ?></a></li>
          <li><a href="<?php echo e(action("DocumentController@ldmsUpdateProfile")); ?>"><i class="fa fa-support"></i> <?php echo e(trans('file.User Options')); ?></a></li>
          <?php
            $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
            $ldms_role_data = Db::table('roles')->where('id', $ldms_user_data->role_id)->first();
          ?>
          <?php if($ldms_role_data->id == 4): ?>
          <li><a href="<?php echo e(action("RolesController@create")); ?>"><i class="fa fa-support"></i> <?php echo e(trans('file.Create Role')); ?></a></li>
          <li><a href="<?php echo e(action("UserController@create")); ?>"><i class="fa fa-support"></i> <?php echo e(trans('file.Create User Account')); ?></a></li>
          <li><a href="<?php echo e(route('setting.general')); ?>"><i class="fa fa-cog"></i> <?php echo e(trans('file.General Setting')); ?></a></li>
          <li><a href="<?php echo e(route('setting.mail')); ?>"><i class="fa fa-envelope"></i> <?php echo e(trans('file.Mail Setting')); ?></a></li>
          <li><a href="<?php echo e(route('setting.sms')); ?>"><i class="fa fa-paper-plane"></i> <?php echo e(trans('file.SMS Setting')); ?></a></li> 
          <?php endif; ?>
        </ul>
      </li>
      <li>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
          <i class="fa fa-bell" aria-hidden="true"></i><span class="badge"><?php echo count($ldms_expired_documents_all) + count($ldms_close_expired_documents_all);?></span>
        </a>

        <ul class="dropdown-menu" role="menu">
          <li><a class="danger" href="<?php echo e(action("DocumentController@ldmsExpiredDocuments")); ?>"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo count($ldms_expired_documents_all);?> <?php echo e(trans('file.Documents Expired')); ?></a></li>
          <li><a class="warning" href="<?php echo e(action("DocumentController@ldmsCloseToBeExpiredDocuments")); ?>"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo count($ldms_close_expired_documents_all);?> <?php echo e(trans('file.Documents Expiring Soon')); ?></a></li>
        </ul>
      </li>
      <li>
        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i> <?php echo e(trans('file.LOGOUT')); ?>

      </a>
      <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
          <?php echo e(csrf_field()); ?>

      </form>
      </li>
    </ul>
  </div><!-- /.container-fluid -->
</nav>
