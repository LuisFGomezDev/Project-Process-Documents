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
    <center><h3><strong><?php echo e(trans('file.SMS Setting')); ?></strong></h3> </center>
    <?php echo Form::open(['route' => 'setting.smsStore', 'method' => 'post']); ?>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="form-group">
                    <input type="hidden" name="gateway_hidden" value="<?php echo e(env('SMS_GATEWAY')); ?>">
                    <label><strong><?php echo e(trans('file.Gateway')); ?> *</strong></label>
                    <select class="form-control" name="gateway">
                        <option selected disabled><?php echo e(trans('file.Select SMS gateway...')); ?></option>
                        <option value="twilio">Twilio</option>
                        <option value="clickatell">Clickatell</option>
                    </select>
                </div>
                <div class="form-group twilio">
                    <label><strong>ACCOUNT SID *</strong></label>
                    <input type="text" name="account_sid" class="form-control twilio-option" value="<?php echo e(env('ACCOUNT_SID')); ?>" />
                </div>
                <div class="form-group twilio">
                    <label><strong>AUTH TOKEN *</strong></label>
                    <input type="text" name="auth_token" class="form-control twilio-option" value="<?php echo e(env('AUTH_TOKEN')); ?>" />
                </div>
                <div class="form-group twilio">
                    <label><strong>Twilio Number *</strong></label>
                    <input type="text" name="twilio_number" class="form-control twilio-option" value="<?php echo e(env('Twilio_Number')); ?>" />
                </div>
                <div class="form-group clickatell">
                    <label><strong>API Key *</strong></label>
                    <input type="text" name="api_key" class="form-control clickatell-option" value="<?php echo e(env('CLICKATELL_API_KEY')); ?>" />
                </div>
                <div class="form-group">
                    <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
                </div>
            </div>
        </div>
    <?php echo Form::close(); ?>

</div>

<script type="text/javascript" src="<?php echo asset('public/js/jquery-3.2.0.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-ui.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap-datepicker.min.js')?>"></script>

 <script type="text/javascript">
     if( $('input[name="gateway_hidden"]').val() == 'twilio' ){
        $('select[name="gateway"]').val('twilio');
        $('.clickatell').hide();
    }
    else if( $('input[name="gateway_hidden"]').val() == 'clickatell' ){
        $('select[name="gateway"]').val('clickatell');
        $('.twilio').hide();
    }
    else{
        $('.clickatell').hide();
        $('.twilio').hide();
    }

    $('select[name="gateway"]').on('change', function(){
        if( $(this).val() == 'twilio' ){
            $('.clickatell').hide();
            $('.twilio').show(500);
            $('.twilio-option').prop('required',true);
            $('.clickatell-option').prop('required',false);
        }
        else if( $(this).val() == 'clickatell' ){
            $('.twilio').hide();
            $('.clickatell').show(500);
            $('.twilio-option').prop('required',false);
            $('.clickatell-option').prop('required',true);
        }
    });
 </script>

</body>