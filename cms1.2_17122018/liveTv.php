<?php  require_once 'config/auth.php'; ?>
<?php require_once 'includes/header.php';?>


<body onload="viewChannel()" id="get_token">
<?php require_once 'includes/navigation.php';?> 
    
    <div class="w3-seprator-top"></div> <!-- 60px top-->
    
     <div class="w3-row darkBar">
        <div class="main-container w3-row-padding ">
            <ol class="w3-breadcrumb"><li><a href="index.php">HOME</a> / </li><li><a href="channels.php">live TV</a> / </li><li><a href="" class="last">channel</a></li></ol>
        </div>    
  </div>
    
     <div class="w3-seprator"></div> <!-- 20px margin-->
    
 
  <div class="w3-row fullHeight">
        <div class="main-container w3-row-padding">
            <!-- left area-->
            <div class="w3-col l8 s12 m8">
                 <!-- PLAYER-->
                <div class="w3-content w3-card-2 player w3-animate-opacity" id="watch-video">
                    <!--<img src="images/banners/placeholderL.jpg" class="w3-images" />-->
                </div>
                 <!-- !PLAYER-->
                 
               
                
                <div class="w3-seprator10px"></div> <!-- 20px margin-->
                <div class="w3-content w3-card-2 w3-hover-shadow w3-skyblue w3-row-padding">
                    
                     <div class="w3-responsive">
                         <br>
                     <table class="w3-table">
                         <tr><td class="video-title " id="video-title">...</td></tr>
                        <!-- <tr class="video-user-action">
                             <td>
                                  <div class="w3-row">
                                      <div class="w3-col s12 m2 l2"><i class="fa fa-2x fa-clock-o" style="float: left;"></i><span id="publish"></span></div>
                                      <div class="w3-col s4 m1 l1"><div class="w3-heart w3-pointer" id="resultlike" onclick="likeDislike('L')"></div> <span id="likes" ></span></div>
                                      <div class="w3-col s4 m1 l1"><div class="w3-heart-break w3-pointer" id="resultdislike"  onclick="likeDislike('D')"></div><span id="dislikes" ></span></div>
                                      <div class="w3-col s4 m1 l1"><i class="fa fa-2x fa-eye" style="float: left;"></i><span id="views"></span></div>
                                  </div>    
                               </td>
                         </tr>
                         <tr><td colspan="4" ><div class="w3-addto w3-pointer" onclick="showPlaylist()"></div>Add to<button class="w3-btn w3-button w3-red btn-custom w3-hover-red w3-right">Subscribe</button>
                                             
                                                 <div id="addToArea"></div>
                                             
                                         
                                         </td>
                         </tr>
                           -->     
                            
                         
                     </table>
                         <br>
                     </div> 
                         
                </div>
                
                
                
                <div class="w3-seprator10px"></div> <!-- 20px margin-->
                <div class="w3-content w3-skyblue  w3-container description">
                    <h2>Description</h2> 
                    <hr>
                    <p id="discription">Loading...</p>  
                    
                    
                    
                    <!--<p class="w3-center"><button class="w3-btn w3-button w3-gray w3-small">Show more</button></p>-->
                    
                </div>
                
                
                
                <div class="w3-seprator10px"></div> <!-- 20px margin-->
                
                
                
            
            </div>
            <!-- !left area-->
              
             <!-- right area-->
            <div class="w3-col l4 s12 m4 ">
                <div class="w3-content ">
                <div class="w3-skyblue w3-row-padding ">
                        <h4 >Recommended Videos</h4>
                        <hr>
                        <div class="w3-container">
                            
                            
                            <div class="w3-row-padding w3-center" >
                                <div class="w3-col s12 m12 l12 ">
                                    <div class=" " style="padding-left: 24px; padding-right: 24px;">
                                        <?php include_once 'includes/adConfig.php';?>
                                     </div>
                                </div>
                                    
                                <div id="recommended_result"  >     
                
                                </div>    
                            </div>
                                
                                
                        </div>
                            
                            
                            
                            
                    </div>
                
                </div>
                <div class="w3-seprator"></div>
                <div class="w3-skyblue w3-row-padding ">
                     <h4 >Social Fans</h4>
                        <hr>      
                   
                        
                        <?php include 'includes/socialfans.php';?>
                        
                        <br>
                    
                </div>
            
                        
            
            </div>
            <!-- right area-->
            
        </div> 
  </div>
  
  
  
 
  
  
  
  
  
  
  <div class="w3-seprator"></div>
   <div class="w3-seprator"></div>
    <div class="w3-seprator"></div>
  

<?php require_once 'includes/footer.php';?>
  <!--<script type="text/javascript" src="layouts/js/app.js"></script>-->
    <script>
    var track_page =0; 
$("#load_more_button").click(function (e) { //user clicks on button
    
	 $("#load_more_button").html('<center><div class="slice" > <div data-loader="spinner"></div></div></center>');
          //page number increment everytime user clicks load button
         var page_size=8;
         track_page=track_page+page_size;
	 getRelatedVideo(track_page,page_size); //load content
         
          if(track_page>0)
                { 
                  $("html, body").animate({scrollTop: $("#load_more_button").offset().top}, 800);
                }
});
    </script>
    
    
