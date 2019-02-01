<?php
include_once '../auths.php'; 
include_once '../auth.php'; 
include_once '../function.inc.php';
$conn=db_connect(DASHBOARD_USER_ID,PUBLISHER_UNIQUE_ID);
function getSmtpCredential()
{
   global $conn;
   $sql_smtp = "SELECT client_email,mail_pass,smtp_server,port FROM mail_config";
   $geTSMTP = db_select($conn, $sql_smtp);
   return $geTSMTP;
}
function getTotalActiveCustomers($data = array()) {
           global $conn;
           $sql = "SELECT uid FROM user_registration";
           $implode = array();
           if(isset($data['active_customer']) && !is_null($data['active_customer'])) {
	         $implode[] = "status = '" . (int)$data['active_customer'] . "'";
	     }
 	    if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
           $TotalActiveCustomers = db_totalRow($conn, $sql);
           return $TotalActiveCustomers;
	}
function getActiveCustomers($data = array()) {
        global $conn;
        $sql = "SELECT uemail FROM user_registration";
        $implode = array();
        if(isset($data['active_customer']) && !is_null($data['active_customer'])) {
              $implode[] = "status = '" . (int)$data['active_customer'] . "'";
          }
         if ($implode) {
                     $sql .= " WHERE " . implode(" AND ", $implode);
          }
            if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
                //return $sql."-".$data['active_customer'];
		$geTActiveCustomers = db_select($conn, $sql);
                return $geTActiveCustomers;
	}
function getTotalSubcriberUser($data = array()) {
           global $conn;
           $sql = "SELECT userid,MAX(added_date) added_date FROM user_payment_details where order_status!='Aborted' 
           GROUP BY userid ";
           $implode = array();
           //if(isset($data['active_customer']) && !is_null($data['active_customer'])) {
	     //    $implode[] = "status = '" . (int)$data['active_customer'] . "'";
	    // }
 	    //if ($implode) {
		//	$sql .= " WHERE " . implode(" AND ", $implode);
	  //	}
           $TotalSubcriberUser = db_totalRow($conn, $sql);
           return $TotalSubcriberUser;
}      
function getSubcriberUser($data = array()) {
        global $conn;
        $sql="SELECT ur.uemail
        FROM user_payment_details upd left join user_registration ur ON upd.userid=ur.uid 
        where upd.order_status!='Aborted' GROUP BY upd.userid ";
        $implode = array();
        //if(isset($data['active_customer']) && !is_null($data['active_customer'])) {
         //     $implode[] = "status = '" . (int)$data['active_customer'] . "'";
         // }
         if ($implode) {
                     $sql .= " WHERE " . implode(" AND ", $implode);
          }
            if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
                //return $sql;
                $getSubcriberUser = db_select($conn, $sql);
                return $getSubcriberUser;
	}
?>