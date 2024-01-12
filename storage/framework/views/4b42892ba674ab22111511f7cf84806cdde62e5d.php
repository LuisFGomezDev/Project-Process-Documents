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
<?php echo $__env->make('partials.topMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<title>LDMS</title>
<?php if(session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<div class="col-md-12 panel">
    <center><h3><strong><?php echo e(trans('file.Mail Setting')); ?></strong></h3> </center>
    <?php echo Form::open(['route' => 'setting.mailStore', 'method' => 'post']); ?>

        <div class="row">
            <div class="col-md-3 col-md-offset-3">
                <div class="form-group">
                    <label><strong><?php echo e(trans('file.Mail Host')); ?> *</strong></label>
                    <input type="text" name="mail_host" class="form-control" value="<?php echo e(env('MAIL_HOST')); ?>" required />
                </div>
                <div class="form-group">
                    <label><strong><?php echo e(trans('file.Mail Address')); ?> *</strong></label>
                    <input type="text" name="mail_address" class="form-control" value="<?php echo e(env('MAIL_FROM_ADDRESS')); ?>" required />
                </div>
                <div class="form-group">
                    <label><strong><?php echo e(trans('file.Mail From Name')); ?> *</strong></label>
                    <input type="text" name="mail_name" class="form-control" value="<?php echo e(env('MAIL_FROM_NAME')); ?>" required />
                </div>
                <div class="form-group">
                    <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><strong><?php echo e(trans('file.Mail Port')); ?> *</strong></label>
                    <input type="text" name="port" class="form-control" value="<?php echo e(env('MAIL_PORT')); ?>" required />
                </div>
                <div class="form-group">
                    <label><strong><?php echo e(trans('file.Password')); ?> *</strong></label>
                    <input type="password" name="password" class="form-control" value="" required />
                </div>
                <div class="form-group">
                    <label><strong><?php echo e(trans('file.Encryption')); ?> *</strong></label>
                    <input type="text" name="encryption" class="form-control" value="<?php echo e(env('MAIL_ENCRYPTION')); ?>" required />
                </div>
            </div>
        </div>
    <?php echo Form::close(); ?>

</div>

<script type="text/javascript" src="<?php echo asset('public/js/jquery-3.2.0.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-ui.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap-datepicker.min.js')?>"></script>

</body>