<?php
include_once 'corefunction.php';
$activid = $_REQUEST['activid'];
$activestatus = $_REQUEST['activestatus'];
$hostname=$_SERVER['HTTP_HOST'];
$query="select uid,user_id,uname,uemail,status,upassword from user_registration where uid='$activid'";
$fetch= db_select($conn,$query);
//$fetch=mysqli_fetch_array($r);
$id=$fetch[0]['uid'];  $name=$fetch[0]['uname']; $email=$fetch[0]['uemail']; $pass=$fetch[0]['upassword'];

//exit;
if($activestatus==0)
{
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
mail($email,$subject,$message,$headers);
$query = "update user_registration set status = 1 where uid='$activid'";
$res =  db_query($conn,$query);	
echo $msg="1"."@".$id;  //active	
/*----------------------------update log file begin-------------------------------------------*/
   $cdate=date('d/m/Y H:i:s');  $action="Active(".$email.")"; $username=$_SESSION['username'];
   write_log($cdate,$action,$username);
    /*----------------------------update log file End---------------------------------------------*/ 
}
	
if($activestatus==1)
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
$query = "update user_registration set status = 0 where uid='$activid'";
$res =  db_query($conn,$query);	 	
echo $msg="0"."@".$id;  // deactive	 

/*----------------------------update log file begin-------------------------------------------*/
   $cdate=date('d/m/Y H:i:s');  $action="deactive(".$email.")"; $username=$_SESSION['username'];
   write_log($cdate,$action,$username);
    /*----------------------------update log file End---------------------------------------------*/ 



}	

//echo $msg;


 
?>
