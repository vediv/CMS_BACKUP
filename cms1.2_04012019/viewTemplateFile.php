<?php
include_once 'corefunction.php';
$DBname=DATABASE_Name;
$new_path = TEMPLATE_CONFIG_PATH.$DBname;
$filename=$_REQUEST['filename'];
$fullpath=$new_path."/".$filename;
$file_handle = fopen($fullpath, "r") or die("Unable to open file!");

 while (!feof($file_handle) ) {
  $line_of_text = fgets($file_handle);
 //print_r($line_of_text);
 $parts = explode('=', trim($line_of_text) );
 // echo "<pre>";print_r($parts);echo "</pre>";
   
 
 switch($parts[0])
  { 
  case 'appname':
       $appname = $parts[1];
      break;
  case 'baseurl':
     $baseurl = $parts[1];
      break;
   case 'URLfont_file':
       $URLfont_file = $parts[1];
      break;
  case 'URLlogin_bgimg':
      $URLlogin_bgimg = $parts[1];
      break;
   case 'URLsplash_bgimg1':
       $URLsplash_bgimg1 = $parts[1];
      break;
  case 'splash_bgimg1':
      $splash_bgimg1 = $parts[1];
      break;
   case 'URLbgimg1':
       $URLbgimg1 = $parts[1];
      break;
  case 'URLlogin_logo':
      $URLlogin_logo = $parts[1];
      break;
   case 'URLplaceh_img':
      $URLplaceh_img = $parts[1];
      break;
   case 'URLlauncher_img':
       $URLlauncher_img = $parts[1];
      break;
  case 'Thumb_bg_clr':
      $Thumb_bg_clr = $parts[1];
      break;
   case 'Title_br_clr':
       $Title_br_clr = $parts[1];
      break;
	  case 'Text_tl_clr':
       $Text_tl_clr = $parts[1];
      break;
  case 'Text_clr':
      $Text_clr = $parts[1];
      break;
   case 'Font_clr':
       $Font_clr = $parts[1];
      break;
  case 'Icon_clr':
      $Icon_clr = $parts[1];
      break;
   case 'menu_color':
       $menu_color = $parts[1];
      break;
  case 'tabstrip_color':
      $tabstrip_color = $parts[1];
      break;
   case 'Bg_clr':
       $Bg_clr = $parts[1];
      break;
  case 'Category_clr':
      $Category_clr = $parts[1];
      break;
  case 'Tab_clr':
      $Tab_clr = $parts[1];
      break;
   case 'Username':
       $Username = $parts[1];
      break;
  case 'Password':
      $Password = $parts[1];
      break;
   case 'Partner_Id':
      $Partner_Id = $parts[1];
      break; 
     } 
  }  
 fclose($file_handle);
?>
<style>
	.col-md-4{
		min-height: 44px;
	}
</style>
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Publisher detail for <strong>   </h4>
      </div>
    <div class="modal-body" >
        <div class="box">
             <!-- /.box-header -->
         <!--- <div class="box-body" id="inner-content-div" style="border: 0px solid red; overflow-x: hidden; overflow-y: auto; ">
     <div class="row" >  </div>          
     </div>------------>
     
      <div class="">
 
           

     
        <!-- Main content --> 
       
           	<fieldset style="margin-top: 15px !important;"> 
 <form class="form-horizontal form-label-left">    

                <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;">appname :</label>
               <div class="col-md-3 col-sm-3 col-xs-12">
                   <?php echo $appname; ?>
               </div>

                <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important;"> Baseurl :</label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                 <?php echo $baseurl; ?>
                </div>
              </div>
                 <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; ">URLfont_file:</label>
               <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $URLfont_file; ?>
               </div>

                <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important; ">URLlogin_bgimg:</label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                 <?php echo $URLlogin_bgimg; ?>
                </div>
              </div>
                
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;">URLsplash_bgimg1 :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
               <?php echo $URLsplash_bgimg1; ?>
              </div>

              <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important;">splash_bgimg1 :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
               <?php echo $splash_bgimg1; ?>
              </div>
            </div>
                
              <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; ">URLbgimg1 :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $URLbgimg1; ?>
              </div>

            
              
            </div>
                
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;">URLlogin_logo :	</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $URLlogin_logo ; ?>
              </div>

              <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important;">URLplaceh_img :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
               <?php echo $URLplaceh_img; ?>
              </div>
            </div>
          <div  class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;">URLlauncher_img :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $URLlauncher_img; ?>
              </div>
              <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important;">Thumb_bg_clr :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
              <?php echo $Thumb_bg_clr; ?>
              </div>
            </div>    
             <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;">Title_br_clr :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
               <?php echo $Title_br_clr; ?>
              </div>
              <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important;">Text_tl_clr :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $Text_tl_clr; ?>
              </div>
            </div>    
             <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;">Text_clr :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
             <?php echo $Text_clr; ?>
              </div>
              <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important;">Font_clr :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $Font_clr; ?>
              </div>
            </div>    
            
            <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;">Icon_clr :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
               <?php echo $Icon_clr; ?>
              </div>
              <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important; ">menu_color :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $menu_color; ?>
              </div>
            </div>    
            
            <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;">tabstrip_color :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
               <?php echo $tabstrip_color; ?>
              </div>
              <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important;">Bg_clr :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $Bg_clr; ?>
              </div>
            </div>    
            
            <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important;">Category_clr :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
               <?php echo $Category_clr; ?>
              </div>
              <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important;">Tab_clr :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
               <?php echo $Tab_clr; ?>
              </div>
            </div>      
            <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; ">Username :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <?php echo $Username; ?>
              </div>
              <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important;">Password :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
               <?php echo $Password; ?>
              </div>
              </div>
               <div class="form-group">
               <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important;">Partner_Id :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
              <?php echo $Partner_Id; ?>
              </div>
            </div>      
            </fieldset>
         </form> 
    </div>
      
     
     
  </div>
</div>             

