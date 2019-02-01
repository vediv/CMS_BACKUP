<?php
include_once 'corefunction.php';
$Entryids=$_POST['Entryids']; $getpageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];
$entryIDS=rtrim($Entryids,','); 
$entryId = $entryIDS;
$version = null;   
?>	

<script type="text/javascript">
function planinfoView(ptag,act,entryid)
{
    var dataString ='planuniquename='+ptag+'&act='+act+'&entryid='+entryid;
    $.ajax({
           type: "POST",
           url: "planCore.php",
           data: dataString,
           cache: false,
           success: function(result){
           	 $("#resultPlan").html(result);
           }
    });   
}
</script>
<?php
$ptag=$_REQUEST['ptag']; 
$checked="";
if($ptag!=''){ ?>    
<script type="text/javascript">
planinfoView('<?php echo $ptag; ?>','showedit','<?php echo $entryId; ?>');
</script>    
<?php } ?>
<form>

   <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Plan</h4>
        </div>
         <div class="modal-body" >
<p>Choose The following Plan :</p>
    <label class="radio-inline">
       <!-- <input type="radio" name="planoption" <?php echo $ptag=='f' ? "checked" :""; ?>  id="planoption" value="f" onclick="planinfo('f','show')" style="cursor: pointer;" >Free-->
        <input type="radio" name="planoption" <?php echo $ptag=='f' ? "checked" :""; ?>  id="planoption" value="f"  style="cursor: pointer;" >Free
     </label>
 <label class="radio-inline">
  <!--<input type="radio" name="planoption" id="planoption" <?php echo $ptag=='p' ? "checked" :""; ?> value="p" onclick="planinfo('p','show')" style="cursor: pointer;">Premium-->
    <input type="radio" name="planoption" id="planoption" <?php echo $ptag=='p' ? "checked" :""; ?> value="p"  style="cursor: pointer;">Premium

 </label>

<!--<div id="resultPlan" style="border: 0px solid red; margin-top:10px;"></div>-->

<!--<div class="pull-right"><button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">See Plan Click Here</button></div> -->
    <!--<div id="demo" class="collapse">
     <hr/>	
     <table id="example1" class="table table-bordered">
        <thead>
              <tr>
                <th>Plan-Name</th> <th>Plan Duration(days)</th> <th>Plan-Value</th>
              </tr>
       </thead>
        <tbody> 
<?php
include_once 'auth.php';
include_once 'function.inc.php';
$sql="SELECT planID,planName,pduration,pValue FROM plandetail where pstatus=1 ORDER BY planID DESC";
$rr= db_select($conn,$sql);
foreach($rr as $fetch )
 {
 $planID=$fetch['planID'];  $planName=$fetch['planName']; $pValue=$fetch['pValue']; $pduration=$fetch['pduration']; 
 ?>
<tr>

<td><?php echo ucwords($planName); ?></td>
<td><?php echo $pduration ;?> days</td>
<td><?php echo $pValue?> <i class="fa fa-rupee"></i></td>
 </tr>
<?php } ?>
    </tbody>                  
        </table>     
    </div> -->         

 </div>
    <div class="modal-footer">
    <button type="button" id="savebulkplan" class="btn btn-primary center-block" data-dismiss="modal1" onclick="save_bulkplan('savebulkplan','<?php echo $entryId; ?>','<?php echo $getpageindex;  ?>','<?php echo $limitval; ?>');" >Save & Close</button>
  </div>
    <div align="center" id="saving_loader"></div>
 </form>  
 <script type="text/javascript">
function planinfo(planuniquename,act)
{
   var dataString ='planuniquename='+planuniquename+'&act='+act;
   $.ajax({
           type: "POST",
           url: "planCore.php",
           data: dataString,
           cache: false,
           success: function(result){
           	 $("#resultPlan").html(result);
           }
    });   
    
}
function save_bulkplan(savebulkplan,entryid,pageindex,limitval){
$('#myModal_bulk').modal();
var planuniquename=$('input[name=planoption]:checked').val();
   if(!planuniquename)
   {
        alert("Please Choose atleast One Plan Type ?");
        $("#myModal_bulk").modal('show');
        return false
   }
   $("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
   $('#savebulkplan').attr('disabled',true);
   var dataString ='maction='+savebulkplan+'&entryid='+entryid+'&pageindex='+pageindex+'&planuniquename='+planuniquename+'&limitval='+limitval;
   $.ajax({
           type: "POST",
           url: "media_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
                /*$("#myModal_bulk").modal('hide');
                $("#saving_loader").hide();
                $("#results").html('');
	        $("#flash").hide();
	        $("#results").html(result);
                $("#msg").css("color", "green").html("Bulk Plan saved successfully");
                */
                $('#myModal_bulk').modal('hide');
                $('#load').show();
                $('#results').css("opacity",0.1);
                if(result==1){
                $( "#results" ).load( "media_paging.php", { pageindex:pageindex,limitval:limitval,maction:'only_page_limitval' }, function(r) {
                $( "#results" ).html(r);
                $("#msg").html("Bulk Plan saved successfully.");
                $('#load').hide();
                $('#results').css("opacity",1);
                });
                }
                
                
       }
    });
}
</script>
