<?php  require_once 'config/auth.php'; ?>
<?php
//$getAction=1; // this is come from default.inc.php 
$subCatID=isset($_GET['subCatID']) ? $_GET['subCatID'] : 'empty';
$VideocategorieID=isset($_GET['vcatID']) ? $_GET['vcatID'] :'';
if($subCatID=='empty')
{
	 $categoryIDD=0;
}
if($subCatID!='empty')
{
    $catName=isset($_GET['CatName']) ? $_GET['CatName'] : '';	
    $categoryIDD=$subCatID;
}
if(!empty($VideocategorieID))
{
	$vcatID= $VideocategorieID;
}	

?>
<?php require_once 'includes/header.php';?>
<body onload="initCategory()" id="get_token">
<?php require_once 'includes/navigation.php';?> 
    
    <div class="w3-seprator-top"></div> <!-- 60px top-->
    
     <div class="w3-row darkBar">
        <div class="main-container w3-row-padding ">
            <ol class="w3-breadcrumb" id="cat_nav"><li><a href="index.php">HOME</a> / </li><li><a href="category.php">CATEGORY</a> / </li></ol>
        </div>    
  </div>
    
     <div class="w3-seprator"></div> <!-- 20px margin-->
     
     
     <!-- cards---->
     <!--
    <div class="w3-row">
        <div class="main-container">
            <div class="s12 m12 l12 card-holder w3-row-padding ">
                <div class="relative">
                    <div class="w3-left  w3-hover-text-khaki w3-opacity" style="height:300px;margin-top: 48px; margin-left: 15px; padding: 150px 17px 0 17px; background: rgba(57,6,5,0.9);position: absolute;" onclick="plusCards(-1)">&#10094;</div>
                    <div class="w3-right  w3-hover-text-khaki w3-opacity" style="height:300px; margin-top: 48px; padding: 150px 17px 0 17px;margin-right:15px; background: rgba(57,6,5,0.9);position: absolute;right: 0px;"  onclick="plusCards(1)">&#10095;</div>
              
                </div>
                <h3><span class="text-red">IN THE SPOTLIGHT</span> THIS WEEK</h3>
                    
                <div class="cardSlider  w3-row-padding dsiplayBlock " >
                <?php for($i=0;$i<20;$i++) :?>
                    <div class="w3-col custome-card ">
                    <div class="w3-card-2 cards w3-animate-card">
                         <img src="images/banners/200.jpg" class="w3-image" >
                        <div class="card-text ">
                         <div class="w3-col m7 w3-opacity"><span>CATEGORY</span></div><div class="w3-col m5 w3-opacity w3-right-align"><span >2 Hours ago</span></div>
                         <h5 class=""><?php echo $i; ?><?php subString("Water Adventure in Staying Young",26);?></h5>
                         <p class="w3-opacity"><?php subString("Watch Aatadukundam Ra Movie Theatrical Trailer, Starring Sushanth, Sonam, Brahmanandam, Vennala Kishore, Prudhvi Raj and Murali Sharma. Music by Anoop Rubens. Directed by G.Nageswar Reddy. Produced by Chinthalapudi Srinivas, A Naga Susheela.", 100) ?></p>
                        </div>
                     </div>
                    </div>
                <?php endfor;?> 
                </div>
            </div>
        </div>    
    </div>-->
   <!-- !cards---->


     
<div class="w3-row fullHeight">
   <div class="main-container w3-row-padding w3-container">
            <!-- left area-->
            <div class="w3-col l9 s12 m9">
     
                <div class="darkBg  w3-container w3-card-2 fullHeight">
                    <h2 id="category-title">All Categories </h2> 
                    <hr>
                    <div id="categorie_result1"></div>
                    <div id="categorie_result">
                        <div class="w3-row " >
                          <?php for($i=0;$i<3;$i++) : ?>
                   
                            <div class="w3-col s12 m4 l4 ">
                            <div class="w3-card-2 vidThumb">
                              <img class="w3-image" src="images/banners/placeholderS.jpg" >
                             
                            </div>
                           </div>
                           <?php endfor;?> 
                    
                         </div>
                        
                    </div>
                    <!--<p class="w3-center"><button class="w3-btn w3-button w3-gray w3-small">Show more</button></p>-->
                    
              </div>
                
                <div class="w3-seprator-top"></div>    
      <!--ads--->             
 <div class=" w3-center">
 
     
 
        <div class="w3-col s12 m12 l12">
        <?php include 'includes/adConfig.php';?>
       </div>
 </div>
 <!--!ads--->
                
                
            </div>
             <!-- !left area-->
              
             <!-- right area-->
             <div class="w3-col l3 s12 m3 ">
                    <div class="w3-content ">
                        <div class="w3-skyblue w3-row-padding relative" style="min-height: 230px;">
                        <h3 >Category List</h3>
                        <hr>
                        <div class="w3-container ">
                            <div class="w3-row-padding w3-center " id="sidebar">
                                
                               
                                
                            </div>
                            <br>
                        
                       </div>    
     
                      </div> 
                        
                        
                         <div class="w3-seprator"></div>
                <div class="w3-skyblue w3-row-padding ">
                     <h3 >Social Fans</h3>
                        <hr>      
                   
                        
                         <?php include 'includes/socialfans.php';?>
                        
                        <br>
                    
                </div>
                         
                         
                                    
                <div class="w3-seprator"></div>
                <!-- ads-->
                <div class="w3-row">
                          
                  <div class="w3-col s12 m12 l12">
                        <div class="" >
                         <?php include 'includes/adConfig.php';?>
                        </div>
                    </div>
                            
                    
                        
                 
                    
                </div>
                <!-- ads-->
                        
                    </div>
            </div>
    </div>    
</div>     
     

  <div class="w3-seprator"></div>
   <div class="w3-seprator"></div>
    <div class="w3-seprator"></div>
  

<?php require_once 'includes/footer.php';?>
     
    <script>   
    function myAccFunc(id) {
    localStorage.setItem("accoId",id);
    var x = _("accord"+id);
    var y=_("plus"+id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        x.previousElementSibling.className += " w3-active";
        y.classList.remove("fa-plus");
        y.classList.add("fa-minus");
    } else { 
        x.className = x.className.replace(" w3-show", "");
        x.previousElementSibling.className = 
        x.previousElementSibling.className.replace(" w3-active", "");
        y.classList.add("fa-plus");
        y.classList.remove("fa-minus");
    }
}    
    </script>   
