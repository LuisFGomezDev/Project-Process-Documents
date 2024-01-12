<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($ldms_general_setting_data->site_title); ?></title>
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap-datepicker.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/font-awesome.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/jquery-ui.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/main.css')?>" type="text/css">
</head>
<body>
<?php echo $__env->make('partials.topMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message')): ?>
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message1')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message1')); ?></div> 
<?php endif; ?>
    <!--Profile Edit Start-->
    <form class="form-group" method="post" action="ldms_manageProfileUpdate">
        <?php echo csrf_field(); ?>

        <div class="col-md-6">
            <div class="col-md-12 panel">
                <h3><?php echo e(trans('file.Manage Profile')); ?></h3>
                <input type="hidden" name="id" value="<?php echo $userInformation[0]->id;?>">
                <div class="form-group col-md-12">
                     <label for="ldms_documentTitle"><?php echo e(trans('file.Name')); ?></label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                             <input class="form-control" type="text" name="ldms_name" id="ldms_name" value="<?php echo $userInformation[0]->name;?>">
                         </div>
                     </div>
                </div>                   
                <div class="form-group col-md-12">
                    <label for="ldms_experiedDate"><?php echo e(trans('file.Email')); ?></label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <input id="ldms_email" name="ldms_email" class="form-control" type="email" value="<?php echo $userInformation[0]->email;?>">
                         </div>
                    </div>
                </div>

                <div class="form-group submit col-md-12 text-left">
                    <div class="form-group-inner">
                        <div class="field-outer">
                            <input type="submit" name="submit" value="<?php echo e(trans('file.Update')); ?>" class="btn btn-primary" id="upadteFormManageProfile">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form class="form-group" method="post" action="ldms_changePassword">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="id" value="<?php echo $userInformation[0]->id;?>">
        
        <div class="col-md-6">
            <div class="col-md-12 panel">
                <h3><?php echo e(trans('file.Change Password')); ?></h3>
                <div class="form-group col-md-12">
                     <label for="ldms_email"><?php echo e(trans('file.Current Password')); ?></label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input class="form-control" type="password" name="ldms_old_password" id="ldms_old_password">
                         </div>
                     </div>
                </div>  

                <div class="form-group col-md-12">
                     <label for="ldms_email"><?php echo e(trans('file.New Password')); ?></label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input class="form-control" type="password" name="ldms_new_password" id="ldms_new_password">
                         </div>
                     </div>
                </div>  

                <div class="form-group col-md-12">
                     <label for="ldms_email"><?php echo e(trans('file.Confirm Password')); ?></label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input class="form-control" type="password" name="ldms_confirm_password" id="ldms_confirm_password" 
                            onChange="checkPasswordMatch();" >
                         </div>
                     </div>
                </div>
            
                <div class="form-group col-md-12">
                    <div class="registrationFormAlert" id="divCheckPasswordMatch">
                </div>

                <div class="form-group submit col-md-12 text-left">
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <input type="submit" name="submit" value="<?php echo e(trans('file.Update')); ?>" class="btn btn-primary" id="updatePassword">
                         </div>
                    </div>
                </div> 
                </div>
            </div>
        </div>               
    </form>
    <!--Profile Edit End-->
  <script type="text/javascript" src="<?php echo asset('public/js/jquery-3.2.0.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-ui.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap-datepicker.min.js')?>"></script>

 <script type="text/javascript">
 var upadteFormManageProfile = $('#upadteFormManageProfile');
    upadteFormManageProfile.on("click",function () {
        var ldms_name = $.trim($('#ldms_name').val());
        if (ldms_name == '') {
            alert("Name can't be empty.");
            $("#ldms_name").focus();
            return false;
        }
        var ldms_email = $.trim($('#ldms_email').val());
        if (ldms_email == '') {
            alert("Email can't be empty.");
            $('#ldms_email').focus();
            return false;
        }
    });

 var updatePassword = $('#updatePassword');
    updatePassword.on("click",function () {
        var ldms_old_password = $.trim($('#ldms_old_password').val());
        if (ldms_old_password == '') {
            alert("Current Password can't be empty.");
            $("#ldms_old_password").focus();
            return false;
        }
        var ldms_new_password = $.trim($('#ldms_new_password').val());
        if (ldms_new_password == '') {
            alert("New Password can't be empty.");
            $('#ldms_new_password').focus();
            return false;
        }
        var ldms_confirm_password = $.trim($('#ldms_confirm_password').val());
        if (ldms_confirm_password == '') {
            alert("Confirm Password can't be empty.");
            $('#ldms_confirm_password').focus();
            return false;
        }
    });

    function checkPasswordMatch() {
    var password = $("#ldms_new_password").val();
    var confirmPassword = $("#ldms_confirm_password").val();

    if (password != confirmPassword)
        $("#divCheckPasswordMatch").html("Passwords do not match!");
    else
        $("#divCheckPasswordMatch").html("Passwords match.");
    }

    $(document).ready(function () {
       $("#ldms_confirm_password").keyup(checkPasswordMatch);
    });

 </script>
 </body>
 </html>
