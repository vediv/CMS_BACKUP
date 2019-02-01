<?php  
include_once 'corefunction.php'; 
$check="";
if(isset($_POST['save_priority']))
{
     $pidd=$_REQUEST['idd']; $prio=$_REQUEST['pr'];
     $i=0;
     foreach($pidd as $ptid)
           {
              $ptid; $pri=$prio[$i];	
              $s="update categories set priority='$pri' where catid='$ptid'"; 
              $r=db_query($conn,$s);
              $i++;
     }  
}    

?>
<!DOCTYPE html>
<html>
  <head>
 <meta charset="UTF-8">
 <title><?php echo ucwords(PROJECT_TITLE)." | Category Content";?></title>
 <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
body {font-size: 13px !important;} .caret {    margin-left: 4px !important; }
.input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group { padding: 3px 7px !important; }
.dropdown-menu > li > a { padding: 3px 10px !important; color: #555 !important; }
.dropdown-menu {  border: 1px solid #666 !important;}
.mainNav ul {    border-bottom: 0px solid #888 !important;  }
.mainNav ul li { border-top: 0 solid #444 !important;  border-bottom: 1px solid #888 !important; }
.preview
{ width:200px;border:solid 1px #dedede; }
  #load {
    opacity:1;
    width: 80%;
    height: 70%;
    position: fixed;
    z-index: 9999;
    background: url("img/image_process.gif") no-repeat center;
    
}

</style>
</head>
<body class="skin-blue" onload="initResizeEvents();">
<div class="wrapper">
<?php include_once 'header.php';?>
<?php include_once 'lsidebar.php';?>
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Add Category <?php echo $check; ?>
          <?php  if(in_array("1", $UserRight)){ ?>     
              <a href="javascript:void()"  data-target=".bs-example-modal-lg" data-toggle="modal" title="Add New" onclick="add_new_category();">
           	<small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
          <?php } ?>
          </h1> 
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Add Category</li>
          </ol>          
         </section>
     <section class="content">
           <div class="row">
          <div class="col-xs-12">
          
          <div class="box"> 
           <div class="box-header"></div> 
           <div id="flash1"></div>
           <div id="results"></div>
          </div>
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

					  
<?php include_once "footer.php"; include_once 'commonJS.php'; ?>
</div>
<!-- this following code show the upload model -->   

<div class="modal fade" id="myModal_add_new_category" role="dialog" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog modal-lg">
   <div class="modal-content" id="add_new_category_model_view"> </div> 
</div>
</div>


<!-- Model for view and update content.... start DIV -->
<div class="modal fade" id="myModal_category_view" role="dialog" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog modal-lg">
   <div class="modal-content" id="show_category_model_view"> </div>
</div>
</div>
  
<div class="modal fade" id="myModal_view_entry" role="dialog" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
     <div class="modal-content" id="view_category_entry"></div>
</div>
</div>

<div class="modal fade" id="myModal_view_setpriority" role="dialog" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
     <div class="modal-content" id="view_setpriority"></div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
var pageNum = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
//$("#results").html('');
$("#flash1").show();
$("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
    $('#results').load("category_paging.php",
    {'pageNum':pageNum},
        function() {
                   $("#flash1").hide();
                   pageNum++;

              }); //load first group
   });
</script>

<script type='text/javascript'>
function refreshcontent(refresh){
     $("#flash").show();
     $("#flash").fadeIn(400).html('Loading <img src="img/image_process.gif" />');
      var dataString ='refresh='+ refresh;
     $("#results").html();
       $.ajax({
           type: "POST",
           url: "category_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
          	//alert(result);
           	 $("#results").html('');
          	 $("#flash").hide();
          	 $("#results").html(result);
          }
     });
}   
function setPriority()
    {
       
       $("#flash").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
       $('#myModal_view_setpriority').modal();
       var info = 'action=setpriority'; 
        $.ajax({
	   type: "POST",
	   url: "priority.php",
	   data: info,
         success: function(result){
         $("#flash").hide();
         $('#view_setpriority').html(result);
         //$("#LegalModal").modal('show');
         //return false;
          }
        });
     return false; 
    
 }
 
function add_new_category()    
{
     $("#myModal_add_new_category").modal();
     $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
     var info = 'action=add_new_category'; 
        $.ajax({
	    type: "POST",
	    url: "add_new_category.php",
	    data: info,
             success: function(result){
             $("#flash").hide();
             $('#add_new_category_model_view').html(result);
         return false;
        }
 
        });
     return false;    
}
/*this is for model JS with edit and view detail */
function categoryEdit(categoryID,EntryPageindex) 
{
   $("#myModal_category_view").modal();
   $("#flash").fadeIn(200).html('Loading <img src="img/image_process.gif" />');
   var info = 'Entryid=' + categoryID+"&pageindex="+EntryPageindex; 
   $.ajax({
            type: "POST",
            url: "categories_edit_model.php",
            data: info,
            success: function(result){
            $('#show_category_model_view').html(result);
            $("#flash").hide();
        }

     });
     return false;
 }

function view_category_entry(categoryID)
{
   $("#myModal_view_entry").modal();
   $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
   var info = 'categoryID='+categoryID+"&action=view_category_entry"; 
       $.ajax({
	    type: "POST",
	    url: "categories_view_entry.php",
	    data: info,
            success: function(result){
             $("#flash").hide();    
             $('#view_category_entry').html(result);
              }   
            });
     return false;   
}


function changePagination(pageid,limitval,searchtext,fromdate,todate){    
      $("#flash").show();
      $("#flash").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
      var dataString ='pageNum='+pageid+'&limitval='+limitval+'&searchInputall='+searchtext+'&fromdate='+fromdate+'&todate='+todate;
      $.ajax({
           type: "POST",
           url: "category_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
           	 $("#results").html('');
                 $("#flash").hide();
           	 $("#results").html(result);
           }
     }); 
}


function deleteContent(entryID,delname,pageindex,parent_id,subcategorycount){

    if(subcategorycount==0)
    {
       var msg="Are you sure you want to delete the selected Category  ?";
        var dataString ='entryID='+ entryID +"&categoryaction="+delname+"&pageindex="+pageindex+"&parent_id="+parent_id;
    }
    if(subcategorycount>0)
    {
     var  msg="The category will be deleted with its sub-categories. \nDo you want to continue?";
     var dataString ='entryID='+ entryID +"&categoryaction=delete_with_sub_category&pageindex="+pageindex+"&parent_id="+parent_id;
    }
    var a=confirm(msg);
	     if(a==true)
	     {  
             $("#flash").show();
             $("#flash").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
	        $.ajax({
	           type: "POST",
	           url: "category_paging.php",
	           data: dataString,
	           cache: false,
	           success: function(result){
	           //alert(result);
	           $("#results").html('');
	           $("#flash").css("color", "red").html('Category Deleted Successfully..');
                   $("#results").html(result); 
	          // window.location="category_content.php";	         
             }
	         });
	     }
	     else
	     {
	     	 $("#flash").hide();
	     	 return false;
	     }
}
function delete_category_entry(categoryid,entryid,trcount,publisher_id)
{
      var apiURl="<?php  echo $apiURL."/category_delete" ?>";   
      var apiBody = new FormData();
      apiBody.append("partnerid",publisher_id); 
      apiBody.append("entryid",entryid);
      apiBody.append("catid",categoryid);
      var d=confirm("Are you sure you want to Delete This entry from Category ?");
      if(d)
      {
       $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                    //console.log(jsonResult);  
                    var Status=jsonResult.Status;
                    if(Status=="1")
                    {
                         document.getElementById('remove_msg').innerHTML="Entry successfully deleted from category";
                         $("#rmv" + trcount).remove();
                    }    
               
                 }
            });
        } 
    
}
function changePagination_view_category_entry(pageid,limitval,categoryid){
     $("#remove_msg").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
     var dataString ='first_load='+ pageid+'&limitval='+limitval+'&categoryID='+categoryid+'&action=view_category_entry';
     //$("#paging_result").html();
     $.ajax({
           type: "POST",
           url: "categories_view_entry.php",
           data: dataString,
           cache: false,
           success: function(result){
             //  alert(result);
           	 $("#view_category_entry").html('');
                 $("#remove_msg").hide();
           	 $("#view_category_entry").html(result);
           }
      });
}
function refreshcontent(refresh,pageid,searchKeword){
     $("#flash").show();
     $("#flash").fadeIn(400).html('Loading <img src="img/image_process.gif" />');
     var dataString ='categoryaction='+refresh+'&pageNum='+pageid+'&searchInputall='+searchKeword;
     $.ajax({
           type: "POST",
           url: "category_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
           	 $("#results").html('');
          	 $("#flash").hide();
          	 $("#results").html(result);
          }
     });
}



var _=function(id){return document.getElementById(id)};  
function initResizeEvents()
{
    if(window.attachEvent)
    {
         window.attachEvent('onresize', function(){ console.log("onresize"); setPlContainerHeight();});
    }
    
    else if(window.addEventListener)
    {
        window.addEventListener('resize', function(){console.log("resize"); setPlContainerHeight();}, true);
    }
    
    else
    {
        console.log("The browser does not support Javascript event binding");
    }
}
setPlContainerHeight();
//window.addEventListener('load', function(){ console.log("load"); setPlContainerHeight();}, true);
function setPlContainerHeight()
{
   var wHeight=height();
   var HeaderHeight=120;
   var footerHeight=80;
   var AddHF=HeaderHeight+footerHeight;
   var newHeight=wHeight-AddHF;
   var tbodyHeight=newHeight-150;
   console.log("newHeight=="+newHeight)
   setHeight('results',newHeight);
   
}
function setHeight(el,height)
{
    return _(el).style.height=height+"px";
}
function height(el)
{
        if(el)
        return el.offsetHeight||el.clientHeight||0;
        else
        return window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight||0;
}

</script>
</body>
</html>
