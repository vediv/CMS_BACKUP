<?php
include_once 'corefunction.php';
$action=(isset($_POST['action']))? $_POST['action']: "";
switch($action)
{
	case "add_new_footer":
        ?> 
        <div class="modal-body">
          <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('myModal_add_new_footer','view_modal_new_footer');">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>Add New Content</b>
                </h4>
            </div>
        <div style=" border:1px solid #c7d1dd ;">
        <form class="form-horizontal" role="form" action="javascript:" method="post" id="confirm" onsubmit="return SaveFooter()">
            <div class="form-group" style="margin-top: 12px">
              <label class="control-label col-sm-3">Year:</label>
              <div class="col-sm-7">
                  <select class="form-control" name="year" id="year" required>
                      <option value="">Select Year</option>
                      <option value="2015">2015</option>
                      <option value="2016">2016</option>
                      <option value="2017">2017</option>
                      <option value="2018">2018</option>
                      <option value="2019">2019</option>
                       <option value="2020">2020</option>
                    </select>                
                  <span class="help-block has-error" id="ttag-error" style="color:red;"></span>
              </div>
            </div>
                 <div class="form-group">
                   <label class="control-label col-sm-3" >Content:</label>
                   <div class="col-sm-7">          
                       <input type="text" class="form-control" maxlength="30" name="content" id="content"  aria-required  placeholder="Enter Footer Content">
                       <span class="help-block has-error" id="stag-error" style="color:red;"></span>
                   </div>
                 </div>
             <div class="form-group">
                   <label class="control-label col-sm-3" >URL:</label>
                   <div class="col-sm-7">          
                       <input type="text" class="form-control" name="url" id="url" required=""  onblur="checkURL(this)" pattern="^(https?://)?([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$"  aria-required  placeholder="Enter Footer Content">
                       <span class="help-block has-error" id="stag-error" style="color:red;"></span>
                   </div>
                 </div>
              <div class="modal-footer">
                   <div class="col-sm-offset-2 col-sm-3">
                       <button type="submit" name="save" id="footer_content" class="btn btn-primary" >Submit</button>
                        <span id="saving_loader"> </span>  
                      
                   </div>
                 </div>
         </form>
       </div>
    </div> 
        <?php     
            break;    
            case "edit_footer":
            $fid=$_POST['fid']; $pageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];
            $query1="select f_year,f_content,f_hyperlink from dashbord_footer where f_id='$fid'";
            $fetch= db_select($conn,$query1);
            $year =$fetch[0]['f_year']; $content =$fetch[0]['f_content'];  $url =$fetch[0]['f_hyperlink'];  
         ?>   
         <div class="modal-body">
         <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('LegalModal_modal_edit_homeTags','edit_modal_homeTags');" >
         <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
         <h4 class="modal-title" id="myModalLabel"> <b>Edit Footer Content - <?php echo $content; ?> </b></h4> 
         </div>
         <br/>
       <div style=" border:1px solid #c7d1dd ;">
       <form class="form-horizontal" role="form" action="javascript:" method="post" id="confirm" onsubmit="return SaveEditFooter('<?php echo $fid; ?>','<?php echo $pageindex; ?>','<?php echo $limitval;  ?>')">
            <div class="form-group" style="margin-top: 12px">
                <label class="control-label col-sm-3">Year:</label>
              <div class="col-sm-7">
                 
                   <select class="form-control" name="year" id="year" >
                        <option value="2015"<?php echo $year=='2015'? 'selected': ''; ?> >2015</option>
                        <option value="2016"<?php echo $year=='2016'? 'selected': ''; ?> >2016</option>
                        <option value="2017"<?php echo $year=='2017'? 'selected': ''; ?> >2017</option>
                        <option value="2018"<?php echo $year=='2018'? 'selected': ''; ?> >2018</option>
                        <option value="2019"<?php echo $year=='2019'? 'selected': ''; ?> >2019</option>
                        <option value="2020"<?php echo $year=='2020'? 'selected': ''; ?> >2020</option>
                  </select>	                 
                  <span class="help-block has-error" id="year-error" style="color:red;"></span>
              </div>
            </div>
                 <div class="form-group">
                   <label class="control-label col-sm-3" >Content:</label>
                   <div class="col-sm-7">          
                       <input type="text" class="form-control"  value="<?php echo $content; ?>" name="content" id="content"  aria-required  placeholder="Enter Footer Content">
                       <span class="help-block has-error" id="content-error" style="color:red;"></span>
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="control-label col-sm-3" >URL:</label>
                   <div class="col-sm-7">          
                       <input type="text" class="form-control"  value="<?php echo $url; ?>" name="url" id="url" onblur="checkURL(this)" pattern="^(https?://)?([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$" aria-required  placeholder="Enter URL">
                       <span class="help-block has-error" id="url-error" style="color:red;"></span>
                   </div>
                 </div>
              <div class="modal-footer">
                   <div class="col-sm-offset-2 col-sm-3">
                       <button type="submit" name="save" id="footer_content" class="btn btn-primary" >Update</button>
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
   function checkURL (abc) {
    var string = abc.value;
    console.log(abc);
    if (!~string.indexOf("http")){
        console.log("abcd");
        string = "http://" + string;
    }
    abc.value = string;
    return abc
}
    </script>     