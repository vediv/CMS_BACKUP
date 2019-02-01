<?php
include_once 'corefunction.php';
$Entryid=$_POST['Entryid']; $getpageindex=$_POST['pageindex'];$limitval=$_POST['limitval']; $searchInputall=$_POST['searchInputall'];
$selEntry="select age_limit from entry where entryid='$Entryid'";
$f= db_select($conn,$selEntry);
$age_limit=$f[0]['age_limit']; 
//echo "age";
?>
<div style="border: 1px solid #c7d1dd ; border-top: 0px; padding:5px 5px 20px 4px; text-align:center">
    <form method="post" id="formMetaDataContentViewer" name="formMetaDataContentViewer" class="form-inline">  
              <div class="box-header">
                  <h3 class="box-title"></h3>
              </div><!-- /.box-header -->
                <div class="form-group ">
                  <label for="agelimit">Select Content Rating :</label>
                     <select name="agelimit" id="agelimit" style="width: 370px;" class="form-control" >
                     <option value="">--Select Content Rating--</option>
                     <option value="UA"  <?php echo $age_limit=="UA"?"selected":'';  ?> >U/A</option>
                     <option value="A"  <?php echo $age_limit=="A"?"selected":'';  ?> >A</option>
                     <!--<option value="PG13" <?php echo $age_limit=="PG13"?"selected":'';  ?>>PG13</option>
                     <option value="NC16" <?php echo $age_limit=="NC16"?"selected":'';  ?>>NC16</option>
                     <option value="M18" <?php echo $age_limit=="M18"?"selected":'';  ?>>M18</option>
                     <option value="R21" <?php echo $age_limit=="R21"?"selected":'';  ?>>R21</option>-->
                     </select>
                </div>
             <?php $disabled_button = (in_array(2, $UserRight) ? "" : "disabled"); ?>       
             <button type="button" name="save_ageRestriction" <?php echo $disabled_button; ?> id="save_ageRestriction" class="btn btn-primary" onclick="saveAge('saveAgeR','<?php echo $Entryid; ?>','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>');" >Save</button>
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
var searchInputall="<?php echo $searchInputall ?>"; 
function saveAge(smatadata,entryid,pageindex,limitval){
var agelimit = $('#agelimit').val();
   if(agelimit=='')
       {
            alert("please select content Age Restriction .");
            return false;
       }
   $("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
   $('#save_ageRestriction').attr('disabled',true);
     $.ajax({
      method : 'POST',
      url : 'media_paging.php',
      data :"entryid="+entryid+"&maction="+smatadata+"&pageindex="+pageindex+"&limitval="+limitval+"&agelimit="+agelimit+"&searchInputall="+searchInputall,
      success: function(jsonResult){
            $("#saving_loader").hide(); 
            $('#myModalVodEdit').modal('hide');
            $("#results").html(jsonResult);
            $("#msg").html("age restriction saved successfully"); 
        }
      });  
  
}

</script>

                 
