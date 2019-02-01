<?php
include_once 'corefunction.php';
$action=$_POST['action'];
switch($action) {
case "bulkAddContentPartner":
$Entryids=$_POST['Entryids']; $getpageindex=$_POST['pageindex'];
$limitval=$_POST['limitval'];
$entryId = $entryIDS;
$entryIDS=rtrim($Entryids,','); 
$version = null; 
?>
<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal1"  onclick="CloseModel();">&times;</button>
        <h4 class="modal-title">Add To Content Partner</h4>
</div>
<div style="border: 1px solid #c7d1dd ; border-top: 0px; padding:5px 5px 20px 4px; text-align:center">
    <form method="post" id="formBulkContentPartner" name="formBulkContentPartner" class="form-inline">  
              <div class="box-header">
                  <h3 class="box-title"></h3>
              </div><!-- /.box-header -->
                <div class="form-group ">
                  <label for="email">Content Partner :</label>
                 <?php 
                        $sel="Select contentpartnerid,name,par_id from content_partner where status='1' order by name";
                        $fet=db_select($conn,$sel);
                        ?>
                     <select name="addcontentpartner" id="addcontentpartner" style="width: 370px;" class="form-control" >
                     <option value="">--Select Content Partner--</option>
                    <?php foreach ($fet as $val) 
                    {  $par_id=$val['par_id'];  
                       $cname=$val['name']; 
                       
                    ?>
                    <option value="<?php echo $par_id;  ?>"><?php echo $cname;  ?></option>
                    <?php } ?>
                   </select>
                  <input type="hidden" name="entryids" id="entryids" value="<?php echo $entryIDS; ?>">
                </div>
                    
               <button type="button" name="save_bulkcontentPartner" id="save_bulkcontentPartner" class="btn btn-primary" onclick="saveBulkContentPartner('saveBulkContentPartner','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>');" >Save</button>
               <span id="saving_loader"></span>
     </form>
</div>     
<script type="text/javascript">
function CloseModel(){
document.getElementById("show_bulkContentPartner").innerHTML="";
$('#myModal_bulkContentPartner').modal('hide');
}    
    
function saveBulkContentPartner(act,pageindex,limitval){
   $('#myModal_bulkContentPartner').modal();
   var addcontentpartner=$("#addcontentpartner").val();
   var entryids=$("#entryids").val();
   //console.log(act+"--"+addcontentpartner+"--"+entryids);
   $("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
   $('#save_bulkcontentPartner').attr('disabled',true);
   var dataString ='maction='+act+'&entryids='+entryids+'&pageindex='+pageindex+'&addcontentpartner='+addcontentpartner+'&limitval='+limitval;
   $.ajax({
           type: "POST",
           url: "media_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
                $('#myModal_bulkContentPartner').modal('hide');
                $('#load').show();
                $('#results').css("opacity",0.1);
                if(result==1){
                $( "#results" ).load( "media_paging.php", { pageindex:pageindex,limitval:limitval,maction:'only_page_limitval' }, function(r) {
                $( "#results" ).html(r);
                $("#msg").html("saved content partner successfully.");
                $('#load').hide();
                $('#results').css("opacity",1);
                });
                }
                
                
       }
    });
}
</script>

<?php break;
case "contentViewerRating": 
$Entryids=$_POST['Entryids']; $getpageindex=$_POST['pageindex'];
$limitval=$_POST['limitval'];
$entryId = $entryIDS;
$entryIDS=rtrim($Entryids,','); 
?>
<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal1"  onclick="CloseVideo();">&times;</button>
        <h4 class="modal-title">Add To Content Viewer(Rating)</h4>
</div>
<div style="border: 1px solid #c7d1dd ; border-top: 0px; padding:5px 5px 20px 4px; text-align:center">
    <form method="post" id="formBulkContentViewer" name="formBulkContentViewer" class="form-inline">  
              <div class="box-header">
                  <h3 class="box-title"></h3>
              </div><!-- /.box-header -->
                <div class="form-group ">
                  <label for="addcontentpartner">Content Viewer :</label>
                     <select name="addcontentviewer" id="addcontentviewer" style="width: 370px;" class="form-control" >
                     <option value="">--Select Rating--</option>
                     <option value="G">G</option>
                     <option value="PG">PG</option>
                     <option value="PG13">PG13</option>
                     <option value="NC16">NC16</option>
                     <option value="M18">M18</option>
                     <option value="R21">R21</option>
                     </select>
                  <input type="hidden" name="entryids" id="entryids" value="<?php echo $entryIDS; ?>">
                </div>
                    
               <button type="button" name="save_bulkcontentViewer" id="save_bulkcontentViewer" class="btn btn-primary" onclick="saveBulkContentViewer('saveBulkContentViewer','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>');" >Save</button>
               <span id="saving_loader"></span>
               </form>
    
</div>  
<div class="row">
    <div class="col-lg-10 col-lg-offset-1"  >
        <div class="box-body">
                <table class="table table-bordered" width="70%">
                    <tr>
                        <td colspan="2" style="color: #fff;background-color: #337ab7; text-align: center;">LEGENDS</td>
                    </tr>
                    <tr>
                        <th style="color: #fff;background-color: #337ab7; text-align: center;">Symbol</th>
                        <th style="color: #fff;background-color: #337ab7; text-align: center;">Description</th>
                    </tr>
                    <tr>
                      <td>G</td>
                      <td>General (suitable for all ages)</td>
                    </tr>
                     <tr>
                      <td>PG</td>
                      <td>Parental Guidance<br>
                      suitable for all ages,but parents should guide their young.
                      </td>
                    </tr>
                     <tr>
                      <td>PG13</td>
                      <td>Parental Guidance 13<br/>
                      suitable for persons aged 13 and above but parental guidance as advised for children below 13.
                      </td>
                    </tr>
                     <tr>
                      <td>NC16</td>
                      <td>No Children Under 16 (
                      suitable for  persons aged 16 and above).
                      </td>
                    </tr>
                     <tr>
                      <td>M18</td>
                      <td>Mature 18 (suitable for  persons aged 18 and above) </td>
                    </tr>
                     <tr>
                      <td>R21</td>
                      <td>Restricted 21 (Restricted to persons aged 21 and above)</td>
                    </tr>
                    
                     
                   
                  </table>
                </div><!-- /.box-body -->
    </div>
    
</div>
<script type="text/javascript">
function CloseVideo(){
document.getElementById("show_bulkContentViewer").innerHTML="";
$('#myModal_bulkContentViewer').modal('hide');
}    
    
function saveBulkContentViewer(act,pageindex,limitval){
   $('#myModal_bulkContentViewer').modal();
   var addcontentviewer=$("#addcontentviewer").val();
   if(addcontentviewer=='')
       {
            alert("please select content viewer rating .");
            return false;
       }
   var entryids=$("#entryids").val();
   console.log(act+"--"+addcontentviewer+"--"+entryids);
   $("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
   $('#save_bulkcontentViewer').attr('disabled',true);
   var dataString ='maction='+act+'&entryids='+entryids+'&pageindex='+pageindex+'&addcontentviewer='+addcontentviewer+'&limitval='+limitval;
   $.ajax({
           type: "POST",
           url: "media_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
                $('#myModal_bulkContentViewer').modal('hide');
                $('#load').show();
                $('#results').css("opacity",0.1);
                if(result==1){
                $( "#results" ).load( "media_paging.php", { pageindex:pageindex,limitval:limitval,maction:'only_page_limitval' }, function(r) {
                $( "#results" ).html(r);
                $("#msg").html("saved content viewer successfully.");
                $('#load').hide();
                $('#results').css("opacity",1);
                });
                }
                
                
       }
    });
}
</script>
    
<?php 
break;  
case "AgeRestriction":
$Entryids=$_POST['Entryids']; $getpageindex=$_POST['pageindex'];
$limitval=$_POST['limitval'];
$entryId = $entryIDS;
$entryIDS=rtrim($Entryids,','); 
?>
<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal1"  onclick="CloseVideo();">&times;</button>
        <h4 class="modal-title">Add To Age Restriction</h4>
</div>
<div style="border: 1px solid #c7d1dd ; border-top: 0px; padding:5px 5px 20px 4px; text-align:center">
    <form method="post" id="formAgeRestriction" name="formAgeRestriction" class="form-inline">  
              <div class="box-header">
                  <h3 class="box-title"></h3>
              </div><!-- /.box-header -->
                <div class="form-group ">
                  <label for="agelimit">Content Viewer :</label>
                     <select name="agelimit" id="agelimit" style="width: 370px;" class="form-control" >
                     <option value="">--Select Rating--</option>
                     <option value="UA">U/A</option>
                     <option value="A">A</option>
                     <!--<option value="PG13">PG13</option>
                     <option value="NC16">NC16</option>
                     <option value="M18">M18</option>
                     <option value="R21">R21</option>-->
                     </select>
                  <input type="hidden" name="entryids" id="entryids" value="<?php echo $entryIDS; ?>">
                </div>
                    
               <button type="button" name="save_AgeRestriction" id="save_AgeRestriction" class="btn btn-primary" onclick="saveAgeRestrictionBulk('saveAgeRestrictionBulk','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>');" >Save</button>
               <span id="saving_loader"></span>
               </form>
    
</div>  
<div class="row">
    <div class="col-lg-10 col-lg-offset-1"  >
        <div class="box-body">
                <table class="table table-bordered" width="70%">
                    <tr>
                        <td colspan="2" style="color: #fff;background-color: #337ab7; text-align: center;">LEGENDS</td>
                    </tr>
                    <tr>
                        <th style="color: #fff;background-color: #337ab7; text-align: center;">Symbol</th>
                        <th style="color: #fff;background-color: #337ab7; text-align: center;">Description</th>
                    </tr>
                   <tr>
                      <td>U/A</td>
                      <td>Parental Guidance for children below the age of 12 years</td>
                    </tr>
                     <tr>
                      <td>A</td>
                      <td>Restricted to adults<br>
                      </td>
                    </tr>
                     <!--<tr>
                      <td>PG13</td>
                      <td>Parental Guidance 13<br/>
                      suitable for persons aged 13 and above but parental guidance as advised for children below 13.
                      </td>
                    </tr>
                     <tr>
                      <td>NC16</td>
                      <td>No Children Under 16 (
                      suitable for  persons aged 16 and above).
                      </td>
                    </tr>
                     <tr>
                      <td>M18</td>
                      <td>Mature 18 (suitable for  persons aged 18 and above) </td>
                    </tr>
                     <tr>
                      <td>R21</td>
                      <td>Restricted 21 (Restricted to persons aged 21 and above)</td>
                    </tr>-->
                    
                     
                   
                  </table>
                </div><!-- /.box-body -->
    </div>
    
</div>
<script type="text/javascript">
function CloseVideo(){
document.getElementById("show_bulkContentViewer").innerHTML="";
$('#myModal_bulkContentViewer').modal('hide');
}    
    
function saveAgeRestrictionBulk(act,pageindex,limitval){
   $('#myModal_bulkContentViewer').modal();
   var agelimit=$("#agelimit").val();
   if(agelimit=='')
       {
            alert("please select content Age Restriction .");
            return false;
       }
   var entryids=$("#entryids").val();
   //console.log(act+"--"+addcontentviewer+"--"+entryids);
   $("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
   $('#save_AgeRestriction').attr('disabled',true);
   var dataString ='maction='+act+'&entryids='+entryids+'&pageindex='+pageindex+'&agelimit='+agelimit+'&limitval='+limitval;
   $.ajax({
           type: "POST",
           url: "media_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
                $('#myModal_bulkContentViewer').modal('hide');
                $('#load').show();
                $('#results').css("opacity",0.1);
                if(result==1){
                $( "#results" ).load( "media_paging.php", { pageindex:pageindex,limitval:limitval,maction:'only_page_limitval' }, function(r) {
                $( "#results" ).html(r);
                $("#msg").html("Age Restriction Saved successfully");
                $('#load').hide();
                $('#results').css("opacity",1);
                });
                }
                
                
       }
    });
}
</script>

<?php
    break;
}
?> 

  
 

