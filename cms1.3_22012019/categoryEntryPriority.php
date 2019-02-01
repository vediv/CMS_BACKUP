<?php
include_once 'corefunction.php';
$act=$_POST['action'];
switch($act)
{
    case "categoryEntryPriority":
    $catid=$_POST['catid'];$catName=$_POST['catName'];
    $kquery="SELECT kcat.entry_id,kentry.name,kcat.category_id,kcat.created_at,kcat.status,kentry.thumbnail,kentry.subp_id
    FROM kaltura.category_entry kcat LEFT JOIN kaltura.entry kentry ON kcat.entry_id=kentry.id
    where kcat.partner_id='$partnerID' and kcat.category_id='$catid' and kcat.status='2' ORDER BY (kcat.id) ASC " ;
    $totalEntryKaltura = db_totalRow($conn,$kquery);
    $fetchKaltura =db_select($conn,$kquery);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Set Entry Priority In Category -- <?php echo  $catName; ?></h4>
</div>
<div class="modal-body" >
<form class="form-horizontal" method="post" name="categoryEntryForm" id="categoryEntryForm">
<div> Total Entry: <?php  echo  $totalEntryKaltura;?></div>
<div class="box">

<div id="res"></div>
<div id="load_in_modal" style="display:none; text-align: center !important;"></div>
<div class="box-body" id="inner-content-div">
<table   class="table table-bordered table-striped" >
<thead>
 <tr>
  <th>Thumbnail</th> <th>Entry ID</th> <th>Entry Name</th> <th>Added-Date</th> <th>Status</th>  <th width="10%">Priority</th>
 </tr>
</thead>
<tbody>
<?php
$count=1;
//$sql1="SELECT MAX(priority) AS maxapriority  FROM category_entry where category_id='$catid' order by priority DESC";
//$que1 = db_select($conn,$sql1);
//$maxapriority=$que1[0]['maxapriority'];
$maxapriority=$totalEntryKaltura;
foreach($fetchKaltura as $entry)
{
  $entry_id=$entry['entry_id']; $created_at=$entry['created_at'];
  $thumbnailimg=$entry['thumbnail'];
  $subp_id=$fetchKaltura=$entry['subp_id']; $name=$entry['name'];
  $thumbnailUrl=$serviceURL.'/p/'.$partnerID.'/sp/'.$subp_id.'/thumbnail/entry_id/'.$entry_id.'/version/'.$thumbnailimg;
  $tumnail_height_width="/width/90/height/60";
  $status=$entry['status'];
  //$mdeitype= $mediaType==1 ? "video" : "";
  if($status=='-1') { $statusc="error_converting"; }
  if($status=='-2') { $statusc="error_importing"; }
  if($status=='2') { $statusc="Ready"; }
  if($status=='0') { $statusc="import"; }
  if($status=='1') { $statusc="converting"; }
  if($status=='2') { $statusc="Ready"; }
  if($status=='4') { $statusc="Pending"; }
  $entry_query="select entryid,category_id,priority from category_entry where category_id='$catid' and entryid='$entry_id' order by priority DESC";
  $totalEntryl = db_totalRow($conn,$entry_query);
  $fetchEntryLocal=  db_select($conn,$entry_query);
  $catentryid=$fetchEntryLocal[0]['entryid']; $entry_priority=$fetchEntryLocal[0]['priority'];
?>
<tr id="rmv<?php echo $count; ?>">
<td><img class="img-responsive customer-img"  src="<?php echo $thumbnailUrl.$tumnail_height_width; ?>" height="30" width="70" /></td>
<td><?php echo $entry_id;?></td>
<td><?php echo $name;?></td>
<td><?php echo $created_at; ?></td>
<td>
<span class="label label-<?php echo $status==2?"success":"danger";?> label-white middle" style="cursor:pointer;"><?php echo $statusc; ?></span>
</td>
<td>
<input type="hidden" size="5" name="entryid[]" id="entryid" value="<?php echo $entry_id; ?>" />
<select class="ranking" name="category_entry_priority[]" id="pr" style="width: 80px;">
<option value="0">Not Set</option>
<?php
for($j=1;$j<=$maxapriority;$j++){?>
<option value="<?php echo $j;?>" <?php if ($entry_priority==$j){ echo 'selected'; }?>><?php  echo $j; ?></option>
<?php } ?>
</select>
</td>
<?php   $count++; }   ?>
</tr>
</tbody>
</table>
</div>
</div>
    <div style="height:50px!important">
        <div>
<?php if(in_array(2, $UserRight)){ ?>
<button type="button" name="save_priority" id="save_priority"   class="btn btn-primary center-block" onclick="saveCategoryEntryPriority('saveCategoryEntryPriority','<?php echo $catid; ?>');">Save Priority </button>

<?php } else { ?>
<button type="button" disabled name="save_priority"  class="btn btn-primary center-block">Save Priority</button>
<?php } ?>
</div><div id="loader_save" style="margin-top: -35px !important; margin-left: 510px !important"></div>
</div>
</form>
</div>
<?php break;
case "saveCategoryEntryPriority":
$category_entry_priority=$_POST['category_entry_priority']; $entryid=$_POST['entryid'];
$priority_entryid = array_combine($entryid, $category_entry_priority);
$categoryid=$_POST['categoryid'];
foreach($priority_entryid as $entryid => $cpriority) {
 {
    $chk="select COUNT(*) as totalcount from category_entry where entryid='$entryid' and category_id='$categoryid'";
    $fetchEntryCount=  db_select($conn,$chk);
    $tcount=$fetchEntryCount[0]['totalcount'];
    if($tcount>0){
       $update="Update category_entry set priority='$cpriority' where entryid='$entryid' and  category_id='$categoryid'";
       $rr=  db_query($conn, $update);
       /*----------------------------update log file begin-------------------------------------------*/
         $error_level=1;$msg="Category video Entry Priority Update($categoryid-$cpriority)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
         $qry=$insert;
         write_log($error_level,$msg,$lusername,$qry);
      /*----------------------------update log file End---------------------------------------------*/
    }
  }
}
sleep(1);
break;
case "addPlanInCategory":
$catid=$_POST['catid'];$catName=$_POST['catName'];
$getpageindex=$_REQUEST['pageindex'];
$limitval=$_REQUEST['limitval'];
$qryCat="select planid,tag from category_plan_info where categoryid='$catid'";
$fetCat=db_select($conn,$qryCat);
$getPlanID=$fetCat[0]['planid'];
$ptag=$fetCat[0]['tag'];
?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Set Plan For This Category -- <?php echo  $catName; ?></h4>
</div>
<div class="modal-body">
<div class="box">
<div class="box-body" id="inner-content-div">
  <div style="border: 1px solid #c7d1dd ; border-top: 0px; padding:5px 5px 20px 4px; text-align:center">
      <form method="post" id="formaddplanInCategory" name="formaddplanInCategory" class="form-inline">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div><!-- /.box-header -->
                  <div class="form-group ">
                    <div>
                    <label for="email">Select Plan Category :</label>
                   <?php
                      $sel="select planID,planName from plandetail where plan_used_for='w'";
                      $fet=db_select($conn,$sel);
                    ?>
                    <select name="planid" id="planid" style="width: 370px;" class="form-control" >
                    <option value="">--Select Plan Category ---</option>
                    <?php foreach ($fet as $val)
                      {
                         $planID=$val['planID'];
                         $planName=$val['planName'];
                         $sel=$getPlanID==$planID?'selected':'';
                      ?>
                      <option value="<?php echo $planID;  ?>" <?php echo $sel; ?>><?php echo $planName. " ($planID)";  ?></option>
                      <?php } ?>
                     </select>
                    <input type="hidden" name="categoryid" id="categoryid" value="<?php echo $catid; ?>">
                  </div><br />
                  <div>
                    <label for="email">Plan Category Status:</label>
                      <select name="plan_c" id="plan_c" style="width: 370px;" class="form-control">
                          <option  value="p" <?php echo $ptag=='p'?"selected":''; ?>>Premium</option>
                          <option value="f" <?php echo $ptag=='f'?"selected":''; ?>>Free</option>
                      </select>
                   </div><br /><br />
                   <div>
                   <?php if(in_array(2, $UserRight)){ ?> <button type="button" name="savePlanForCategory" id="savePlanForCategory" class="btn btn-primary" onclick="savePlanCategory('savePlanCategory','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>');" >Save</button>
                    <span id="saving_loader"></span>
                  <?php } else { ?>
                  <button type="button" disabled name="savePlanForCategory"  class="btn btn-primary center-block">Save</button>
                   <span id="saving_loader"></span>
                  <?php } ?>
                </div></div>

       </form>
  </div>
</div>
</div>
<?php break; } ?>
<script src="js/jquery.slimscroll.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    $('#inner-content-div').slimScroll({
    	 height: '400px',
    	// width:  '352px',
    	  size: '8px',
    	 //color: '#f5f5f5'
    });
});
$(".ranking").each(function(){
 // alert("yes");
    $(this).data('__old', this.value);
}).change(function() {
    var $this = $(this), value = $this.val(), oldValue = $this.data('__old');
        $(".ranking").not(this).filter(function(){
        return this.value == value;

    }).val(oldValue).data('__old', oldValue);

    $this.data('__old', value);
});
function saveCategoryEntryPriority(smatadata,categoryid){
  $("#saving_loader").show();
  $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
     $("#loader_save").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
     $('#savePlanForCategory').attr('disabled',true);
     $.ajax({
      method : 'POST',
      url : 'categoryEntryPriority.php',
      data : $('#categoryEntryForm').serialize() +
           "&categoryid="+categoryid+"&action="+smatadata,
      success: function(jsonResult){
          $('#savePlanForCategory').attr('disabled',false);
          $("#loader_save").hide();
          var msgm='<div class="alert alert-success"><strong>Success!</strong> Priority Saved Successfully.</div>';
          $("#res").html(msgm);
          $("#saving_loader").hide();
        }
      });
}
function savePlanCategory(act,pageindex,limitval){
     $("#loader_save").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
     $('#save_priority').attr('disabled',true);
     var planid=$("#planid").val();
     var plan_c=$("#plan_c").val();
     if(planid=='')
     {
        alert("select plan"); return false;
     }
     var categoryid=$("#categoryid").val();
     $("#saving_loader").show();
     $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
     $.ajax({
      method : 'POST',
      url :'category_paging.php',
      data :"categoryid="+categoryid+"&planid="+planid+"&categoryaction="+act+"&pageNum="+pageindex+"&limitval="+limitval+"&plan_c="+plan_c,
      success: function(result){
          $('#save_priority').attr('disabled',false);
          $("#loader_save").hide();
          //$("#results").html('');
          $('#myModal_view_setpriority').modal('hide');
          $("#msg").html('Save plan Successfully');
          $("#results").html(result);
          $("#saving_loader").hide();
        }
      });

}
</script>
