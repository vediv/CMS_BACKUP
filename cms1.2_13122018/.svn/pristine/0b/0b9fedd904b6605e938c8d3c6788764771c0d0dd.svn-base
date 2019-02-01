<?php
include_once 'corefunction.php';
$userid_dashboard=$get_user_id;
$commanmsg = isset($_GET['val']) ? $_GET['val'] : '';
$confirmalert=$commanmsg!=''? "alert alert-success":"";
$commanmsg_page = isset($_GET['val_page']) ? $_GET['val_page'] : '';
$confirmalert_page=$commanmsg_page!=''? "alert alert-success":"";
$commanmsg_page_content = isset($_GET['val_content']) ? $_GET['val_content'] : '';
$confirmalert_page_content=$commanmsg_page_content!=''? "alert alert-success":"";
if(isset($_POST['save_social'] ))   
{ 
    $social_title=$_POST['social_title']; $social_value=$_POST['social_value']; $device=$_POST['device'];
    if($social_title=='googel_sign_client_id'){ $tag="google"; }
    if($social_title=='googel_ga_view_id'){ $tag="google_ga"; }
    if($social_title=='facebook_app_id'){ $tag="facebook"; }
    $qry="insert into configuration_setup(conf_user_id,conf_title,conf_data,conf_date_added,conf_status,conf_tag,type,device)
            values('$userid_dashboard','$social_title','$social_value',NOW(),'1','$tag','social_setting','$device')";
    $q=db_query($conn,$qry);
    if($q)
   { header("Location:config_setting.php?val=successfully_added_$social_title");  }
}
if(isset($_POST['save_social_page'] ))   
{     
    $social_title_page=$_POST['social_title_page']; $social_url=$_POST['social_url'];
    if($social_title_page=='facebook_page'){ $tag="facebook_page"; }
    if($social_title_page=='google_page'){ $tag="google_page"; }
    if($social_title_page=='twitter_page'){ $tag="twitter_page"; }
    if($social_title_page=='youtube_page'){ $tag="youtube_page"; }
    $qry="insert into configuration_setup(conf_user_id,conf_title,conf_data,conf_date_added,conf_status,conf_tag,type)
            values('$userid_dashboard','$social_title_page','$social_url',NOW(),'1','$tag','social_page')";
    $q=db_query($conn,$qry);
    if($q)
   { header("Location:config_setting.php?val_page=successfully_added_$social_title_page");  }
}

if(isset($_POST['save_content_page'] ))   
{     
    $content_title_page=$_POST['content_title_page']; $page_url=$_POST['page_url'];
    $page_setup_msg=db_quote($conn,$_POST['page_setup_msg']);
    
    /*
    $qry="insert into content_setup(content_user_id,content_title,content_data,content_date_added,content_status,content_url)
    values('$userid_dashboard','$content_title_page',$page_setup_msg,NOW(),'1','$page_url')";
    $q=db_query($conn,$qry);
    if($q)
    { 
      header("Location:config_setting.php?val_content=successfully_added_$content_title_page");  
    }
   */

switch($publisher_unique_id)
{
    case "ott955":
    $clientName='pitaara';
    break; 
    case "ott025":
    $clientName='NA';
    break; 
    case "ott417":
    $clientName='NA';
    break; 
    case "ott488":
    $clientName='adosphere';
    break;  
    case "ott503":
    $clientName='biocine';
    break;
    case "ott182":
    $clientName='powersmart';
    break;
        
}   
    switch($content_title_page)
     {
        case "about_us":
        $f=fopen("../$clientName/pages/about.php","w") or die("Unable to opene file");
        $myfoot = '<style>p{text-align:justify;}</style><div  style="position:fixed;width:100%;z-index:2 "><center><img src="images/pb.png"></center></div>';
        $page_setup_msg="<p>".$_POST['page_setup_msg']."</p>".$myfoot;
        $w=fwrite($f,$page_setup_msg) or die("Unable to write file");
        fclose($f);
        break;

        case "term_and_condition": 
        $f=fopen("../$clientName/pages/terms.php","w") or die("Unable to opene file");
        $w=fwrite($f,$_POST['page_setup_msg']) or die("Unable to write file");
        fclose($f);
        break;

        case "privacy_policy":
        $f=fopen("../$clientName/pages/privacy.php","w") or die("Unable to opene file");
        $w=fwrite($f,$_POST['page_setup_msg']) or die("Unable to write file");
        fclose($f);
        break;

        case "faq":
        $f=fopen("../$clientName/pages/faq.php","w") or die("Unable to opene file");
        $w=fwrite($f,$_POST['page_setup_msg']) or die("Unable to write file");
        fclose($f);
        break;
     
     }
     if($w)
     { 
      header("Location:config_setting.php?val_content=successfully_added_$content_title_page");  
     }
 }   
                        
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo PROJECT_TITLE." | Configuration | Page Setting";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />

</head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
   <?php include_once 'lsidebar.php';?>
        <link href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Configuration & Page Setting</h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
                      <li class="active">Configuration & Page Setting </li>
          </ol>
        </section>
<section class="content">
<div class="row">
<section class="col-lg-7 ">
              <!-- TO DO List -->
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Social Configuration Detail</h3>
                 </div><!-- /.box-header -->
                 <hr style="margin-top: 3px !important">
                 <div class="<?php echo $confirmalert; ?>" style="margin:10px 10px 10px 10px; "><strong><?php echo $commanmsg; ?></strong></div>
                 <form class="form-inline" style="border: 0px solid red; margin-left: 5px;" method="post">
                     <div class="col-sm-12" style="border: 0px solid red;">
                     <label>Choose Device : </label>
                     <label class="radio-inline"><input type="radio" name="device" value="web" required>Web</label>
                     <label class="radio-inline"><input type="radio" name="device" value="android">Android</label>
                     <label class="radio-inline"><input type="radio" name="device" value="iphone">iPhone</label>
                     <label class="radio-inline"><input type="radio" name="device" value="ipad">iPad</label>
                    </div>
                   
                      <div class="form-group">
                       <select class="form-control" required name="social_title" style="padding: 0px 3px;">
                        <option value="">-- Select Title--</option>
                        <option value="googel_sign_client_id">Google Sign in Client ID</option>
                        <option value="googel_ga_view_id">Google GA View ID</option>
                        <option value="facebook_app_id">Facebook APP ID</option>
                        
                      </select>
                    </div>
                    <div class="form-group">
                      <input type="text" style="width: 256px" class="form-control" name="social_value" size="55" placeholder="Enter Client data" required >
                    </div>
                     <?php $disabled_button = (in_array(2, $UserRight) ? "" : "disabled"); ?>
                      <button type="submit" <?php echo $disabled_button; ?> name="save_social"  class="btn btn-default">Save</button>
                      </form> 
                  <hr>
                 
                 <div class="box-body" style="border: 0px solid red;">
                  <?php
                  $q="select * from configuration_setup where type='social_setting' order by conf_id DESC";
                  $ff= db_select($conn,$q);
                  ?>    
                 <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Device</th>
                          <th>Title</th>
                          <th>Key Value</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($ff as $fsocial){
                         $device=$fsocial['device']; $ctitle=$fsocial['conf_title']; $sdata=$fsocial['conf_data']; 
                         $conf_status=$fsocial['conf_status']; $conf_id=$fsocial['conf_id'];
                         if($conf_status==1){ $active="active"; $sclass="label-success";    }
                         else{ $active="inactive"; $sclass="label-danger"; }
                         ?>  
                        <tr>
                          <td><?php echo $device; ?></td>
                          <td><?php echo $ctitle; ?></td>
                          <td><?php echo wordwrap($sdata,7, "\n", true); ?></td>
                          <td id="getstatus<?php  echo $conf_id; ?>"><span id="setlevel<?php  echo $conf_id; ?>" class="label <?php echo $sclass; ?>"><?php echo $active; ?></span></td>
                          <input type="hidden" size="1" id="ad_status<?php echo $conf_id;  ?>" value="<?php echo $conf_status;  ?>" >
                          <td>
                          <?php  if(in_array(4, $UserRight)){ ?> 
                          <a href="#" onclick="delete_social('<?php echo $conf_id;  ?>')"><i class="fa fa-trash-o" ></i></a>
                          <a href="#">
                          <i id="icon_status<?php echo $conf_id; ?>"   class="status-icon fa <?php  echo ($conf_status == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick=social_act_deact('<?php echo $conf_id;  ?>')></i> </a>
                          <?php } ?>
                          </td>
                        </tr>
                        <?php } ?>
                      
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                 </div><!-- /.box-body -->
               
              </div><!-- /.box -->

            </section>
      <section class="col-lg-5 ">
                <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Social Page Detail</h3>
                 </div><!-- /.box-header -->
                 <hr style="margin-top: 3px !important">
                 <div class="<?php echo $confirmalert_page; ?>" style="margin:8% 0px; "><strong><?php echo $commanmsg_page; ?></strong></div>
  

                 <form class="form-inline" style="border: 0px solid red; margin-left: 5px;" method="post">
                     
                      <div class="form-group">
                       <select class="form-control" required name="social_title_page" style="padding: 0px 3px !important;">
                        <option value="">-- Select Social Title--</option>
                        <option value="facebook_page">Facebook Page</option>
                        <option value="google_page">Google Page</option>
                        <option value="twitter_page">Twitter Page</option>
                        <option value="youtube_page">Youtube Page</option>
			<option value="instagram_page">Instagram Page</option>
                        
                      </select> 
                    </div> 
                    <div class="form-group">
                        <input type="url" style="width: 162px !important" class="form-control" name="social_url" size="26" placeholder="Enter page URL" required >
                    </div>
                     <?php $disabled_button = (in_array(2, $UserRight) ? "" : "disabled"); ?>
                      <button type="submit" <?php echo $disabled_button; ?> name="save_social_page" class="btn btn-default">Save</button>
                      </form> 
                  <hr>
                 
                 <div class="box-body" style="border: 0px solid red;">
                  <?php
                  $q="select * from configuration_setup where type='social_page' order by conf_id DESC";
                  $ff= db_select($conn,$q);
                  ?>    
                 <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>URL</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($ff as $fsocial){
                         $socialType=$fsocial['conf_tag']; $ctitle=$fsocial['conf_title']; $sdata=$fsocial['conf_data']; 
                         $conf_status=$fsocial['conf_status']; $conf_id=$fsocial['conf_id'];
                         if($conf_status==1){ $active="active"; $sclass="label-success";    }
                         else{ $active="inactive"; $sclass="label-danger"; }
                         ?>  
                        <tr>
                          
                          <td><?php echo $ctitle; ?></td>
                          <td><?php echo $sdata ?></td>
                          <td id="getstatus<?php  echo $conf_id; ?>"><span id="setlevel<?php  echo $conf_id; ?>" class="label <?php echo $sclass; ?>"><?php echo $active; ?></span></td>
                          <input type="hidden" size="1" id="ad_status<?php echo $conf_id;  ?>" value="<?php echo $conf_status;  ?>" >
                          <td>
                          <?php  if(in_array(4, $UserRight)){ ?> 
                          <a href="#" onclick="delete_social('<?php echo $conf_id;  ?>')"><i class="fa fa-trash-o" ></i></a>
                          <a href="#">
                          <i id="icon_status<?php echo $conf_id; ?>"   class="status-icon fa <?php  echo ($conf_status == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick=social_act_deact('<?php echo $conf_id;  ?>')></i> </a>
                          <?php } ?>
                          </td>
                        </tr>
                        <?php } ?>
                      
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                 </div><!-- /.box-body -->
               
              </div><!-- /.box -->
            
            </section>
    <section class="col-lg-12 ">
            <!-- quick email widget -->
              <div class="box box-primary">
                <div class="box-header">
                  <i class="fa fa-envelope"></i> 
                  <h3 class="box-title">Content Setup (EG :About US | Terms & Conditions | Privacy Policy)</h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <button class="btn btn-primary btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                  </div><!-- /. tools -->
                </div>
                <div class="box-body">
                     <div class="<?php echo $confirmalert_page_content; ?>" style="margin:10px 10px 10px 10px; "><strong><?php echo $commanmsg_page_content; ?></strong></div>
  

                    <form class="form-horizontal" role="form" method="post">
                    <div class="form-group">
                        <div class="col-sm-4">
                           <select class="form-control" required name="content_title_page">
                        <option value="">-- Select Title--</option>
                        <option value="about_us">About US</option>
                        <option value="term_and_condition">Terms & Conditions</option>
                        <option value="privacy_policy">Privacy Policy</option>
                        <option value="faq">FAQ's</option>
                      </select> 
                        </div>
                        <div class="col-sm-6">
                           <input type="url" class="form-control" name="page_url" placeholder="Page url"> 
                        </div>
                    </div>
                    <div>  
                        <textarea class="textarea" placeholder="Place some text here" name="page_setup_msg" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                   <div class="box-footer clearfix">
                       <?php $disabled_button = (in_array(2, $UserRight) ? "" : "disabled"); ?>
                       <button class="pull-left btn btn-default" <?php echo $disabled_button; ?> id="save_content_page" name="save_content_page">Save <i class="fa fa-arrow-circle-right"></i></button>
                </div>       
                      
                 </form>
                
              <div class="box-body" style="border: 0px solid red;">
                  <?php  /*
                   //$qry="insert into content_setup(content_user_id,content_title,content_data,content_date_added,content_status,content_url)    
                  $q="select content_id,content_title,content_status,content_url from content_setup";
                  $ff= db_select($conn,$q); */
                  ?>    
                 <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>URL</th>
                          <th>Preview</th>
                         </tr>
                      </thead>
                      <tbody>
                         
     <tr>
     <td>About Us</td>
     <td>pages/about.php</td>
     <td><a  title="Preview" onclick="page_content_view('about')"><i class="fa fa-eye" ></i></a></td></tr>
      <tr><td>Terms and Conditions</td><td>pages/terms.php</td><td> <a  title="Preview" onclick="page_content_view('terms')"><i class="fa fa-eye" ></i></a></td></tr>
<tr><td>Privacy Policy</td><td>pages/privacy.php</td><td> <a  title="Preview" onclick="page_content_view('privacy')"><i class="fa fa-eye" ></i></a></td></tr>
        <tr><td>FAQs</td><td>pages/faq.php</td><td> <a  title="Preview" onclick="page_content_view('faq')"><i class="fa fa-eye" ></i></a></td></tr>
                        
                      
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                 </div><!-- /.box-body -->
                   
                </div>
                
              </div>
            </section>
          </div>
        
      </div>     
      
 <?php include_once "footer.php"; include_once 'commonJS.php'; ?>
    </div>
<div class="modal fade" id="myModal_view_page" role="dialog" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog modal-lg">
<div class="modal-content" id="show_detail_model_view_page_content" style="text-align:left">

</div>

</div>
    
 </div>    
<script src="dist/js/jquery-ui.min_1.11.2.js" type="text/javascript"></script>
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<script src="dist/js/pages/dashboard.js" type="text/javascript"></script>
<script type="text/javascript">
function social_act_deact(confid){
       var adstatus=document.getElementById('ad_status'+confid).value;
       var msg = (adstatus == 1) ? "inactive":"active";
       var c=confirm("Are you sure you want to "+msg+ " This?")
      if(c)
     {
        $.ajax({
        type: "POST",
        url: "core_active_deactive.php",
        data: 'confid='+confid+'&adstatus='+adstatus+'&action=social_config',
        success: function(re){
          window.location.href="config_setting.php";
   	    }
            }); 
}
}
function delete_social(confid){
var st=document.getElementById('ad_status'+confid).value;
if(st==1) { alert('This configuration is active so you can not delete'); return false;} 
var d=confirm("Are you sure you want to Delete This configuration?");
if(d)
{
       var info = 'confid='+confid+'&action=social_config_delete';
       $.ajax({
       type: "POST",
       url: "coredelete.php",
       data: info,
       success: function(r){
         if(r==1){   window.location.href="config_setting.php"; }
         }
    });  
}    

}

function page_act_deact(contentid){
       var page_status=document.getElementById('page_status'+contentid).value;
       var msg = (page_status == 1) ? "inactive":"active";
       var c=confirm("Are you sure you want to "+msg+ " This?")
      if(c)
     {
        $.ajax({
        type: "POST",
        url: "core_active_deactive.php",
        data: 'contentid='+contentid+'&adstatus='+page_status+'&action=page_content_config',
        success: function(re){
           window.location.href="config_setting.php";
   	    }
            }); 
}
}

function delete_page_content(contentid){
var st=document.getElementById('page_status'+contentid).value;
if(st==1) { alert('This content is active so you can not delete'); return false;} 
var d=confirm("Are you sure you want to Delete This Content?");
if(d)
{
       var info = 'contentid='+contentid+'&action=page_content_delete';
       $.ajax({
       type: "POST",
       url: "coredelete.php",
       data: info,
       success: function(r){
         if(r==1){   window.location.href="config_setting.php"; }
         }
    });  
}    

}
 /* this is for model JS with  view detail */
function page_content_view(contentid)
{
    $("#myModal_view_page").modal();
    var info = 'contentid=' + contentid; 
    $.ajax({
	    type: "POST",
	    url: "page_view_content.php",
	    data: info,
        success: function(result){
        $('#show_detail_model_view_page_content').html(result);
        return false;
        }
 
        });
     return false;    
   
}

</script>  
</body>
</html>


