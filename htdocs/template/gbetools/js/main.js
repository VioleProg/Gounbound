$(document).ready(function(){
	if (window.XMLHttpRequest) { // Don't do this on IE6 and Older browsers since these are transparent PNGs
		$('.left_menu_items>a').hover( // Add hover functionality to menu items
			function(){
				$(this).children("span").show();
			}, function(){
				$(this).children("span").hide();
			});
	}
}); 


function flashWrite(s,w,h,d,bg,t,f,l){

	var code = "";
    code  = "<object type=\"application/x-shockwave-flash\" ";
    code +=         "classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" ";
    code +=         "codebase=\"../fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" ";
    code +=         "width=\""+w+"\" height=\""+h+"\" id=\""+d+"\" align=\""+l+"\">";

    code += "<param name=\"movie\" value=\""+s+"\" />";
    code += "<param name=\"quality\" value=\"high\" />";
    code += "<param name=\"wmode\" value=\""+t+"\" />";
    code += "<param name=\"menu\" value=\"false\" />";
    code += "<param name=\"allowScriptAccess\" value=\"sameDomain\" />";
    code += "<param name=\"swliveconnect\" value=\"true\" />";
	code += "<param name='scale' value='"+f+"' />";
	code += "<param name='salign' value='"+l+"' />";
    code += "<embed src=\""+s+"\" quality=\"high\" "
    code +=        "wmode=\""+t+"\" "
    code +=        "bgcolor=\"#ffffff\" "
    code +=        "salign=\""+l+"\" "
    code +=        "name=\""+d+"\" "
	code +=        "movie=\""+s+"\" "
	code +=        "wmode=\""+t+"\" "
	code +=        "allowScriptAccess=\"sameDomain\" "
	code +=        "allowFullScreen=\"false\" "
    code +=        "menu=\"false\" width=\""+w+"\" height=\""+h+"\" "
    code +=        "type=\"application/x-shockwave-flash\" "
    code +=        "pluginspage=\"../www.macromedia.com/go/getflashplayer\"> "
    code += "</embed>"
    code += "</object>"

	document.write (code);
}

// Open new window
function openVideo(url, mywidth, myheight) {
var openWindow = window.open(url,'','scrollbars=no,menubar=no,width=' + mywidth + ',height=' + myheight + ',resizable=no,toolbar=no,location=no,status=no');
}