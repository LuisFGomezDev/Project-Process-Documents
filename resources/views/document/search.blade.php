<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Document List</title>
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap-datepicker.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/font-awesome.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/jquery-ui.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/main.css')?>" type="text/css"> 
</head>
<body>
@include('partials.topMenu')

@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('message1'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message1') }}</div> 
@endif
  <div class="col-md-9">     
    <!--Document List Start-->
    <div class="col-md-12 panel">
        <h1>Search Document(<?php echo $ldms_total_documents_number;?>)</h1>
    <?php
        $ldms_prev_url = 'from_search_page';
    ?>
        
        <div class="col-md-4">
      <form method="get" action="ldms_search" id="ldms_search" name="ldms_search">
          {!! csrf_field() !!}          
            <div class="search-box input-group">
              <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
    <input class="form-control" type="text" name="ldms_documentTitleSearch" id="ldms_documentTitleSearch" placeholder="Type document name and click...">
            </div>
          </form>
        </div>
        <div class="col-md-8">
            <div class="btn-toolbar pull-right">
              <div class="btn-group">
                <button class="btn btn-default btn-print dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print" aria-hidden="true"></i> Print
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                  <li><a onclick="print_current()">Print Current</a></li>
                  <li><a onclick="print_all()">Print All</a></li>
                </ul>
              </div>
            </div>
        </div>
    
        <div class="col-md-12"> 
            <table class="table table-bordered table-striped">
                <th>SL No.</th>
                <th>Document Title</th>
                <th>Expired Date</th>
                <th>Notification Email</th>            
                <th class="text-center hidden-print">Option</th>
                @foreach($document_list as $document)
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
                            <td>1</td>
                            <td>{!! $document->title !!}</td>
                            <td>{!! $document->expired_date !!}</td>
                            <td>{!! $document->email !!}</td>
                    
                                <td class="text-center hidden-print">
                                <?php
                                if ($expiredDate<$todayDate) {
                                    $ldms_line_through = "line-through";
                                } else {
                                    $ldms_line_through = "none";
                                }?>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default">Action</button>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                            <li><a title = "View" href="ldms_edit/{!! $document->id !!}"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                            <li class="divider"></li>
                                            <li><a title = "Download" href="../public/document/<?php echo $document->file_name;?>" download><i class="fa fa-download" aria-hidden="true"></i> Download</a></li>
                                            <li class="divider"></li>
                                            <li><a title = "Delete" href="ldms_delete/{!! $document->id !!}/{!! $document->file_name !!}/{!! $ldms_prev_url !!}" onclick='return confirmDelete()'><i class="fa fa-trash" aria-hidden="true"></i> Delete</a></li>
                                            <li class="divider"></li>
                                            <li><a class="<?php if ($expiredDate<$todayDate) {
                                                echo "disabled";
}?>" href="ldms_alarm_date/{!! $document->id !!}" title="Alarm Date"><i class="fa fa-bell" aria-hidden="true"></i> <span style="text-decoration:<?php echo $ldms_line_through;?>">Alarm</span></a>
                                            </li>
                                      </ul>
                                </div>
                                </td>
                        </tr>
                @endforeach
            </table>
            <div class="btn-toolbar pull-right">
              <div class="btn-group">
                <button class="btn btn-default btn-print dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print" aria-hidden="true"></i> Print
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                  <li><a onclick="print_current()">Print Current</a></li>
                  <li><a onclick="print_all()">Print All</a></li>
                </ul>
              </div>
            </div>
        </div>
    </div>
    <!--Document List End-->
  </div>

  <div class="col-md-3">
    <div class="col-md-12 panel">
        <h3>Upload New Document</h3>
        <!--Document Create Start-->
        <form method="post" action="ldms_store" files="true" enctype="multipart/form-data">
            <div class="col-md-12">
                {!! csrf_field() !!}
                <div class="form-group">
                     <label for="ldms_documentTitle">Document Title</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                             <input class="form-control" type="text" name="ldms_documentTitle" id="ldms_documentTitle" placeholder="Trade License">
                         </div>
                     </div>
                </div>                   
                <div class="form-group">
                    <label for="ldms_experiedDate">Expired Date</label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <input id="ldms_experiedDate" name="ldms_experiedDate" class="form-control" type="text" name="date" value="<?php echo date('d-m-Y', strtotime('+2 day')); ?>">
                         </div>
                    </div>
                </div>
                <div class="form-group">
                     <label for="ldms_email">Notification Email</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input class="form-control" type="email" name="ldms_email" id="ldms_email" placeholder=
                            "abc@gmail.com">
                         </div>
                     </div>
                </div>
                <div class="form-group">
                     <label for="ldms_documentFile">Document File</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                             <input  type="file" name="ldms_documentFile" id="ldms_documentFile">
                             <label class="btn btn-default" for="ldms_documentFile"><i class="fa fa-upload"></i> Upload File</label>
                             <span id="ldms_document_file_name"></span>
                         </div>
                     </div>
                </div>                                   
            </div>
            <div class="form-group submit text-right">
                <label for="submit"></label>
                <div class="form-group-inner">
                     <div class="field-outer">
                       <input type="submit" name="submit" value="Submit" class="btn btn-primary" id="createForm">
                     </div>
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
 <script type="text/javascript">
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

  var ldms_tags_title = [ @foreach($ldms_documents_all as $document)
        <?php
            $documentTitleArray[] = $document->title;
        ?>
         @endforeach
            <?php
            echo  '"'.implode('","', $documentTitleArray).'"';
            ?> ];

    var ldms_documentTitleSearch = $('#ldms_documentTitleSearch');
    ldms_documentTitleSearch.autocomplete({
      source: function( request, response ) {
              var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
              response( $.grep( ldms_tags_title, function( item ){
                  return matcher.test( item );
              }) );
          },
      select: function(event,ui){
        ldms_documentTitleSearch.val(ui.item.value);
        var ldms_search = $("#ldms_search");
        $("#ldms_search").submit();
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

  function print_current(){
    var myWindow=window.open('','','width=800,height=500');
    <?php
          $ldms_print_serial = 1;
          $html="<html><head><title></title><link rel='stylesheet' href='";
          $html.= asset('public/css/bootstrap.min.css');
          $html.= "' type='text/css'></head><body><table class='table table-bordered table-striped'><tr><td>SL No.</td><td>Document Title</td><td>Expired Date</td><td>Notification Email</td></tr>";
    foreach ($document_list as $document) {
        $html.="<tr><td>".$ldms_print_serial."</td><td>".$document->title."</td><td>".$document->expired_date."</td><td>".$document->email ."</td></tr>";
        $ldms_print_serial++;
    }
          $html.="</table></body></html>";
    ?>

    var html_printCurrent = "<?php echo $html; ?>";
    myWindow.document.write(html_printCurrent);
    myWindow.document.close();
    myWindow.focus();
    myWindow.print(); 
  }

  function print_all(){
    var myWindow=window.open('','','width=800,height=500');
    <?php
          $ldms_print_serial = 1;
          $html="<html><head><title></title><link rel='stylesheet' href='";
          $html.= asset('public/css/bootstrap.min.css');
          $html.= "' type='text/css'></head><body><table class='table table-bordered table-striped'><tr><td>SL No.</td><td>Document Title</td><td>Expired Date</td><td>Notification Email</td></tr>";
    foreach ($ldms_documents_all as $document) {
        $html.="<tr><td>".$ldms_print_serial."</td><td>".$document->title."</td><td>".$document->expired_date."</td><td>".$document->email ."</td></tr>";
        $ldms_print_serial++;
    }
          $html.="</table></body></html>";

    ?>

    var html_printAll = "<?php echo $html; ?>";
    myWindow.document.write(html_printAll);
    myWindow.document.close();
    myWindow.focus();
    myWindow.print(); 
  }
</script>
</body>
</html>
