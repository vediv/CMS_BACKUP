<?php
include_once 'auths.php';
//$TotalCategoryLevelArray=array(0,1,2,3,4);
function getCategoryLevel()
{
    global $conn;
    $qry="select value from  filter_setting where tag='category_level' and status='1' ";
    $getFData=  db_select($conn, $qry);
    $category_level=$getFData[0]['value'];
    return $category_level; 
}
?>