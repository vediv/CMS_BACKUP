<?php
include_once 'corefunction.php';
include_once("config.php");
 $User_id=$_REQUEST['user_id'];
 $getpageindex=$_REQUEST['pageindex'];

     $query = "SELECT * FROM user_history WHERE uid=$User_id";
     $fetch =db_select($conn,$query);
     $userid=$fetch[0]['uid'];   $user_historyID=$fetch[0]['vid'];  
	 $entry_ids=rtrim ($fetch[0]['entry_ids'] , ",");
	 $viewdate=$fetch[0]['last_view']; 
	 
	 $arr=explode(",",$entry_ids);
	 $total_entry=count($arr);
?>
<h3 align="center">This Category has total <?php echo $total_entry;?> Entries</h3>
     <!-- /.box-header -->
                <table  class="table table-bordered table-striped" >
                     <thead>
	                        <tr>
	                           <th>S.No</th>
	                           <th>Thumbnail</th>
	                           <th>Entry ID</th>
	                           <th>Entry Name</th>
	                        </tr> 
                     </thead>
 <tbody>
<?php
$count=1;
$filter = new KalturaMediaEntryFilter();
foreach ($arr as $entryID)
	         {
					$entryId = $entryID;
	         	    $filter->idEqual = $entryId;
                    $pager = null;
                    $result = $client->media->listAction($filter, $pager);
	 	            //print '<pre>'.print_r($result, true).'</pre>';
				    foreach($result->objects as $entry) {
				    $id	=$entry->id;  $name=$entry->name;
				    $thumbnailUrl=$entry->thumbnailUrl;  $views=$entry->views;
			        $tumnail_height_width="/width/100/height/100";
?>
       <tr>
            <td align="center"><?php echo $count; ?></td>
            <td width="10%"><img class="img-responsive customer-img"  src="<?php echo $thumbnailUrl.$tumnail_height_width; ?>" alt="" /></td>
            <td align="center"><?php echo $id;?></td>
            <td align="center"><?php echo $name;?></td>
           <!-- <td><?php // echo $createdAt; ?></td>-->
            <?php  } $count++; }  include_once 'ksession_close.php'; ?>
       </tr>  
</ul>   
</tbody>
</table>         


            
</div>
<script src="js/jquery.slimscroll.min.js" type="text/javascript"></script> 
<script type="text/javascript">
$(function(){
    $('#inner-content-div').slimScroll({
    	 height: '350px',
    	// width:  '352px',
    	  size: '8px', 
    	 //color: '#f5f5f5'
    });
}); 
</script>
     
