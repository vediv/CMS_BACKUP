<?php
include_once 'corefunction.php';
$action=(isset($_POST['action']))? $_POST['action']: "";
switch($action)
{     
        case "save_headercontent":
        $catID=$_POST['catid'];  $m_name=$_POST['m_name']; $view_type=$_POST['view_type']; $menu_type=$_POST['menu_type'];
        $host_url=$_POST['host_url']; $img_urls=$_POST['img_urls'];
        $checkUserID = "SELECT category_id from header_menu WHERE category_id = '$catID' and menu_type='".$menu_type."'";
        $num=db_totalRow($conn,$checkUserID); 
        if ($num > 0) { echo 1; exit;  }
        $sql="insert into header_menu (category_id,header_name,header_status,priority,added_date,view_type,host_url,img_url,menu_type)
            Select '$catID','$m_name','0',ifnull(max(priority),0)+1,NOW(),'$view_type','$host_url','$img_urls','$menu_type' from header_menu";
         $r=db_query($conn,$sql);
         $error_level=1;$msg="Add New Header Content($m_name)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
         $qry='';
         write_log($error_level,$msg,$lusername,$qry);
         /*----------------------------update log file End---------------------------------------------*/  
        echo 2; exit;
        break;   
	case "add_new_headercontent":
        ?> 
        <div class="modal-body">
          <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('myModal_add_new_headerContent','view_modal_new_headerContent');">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                 </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>Add New Header Content</b>
                </h4>
            </div>
       <form class="form-horizontal" role="form" action="javascript:" id="imageform" method="post" enctype="multipart/form-data" onsubmit="return SaveHeaderContent()">
        <div class="row" style="padding-top: 10px;">
        <div id="error_dublicate" class="text-center" style="padding:0 10px 0px 10px;"></div>   
            <div class="col-md-6">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Select Fixed Menu as Menu Header </h3>
                </div>
                <div class="box-body no-padding">
                 <div id="sidebar" class="well sidebar-nav" style="border: 1px solid #c7d1dd; max-height:250px; overflow-y: scroll;"> 
                    <div class="mainNav" style="border: 1px solid #c7d1dd ;">
                    <ul>
                   <?php
                   $que="SELECT header_fixed_mid,name FROM header_fixed_menu WHERE status='2'" ;
                   $row=db_select($conn,$que);
                   foreach ($row as  $cat) {                                    
                   $header_fixed_mid=$cat['header_fixed_mid']; $name=$cat['name'];
                   ?>    
                       <li>
                           <input type="radio" name="menu_value"  id="menu_value"  value="<?php  echo $header_fixed_mid."@@".$name; ?>" required>	
                       <a href="javascript:"><?php echo strtoupper($name);?></a>
                       </li>			
                       <?php }?>
                   </ul>
                   </div>
                   </div>
                </div>
              </div>

            
            </div>
            <div class="col-md-6">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Select Category as Menu Header</h3>
                </div>
                <div class="box-body no-padding">
                  <div id="sidebar" class="well sidebar-nav" style="border: 1px solid #c7d1dd; max-height:250px; overflow-y: scroll;"> 
                    <div class="mainNav" style="border: 1px solid #c7d1dd ;">
                    <ul>
                   <?php
                   $que="SELECT category_id,cat_name FROM categories WHERE parent_id='0'" ;
                   $row=db_select($conn,$que);
                   foreach ($row as  $cat) {                                    
                   $category_id=$cat['category_id']; $cat_name=$cat['cat_name'];
                   ?>    
                       <li>
                           <input type="radio" name="menu_value"  id="menu_value"  value="<?php  echo $category_id."@@".$cat_name; ?>" required>	
                       <a href="javascript:"><?php echo strtoupper($cat_name);?></a>
                       </li>			
                       <?php }?>
                   </ul>
                   </div>
                   </div>
                </div>
              </div>
             </div>
            
         </div>
           <div class="col-md-12">  
            <div class="form-group" style="margin-top: 0px; border: 0px solid red;">
                <label class="control-label col-sm-2 " style="border: 0px solid red; margin-top: 3px;">Header Name:</label>
                <div class="col-sm-4">
                   <input type="hidden" class="form-control"  id="catid" name="catid">
                   <input type="text" class="form-control" size="15" maxlength="30" readonly name="m_name" id="m_name" >
                    <span class="help-block has-error" id="m_name-error" style="color:red;"></span>
                </div>
            <!--</div> 
            <div class="form-group" style="margin-top: 6px;">-->
                <label class="control-label col-sm-2" style="border: 0px solid red; margin-top: 3px;">Menu Type:</label>
                <div class="col-sm-3">
                    <select name="menu_type" id="menu_type" style="width: 200px;">
                        <option value="">--Select Menu type--</option>
                        <option value="h">Header Menu</option>
                        <option value="l">Left Menu</option>
                        <option value="f">Footer Menu</option>
                        <option value="r">Right Menu</option>
                    </select>
                  <span class="help-block has-error" id="menu_type-error" style="color:red;"></span>
                </div>
            </div>  
           </div>
           
            <div class="form-group" style="margin-top: 12px;">
            <label class="control-label col-sm-3 " style="border: 0px solid red;">Select View Type *:</label>
            <?php
            $json=file_get_contents('includes/viewTypeSet.json');
            //print_r($data); 
            $json_data = json_decode($json,true);
            foreach ($json_data as $key => $value) {
                $name=$json_data[$key]["name"];
                $v=$json_data[$key]["value"];
                $img=$json_data[$key]["image"];
            ?>
            <label class="radio-inline control-label"> <input type="radio" name="viewType" id="viewType" value="<?php echo $v; ?>" required><?php echo $name; ?></label> 
            <a href="javascript:" title="preview :<?php echo $name; ?>" style="margin-left: 10px;" onclick="previewViewType('<?php echo $name; ?>','<?php echo $img; ?>')"><i class="fa fa-eye"></i></a>
           <?php } ?>  
            </div>
          
            <div class="form-group" style="margin-top: 12px; ">
             <input name="host_url" id="host_url"  type="hidden" class="inputFile" />
             <input name="img_urls" id="img_urls"  type="hidden" class="inputFile" />
                      <label for="exampleInputFile" class="control-label col-sm-3">Select Image :</label>
                      <div class="col-sm-5" style="border:0px solid red;">
                           <input type="file" class="inputFile" name="photoimg" id="photoimg" placeholder="select a File"  >
                       		Image Size (45*45) 
                        </div>
                      <div class="col-sm-3" style="border:0px solid red;" id="preview_s"></div>                   
              </div>
              
              
          <div class="modal-footer">
            <div class="pull-left col-sm-7" style="border:0px solid red;">
             <button type="submit" name="save" id="header_content" class="btn btn-primary" >Save Header Menu</button>   
            </div>
            <div align="left" class="pull-right col-sm-5" style="border:0px solid red;">
               <span id="saving_loader"> </span>
            </div>
           </div>  
             

        </form>     
        </div>
       <script type="text/javascript" src="scripts/jquery.form.js"></script>
<script type="text/javascript" >
  $(document).ready(function() { 
  $('#photoimg').on('change', function() {
  if(['image/jpeg', 'image/jpg', 'image/png', 'image/gif','image/jpeg'].indexOf($("#photoimg").get(0).files[0].type) == -1) {
        alert('Error : Only JPEG, PNG & GIF,JPEG allowed');
        $("#photoimg").val('');
        return false;
    }
   var apiBody1 = new FormData($('#imageform')[0]);
   apiBody1.append('data',$('input[type=file]')[0].files[0]);
   apiBody1.append('action','menu_icon');
    $.ajax({
                url:'includes/image_process.php',
                method: 'POST',
                data:apiBody1,
                processData: false,
                contentType: false,
                success: function(r){
                  if(r==1){
                       //alert("yes");
                       ImageProcess(); 
                  }
                  if(r==0){ alert("Error : Image Height should be  45 * 45 pixels."); return false; }
                }
           });
  
  }); 
function ImageProcess(){
   $("#preview_s").html('Uploading.... <img src="img/image_process.gif" alt="Uploading...."/>');
   $('#photoimg').attr('disabled',true);
   var publisher_unique_id="<?php echo $publisher_unique_id ?>";
   var apiURl="<?php  echo $apiURL."/upload" ?>";
   var apiBody = new FormData($('#imageform')[0]);
       apiBody.append("partnerid",publisher_unique_id);
       apiBody.append("tag","menu_icon");
       apiBody.append("fileAction","image");
       apiBody.append('data',$('input[type=file]')[0].files[0]);
      $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                //var len=jsonResult.image_url.length; 
                var HOST_original=jsonResult.image_url[0].HOST
                var URI=jsonResult.image_url[0].URI; 
                var imgShow=HOST_original+URI;
                $("#host_url").val(HOST_original);
                $("#img_urls").val(URI);
                $('#photoimg').attr('disabled',false);
                $('#saveSlider').attr('disabled',false);
                setTimeout(function() {var imgPrev='Preview : <img src="'+imgShow+'" class="img-responsive customer-img" style="background-color: black;" >';
                document.getElementById('preview_s').innerHTML=imgPrev; }, 10000);
                       
                }
            });	
         }
     });
  
 </script>	

        <?php   
        break;    
        case "edit_headercontent":
        $hcid=$_POST['hcid']; $pageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];
        $query1="select * from header_menu where hid='$hcid'";
        $fetch= db_select($conn,$query1);  
        $header_name =$fetch[0]['header_name']; $menu_type =$fetch[0]['menu_type']; 
        $host_url =$fetch[0]['host_url'];  $img_urls =$fetch[0]['img_url']; 
        $view_type =$fetch[0]['view_type'];
        
        ?>   
 
  <div class="modal-body">
         
         <div class="modal-body">
         <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('LegalModal_modal_edit_headerContent','edit_modal_headerContent');" >
         <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
         <h4 class="modal-title" id="myModalLabel"> <b>Edit Header Content  - <?php echo $header_name; ?> </b></h4> 
         </div>
         <br/>
       <div style=" border:1px solid #c7d1dd ;">
       <form class="form-horizontal" role="form" action="javascript:" method="post" id="confirm" onsubmit="return SaveEditHeaderContent('<?php echo $hcid; ?>','<?php echo $pageindex; ?>','<?php echo $limitval;  ?>')">
           
            <div class="row" style="padding-top: 10px;">
        <div id="error_dublicate" class="text-center" style="padding:0 10px 0px 10px;"></div>   
            <div class="col-md-6">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Select Fixed Menu as Menu Header </h3>
                </div>
                <div class="box-body no-padding">
                 <div id="sidebar" class="well sidebar-nav" style="border: 1px solid #c7d1dd; max-height:250px; overflow-y: scroll;"> 
                    <div class="mainNav" style="border: 1px solid #c7d1dd ;">
                    <ul>
                   <?php
                   $que="SELECT header_fixed_mid,name FROM header_fixed_menu WHERE status='2'" ;
                   $row=db_select($conn,$que);
                   foreach ($row as  $cat) {                                    
                   $header_fixed_mid=$cat['header_fixed_mid']; $name=$cat['name'];
                   ?>    
                       <li>
                           <input type="radio" name="menu_value"  id="menu_value" value="<?php  echo $header_fixed_mid."@@".$name; ?>"<?php echo ($name==$header_name)?'checked':'' ?> required>	
                       <a href="javascript:"><?php echo strtoupper($name);?></a>
                       </li>			
                       <?php }?>
                   </ul>
                   </div>
                   </div>
                </div>
              </div>

            
            </div>
            <div class="col-md-6">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Select Category as Menu Header</h3>
                </div>
                <div class="box-body no-padding">
                  <div id="sidebar" class="well sidebar-nav" style="border: 1px solid #c7d1dd; max-height:250px; overflow-y: scroll;"> 
                    <div class="mainNav" style="border: 1px solid #c7d1dd ;">
                    <ul>
                   <?php
                   $que="SELECT category_id,cat_name FROM categories WHERE parent_id='0'" ;
                   $row=db_select($conn,$que);
                   foreach ($row as  $cat) {                                    
                   $category_id=$cat['category_id']; $cat_name=$cat['cat_name'];
                   ?>    
                       <li>
                           <input type="radio" name="menu_value"  id="menu_value" value="<?php  echo $category_id."@@".$cat_name; ?>"<?php echo ($cat_name==$header_name)?'checked':'' ?> required>	
                       <a href="javascript:"><?php echo strtoupper($cat_name);?></a>
                       </li>			
                       <?php }?>
                   </ul>
                   </div>
                   </div>
                </div>
              </div>
             </div>
            
         </div>
           <div class="col-md-12">
              <div class="form-group" style="margin-top: 6px;">
                <label class="control-label col-sm-2">Header Name:</label>
                <div class="col-sm-4">
                   <input type="hidden" class="form-control"  id="catid" name="catid">
                   <input type="text" class="form-control" size="5" maxlength="30" readonly name="m_name" id="m_name"  value="<?php echo $header_name; ?>">
                    <span class="help-block has-error" id="m_name-error" style="color:red;"></span>
                </div>
           <!-- </div> 
             <div class="form-group" style="margin-top: 6px;">-->
                <label class="control-label col-sm-2">Menu Type:</label>
                <div class="col-sm-3">
                   <select name="menu_type" id="menu_type" style="width:200px;">
                      
                        <option value="h"<?php echo $menu_type=='h'? 'selected': ''; ?> >Header Menu</option>
                        <option value="l"<?php echo $menu_type=='l'? 'selected': ''; ?> >Left Menu</option>
                        <option value="f"<?php echo $menu_type=='f'? 'selected': ''; ?> >Footer Menu</option>
                        <option value="r"<?php echo $menu_type=='r'? 'selected': ''; ?> >Right Menu</option>
                    </select>
                  <span class="help-block has-error" id="menu_type-error" style="color:red;"></span>
                </div>
            </div>
            </div>   
             <div class="form-group" style="margin-top: 12px;">
            <label class="control-label col-sm-3 " style="border: 0px solid red;">Select View Type *:</label>
            <?php
            $json=file_get_contents('includes/viewTypeSet.json');
            //print_r($data); 
            $json_data = json_decode($json,true);
            foreach ($json_data as $key => $value) {
                $name=$json_data[$key]["name"];
                $v=$json_data[$key]["value"];
                $img=$json_data[$key]["image"];
                
            ?>
            <label class="radio-inline control-label"> <input type="radio" name="viewType" id="viewType"  <?php echo $view_type==$v ?"checked":"" ?> value="<?php echo $v; ?>" required><?php echo $name; ?></label> 
            <a href="javascript:" title="preview :<?php echo $name; ?>" style="margin-left: 10px;" onclick="previewViewType('<?php echo $name; ?>','<?php echo $img; ?>')"><i class="fa fa-eye"></i></a>
           <?php } ?>  
            </div>
           
           
            <div class="form-group" style="margin-top: 12px; ">
             <input name="host_url" id="host_url"  type="hidden" class="inputFile" />
             <input name="img_urls" id="img_urls"  type="hidden" class="inputFile" />
                      <label for="exampleInputFile" class="control-label col-sm-3">Select Image :</label>
                      <div class="col-sm-5" style="border:0px solid red;">
                          <input type="file" class="inputFile" name="photoimg" id="photoimg"  placeholder="select a File"  >
                       		Image Size (45*45) 
                        </div>
                      <div class="col-sm-3" style="border:0px solid red;" id="preview_s_edit">
                          <?php
                          //$host_url$img_urls
                          if(!empty($host_url))
                          { ?>
                          <img src="<?php echo $host_url.$img_urls ?>" class="img-responsive customer-img" style="background-color: black;">
                          <?php }    
                          ?>
                      </div>                   
              </div>
           
           
               
          <div class="modal-footer">
            <div class="pull-left col-sm-7" style="border:0px solid red;">
             <button type="submit" name="save" id="header_content" class="btn btn-primary" >Update</button>   
            </div>
            <div align="left" class="pull-right col-sm-5" style="border:0px solid red;">
               <span id="saving_loader"> </span>
            </div>
           </div>  
              
          
       </div> 
       </div> 
      <script type="text/javascript" src="scripts/jquery.form.js"></script>
<script type="text/javascript" >
  $(document).ready(function() { 
  $('#photoimg').on('change', function() {
  if(['image/jpeg', 'image/jpg', 'image/png', 'image/gif','image/jpeg'].indexOf($("#photoimg").get(0).files[0].type) == -1) {
        alert('Error : Only JPEG, PNG & GIF,JPEG allowed');
        $("#photoimg").val('');
        return false;
    }
   var apiBody1 = new FormData($('#confirm')[0]);
   apiBody1.append('data',$('input[type=file]')[0].files[0]);
   apiBody1.append('action','menu_icon');
    $.ajax({
                url:'includes/image_process.php',
                method: 'POST',
                data:apiBody1,
                processData: false,
                contentType: false,
                success: function(r){
                  if(r==1){
                       //alert("yes");
                       ImageProcess(); 
                  }
                  if(r==0){ alert("Error : Image Height should be  45 * 45 pixels."); return false; }
                }
           });
  
  }); 
function ImageProcess(){
   $("#preview_s_edit").html('Uploading.... <img src="img/image_process.gif" alt="Uploading...."/>');
   $('#photoimg').attr('disabled',true);
   
   var publisher_unique_id="<?php echo $publisher_unique_id ?>";
   var apiURl="<?php  echo $apiURL."/upload" ?>";
   var apiBody = new FormData($('#confirm')[0]);
       apiBody.append("partnerid",publisher_unique_id);
       apiBody.append("tag","menu_icon");
       apiBody.append("fileAction","image");
       apiBody.append('data',$('input[type=file]')[0].files[0]);
      $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                //var len=jsonResult.image_url.length; 
                var HOST_original=jsonResult.image_url[0].HOST
                var URI=jsonResult.image_url[0].URI; 
                var imgShow=HOST_original+URI;
                $("#host_url").val(HOST_original);
                $("#img_urls").val(URI);
                $('#photoimg').attr('disabled',false);
                $('#saveSlider').attr('disabled',false);
                setTimeout(function() 
                {
                    var imgPrev='Preview : <img src="'+imgShow+'" class="img-responsive customer-img" style="background-color: black;" >';
                    document.getElementById('preview_s_edit').innerHTML=imgPrev; 
                }, 15000);
                       
                }
            });	
         }
     });
  
 </script>	

        <?php 
        break;  
        
    
        
}
?>
<script type="text/javascript">
  $(document).ready(function(){
        $("input[type='radio']").click(function(){
             var radioValue = $("input[name='menu_value']:checked").val();
             if(radioValue=='0'){
                  document.getElementById("catid").value = radioValue;
                  document.getElementById("m_name").value ="";
              }
             if(radioValue!='0'){
                  var catid_name=radioValue.split('@@');
                  var catid=catid_name[0]; var catname=catid_name[1];
                  document.getElementById("catid").value = catid;
                  document.getElementById("m_name").value = catname;
                  document.getElementById("m_name").readOnly = true;
              }
        });
        
    });
</script>

