<?php  require_once 'config/auth.php'; ?>
<?php $search_request=$_REQUEST['searchtext'];?>
<?php require_once 'includes/header.php';?>


<body onload="initSearchPage()" id="get_token">
<?php require_once 'includes/navigation.php';?> 
    
    <div class="w3-seprator-top"></div> <!-- 60px top-->
    
    <div class="w3-row darkBar">
        <div class="main-container w3-row-padding ">
            <ol class="w3-breadcrumb"><li><a href="index.php">HOME</a> / </li><li><a href="">SEARCH</a> / </li><li><a class="last"><?php echo $search_request; ?> : <span id="srchResCount">0</span> Results</a></li></ol>
        </div>    
  </div>
    
     <div class="w3-seprator"></div> <!-- 20px margin-->
     
     <div class="w3-row fullHeight">
         <div class="main-container w3-row-padding" >
            <div class="w3-col darkBg" id="Search-data"></div>    
            
        </div>
         
     </div>
     
     
     
     
     <div class="w3-seprator"></div>
   <div class="w3-seprator"></div>
    <div class="w3-seprator"></div>
  

<?php require_once 'includes/footer.php';?>

    <style>
        .last{font-size: 15px;  }
        #Search-data .w3-col{padding-top: 10px;padding-right: 5px;}
        </style>