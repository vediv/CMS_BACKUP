<?php
include_once 'corefunction.php';
$Entryid=$_POST['Entryid']; $getpageindex=$_POST['pageindex'];$limitval=$_POST['limitval']; $searchInputall=$_POST['searchInputall'];
$selEntry="select puser_id from entry where entryid='$Entryid'";
$f= db_select($conn,$selEntry);
$contentpartnerid=$f[0]['puser_id']; 
?>
<div style="border: 1px solid #c7d1dd ; border-top: 0px; padding:5px 0px 20px 4px ">
    <form method="post" id="formMetaDataContentPartner" name="formMetaDataContentPartner">  
<div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Content Partner</h3>
                </div><!-- /.box-header -->
                <div class="">
               <div class="form-group">
                   <label class="control-label col-sm-2" >Content Partner:</label>
                   <div class="col-sm-10">
                   <?php 
                        $sel="Select contentpartnerid,name,par_id from content_partner where status='1' order by name";
                        $fet=db_select($conn,$sel);
                        ?>
                     <select name="contentpartner" id="contentpartner" style="width: 370px;" class="form-control" >
                     <option value="">--Select Content Partner--</option>
                    <?php foreach ($fet as $val) 
                    {  $par_id=$val['par_id'];  
                       $cname=$val['name']; 
                       $sel=$par_id==$contentpartnerid?"selected":'';
                    ?>
                    <option value="<?php echo $par_id;  ?>" <?php echo $sel; ?>><?php echo $cname;  ?></option>
                    <?php } ?>
                   </select>
                   </div>
                </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
        

 <div class="modal-footer">
            <div class="col-sm-offset-3 col-sm-4" style="right: 6%;">
            <?php $disabled_button = (in_array(2, $UserRight) ? "" : "disabled"); ?>
            <button type="button" name="save_contentPartner" <?php echo $disabled_button; ?> id="save_contentPartner" class="btn btn-primary" onclick="save_content_partner_metdata('save_content_partner_metdata','<?php echo $Entryid; ?>','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>');" >Save</button>
                <span id="saving_loader"> </span>  
            </div>
        </div>
    </form>
</div>        
 
<script type="text/javascript">
var searchInputall="<?php echo $searchInputall ?>"; 
function save_content_partner_metdata(smatadata,entryid,pageindex,limitval){
var contentpartner = $('#contentpartner').val();
   if(contentpartner=='')
       {
            alert("please select content_partner ?");
            return false;
       }
 $("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
   $('#save_contentPartner').attr('disabled',true);
     $.ajax({
      method : 'POST',
      url : 'media_paging.php',
      data :"entryid="+entryid+"&maction="+smatadata+"&pageindex="+pageindex+"&limitval="+limitval+"&content_partner="+contentpartner+"&searchInputall="+searchInputall,
      success: function(jsonResult){
            $("#saving_loader").hide(); 
            $('#myModalVodEdit').modal('hide');
            $("#results").html(jsonResult);
            $("#msg").html("content partner saved successfully"); 
        }
      });  
  
}

</script>

                 
