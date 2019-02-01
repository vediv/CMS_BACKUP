var youtubeUrl="http://ott.planetcast.in:6080/youtube";
var basketData=[];

function makeRequest(url,body,container)
{
    var xhr=null;
    if(window.XMLHttpRequest)
    {
        xhr=new XMLHttpRequest();
    }
    else
    {
        xhr=new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    
    switch(container)
    {
        
        
        case "loadMorePlaylist":
           _("loadMorePTree").innerHTML='<img src="img/image_process.gif">';
         break;
         
         case "LoadmorePlaylistVideo":
           _("loadMoreVTree").innerHTML='<img src="img/image_process.gif">';
         break;
         
        case "saveBasketItems":
        _("actionBtns").innerHTML='<img src="img/image_process.gif">';
        break;
        
        default:
            if( _(container))
             _(container).innerHTML='<p class="text-center"><img src="img/image_process.gif"></p>';
              break;
    }
    
   
    xhr.open("POST",url,true);
    xhr.send(body);
    xhr.onreadystatechange=function(){if(xhr.readyState==4 && xhr.status==200){parseRsponse(xhr.responseText,container)}};
}

function parseRsponse(response,container)
{
    var obj=JSON.parse(response);
    
    switch(container)
    {
        case "getPlaylist":
            buildPlaylistTree(obj,container);
            break;
        
        case "getPlaylistVideo":
            buildPlaylistVideoTree(obj,container);
            break;    
        
        case "loadMorePlaylist":
            buildLoadMorePlaylist(obj,container);
            break;  
        
        case "LoadmorePlaylistVideo":
            buildLoadMorePlaylistVideo(obj,container);
            break; 
            
         case "saveBasketItems":
            printMsg(obj,container);
            break;     
            
            
            
    }
    
}

var _=function(id){return document.getElementById(id)};

function getPlaylist(frmObj)
{
    var channelid=frmObj.channelid.value;
    var body=new FormData();
    body.append("partnerid",partnerid);
    body.append("tag","channel");
    body.append("subtag","playlist_list");
    body.append("channelid",channelid);
    makeRequest(youtubeUrl,body,"getPlaylist");
    resetBasket();  
    buildCategoryTree();
}

function loadMorePlaylist(token)
{
   
    var channelid=document.getElementsByName("channelid")[0].value;
    var body=new FormData();
    body.append("partnerid",partnerid);
    body.append("tag","channel");
    body.append("subtag","nextpage");
    body.append("channelid",channelid);
    body.append("token",token);
    makeRequest(youtubeUrl,body,"loadMorePlaylist");
}

function  buildPlaylistTree(obj,container)
{
    var data=obj.META;
    var len=data.length;
    var token=obj.token;
    var html='';
    
    if(len>0)
    {
        getPlaylistVideo(data[0].id,null);
        html+='<ol class="playlist-list" id="playlistTree">';
        var active="active-playlist";
        for(var i=0;i<len;i++)
        {
            var id=data[i].id;
            var title=data[i].title;
            
            html+='<li id='+id+' onclick="getPlaylistVideo(id,this)" class="'+active+' playlist-li">'+title+'</li>';
            
            active="";
        }
        
        
        html+='</ol>';
        
        if(token!=null)
        {
             html+='<p class="text-center" id="loadMorePTree"><button id='+token+' class="btn btn-xs btn-warning" onclick="loadMorePlaylist(id)">LOAD MORE</button></p>';
        }
        
    }
    else
    {
        html+='<p class="text-danger h5">No playlist avalilable.</p>'
    }
    
   _(container).innerHTML=html;
}


function buildLoadMorePlaylist(obj,container)
{
    var data=obj.META;
    var len=data.length;
    var token=obj.token;
    if(len>0)
    {
        var parentNode=_("playlistTree"); 
        for(var i=0;i<len;i++)
        {
            var id=data[i].id;
            var title=data[i].title;
            var elem=document.createElement("li");
                elem.setAttribute("id",id);
                elem.setAttribute("class","playlist-li");
                
            var text=document.createTextNode(title);
                elem.appendChild(text); 
                parentNode.appendChild(elem);
                elem.addEventListener("click",function(){getPlaylistVideo(this.id,this)});
        }
        
        if(token!=null)
        {
            _("loadMorePTree").innerHTML='<button id='+token+' class="btn btn-xs btn-warning" onclick="loadMorePlaylist(id)">LOAD MORE</button>';
        }
        else
        {
             _("loadMorePTree").innerHTML='';
        }
        
        
    }
    else
    {
        
    }
    
    
}



function getPlaylistVideo(playlistid,elem)
{
    if(elem!=null)
    {
        var target=document.getElementsByClassName("playlist-li");
        var len=target.length;
        for(var i=0;i<len;i++)
        target[i].classList.remove("active-playlist");
        elem.classList.add("active-playlist");
    }
    
    
    var body=new FormData();
    body.append("partnerid",partnerid);
    body.append("tag","playlist");
    body.append("subtag","list");
    body.append("playlistid",playlistid);
    makeRequest(youtubeUrl,body,"getPlaylistVideo");    
}


function LoadmorePlaylistVideo(elem)
{
    var playlistid=elem.dataset.playlistid;
    var token=elem.id;
    
    
    var body=new FormData();
    body.append("partnerid",partnerid);
    body.append("tag","playlist");
    body.append("subtag","nextpage");
    body.append("playlistid",playlistid);
    body.append("token",token);
    makeRequest(youtubeUrl,body,"LoadmorePlaylistVideo");    
}





function  buildPlaylistVideoTree(obj,container)
{
    var data=obj.META;
    var len=data.length;
    var token=obj.token;
    var html='';
    
    if(len>0)
    {
        html+='<ol class="playlist-list listNone" id="playlistVideoTree">';
        var count=1;
        for(var i=0;i<len;i++)
        {
            var id=data[i].id;
            var name=data[i].name;
            var thumbnail=data[i].thumbnail;
            var playlistid=data[i].playlistid;
            
            var alreadyInBasket=searchBasketItem(id);
            if(alreadyInBasket){var checked="checked=checked"}else {checked="";}
            
            html+='<li><label for="'+id+'"><table class="custom-table"><tr><td width="10%">'+count+' </td><td width="5%"> <input type="checkbox" '+checked+' onclick="setBasketData(this)" data-videoname="'+name+'"  data-videothumb="'+thumbnail+'"  data-videoid="'+id+'" id='+id+'></td><td width="10%"><img src="'+thumbnail+'" height=32> </td> <td title="'+name+'" width="75%"><p class="substr">'+name+'</p></td></tr></table></label></li>';
            
            count++;
            
        }
        
        
        html+='</ol>';
        
        if(token!=null)
        {
             html+='<p class="text-center" id="loadMoreVTree"><button id='+token+' data-playlistid="'+playlistid+'" class="btn btn-xs btn-warning" onclick="LoadmorePlaylistVideo(this)">LOAD MORE</button></p>';
        }
        
    }
    else
    {
        html+='<p class="text-danger h5">No playlist video avalilable.</p>'
    }
    
   _(container).innerHTML=html;
}

function buildLoadMorePlaylistVideo(obj,container)
{
    var data=obj.META;
    var len=data.length;
    var token=obj.token;
    var html='';
    
    if(len>0)
    {
      
        var parentTree=_("playlistVideoTree").getElementsByTagName("li");
        var count=parentTree.length+1;
        for(var i=0;i<len;i++)
        {
            var id=data[i].id;
            var name=data[i].name;
            var thumbnail=data[i].thumbnail;
            var playlistid=data[i].playlistid;
            
            var alreadyInBasket=searchBasketItem(id);
            if(alreadyInBasket){var checked="checked=checked"}else {checked="";}
            
            
            html+='<li><label for="'+id+'"><table class="custom-table"><tr><td width="10%">'+count+' </td><td width="5%"> <input type="checkbox" '+checked+' onclick="setBasketData(this)" data-videoname="'+name+'"  data-videothumb="'+thumbnail+'"  data-videoid="'+id+'" id='+id+'></td><td width="10%"><img src="'+thumbnail+'" height=32> </td> <td title="'+name+'" width="75%"><p class="substr">'+name+'</p></td></tr></table></label></li>';
            
            count++;
            
        }
        
        _("playlistVideoTree").innerHTML+=html;
        
        
        if(token!=null)
        {
             var btn='<button id='+token+' data-playlistid="'+playlistid+'" class="btn btn-xs btn-warning" onclick="LoadmorePlaylistVideo(this)">LOAD MORE</button>';
        }
        else
        {
            btn="";
        }
        
        _("loadMoreVTree").innerHTML=btn;
    }
}


function getCategoryTree()
{
    var data=JSON.parse(catArray);
    var len=data.length;
    var catTree=[];
   
    if(len>0)
    {
        for(var i=0;i<len;i++)   //// Category loop
        {
            var category_id=data[i].category_id;
            var parent_id=data[i].parent_id;
            var cat_name=data[i].cat_name;
            
            if(parent_id==0)
            {
                  var treeLen=catTree.push({"parent_id":category_id,"parent":cat_name,"childs":[]}); 
                  var index=treeLen-1;
                  
                  for(var j=0;j<len;j++)  //// Sub-Category loop
                  {
                      if(data[j].parent_id==category_id)
                      {
                          var subCat_id=data[j].category_id; var subCat_name=data[j].cat_name;
                          var SubTreeLen=catTree[index].childs.push({"parent_id":subCat_id,"parent":subCat_name,"childs":[]});
                          var SubIndex=SubTreeLen-1;
                          
                             for(var k=0;k<len;k++)  //// Sub-sub-Category loop
                             {
                                 
                                 if(data[k].parent_id==subCat_id)
                                 {
                                     catTree[index].childs[SubIndex].childs.push({"category_id":data[k].category_id,"cat_name":data[k].cat_name});
                                 }
                                 
                             } //// !Sub-sub-Category loop
                          
                          
                      }
                          
                          
                  }  //// !Sub-Category loop
                  
                  
            }  
            
            
        }//// !Category loop
               
    }
    
   return  catTree;
    
}

function buildCategoryTree()
{
    var obj=getCategoryTree();
    var len=obj.length;
    var html='<select name="category"><option value="">Select Category</option>';    
    if(len>0)
    {
        for(var i=0;i<len;i++)
        {
            var parent=obj[i].parent;
            var parent_id=obj[i].parent_id;
            var childs=obj[i].childs;
            var childsLen=childs.length;
            
            if(childsLen>0)
            {
                html+='<optgroup label="'+parent+'" class="sub">';
                for(var j=0;j<childsLen;j++)
                {
                    var sub_parent=childs[j].parent;
                    var sub_parent_id=childs[j].parent_id;
                    var sub_childs=childs[j].childs;
                    var sub_childsLen=sub_childs.length;
                    
                    if(sub_childsLen>0)
                    {
                        html+='<optgroup label="'+sub_parent+'" class="sub_sub">';
                        for(var k=0;k<sub_childsLen;k++)
                        {
                            var category_id=sub_childs[k].category_id;
                            var cat_name=sub_childs[k].cat_name;
                            html+='<option value="'+category_id+'">'+cat_name+'</option>';
                            
                        }
                        html+='</optgroup>';
                    }
                    else
                    {   
                        html+='<optgroup>';
                        html+='<option value="'+sub_parent_id+'">'+sub_parent+'</option>';
                        html+='</optgroup>';
                    }
                    
                    
                }
                
                html+='</optgroup>';
                
            }
            else
            {
                html+='<option value="'+parent_id+'">'+parent+'</option>';
            }
            
    
        }
    }
    
    _("categoryTree").innerHTML=html;
}

function uncheckCheckedVideos(id)
{ 
    if(id!="all")
    {
        _(id).checked=false;
    }
    else
    {
        if(_("playlistVideoTree"))
        {
            var elem=_("playlistVideoTree").getElementsByTagName("input");
            var len=elem.length;
            for(var i=0;i<len;i++)
            {
                if(elem[i].checked==true)
                    elem[i].checked=false;
            }
        }
    }
    
    
    
}

function RemoveBasketItem(elem)
{     
      var id=elem.dataset.itemid;
      
      var cnf=confirm("Are you sure to remove this item from selected video list?");
      if(cnf)
      {
          var i;
          var targetIndex=basketData.findIndex(i=>i.id===id);
          basketData.splice(targetIndex,1);
          buildBasket();
          uncheckCheckedVideos(id);
      }
      
}

function searchBasketItem(itemId)
{
    var i;
    var index=basketData.findIndex(i=>i.id===itemId);
    if(index<0)
    return false;
    return true;
}

function resetBasket()
{
    basketData=[];
    buildBasket();
    uncheckCheckedVideos("all");
}

function getCatId()
{
    var cat=document.getElementsByName("category")[0].value;
    
    if(cat=="")
    {
        alert("Kindly select category to save video");
        document.getElementsByName("category")[0].focus();
        return false;
    }
    return cat;
    
    
}

function setBasketData(elem)
{
     var cat_id=getCatId(); if(!cat_id){elem.checked=false; return false;} 
    var name=elem.dataset.videoname;
    var thumb=elem.dataset.videothumb;
    var id=elem.dataset.videoid;
    //alert(name+"---"+thumb+"--"+id);
    
    if(elem.checked==true)
    {
       
        basketData.push({"id":id,"category_id":cat_id,"thumbnail":thumb,"name":name});
        
    }
    else
    {
        var i;
        var targetIndex = basketData.findIndex(i => i.id === id);
        basketData.splice(targetIndex,1);
        
    }
    
    buildBasket();
}

function saveBasketItems()
{
    var body=new FormData();
    body.append("partnerid",partnerid);
    body.append("tag","bulk_meta");
    body.append("bulk_id",JSON.stringify(basketData));
    makeRequest(youtubeUrl,body,"saveBasketItems");    
}

function printMsg(obj,container)
{
    var status=obj.status;
    var message=obj.Message;
    switch(status)
    {
        case "1":case 1:
                _("actionBtns").innerHTML='<p class="text-success ">'+message+'</p>';
                basketData=[];
               break;
         case "0":case 0:
                 _("actionBtns").innerHTML='<p class="text-danger ">'+message+'</p>';
                break;   
    }
    
}


function buildBasket()
{
    var len=basketData.length;
  if(len>0)
  {
        _("basketTitle").innerHTML=" : "+len;
         var html='<div class="col-sm-12 bg-liteGray  text-center" id="actionBtns"><div class="col-sm-5 "><button class="btn btn-xs btn-success" onclick="saveBasketItems()">Save</button></div>';
             html+='<div class="col-sm-5 "><button class="btn btn-xs btn-danger" onclick="resetBasket()">Clear</button></div></div>';
        for(var i=0;i<len;i++)
        {
            var img=basketData[i].thumbnail;var name=basketData[i].name;var id=basketData[i].id;
            html+='<div><span class="removBasketData" title="Remove item " data-itemid="'+id+'" onclick="RemoveBasketItem(this)"><i class="fa fa-times-circle"></i></span><img src="'+img+'" title="'+name+'"  width=32 height=32></div>';
        }
        
        _("basketData").innerHTML=html;
  }
  else
  {
        _("basketTitle").innerHTML="";
      _("basketData").innerHTML="";
  }
  
  //console.log(JSON.stringify(basketData))
}