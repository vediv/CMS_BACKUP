<?php
include_once 'corefunction.php';
$action=(isset($_POST['action']))? $_POST['action']: "";
switch($action)
{     
       case "viewTypePreview":
       $viewName=$_POST['viewName'];  $viewImgUrl=$_POST['viewImgUrl'];   
        ?> 
        <div class="modal-body">
          <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('myModalViewType','view_view_type');">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                 </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>View Type Preview <?php //echo $viewName; ?></b>
                </h4>
            </div>
        <div class="row" style="padding-top: 10px;">
            <div class="col-md-6">
                <img src="<?php echo $viewImgUrl; ?>">
            </div>
      
            
         </div>
 </div>
      
        <?php   
        break;    
}
?>

