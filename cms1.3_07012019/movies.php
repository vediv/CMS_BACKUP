<?php  require_once 'config/auth.php'; ?>
<?php require_once 'includes/header.php';?>
<body onload="initMovies()" id="get_token" class="">
<?php require_once 'includes/navigation.php';?> 
    
    <!--  <div class="w3-seprator-top"></div>--> 
    
    <!-- slider--> 
    <div class="w3-row">
        <div class="s12 m12 l12 w3-col" id="movie-carousel">
      
            <img class="w3-image" width="100%" src="images/banners/placeholderL.jpg">
              
       </div>
  
   </div>
   <!-- !slider--> 
   
  <!-- Tab Buttons-->    
<div class="w3-row w3-skyblue barSubItems1">
    <div class="main-container w3-row-padding" id="w3-bar" >
           
        <!--- Tab item will appear here from function  tabItems() -->
    </div> 
    
    
    
</div>
  
  <div class="w3-row barSubItems ">
      
   <div class="main-container w3-row-padding" id="barSubItems">
         
        <!--- Tab sub item will appear here from function  tabItems() -->
   </div> 
    
  </div>
  
 
<!-- !tab Buttons-->  

 <!-- Tab Container--> 
<div class="w3-row channel-container darkBg fullHeight">
    <div class="main-container w3-row-padding" >
           
             <div id="movies-result" class="tabs">
                 
               </div>  
          
    </div>
</div>
<!-- !Tab Container-->      
    
    
 
   
    
  

<?php require_once 'includes/footer.php';?>    
    
<script>         
    $(document).ready(function(){sliderIntrvl=setInterval(slider,5000); }) 
function openTab(tabID) {
    
   // _("w3-bar").innerHTML=""
    tabItems(tabID);         
    var i;
    var x =__("tabs");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    _(tabID).style.display = "block";  
}
</script>
           