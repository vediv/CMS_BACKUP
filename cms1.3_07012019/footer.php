<?php include_once 'corefunction.php'; ?>
<footer class="main-footer">
<?php 
$query1 = "SELECT * FROM dashbord_footer where f_status='1'";
$fetch = db_select($conn,$query1);
if(!empty($fetch))
{
 ?>

<strong>Copyright &copy; <?php echo $fetch[0]['f_year']; ?> <a href="<?php echo $fetch[0]['f_hyperlink']; ?>" target="_blank"><?php echo ucwords($fetch[0]['f_content']); ?></a>
</strong> All rights reserved. Version 1.1
<strong style="float: right;"> Powered By <a href="http://www.planetc.net/" target="_blank">Planetcast</a></strong>


<?php } 
else { echo "Set The footer Detail <a href='footer_content.php'> Click Here</a>";}
?>
</footer>
<?php
/* close db connections */
db_close($conn);
db_close1();
?>
