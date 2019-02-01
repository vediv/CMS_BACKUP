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
include_once 'corefunction.php';
$ptag=$_POST['ptag']; $Entryid=$_POST['Entryid']; $getpageindex=$_POST['pageindex']; $searchInputall=$_POST['searchInputall'];
$limitval=$_POST['limitval'];
$checked="";
if($ptag!=''){ ?>    
<script type="text/javascript">
planinfoView('<?php echo $ptag; ?>','showedit','<?php echo $Entryid; ?>');
</script>    
<?php } ?>

<div style="border: 1px solid #c7d1dd ; border-top: 0px; padding:20px 0px 20px 4px ">
<form method="post"  name="PlanShow" id="PlanShow">   
<div class="row" <div class="row" style="margin-top: 0px;">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Choose The following Content Type : </h3>
                  <div class="form-group">
                   <p>   
                    <label class="radio-inline">
                        <!--<input type="radio" name="planoption" <?php echo $ptag=='f' ? "checked" :""; ?>  id="planoption" value="f" onclick="planinfo('f','show')" style="cursor: pointer;" >Free-->
                        <input type="radio" name="planoption" <?php echo $ptag=='f' ? "checked" :""; ?>  id="planoption" value="f" style="cursor: pointer;" >Free
                    </label>
                    <!-- <label class="radio-inline">
                      <input type="radio" name="planoption" id="planoption" <?php //echo $ptag=='t' ? "checked" :""; ?> value="t" onclick="planinfo('t','show')" style="cursor: pointer;">Trial
                    </label> -->
                    <label class="radio-inline">
                        <!--<input type="radio" name="planoption" id="planoption" <?php echo $ptag=='p' ? "checked" :""; ?> value="p" onclick="planinfo('p','show')" style="cursor: pointer;">Premium-->
                        <input type="radio" name="planoption" id="planoption" <?php echo $ptag=='p' ? "checked" :""; ?> value="p" style="cursor: pointer;">Premium

                    </label>
                    </p>
                    </div>
                </div><!-- /.box-header -->
               
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        
        <div class="modal-footer">
            <div class="col-sm-offset-3 col-sm-4" style="right: 6%;">
            <?php if(in_array(2, $UserRight)){ ?> 
            <button type="button" class="btn btn-primary" id="saveplan" data-dismiss="modal1" onclick="save_plan('saveplan','<?php echo $Entryid; ?>','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>');" >Save & Close</button>
            <?php } else { ?>
            <button type="button" class="btn btn-primary" disabled data-dismiss="modal" name="submit">Save & Close</button>
          <?php } ?>  
            
            </div>
            <span id="saving_loader"> </span>  
        </div>
      
  </form>
      </div>


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
var searchInputall="<?php echo $searchInputall ?>"; 
function save_plan(saveplan,entryid,pageindex,limitval){
var plan_ids = $('#example-getting-started1').val();
//var planuniquename=$("input:radio[name=planoption]").is(":checked")
var planuniquename=$('input[name=planoption]:checked').val();
   if(!planuniquename)
   {
        alert("Please Choose atleast One Plan Type ?");
        $("#myModal").modal('show');
        return false
   }
   /*if(plan_ids=='' || plan_ids==null)
   {
        alert("Please Select atleast One Plan ?");
        $("#myModal").modal('show');
        return false
   }*/
    $('#saveplan').attr('disabled',true);
    $("#saving_loader").show();
    $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');  
    var dataString ='maction='+saveplan+'&entryid='+entryid+'&pageindex='+pageindex+'&planuniquename='+planuniquename+'&limitval='+ limitval+"&searchInputall="+searchInputall;
    //var dataString ='maction='+saveplan+'&entryid='+entryid+'&plan_ids='+plan_ids+'&pageindex='+pageindex+'&planuniquename='+planuniquename+'&limitval='+ limitval;
    $.ajax({
           type: "POST",
           url: "media_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
           $("#myModalVodEdit").modal('hide');
           $("#saving_loader").hide();    
           $("#results").html(result);
           $("#msg").html("plan saved successfully"); 
           
           }
    });
}
</script>
