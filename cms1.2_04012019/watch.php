<?php  require_once 'config/auth.php'; ?>
<?php $entryID_from_url=$_REQUEST['entryID'];$entryId = $entryID_from_url;?>
<?php require_once 'includes/header.php';?>
<?php //HI ?>


<body onload="initWatchVideo()" onbeforeunload="return initContinueWatching()" id="get_token">
<?php require_once 'includes/navigation.php';?> 
    
    <div class="w3-seprator-top"></div> <!-- 60px top-->
    
     <div class="w3-row darkBar">
        <div class="main-container w3-row-padding ">
            <ol class="w3-breadcrumb"><li><a href="index.php">HOME</a> / </li><li><a href="category.php">CATEGORY</a> / </li><li><a href="" class="last">videos</a></li></ol>
        </div>    
  </div>
    
     <div class="w3-seprator"></div> <!-- 20px margin-->
    
 
  <div class="w3-row ">
        <div class="main-container w3-row-padding">
            <!-- left area-->
            <div class="w3-col l8 s12 m8">
                 <!-- PLAYER-->
                 <div class="w3-content w3-card-2 player w3-animate-opacity" id="watch-video" >
                    <img src="images/banners/placeholderL.jpg" class="w3-images" />
                </div>
                 <!-- !PLAYER-->
                 
                <!-- PLAYLIST ITEMS-->
                <?php if(isset($_REQUEST["pid"])): ?>
                <div class="w3-content player w3-row" id="playlist-video">
                    
                    
                   
                </div>
                <?php endif; ?>
                 <!-- !PLAYLIST ITEMS-->
                
                <div class="w3-seprator10px"></div> <!-- 20px margin-->
                <div class="w3-content w3-card-2 w3-hover-shadow w3-skyblue w3-row-padding">
                    
                     <div class="w3-responsive">
                         <br>
                     <table class="w3-table">
                         <tr><td class="video-title " id="video-title">...</td></tr>
                         <tr class="video-user-action">
                             <td>
                                  <div class="w3-row">
                                     
                                      <table style="margin-top: 10px;min-width: 30%">
                                          <tr><td colspan="3"><div class="w3-time "></div><span id="publish"></span></td></tr>
                                          <tr><td><div class="w3-heart w3-pointer" id="resultlike" onclick="likeDislike('L')"></div> <span id="likes" ></span></td>
                                              <td><div class="w3-heart-break w3-pointer" id="resultdislike"  onclick="likeDislike('D')"></div><span id="dislikes" ></span></td>
                                              <td><div class="w3-views "></div><span id="views"></span></td>
                                          </tr>
                                      </table>
                                     
                                  </div>    
                               </td>
                         </tr>
                         <tr><td colspan="4" >
                                 <div class="w3-addto w3-pointer" onclick="showPlaylist()"></div>Add to 
                                 &nbsp;&nbsp;<span class="w3-pointer">
                                             <div class="dropdown">
                                                <i class="fa fa-share-alt-square fa-2x"></i>
                                                <div class="dropdown-content">
                                                    
                                                    
        
    <a  id="fbShare" href="javascript:" title="Facebook share" ><img src='images/icons/fb.png'  width="32"></a>
 
    <a target="_blank" onclick="return !window.open(this.href, 'Adosphere', 'width=500,height=500,width=500,height=500,left=500, top=100, scrollbars, resizable')" href="https://twitter.com/share?url=<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>&amp;text=Watch video &amp;hashtags=adosphere" title="Twitter share" target="_blank"><img src='images/icons/twitter.png' width="32"></a>
  
    <a target="_blank" target="_blank" onclick="return !window.open(this.href, 'Adosphere', 'width=500,height=500,left=500, top=100, scrollbars, resizable')" href="https://plus.google.com/share?url=<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" title="Google Plus Share" target="_blank"><img src='images/icons/g.png'  width="32"></a>
          
                                             </div>
                                             </div>
                                             </span>
                                 <button class="w3-btn w3-button w3-red btn-custom w3-hover-red w3-right">Subscribe</button>
                                             
                                                 <div id="addToArea"></div>
                                             
                                         
                                         </td>
                         </tr>
                                
                            
                         
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
                <div class="w3-content darkBg relative w3-container description">
                    <p>Related Videos</p> 
                    <hr>
                     <span id="related-video">
                     <span id="related-placeholder">
               
                
                 <?php for($i=0;$i<3;$i++) : ?>
                   
                    <div class="w3-col s12 m4 l4 ">
                    <div class="w3-card-2 vidThumb">
                         <img class="w3-image" src="images/banners/placeholderS.jpg" >
                         
                     </div>
                    </div>
                <?php endfor;?> 
                    
               
                </span>
                </span>
                    <p>&nbsp;</p>
                  <div class="w3-center w3-col s12 m12 l12">
                      <button class="adore-btn " id="load_more_button">Load more</button>
                  </div>
                    
                    
                </div>
                
                <div class="w3-seprator10px"></div> <!-- 20px margin-->
                <div class="w3-seprator10px"></div> <!-- 20px margin-->
                
                <!-- ads--->
                
           <div class="w3-col s12 m12 l12">
           <div class=" " >
           <?php include_once 'includes/adConfig.php';?>
           </div>
           </div>
        
                
                <!-- !ads--->
            
            </div>
            <!-- !left area-->
 
            
            
              
             <!-- right area-->
            <div class="w3-col l4 s12 m4 ">
                <div class="w3-content ">
                    <div class="w3-skyblue w3-row-padding relative">
                        <h4 >Recommended Videos</h4>
                        <hr>
                        <div class="w3-container">
                            
                            
                            <div class="w3-row-padding w3-center" >
                                <div class="w3-col s12 m12 l12 ">
                                <div class="w3-card-2 " style="padding-left: 24px; padding-right: 24px;">
                                <?php include_once("includes/bannerAd.php"); ?>
                                </div>
                                </div>
                                    
                                <div id="recommended_result"  >     
                 <?php for($i=0;$i<1;$i++) : ?>
                     
                                    <div class="w3-col s12 m12 l12 ">
                                        <div class="w3-card-2 ">
                                            <img class="w3-image" src="images/banners/placeholderS.jpg" >
                                                
                                            
                                        </div>
                                    </div>
                <?php endfor;?> 
                    
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
         var page_size=6;
         track_page=track_page+page_size; 
         if(track_page>parseInt(localStorage.getItem("relatedTotalCount")))
         {
             $("#load_more_button").hide();
         }
         else 
         {
	 getRelatedVideo(track_page,page_size); //load content
         
          if(track_page>0)
                { 
                  $("html, body").animate({scrollTop: $("#load_more_button").offset().top}, 800);
                }
         }
});

var url="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>";

document.getElementById('fbShare').onclick = function() {
  FB.ui({
    method: 'share',
    display: 'popup',
    href: url,
  }, function(response){});
}


    </script>
    
    
