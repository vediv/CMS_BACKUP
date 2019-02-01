<?php
include_once 'corefunction.php';
include_once("config.php");
$publisher_unique_id;      // use in auth.php
$act=$_POST['action'];
switch($act)
{
    case "view_category_entry":
    $categoryID=$_POST['categoryID'];
    ?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">This Category has total <?php //echo $total_pages;?> Entries</h4>
</div>
<div id="load_in_modal" style="display:none; text-align: center !important;"></div>
   <div class="modal-body" style="min-height: 500px !important;" >
     <div id="remove_msg"></div>
    <div class="box">
        
      <div class="box-body"  id="result_category_view_entry" style="border: 0px solid red;"></div>
    </div>
   </div>
<script type="text/javascript">
$(document).ready(function() {
var pageNum = 1; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
var categoryID  = "<?php echo $categoryID; ?>";
$('#load_in_modal').show();
$('#result_category_view_entry').css("opacity",0.1);
$('#result_category_view_entry').load("ajax_common.php",{'pageNum':pageNum,'action':'category_view_entry','categoryID':categoryID},
function() {
             $('#load_in_modal').hide();
             $('#result_category_view_entry').css("opacity",1);
             pageNum++;
            }); //load first group
   });
function changePagination_view_category_entry(pageid,limitval,categoryid){
     //$("#remove_msg").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
     $('#load_in_modal').show();
     $('#result_category_view_entry').css("opacity",0.1);
     var dataString ='pageNum='+pageid+'&limitval='+limitval+'&categoryID='+categoryid+'&action=category_view_entry';
     //$("#paging_result").html();
     $.ajax({
           type: "POST",
           url: "ajax_common.php",
           data: dataString,
           cache: false,
           success: function(result){
             //  alert(result);
           	 $('#load_in_modal').hide();
                 $('#result_category_view_entry').css("opacity",1);
           	 $("#result_category_view_entry").html(result);
           }
      });
}  

function delete_category_entry(categoryid,entryid,publisher_id,pageNum,limitval)
{
     //$("#msg").html();  
     //$("#remove_msg").html();  
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
                        //document.getElementById('remove_msg').innerHTML="Entry successfully deleted from category";
                       $('#load_in_modal').show();
                       $('#result_category_view_entry').css("opacity",0.1); 
                       $( "#result_category_view_entry" ).load("ajax_common.php",{ pageNum:pageNum,limitval:limitval,action:'category_view_entry',categoryID:categoryid }, 
                       function(r) {
                        //alert(r);
                        $("#result_category_view_entry").html(r);
                        $("#remove_msg").html("Entry successfully deleted from category.");
                        $('#load_in_modal').hide();
                        $('#result_category_view_entry').css("opacity",1);
                        });   
                    }    
               
                 }
            });
        } 
    
}
</script>
<?php
   break;
    case "view_bulk_entries":
    $kjobid=$_POST['kjobid'];
    ?>    
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">View Entries <?php //echo $total_pages;?></h4>
    </div>
    <div id="load_in_modal" style="display:none; text-align: center !important;"></div>
    <div class="modal-body" style="min-height: 500px !important;" >
    <div id="remove_msg"></div>
    <div class="box">
       <div class="box-body"  id="bulk_view_entry" style="border: 0px solid red;">
            
            
        </div>
    </div>
</div>  
<script type="text/javascript">
$(document).ready(function() {
var pageNum = 1; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
var kjobid = "<?php echo $kjobid; ?>";
$('#load_in_modal').show();
$('#bulk_view_entry').css("opacity",0.1);
$('#bulk_view_entry').load("coreData.php",{'pageNum':pageNum,'action':'bulk_view_entries_data','kjobid':kjobid},
function() {
             $('#load_in_modal').hide();
             $('#bulk_view_entry').css("opacity",1);
             pageNum++;
            }); //load first group
   }); 
   
 
    function changePagination_view_category_entry(pageid,limitval,kjobid){
     //$("#remove_msg").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
     $('#load_in_modal').show();
     $('#bulk_view_entry').css("opacity",0.1);
     var dataString ='pageNum='+pageid+'&limitval='+limitval+'&kjobid='+kjobid+'&action=bulk_view_entries_data';
     //$("#paging_result").html();
     $.ajax({
           type: "POST",
           url: "coreData.php",
           data: dataString,
           cache: false,
           success: function(result){
             //  alert(result);
           	 $('#load_in_modal').hide();
                 $('#bulk_view_entry').css("opacity",1);
           	 $("#bulk_view_entry").html(result);
           }
      });
    } 
    </script>   
   

<?php 
 break;    
}

?>

     
