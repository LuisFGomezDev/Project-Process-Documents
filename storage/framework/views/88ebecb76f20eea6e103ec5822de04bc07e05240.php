<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap-datepicker.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/font-awesome.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/jquery-ui.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/main.css')?>" type="text/css"> 
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/select.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/dataTables.checkboxes.css') ?>">
</head>
<body>
<?php echo $__env->make('partials.topMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<title>LDMS</title>
<?php if(session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message1')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message1')); ?></div> 
<?php endif; ?>
<?php if($errors->has('title')): ?>
 <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><?php echo e($errors->first('title')); ?></strong></div>

<?php endif; ?>
<?php if(count($role_list)!=0): ?>
  <div class="col-md-9">     
    <!--Role List Start-->
    <div class="col-md-12 panel">
        <h1><strong><?php echo e(trans('file.All Roles')); ?></strong></h1>
        <br>
        <div class="col-md-12"> 
	        <table id="role-table" class="table table-bordered table-striped">
              <thead>
                <th class="not-exported"></th>
                <th><?php echo e(trans('file.SL No')); ?></th>
                <th><?php echo e(trans('file.Role Title')); ?></th>            
                <th class="text-center hidden-print not-exported">Option</th>
              </thead>
	            <tbody>
                <?php $__currentLoopData = $role_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                      <td><?php echo e($key); ?></td>
                      <td><?php echo $key+1 ?></td>
                      <td><?php echo $role->title; ?></td>
                      <td class="text-center hidden-print">
                          <div class="btn-group">
                              <button type="button" class="btn btn-default"><?php echo e(trans('file.Action')); ?></button>
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                  <li><a title = "View" href="<?php echo $role->id; ?>/edit"><i class="fa fa-eye" aria-hidden="true"></i><?php echo e(trans('file.View')); ?> </a></li>
                                  <?php if($key): ?>
                                  <li class="divider"></li>
                                  <?php echo Form::open(['route' => ['role.destroy', $role->id], 'method' => 'DELETE'] ); ?>

                                  <li>
                                    <button type="submit" class="custom-del" onclick="return confirmDelete()"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo e(trans('file.Delete')); ?></button> 
                                  </li>
                                  <?php echo Form::close(); ?>

                                  <?php endif; ?>
                              </ul>
                          </div>
                      </td>
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
              </tbody>
	        </table>
        </div>
            
     </div>
  </div>
<?php endif; ?>

<div class="col-md-3">
  <div class="col-md-12 panel">
  <center><h3><strong><?php echo e(trans('file.Add Role')); ?></strong> </h3> </center>
  <div class="row">
    <div class="col-md-12">
      <?php echo Form::open(['route' => 'role.store', 'method' => 'post']); ?>

      
      <div class="form-group">
             <label for="ldms_roleTitle"><?php echo e(trans('file.Role Title')); ?></label>
             <div class="form-group-inner">
                <div class="field-outer">
                    <?php echo e(Form::text('title',null,array('required' => 'required', 'class' => 'form-control', 'awesome'))); ?>

            <?php if($errors->has('title')): ?>
              <span class="help-block">
                          <strong><?php echo e($errors->first('title')); ?></strong>
                      </span>
            <?php endif; ?>
                </div>
             </div>
          </div>

          <div class="form-group">
              <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">  
          </div> 

    </div>      
  </div>
  </div>
</div>		
<?php echo Form::close(); ?>


<script type="text/javascript" src="<?php echo asset('public/js/jquery-3.2.0.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-ui.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap-datepicker.min.js')?>"></script>

<script type="text/javascript" src="<?php echo asset('public/js/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/dataTables.bootstrap4.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/dataTables.buttons.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/buttons.bootstrap4.min.js') ?>">"></script>
<script type="text/javascript" src="<?php echo asset('public/js/buttons.print.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/vfs_fonts.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/buttons.html5.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/buttons.colVis.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/sum().js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/dataTables.select.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/dataTables.checkboxes.min.js') ?>"></script>

<script type="text/javascript">

  $('#role-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ <?php echo e(trans("file.records per page")); ?>',
             "info":      '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
            "search":  '<?php echo e(trans("file.Search")); ?>',
            'paginate': {
                    'previous': '<?php echo e(trans("file.Previous")); ?>',
                    'next': '<?php echo e(trans("file.Next")); ?>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 3]
            },
            {
                'checkboxes': {
                   'selectRow': true
                },
                'targets': 0
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'pdf',
                text: '<?php echo e(trans("file.PDF")); ?>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    modifier: {
                          page: 'current'
                    }
                },
                footer:true
            },
            {
                extend: 'csv',
                text: '<?php echo e(trans("file.CSV")); ?>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    modifier: {
                          page: 'current'
                    }
                },
                footer:true
            },
            {
                extend: 'print',
                text: '<?php echo e(trans("file.Print")); ?>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    modifier: {
                          page: 'current'
                    }
                },
                footer:true
            },
            {
                extend: 'colvis',
                text: '<?php echo e(trans("file.Column visibility")); ?>',
                columns: ':gt(0)'
            },
        ],
    } );

<?php if(count($role_list)!=0): ?>
    function confirmDelete() {
      if (confirm("Are you sure want to delete?")) {
          return true;
      }
      return false;
    }

    $(function () {
      var tooltip = $('[data-toggle="tooltip"]');
      tooltip.tooltip({container: 'body'});
    });

  
<?php endif; ?>
</script>


