function runXML(url)
{
   
    
    var xmlHttp=null;
    
    if(window.ActiveXObject)
    {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        
    }
    else if(window.XMLHttpRequest)
    {
      xmlHttp=new XMLHttpRequest();
    }
  
   
    xmlHttp.open("GET",url,true);
    xmlHttp.send();
    xmlHttp.onreadystatechange=function(){if(xmlHttp.readyState==4){parseXML(xmlHttp.responseText);}};
    
    
    
}


function parseXML(xmlResponse)
{
    //console.log(xmlResponse);
    var parser=new DOMParser(); 
    var xmlDoc=parser.parseFromString(xmlResponse,"text/xml");
    //console.log(xmlDoc);
    getDataFromXMl(xmlDoc,"MediaFile");
    
}

localStorage.setItem("adUrl",null);
var adUrl=[];
function getDataFromXMl(xmlDoc,tag)
{  
  if(xmlDoc.getElementsByTagName(tag)[0])
  {
   var data=xmlDoc.getElementsByTagName(tag)[0].childNodes[0].nodeValue; 
   
       adUrl.push(data);
       localStorage.setItem("adUrl",JSON.stringify(adUrl));
  }
   
   
}
