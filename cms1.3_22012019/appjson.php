<?php
include_once 'function.inc.publisher.php';
$publisherID=$_GET['partnerid'];
$qry="select dbName from publisher where publisherID='$publisherID'";
$row=  db_select1($qry);
$dbName = trim($row[0]['dbName']);
$config_file_path="http://myott.planetcast.in/data/".$dbName."/formdata.ini";
$content = file_get_contents($config_file_path);
$ini_array = parse_ini_string($content, true);
$content=json_encode($ini_array);
//header('Content-type: text/plain');
//header('Content-Disposition: attachment;filename="config.json"');
$content = str_replace("\\/", "/", $content);
echo ($content);
?>

