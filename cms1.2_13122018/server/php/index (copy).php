<?php
error_reporting(E_ALL | E_STRICT);
session_start();
$userID=$_SESSION['publisher_info']['dasbord_user_id'];
require('UploadHandler.php');
$upload_handler = new UploadHandler();
?>

