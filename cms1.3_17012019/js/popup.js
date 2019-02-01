var _$ = function(elem) {return(document.getElementById(elem));};
function Cheight()
{
   return window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight||0;
}
function PopupCenterN(pUrl,titleMod,width,height)
{
    var sheetMod = document.createElement('style');
    sheetMod.id = "modSheetCustom";
    var sheetCheckMod = _$("modSheetCustom");
    if(sheetCheckMod)
        sheetCheckMod.parentNode.removeChild(sheetCheckMod);
    var sheetClass = ".modalDialogNewCustom";
    sheetClass += "{";
    sheetClass += "position: fixed;";
    sheetClass += "font-family: Arial, Helvetica, sans-serif;";
    sheetClass += "top: 0;";
    sheetClass += "right: 0;";
    sheetClass += "bottom: 0;";
    sheetClass += "left: 0;";
    sheetClass += "background: rgba(0,0,0,0.8);";
    sheetClass += "z-index: 99999;";
    sheetClass += "opacity:0;";
    //sheetClass += "width: "+width+"px !important;";
    //sheetClass += "height: "+height+"px !important;";
    sheetClass += "-webkit-transition: opacity 400ms ease-in;";
    sheetClass += "-moz-transition: opacity 400ms ease-in;";
    sheetClass += "transition: opacity 400ms ease-in;";
    sheetClass += "pointer-events: none;";
    sheetClass += "}";

    sheetClass += ".modalDialogNewCustom:target";
    sheetClass += "{";
    sheetClass += "opacity:1;";
    sheetClass += "pointer-events: auto;";
    sheetClass += "}";
    sheetClass += ".modalDialogNewCustom > div";
    sheetClass += "{";
    sheetClass += "width: "+width+";";
    sheetClass += "height: "+height+";";
    //sheetClass += "height: "+auto+";";
    sheetClass += "position: relative;";
    sheetClass += "margin: auto;";
    sheetClass += "padding: 5px 20px 70px 20px;";
    sheetClass += "background: #fff;";
    sheetClass += "background: -moz-linear-gradient(#fff, #999);";
    sheetClass += "background: -webkit-linear-gradient(#fff, #999);";
    sheetClass += "background: -o-linear-gradient(#fff, #999);";
    sheetClass += "}";

    sheetClass += ".closeNewCustomModal";
    sheetClass += "{";
    sheetClass += "background:#000000;";
    sheetClass += "opacity:1;";
    sheetClass += "color: #FFFFFF;";
    sheetClass += "line-height: 25px;";
    sheetClass += "position: absolute;";
    sheetClass += "right: 12px;";
    sheetClass += "text-align: center;";
    sheetClass += "top: 10px;";
    sheetClass += "width: 24px;";
    sheetClass += "text-decoration: none;";
    sheetClass += "font-weight: bold;";
    sheetClass += "/*";
    sheetClass += "-webkit-border-radius: 12px;";
    sheetClass += "-moz-border-radius: 12px;";
    sheetClass += "border-radius: 12px;";
    sheetClass += "-moz-box-shadow: 1px 1px 3px #000;";
    sheetClass += "-webkit-box-shadow: 1px 1px 3px #000;";
    sheetClass += "box-shadow: 1px 1px 3px #000;";
    sheetClass += "*/";
    sheetClass += "}";
    sheetClass += ".closeNewCustomModal:hover { background: #CCCCCC; color:#000000;}";

    sheetMod.innerHTML = sheetClass;
    document.head.appendChild(sheetMod);

    var checkMod = _$("openModalNewCustomModal");
    if(checkMod)
    checkMod.parentNode.removeChild(checkMod);
    var newMod = document.createElement("div");
    newMod.id = "openModalNewCustomModal";
    newMod.setAttribute("class","modalDialogNewCustom");
    var subMod = document.createElement("div");
    subMod.id = "subModId";
    var anchorMod = document.createElement("a");
    anchorMod.setAttribute("class","closeNewCustomModal");
    anchorMod.title = "Close";
    var anchorModText = document.createTextNode("X");
    anchorMod.setAttribute('href', "#closeNewCustomModal");
    anchorMod.appendChild(anchorModText);
    subMod.appendChild(anchorMod);
    var h2Mod = document.createElement("H2");
    var h2ModText = document.createTextNode(titleMod);
    h2Mod.appendChild(h2ModText);
    h2Mod.style.fontSize = "14px";
    h2Mod.style.fontWeight = "bold";
    h2Mod.style.textAlign = "left";
    subMod.appendChild(h2Mod);
    var iframeMod = document.createElement("iframe");
    iframeMod.id = "eiFrame";
    iframeMod.setAttribute("frameborder","1");
    iframeMod.setAttribute("src", pUrl);
    iframeMod.style.border = "1px solid #CCCCCC";
    iframeMod.style.width = "100%";
    iframeMod.style.height = "100%";
    subMod.appendChild(iframeMod);
    newMod.appendChild(subMod);
    document.body.appendChild(newMod);
    var subModeH = _$("subModId").clientHeight;
    var margTop = (Cheight()/2) - (subModeH/2);
    _$("subModId").style.marginTop = margTop+"px";
    window.location.href = '#openModalNewCustomModal';
}
