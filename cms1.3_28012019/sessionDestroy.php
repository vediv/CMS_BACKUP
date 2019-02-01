<?php  require_once 'config/auth.php'; ?>
<?php require_once 'includes/header.php';?>
<body onload="getMenu()" id="get_token">
<?php require_once 'includes/navigation.php';?>    
   


<div class="w3-display-container w3-text-white">
    <img class="w3-image" width="100%" src="images/banners/placeholderL.jpg">
   
    <div class="w3-display-middle w3-large"><a href="logout.php?tokFlag=False" class="w3-btn w3-button w3-green ">Restore Session</a></div>

<div id="id01" class="w3-modal w3-animate-opacity" style="display:block; ">
    <div class="w3-modal-content w3-card-8" style="width:30%; top:32%;">
      <header class="w3-container w3-red"> 
        <span onclick="document.getElementById('id01').style.display='none'" 
        class="w3-closebtn">&times;</span>
        <h3>Your session has expired</h3>
      </header>
        <div class="w3-center"><br><a href="logout.php?tokFlag=False" class="w3-btn w3-button w3-green w3-hover-green">Restore Session</a><br><br></div>
    </div>
  </div>
</div>
   </div>

</body>
</html>

