<?php 
include_once 'corefunction.php';
require 'define.php';
$commonmsg = isset($_GET['val']) ? $_GET['val'] : '';
if($commonmsg=="success")
{ $msgcall="Template Added Successfully";  }
$action= isset($_REQUEST["act"]) ? $_REQUEST["act"] : '';
$name= isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
$tempname="Create"; 
$appname=''; 
 
  if($action=='')
    { 
      $action="create";
      $fildsetname="Create";  
      $submit_button_name='save';
    }
   if($action=="edit")
    { 
      $tempname="Edit";
      $fildsetname="Edit"; $submit_button_name="edit";
        $config_file_path=TEMPLATE_CONFIG_PATH;
        $DBname=DATABASE_Name;
        $new_path = $config_file_path.$DBname."/";
        $f=$new_path.$name;
        $file_handle = fopen($f, "r") or die("Unable to open file!");
        while (!feof($file_handle) ) {

  $line_of_text = fgets($file_handle);
  $parts = explode('=', trim($line_of_text) );
  //echo "<pre>";print_r($parts);echo "</pre>";
  
 switch($parts[0])
  {
  case 'appname':
       $appname = $parts[1];
      break;
  case 'baseurl':
      $baseurl = $parts[1];
      break;
   case 'URLlogin_bgimg':
       $URLlogin_bgimg = $parts[1];
      break;
  case 'URLsplash_bgimg1':
      $URLsplash_bgimg1 = $parts[1];
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
   case 'splash_bgimg1':
      $splash_bgimg1 = $parts[1];
      break;
   
     } 
  } 
   fclose($file_handle);
    }
        
    ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo PROJECT_TITLE." | Create Template";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="bootstrap/color-picker/css/bootstrap-colorpicker.min.css" rel="stylesheet"> 
<style type="text/css">
 
  .file {
     visibility: hidden;
     position: absolute;
  }
.input-lg {
     height: 32px !important;
     padding: 2px 6px !important;
     font-size: 15px !important;
          }
 label { 
    font-weight: normal !important;
        }
legend { 
    width:  auto !important;
    border: 0px solid #333 !important;
    color: #333 !important;
   
   }
   fieldset {
    border: 1px solid #3c8dbc !important;
    margin-top: 15px !important;
    padding-right: 13px !important;
    
}
.box { 
    margin-top: 10px;
    border-radius: 3px !important;
    background: none !important;
    border-top: 2px solid #d2d6de;
    margin-bottom: 0px !important;
    width: 100%;
    box-shadow: 0  0px 0px rgba(0, 0, 0, 0.1) !important;
}
.box-header { 
    padding: 4px !important;
}
.content { 
    padding-top: 0 !important;
   }
    #blah{
  max-width:80px; 
}
    #blah2{
  max-width:80px; 
}
    #blah3{
  max-width:80px; 
}
   #blah4{
  max-width:80px; 
}
 #blah5{
  max-width:80px; 
}
 #blah6{
  max-width:80px; 
}
 #blah7{
  max-width:80px; 
}
input[type="file"] {
    display: inline-block !important;
}

.buttonstyle{

	padding: 5px 10px !important;
			/*background-color:#008000;*/
	
}

hr { 
    border-color: #c7d1dd -moz-use-text-color -moz-use-text-color !important;
    border-image: none;
    border-style: solid none none;
    border-width: 1px 0 0;
    margin-bottom: 20px;
    margin-top: 20px;
}
.box-body {
    background-color: #fff !important;
    border: 1px solid #c7d1dd !important; 
    border-top: 0px solid #c7d1dd !important; 
}
  </style>
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      <?php include_once 'header.php';?>
           <!-- Left side column. contains the logo and sidebar -->
      <?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
 <section class="content-header">
            <h1><?php echo $tempname; ?> Template </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i>Home</a></li>
             <li class="active"><?php echo $tempname; ?> Template</li>
   </ol>
       </section>
          <div class="box box-header" style="border-top: 0px !important">

      <div id="success" style="text-align:center; width:400px; margin-left: 257px"> </div>
        <!-- Main content --> 
        <section class="content" style="border: 0px solid #333; margin-top: 0px; padding-bottom: 55px;">
            <div class="box"> 
           <div class="box-body">
                 <span id="success" style="color:red;"></span>
           	<div style="margin-top: 15px !important;"> 
           	   <legend> Image Category </legend>
           	  <!-- <hr style="color: #c7d1dd !important"></hr>-->
  <form class="form-horizontal form-label-left" > 

                    <div class="form-group">
           		<label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">  Template Name :	</label>
                          <div class="col-md-4 col-sm-4 col-xs-12">
                              <input type="text" title="create template" name="templateName"  id="templateName" value="<?php echo $name; ?>"/>
                              <span id="error" style="color:red;"></span>
           		  </div>
           	    </div>  
                   
           	    <div class="form-group">
           		<label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">  App Title :	</label>
                          <div class="col-md-4 col-sm-4 col-xs-12">
                              <input type="text" title="title" name="appname" id="appname" value="<?php echo $appname; ?>"/>
           		  </div>
           	    </div>  
           	<div class="form-group">
           	 <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Baseurl :	</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" title="title" name="baseurl" id="baseurl" value="<?php echo $baseurl; ?>"/>
           	    </div>
           	</div>
       <form class="form-horizontal form-label-left" role="form" id="imageform1" method="post" enctype="multipart/form-data"> 

             <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Login Background image :</label>
                 <span class="input-group-btn col-md-6 ">
                    <div class="btn btn-default image-preview-input"> 
                        <input type="file" onchange="readURL(this);"   accept="image/png, image/jpeg, image/gif"  name="login_bgimg1"  id="login_bgimg1" value="<?php echo $URLlogin_bgimg; ?>" />
                        <img id="blah" src="<?php echo $URLlogin_bgimg; ?>" alt="" /> 
                <input type="hidden" class="form-control" name="textlogin_bgimg1" id="textlogin_bgimg1"  value="<?php echo $URLlogin_bgimg; ?>">
 
                    </div>
                     <div class="col-lg-6 col-md-6 col-sm-6" id="preview_s"></div>
                 </span>
                </div>  
       </form> 
     <form class="form-horizontal form-label-left" role="form" id="imageform2" method="post" enctype="multipart/form-data"> 

                 <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Splash Background image :</label>
                 <span class="input-group-btn col-md-6 ">
                    <div class="btn btn-default image-preview-input"> 
                        <input type="file" onchange="readURL1(this);"  accept="image/png, image/jpeg, image/gif"  name="splash_bgimg1"  id="splash_bgimg1" value="<?php echo $splash_bgimg1; ?>"  />
                        <input type="hidden" class="form-control" id="textsplash_bgimg1" name="textsplash_bgimg1" value="<?php echo $URLsplash_bgimg1; ?>" >
                       <img id="blah6" src="<?php echo $URLsplash_bgimg1; ?>" alt="" /> 
                    </div>
                     <div class="col-lg-6 col-md-6 col-sm-6" id="preview_s"></div>
                 </span>
                </div> 
          </form> 
     <form class="form-horizontal form-label-left" role="form" id="imageform3" method="post" enctype="multipart/form-data"> 
                   
                      <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Logo :</label>
                 <span class="input-group-btn col-md-6 ">
                    <div class="btn btn-default image-preview-input"> 
                        <input type="file" onchange="readURL2(this);"  accept="image/png, image/jpeg, image/gif"  name="bgimg1"  id="bgimg1"  value="<?php echo $URLbgimg1; ?>" />
                        <input type="hidden" class="form-control" id="textbgimg1" name="textbgimg1"  value="<?php echo $URLbgimg1; ?>">
  
                        <img id="blah7" src="<?php echo $URLbgimg1; ?>"" alt="" /> 
                    </div>
                     <div class="col-lg-6 col-md-6 col-sm-6" id="preview_s"></div>
                 </span>
                </div> 
         
          </form> 
     <form class="form-horizontal form-label-left" role="form" id="imageform4" method="post" enctype="multipart/form-data"> 
                   
                <div class="form-group"> 
                   <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Login_Logo :</label>
                      <span class="input-group-btn col-md-6"> 
                        <div class="btn btn-default image-preview-input"> 
                            <input type="file" onchange="read2URL(this);" accept="image/png, image/jpeg, image/gif" name="login_logo" id="login_logo"  value="<?php echo $URLlogin_logo; ?>" />
                            <input type="hidden" class="form-control"  id="textlogin_logo" name="textlogin_logo"  value="<?php echo $URLlogin_logo; ?>" >
                          <img id="blah2" src="<?php echo $URLlogin_logo; ?>" alt="" />  	
                       </div>
                      </span>
                </div>
          </form> 
     <form class="form-horizontal form-label-left" role="form" id="imageform5" method="post" enctype="multipart/form-data"> 
               <div class="form-group"> 
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">PlaceHolder Image :</label>
                     <span class="input-group-btn col-md-6">
                      <div class="btn btn-default image-preview-input">  
                          <input type='file' onchange="read3URL(this);" accept="image/png, image/jpeg, image/gif" name="placeh_img" id="placeh_img" value="<?php echo $URLplaceh_img; ?>"/>
               <input type="hidden" class="form-control" id="textplaceh_img" name="textplaceh_img" value="<?php echo $URLplaceh_img; ?>">
                        <img id="blah3" src="<?php echo $URLplaceh_img; ?>" alt="" />
                          <!-- rename it -->
                      </div>
                    </span> 
                    </div>    
                       
                 </form> 
     <form class="form-horizontal form-label-left" role="form" id="imageform6" method="post" enctype="multipart/form-data">    
                   <div class="form-group"> 
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Launcher Icon :</label>
                     <span class="input-group-btn col-md-6">
                      <div class="btn btn-default image-preview-input">  
                    	<input type='file' onchange="read5URL(this);" accept="image/png, image/jpeg, image/gif" name="launcher_img" id="launcher_img"  value="<?php echo $URLlauncher_img; ?>" />
             <input type="hidden" class="form-control" id="textlauncher_img" name="textlauncher_img"  value="<?php echo $URLlauncher_img; ?>" >
                        <img id="blah5" src="<?php echo $URLlauncher_img; ?>" alt="" />
                          <!-- rename it -->
                      </div>
                    <!--</span>--> 
                    </div>    
                   
     </form>
                  <div class="form-group"></div>
                </div>        
</form>
<hr></hr>
  <legend> Color Category </legend>
 <form class="form-horizontal form-label-left">    

                <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Thumb background color code  :</label>
               <div class="col-md-3 col-sm-3 col-xs-12">
                 <div class="input-group demo2">
                     <input type="text" value="#2a2d31" class="form-control" name="thumb_bgname" id="thumb_bgname"   />
                   <span class="input-group-addon"><i></i></span>
                 </div>
               </div>

                <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;"> Title barColor code :</label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="input-group demo2">
                    <input type="text" value="#1e2224" class="form-control" name="tit_barcolor_code" id="tit_barcolor_code"/>
                    <span class="input-group-addon"><i></i></span>
                  </div>
                </div>
              </div>
                 <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Background Colour Code :</label>
               <div class="col-md-3 col-sm-3 col-xs-12">
                 <div class="input-group demo2">
                     <input type="text" value="#1e2224" class="form-control" name="bgcolor" id="bgcolor" />
                   <span class="input-group-addon"><i></i></span>
                 </div>
               </div>

                <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Category Color Code:</label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="input-group demo2">
                      <input type="text" value="#2a2d31" class="form-control" name="category_code" id="category_code"/>
                    <span class="input-group-addon"><i></i></span>
                  </div>
                </div>
              </div>
                
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Text Title Color Code :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="input-group demo2">
                  <input type="text" value="#e01ab5" class="form-control" name="txt_title_code" id="txt_title_code" />
                  <span class="input-group-addon"><i></i></span>
                </div>
              </div>

              <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Text Color Code :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="input-group demo2">
                  <input type="text" value="#ffffff" class="form-control" name="textcolor_code"  id="textcolor_code"/>
                  <span class="input-group-addon"><i></i></span>
                </div>
              </div>
            </div>
                
              <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Font Color :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="input-group demo2">
                  <input type="text" value="#e01ab5" class="form-control" name="fontcolor_code" id="fontcolor_code" />
                  <span class="input-group-addon"><i></i></span>
                </div>
              </div>

              <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">  <a href="#" data-toggle="tooltip" title="(back,search,viewAll,like,dislike,share,add,delete)!" style="color: #333">Icon_Color  :	</a></label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="input-group demo2">
                  <input type="text" value="#ffffff" class="form-control" name="icon_color" id="icon_color" />
                  <span class="input-group-addon"><i></i></span>
                </div>
              </div>
            </div>
                
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Menu Color code :	</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="input-group demo2">
                  <input type="text" value="#e01ab5" class="form-control" name="menu_color" id="menu_color" />
                  <span class="input-group-addon"><i></i></span>
                </div>
              </div>

              <label class="control-label col-md-2 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">TabStrip Color :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="input-group demo2">
                  <input type="text" value="#3e4249" class="form-control" name="tabstrip_color" id="tabstrip_color" />
                  <span class="input-group-addon"><i></i></span>
                </div>
              </div>
            </div>
        <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Tab Color :</label>
              <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="input-group demo2">
                  <input type="text" value="#e8323e" class="form-control" name="tab_color"  id="tab_color"/>
                  <span class="input-group-addon"><i></i></span>
                </div>
              </div>
            </div>
       
         <form class="form-horizontal form-label-left" role="form" id="imageform7" method="post" enctype="multipart/form-data">    
        
            <div class="form-group"> 
              <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">Font Files :</label>
               <span class="input-group-btn col-md-6 ">
              <div class="btn btn-default image-preview-input"> 
                  <input type="file" onchange="read4URL(this);" accept="image/png, image/jpeg, image/gif,image/tit" name="font_file" id="font_file"  value="<?php echo $URLfont_file; ?>" /> <!-- rename it -->
                <input type="hidden" class="form-control" id="textfont_file" name="textfont_file"  value="<?php echo $URLfont_file; ?>"  >
                <img id="blah4" src="<?php echo $URLfont_file; ?>" alt=""/>
              </div>
      </span>

          </div>
                
            </form>
             
         </form>

                   <hr />
                    <legend>API Credentials </legend>
     <form class="form-horizontal form-label-left">    

                       	<div class="form-group">
           		    <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">  Username  :	</label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
         	              <input type="text" title="title" name="username" id="username"  value="<?php echo $Username; ?>" />
           		   </div>
                   	</div>
                   	
                   	<div class="form-group">
           		    <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">  Password :	</label>
                   <div class="col-md-4 col-sm-4 col-xs-12">
         	       <input type="password" title="title" name="password" id="password" value="<?php echo $Password; ?>" />
           		   </div>
                	</div>
           	
           	           	<div class="form-group">
           		        <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left !important; padding-left: 30px;">  Partner ID :	</label>
                       <div class="col-md-4 col-sm-4 col-xs-12">
                           <input type="text" readonly title="partner id" name="pass_id" id="pass_id" value="<?php echo PUBLISHER_UNIQUE_ID; ?>"/>
           	          	</div>
                    	</div>
                    	 
                    	                    
                    <div class="form-group col-md-12" style=" margin-top: 20px">
                    	 <div class=" col-md-4"></div>
                    	  <div class=" col-md-4" style="text-align: center;">
 <input type="button" name="<?php echo $submit_button_name; ?>" onclick="createtemplate('<?php echo $action; ?>');"  value="<?php echo $fildsetname; ?>" class="buttonstyle" />
    	
                             <!-- <input type="button"  value="Create Template" onclick="createtemplate('create');"/> -->
                          </div>
                    </div> <div class=" col-md-4"></div>
                    
                  
  
       </form> 
    
 
            </div></div>          
                      
 </section><!-- /.content -->
 </div><!-- /.content-wrapper -->
 </div>
     <?php include_once "footer.php"; include_once 'commonJS.php'; ?>
    <!-- ./wrapper -->
<script src="dist/js/custom.js" type="text/javascript"></script>
<script src="bootstrap/color-picker/js/bootstrap-colorpicker.min.js"></script>
<script type="text/javascript" src="scripts/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({animation: true});   
});

function createtemplate(saction)
{
   
    var templateName = $("#templateName").val(); 
    var appname = $("#appname").val();
    var baseurl = $("#baseurl").val();
    var textfontfile = $("#textfont_file").val();         
    
    var textloginbgimg1 = $("#textlogin_bgimg1").val();
    var textsplashbgimg1 = $("#textsplash_bgimg1").val();
    var textbgimg1= $("#textbgimg1").val();
    var textloginlogo= $("#textlogin_logo").val();
    var textplacehimg= $("#textplaceh_img").val();
    var textlauncherimg= $("#textlauncher_img").val();
      
    var thumbbgname= $("#thumb_bgname").val();
    var titbarcolorcode= $("#tit_barcolor_code").val();
    var txttitlecode= $("#txt_title_code").val();
    var textcolorcode= $("#textcolor_code").val();
    var fontcolorcode= $("#fontcolor_code").val();
      
    var iconcolor= $("#icon_color").val();
    var menucolor= $("#menu_color").val();
    var tabstripcolor= $("#tabstrip_color").val();
    var bgcolor= $("#bgcolor").val();
     var categorycode= $("#category_code").val();
     var tabcolor= $("#tab_color").val();
       
     var username= $("#username").val();
     var password= $("#password").val();
     var passid= $("#pass_id").val();
     var dataString ='act='+saction+'&templateName='+templateName+'&appname='+appname+'&baseurl='+baseurl+'&textfontfile='+textfontfile+'&textloginbgimg1='+textloginbgimg1+"&textsplashbgimg1="+textsplashbgimg1+"&textbgimg1="+textbgimg1+"&textloginlogo="+textloginlogo+"&textplacehimg="+textplacehimg+"&textlauncherimg="+textlauncherimg+"&thumbbgname="+thumbbgname+"&titbarcolorcode="+titbarcolorcode+"&txttitlecode="+ txttitlecode+"&textcolorcode="+textcolorcode+"&fontcolorcode="+fontcolorcode+"&iconcolor="+iconcolor+"&menucolor="+menucolor+"&tabstripcolor="+tabstripcolor+"&bgcolor="+bgcolor+"&categorycode="+categorycode+"&tabcolor="+tabcolor+"&username="+username+"&password="+password+"&passid="+passid;
 $.ajax({                                                                                                                                        
    type: "POST",
    url: "create_temp_images.php",
    data: dataString,
    cache: false,
    success: function(re){
    switch(saction) {
    case "create":
            if(re==3)
            { 
                  $("#error").html("Tempalte Name already exist");
            }
            if(re==1)
            {     
                   $("#success").html("Tempalte created successfully");
                   window.location="createTemplatelist.php?val=success";
            }
        break;
    case "edit":
    if(re==1)
            {     
                 $("#success").html("Tempalte Update successfully");
                  window.location="createTemplatelist.php?vall=update";
            }
        break;
}           
    }
    }); 
}
</script>
<script>
  function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });
</script>

<script>
	     function read2URL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah2').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp2").change(function(){
        readURL(this);
    });
</script>
<script>
	     function read3URL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah3').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp3").change(function(){
        readURL(this);
    });
</script>

<script>
    
	     function read4URL(input) {
        if(input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah4').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp3").change(function(){
        readURL(this);
    });
</script>
<script>
	     function read5URL(input) {
        if(input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah5').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp3").change(function(){
        readURL(this);
    });
</script>

<script>
	     function readURL1(input) {
        if(input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah6').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp3").change(function(){
        readURL(this);
    });
</script>
<script>
	     function readURL2(input) {
        if(input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah7').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp3").change(function(){
        readURL(this);
    });
</script>

<script type="text/javascript" >
 $(document).ready(function() {
     $('#login_bgimg1').on('change',function() {
     var publisher_unique_id="<?php echo $publisher_unique_id ?>";
      var apiURl="<?php  echo $apiURL."/upload" ?>"; 
     var apiBody = new FormData($('#imageform1')[0]);
     apiBody.append("partnerid",publisher_unique_id);
     apiBody.append("tag","template");
     apiBody.append("fileAction","image");
     apiBody.append('data', $('#login_bgimg1')[0].files[0]);
     $.ajax({
            url:apiURl,
            method: 'POST',
            dataType: 'json',
            data:apiBody,
            processData: false,
            contentType: false,
            success: function(jsonResult){
                //alert(jsonResult);
          var HOST_original=jsonResult.image_url[0].HOST;
          var URL_original=jsonResult.image_url[0].URI;
          var imgShow=HOST_original+URL_original;
          console.log(URL_original+"---"+HOST_original);
          $("#textlogin_bgimg1").val(imgShow);
          
                  }
           });
     });
      
     $('#splash_bgimg1').on('change',function() {
     var publisher_unique_id="<?php  echo $publisher_unique_id ?>";
     var apiURl="<?php  echo $apiURL."/upload" ?>";
     var apiBody = new FormData($('#imageform2')[0]);
     apiBody.append("partnerid",publisher_unique_id);
     apiBody.append("tag","template");
     apiBody.append("fileAction","image");
     apiBody.append('data', $('#splash_bgimg1')[0].files[0]);
     $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                var HOST_original=jsonResult.image_url[0].HOST;
                var URL_original=jsonResult.image_url[0].URI;
                var imgShow1=HOST_original+URL_original;
                console.log(URL_original+"---"+HOST_original);
                $("#textsplash_bgimg1").val(imgShow1);
                    }
             });
     });
     
     
     $('#bgimg1').on('change',function() {
     var publisher_unique_id="<?php echo $publisher_unique_id ?>";
     var apiURl="<?php  echo $apiURL."/upload" ?>";
     var apiBody = new FormData($('#imageform3')[0]);
     apiBody.append("partnerid",publisher_unique_id);
     apiBody.append("tag","template");
     apiBody.append("fileAction","image");
     apiBody.append('data', $('#bgimg1')[0].files[0]);
     $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                var HOST_original=jsonResult.image_url[0].HOST;
                var URL_original=jsonResult.image_url[0].URI;
                var imgShow=HOST_original+URL_original;
              console.log(URL_original+"---"+HOST_original);
                $("#textbgimg1").val(imgShow);
                    }
             });
     });

     $('#login_logo').on('change',function() {
     var publisher_unique_id="<?php   echo $publisher_unique_id ?>";
      var apiURl="<?php  echo $apiURL."/upload" ?>";
     var apiBody = new FormData($('#imageform4')[0]);
     apiBody.append("partnerid",publisher_unique_id);
     apiBody.append("tag","template");
     apiBody.append("fileAction","image");
     apiBody.append('data', $('#login_logo')[0].files[0]);
     $.ajax({
                url:apiURl',
                method: 'POST',
                dataType: 'json',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                var HOST_original=jsonResult.image_url[0].HOST;
                var URL_original=jsonResult.image_url[0].URI;
                var imgShow=HOST_original+URL_original;
              console.log(URL_original+"---"+HOST_original);
                $("#textlogin_logo").val(imgShow);
                    }
             });
     });
     

     $('#placeh_img').on('change',function() {
     var publisher_unique_id="<?php  echo $publisher_unique_id ?>";
      var apiURl="<?php  echo $apiURL."/upload" ?>";
     var apiBody = new FormData($('#imageform5')[0]);
     apiBody.append("partnerid",publisher_unique_id);
     apiBody.append("tag","template");
     apiBody.append("fileAction","image");
     apiBody.append('data', $('#placeh_img')[0].files[0]);
     $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                var HOST_original=jsonResult.image_url[0].HOST;
                var URL_original=jsonResult.image_url[0].URI;
                var imgShow=HOST_original+URL_original;
              console.log(URL_original+"---"+HOST_original);
                $("#textplaceh_img").val(imgShow);
                    }
             });
     });
   
     $('#launcher_img').on('change',function() {
     var publisher_unique_id="<?php echo $publisher_unique_id ?>";
      var apiURl="<?php  echo $apiURL."/upload" ?>";
     var apiBody = new FormData($('#imageform6')[0]);
     apiBody.append("partnerid",publisher_unique_id);
     apiBody.append("tag","template");
     apiBody.append("fileAction","image");
     apiBody.append('data', $('#launcher_img')[0].files[0]);
     $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                var HOST_original=jsonResult.image_url[0].HOST;
                var URL_original=jsonResult.image_url[0].URI;
                var imgShow=HOST_original+URL_original;
              console.log(URL_original+"---"+HOST_original);
                $("#textlauncher_img").val(imgShow);
                    }
             });
     });
     
     $('#font_file').on('change',function() {
     var publisher_unique_id="<?php  echo $publisher_unique_id ?>";
       var apiURl="<?php  echo $apiURL."/upload" ?>";
     var apiBody = new FormData($('#imageform7')[0]);
     apiBody.append("partnerid",publisher_unique_id);
     apiBody.append("tag","template");
     apiBody.append("fileAction","image");
     apiBody.append('data', $('#font_file')[0].files[0]);
     $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                var HOST_original=jsonResult.image_url[0].HOST;
                var URL_original=jsonResult.image_url[0].URI;
                var imgShow=HOST_original+URL_original;
              console.log(URL_original+"---"+HOST_original);
                $("#textfont_file").val(imgShow);
                    }
             });
     });
          
 });
</script>

      <!-- End Code    -->

      
      
<script type="text/javascript">
bootbox.alert("<?php echo $msgcall;?>", function() {
 window.location.href='createTemplate.php';
});
</script>
  </body>
</html>


