<?php  require_once 'config/auth.php'; ?>
<?php require_once 'includes/header.php';?>
<body onload="initLiveTv()" id="get_token" style="background:url('http://adosphere.adore.sg/images/banners/channelBg.png') center fixed">
<?php require_once 'includes/navigation.php';?> 
    
    <div class="w3-seprator-top"></div>
    
    <!-- slider--> 
    <div class="w3-row">
        <div class="s12 m12 l12 w3-col">
      
            <img class="w3-image" width="100%" src="images/banners/channel.jpg">
              
       </div>
  
   </div>
   <!-- !slider--> 
   
  <!-- Tab Buttons-->    
<div class="w3-row w3-black">
    <div class="main-container w3-row-padding" id="w3-bar">
           
        <!--- Tab item will appear here from function  tabItems() -->
           
        </div>    
</div>
<!-- !tab Buttons-->  

 <!-- Tab Container--> 
<div class="w3-row channel-container">
    <div class="main-container w3-row-padding" >
           
             <div id="liveTv" class="tabs">
                
               </div>  
        
        
        
        
                





     
    </div>
    
    
    <!--- ads --->
    <div class="w3-seprator-top "><h1>&nbsp;</h1><h1>&nbsp;</h1></div> <!-- 20px margin--> 
    <div class="w3-seprator-top "><h1>&nbsp;</h1><h1>&nbsp;</h1></div> <!-- 20px margin--> 
    
 <div class="w3-row-padding w3-center">
 
 
 
        <div class="w3-col s12 m12 l12">
           
            <?php include_once 'includes/adConfig.php';?>
       </div>
 </div>
 <!--!ads--->
   
</div>
<!-- !Tab Container-->      
    
   
 
    
  

<?php require_once 'includes/footer.php';?>    
    
<script>

tabItems("liveTv");       
        
    
function tabItems(activeId)
{
  
    
    var tab='<button class="w3-bar-item " id="tabliveTv" onclick=openTab("liveTv") >Entertainment</button>';
        
        
        _("w3-bar").innerHTML=tab;
        _("tab"+activeId).classList.add("active-bar");   
            
}
        
function openTab(tabID) {
    
    _("w3-bar").innerHTML=""
    tabItems(tabID);         
    var i;
    var x =__("tabs");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    _(tabID).style.display = "block";  
}
</script>
           
