<?php 
include_once 'corefunction.php';
$userid_dashboard=$get_user_id;
$publisher_unique_id;
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

$contentid = $_POST['contentid'];
switch($contentid)
{
 case "about":
 $content_title="About Us";
 
$file = fopen("../$clientName/pages/about.php","r");
$content_data=fread($file,filesize("../$clientName/pages/about.php")+1);
fclose($file);

 break;

case "terms":
 $content_title="Terms and Conditions";
 
$file = fopen("../$clientName/pages/terms.php","r");
$content_data=fread($file,filesize("../$clientName/pages/terms.php")+1);
fclose($file);

 break;

case "privacy":
 $content_title="Privacy Policy";
$file = fopen("../$clientName/pages/privacy.php","r");
$content_data=fread($file,filesize("../$clientName/pages/privacy.php")+1);
fclose($file);

 break;


case "faq":
$content_title="FAQs";
$file = fopen("../$clientName/pages/faq.php","r");
$content_data=fread($file,filesize("../$clientName/pages/faq.php")+1);
fclose($file);
 break;


}



?>	   

<style>
	.col-md-4{
		min-height: 44px;
	}
</style>
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Preview for <strong><?php echo $content_title; ?></strong> Page. </h4>
      </div>
    <div class="modal-body" >
        <div class="box">
             <!-- /.box-header -->
          <div class="box-body"  style="border: 0px solid red; overflow-x: hidden; overflow-y: auto; ">
              <pre>
              <?php echo $content_data; ?>         

              </pre>
   
  
        
          </div>
  </div>
</div>             

