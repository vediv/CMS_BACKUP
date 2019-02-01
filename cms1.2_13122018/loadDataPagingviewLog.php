<?php
include_once 'auths.php';
include_once 'auth.php'; 

?>
<div class="box-body">
 	
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                      <tr>
                           <th>S.No</th>
                           <th>User Name</th>
                           <th>Song Id</th>
                           <th>Category Id</th>
                           <th>Song Title </th>
                           <th>Tags</th>
                           <th>View Date</th>
						   <th>Last Seen</th>
                      </tr>
               </thead>
               
               <tbody>
                    	
<?php 
// value come from notification
$q="select uavl.*,ur.uname from user_authentication_view_log AS uavl LEFT JOIN user_registration as ur on uavl.uid=ur.uid order by uavl.uaid desc";
$rr= db_select($q);
$num=db_totalRow($q);
 $i=1;
 foreach($rr as $fetch )
   {
     $userid=$fetch['uid'];
     $uname=$fetch['uname'];
	 $id1=$fetch['uaid'];
	 $songid=$fetch['song_id'];
	 $categoryid=$fetch['category_id'];
	 $viewdate=$fetch['view_date'];
	 $lastseen=$fetch['last_seen'];
	 $songtitle=$fetch['song_title'];
	 $tags=$fetch['tags'];
	
 ?>  
                <tr>
                          <td><?php echo $i++; ?></td>
                          <td><?php echo $uname; ?></td>
                          <td><?php echo $songid ;?></td>
                          <td><?php echo $categoryid?></td>
                          <td><?php echo $songtitle; ?></td>
                          <td style="text-align: justify"><?php echo $tags; ?></td>   
                          <td><?php echo $viewdate; ?></td>
                          <td><?php echo $lastseen; ?></td>
                    
               </tr>
                  <?php } ?>  
                          
                    </tbody>                  
                  </table>         
    
 </div>
