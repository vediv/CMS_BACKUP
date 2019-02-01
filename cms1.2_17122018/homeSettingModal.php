<?php
include_once 'corefunction.php';
$action=(isset($_POST['action']))? $_POST['action']: "";
switch($action)
{
	case "add_new_hometags":
        ?> 
        <div class="modal-body">
          <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('myModal_add_new_homeTags','view_modal_new_homeTags');">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>Add New Home Tags</b>
                </h4>
            </div>
        <br/>
       <div style=" border:1px solid #c7d1dd ;">
        <form class="form-horizontal" role="form" action="javascript:" method="post" id="confirm" onsubmit="return SaveHomeTags()">
            <div class="form-group" style="margin-top: 12px">
              <label class="control-label col-sm-4">Home Tag Name *:</label>
              <div class="col-sm-7">
                  <input type="text" class="form-control" maxlength="30"  name="ttag" id="ttag" placeholder="Tag Name ,max 30 characters">
                  <span class="help-block has-error" id="ttag-error" style="color:red;"></span>
              </div>
            </div>
                 <div class="form-group">
                   <label class="control-label col-sm-4" >Search Tag:</label>
                   <div class="col-sm-7">          
                       <input type="text" class="form-control" maxlength="30" name="stag" id="stag"  aria-required  placeholder="enter search tag name ,max 30 characters">
                       <span class="help-block has-error" id="stag-error" style="color:red;"></span>
                   </div>
                 </div>
             <div class="modal-footer">
            <div class="pull-left col-sm-7" style="border:0px solid red;">
             <button type="submit" name="save" id="home_tag" class="btn btn-primary" >Save</button>   
            </div>
            <div align="left" class="pull-right col-sm-5" style="border:0px solid red;">
               <span id="saving_loader"> </span>
            </div>
           </div>
         </form>
       </div>
    </div>
       
        <?php   
        break;    
        case "edit_homeTags":
        $tagid=$_POST['tagid']; $pageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];
        $query1="select title_tag_name,search_tag from home_title_tag where tags_id='$tagid'";
        $fetch= db_select($conn,$query1);
        $title_tag_name =$fetch[0]['title_tag_name']; $search_tag =$fetch[0]['search_tag'];  
         ?>   
         <div class="modal-body">
         <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('LegalModal_modal_edit_homeTags','edit_modal_homeTags');" >
         <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
         <h4 class="modal-title" id="myModalLabel"> <b>Edit Home Setting Tag - <?php echo $title_tag_name; ?> </b></h4> 
         </div>
         <br/>
       <div style=" border:1px solid #c7d1dd ;">
       <form class="form-horizontal" role="form" action="javascript:" method="post" id="confirm" onsubmit="return SaveEditHomeTags('<?php echo $tagid; ?>','<?php echo $pageindex; ?>','<?php echo $limitval;  ?>')">
            <div class="form-group" style="margin-top: 12px">
              <label class="control-label col-sm-3">Tag Name:</label>
              <div class="col-sm-7">
                  <input type="text" class="form-control" maxlength="30" value="<?php echo $title_tag_name; ?>"  name="ttag" id="ttag" placeholder="Tag Name ,max 30 characters">
                  <span class="help-block has-error" id="ttag-error" style="color:red;"></span>
              </div>
            </div>
                 <div class="form-group">
                   <label class="control-label col-sm-3" >Search Tag:</label>
                   <div class="col-sm-7">          
                       <input type="text" class="form-control" maxlength="30" value="<?php echo $search_tag; ?>" name="stag" id="stag"  aria-required  placeholder="enter search tag name ,max 30 characters">
                       <span class="help-block has-error" id="stag-error" style="color:red;"></span>
                   </div>
                 </div>
              <!--<div class="modal-footer">
                   <div class="col-sm-offset-2 col-sm-3">
                       <button type="submit" name="save" id="home_tag" class="btn btn-primary" >Update</button>
                     <span id="saving_loader"> </span>  
                      
                   </div>
                 </div>-->
           <div class="modal-footer">
            <div class="pull-left col-sm-7" style="border:0px solid red;">
             <button type="submit" name="save" id="home_tag" class="btn btn-primary" >Update</button>   
            </div>
            <div align="left" class="pull-right col-sm-5" style="border:0px solid red;">
               <span id="saving_loader"> </span>
            </div>
           </div>
         </form>
       
       </div> 
        
        </div>    
        <?php 
        break;    
}
?>
<script>
    $('input[type=text]').blur(function(){ 
       $(this).val($.trim($(this).val().replace(/\t+/g,' ')));
    }); 
</script> 