<?php
include_once 'corefunction.php';
$action = $_POST['action'];
switch($action)
{
    case "menu_delete":
	 $menuid = $_POST['menuid'];
         $sqlh = "delete from menus where mid='".$menuid."'";
         $r=db_query($conn,$sqlh);
         deleteLog("Menu",$menuid,$sqlh);
	 echo 1;
    break; 
    case "plan_delete":
	 $pid = $_POST['pid'];
         $sqlh = "delete from plandetail where planID='".$pid."'";
         $r=db_query($conn,$sqlh);
         deleteLog("Plan",$pid,$sqlh);
	 echo 1;
    break; 
    case "home_tag_delete":
	 $tagsid = $_POST['tagsid'];
         $priority = $_POST['priority'];
         $sqlh = "delete from home_title_tag where tags_id='".$tagsid."'";
         $r=db_query($conn,$sqlh);
         $upPri="update home_title_tag set priority=(priority-1) where priority>='".$priority."'";
         $rr=db_query($conn,$upPri);
         deleteLog("HomeSettingTag",$tagsid,$sqlh);
	 echo 1;
    break;
    case "slider_img_delete":
	 $sliderid = $_POST['sliderid']; $priority=$_POST['priority'];
         $sqlh = "delete from slider_image_detail where img_id='".$sliderid."'";
         $r=db_query($conn,$sqlh);
         $upPri="update slider_image_detail set priority=(priority-1) where priority>='".$priority."'";
         $rr=db_query($conn,$upPri);
         deleteLog("slider Image",$sliderid,$sqlh);
         
	 echo 1;
    break;
    case "content_part_delete":
         $contentID=$_POST['cpid']; 
 	 $sqlh = "DELETE FROM content_partner WHERE contentpartnerid='$contentID'";
         $r=db_query($conn,$sqlh);
         deleteLog("Content Partner",$contentID,$sqlh);
         echo 1;
    break;
 case "menu_header_delete":
         $headerID=$_POST['hid']; 
 	 $sqlh = "DELETE FROM header_menu WHERE hid='$headerID'";
         $r=db_query($conn,$sqlh);
         deleteLog("Menu Header",$headerID,$sqlh);
         echo 1;
    break;
case "social_config_delete":
         $confid=$_POST['confid']; 
 	 $sqlh = "DELETE FROM configuration_setup WHERE conf_id='".$confid."'";
         $r=db_query($conn,$sqlh);
          deleteLog("Social Config ",$confid,$sqlh);
         echo 1;
    break;
case "page_content_delete":
         $contentid=$_POST['contentid']; 
 	 $sqlc = "DELETE FROM content_setup WHERE content_id='".$contentid."'";
         $r=db_query($conn,$sqlc);
          deleteLog("Page Content",$contentid,$sqlc);
         echo 1;
    break;
case "footer_delete":
         $ftcid=$_POST['ftcid']; 
 	 $sqlf = "DELETE FROM dashbord_footer WHERE f_id='".$ftcid."'";
         $r=db_query($conn,$sqlf);
          deleteLog("Footer Content",$ftcid,$sqlf);
         echo 1;
    break;	
 case "user_list_delete":
         $usersid=$_POST['usersid']; 
 	 $sqlu = "DELETE FROM user_registration WHERE uid='".$usersid."'";
         $r=db_query($conn,$sqlu);
         deleteLog("User List",$usersid,$sqlu);
         echo 1;
  break;
   case "popup_img_delete":
	 $popup_imge_id = $_POST['popup_imge_id']; 
         $sqlh = "delete from popup_images where popup_imge_id='".$popup_imge_id."'";
         $r=db_query($conn,$sqlh);
         deleteLog("PopUp Image",$popup_imge_id,$sqlh);
        echo 1;
    break;
   case "coupon_delete":
	 $coupon_id = $_POST['coupon_id']; 
         $delCoupon = "delete from coupon where coupon_id='".$coupon_id."'";
         $r=db_query($conn,$delCoupon);
         $delCouponVideo = "delete from coupon_video where coupon_id='".$coupon_id."'";
         $r=db_query($conn,$delCouponVideo);
         $delCouponCategory = "delete from coupon_category where coupon_id='".$coupon_id."'";
         $r=db_query($conn,$delCouponCategory);
         //$delCouponHistory = "delete from coupon_history where coupon_id='".coupon_id."'";
         //$r=db_query($conn,$delCouponHistory);
         deleteLog("Coupon Delete",$coupon_id,$delCoupon);
        echo 1;
    break;
    case "giftvoucher_delete":
	 $voucher_id = $_POST['voucher_id']; 
         $sqlv = "delete from voucher where voucher_id='".$voucher_id."'";
         $r=db_query($conn,$sqlv);
         deleteLog("Voucher Delete",$voucher_id,$sqlv);
    echo 1;
    case "offer_delete":
	 $offer_id = $_POST['offer_id']; 
         $sqlv = "update offers set status=3 where offer_id='".$offer_id."'";
         $r=db_query($conn,$sqlv);
         deleteLog("Offer Delete",$offer_id,$sqlv);
    echo 1;
    case "subcription_code_delete":
	 $subcid = $_POST['subcid']; 
         $sqlv = "update subscription_code set status=3 where subcid='".$subcid."'";
         $r=db_query($conn,$sqlv);
         deleteLog("subscription code delete",$offer_id,$sqlv);
    echo 1;
    break;
	 

}
function deleteLog($name,$delid,$qry)
{
    /*----------------------------update log file begin-------------------------------------------*/
    $error_level=1;$msg="Delete $name ($delid)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
    write_log($error_level,$msg,$lusername,$qry);
    /*----------------------------update log file End---------------------------------------------*/   
     
}
?>


