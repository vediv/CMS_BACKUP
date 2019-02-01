<?php
include_once 'corefunction.php';
$act=$_POST['action'];
switch($act)
{
     case "setpriority":
     ?>
    
 <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Set Category Priority</h4>
         </div>

<div class="modal-body" >
    <form class="form-horizontal" method="post" action="#">    
<div class="box">
<div class="box-body"  id="inner-content-div" >
    
<table   class="table table-bordered table-striped" >
  <thead>
   <tr> <th>Category ID</th> <th>Name</th> <th>Priority</th>  </tr> 
 </thead>
  <tbody style="border: 0px solid red; overflow-x: hidden; overflow-y: auto; ">
                  	
<?php
$sql1="SELECT MAX(priority) AS maxapriority  FROM categories order by priority DESC";
$que1 = db_select($conn,$sql1);
$maxapriority=$que1[0]['maxapriority'];
$sql="SELECT catid,category_id,cat_name,priority FROM categories order by priority DESC";
$que = db_select($conn,$sql);
$countRow=  db_totalRow($conn,$sql);
$count=1;
foreach($que as $fetch)
{
   $catid=$fetch['catid']; $category_id=$fetch['category_id']; $cat_name =$fetch['cat_name']; $priority=$fetch['priority'];
?>
<tr>

<td><?php echo $category_id;?></td>
<td><?php echo $cat_name;?></td>
<td>
<input type="hidden" size="5" name="idd[]" id="idd" value="<?php echo $catid; ?>" />
<select class="ranking" name="pr[]" id="pr" style="width: 60px;">
<?php
for($j=1;$j<=$maxapriority;$j++){?>       	
<option value="<?php echo $j;?>" <?php if ($priority==$j){ echo 'selected'; }?>><?php echo $j; ?></option>
<?php 
    }
    ?>		
</select>
</td>
<?php  $count++; }  ?>
</tr>  
</ul>   

</tbody>
        
</table> 
</div>    
</div> 

      
<?php if(in_array(2, $UserRight)){ ?>   
    <button type="submit" name="save_priority" data-dismiss="modal2"  class="btn btn-primary center-block">Save Priority</button>
<?php } else { ?>
<button type="submit" disabled name="save_priority" data-dismiss="modal2" class="btn btn-primary center-block">Changes Priority</button>
<?php } ?> 

</form>
</div>
<?php break;   
     case "setpriority_slider":
     ?>    
 <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Set Slider Image Priority</h4>
         </div>

<div class="modal-body" >
    <form class="form-horizontal" method="post" action="#">    
<div class="box">
<div class="box-body"  id="inner-content-div" >
    
<table   class="table table-bordered table-striped" >
  <thead>
   <tr> <th>Image</th> <th>EntryID</th> <th>Priority</th>  </tr> 
 </thead>
  <tbody style="border: 0px solid red; overflow-x: hidden; overflow-y: auto; ">
                  	
<?php
$sql1="SELECT MAX(priority) AS maxapriority  FROM slider_image_detail order by priority DESC";
$que1 = db_select($conn,$sql1);
$maxapriority=$que1[0]['maxapriority'];
$sql="SELECT img_id,ventryid,img_url,host_url,priority FROM slider_image_detail order by priority ASC";
$que = db_select($conn,$sql);
$countRow=  db_totalRow($conn,$sql);
$count=1;
foreach($que as $value)
{
    $id=$value['img_id'];   $ventryid=$value['ventryid'];  
    $img_url=$value['img_url'];  $host_url=$value['host_url'];	
    if (preg_match('/http:/',$host_url))
    $host_url_new=$host_url;
    else $host_url_new="http://".$host_url; 	
    $priority=$value['priority'];
   
?>
<tr>

<td width="200"><img class="img-responsive customer-img" width="200" height="100"   src="<?php echo $host_url_new.$img_url; ?>" alt="" /></td>
<td><?php echo $ventryid;?></td>
<td>
<input type="hidden" size="5" name="idd[]" id="idd" value="<?php echo $id; ?>" />
<select class="ranking" name="pr[]" id="pr" style="width: 60px;">
<?php
for($j=1;$j<=$maxapriority;$j++){
    
?>       	
<option value="<?php echo $j;?>" <?php if ($priority==$j){ echo 'selected'; }?>><?php echo $j; ?></option>
<?php } ?>		
</select>
</td>

<?php  $count++; }  ?>
</tr>  
</ul>   

</tbody>
        
</table> 
</div>    
</div> 

      
<?php if(in_array(2, $UserRight)){ ?>   
    <button type="submit" name="save_priority_slider" data-dismiss="modal2"  class="btn btn-primary center-block">Save Priority</button>
<?php } else { ?>
<button type="submit" disabled name="save_priority_slider" data-dismiss="modal2" class="btn btn-primary center-block">Changes Priority</button>
<?php } ?> 

</form>
</div>
    <?php 
    break;
     case "setpriority_homeSettingtags":
     ?>    
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Set Home Setting Tags Priority</h4>
         </div>

<div class="modal-body" >
    <form class="form-horizontal" method="post" action="#">    
<div class="box">
<div class="box-body"  id="inner-content-div" >
    
<table   class="table table-bordered table-striped" >
  <thead>
   <tr> <th>TagName</th> <th>Search Tag</th> <th>Priority</th>  </tr> 
 </thead>
  <tbody style="border: 0px solid red; overflow-x: hidden; overflow-y: auto; ">
<?php
$sql1="SELECT MAX(priority) AS maxapriority  FROM home_title_tag order by priority DESC";
$que1 = db_select($conn,$sql1);
$maxapriority=$que1[0]['maxapriority'];
$sql="SELECT tags_id,title_tag_name,search_tag,priority FROM home_title_tag order by priority ASC";
$que = db_select($conn,$sql);
$countRow=  db_totalRow($conn,$sql);
$count=1;
foreach($que as $value)
{
    $id=$value['tags_id']; $title_tag_name=$value['title_tag_name']; $search_tag=$value['search_tag'];   $priority=$value['priority'];
?>
<tr>

<td><?php echo $title_tag_name; ?> </td>
<td><?php echo $search_tag;?></td>
<td>
<input type="hidden" size="5" name="idd[]" id="idd" value="<?php echo $id; ?>" />
<select class="ranking" name="pr[]" id="pr" style="width: 60px;">
<?php
for($j=1;$j<=$maxapriority;$j++){
?>       	
<option value="<?php echo $j;?>" <?php if ($priority==$j){ echo 'selected'; }?>><?php echo $j; ?></option>
<?php } ?>		
</select>
</td>

<?php  $count++; }  ?>
</tr>  
</ul>   

</tbody>
        
</table> 
</div>    
</div> 

      
<?php if(in_array(2, $UserRight)){ ?>   
    <button type="submit" name="save_priority_homeSetting" data-dismiss="modal2"  class="btn btn-primary center-block">Save Priority</button>
<?php } else { ?>
<button type="submit" disabled name="save_priority_homeSetting" data-dismiss="modal2" class="btn btn-primary center-block">Changes Priority</button>
<?php } ?> 

</form>
</div>
    <?php 
    break;    
    
 case "setpriority_headerContent":
     ?>    
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Set Header Content Priority</h4>
         </div>

<div class="modal-body" >
    <form class="form-horizontal" method="post" action="#">    
<div class="box">
    <div class="box-body"  id="inner-content-div">
    
<table   class="table table-bordered table-striped" >
  <thead>
   <tr> <th>Header Name</th><th>Priority</th>  </tr> 
 </thead>
  <tbody style="border: 0px solid red; overflow-x: hidden; overflow-y: auto; ">
<?php
$sql1="SELECT MAX(priority) AS maxapriority  FROM header_menu where header_status!='3' order by priority DESC";
$que1 = db_select($conn,$sql1);
$maxapriority=$que1[0]['maxapriority'];
$sql="SELECT hid,header_name,priority FROM header_menu where header_status!='3'  order by priority ASC";
$que = db_select($conn,$sql);
$countRow=  db_totalRow($conn,$sql);
$count=1;
foreach($que as $value)
{
    $id=$value['hid']; $header_name=$value['header_name'];    $priority=$value['priority'];
?>
<tr>

<td><?php echo $header_name; ?> </td>
<td>
<input type="hidden" size="5" name="idd[]" id="idd" value="<?php echo $id; ?>" />
<select class="ranking" name="pr[]" id="pr" style="width: 60px;">
<?php
for($j=1;$j<=$maxapriority;$j++){
?>       	
<option value="<?php echo $j;?>" <?php if ($priority==$j){ echo 'selected'; }?>><?php echo $j; ?></option>
<?php } ?>		
</select>
</td>

<?php  $count++; }  ?>
</tr>  
</ul>   

</tbody>
        
</table> 
</div>    
</div> 
<?php if(in_array(2, $UserRight)){ ?>   
    <button type="submit" name="save_priority_headercontent" data-dismiss="modal2"  class="btn btn-primary center-block">Save Priority</button>
<?php } else { ?>
<button type="submit" disabled name="save_priority_headercontent" data-dismiss="modal2" class="btn btn-primary center-block">Changes Priority</button>
<?php } ?> 

</form>
</div>
    <?php 
    break;    
} ?>
<script src="dist/js/custom.js" type="text/javascript"></script> 
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
</script>


