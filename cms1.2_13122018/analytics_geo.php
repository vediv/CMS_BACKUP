<?php 
include_once 'corefunction.php';
$qryAna="select google_client_id,client_secret,refresh_token from mail_config where publisherID='".$publisher_unique_id."'";
$fetchAna=  db_select($conn,$qryAna);
$google_client_id=$fetchAna[0]['google_client_id']; $client_secret=$fetchAna[0]['client_secret'];
$refresh_token=$fetchAna[0]['refresh_token']; //$analytics_url=$fetchAna[0]['analytics_url'];
$view=isset($_GET['view'])?$_GET['view']:'location';
switch($view)
{
    case "location":
    include_once('ga_geo_location.php');    
    break; 
    case "language":
    include_once('ga_geo_language.php');
    break; 
}
?>
<script type="text/javascript">
function viewScreenType(viewtype)
{
    //alert(viewtype);
    window.location.href="analytics_geo.php?view="+viewtype;
    return true;
}
</script>
