<?php
include_once 'corefunction.php';
$action = $_POST['action'];
switch($action)
{
	case "active_mail_inactive_mail":
        $userid = $_POST['userid'];
        $adstatus= $_POST['adstatus'];
        //$adupdateStaushome=$tagstatus==1?0:1;
        if($adstatus==0)
        {
            $hostname=$_SERVER['HTTP_HOST'];
            $qu="select uid,user_id,uname,uemail,status,upassword from user_registration where uid='$userid'";
            $f= db_select($conn,$qu);
            $id=$fetch[0]['uid'];  $name=$fetch[0]['uname']; $email=$fetch[0]['uemail']; $pass=$fetch[0]['upassword']; 	
            $subject = "Mycloud Login Detail";
            $headers = "From: mycloud@esselshyam.net\r\n";
            $headers .= "Reply-To: mycloud@esselshyam.net\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $message = '<html><body>';
            $message.='<div style="width:550px; background-color:#CC6600; padding:15px; font-weight:bold;">';
            $message.='Mycloud Login Detail';
            $message.='</div>';
            $message.="<div>Login-id: $email and Password :$pass <br/>";
            //$message.='<div style="font-family: Arial;"><br/>';
            $message.='Please Click Following Link';
            $message.="<a href='http://$hostname/secured/login.php'>Click to Login</a>";
            $message.='</div>';
            $message.='</body></html>';
            //mail($email,$subject,$message,$headers);
            $query1 = "update user_registration set status = 1 where uid='$userid'";
            $res =  db_query($conn,$query1);	
             echo 1;	
            /*----------------------------update log file begin-------------------------------------------*/
              // $cdate=date('d/m/Y H:i:s');  $action="Active(".$email.")"; $username=$_SESSION['username'];
              // write_log($cdate,$action,$username);
            /*----------------------------update log file End---------------------------------------------*/     
        }    
        if($adstatus==1)
        {
        $subject = "Mycloud Detail";
        $headers = "From: mycloud@esselshyam.net\r\n";
        $headers .= "Reply-To: mycloud@esselshyam.net\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $message = '<html><body>';
        $message.='<div style="width:550px; background-color:#CC6600; padding:15px; font-weight:bold;">';
        $message.='Mycloud Login Detail';
        $message.='</div>';
        $message.="<div>";
        $message.= '<h3 style="font-size: 21px; ">Dear User,</h3>';
        $message.='<p style="font-size: 15px; white-space: normal; ">
        On account of security & content hygiene,  we are holding this account till the time you get next notification from us.
        Help us to maintain the portal for every one, for us all our users are important.
        We will miss, see you again !!!</p>';
        $message.='</div>';
        $message.='</body></html>';
        //mail($email,$subject,$message,$headers);
        $query = "update user_registration set status = 0 where uid='$userid'";
        $res =  db_query($conn,$query);	
        echo 0;  

        /*----------------------------update log file begin-------------------------------------------*/
           //$cdate=date('d/m/Y H:i:s');  $action="deactive(".$email.")"; $username=$_SESSION['username'];
           //write_log($cdate,$action,$username);
            /*----------------------------update log file End---------------------------------------------*/ 

    }		
         
        break;	
       
        

	}


?>

