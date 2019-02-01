<?php
require_once('kalturaClient/KalturaClient.php');
//require_once('php5/KalturaClient.php');
//include_once 'core_config.php'; 
$config = new KalturaConfiguration(PARTNER_ID);
$config->serviceUrl = SERVICEURL."/";
$client = new KalturaClient($config);
$ks = $client->generateSession(ADMINSECRET, USER_ID, KalturaSessionType::ADMIN, PARTNER_ID);
$client->setKs($ks);
?>
