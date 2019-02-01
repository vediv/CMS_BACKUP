<?php
//include_once 'auth.php'; 
function db_connect1() {

    // Define connection as a static variable, to avoid connecting more than once 
    static $connection;

    // Try and connect to the database, if a connection has not been established yet
    if(!isset($connection)) {
         // Load configuration as an array. Use the actual location of your configuration file
        $db_host="192.168.27.15"; //local server name default localhost
        $db_user="root";  //mysql username default is root.
        $db_pass="cloud10.0";       //blank if no password is set for mysql. 
        $db_database="ott_publisher";
        $connection = mysqli_connect($db_host,$db_user,$db_pass,$db_database);
		
    }

    // If connection was not successful, handle the error
    if($connection === false) {
        // Handle error - notify administrator, log to a file, show an error screen, etc.
        return mysqli_connect_error(); 
    }
    return $connection;
}
function db_query1($query) {
    // Connect to the database
    $connection = db_connect1();
    // Query the database
    $result = mysqli_query($connection,$query);
	return $result;
}

function db_totalRow1($query) {
    // Connect to the database
    $connection = db_connect1();
    // Query the database
    $result = mysqli_query($connection,$query);
	$total_row=mysqli_num_rows($result);
    return $total_row;
}



function db_select1($query) {
    $rows = array();
    $result = db_query1($query);
    
    // If query failed, return `false`
    if($result === false) {
        return false;
    }

    // If query was successful, retrieve all the rows into an array
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function db_error1() {
    $connection = db_connect1();
    return mysqli_error($connection);
}

function db_quote1($value) {
    $connection = db_connect1();
    return "'" . mysqli_real_escape_string($connection,$value) . "'";
}

function last_insert_id1($query)
{
    $connection = db_connect1();
    $result = mysqli_query($connection,$query);
    return mysqli_insert_id($connection); 
}
function db_close1() {
    $connection = db_connect1();
     return mysqli_close($connection);
}


function write_log1($datetime,$action,$username)
{
	  $username="By-".$username;
	   //$datetime; echo $systemname; echo $transcoder; echo  $type; echo $action;  echo $username;
	   $log_file_name='files/logs.txt';
	   //if($transcoder==''){ $transcoder="  ";}
	   $str= "$datetime,$action,$username".PHP_EOL;
       $fp = fopen($log_file_name,'a');
       fwrite($fp,($str));
       fclose($fp);
	  
}

