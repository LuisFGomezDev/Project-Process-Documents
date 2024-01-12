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
<?php echo $__env->make('partials.topMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<title>LDMS</title>
<?php if(session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<div class="col-md-12 panel">
    <center><h3><strong><?php echo e(trans('file.General Setting')); ?></strong></h3> </center>
    <?php echo Form::open(['route' => 'setting.generalStore', 'files' => true, 'method' => 'post']); ?>

        <div class="row">
            <div class="col-md-3 col-md-offset-3">
                <div class="form-group">
                    <label><strong><?php echo e(trans('file.Site Title')); ?> *</strong></label>
                    <input type="text" name="site_title" class="form-control" required value="<?php if($ldms_general_setting_data): ?><?php echo e($ldms_general_setting_data->site_title); ?><?php endif; ?>"/>
                </div>
                <div class="form-group">
                    <label><strong><?php echo e(trans('file.Notify By')); ?> *</strong></label>
                    <div class="radio">
                    	<?php if($ldms_general_setting_data->notify_by == 'email'): ?>
					  	<label><input type="radio" name="notify_by" value="email" checked /> <?php echo e(trans('file.Email')); ?></label> &nbsp;
					  	<label><input type="radio" name="notify_by" value="sms"> <?php echo e(trans('file.SMS')); ?></label>
					  	<?php else: ?>
					  	<label><input type="radio" name="notify_by" value="email" /> <?php echo e(trans('file.Email')); ?></label> &nbsp;
					  	<label><input type="radio" name="notify_by" value="sms" checked> <?php echo e(trans('file.SMS')); ?></label>
					  	<?php endif; ?>
					</div>
                </div>
                <div class="form-group">
                    <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><strong><?php echo e(trans('file.Site Logo')); ?></strong></label>
                    <input type="file" name="site_logo" class="form-control"/>
                </div>
                <?php if($errors->has('site_logo')): ?>
               <span>
                   <strong><?php echo e($errors->first('site_logo')); ?></strong>
                </span>
                <?php endif; ?>
                <div class="form-group">
                    <label><strong><?php echo e(trans('file.Time Zone')); ?></strong></label>
                    <input type="hidden" name="timezone_hidden" value="<?php echo e(env('APP_TIMEZONE')); ?>">
                    <select name="timezone" class="selectpicker form-control" data-live-search="true" title="Select TimeZone...">
                        <?php $__currentLoopData = $zones_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                        <?php if(env('APP_TIMEZONE') == $zone['zone']): ?>
	                        	<option value="<?php echo e($zone['zone']); ?>" selected><?php echo e($zone['diff_from_GMT'] . ' - ' . $zone['zone']); ?></option>
	                        <?php else: ?>
	                        	<option value="<?php echo e($zone['zone']); ?>"><?php echo e($zone['diff_from_GMT'] . ' - ' . $zone['zone']); ?></option>
	                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
    <?php echo Form::close(); ?>

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