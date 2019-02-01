<?php
include_once 'corefunction.php';
$msg = isset($_GET['val']) ? $_GET['val'] : '';
switch($msg)
{
    case "Successfully_added":
       $flashMsg="Successfully added"; 
    break; 
   case "Ticker_Activated":
       $flashMsg="Ticker Activated ...";  
    break; 
  case "Ticker_deleted":
        $flashMsg="<span class='text-danger'>Ticker deleted ...</span>";
    break; 
 case "Ticker_deactivated":
        $flashMsg="Ticker deactivated ...";
    break; 
   case "Error_occured":
      $flashMsg="<span class='text-danger'>Error occured..</span>"; 
    break;
   

}
if(isset($_REQUEST['t_deactivate']))
{
  $id=$_REQUEST['ticker_id'];
  $sql="update content_setup set content_status=0 where content_id='$id'";
  $r = db_query($conn,$sql);
  if($r)
  header("Location:ticker_config.php?val=Ticker_deactivated");
  else
  header("Location:ticker_config.php?val=Error_occured");

}

if(isset($_REQUEST['t_activate']))
{
  $id=$_REQUEST['ticker_id'];
  $sql="update content_setup set content_status=0 where content_title='ticker'";
  db_query($conn,$sql);
  $sql="update content_setup set content_status=1 where content_id='$id'";
  $r = db_query($conn,$sql);
  if($r)
   header("Location:ticker_config.php?val=Ticker_Activated");
  else
  header("Location:ticker_config.php?val=Error_occured");

}

if(isset($_REQUEST['t_delete']))
{
  $id=$_REQUEST['ticker_id'];
  $sql="delete from content_setup where content_id='$id'";
  $r = db_query($conn,$sql);
  if($r)
   header("Location:ticker_config.php?val=Ticker_deleted");
   else
   header("Location:ticker_config.php?val=Error_occured");

}




if(isset($_POST['ticker_save'])) 
{   
       extract($_POST);
       $t_text1=  db_quote_new($conn, $t_text);
       $Data=array("t_text"=>$t_text,"t_bg"=>$t_bg,"t_fg"=>$t_fg,"t_fweight"=>$t_fweight,"t_fsize"=>$t_fsize,"t_behav"=>$t_behav,"t_dir"=>$t_dir,"t_speed"=>$t_speed,"tLoop"=>$tLoop);
       $tickerData1=  json_encode($Data);
       $tickerData=  db_quote_new($conn, $tickerData1);
       $ticker_config="insert into content_setup(content_user_id, content_title, content_data, content_date_added,content_status,content_url,content_text) values('$get_user_id','ticker','$tickerData',now(),0,'','$t_text1')";
       $r = db_query($conn,$ticker_config);
       if($r)
       { 
          
           //$flashMsg="Successfully added";
          header("Location:ticker_config.php?val=Successfully_added");
        }
     else
     {
          //$flashMsg="<span class='text-danger'>Error occured..</span>";
         header("Location:ticker_config.php?val=Error_occured");
        
     }
         
 }
     
function getTickerList()
{
   global $conn;
   $sql="select * from content_setup where content_title='ticker'";
   $res=db_select($conn,$sql);
   
   //print '<pre>'.print_r($res, true).'</pre>';
   return $res;
}
    
    

                        
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo ucwords(PROJECT_TITLE)." | Ticker Config";?></title>
  <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td
{border-top: 0px solid #f4f4f4 !important;}
.padng1{padding-left: 21%}
   	.card {    border-radius: 4px;    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(63, 63, 68, 0.1); background-color: #FFFFFF; margin: 10px;}
.card .header {    padding: 5px 5px 0;}
.btn-info{background-color: #337ab7 !important}
h4, .title{	color:#337ab7 !important; }
.content {min-height: 209px !important}
hr{
	margin: 0px !important;
}
.pre_new {
  font-size: 13px !important; color: #333 !important; background: none !important;
}
 </style>

  </head>
  <body class="skin-blue" >
    <div class="wrapper">
      <?php include_once 'header.php';
      include_once 'lsidebar.php';?>
    
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="min-height: 700px !important;">
        <section class="content-header">
          <h1>Ticker Configuration
          <!-- <small><span style="color:#3290D4" class="glyphicon glyphicon-plus " ></span></small>-->
          </h1> 
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
                     <li class="active">Ticker Configuration</li>
          </ol>          
         </section>
         
         <section class="content">
         	<div class="box">
         	<div class="box-header">
                        <div class="card" style="margin-left: 0px !important">
                             <div class="header" style="background: #D2D6DE">
                                <h4 class="title">New Ticker</h4><hr />
                                <p class="category"></p>
                            </div>
                           
  

<div class="content">
<div class="row"> 
<div class="col-md-12">

<form action="" name="t_form" method="post" onsubmit="return validateTicker()">
                                    <div class="col-sm-8">
                                     <p id="t_resp" style="padding:5px;color:red;">&nbsp</p>   
                                        <table class="table">
                                            <tr><td ><h5>Ticker Text:</h5></td><td colspan=3>
                                            <input type="text"  name="t_text" class="form-control">
                                            </td></tr>
 <!--<tr>
     <td><h5>Ticker URL</h5></td><td colspan=3>
      <input type="url" placeholder="http://YourDomainName/config/infobar.php" title="http://YourDomainName/config/infobar.php" required name="t_url" class="form-control">
     </td></tr>-->
                                          <tr>
                                                <td width="25%"><h5>Ticker Background:</h5></td><td width="25%"><input type="color" value="#FFA500"  name="t_bg" class="form-control"></td>
                                                <td width="25%"><h5 class="padng1">Ticker TextColor:</h5></td><td width="25%"><input type="color" value="#ffffff"  name="t_fg" class="form-control"></td>
                                            </tr>
                                                
                                            <tr>
                                                <td width="25%"><h5>Ticker FontSize:</h5></td><td width="25%"><input type="text" maxlength=2 value="14" name="t_fsize" class="form-control"></td>
                                                <td width="25%"><h5 class="padng1">Ticker FontWeight:</h5></td><td width="25%"><select name="t_fweight" class="form-control"><option>Bold</option><option>Normal</option></select></td>
                                            </tr>
                                                
                                                
                                            <tr>
                                                <td width="25%"><h5>Ticker Behavior:</h5></td><td width="25%"><select name="t_behav" class="form-control"><option>Scroll</option><option>Slide</option><option>Alternate</option></select></td>
                                                <td width="25%"><h5 class="padng1">Ticker direction:</h5></td><td width="25%"><select name="t_dir" class="form-control"><option>Left</option><option>Right</option></select></td>
                                            </tr>
                                                
                                            <tr>
                                                <td width="25%"><h5>Ticker Speed:</h5></td><td width="25%"><input type="text" value="1" maxlength=2 name="t_speed" class="form-control"></td>
                                                <td width="25%"><h5 class="padng1">Ticker Loop:</h5></td><td width="25%"><input type="text" value="0" maxlength=3 name="t_loop" class="form-control"></td>
                                            </tr>
                                                
                                                
                                        </table>                          
                                    </div>
                                        
                                        
                                    <div class="col-sm-4">
                                        <table width="100%"  >
                                            <tr><td style="border-bottom:1px solid #EEEEEE"><h6 style="padding-top:10px">Preview
                                                        <a herf="" id="tricker_preview" >
                                                            <i class="fa fa-eye" aria-hidden="true" style="cursor: pointer;"></i>
</a></h6></td></tr>
                                            <tr><td id="t_preview" height=186></td></tr>
                                            <tr><td><button type="submit"  name="ticker_save" class="btn btn-sm btn-info">Create Ticker</button></td></tr>
                                        </table>
                                    </div>
                                </form>
 

                         
                          
</div>

                        
  </div>
</div></div>
<div class="card" style="margin-left: 0px;"> 
        <div class="header" style="background: #D2D6DE">
               <h4 class="title"> Ticker List</h4><hr />
               <p class="category"></p>
       </div>
    
                                    <h4 class="text-center">
                                      <?php if(isset($flashMsg)) echo $flashMsg;?>
                                          
                                    </h4>
                                    <table class="table" style="border: 0px !important; border-top: 0px !important">
                                     <?php 
                                      $data=getTickerList();
                                      $len=count($data);
                                      for($i=0;$i<$len;$i++)
                                      {
                                        $id=$data[$i]["content_id"];
                                        $status=$data[$i]["content_status"];
                                        $text=$data[$i]["content_text"];
                                        $t_data=json_decode($data[$i]["content_data"],true); 
                                         //print '<pre>'.print_r($t_data, true).'</pre>';
                                          $bg=$t_data['t_bg'];
                                          $fg=$t_data['t_fg'];
                                          $font=$t_data['t_fsize'];
                                          $fontW=$t_data['t_fweight'];
                                          $tBehav=$t_data['t_behav'];
                                          $tDir=$t_data['t_dir'];
                                          $tLoop=$t_data['t_loop'];
                                          $tSpeed=$t_data['t_speed'];
                                         // $text=$t_data['t_text'];
                                          if($status==1) {
                                              $disable='disabled';
                                             $btn='<button type="submit" name="t_deactivate" class="btn btn-success btn-xs" title="Status: Active">Deactivate</button>';            
                                          }
                                             else {
                                             $disable='';    
                                             $btn='<button type="submit" name="t_activate" class="btn btn-default btn-xs">Activate</button>';            
                                             }          
                                                        
                $ticker='<div style=" background:'.$bg.';color: '.$fg.';font-size: '.$font.'px;padding:5px;font-weight: '.$fontW.'">';
                $ticker.='<marquee behavior="'.$tBehav.'" direction="'.$tDir.'" truespeed="1" loop="'.$tLoop.'" scrollamount="'.$tSpeed.'" >';
                $ticker.="<span><pre class='pre_new' style='font-size: $font !important; color: $fg !important; font-weight: $fontW  !important; background: none !important; border:0px !important; margin: 0 0 0px !important;padding: 0px !important; '>$text</pre></span>"; 
               $ticker.='</marquee></div>';

      echo '<form method=post><tr style="border:0px !important;"><input type="hidden" name="ticker_id" value="'.$id.'"><td width="90%">'.$ticker.'</td><td><button type="submit" '.$disable.'  name="t_delete" class="btn btn-default btn-xs"><i class="fa fa-trash"></button></td><td>'.$btn.'</td></tr></form>';
                                      }
                                          
                                          
                                      ?>
                                    </table>
                             

</div>
                        
                        </div>
</section>
</div><!-- /.content-wrapper -->
    
         <?php 
include_once "footer.php"; 
include_once 'commonJS.php';  
?>
</div><!-- ./wrapper -->

 <script type="text/javascript">
           document.getElementById("tricker_preview").addEventListener("click", tikerPreview);
            $('input[type=text]').blur(function(){
            $(this).val($.trim($(this).val().replace(/\t+/g,' ')));
            });
            function tikerPreview()
            {
                if(!validateTicker())return false;
                var text=document.getElementsByName("t_text")[0].value; text=(text=="")?"Enter Ticker Text":text;
                var bg=document.getElementsByName("t_bg")[0].value;
                var fg=document.getElementsByName("t_fg")[0].value;
                var fontW=document.getElementsByName("t_fweight")[0].value;
                var font=document.getElementsByName("t_fsize")[0].value;
                var tBehav=document.getElementsByName("t_behav")[0].value;
                var tDir=document.getElementsByName("t_dir")[0].value;
                var tSpeed=document.getElementsByName("t_speed")[0].value;
                var tLoop=document.getElementsByName("t_loop")[0].value;
                var html='<div style="width: 99.9%; background:'+bg+';color: '+fg+';font-size: '+font+'px;padding:5px;font-weight: '+fontW+';">';
                html+='<marquee behavior="'+tBehav+'" direction="'+tDir+'" truespeed="1" loop="'+tLoop+'" scrollamount="'+tSpeed+'" >';
                html+='<span><pre style="font-size: '+font+'px !important; color: '+fg+' !important; background: none !important; border:0px !important; margin: 0 0 0px !important;padding: 0px !important; ">'+text+'</pre></span>'; 
                html+='</marquee></div>';
                document.getElementById("t_preview").innerHTML=html;
                
            }
            function validateTicker()
            {
                 var container=document.getElementById("t_resp");
                 var text=document.getElementsByName("t_text")[0].value;
                 var font=document.getElementsByName("t_fsize")[0].value;
                 var tSpeed=document.getElementsByName("t_speed")[0].value;
                 var tLoop=document.getElementsByName("t_loop")[0].value;
                 container.innerHTML="&nbsp;";
                 //var txtPat=/^[_A-Za-z0-9-\\+][\S\s]{2,3000}$/;
                 var numpat=/^[0-9]{1,}$/;
           
                  if(text=='')   
                 {container.innerHTML="Ticker text should not be Blank ."; return false;  }

                  else if(!font.match(numpat) || font<10 || font>30)
                  {container.innerHTML="Font should be 10px to 30px"; return false;  }
                  
                  else if(!tSpeed.match(numpat) || tSpeed<=0 || tSpeed>10 )
                  {container.innerHTML="Ticker Speed should be 0 to 10"; return false;  }
               
                  else if(!tLoop.match(numpat) || tLoop<0 )
                  {container.innerHTML="Ticker Speed should be a valid number. Enter 0 for infinite loop."; return false;  }


                  else
                  return true;

            }

           /* function initTicker()
            {
                alert("yes");
                el=document.forms[0].elements;
                var len=el.length;
                for(var i=0;i<len-1;i++)
                {
                    el[i].addEventListener("change",tikerPreview);
                }
            }
            */
            
        </script>
                  
     </body>
</html>
