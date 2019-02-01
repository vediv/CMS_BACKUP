/* close Modal dynamic */
function CloseModal(modelName,ModelViewContentID){
console.log(modelName+"----"+ModelViewContentID);    
document.getElementById(ModelViewContentID).innerHTML="";
$('#'+modelName).modal('hide');
}


function selpagelimit_new(selectBoxID,pageURL,loaderid){
var limitval = $('#'+selectBoxID).val();
var dataString ='limitval='+ limitval;
$('#'+loaderid).show();
$('#results').css("opacity",0.1);
        $.ajax({
        type: "POST",
        url:pageURL,
        data: dataString,
        cache: false,
        success: function(result){
                 $("#results").html('');
                 $("#results").html(result);
                 $('#'+loaderid).hide();
                 $('#results').css("opacity",1);
              }
            }); 
}

function selpagelimit(selectBoxID,pageURL,loaderID){
var limitval = $('#'+selectBoxID).val();
var dataString ='limitval='+ limitval;
 $("#"+loaderID).show();
         $('#results').css("opacity",0.1);
//$("#"+loaderid).fadeIn(400).html('Wait <img src="img/image_process.gif" />');
        $.ajax({
        type: "POST",
        url:pageURL,
        data: dataString,
        cache: false,
        success: function(result){
                $("#results").html(result);
                $("#"+loaderID).hide();
                $('#results').css("opacity",1);
              }
            }); 
}

function SeachDataTable(pageURL,limitval,pageNum,loaderID,filtervalue)
{
      var searchInputall = $('#searchInput').val();
      // console.log(pageURL+"---"+limitval+"--"+pageNum+"--"+loaderID);
      if(searchInputall=='')
      {
        $("#submitBtn").show();  
	$('.enableOnInput').prop('disabled', true);
        //$("#"+loaderID).show();
        //$("#"+loaderID).fadeIn(400).html('Wait <img src="img/image_process.gif" />');
         $("#"+loaderID).show();
         $('#results').css("opacity",0.1);
        var dataString ='searchInputall='+searchInputall+"&limitval="+limitval+"&pageNum="+pageNum+"&filtervalue="+filtervalue;
         $.ajax({
                    type: "POST",
                    url:pageURL,
                    data: dataString,
                    cache: false,
                        success: function(result){
                         $("#searchword").css("display", "none");      
                         $("#results").html(result);
                         $("#"+loaderID).hide();
                         $('#results').css("opacity",1);
                        }
                 });
      }
      else {
            //If there is text in the input, then enable the button
            var get_string = searchInputall.length;
            if(get_string>=1){  $("#submitBtn").show();    }
            $('.enableOnInput').prop('disabled', false);
      }
}

$('#searchInput').bind('paste', function (e) {
     $('.enableOnInput').prop('disabled', false);
});

$("#searchInput").keyup(function(event) {
     if (event.keyCode === 13) {
        $("#submitBtn").click();
      }
});

function SearchDataTableValue(pageURL,limitval,pageNum,loaderID,filtervalue)
{
    var searchInputall = $('#searchInput').val();
    searchInputall = searchInputall.trim();
    var strlen=searchInputall.length;
    if(strlen==0){  $('#searchInput').val(''); $('#searchInput').focus(); return false;   }
     //$("#"+loaderID).show();
     //$("#"+loaderID).fadeIn(400).html('Wait <img src="img/image_process.gif" />');
     $("#"+loaderID).show();
     $('#results').css("opacity",0.1);
     var apiBody = new FormData();
     apiBody.append("searchInputall",searchInputall);
     apiBody.append("limitval",limitval);
     apiBody.append("filtervalue",filtervalue);
     $("#"+loaderID).show();
     $('#results').css("opacity",0.1);
     $.ajax({
     url:pageURL,
     method: 'POST',
     data:apiBody,
     processData: false,
     contentType: false,
     success: function(result){
               $("#results").html(result);
                $("#searchword").css("display", "");
                $('#searchword').html(searchInputall);
                $("#"+loaderID).hide();
                $('#results').css("opacity",1);
                
            }
      });
}

function changePagination(pageid,limitval,searchtext,fromdate,todate,pageUrl,filtervalue){    
      $('#load').show();
      $('#results').css("opacity",0.1);
      var dataString ='pageNum='+pageid+'&limitval='+limitval+'&searchInputall='+searchtext+'&fromdate='+fromdate+'&todate='+todate+'&filtervalue='+filtervalue;
      $.ajax({
           type: "POST",
           url: pageUrl,
           data: dataString,
           cache: false,
           success: function(result){
           	 $("#results").html(result);
                 $('#load').hide();
		 $('#results').css("opacity",1);
           }
      }); 
}

/*function SendSingleMail(emailID)
{
    location.href="mail.php?action=single&uemail="+emailID;
    return true;
}
*/
function TemplateViewInModal(userEmail,pageName,TemplateType)
{
     if(TemplateType=='emailSend'){
     $("#myModalEmailSend").modal();
      var info = 'action='+TemplateType+"&userEmail="+userEmail+"&pageName="+pageName+"&ModalName=myModalEmailSend&ModalView=ViewContentEmailSend"; 
        $.ajax({
	    type: "POST",
	    url: "view/mailTemplate.php",
	    data: info,
             success: function(result){
             $('#ViewContentEmailSend').html(result);
            return false;
        }
 
        });
       return false;
     }
    
}

function checkPassword(str)
  {
    // at least one number, one lowercase and one uppercase letter
    // at least six characters that are letters, numbers or the underscore
    //var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])\w{6,}$/;
    var re = /^(?=.*\d)(?=.*[!@#$%^&*_])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    return re.test(str);
}






