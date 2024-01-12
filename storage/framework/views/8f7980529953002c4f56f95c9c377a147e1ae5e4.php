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
<?php if(session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message1')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message1')); ?></div> 
<?php endif; ?>
    <div class="col-md-6">
           <div class="col-md-12 panel">
            <h3><?php echo e(trans('file.Set New Alarm')); ?></h3>  
            <!--Alarm Create Start-->
            <form class="form-group" method="post" action="ldms_alarm_add">
                <div class="col-md-12">
                    <?php echo csrf_field(); ?>                  
                    <div class="form-group col-md-6">
                        <label for="ldms_experiedDate"><?php echo e(trans('file.New Alarm Date')); ?></label>
                        <div class="form-group-inner">
                             <div class="field-outer">
                               <input id="ldms_new_alarm" name="ldms_new_alarm" class="form-control" type="text" name="date">
                             </div>
                        </div>
                    </div>  
                    <div class="form-group col-md-6">
                        <label for="ldms_experiedDate"><?php echo e(trans('file.Expired Date')); ?></label>
                        <div class="form-group-inner">
                             <div class="field-outer">
                               <input id="ldms_expire_date_show" name="ldms_expire_date_show" class="form-control" type="text" name="date" value="<?php echo $alarmDateList['expired_date']?>" disabled>
                             </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                       <input type="hidden" name="id" value="<?php echo $alarmDateList['id']?>">
                       <input type="hidden" name="previousAlarmDateString" value="<?php echo $alarmDateList['alarm']?>">
                       <input type="submit" name="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
                    </div>  
               </div>               
             </form>
             <!--Alarm Create End-->
        </div>
    </div>
            
    <div class="col-md-6">
        <div class="col-md-12 panel">
            <h3><?php echo e(trans('file.Alarm List')); ?></h3>
            <!--Alarm List Start-->
        <?php
                $alarmDatesList = $alarmDateList['alarm'];
                $alarmDates = explode(",", $alarmDatesList);
        ?>
            <div class="col-md-12">
            <?php if(!empty($alarmDatesList)): ?>    
                <table class="table table-bordered table-striped">
                    <th><?php echo e(trans('file.Alarm Date')); ?></th>            
                    <th class="text-center"><?php echo e(trans('file.Action')); ?></th>
                    <?php $__currentLoopData = $alarmDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alarmDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td> <?php echo date('d-m-Y', strtotime($alarmDate));?> </td>
                            <td class="text-center">
                                <a href="ldms_alarm_delete/<?php echo $alarmDate?>/<?php echo $alarmDateList['id']?>/<?php echo $alarmDatesList;?>"><button class="btn btn-danger" title="Delete" onclick='return confirmDelete()'><?php echo e(trans('file.Delete')); ?></button></a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            <?php else: ?>
            <p><?php echo e(trans('file.No Alarm is Set')); ?></p>
            <?php endif; ?>
            </div>
            <!--Alarm List End-->
        </div>
    </div>

 <script type="text/javascript" src="<?php echo asset('public/js/jquery-3.2.0.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-ui.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap-datepicker.min.js')?>"></script>

 <script type="text/javascript">
    $('#ldms_new_alarm').datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y', strtotime('+2 day')); ?>",
     endDate: "<?php echo date('d-m-Y', strtotime('-2 day', strtotime($alarmDateList['expired_date']))); ?>",
     autoclose: true,
     todayHighlight: true
     });
    $('form').submit(function () {
        var ldms_new_alarm = $.trim($('#ldms_new_alarm').val());
        if (ldms_new_alarm == '') {
            alert("New Alarm Date can't be empty.");
            $('#ldms_documentFile').focus();
            return false;
        }
    });

    function confirmDelete() {
    if (confirm("Are you sure want to delete?")) {
        return true;
    }
    return false;
}
</script>
</body>
</html>             
