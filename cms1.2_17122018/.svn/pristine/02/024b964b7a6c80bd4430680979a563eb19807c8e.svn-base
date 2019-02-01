<?php
// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
?>

<?php  require_once 'config/auth.php'; ?>
<?php if(empty($_SESSION['user_id'])){   header("Location:index.php");}?>
<?php require_once 'includes/header.php';?>
<body onload="initMyAccount()" id="get_token" >
<?php require_once 'includes/navigation.php';?> 
    
    <div class="w3-seprator-top"></div> <div class="w3-seprator"></div>
   <!-- !seprater-->    
 

 <!-- Tab Container--> 
<div class="w3-row channel-container" style="min-height: 100%;">
    <div class="main-container ">
        
        <div class="w3-col s12 m1 l1 w3-row-padding" id="w3-bar">
           
        </div>
        
        <div class="w3-col s12 m10 l10 w3-row-padding">
            <div id="profile" class="tabs w3-card-2 border-radius4 w3-col" style="padding:0px; color: #000;">
              
                <div class="w3-skyblue border-radiusTop4"><h3>Profile</h3><p><small>Edit your profile</small></p></div>
                
                <div class="w3-col w3-third w3-center"><img id="image-holder" src="images/img_user.png" class="w3-circle" width="164" ></div>
                <div class="w3-col w3-half">
                    
                     
                    <form id="upload_form" enctype="multipart/form-data" type="POST" action="javascript:" onsubmit="saveImgeProfile()" style="margin-top:30px;" >
                        <input type="file" required="" id="fileUpload">
                       
                        <p>Max size of 50 KB (100x100)</p><p>Allowed format jpg,png,gif</p>
                        <button type="submit" class="adore-btn btn-sm">Upload</button>
                        
                    </form>
                    
                    
                    
   
                    
                    
                </div>
                
                <div class="w3-col" style="padding:0px;"><hr></div>
                <div class="w3-col m12 l12 s12 ">
                    <center>
                        <form action="javascript:" method="" onsubmit="return SaveEditUserProfile()">
                    <table style="min-width:60%">
                    <tr><td>Full Name</td><td><input type="text" required="" id="fullname" placeholder="Full name"></td></tr>
                    <tr><td>Email</td><td><input type="email"  disabled="" required="" id="email" placeholder="Registered email"></td></tr>
                    <tr><td>Mobile</td><td><input type="text" pattern="[0-9]{10}" title="10 digit number"required="" id="mobile" placeholder="Mobile"></td></tr>
                    <tr><td>DOB</td><td><select class="select-sm" id="day" required=""><?php for($i=0;$i<=31;$i++): ?><?php if($i==0)echo "<option value=''>Date</option>"; else echo "<option>".$i."</option>";?><?php endfor; ?></select><select id="month" class="select-sm"  required=""><?php for($i=0;$i<=12;$i++): ?><?php if($i==0)echo "<option value=''>Month</option>"; else echo "<option>".$i."</option>";?><?php endfor; ?></select><select id="year" class="select-sm"  required=""><?php for($i=1960;$i<=date("Y");$i++): ?><option><?php echo $i;?></option><?php endfor; ?></select></td></tr>
                    <tr><td>Gender</td><td><select id="userGender" required=""><option>Female</option><option>Male</option></select></td></tr>
                    <tr><td>Country</td><td><select id="country" required="" onclick="load_contents_country_state()"><option>Select country</option></select></td></tr>
                    <tr><td>State</td><td><select id="state" required=""><option>Select state</option></select></td></tr>
                    <tr><td>&nbsp;</td><td ><button type="submit" class="adore-btn">Save change</button></td></tr>
                     
                </table>
                </form>  
                    </center>
                </div>
            </div>  
            
            <div id="password" class="tabs displayNone w3-card-2 border-radius4">
                <div class="w3-row-padding" style="padding:0px;color: #000;"> 
                    <div class="w3-skyblue border-radiusTop4"><h3>Password</h3><p><small>Update your password</small></p></div>
               
                
                <div class="w3-col m12 l12 s12 ">
                    <center>
                        <form action="javascript:" method="" onsubmit="return ChangePassword()">
                    <table style="min-width:50%">
                    <tr><td>Old password</td><td><input type="password" required="" id="oldpass" placeholder="old password"></td></tr>
                    <tr><td>New password</td><td><input type="password" required="" id="newpass" placeholder="new password"></td></tr>
                    <tr><td>Confirm password</td><td><input type="password" required="" id="cnfpass" placeholder="re-type new password"></td></td></tr>
                    
                    <tr><td colspan="2" align="center"><button type="submit" class="adore-btn ">Save change</button></td></tr>
                    <tr><td id="passResponse" colspan="2" align="center"></td></tr> 
                </table>
                </form>  
                    </center>
                </div>
                </div>  
                 
                 
            </div>  
        
            <div id="plan" class="tabs displayNone  w3-card-2 border-radius4">
                  <div class="w3-row-padding" style="padding:0px"> 
                      <div class="w3-skyblue border-radiusTop4"><h3>Subscription Plan</h3><p><small>Plan details</small></p></div>
               
                
                    <div class="w3-col m12 l12 s12 ">
                        <h4>CURRENT SUBSCRIPTION</h4>
                        <table class=" w3-responsiv planTable" border="1" bordercolor="#2A2A2A">
                            <tr class="w3-orange "><td>Plan</td><td>Period</td><td>Rate</td><td>Date</td><td>Expiry</td><td>Status</td></tr>
                            <tr class="w3-text-black"><td>Monthly</td><td>30 days</td><td>Rs 100</td><td>10 March</td><td>10 April</td><td><i class="fa fa-circle w3-text-red"></i></td></tr>
                          
                        </table>                        
                    </div>
                    
                    <div class="w3-col w3-seprator-top"></div>
                    
                    <div class="w3-col m12 l12 s12  w3-center">
                    
                        <a href="javascript:" class="adore-btn btn-lg marginB10">View payment history</a>
                        <a href="javascript:" class="adore-btn btn-lite btn-lg  marginB10">view subscription history</a>
                                               
                    </div>
                   
                    
                   <div class="w3-col w3-seprator-top"></div>
                   
                   <div id="Plansubscription"><!-- plans boxes-->
                   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                  
                   
                   </div><!-- !plans boxes-->
                   
                   
                    
                </div>  
               
            </div>  
        
        
        </div>
           
             
        
        
                





     
    </div>
</div>
<!-- !Tab Container-->      
    
    
 
   
    
  

<?php require_once 'includes/footer.php';?>  

<style>
    
  #w3-bar button{width:62px; margin: 0px 20px 20px 0px;;}  
  .fa-credit-card{padding: 7px 0 7px 0;font-size:22px;}
  .tabs{min-height: 200px;padding: 0px;font-size: 17px;}
  .tabs h3{margin-bottom: 1px;}
  .tabs div{padding-left: 5px; padding-top: 1px;}
  button{font-weight: bold; margin-left: 0px;}
 .tabs input[type=file]{padding: 0px;font-size: 10px;}
 .tabs  input[type=text],input[type=password],input[type=email],select{padding: 5px;width: 180px;}
  .select-sm{width:57px; margin-right: 0px;}
</style>
  
<script>

tabItems("profile");       
        
    
function tabItems(activeId)
{
    var tab='<button class="w3-button w3-btn w3-black border-radius4" id="tabprofile" onclick=openTab("profile")><i class="fa fa-user fa-2x"></i></button>';
        tab+='<button class="w3-button w3-btn w3-black border-radius4" id="tabpassword" onclick=openTab("password")><i class="fa fa-lock fa-2x"></i></button>';
        tab+='<button class="w3-button w3-btn w3-black border-radius4" id="tabplan" onclick=openTab("plan")><i class="fa fa-credit-card " ></i></button>';
        
        
        _("w3-bar").innerHTML=tab;
        _("tab"+activeId).classList.remove("w3-black");   
        _("tab"+activeId).classList.add("w3-skyblue");   
            
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
    

<script type="text/javascript">
var tagName="country" ; //track user click as page number, righ now page number 1
load_contents_country_state(tagName); //load content

//Ajax load function
function load_contents_country_state(tagName){
         //var user = "PlanetCastM";  var pass = "p1@netc@$t";
         $.ajax({
                url: GET_REGION,
                
                method: 'POST',
                dataType: 'json', 
                data:{ 'tag':tagName,'partnerid':PARTNER_ID},
                    success: function(jsonResult){
                    var clen=jsonResult.Countrylist.length;
                    var options_str = "";
                    options_str += '<option value="">Select Country</option>';
                    for (var i = 0; i < clen; i++) 
                    {
                       var countryName=jsonResult.Countrylist[i].country;
                       var countryCode=jsonResult.Countrylist[i].code;  
                       options_str += '<option value="' + countryCode + '">' + countryName + '</option>';
                    }    
                document.getElementById("country").innerHTML=options_str; 
            }
      });	
}
  
function buildState(countryCode,selectedState)
{
           if(countryCode){
           $.ajax({
                url: GET_REGION,
               
                method: 'POST',
                dataType: 'json', 
                data:{ 'tag':"city",'code':countryCode},
                    success: function(jsonResult){
                    var citylen=jsonResult.Citylist.length;
                    if(citylen=='0')
                    {
                         document.getElementById("state").innerHTML='<option value="">Not State In this Country</option>';
                    }
                    else
                    {    
                        var options_str = "";
                        for (var i = 0; i < citylen; i++) 
                        {
                            
                           var cityName=jsonResult.Citylist[i].city;
                           var sel=(cityName==selectedState) ? "selected" : ""; //alert(sel+""+cityName+""+selectedState);
                           options_str += '<option value="' + cityName + '" '+sel+'>' + cityName + '</option>';
                        }    
                       document.getElementById("state").innerHTML=options_str; 
                  }
            }
      });	
        }else{
            $('#state').html('<option value="">Select country first</option>');
          
        }
}

     
   
 $(document).ready(function(){
    $('#country').on('change',function(){
        var countryCode = $(this).val();
         buildState(countryCode)
    });        
});



</script>

<script type="text/javascript">  
   $(document).ready(function() {
        // $("#savePhoto").prop("disabled",true);
         $("#ShowButtons").hide();
         $("#fileUpload").on('change', function() {
        
          //Get count of selected files
         var countFiles = $(this)[0].files.length;
          var imgPath = $(this)[0].value;
          var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
          var imgFileSize = this.files[0].size;
          var image_holder = $("#image-holder");
          image_holder.empty();
          $("#savePhoto").prop("disabled",false);
          if(imgFileSize<51200)
          {
          if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof(FileReader) != "undefined") {
            
              for (var i = 0; i < countFiles; i++) 
              {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image"
                  }).appendTo(image_holder);
                }
                image_holder.show();
                reader.readAsDataURL($(this)[0].files[i]);
                 $("#ShowButtons").show();
              }
              
            }
             else {
              alert("This browser does not support FileReader.");
            }
            
            
          } else {
            alert("Invalid file format.");
          }
         }
         else
         {
              alert("Image file size max 50 KB");
         }
          
    
          
        });
      });
</script>
<script>
function saveImgeProfile()
{  
       var imageName=document.getElementById("fileUpload").value; 
       //var useriD=document.getElementById("useridd").value;
       var apiBody = new FormData($('#upload_form')[0]);
       apiBody.append("partnerid",PARTNER_ID);
       apiBody.append("fileAction","profileimage");
       apiBody.append("uid",Userid);
       apiBody.append('data', $('input[type=file]')[0].files[0]);
       //var user = "PlanetCastM";  var pass = "p1@netc@$t";
	  $.ajax({
                url: GET_UPLOAD_USER_IMAGE,
               
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                //contentType: 'multipart/form-data',
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                      var image_url=jsonResult.image_url; 
                     
                      //alert(image_url);
                      _('image-holder').src=image_url;
                      notification(jsonResult.Message);
                    }
            });	

}     
    
</script>