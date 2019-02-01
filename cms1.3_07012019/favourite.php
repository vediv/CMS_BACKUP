<?php  require_once 'config/auth.php'; ?>
<?php if(empty($_SESSION['user_id'])){   header("Location:index.php");}?>
<?php require_once 'includes/header.php';?>


<body onload="initFavourite()" id="get_token">
<?php require_once 'includes/navigation.php';?> 
    
    <div class="w3-seprator-top"></div> <!-- 60px top-->
    
     <div class="w3-row darkBar">
        <div class="main-container w3-row-padding ">
            <ol class="w3-breadcrumb"><li><a href="index.php">HOME</a> / </li><li><a href="" class="last"> Favourites</a></li></ol>
        </div>    
  </div>
    
     <div class="w3-seprator"></div> <!-- 20px margin-->
    
     
     
     <div class="w3-row " style="min-height: 100%;">
        
         <div class="main-container w3-row-padding" id="favouriteList">
            
            
            
           
            
         
        </div>
     </div>    
     
     
     
     
     
     
     
     
     
      <div class="w3-seprator"></div>
   <div class="w3-seprator"></div>
    <div class="w3-seprator"></div>
  

<?php require_once 'includes/footer.php';?>

    
