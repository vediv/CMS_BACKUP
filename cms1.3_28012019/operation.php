<?php
//date_default_timezone_set('Asia/Calcutta');
//include_once 'corefunction.php';
include_once 'auths.php';
include_once 'auth.php';
include_once 'function.inc.php';
$conn=db_connect(DASHBOARD_USER_ID,PUBLISHER_UNIQUE_ID);
$get_user_id=DASHBOARD_USER_ID; $publisher_unique_id=PUBLISHER_UNIQUE_ID;$login_access_level=ACCESS_LEVEL;
$action =(isset($_REQUEST['action']))? $_REQUEST['action']: 0;
switch($action)
{
     case "notification_download":
     $fromDate=$_POST['fromDate']; $toDate=$_POST['toDate'];
     $fromDate_convert=date('Y-m-d', strtotime($fromDate));
     $toDate_convert=date('Y-m-d', strtotime($toDate));
     $format="notification".$_POST['format'];
     $SQL = "SELECT notification_id,title,message,thumbnail,total_success,total_fail,status,mode,sending_time FROM notification_details WHERE DATE(sending_time) BETWEEN '$fromDate_convert' AND '$toDate_convert'";
     $header = ''; $result ='';
     $header = "SNO". "\t";
     $fields = db_fetch_fields($conn,$SQL);
     foreach($fields as $fi => $f)
     {
        $name=  strtoupper($f->name);
        $header.=$name."\t";
     }
     $j=1;
     $rows=db_select_row($conn,$SQL);
     foreach( $rows as $row )
     {
         $line = '';
         foreach($row as $value )
         {
            if ( ( !isset( $value ) ) || ( $value == "" ) )
              {
                    $value = "\t";
               }
            else
            {
               $value = str_replace( '"' , '""' , $value );
                $value = '"'.$value . '"' . "\t";
            }
              $line .=$value;
         }
        $line1='"'.$j.'"'. "\t" .$line;
        $result .= trim( $line1 ) . "\n";
     $j++;
    }
    $result = str_replace( "\r" , "" , $result );
    if ( $result == "" )
    {
        $result = "\nNo Record(s) Found!\n";
    }
    //print "$header\n$result";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".$format."");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\n$result";
    break;

case "pdf":
$fromDate=$_GET['fromDate']; $toDate=$_GET['toDate'];
$fromDate_convert=date('Y-m-d', strtotime($fromDate));
$toDate_convert=date('Y-m-d', strtotime($toDate));
$SQL = "SELECT notification_id,title,message,thumbnail,total_success,total_fail,status,mode,sending_time FROM notification_details WHERE DATE(sending_time) BETWEEN '$fromDate_convert' AND '$toDate_convert'";
$fetch=db_select($conn,$SQL);
$html = '<table border="1" width="100%">';
$html .= '<tbody><tr><td>SNO</td><td>NOTIFICATION_ID</td><td>TITLE</td><td>MESSAGE</td><td>THUMBNAIL</td> <td>TOTAL_SUCCESS</td> <td>TOTAL_FAIL</td><td>MODE</td><td>SENDING TIME</td></tr>';
$i=1;
foreach($fetch as $ff)
{
$nid=$ff['notification_id']; $title=$ff['title']; $message=$ff['message']; $thumbnail=$ff['thumbnail'];
$total_success=$ff['total_success'];$total_fail=$ff['total_fail']; $mode=$ff['mode']; $sending_time=$ff['sending_time'];
$html .='<tr>
<td>'.$i.'</td>
<td>'.$nid.'</td>
<td>'.$title.'</td>
<td>'.$message.'</td>
<td>'.$thumbnail.'</td>
<td>'.$total_success.'</td>
<td>'.$total_fail.'</td>
<td>'.$mode.'</td>
<td>'.$sending_time.'</td>
</tr>
';
$i++;
}
$html .='</tbody></table>';

//==============================================================
//==============================================================
//==============================================================
include("plugins/MPDF57/mpdf.php");

$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13);

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,2);

$mpdf->Output('notification.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================
break;
case "userlist":
     $fromDate=$_POST['fromDate']; $toDate=$_POST['toDate'];
     $fromDate_convert=date('Y-m-d', strtotime($fromDate));
     $toDate_convert=date('Y-m-d', strtotime($toDate));
     $format="RegisteredUserList".$_POST['format'];
     $SQL = "SELECT uname,user_id,uemail,added_date,oauth_provider FROM user_registration WHERE DATE(added_date) BETWEEN '$fromDate_convert' AND '$toDate_convert'";
     $header = ''; $result ='';
     $header = "Sno". "\t";
     $header .= "Name". "\t";
     $header .= "User ID". "\t";
     $header .= "Email". "\t";
     $header .= "Registration Date". "\t";
     $header .= "Authentication From ". "\t";
     /*$fields = db_fetch_fields($conn,$SQL);
     foreach($fields as $fi => $f)
     {
        $name=  strtoupper($f->name);
        $header.=$name."\t";
     }*/
     $j=1;
     $rows=db_select_row($conn,$SQL);
     foreach( $rows as $row )
     {
         $line = '';
         foreach($row as $value )
         {
            if ( ( !isset( $value ) ) || ( $value == "" ) )
              {
                    $value = "\t";
               }
            else
            {
               $value = str_replace( '"' , '""' , $value );
                $value = '"'.$value . '"' . "\t";
            }
              $line .=$value;
         }
        $line1='"'.$j.'"'. "\t" .$line;
        $result .= trim( $line1 ) . "\n";
     $j++;
    }
    $result = str_replace( "\r" , "" , $result );
    if ( $result == "" )
    {
        $result = "\nNo Record(s) Found!\n";
    }
    //print "$header\n$result";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".$format."");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\n$result";
    break;
case "userListPdf":
$t = iconv("UTF-8", "UTF-8//IGNORE", $t);
$fromDate=$_GET['fromDate']; $toDate=$_GET['toDate'];
$fromDate_convert=date('Y-m-d', strtotime($fromDate));
$toDate_convert=date('Y-m-d', strtotime($toDate));
//$SQL = "SELECT notification_id,title,message,thumbnail,total_success,total_fail,status,mode,sending_time FROM notification_details WHERE DATE(sending_time) BETWEEN '$fromDate_convert' AND '$toDate_convert'";
$html = '<table border="0"  width="100%" style="border-collapse: collapse; font-family: arial, sans-serif;">>';
$html .='<tr><td colspan="6" align="center"><b>REGISTERED USERS LIST</b></td></tr>';
$html .='</tbody></table>';
$SQL = "SELECT uname,user_id,uemail,added_date,oauth_provider FROM user_registration WHERE DATE(added_date) BETWEEN '$fromDate_convert' AND '$toDate_convert'";
$fetch=db_select($conn,$SQL);
$html .= '<table border="1"  width="100%" style="border-collapse: collapse; font-family: arial, sans-serif; font-size:11px;">';
//$html .='<tr><td colspan="6" align="center"><b>REGISTERED USERS LIST</b></td></tr>';
$html .= '<tbody><tr><td><b>Sno</b></td><td><b>Name</b></td><td><b>User ID</b></td><td><b>Email</b></td><td><b>Reg. Date</b></td> <td><b>Auth. From</b></td> </tr>';
$i=1;

foreach($fetch as $ff)
{
$uname=$ff['uname']; $user_id=$ff['user_id']; $uemail=$ff['uemail'];
$unamew=wordwrap($uname,25,"<br>\n",TRUE);
$uemailw=wordwrap($uemail,25,"<br>\n",TRUE);
$user_idw=wordwrap($user_id,25,"<br>\n",TRUE);
$added_date=$ff['added_date'];
$oauth_provider=$ff['oauth_provider'];
$html .='<tr>
<td>'.$i.'</td>
<td>'.$unamew.'</td>
<td>'.$user_idw.'</td>
<td>'.$uemailw.'</td>
<td>'.$added_date.'</td>
<td>'.$oauth_provider.'</td>
</tr>
';
$i++;
}
$html .='</tbody></table>';

//==============================================================
//==============================================================
//==============================================================
include("plugins/MPDF57/mpdf.php");


$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13);

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$html = utf8_encode($html);
$mpdf->WriteHTML($html,2);

$mpdf->Output('RegisteredUserList.pdf','I');

exit;
//==============================================================
//==============================================================
//==============================================================
break;
case "participantlist":
     $fromDate=$_POST['fromDate']; $toDate=$_POST['toDate'];
     $fromDate_convert=date('Y-m-d', strtotime($fromDate));
     $toDate_convert=date('Y-m-d', strtotime($toDate));
     $format="ParticipantList".$_POST['format'];
     $SQL = "SELECT dt.RegCode,dt.name,ur.mobile,dt.regDate,ur.ulocation,ur.dob FROM
     device_token dt LEFT JOIN user_registration ur ON dt.userid = ur.uid
     WHERE dt.status='1' AND DATE(dt.regDate) BETWEEN '$fromDate_convert' AND '$toDate_convert'";
     $header = ''; $result ='';
     $header  = "Sno". "\t";
     $header .= "Reg Code". "\t";
     $header .= "Name". "\t";
     $header .= "Mobile". "\t";
     $header .= "Register Date". "\t";
     $header .= "Location". "\t";
     $header .= "DOB". "\t";
     /*$fields = db_fetch_fields($conn,$SQL);
     foreach($fields as $fi => $f)
     {
        $name=  strtoupper($f->name);
        $header.=$name."\t";
     }*/
     $j=1;
     $rows=db_select_row($conn,$SQL);
     foreach( $rows as $row )
     {
         $line = '';
         foreach($row as $value )
         {
            if ( ( !isset( $value ) ) || ( $value == "" ) )
              {
                    $value = "\t";
               }
            else
            {
               $value = str_replace( '"' , '""' , $value );
                $value = '"'.$value . '"' . "\t";
            }
              $line .=$value;
         }
        $line1='"'.$j.'"'. "\t" .$line;
        $result .= trim( $line1 ) . "\n";
     $j++;
    }
    $result = str_replace( "\r" , "" , $result );
    if ( $result == "" )
    {
        $result = "\nNo Record(s) Found!\n";
    }
    //print "$header\n$result";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".$format."");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\n$result";
    break;
case "participantListPdf":
$t = iconv("UTF-8", "UTF-8//IGNORE", $t);
$fromDate=$_GET['fromDate']; $toDate=$_GET['toDate'];
$fromDate_convert=date('Y-m-d', strtotime($fromDate));
$toDate_convert=date('Y-m-d', strtotime($toDate));
//$SQL = "SELECT notification_id,title,message,thumbnail,total_success,total_fail,status,mode,sending_time FROM notification_details WHERE DATE(sending_time) BETWEEN '$fromDate_convert' AND '$toDate_convert'";
$html = '<table border="0"  width="100%" style="border-collapse: collapse; font-family: arial, sans-serif;">>';
$html .='<tr><td colspan="6" align="center"><b>PARTICIPANT LIST</b></td></tr>';
$html .='</tbody></table>';
$SQL = "SELECT dt.RegCode,dt.name,ur.mobile,dt.regDate,ur.ulocation,ur.dob FROM
device_token dt LEFT JOIN user_registration ur ON dt.userid = ur.uid
WHERE dt.status='1' AND DATE(dt.regDate) BETWEEN '$fromDate_convert' AND '$toDate_convert'";
$fetch=db_select($conn,$SQL);
$html .= '<table border="1"  width="100%" style="border-collapse: collapse; font-family: arial, sans-serif; font-size:11px;">';
//$html .='<tr><td colspan="6" align="center"><b>REGISTERED USERS LIST</b></td></tr>';
$html .= '<tbody><tr><td><b>Sno</b></td><td><b>Reg Code</b></td><td><b>Name</b></td><td><b>Mobile</b></td><td><b>Register Date</b></td><td><b>Location</b></td> <td><b>DOB</b></td> </tr>';
$i=1;
foreach($fetch as $ff)
{
$reg_code=$ff['RegCode']; $name=$ff['name']; $mobile=$ff['mobile'];
$reg_date=$ff['regDate'];
$ulocation=$ff['ulocation'];
$dob=$ff['dob'];
$html.='<tr>
<td>'.$i.'</td>
<td>'.$reg_code.'</td>
<td>'.$name.'</td>
<td>'.$mobile.'</td>
<td>'.$reg_date.'</td>
<td>'.$ulocation.'</td>
<td>'.$dob.'</td>
</tr>';
$i++;
}
$html .='</tbody></table>';
//==============================================================
//==============================================================
//==============================================================
include("plugins/MPDF57/mpdf.php");
$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13);
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$html = utf8_encode($html);
$mpdf->WriteHTML($html,2);
$mpdf->Output('ParticipantList.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================
break;


}
?>
