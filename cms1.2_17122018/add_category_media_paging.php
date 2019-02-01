<?php
include_once 'corefunction.php';
$Entryids=$_POST['Entryids']; $getpageindex=$_POST['pageindex'];$limitval=$_POST['limitval'];
$entryId = $entryIDS;
$entryIDS=rtrim($Entryids,','); 
$version = null; 
$catAction=$_POST['cat_add_remove'];
switch ($catAction) {
case "cat_add":
  ?>
<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add To Category</h4>
</div>
<form class="form-inline" method="post"> 
<div class="modal-body" >

<input type="hidden" name="entryids" id="entryids" value="<?php echo $entryIDS; ?>">

<div class="col-md-12" >
       <div class="box box-default">
          <div class="box-header">
            
          </div>
       <!--<div align="center" class="box-body">
        <div class="form-group">
        <label for="category_value" class="control-label col-xs-3">Categories:</label>
        <div class="col-xs-8">
         <input type="text" size="60" name="category_video"  placeholder="Category" id="input-category" class="form-control" />
         <div id="bulk-category" class="well well-sm" style="height:200px;  width: 518px; overflow: auto;">  </div>
        </div>
        </div>
        </div>-->
       <table  border='0'  style="border-collapse: separate; border-spacing: 0 1em;" width='100%' >
        <tr>
        <td valign="top">
          <level> Categories :</level> 
          </td>
          <td colspan="3">
          <input type="text" size="70" name="category_video" value="" placeholder="Category" id="input-category" class="form-control" />
          <div id="bulk-category" class="well well-sm" style="height:200px; width: 598px; overflow: auto;">  </div>
          </td>    
        </tr>
       </table>    
        
        </div>
                  <!--<div  class="form-group ">
                    <label>Categories:</label>
                    <div class="form-group " id="drawCategory">
                       <span id="wait_loader_category"></span>
                             
                    </div>
                  </div>-->
                </div>
              </div>
            </div>
          
     <div class="modal-footer" >
     <button type="button" class="btn btn-primary center-block" data-dismiss="modal1" name="save_bulk_category"  id="save_bulk_category" onclick="savebulkcategory('bulk_add_cat','<?php echo $getpageindex;  ?>','<?php echo $limitval; ?>');" >
     Save & Close </button> 
     </div>
     <div align="center" id="saving_loader"></div>
</form>  
 
<script src = "js/common.js"></script>
<script type="text/javascript">
// $('input[name=\'category_video\']').autocomplete({
        $("#input-category").autocomplete({
	'source': function(request, response) {
            	$.ajax({
			url: 'couponModal.php?action=get_category&filter_name='+request,
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['fullname'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'category_video\']').val('');
		
		$('#bulk-category' + item['value']).remove();
		
		$('#bulk-category').append('<div id="bulk-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="bulk-category[]" value="' + item['value'] + '" /></div>');
	}	
});
$('#bulk-category').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});    
</script>
  
 <?php 
  break;
case "cat_remove":
 ?>		
 <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Remove Category</h4>
</div>
         <div class="modal-body" >
<form class="form-horizontal" method="post">
 <input type="hidden" name="entryids" id="entryids" value="<?php echo $planentryID; ?>">
 <input type="hidden" name="pageindex" id="pageindex" value="<?php echo $getpageindex; ?>">
  <div class="form-group">
           <!-- <label for="inputPassword" class="control-label col-xs-2">Categories:</label>-->
            <div class="col-xs-10">
    
				 <div class="container1"> 	                 
    <div class="row"> 
        <div class="col-md-12">
            <div id="sidebar" class="well sidebar-nav" style="border: 0px solid red;"> 
	      <div class="mainNav">
	      <ul>
	     <?php
         $muldelEntryID=explode(",",$entryId);
		  foreach ($muldelEntryID as $upentryid) {
		    $entryId = $upentryid;
            $version = null;
            $result = $client->baseEntry->get($entryId, $version);	
	        $categoriesIds=$result->categoriesIds;
			$categoriesName=$result->categories;
			?>
			<?php 
	 		if(!empty($categoriesIds))	
		    {
		    	$muldelcategoryID=explode(",",$categoriesIds);
				 foreach ($muldelcategoryID as $cidd) {
		    ?>
	   
			<li> <input type="checkbox" class="checkBoxClass1" name="category_value"  id="example-getting-started"  value="<?php echo $upentryid."-".$cidd; ?>">	
				<a href="#"><?php echo strtoupper($categoriesName)."--".$upentryid."-".$cidd;?></a>
			
			</li>
			
			
<?php   }  }else { ?> <li> No categories to remove </li>		
<?php }  ?>
	 	  
<?php } ?>
</ul>		
	
		
	      	
	      	
	      	
	      	
	
         </div>
</div>
        </div>
        
    </div>
</div> 
            </div>
        </div>
       <div class="form-group">
           <div class="col-xs-offset-2 col-xs-10" >
               
            	<button type="button" class="btn btn-primary" data-dismiss="modal" name="submit"  id="myFormSubmit" onclick="removebulkcategory('bulk_remove_cat','<?php echo $getpageindex;  ?>');" >Remove & Close</button>
            </div>
        </div> 
         </form> 
      </div>
  <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>
    
   
<?php       
break;}
?>
<script type="text/javascript">
//drawCateory();    
/*function drawCateory()
{
    $("#wait_loader_category").fadeIn(400).html('Loading... <img src="img/image_process.gif" />');
    var dataString ='action=category_in_youtube';
    $.ajax({                                                                                                                                        
    type: "POST",
    url: "ajax_common.php",
    data: dataString,
    cache: false,
    success: function(r){
      $("#wait_loader_category").hide(); 
      $("#drawCategory").html(r);
      }
      
    });  
} */   

function savebulkcategory(act,pageindex,limitval) {
   var category=''; 
   var bulk_category = document.getElementsByName('bulk-category[]');
   if(bulk_category.length==0)
   {
        alert("You must select at least one entry");
         $('#myModal_add_to_category').modal({ show: 'false'}); 
         return false;
   }   
   for (var x = 0; x < bulk_category.length; x++) { 
           category += bulk_category[x].value+',';
        }
   var categoryids=category.slice(0, -1);
   var entryids=$('#entryids').val();   
   $('#myModal_add_to_category').modal('show');
   $("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
   $('#save_bulk_category').attr('disabled',true); 
   var info = 'Entryids='+entryids+"&pageindex="+pageindex+"&categories_id="+categoryids+'&limitval='+limitval+"&maction="+act; 
    $.ajax({
        type: "POST",
        url: "media_paging.php", 
        data: info,
         success: function(result){
                $('#myModal_add_to_category').modal('hide');
                $('#load').show();
                $('#results').css("opacity",0.1);
                if(result==1){
                $( "#results" ).load( "media_paging.php", { pageindex:pageindex,limitval:limitval,maction:'only_page_limitval' }, function(r) {
                $( "#results" ).html(r);
                $("#msg").html("Bulk Category Saved successfully.");
                $('#load').hide();
                $('#results').css("opacity",1);
                });
                }
               }
      });  
}



function removebulkcategory(act,pageindex) {
var finald = '';
   $('.checkBoxClass1:checked').each(function(){        
       var values = $(this).val();
       finald += values+',';
   });
if(finald=='')
{ 
  alert("You must select at least one entry to remove"); 
 
}
  else { 
var info = 'entryid_and_categoryID='+finald+"&pageindex="+pageindex+"&maction="+act;
$.ajax({
type: "POST",
url: "media_paging.php",
data: info,
success: function(result){
  $('#results').html(result);
      }
  }); 
} 

} 
</script>
