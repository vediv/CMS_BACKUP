<?php 
include_once 'corefunction.php';
$entryId=$_POST['Entryid'];
$publisher_unique_id=$_POST['partner_uniqueid'];
$duration=$_POST['duration']; 
$msDuration=$duration*1000;

//echo "second=".$duration."---".$msDuration;

$time_format=gmdate("H:i:s", $duration);
if(in_array(4,$UserRight)){ $disable=""; } else  { $disable="disabled";  }
?>	
<style type="text/css">
    .duration span { left: 0px !important; }
</style>

<div id="row">
<div id="load_in_modal" style="display:none; "></div>
<div class="row"  style="margin-top: 0px;">
    <div class="col-md-6">
        <div class="box">
            <form class="form-horizontal" method="post" id="advertisementShow">   
          <div class="box-body">
                <div class="form-group">
                 <label class="control-label col-sm-2" for="email">Name*:</label>
                 <div class="col-sm-10">
                    <input type="text" id="service_name"   name="service_name" class="form-control"  />
                 </div>
                </div>
                <div class="form-group">
                     <label class="control-label col-sm-2" for="email">Timing*:</label>
                     <div class="col-sm-10">
                        <input type="text" id="cue_time" name="cue_time" value="" placeholder="HH:MM:SS" class="form-control" />
                         <input type="hidden" id="totalvideoduration" name="totalvideoduration" value="<?php echo $msDuration; ?>" placeholder="HH:MM:SS"  />
                         <input type="hidden" id="totaltime_only_format"  name="totaltime_only_format" value="<?php echo $time_format; ?>" placeholder="HH:MM:SS"  />
                     </div>
                </div> 
                <div class="form-group">
                   <label class="control-label col-sm-2" for="email">URL*:</label>
                   <div class="col-sm-10">
                      <textarea name="adurl" id="adurl" cols="26" class="form-control" style="resize: none; width:100%;" ></textarea>
                   </div>
                </div> 
               <div class="form-group">
                   <label class="control-label col-sm-2" for="email">Status:</label>
                   <div class="col-sm-10">
                     <select id="advStatus" name="advStatus"  class="form-control">
                        <option value="1">Show to free users</option>
                        <option value="0">Show to all</option>
                    </select>
                   </div>
                </div> 
          </div>
            <div class="box-footer clearfix">
            <?php  if(in_array(2, $UserRight)){ ?>    
            <input  type="button" class="btn btn-info " id="saveAds"   value="save" onclick="insertadds();" />
            <span id="delBtn"></span>
            <?php } else { ?>
            <button type="button" class="btn btn-info" disabled  name="submit">Save</button>
            <?php } ?>
            
            </div>
         </form>    
        </div>
    </div>
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?php echo "Total Video Duration: " .$time_format; ?></h3>
        </div>
        <!--<div class="box-body no-padding">
         video preview
        </div>-->
      </div>

    </div>
</div>
<style>
    .duration{padding:2px 5px 2px 5px; color: #000; border-left: 1px solid #000; margin-right: 12px;float: left;width: 65px;position: relative;min-height: 10px;}   
    .duration span{position: absolute;top:-20px;left: -15px;}
</style> 
<div class="row">
    <div class="col-xs-12">
      <div class="box">
          <strong><h4 class="box-title text-center"  id="msgContain"></h4></strong>
        <div class="box-header"></div>
        <div class="box-body" style="border: 0px solid grey; margin-top:5px;" >
             
        <div id="divnew" style="width:100%;border-bottom: 0px solid red; float: left;">
            <div id="newdiv" style="width:100%;">

            </div>
     </div>
        <div id="divnew" style="width:100%;height:150px;border:0px solid #ccc;border-top:none;position: relative;">
            <div id="cuePoints" style="width:100%;">

            </div>
        </div>
          <div id="result_advertisement" style="border: 0px solid grey;"></div>
      </div>
      </div>
    </div>
</div>
</div>
<script type="text/javascript" src="js/jquery.maskedinput.js"> </script>
<script type="text/javascript">
    jQuery(function($){
       $("#cue_time").mask("29:59:59");
    });
</script>
<script type="text/javascript">
cuePoints=[];  adCount=0;adIds=[];adName=[];adStatus=[];adUrl=[];
function timeToSec(myTime)
{
	var myStime = myTime.split(":");
   	var hh = parseInt(myStime[0]) * 60 * 60;
   	var mm = parseInt(myStime[1]) * 60;
   	var ss = parseInt(myStime[2]);
        return (hh+mm+ss);
}
function settotime(i){
 
 var hour,min,sec;
 if(i<60)
{
    hour="00";
    min="00";
    sec=(i<10)?"0"+i:i;
}
else if(i>=60&&i<3600)
{
var m=parseInt(i/60);var s=i%60;

    hour="00";
    min=(m<10)?"0"+m:m;
    sec=(s<10)?"0"+s:s;
}
else if(i>=3600)
{
 var h=parseInt(i/3600);m=parseInt((i%3600)/60);var s=(i%3600)%60;

    hour=(h<10)?"0"+h:h;
    min=(m<10)?"0"+m:m;
    sec=(s<10)?"0"+s:s;   
}
s=(Math.ceil(sec)<10)?"0"+Math.ceil(sec):Math.ceil(sec);
var fulltime=hour+":"+min+":"+s;
return fulltime;

}

</script>


<script type="text/javascript">
var adcueURl="<?php  echo $apiURL."/adcue" ?>";    
var partnerid = "<?php echo $publisher_unique_id; ?>"; 
var entryid = "<?php echo $entryId; ?>";
var totalVideoduration = "<?php echo $duration; ?>";
drawTimline(totalVideoduration);
load_contents(); 
function load_contents(){
    cuePoints=[];adIds=[];adName=[];adStatus=[];adUrl=[];
        $.ajax({
                url: adcueURl,
                method: 'POST',
                dataType: 'json',
                crossDomain: true,
                data:{ 'partnerid':partnerid,'tag':"view",'entryid':entryid},
                success: function(jsonResult){
                var status=jsonResult.status;
                var len=jsonResult.length;
               //console.log(jsonResult);
                
                if(status!=0 || status=='')
                {    
                /*var tabledata='';
                tabledata+='<table id="example1" class="table table-fixedheader table-bordered table-striped">';
                tabledata+='<thead>';
                tabledata+='<tr><th>Name</th><th>StartTime</th><th>URL</th><th>Status</th><th>Action</th></tr>';
                tabledata+='</thead>';
                tabledata+='<tbody>';*/
                adCount=len; 
                for(var i = 0; i < len ; i++)
                {
                     var name=jsonResult[i].name; var url=jsonResult[i].URL;
                     var startTime=jsonResult[i].startTime; var Adv_id=jsonResult[i].Adv_id; 
                     var Adv_status=jsonResult[i].Adv_status;
                     
                     cuePoints.push(startTime);
                     adIds.push(Adv_id);
                     adName.push(name);
                     adStatus.push(Adv_status);
                     adUrl.push(url);
                     
                  /*tabledata+='<tr>'; 
                tabledata+='<td>'+name+'</td>';
                tabledata+='<td>'+startTime+'</td>';
                tabledata+='<td>'+url+'</td>';
                tabledata+='<td>'+Adv_status+'</td>';
                tabledata+='<td>';
                tabledata+='<a href="#" onCLick="removeAds(\''+Adv_id+'\')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>&nbsp&nbsp&nbsp';
                tabledata+='<a href="#" onCLick="updateAds(\''+Adv_id+'\')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                tabledata+='</td>';
                tabledata+='</tr>';  */ 
                }
                /*tabledata+='</tbody>';
                tabledata+='</table>';*/
        
                 //var status=jsonResult.status;
                 //var msg=jsonResult.Message;
                 //$("#result_advertisement").html(tabledata);
                 
                 //alert(cuePoints);
                 
                 //console.log(len);
                 
                 cre(totalVideoduration);
                 
                } 
                if(status==0)
                { $("#msgContain").html("No Ads Data Available"); }               
                 
            }
      });	
}

function insertadds()
{
    var name = $('#service_name').val();	
    var cue_time = $('#cue_time').val();
    var startTime=timeToSec(cue_time);
    var adurl = $('#adurl').val();
    var advStatus = $('#advStatus').val();
    var totalvideoduration = $('#totalvideoduration').val();
    var totaltime_only_format = $('#totaltime_only_format').val();
    var startTimeInMS=(startTime)*1000;
    var regForUrl = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    if(name=='')
    {
        alert("Name Required") ;  
            return false;   
    }    
    else if(cue_time=='')
    {
        alert("Time Required") ;  
            return false;   
    } 
    else if(cue_time=='00:00:00')
    {
        alert("Time should be greater than 00:00:00") ;  
            return false;   
    }
    else if(startTimeInMS > totalvideoduration)
    {
            alert("Your start Time :"+cue_time+ " is greater than total video time duration="+totaltime_only_format) ;  
            return false;
    }    
    else if(adurl=='')
    {
         alert("URL Required") ;  
            return false;   
    }
    else if(!regForUrl.test(adurl)) {
      alert('Invalid URL-- missing "http://" or "https://"'); return false;
     }
    var partnerid = "<?php echo $publisher_unique_id; ?>"; 
    var entryid = "<?php echo $entryId; ?>"; 
    $('#load_in_modal').show();
    $('#row').css("opacity",0.1);
     $.ajax({
                url: adcueURl,
                method: 'POST',
                dataType: 'json',
                crossDomain: true,
                data:{ 'partnerid':partnerid,'name':name,'entryid':entryid,'starttime':startTime,'url':adurl,'tag':"insert",'status':advStatus},
                success: function(jsonResult){
                console.log(jsonResult);
                var status=jsonResult.status;
                var Message=jsonResult.Message;
                $('#load_in_modal').hide();
                $('#row').css("opacity",1);
                if(status==1)
                {
                   //alert("Data Successfully Inserted");
                    load_contents();
                    $("#service_name").val("");
                    $("#cue_time").val("");
                    $("#adurl").val("");
                    $("#msgContain").html(Message);
                    
                }    
                if(status==2)
                {
                    $("#msgContain").html(Message);
                    
                } 
                     
                
            }
      });	    
    
    
}
function removeAds(advId)
{
     var entryid = "<?php echo $entryId; ?>"; 
     var a=confirm("Are you sure want to delete This?")
     if(a==true)
     { 
      
       $.ajax({
                url: adcueURl,
                method: 'POST',
                dataType: 'json',
                crossDomain: true,
                data:{'adv_id':advId,'entryid':entryid,'tag':"delete",'partnerid':partnerid},
                success: function(jsonResult){
                //console.log(jsonResult);
                var status=jsonResult.status;
                //console.log(status);
                var Message=jsonResult.Message;
                if(status==3)
                {
                    alert("Successfully Removed"); 
                    $("#service_name").val("");
                    $("#cue_time").val("");
                    $("#adurl").val("");
                    $("#saveAds").attr("onclick","insertadds()");
                    $("#saveAds").attr('value', 'Save');
                    $("#delBtn").html("");
                    load_contents();
                }    
                $("#msgContain").html(Message);
                
                 
            }
      });    
    
     }
     else
     {
         return false;
     }
}


function updateAds(advId)
{
  
      var entryid = "<?php echo $entryId; ?>"; 
      var disable = "<?php echo $disable; ?>";
       $.ajax({
                url: adcueURl,
                method: 'POST',
                dataType: 'json',
                crossDomain: true,
                data:{'adv_id':advId,'entryid':entryid,'tag':"view",'partnerid':partnerid},
                success: function(jsonResult){
                 var status=jsonResult[0].status;
                 if(status==1)
                 {  
                     var name=jsonResult[0].name;
                     var startTime=jsonResult[0].startTime; 
                     //alert(startTime);
                     var timeFormat=settotime(startTime);
                     var url=jsonResult[0].URL;
                     var Adv_id=jsonResult[0].Adv_id;
                     $("#service_name").val(name);
                     $("#cue_time").val(timeFormat);
                     $("#adurl").val(url);
                     $("#saveAds").attr("onclick","finalUpdateAds('"+Adv_id+"')");
                     $("#saveAds").attr('value', 'Update');
                     $("#delBtn").html('<input  type="button" class="btn btn-info" id='+Adv_id+'  '+disable+'   value="Delete" onclick="removeAds(\''+Adv_id+'\');" />');
                  }    
                
            }
      });    
     
    
}

function finalUpdateAds(Advid) 
{
    
     var name = $('#service_name').val();	
     var cue_time = $('#cue_time').val();
     var startTime=timeToSec(cue_time);
     var adurl = $('#adurl').val();
     var advStatus = $('#advStatus').val();
     var totalvideoduration = $('#totalvideoduration').val();
     var totaltime_only_format = $('#totaltime_only_format').val();
     var startTimeInMS=(startTime)*1000;
    if(name=='')
    {
        alert("Name Required") ;  
            return false;   
    }    
    if(cue_time=='')
    {
        alert("Time Required") ;  
            return false;   
    }    
    if(adurl=='')
    {
        alert("URl Required") ;  
            return false;   
    }    
    if(startTimeInMS > totalvideoduration)
    {
            alert("Your start Time :"+cue_time+ " is grether then total video time duraion="+totaltime_only_format) ;  
            return false;
    }    
    var partnerid = "<?php echo $publisher_unique_id; ?>"; 
    var entryid = "<?php echo $entryId; ?>"; 
   
    $.ajax({
    url: adcueURl,
    method: 'POST',
    dataType: 'json',
    crossDomain: true,
    data:{ 'partnerid':partnerid,'name':name,'entryid':entryid,'starttime':startTime,'url':adurl,'tag':"update",'status':advStatus,'adv_id':Advid},
    success: function(jsonResult){
      console.log(jsonResult);
    var status=jsonResult.status;
    var Message=jsonResult.Message;
    
    if(status==1)
    {
        load_contents();
        $("#msgContain").html(Message);
    }    
    if(status==2)
    {
        $("#msgContain").html(Message);
    }  
    if(status==3)
    {
        //$("#msgContain").html("Data Update succesfully");
        alert("Data Successfully Updated");
        $("#service_name").val("");
        $("#cue_time").val("");
        $("#adurl").val("");
        $("#saveAds").attr("onclick","insertadds()");
        $("#saveAds").attr('value', 'Save');
        drawTimline(totalVideoduration);
        load_contents();  
       
    }    



}
      });	    
    
}
var sum=0;var v=0;var z=0;var e=0;
function drawTimline(seconds){
var secondSlot=(seconds/10);
var timeslots='';
var inputTime=secondSlot;
for(var i=0;i<=10;i++)
{
    inputTime=Math.ceil(secondSlot*i);
    //alert(inputTime);
    var time=settotime(inputTime);
    timeslots+='<div class="duration" style="border:none;"><span>'+time+'</span></div>';
     //alert(inputTime);
}
document.getElementById("divnew").innerHTML=timeslots;
}
function cre(seconds)
{    
var ads=adCount;
var perblock=seconds/10;
var cues='';
for(var i=0;i<ads;i++)
{
    var inputTime=Math.ceil(perblock*i);
    //alert(inputTime);
    var time=settotime(inputTime);
  var status=adStatus[i];
  var url=adUrl[i];
  var color=(status==1)?"green":"red";
  var name=adName[i];
  var adId=adIds[i]; 
  var perpix=cuePoints[i]/perblock;  
  var setline=parseInt((perpix*75));
  cues+='<div title="Cuepoint position : '+settotime(cuePoints[i])+'\nCuepoint name: '+name+'\nCuepoint url: '+url+'" onclick=updateAds("'+adId+'") style="border-right:3px solid '+color+';cursor:pointer; min-height:148px; max-width: 1px;position:absolute;left:'+setline+'px"><div class="duration" ></div></div>';   
}
document.getElementById("cuePoints").innerHTML=cues;
}

function converttoSec(per)
{
    var t1=per.split(":");
    if(t1.length==3)
    {
    var a1=parseInt(t1[0]*3600);
    var a2=parseInt(t1[1]*60);
    var a3=parseInt(t1[2]);
    var totTime=a1+a2+a3;
    }
    else if(t1.length==2)
    {
    var a4=parseInt(t1[0]*60);
    var a5=parseInt(t1[1]);
    var totTime=a5+a4;
    }
    else if(t1.length==1)
    {
    var totTime=parseInt(t1[0]);
    }
    return totTime;
}
 $('input[type=text]').blur(function(){ 
       $(this).val($.trim($(this).val().replace(/\t+/g,' ')));
    }); 

</script>
