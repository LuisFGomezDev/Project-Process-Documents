<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$ldms_general_setting_data->site_title}}</title>
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

@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('message1'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message1') }}</div> 
@endif
@if(count($document_list)!=0)
  <div class="col-md-9">     
    <!--Document List Start-->
    <div class="col-md-12 panel">
        <h1>{{trans('file.Expired Document List')}}(<?php echo $ldms_total_documents_number;?>)</h1>
    
        <div class="col-md-12"> 
            <table id="document-table" class="table table-bordered table-striped">
                <thead>
                  <th class="not-exported"></th>
                  <th>{{trans('file.SL No')}}</th>
                  <th>{{trans('file.Document Title')}}</th>
                  <th>{{trans('file.Expired Date')}}</th>
                  <th>{{trans('file.Notification Email')}}</th>            
                  <th class="text-center hidden-print not-exported">{{trans('file.Option')}}</th>
                </thead>
                
                <tbody>
                  @foreach($document_list as $key=>$document)
                    <?php
                    $fileExtension = $document->file_name ;
                    $fileExtension = substr($fileExtension, strpos($fileExtension, ".") + 1);
                    $todayDate = strtotime(date('Y-m-d'));
                    $expiredDate = strtotime($document->expired_date);
                    ?> 

                        <tr class=<?php if ($expiredDate<$todayDate) {
                            echo "danger";
}?> data-toggle="tooltip" data-placement="top"  title= "<?php if ($expiredDate<$todayDate) {
    echo "Document Date is Expired";
}?>">
                            <td>{{$key}}</td>
                            <td><?php echo ($key+1)?></td>
                            <td>{!! $document->title !!}</td>
                            <td>{!! date('d-m-Y', strtotime($document->expired_date)) !!}</td>
                            <td>{!! $document->email !!}</td>
                    
                                <td class="text-center hidden-print">
                                <?php
                                if ($expiredDate<$todayDate) {
                                    $ldms_line_through = "line-through";
                                } else {
                                    $ldms_line_through = "none";
                                }?>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default">{{trans('file.Action')}}</button>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                            <li><a title = "View" href="ldms_edit/{!! $document->id !!}"><i class="fa fa-eye" aria-hidden="true"></i> {{trans('file.View')}}</a></li>
                                            <li class="divider"></li>
                                            <li><a title = "Download" href="../public/document/<?php echo $document->file_name;?>" download><i class="fa fa-download" aria-hidden="true"></i> {{trans('file.Download')}}</a></li>
                                            <li class="divider"></li>
                                            <li><a title = "Delete" href="ldms_delete/{!! $document->id !!}/{!! $document->file_name !!}" onclick='return confirmDelete()'><i class="fa fa-trash" aria-hidden="true"></i> {{trans('file.Delete')}}</a></li>
                                            <li class="divider"></li>
                                            <li><a class="<?php if ($expiredDate<$todayDate) {
                                                echo "disabled";
}?>" href="ldms_alarm_date/{!! $document->id !!}" title="Alarm Date"><i class="fa fa-bell" aria-hidden="true"></i> <span style="text-decoration:<?php echo $ldms_line_through;?>">{{trans('file.Alarm')}}</span></a>
                                            </li>
                                      </ul>
                                </div>
                                </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--Document List End-->
  </div>

  <div class="col-md-3">
    <div class="col-md-12 panel">
        <h3>{{trans('file.Upload New Document')}}</h3>
@else
  <div class="col-md-8 col-md-offset-2">
    <div class="col-md-12 panel">
    <h1 class="text-danger">{{trans('file.No Expired Documents to Show')}}</h1>
        <h3>{{trans('file.Upload New Document')}}</h3>
@endif        
        <!--Document Create Start-->
        <form method="post" action="ldms_store" files="true" enctype="multipart/form-data">
            <div class="col-md-12">
                {!! csrf_field() !!}
                <div class="form-group">
                     <label for="ldms_documentTitle">{{trans('file.Document Title')}}</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                             <input class="form-control" type="text" name="title" id="ldms_documentTitle" placeholder="Trade License">
                         </div>
                     </div>
                </div>                   
                <div class="form-group">
                    <label for="ldms_experiedDate">{{trans('file.Expired Date')}}</label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <input id="ldms_experiedDate" name="ldms_experiedDate" class="form-control" type="text" name="date" value="<?php echo date('d-m-Y', strtotime('+2 day')); ?>">
                         </div>
                    </div>
                </div>
                <div class="form-group">
                     <label for="ldms_email">{{trans('file.Notification Email')}}</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input class="form-control" type="email" name="ldms_email" id="ldms_email" placeholder=
                            "abc@gmail.com">
                         </div>
                     </div>
                </div>
                <div class="form-group">
                     <label for="ldms_email">{{trans('file.Notification Mobile')}}</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input class="form-control" type="text" name="mobile" placeholder=
                            "+8801*********">
                         </div>
                     </div>
                </div>
                <div class="form-group">
                     <label for="ldms_documentFile"> {{trans('file.Document')}}</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                             <input  type="file" name="ldms_documentFile" id="ldms_documentFile">
                             <label class="btn btn-default" for="ldms_documentFile"><i class="fa fa-upload"></i> {{trans('file.Upload File')}}</label>
                             <span id="ldms_document_file_name"></span>
                         </div>
                     </div>
                </div>
                <div class="form-group">
                  <input type="submit" name="submit" value="{{trans('file.Submit')}}" class="btn btn-primary" id="createForm">
                </div>                                 
            </div>              
         </form>
         <!--Document Create End-->
    </div> 
  </div>
    

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

  $('#document-table').DataTable( {
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
                'targets': 0,
                'checkboxes': {
                   'selectRow': true
                }
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

    var ldms_experiedDate = $('#ldms_experiedDate');
    ldms_experiedDate.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y', strtotime('+2 day')); ?>",
     autoclose: true,
     todayHighlight: true
     });

    var createForm = $('#createForm');
    createForm.on("click",function () {
        var ldms_documentTitle = $.trim($('#ldms_documentTitle').val());
        if (ldms_documentTitle == '') {
            alert("Document Title can't be empty.");
            $("#ldms_documentTitle").focus();
            return false;
        }
        var ldms_email = $.trim($('#ldms_email').val());
        if (ldms_email == '') {
            alert("Alarm Sending Email can't be empty.");
            $('#ldms_email').focus();
            return false;
        }
        var ldms_documentFile = $.trim($('#ldms_documentFile').val());
        if (ldms_documentFile == '') {
            alert("Document File can't be empty.");
            $('#ldms_documentFile').focus();
            return false;
        }
    });

    var  ldms_document_file = $("#ldms_documentFile");
    ldms_document_file.change(function(){
        var  ldms_document_file_name = $("#ldms_document_file_name");
        ldms_document_file_name.html($(":file").val());
     });

@if(count($document_list)!=0)
    var ldms_tags_email = [ @foreach($ldms_documents_all as $document)
        <?php
            $emailArray[] = $document->email;
        ?>
         @endforeach
            <?php
            echo  '"'.implode('","', $emailArray).'"';
            ?> ];
    var ldms_email = $('#ldms_email');
    ldms_email.autocomplete({
      source: function( request, response ) {
              var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
              response( $.grep( ldms_tags_email, function( item ){
                  return matcher.test( item );
              }) );
          }
    });

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
</body>
</html>
