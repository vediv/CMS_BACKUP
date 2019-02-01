<?php
function db_connect($dashboarduserid,$publisheruniqueID) {
    // Define connection as a static variable, to avoid connecting more than once
    include_once 'function.inc.publisher.php';
    $qry="select dbHostName,dbUserName,dbpassword,dbName from ott_publisher.publisher where par_id='$dashboarduserid' and publisherID='$publisheruniqueID'";
    $fetchDB=db_select1($qry);
    //print_r($fetchDB);
    $dbhost=trim($fetchDB[0]['dbHostName']); $dbusername=trim($fetchDB[0]['dbUserName']);
    $dbpassword=trim($fetchDB[0]['dbpassword']);
    $dbname=trim($fetchDB[0]['dbName']);
    static $connection;
    if(!isset($connection)) {
         $db_host=$dbhost; 
         $db_user=$dbusername;  
         $db_pass=$dbpassword;      
         $db_database=$dbname; // this databse come from core_config.php
        $connection = mysqli_connect($db_host,$db_user,$db_pass,$db_database) or die(mysqli_connect_error());
        }
    // If connection was not successful, handle the error
    if($connection === false) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
       
    }
    return $connection;
}

function db_query($con,$query) {
    //$connection = db_connect();
       $result = mysqli_query($con,$query);
       return $result;
}
function last_insert_id($con,$query)
{
    //$connection = db_connect();
    $result = mysqli_query($con,$query);
    return mysqli_insert_id($con); 
}

function db_num_fields($con,$query) {
    //$connection = db_connect();
    $result1 = mysqli_query($con,$query);
    $result=mysqli_num_fields($result1);
    return $result; 
}
function db_fetch_fields($con,$query) {
   // $connection = db_connect();
    $r = mysqli_query($con,$query);
    $result=mysqli_fetch_fields($r);
    return $result;
}

function db_totalRow($con,$query) {
    $result = mysqli_query($con,$query);
    $total_row=mysqli_num_rows($result);
    return $total_row;
}
function db_select($con,$query) {
    $rows = array();
    $result = db_query($con,$query);
    if($result === false) {
        return false;
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function db_select_row($con,$query) {
    $rows = array();
    $result = db_query($con,$query);
    if($result === false) {
        return false;
    }
    while ($row = mysqli_fetch_row($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function db_error($con) {
    //$connection = db_connect();
    return mysqli_error($con);
}

function db_quote($con,$value) {
    //$connection = db_connect();
    return "'" . mysqli_real_escape_string($con,$value) . "'";
}

function db_quote_new($con,$value) {
    //$connection = db_connect();
    return mysqli_real_escape_string($con,$value);
}
function db_close($con) {
    //$connection = db_connect();
     return mysqli_close($con);
}
function unique_planID($len=3) {
    $pin = '';
    $a = "0123456789";
    $b = str_split($a);
    for ($i=1; $i <= $len ; $i++) { 
        $pin .= $b[rand(0,strlen($a)-1)];
    }
    $pp="p".$pin;
    return $pp;
}
function unique_ContentID($len=3) {
    $pin = '';
    $a = "0123456789";
    $b = str_split($a);
    for ($i=1; $i <= $len ; $i++) { 
        $pin .= $b[rand(0,strlen($a)-1)];
    }
    $pp="c".$pin;
    return $pp;
}


