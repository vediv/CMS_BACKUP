<?php 
include_once 'corefunction.php';

if(isset($_REQUEST['save_priority_headercontent']))
{
     $pidd=$_REQUEST['idd']; $prio=$_REQUEST['pr'];
     $i=0;
     foreach($pidd as $ptid)
           {
               $ptid; $pri=$prio[$i];		
               $s="update header_menu set priority='$pri' where hid='$ptid'";
               $r=db_query($conn,$s);
               $i++;
           } 
      $error_level=1;$msg="Header Content priority Set"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
      $qry='';
      write_log($error_level,$msg,$lusername,$qry);
      header("Location:header_content.php?val=update"); 
}     
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
  <title><?php echo PROJECT_TITLE." | Header Content";?></title>
  <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
  <link href="dist/css/navAccordion.css" rel="stylesheet">
  </head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
      <?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
  <h1>Header Content
       <?php  if(in_array("1", $UserRight)){ ?>    
       <a href="javascript:" data-target=".bs-example-modal-lg"  title="add new home tag" onclick="add_new_headerContent();"><small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
      <?php  } ?>
  </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Header Content  </li>
          </ol>
        </section>
 <section class="content">
          <div class="row">
                     <div style="text-align:center; color: red;"><?php echo $msgg; ?></div>

                <div class="col-xs-12">
                    <div class="box"> 
                     <div class="box-header">
                      </div> 
                     <div id="flash1"></div>    
                     <div id="results" style="min-height: 500px;"></div> 
                    </div>
                </div>
          </div>
 </section><!-- /.content -->
        
</div><!-- /.content-wrapper -->
<?php include_once "footer.php"; include_once 'commonJS.php'; ?>
    </div><!-- ./wrapper -->
<div class="modal fade" id="myModal_add_new_headerContent" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="view_modal_new_headerContent"></div>
    </div>
  </div>
<div id="LegalModal_modal_edit_headerContent" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"  aria-hidden="true" class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
      <div class="modal-content" id="edit_modal_headerContent"></div>
    </div>
  </div>     
<div class="modal fade"  id="myModal_view_setpriority_headercontent" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static"  >
 <div class="modal-dialog modal-lg">
     <div class="modal-content" id="view_setpriority_headercontent" style="width:500px; margin-left: 221px;"></div>
 </div>
</div>  
<div class="modal fade"  id="myModalViewType" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static"  >
 <div class="modal-dialog modal-lg">
     <div class="modal-content" id="view_view_type" style="width:650px;" ></div>
 </div>
</div>
    
<script type="text/javascript">
$(document).ready(function() {
var pageNum = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
//$("#results").html('');
$("#flash1").show();
$("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
$('#results').load("header_content_paging.php",{'pageNum':pageNum},
function() {
                   $("#flash1").hide();
                   pageNum++;

              }); //load first group
   });

function SaveHeaderContent()
{
    $(".has-error").html('');
    var catid = $('#catid').val();
    var m_name = $('#m_name').val();
    var menu_icon = $('#menu_icon').val();
    var menu_type = $('#menu_type').val();
    var viewTypeVal = $("input:radio[name=viewType]:checked").val()
    var pattern=/^[0-9A-Za-z-_#|\s]+$/;
    //var pattern_with_no_space=/^[0-9A-Za-z-_#@|]+$/;
    if(catid==0)
    {    
     if(m_name=='')   
     { var mess="Menu Name should not be Blank"; $("#m_name-error").html(mess); return false;} 
     else if(!m_name.match(pattern))
     { 
       var mess="(Please enter alphanumeric value with #_-)  Eg:test123,test-123,#test_23, test 123"; 
       $("#m_name-error").html(mess);return false;
     }
    }
    if(menu_type=='')
    {
        var mess="(Please select Menu Type )"; 
        $("#menu_type-error").html(mess);return false
    }
    var host_url = $('#host_url').val();
    var img_urls = $('#img_urls').val();
    $('#header_content').attr('disabled',true);
    $("#saving_loader").show();
    $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
    var apiBody = new FormData();
    apiBody.append("catid",catid);
    apiBody.append("m_name",m_name);
    apiBody.append("host_url",host_url); 
    apiBody.append("img_urls",img_urls);
    apiBody.append("menu_type",menu_type);
    apiBody.append("view_type",viewTypeVal);
    apiBody.append("action","save_headercontent");
    $.ajax({
                url:'headerContentModal.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(r){
                if(r==2)
                {   
                 $("#saving_loader").hide();
                 $('#myModal_add_new_headerContent').modal('hide');
                 window.location="header_content.php";
                }
                if(r==1)
                {
                    $('#myModal_add_new_headerContent').modal('show');
                    var mess= '<div class="alert alert-danger"><strong>Notice!</strong>This Header Menu already exits with menu type.</div>';       
                    $("#error_dublicate").html(mess);
                    $("#saving_loader").hide(); 
                    $('#header_content').attr('disabled',false);
                    return false;  
                }
            }
    });	 
}
function SaveEditHeaderContent(hcid,pageindex,limitval)
{
    $(".has-error").html('');
    var m_name = $('#m_name').val();
    var menu_type = $('#menu_type').val();
    var host_url = $('#host_url').val();
    var img_urls = $('#img_urls').val();
    var viewTypeVal = $("input:radio[name=viewType]:checked").val()
    var pattern=/^[0-9A-Za-z-_#|\s]+$/;
    //var pattern_with_no_space=/^[0-9A-Za-z-_#@|]+$/;
    if(m_name=='')   
    { var mess="Menu Name should not be Blank"; $("#m_name-error").html(mess); return false;}  
    else if(!m_name.match(pattern))
    {  var mess="(Please enter alphanumeric value with #_-)  Eg:test123,test-123,#test_23";$("#m_name-error").html(mess);return false;} 
    
    $('#header_content').attr('disabled',true);
    $("#saving_loader").show();
    $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
    var apiBody = new FormData();
    apiBody.append("hcid",hcid); 
    apiBody.append("m_name",m_name);
    apiBody.append("menu_type",menu_type);
    apiBody.append("view_type",viewTypeVal);
   apiBody.append("host_url",host_url); 
    apiBody.append("img_urls",img_urls);
     apiBody.append("pageindex",pageindex);
    apiBody.append("limitval",limitval);
    apiBody.append("action","save_editheadercontent");
    $.ajax({
                url:'header_content_paging.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(re){
                $("#flash").hide();
                $('#LegalModal_modal_edit_headerContent').modal('hide');
                $("#results").html(re);
                $("#msg").html("Header edit successfull..");
            }
    });
    
}
function setPriority()
    {
       //$("#flash").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
       $('#myModal_view_setpriority_headercontent').modal();
       var info = 'action=setpriority_headerContent'; 
        $.ajax({
	   type: "POST",
	   url: "priority.php",
	   data: info,
         success: function(result){
         //$("#flash").hide();
         $('#view_setpriority_headercontent').html(result);
         return false; 
         
          }
        });
     return false; 
    
 }


function homedelete(hid){
 var st=document.getElementById('act_deact_status'+hid).value;
if(st==1) { alert('This Header is active so you can not delete'); return false;} 
var d=confirm("Are you sure you want to Delete This header Menu. ?");
if(d)
{
       var info = 'hid='+hid+'&action=menu_header_delete';
       $.ajax({
       type: "POST",
       url: "coredelete.php",
       data: info,
       success: function(r){
         if(r==1)
         {
             $("#headerdel" + hid).remove();
         }   

         }
    });  
}    

}
</script> 

 <!--active-deactive-->
<script type="text/javascript">
function act_dect_home(headerid){ 
var headerstatus=document.getElementById('act_deact_status'+headerid).value;
var msg = (headerstatus == 1) ? "inactive":"active";
var c=confirm("Are you sure you want to "+msg+ " This?")
if(c)
{
 $.ajax({
   type: "POST",
   url: "core_active_deactive.php",
   data:'headerid='+headerid+'&headerstatus='+headerstatus+'&action=menuheader',
   success: function(reslide){
   	  if(reslide==0)
   	   { 
   	     var img_status=document.getElementById('getstatus'+headerid).innerHTML="<span class='label label-danger'>inactive</span>";
   	     $('#icon_status'+headerid).removeClass('fa-check-square-o').addClass('fa-ban');
   	   }
   	   if(reslide==1)
   	   {
   	   	var img_status=document.getElementById('getstatus'+headerid).innerHTML="<span class='label label-success'>active</span>";
   	   	$('#icon_status'+headerid).removeClass('fa-ban').addClass('fa-check-square-o');
   	   }
           $('#act_deact_status'+headerid).val(reslide);
       
       
     }
 
   });
 }  
 
}
 

</script>    
</body>
</html>
