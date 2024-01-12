<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading"><h1 class="text-center"><?php if($ldms_general_setting_data->site_logo): ?><img src="<?php echo e(url('public/logo', $ldms_general_setting_data->site_logo)); ?>" style="width: 35px; height: auto; display: inline-block;"><?php endif; ?> <?php echo e($ldms_general_setting_data->site_title); ?></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                            <label for="name" class="col-md-4 control-label"><?php echo e(trans('file.User Name')); ?></label>

                            <div class="col-md-6 input-group">
                            	<span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                                <input id="name" type="text" class="form-control" name="name" value="admin" required autofocus>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                            <label for="password" class="col-md-4 control-label"><?php echo e(trans('file.Password')); ?></label>

                            <div class="col-md-6 input-group">
                            	<span class="input-group-addon" id="basic-addon1"><i class="fa fa-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password" value="admin" required>
                            </div>
                        </div>
                        <?php if($errors->has('name')): ?>
                        <div class="form-group">
                            <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e($errors->first('name')); ?></div>
                            </div> 
                        </div>                             
                        <?php endif; ?>                               
                                
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>> <?php echo e(trans('file.Remember Me')); ?>

                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <?php echo e(trans('file.Login')); ?>

                                </button>

                                <a class="btn btn-link" href="<?php echo e(route('password.request')); ?>">
                                    <?php echo e(trans('file.Forgot Your Password?')); ?>

                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>