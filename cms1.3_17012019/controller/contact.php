<?php
include_once '../auths.php'; 
require_once('../includes/class.phpmailer.php');
$FromID=$_POST['from_store_id']; $input_to=$_POST['input-to']; $input_message=$_POST['input-message'];
$subject=$_POST['subject'];
$page=isset($_GET['page'])?$_GET['page']:1;
$limit=10;
$email_total = 0; $emails = array(); $json = array();
switch($input_to)
{
    case "all_active_user":
    $customer_data = array(
            'active_customer' => 1,
            'start'             => ($page - 1) * $limit,
            'limit'             => $limit
    );
    include 'customer.php';    
    $email_total = getTotalActiveCustomers($customer_data);
    $results = getActiveCustomers($customer_data);
    foreach ($results as $result) {
       $emails[] = $result['uemail'];
    }
    break;
    case "all_inactive_user":
    $customer_data = array(
            'active_customer' => 0,
            'start'             => ($page - 1) * $limit,
            'limit'             => $limit
    );
    include 'customer.php';    
    $email_total = getTotalActiveCustomers($customer_data);
    $results = getActiveCustomers($customer_data);
    foreach ($results as $result) {
       $emails[] = $result['uemail'];
    }
    break;
    case "all_subscriber_user":
    $customer_data = array(
            //'active_customer' => 1,
            'start'             => ($page - 1) * $limit,
            'limit'             => $limit
    );
    include 'customer.php';    
    $email_total = getTotalSubcriberUser($customer_data);
    $results = getSubcriberUser($customer_data);
    foreach ($results as $result) {
       $emails[] = $result['uemail'];
    }
    break;
    case "singleEmail":
    include 'customer.php';     
    $UserEmail=isset($_POST['singleEmail'])?$_POST['singleEmail']:'';
    $emails[] = $UserEmail;
    break;    
      
}
/* FOR debug testing */
//$json['success'] =print_r($results)."--".$email_total; 
//echo (json_encode($json));
//exit;
if ($emails) {
$geTSMTP = getSmtpCredential();
$ClientHost=$geTSMTP[0]['smtp_server'];$ClientUsername=$geTSMTP[0]['client_email'];
$ClientPassword=$geTSMTP[0]['mail_pass'];$ClientPort=$geTSMTP[0]['port'];
$json['success'] = "Your message has been successfully sent!";
$start = ($page - 1) * $limit;
$end = $start + $limit;
//$json['success'] = "Your message has been successfully sent to $start of $email_total recipients!";
$json['success'] = "Your message has been successfully sent !";
if ($end < $email_total) {
        $json['next']="controller/contact.php?page=".($page + 1);
    } else {
        $json['next'] = '';
    }
    $message  = '<html dir="ltr" lang="en">' . "\n";
    $message .= '  <head>' . "\n";
    $message .= '    <title>' . $subject . '</title>' . "\n";
    $message .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
    $message .= '  </head>' . "\n";
    $message .= '  <body>' . html_entity_decode($input_message, ENT_QUOTES, 'UTF-8') . '</body>' . "\n";
    $message .= '</html>' . "\n";
    
    foreach ($emails as $email) {  //continue;
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
             $mail    = new PHPMailer();
            //$body                = file_get_contents('contents.html');
            //$body                = "tesing mail from san";
            //$body                = eregi_replace("[\]",'',$message);
            $mail->IsSMTP(); // telling the class to use SMTP
            $mail->Host          = $ClientHost;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Port = $ClientPort;                    // set the SMTP port for the GMAIL server
            $mail->Username  = $ClientUsername; // SMTP account username
            $mail->Password= "$ClientPassword";        // SMTP account password
            $mail->SetFrom($FromID);
            $mail->Subject= $subject;
            $mail->MsgHTML($message);
            $mail->AddAddress($email);
            $mail->Send();
            // Clear all addresses and attachments for next loop
            $mail->ClearAddresses();
            $mail->ClearAttachments();
            }
    }
}
else { $json['error']['email'] ='error_email';}
//sleep(1);
echo (json_encode($json));

?>