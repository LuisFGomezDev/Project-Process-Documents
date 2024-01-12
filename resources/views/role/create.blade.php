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
@include('partials.topMenu')
<title>LDMS</title>
@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('message1'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message1') }}</div> 
@endif
@if($errors->has('title'))
 <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>{{ $errors->first('title') }}</strong></div>

@endif
@if(count($role_list)!=0)
  <div class="col-md-9">     
    <!--Role List Start-->
    <div class="col-md-12 panel">
        <h1><strong>{{trans('file.All Roles')}}</strong></h1>
        <br>
        <div class="col-md-12"> 
	        <table id="role-table" class="table table-bordered table-striped">
              <thead>
                <th class="not-exported"></th>
                <th>{{trans('file.SL No')}}</th>
                <th>{{trans('file.Role Title')}}</th>            
                <th class="text-center hidden-print not-exported">Option</th>
              </thead>
	            <tbody>
                @foreach($role_list as $key=>$role)
                  <tr>
                      <td>{{$key}}</td>
                      <td><?php echo $key+1 ?></td>
                      <td>{!! $role->title !!}</td>
                      <td class="text-center hidden-print">
                          <div class="btn-group">
                              <button type="button" class="btn btn-default">{{trans('file.Action')}}</button>
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                  <li><a title = "View" href="{!! $role->id !!}/edit"><i class="fa fa-eye" aria-hidden="true"></i>{{trans('file.View')}} </a></li>
                                  @if($key)
                                  <li class="divider"></li>
                                  {!! Form::open(['route' => ['role.destroy', $role->id], 'method' => 'DELETE'] ) !!}
                                  <li>
                                    <button type="submit" class="custom-del" onclick="return confirmDelete()"><i class="fa fa-trash" aria-hidden="true"></i> {{trans('file.Delete')}}</button> 
                                  </li>
                                  {!! Form::close() !!}
                                  @endif
                              </ul>
                          </div>
                      </td>
                  </tr>
                @endforeach  
              </tbody>
	        </table>
        </div>
            
     </div>
  </div>
@endif

<div class="col-md-3">
  <div class="col-md-12 panel">
  <center><h3><strong>{{trans('file.Add Role')}}</strong> </h3> </center>
  <div class="row">
    <div class="col-md-12">
      {!! Form::open(['route' => 'role.store', 'method' => 'post']) !!}
      
      <div class="form-group">
             <label for="ldms_roleTitle">{{trans('file.Role Title')}}</label>
             <div class="form-group-inner">
                <div class="field-outer">
                    {{Form::text('title',null,array('required' => 'required', 'class' => 'form-control', 'awesome'))}}
            @if($errors->has('title'))
              <span class="help-block">
                          <strong>{{ $errors->first('title') }}</strong>
                      </span>
            @endif
                </div>
             </div>
          </div>

          <div class="form-group">
              <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">  
          </div> 

    </div>      
  </div>
  </div>
</div>		
{!! Form::close() !!}

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
            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
             "info":      '{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)',
            "search":  '{{trans("file.Search")}}',
            'paginate': {
                    'previous': '{{trans("file.Previous")}}',
                    'next': '{{trans("file.Next")}}'
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
                text: '{{trans("file.PDF")}}',
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
                text: '{{trans("file.CSV")}}',
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
                text: '{{trans("file.Print")}}',
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
                text: '{{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            },
        ],
    } );

@if(count($role_list)!=0)
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

  
@endif
</script>


