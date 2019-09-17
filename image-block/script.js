var isNS = (navigator.appName == "Netscape") ? 1 : 0;
var EnableRightClick = 0;
if(isNS) 
document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP);
function mischandler(){
 if(EnableRightClick==1){ return true; }
 else {return false; }
}
function mousehandler(e){
 if(EnableRightClick==1){ return true; }
 var myevent = (isNS) ? e : event;
 var eventbutton = (isNS) ? myevent.which : myevent.button;
 if((eventbutton==2)||(eventbutton==3)) return false;
}
document.oncontextmenu = mischandler;
document.onmousedown = mousehandler;
document.onmouseup = mousehandler;


$(document).keyup(function(event){
    var keyCode = event.keyCode ? event.keyCode : event.which;
        if (keyCode == 44) stopPrntScr();
});

$(document).keydown(function(event){
    if(event.keyCode==123){
        return false;
    }
    else if (event.ctrlKey && event.shiftKey && event.keyCode==73){        
             return false;
    }
});

function stopPrntScr() {

	var inpFld = document.createElement("input");
	inpFld.setAttribute("value", ".");
	inpFld.setAttribute("width", "0");
	inpFld.style.height = "0px";
	inpFld.style.width = "0px";
	inpFld.style.border = "0px";
	document.body.appendChild(inpFld);
	inpFld.select();
	document.execCommand("copy");
	inpFld.remove(inpFld);
}