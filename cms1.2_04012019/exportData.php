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
    case "subcription_excel":
    $fromDate=$_GET['fromDate']; $toDate=$_GET['toDate']; $dateType=$_GET['dateType'];
    $transStatus=$_GET['transStatus']; $getPlanid=$_GET['planid']; $searchInput=$_GET['searchInput']; 
    $subscType=$_GET['subscType'];
    $format="SubscriptionData".$_GET['exportType'];
    //$SQL = "SELECT uname,user_id,uemail,added_date,oauth_provider FROM user_registration WHERE DATE(added_date) BETWEEN '$fromDate_convert' AND '$toDate_convert'";
     $sql="SELECT ur.uname,ur.uid,upd.orderid,upd.trans_id,upd.plan_days,upd.order_status,
           date(upd.added_date),date(upd.expire_date),STR_TO_DATE(upd.trans_date,'%d-%m-%Y') AS trans_date_new_format,upd.amount 
           FROM user_payment_details upd left join user_registration ur ON upd.userid=ur.uid where upd.order_status!='Aborted' ";
   if($transStatus=='all'){ $orderStatus='';  }
   if($transStatus=='payment_initiated'){ $orderStatus=" And order_status='Payment Initiated'";  }
   if($transStatus=='Success'){ $orderStatus=" And order_status='Success'";  }
   if($transStatus=='otherstatus'){ $orderStatus=" And order_status!='Payment Initiated' and order_status!='Success' ";  } 
   if($subscType=='all'){ $paymentFor=''; }
   if($subscType=='plan' || $subscType=='wallet' || $subscType=='subs_code'){ $paymentFor=" and payment_for='$subscType'"; }
   if($fromDate=='')
    {  
        $sql.="   $orderStatus $paymentFor";
    } 
    if($fromDate!='' && $toDate=='')
    {  
       if($dateType=='added_date'){ $date_type1="added_date"; $sql.=" and Date(upd.added_date)='$fromDate' $orderStatus $paymentFor";} 
       if($dateType=='trans_date'){ $date_type1="trans_date"; $sql.=" and STR_TO_DATE(upd.trans_date,'%d-%m-%Y')='$fromDate' $orderStatus $paymentFor"; }
       if($dateType=='expire_date'){ $date_type1="exipre_date"; $sql.=" and Date(upd.expire_date)='$fromDate' $orderStatus $paymentFor";}
    } 
    if($toDate!='' && $fromDate!='')
    {
       if($dateType=='added_date'){ $date_type1="added_date"; $sql.=" and (Date(upd.added_date) BETWEEN  '$fromDate' AND '$toDate' ) $orderStatus $paymentFor"; } 
       if($dateType=='trans_date'){ $date_type1="trans_date"; $sql.=" and (STR_TO_DATE(upd.trans_date,'%d-%m-%Y') BETWEEN '$fromDate' AND '$toDate' ) $orderStatus $paymentFor"; }
       if($dateType=='expire_date'){ $date_type1="expire_date"; $sql.=" and (Date(upd.expire_date) BETWEEN  '$fromDate' AND '$toDate' ) $orderStatus $paymentFor"; } 
    }
    if($getPlanid!='')
    {
       $sql.=" and planid='$getPlanid' ";
    }  
    if($searchInput!='') // this $filter_user come from report page
    {
         $sql.= " and 
         (upd.userid LIKE '%". $searchInput . "%'
         or upd.orderid LIKE '%" . $searchInput . "%'
         or upd.trans_id LIKE '%" . $searchInput . "%'
         )";
    }  
    //$exportQuery=$sql;
     $SQL_q=$sql;
     $header = ''; $result ='';
     $header = "Sno". "\t";
     $header .= "Name". "\t";
     $header .= "User ID". "\t";
     $header .= "Order ID". "\t";
     $header .= "Transaction ID". "\t";
     $header .= "Plan Days ". "\t";
     $header .= "Status ". "\t";
     $header .= "Added Date ". "\t";
     $header .= "Transaction Date ". "\t";
     $header .= "Expire Date ". "\t";
     $header .= "Amount ". "\t";
     /*$fields = db_fetch_fields($conn,$SQL);
     foreach($fields as $fi => $f) 
     {
        $name=  strtoupper($f->name); 
        $header.=$name."\t";
     }*/
     $j=1;
     $rows=db_select_row($conn,$SQL_q);
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

case "subcription_pdf":
$t = iconv("UTF-8", "UTF-8//IGNORE", $t);    

//$SQL = "SELECT notification_id,title,message,thumbnail,total_success,total_fail,status,mode,sending_time FROM notification_details WHERE DATE(sending_time) BETWEEN '$fromDate_convert' AND '$toDate_convert'";
$html = '<table border="0"  width="100%" style="border-collapse: collapse; font-family: arial, sans-serif;">>';
$html .='<tr><td colspan="6" align="center"><b>SUBSCRIBED USERS LIST</b></td></tr>';
$html .='</tbody></table>';

$fromDate=$_GET['fromDate']; $toDate=$_GET['toDate']; $dateType=$_GET['dateType'];
    $transStatus=$_GET['transStatus']; $getPlanid=$_GET['planid']; $searchInput=$_GET['searchInput'];
    $subscType=$_GET['subscType'];
    $format="SubscriptionData".$_GET['exportType'];
    //$SQL = "SELECT uname,user_id,uemail,added_date,oauth_provider FROM user_registration WHERE DATE(added_date) BETWEEN '$fromDate_convert' AND '$toDate_convert'";
  $sql="SELECT ur.uname,ur.uid,upd.orderid,upd.trans_id,upd.plan_days,upd.order_status,
           date(upd.added_date) as adate,date(upd.expire_date) as edate,STR_TO_DATE(upd.trans_date,'%d-%m-%Y') AS trans_date_new_format,upd.amount 
           FROM user_payment_details upd left join user_registration ur ON upd.userid=ur.uid where upd.order_status!='Aborted' ";
   if($transStatus=='all'){ $orderStatus='';  }
   if($transStatus=='payment_initiated'){ $orderStatus=" And order_status='Payment Initiated'";  }
   if($transStatus=='Success'){ $orderStatus=" And order_status='Success'";  }
   if($transStatus=='otherstatus'){ $orderStatus=" And order_status!='Payment Initiated' and order_status!='Success' ";  } 
    if($subscType=='all'){ $paymentFor=''; }
   if($subscType=='plan' || $subscType=='wallet' || $subscType=='subs_code'){ $paymentFor=" and payment_for='$subscType'"; }
   if($fromDate=='')
    {  
        $sql.="   $orderStatus $paymentFor";
    } 
  
    if($fromDate!='' && $toDate=='')
    {  
       if($dateType=='added_date'){ $date_type1="added_date"; $sql.=" and Date(upd.added_date)='$fromDate' $orderStatus $paymentFor";} 
       if($dateType=='trans_date'){ $date_type1="trans_date"; $sql.=" and STR_TO_DATE(upd.trans_date,'%d-%m-%Y')='$fromDate' $orderStatus $paymentFor"; }
       if($dateType=='expire_date'){ $date_type1="exipre_date"; $sql.=" and Date(upd.expire_date)='$fromDate' $orderStatus $paymentFor";}
    } 
    if($toDate!='' && $fromDate!='')
    {
       if($dateType=='added_date'){ $date_type1="added_date"; $sql.=" and (Date(upd.added_date) BETWEEN  '$fromDate' AND '$toDate' ) $orderStatus $paymentFor"; } 
       if($dateType=='trans_date'){ $date_type1="trans_date"; $sql.=" and (STR_TO_DATE(upd.trans_date,'%d-%m-%Y') BETWEEN '$fromDate' AND '$toDate' ) $orderStatus $paymentFor"; }
       if($dateType=='expire_date'){ $date_type1="expire_date"; $sql.=" and (Date(upd.expire_date) BETWEEN  '$fromDate' AND '$toDate' ) $orderStatus $paymentFor"; } 
    }
    if($getPlanid!='')
    {
       $sql.=" and planid='$getPlanid'";
    }  
    if($searchInput!='') // this $filter_user come from report page
    {
         $sql.= " and 
         (upd.userid LIKE '%". $searchInput . "%'
         or upd.orderid LIKE '%" . $searchInput . "%'
         or upd.trans_id LIKE '%" . $searchInput . "%'
         )";
    }  
    //$exportQuery=$sql;
   $SQL_q=$sql;
   $fetch_data=db_select($conn,$SQL_q);
   //echo "<pre>";print_r($fetch_data);echo "</pre>";
   //exit;
$html .= '<table border="1"  width="100%" style="border-collapse: collapse; font-family: arial, sans-serif; font-size:11px;">';
//$html .='<tr><td colspan="6" align="center"><b>REGISTERED USERS LIST</b></td></tr>';
$html .= '<tbody><tr><td><b>Sno</b></td><td><b>Name</b></td><td><b>User ID</b></td><td><b>Order ID</b></td><td><b>Transaction ID</b></td> <td><b>Plan Days</b></td> <td><b>Status</b></td><td><b>Added Date</b></td><td><b>Transaction Date</b></td><td><b>Expire Date</b></td><td><b>Amount</b></td> </tr>';
$i=1;
foreach($fetch_data as $fetch)
{
  $uid=$fetch['uid'];$orderid=$fetch['orderid']; $trans_id=$fetch['trans_id']; $amount =$fetch['amount'];  
  $trans_date =$fetch['trans_date_new_format'];$uname=$fetch['uname']; $exipre_date =$fetch['edate']; 
  $added_date =$fetch['adate'];
  $order_status=$fetch['order_status'];
  $plan_days=$fetch['plan_days'];  $amount=$fetch['amount']; 
  $expire_date=$fetch['expire_date']; 
  $unamew=wordwrap($uname,10,"<br>\n",TRUE);
  $user_idw=wordwrap($uid,25,"<br>\n",TRUE);
  $order_statusw=wordwrap($order_status,25,"<br>\n",TRUE);
  $html .='<tr>
    <td>'.$i.'</td>
    <td>'.$unamew.'</td>
    <td>'.$user_idw.'</td>
    <td>'.$orderid.'</td>
    <td>'.$trans_id.'</td>
    <td>'.$plan_days.'</td>
    <td>'.$order_statusw.'</td>
    <td>'.$added_date.'</td>
    <td>'.$trans_date.'</td>
    <td>'.$exipre_date.'</td>
    <td>'.$amount.'</td>
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

$mpdf->Output('SubscriptionData.pdf','I');

exit;
//==============================================================
//==============================================================
//==============================================================
break; 
    case "revenue_excel":
    $fromDate=$_GET['fromDate']; $toDate=$_GET['toDate']; $dateType=$_GET['dateType'];
    $getPlanid=$_GET['planid']; $searchInput=$_GET['searchInput']; 
    $subscType=$_GET['subscType'];
    $format="RevenueReport".$_GET['exportType'];
    //$SQL = "SELECT uname,user_id,uemail,added_date,oauth_provider FROM user_registration WHERE DATE(added_date) BETWEEN '$fromDate_convert' AND '$toDate_convert'";
     $sql="SELECT ur.uname,ur.uid,upd.orderid,upd.added_date,upd.amount
          FROM user_payment_details upd left join user_registration ur ON upd.userid=ur.uid 
          where upd.order_status='Success'";
   if($subscType=='all'){ $paymentFor=''; }
   if($subscType=='plan' || $subscType=='wallet'){ $paymentFor=" and payment_for='$subscType'"; }
   if($fromDate=='')
    {  
        $sql.=" $paymentFor";
    } 
    if($fromDate=='')
    {  
        $sql.="  $paymentFor";
    } 
    if($fromDate!='' && $toDate=='')
    {  
       if($dateType=='added_date'){ $date_type1="added_date"; $sql.=" and Date(upd.added_date)='$fromDate'  $paymentFor";} 
       if($dateType=='trans_date'){ $date_type1="trans_date"; $sql.=" and STR_TO_DATE(upd.trans_date,'%d-%m-%Y')='$fromDate'  $paymentFor"; }
       if($dateType=='expire_date'){ $date_type1="exipre_date"; $sql.=" and Date(upd.expire_date)='$fromDate'  $paymentFor";}
    } 
    if($toDate!='' && $fromDate!='')
    {
       if($dateType=='added_date'){ $date_type1="added_date"; $sql.=" and (Date(upd.added_date) BETWEEN  '$fromDate' AND '$toDate' )  $paymentFor"; } 
       if($dateType=='trans_date'){ $date_type1="trans_date"; $sql.=" and (STR_TO_DATE(upd.trans_date,'%d-%m-%Y') BETWEEN '$fromDate' AND '$toDate' )  $paymentFor"; }
       if($dateType=='expire_date'){ $date_type1="expire_date"; $sql.=" and (Date(upd.expire_date) BETWEEN  '$fromDate' AND '$toDate' )  $paymentFor"; } 
    }
    if($getPlanid!='')
    {
       $sql.=" and planid='$getPlanid'";
    }    
     //$exportQuery=$sql;
     $SQL_q=$sql;
     $header = ''; $result ='';
     $header = "Sno". "\t";
     $header .= "Name". "\t";
     $header .= "User ID". "\t";
     $header .= "Order ID". "\t";
     $header .= "Added Date ". "\t";
     $header .= "Amount ". "\t";
     /*$fields = db_fetch_fields($conn,$SQL);
     foreach($fields as $fi => $f) 
     {
        $name=  strtoupper($f->name); 
        $header.=$name."\t";
     }*/
     $j=1;
     $rows=db_select_row($conn,$SQL_q);
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
    break;
    case "revenue_pdf":
    $t = iconv("UTF-8", "UTF-8//IGNORE", $t);    
    $html = '<table border="0"  width="100%" style="border-collapse: collapse; font-family: arial, sans-serif;">>';
    $html .='<tr><td colspan="6" align="center"><b>REVENUE DATA</b></td></tr>';
    $html .='</tbody></table>';
    $fromDate=$_GET['fromDate']; $toDate=$_GET['toDate']; $dateType=$_GET['dateType'];
     $getPlanid=$_GET['planid']; 
    $subscType=$_GET['subscType'];
    $format="RevenueReport".$_GET['exportType'];
    //$SQL = "SELECT uname,user_id,uemail,added_date,oauth_provider FROM user_registration WHERE DATE(added_date) BETWEEN '$fromDate_convert' AND '$toDate_convert'";
   $sql="SELECT ur.uname,ur.uid,upd.orderid,upd.added_date,upd.amount
          FROM user_payment_details upd left join user_registration ur ON upd.userid=ur.uid 
          where upd.order_status='Success'";
   if($subscType=='all'){ $paymentFor=''; }
   if($subscType=='plan' || $subscType=='wallet'){ $paymentFor=" and payment_for='$subscType'"; }
   if($fromDate=='')
    {  
        $sql.=" $paymentFor";
    } 
    if($fromDate=='')
    {  
        $sql.="  $paymentFor";
    } 
    if($fromDate!='' && $toDate=='')
    {  
       if($dateType=='added_date'){ $date_type1="added_date"; $sql.=" and Date(upd.added_date)='$fromDate'  $paymentFor";} 
       if($dateType=='trans_date'){ $date_type1="trans_date"; $sql.=" and STR_TO_DATE(upd.trans_date,'%d-%m-%Y')='$fromDate'  $paymentFor"; }
       if($dateType=='expire_date'){ $date_type1="exipre_date"; $sql.=" and Date(upd.expire_date)='$fromDate'  $paymentFor";}
    } 
    if($toDate!='' && $fromDate!='')
    {
       if($dateType=='added_date'){ $date_type1="added_date"; $sql.=" and (Date(upd.added_date) BETWEEN  '$fromDate' AND '$toDate' )  $paymentFor"; } 
       if($dateType=='trans_date'){ $date_type1="trans_date"; $sql.=" and (STR_TO_DATE(upd.trans_date,'%d-%m-%Y') BETWEEN '$fromDate' AND '$toDate' )  $paymentFor"; }
       if($dateType=='expire_date'){ $date_type1="expire_date"; $sql.=" and (Date(upd.expire_date) BETWEEN  '$fromDate' AND '$toDate' )  $paymentFor"; } 
    }
    if($getPlanid!='')
    {
       $sql.=" and planid='$getPlanid'";
    } //$exportQuery=$sql;
   $SQL_q=$sql;
   $fetch_data=db_select($conn,$SQL_q);
   //echo "<pre>";print_r($fetch_data);echo "</pre>";
   //exit;
$html .= '<table border="1"  width="100%" style="border-collapse: collapse; font-family: arial, sans-serif; font-size:11px;">';
//$html .='<tr><td colspan="6" align="center"><b>REGISTERED USERS LIST</b></td></tr>';
$html .= '<tbody><tr><td><b>Sno</b></td><td><b>Name</b></td><td><b>User ID</b></td><td><b>Order ID</b></td><td><b>Added Date</b></td><td><b>Amount</b></td> </tr>';
$i=1;
foreach($fetch_data as $fetch)
{
  $uid=$fetch['uid'];$orderid=$fetch['orderid'];  $amount =$fetch['amount'];  
  $uname=$fetch['uname']; $added_date =$fetch['added_date'];
  $unamew=wordwrap($uname,10,"<br>\n",TRUE);
  $user_idw=wordwrap($uid,25,"<br>\n",TRUE);
  $html .='<tr>
    <td>'.$i.'</td>
    <td>'.$unamew.'</td>
    <td>'.$user_idw.'</td>
    <td>'.$orderid.'</td>
    <td>'.$added_date.'</td>
    <td>'.$amount.'</td>
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

$mpdf->Output('SubscriptionData.pdf','I');

exit;
    break;    

    
    
}
 
                  
?>
