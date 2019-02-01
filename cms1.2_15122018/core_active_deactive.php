<?php
include_once 'corefunction.php';
$action = $_POST['action'];
switch($action)
{
	 case "menu":
	 $menuid = $_POST['menuid'];
         $adstatus = $_POST['adstatus'];		
	 $adupdateStaus=$adstatus==1?0:1;
	 $sql = "update menus set mstatus='".$adupdateStaus."' where mid='".$menuid."'";
         $r=db_query($conn,$sql);
         /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="Header Menu $adupdateStaus(Menu id:$menuid,Status:$adupdateStaus)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry='';
              write_log($error_level,$msg,$lusername,$qry);
               
         /*----------------------------update log file End---------------------------------------------*/
	 echo $adupdateStaus;
         break;	
        case "plan":
         $planID = $_POST['planid'];
         $adstatus = $_POST['adstatus'];		
	 $adupdateStausplan=$adstatus==1?0:1;
         $adupdateStausplan1=$adstatus==1?"inactive":"active";
	 $sql = "update  plandetail set pstatus='".$adupdateStausplan."' where planID='".$planID."'";
         $re=db_query($conn,$sql);
         
         /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="Plan $adupdateStausplan1(planID:$planID,Status:$adupdateStausplan1)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry='';
              write_log($error_level,$msg,$lusername,$qry);
               
         /*----------------------------update log file End---------------------------------------------*/
        echo $adupdateStausplan;
        break;
        case "userlist":
            $useid = $_POST['useid'];
            $userstatus = $_POST['userstatus'];
            $updateStaususer=$userstatus==1?0:1;
            $sql = "update user_registration set status='".$updateStaususer."' where uid='".$useid."'";
            $resuser=db_query($conn,$sql);
            $adupdate=$userstatus==1?"inactive":"active";
        /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="Register User $adupdate(UserID:$useid,Status:$adupdate)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry='';
              write_log($error_level,$msg,$lusername,$qry);
         /*----------------------------update log file End---------------------------------------------*/
            echo $updateStaususer;
            
        break;    
        case "homesetting":
        $homeID = $_POST['homeid'];
        $tagstatus = $_POST['tagstatus'];
        $adupdateStaushome=$tagstatus==1?0:1;
        $sql = "update  home_title_tag set tag_status='".$adupdateStaushome."' where tags_id='".$homeID."'";
        $reshome=db_query($conn,$sql);
        $adupdateStaushome1=$tagstatus==1?"inactive":"active";
        /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="Home Setting $adupdateStaushome1(HomeID:$homeID,Status:$adupdateStaushome1)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry='';
              write_log($error_level,$msg,$lusername,$qry);
               
         /*----------------------------update log file End---------------------------------------------*/
        echo $adupdateStaushome;
        break;
        case "coupon":
        $coupon_id = $_POST['coupon_id'];
        $status = $_POST['status'];
        $adupdateStatus=$status==1?0:1;
        $sql = "update  coupon set status='".$adupdateStatus."' where coupon_id='".$coupon_id."'";
        $reshome=db_query($conn,$sql);
        $adupdateStatus1=$status==1?"inactive":"active";
        /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="Coupon $adupdateStatus1(Coupan ID:$coupon_id,Status:$adupdateStatus1)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry='';
              write_log($error_level,$msg,$lusername,$qry);
               
         /*----------------------------update log file End---------------------------------------------*/
        echo $adupdateStatus;
        break;
       case "offer":
        $offer_id = $_POST['offer_id'];
        $status = $_POST['status'];
        $adupdateStatus=$status==1?0:1;
        $sql = "update  offers set status='".$adupdateStatus."' where offer_id='".$offer_id."'";
        $reshome=db_query($conn,$sql);
        $adupdateStatus1=$status==1?"inactive":"active";
        /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="Coupon $adupdateStatus1(Offer ID:$offer_id,Status:$adupdateStatus1)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry='';
              write_log($error_level,$msg,$lusername,$qry);
               
         /*----------------------------update log file End---------------------------------------------*/
        echo $adupdateStatus;
        break;
        case "subcription_code":
        $subcid = $_POST['subcid'];
        $status = $_POST['status'];
        $adupdateStatus=$status==1?0:1;
        $sql = "update  subscription_code set status='".$adupdateStatus."' where subcid='".$subcid."'";
        $reshome=db_query($conn,$sql);
        $adupdateStatus1=$status==1?"inactive":"active";
        /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="subscription code $adupdateStatus1(subscription ID:$subcid,Status:$adupdateStatus1)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry='';
              write_log($error_level,$msg,$lusername,$qry);
               
         /*----------------------------update log file End---------------------------------------------*/
        echo $adupdateStatus;
        break; 
        case "giftvoucher":
        $voucher_id = $_POST['voucher_id'];
        $status = $_POST['status'];
        $adupdateStatus=$status==1?0:1;
        $sql = "update voucher set status='".$adupdateStatus."' where voucher_id='".$voucher_id."'";
        $reshome=db_query($conn,$sql);
        $adupdateStatus1=$status==1?"inactive":"active";
        /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="Voucher $adupdateStatus1(Voucher ID:$voucher_id,Status:$adupdateStatus1)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry='';
              write_log($error_level,$msg,$lusername,$qry);
               
         /*----------------------------update log file End---------------------------------------------*/
        echo $adupdateStatus;
        break;
        case "content_partner":
        $contentID = $_POST['contentid'];
        $adstatus = $_POST['adstatus'];
        $adupdateStauscontent=$adstatus==1?0:1;
        $sql = "update  content_partner set status='".$adupdateStauscontent."' where contentpartnerid='".$contentID."'";
        $rescont=db_query($conn,$sql);
        echo $adupdateStauscontent; 
        break;
        case "slider_image":
        $slideID = $_POST['slideid'];
       /* $ss="select ventryid from slider_image_detail where img_id='".$slideID."'"; 
        $rows= db_select($conn,$ss);
        $ventryid=$rows[0]['ventryid'];
        if($ventryid!=''){    
            $sql="select count('$ventryid') as entryCount,video_status from entry where entryid='$ventryid' and status='2'";
            $row= db_select($conn,$sql);
            $entryCount=$row[0]['entryCount']; $video_status=$row[0]['video_status'];
            if($entryCount==0)
            {
                echo 3;
                die();
            } 
            if($entryCount==1 && $video_status=='inactive')
            {
                echo 4;
                die();
            } 
        }*/    
            
        $img_status = $_POST['img_status'];
        $adupdateStausslider=$img_status==1?0:1;
        $sql = "update  slider_image_detail set img_status='".$adupdateStausslider."' where img_id='".$slideID."'";
        $reslide=db_query($conn,$sql);
        $adupdateStausslider1=$img_status==1?"inactive":"active";
        /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="Slider image $adupdateStausslider1(SliderID:$slideID,Status:$adupdateStausslider1)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry='';
              write_log($error_level,$msg,$lusername,$qry);
               
         /*----------------------------update log file End---------------------------------------------*/
        echo $adupdateStausslider;
        break; 
        case "menuheader":
        $headerID = $_POST['headerid'];
        $headerstatus = $_POST['headerstatus'];
        $adupdateStausheader=$headerstatus==1?0:1;
        $adupdateStausMenu=$headerstatus==1?"inactive":"active";
        $sql = "update  header_menu set header_status='".$adupdateStausheader."' where hid='".$headerID."'";
        $reslide=db_query($conn,$sql);
         /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="Header Menu $adupdateStausMenu(HeaderID:$headerID,Status:$adupdateStausMenu)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry='';
              write_log($error_level,$msg,$lusername,$qry);
               
         /*----------------------------update log file End---------------------------------------------*/
        echo $adupdateStausheader;
        break; 
        /*case "youtube_video":
            $entryid = $_POST['entryid'];
            $tag= $_POST['tag'];
            $status=$tag=='active'?'2':'-2';
            $sql = "update entry set status='".$status."' where entryid='".$entryid."'";
            $re=db_query($conn,$sql);
            echo $tag=='active'?'Ready':$tag;
            
        break;*/
        case "youtube_inactive":
         $entryid = $_POST['entryid'];
         $tags = $_POST['tag'];    
         $entrytable = db_query($conn,"update entry set video_status='".$tags."' where entryid='$entryid'");
         echo $tags;
         break;
         case "youtube_active":
         $entryid = $_POST['entryid'];
         $tags = $_POST['tag'];    
         $entrytable = db_query($conn,"update entry set video_status='".$tags."' where entryid='$entryid'");
         echo $tags;
         break; 
    
    
       case "social_config":
            $confid = $_POST['confid'];
            $adstatus = $_POST['adstatus'];
            $updateStaussocial=$adstatus==1?0:1;
            $sql = "update configuration_setup set conf_status='".$updateStaussocial."' where conf_id='".$confid."'";
            $re=db_query($conn,$sql);
            echo $updateStaussocial;
        break;   
       case "page_content_config":
            $contentid = $_POST['contentid'];
            $adstatus = $_POST['adstatus'];
            $updateStauspage=$adstatus==1?0:1;
            echo $sql = "update content_setup set content_status='".$updateStauspage."' where content_id='".$contentid."'";
            $re=db_query($conn,$sql);
            echo $updateStauspage;
        break;   
        case "vod_inactive":
         $entryid = $_POST['entryid'];
         $tags = $_POST['tag'];    
         $entrytable = db_query($conn,"update entry set video_status='".$tags."' where entryid='$entryid'");
         echo $tags;
         break;
         case "vod_active":
         $entryid = $_POST['entryid'];
         $tags = $_POST['tag'];    
         $entrytable = db_query($conn,"update entry set video_status='".$tags."' where entryid='$entryid'");
         echo $tags;
         break;   
         case "vod_bulk_active_inactive":
         $entryid = $_POST['entryid'];
         $tags = $_POST['tag'];
         $entryIDs=  explode(",",$entryid);
         if($tags=="BULK_ACTIVE")
         {
             foreach($entryIDs as $entryids)
             {
                 $entrytable = db_query($conn,"update entry set video_status='active' where entryid='$entryids'");
             } 
            echo 1; 
         }
         if($tags=="BULK_INACTIVE")
         {
             foreach($entryIDs as $entryids)
             {
                 $entrytable = db_query($conn,"update entry set video_status='inactive' where entryid='$entryids'");
             } 
            echo 0; 
         }    
         
         break; 
         case "footercontent":
			$footerID = $_POST['footerid'];
			
			  $fstatus = $_POST['fstatus'];
			$updateStausfooter=$fstatus==1?0:1;
		   if($updateStausfooter==1)
		   {  
		      $inactiveall="update dashbord_footer set f_status='0'"; $resfooter=db_query($conn,$inactiveall); 
		      $upactive="update dashbord_footer set f_status='1' where f_id='".$footerID."'";
		      $resfooter=db_query($conn,$upactive);
		      
		   }
		   if($updateStausfooter==0)
		   {  
		      $upactive="update dashbord_footer set f_status='$updateStausfooter' where f_id='".$footerID."'";
		      $resfooter=db_query($conn,$upactive);
		   }
		  //echo $updateStausfooter; 
		       
 
          break;   
          case "country_currency":
          $ccid = $_POST['ccid'];
          $cc_status = $_POST['cc_status'];
          $adupdateStauscc=$cc_status==1?0:1;
          $adupdateStauscc_n=$cc_status==1?"inactive":"active";
          $sql = "update countries_currency set status='".$adupdateStauscc."' where ccid='".$ccid."'";
          $reslide=db_query($conn,$sql);
         /*----------------------------update log file begin-------------------------------------------*/
            $error_level=1;$msg="Header Menu $adupdateStauscc_n(Country Currency:$ccid,Status:$adupdateStauscc)"; 
            $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
            $qry='';
            write_log($error_level,$msg,$lusername,$qry);
         /*----------------------------update log file End---------------------------------------------*/
          echo $adupdateStauscc;
}
?>

