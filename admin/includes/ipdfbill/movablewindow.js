/******************************************************************************************************
               DHTML moving mini window script written by Mark Wilton-Jones - 2001-2002
                           Updated 29/04/2004 for Konqeror XHTML fix (V4.2.2)
                     Updated 14/09/2004 to allow windows to have scrollbars (V5.0.0)
                       Updated 16/09/2004 for better response in Mozilla (V5.0.1)
*******************************************************************************************************

Please see http://www.howtocreate.co.uk/jslibs/ for details and a demo of this script
Please see http://www.howtocreate.co.uk/jslibs/termsOfUse.html for terms of use

To use:

Inbetween the <head> tags, put:

	<script src="PATH TO SCRIPT/movablewindow.js" type="text/javascript" language="javascript1.2"></script>

To create a mini window put the following just before the </body> tag:

	var nameObject = createMiniWinLayer(
		'This is the contents', //The text to be written in the main part of the mini window (can contain HTML)
		'This is the title',    //The text to be written in the title bar of the mini window
		100,                    //Distance from the left edge of the page to start
		150,                    //Distance from the top edge of the page to start
		300,                    //Width of the mini window
		'#00007f',              //The background colour of the title bar of the mini window
		'#ffffff',              //The background colour of the main part of the mini window
		'logo.gif',             //The location of the logo image in the top left corner (16px x 16px)
		'minimised.gif',        //The location of the minimise image (16px x 16px)
		'Wiederherstellengif',          //The location of the restore image (16px x 16px)
		'close.gif',            //The location of the 'close window' image (16px x 16px)
		'maximise.gif',         //The location of the maximise image (16px x 16px) - use '' for not maximisable
		                        //(only used if drag handle image is also specified)
		'handle.gif',           //The location of the drag handle image (8px x 8px) - use '' for not resizable
		                        //(not available if dragable portion is set to true)
		1,                      //Initial window visibility (0 = hidden, 1 = maximised, 2 = minimised)
		false,                  //Dragable portion (true = entire window, false = title bar only)
		                        //Some browsers may have problems using the minimise/maximise/close buttons
		                        //if you use entire window.
		'optional extra HTML',  //Only used in DOM browsers - HTML to be put just above the main part of the window -
		                        //this MUST NOT contain any 'div' elements - this is designed to be used along with my
		                        //display based menu script to provide menus in the mini windows
		true                    //Only used in DOM browsers (not Konqueror or IE Mac) - should the window use scrollbars
	);

Note: for cross browser compatibility colours should be written as '#ffffff' or 'white', not '#fff'
or 'rgb(etc.)'.

The function will return an object (called nameObject in the example above) with two properties:
	returnObject.maxName  The name of the maximised window
	returnObject.minName  The name of the minimised window

The window pairs (maximised and minimised versions of the same window) will be called
MWJminiwinMAX1 and MWJminiwinMIN1 respectively. Simply change the number to 2 etc. for
each new window.

To show the maximised window, or bring it to the front of the windows, use:
	showMinWin( nameOfMaximisedWindow, nameOfMinimisedWindow )

To show the minimised window, use:
	showMinWin( nameOfMinimisedWindow, nameOfMaximisedWindow )

To hide either window, use:
	hideMinWin( nameOfWindowToHide )

To move the window with script:
	moveWin( nameOfMaximisedWindow, nameOfMinimisedWindow, newXPos, newYPos )

Advanced browsers (IE5+, Opera 7+, Gecko, Konqueror, Safari, and generally any browser that supports
document.childNodes [except ICEbrowser]) can use the drag handle if you provide one, and they also
allow you to rewrite the contents of any of the windows:
	reWriteWin( nameOfMaximisedWindow, nameOfMinimisedWindow, newContent )
	- warning: to prevent a resizing bug in Gecko browsers, you should limit your use of this with mini
	windows that use scrollbars - I could not find any way to avoid this bug
and change the background colour of the mini windows:
	changeWinBG( nameOfMaximisedWindow, newBackgroundColour )
and resize the window with script (you will not be allowed to make the window too small):
	resizeWin( nameOfMaximisedWindow, nameOfMinimisedWindow, desiredWidth, desiredHeight )
or maximise the window with script:
	maximiseWin( nameOfMaximisedWindow, nameOfMinimisedWindow )
These advanced browsers will also show a maximise button (if you specify one AND you specify a drag
handle image). It uses the 'findMaxSize' function to calculate the new position and size of the
windows. By default, the window will be placed at 0,0 and will take up the full space of the browser
window. If you do not want that, you will need to redefine the 'findMaxSize' function, returning
[left,top,width,height].

These advanced browsers can also integrate my display based menu script to produce menus in the mini windows.

These functions will have no effect in browsers that do not support the action and should not produce errors.

If scrollbars are being used, you may want to set the height initially by using resizeWin immediately after
creating the window. Scrollbars work in IE 5.5+ on Windows, Opera 7+, Mozilla 1.5+, Safari/OmniWeb and ICEbrowser.
Other browsers show the window without scrollbars (IE 5.0 on Windows, IE on Mac, Konqueror and Mozilla 1.4- have
deliberately been protected from rendering bugs). IE and Mozilla may flicker when resizing. Opera and Mozilla may
leave a narrow blank gap under the content while scrollbars are visible.
___________________________________________________________________________________________*/

var MWJ_winZind = 65535;

function createMiniWinLayer(mainContent,oTitle,oLeft,oTop,oWidth,barColour,mainColour,oLogo,oMin,oMax,oClose,oFull,oDrag,oVis,oFullDrag,anyExtra,oScroll) {
	if( typeof( oFullDrag ) == 'undefined' ) { window.alert( 'New mini window script incompatible.\nPlease see the script source.' ); return; }
	window.MWJ_MINIWINS = window.MWJ_MINIWINS ? ( window.MWJ_MINIWINS + 1 ) : 1;
	if( document.layers && !document.childNodes ) {
		var theDragString = ' onmouseover="this.captureEvents(Event.MOUSEDOWN);this.onmousedown = function () { clickDiv(\'MWJminiwinMAX'+window.MWJ_MINIWINS+'\',\'MWJminiwinMIN'+window.MWJ_MINIWINS+'\',arguments[0]);return false; };"';
		document.write( '<layer bgcolor="#bfbfbf"  name="MWJminiwinMAX'+window.MWJ_MINIWINS+'" width="'+oWidth+'" left="'+oLeft+'" top="'+oTop+'" visibility="'+((oVis==1)?'show':'hide')+'"'+(oFullDrag?theDragString:'')+'>'+
			'<table border="2" cellpadding="2" cellspacing="2" width="100%"><tr><td bgcolor="'+barColour+'">'+
			'<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'+
			'<td align="left" valign="middle" height="16" width="20">'+
			'<a href="javascript:manuf();" onfocus="this.blur()" onmouseover="window.status=\'Click for information about creating these mini windows\';return true;" onmouseout="window.status=\'\';return true;">'+
			'<img src="'+oLogo+'" border="0" height="16" width="16" alt="PDF Katalog"></a></td>'+
			'<td align="left" valign="middle">'+(oFullDrag?'':'<ilayer width="'+(oWidth-74)+'" height="16" left="0" top="0"><layer width="'+(oWidth-74)+'" height="16" left="0" top="0"'+theDragString+'>')+
			'<font color="#ffffff" face="Arial" size="-1"><b>'+oTitle+
			'</b></font>'+(oFullDrag?'':'</layer></ilayer>')+'</td><td align="right" valign="middle" width="32">'+
			'<a href="javascript:showMinWin(\'MWJminiwinMIN'+window.MWJ_MINIWINS+'\',\'MWJminiwinMAX'+window.MWJ_MINIWINS+'\');" onfocus="this.blur()" onmouseover="window.status=\'Click to minimise the mini window\';return true;" onmouseout="window.status=\'\';return true;">'+
			'<img src="'+oMin+'" border="0" height="16" width="16" alt="Minimieren"></a>'+
			'<a href="javascript:hideMinWin(\'MWJminiwinMAX'+window.MWJ_MINIWINS+'\');" onfocus="this.blur()" onmouseover="window.status=\'Click to close the mini window\';return true;" onmouseout="window.status=\'\';return true;">'+
			'<img src="'+oClose+'" border="0" height="16" width="16" style="cursor:pointer" alt="Schließen"></a></td></tr></table>'+
			'</td></tr><tr><td bgcolor="'+mainColour+'">'+mainContent+'</td></tr></table></layer>' );
		document.write( '<layer bgcolor="#bfbfbf" name="MWJminiwinMIN'+window.MWJ_MINIWINS+'" width="'+oWidth+'" left="'+oLeft+'" top="'+oTop+'" visibility="'+((oVis==2)?'show':'hide')+'"'+(oFullDrag?theDragString:'')+'>'+
			'<table border="2" cellpadding="2" cellspacing="2" width="100%"><tr><td bgcolor="'+barColour+'">'+
			'<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'+
			'<td align="left" valign="middle" height="16" width="20">'+
			'<a href="javascript:manuf();" onfocus="this.blur()" onmouseover="window.status=\'Click for information about creating these mini windows\';return true;" onmouseout="window.status=\'\';return true;">'+
			'<img src="'+oLogo+'" border="0" height="16" width="16" alt="PDF Katalog"></a></td>'+
			'<td align="left" valign="middle">'+(oFullDrag?'':'<ilayer width="'+(oWidth-74)+'" height="16" left="0" top="0"><layer width="100%" left="0" top="0"'+theDragString+'>')+
			'<font color="#ffffff" face="Arial" size="-1"><b>'+oTitle+
			'</b></font>'+(oFullDrag?'':'</layer></ilayer>')+'</td><td align="right" valign="middle" width="32">'+
			'<a href="javascript:showMinWin(\'MWJminiwinMAX'+window.MWJ_MINIWINS+'\',\'MWJminiwinMIN'+window.MWJ_MINIWINS+'\');" onfocus="this.blur()" onmouseover="window.status=\'Click to minimise the mini window\';return true;" onmouseout="window.status=\'\';return true;">'+
			'<img src="'+oMin+'" border="0" height="16" width="16" alt="Maximieren"></a>'+
			'<a href="javascript:hideMinWin(\'MWJminiwinMIN'+window.MWJ_MINIWINS+'\');" onfocus="this.blur()" onmouseover="window.status=\'Click to close the mini window\';return true;" onmouseout="window.status=\'\';return true;">'+
			'<img src="'+oClose+'" border="0" style="cursor:pointer" height="16" width="16" alt="Schließen"></a></td></tr></table>'+
			'</td></tr></table></layer>' );
	} else {
		var theDragString = ' onmousedown="clickDiv(\'MWJminiwinMAX'+window.MWJ_MINIWINS+'\',\'MWJminiwinMIN'+window.MWJ_MINIWINS+'\',arguments[0]);return false;" onselectstart="return false;" ondragstart="return false;"';
		document.write(
			'<div id="MWJminiwinMAX'+window.MWJ_MINIWINS+'" style="width:'+oWidth+'px;z-index:1000;position:absolute;left:'+oLeft+'px;top:'+oTop+'px;visibility:'+((oVis==1)?'visible':'hidden')+';"'+(oFullDrag?theDragString:'')+'>'+
			(document.childNodes?('<div style="position:absolute;right:2px;bottom:2px;z-index:1000;">'+((oDrag&&!oFullDrag)?'<img src="'+oDrag+'" height="8" width="8" border="0" alt="Resize." title="Resize." onmousedown="clickDiv(\'MWJminiwinMAX'+window.MWJ_MINIWINS+'\',\'MWJminiwinMIN'+window.MWJ_MINIWINS+
			'\',arguments[0],true);return false;" onselectstart="return false;" ondragstart="return false;" style="cursor:se-resize;" onmouseover="window.status=\'Drag to resize the mini window\';return true;" onmouseout="window.status=\'\';return true;">':'')+
			'</div>'):'')+'<table border="0" cellpadding="0" cellspacing="0" style="background-color:#bfbfbf;border-left:1px solid #dfdfdf;border-top:1px solid #dfdfdf;border-right:1px solid black;border-bottom:1px solid black;" width="100%"><tr>'+
			'<td style="background-color:#bfbfbf;border-left:1px solid white;border-top:1px solid white;border-right:1px solid #7f7f7f;border-bottom:1px solid #7f7f7f;">'+
			'<table border="0" cellpadding="0" cellspacing="1" width="100%" style="border:1px solid #bfbfbf;"><tr><td>'+
			'<table border="0" cellpadding="2" cellspacing="0" width="100%"><tr>'+
			'<td bgcolor="'+barColour+'" align="left" valign="middle" height="16" width="20">'+
			'<a style="text-decoration:none;cursor:pointer;" href="javascript:manuf();" onfocus="this.blur()" onmouseover="window.status=\'Click for information about creating these mini windows\';return true;" onmouseout="window.status=\'\';return true;" title="PDF Katalog">'+
			'<img src="'+oLogo+'" border="0" height="16" width="16" alt="PDF Katalog"></a></td>'+
			'<td bgcolor="'+barColour+'" align="left" valign="middle" style="color:#ffffff;font-family:Arial,Sans-Serif;font-weight:bold;font-size:12px;cursor:pointer;" '+
			'onmouseover="window.status=\'Drag here to move the mini window\';return true;" onmouseout="window.status=\'\';return true;"'+
			(oFullDrag?'':theDragString)+' nowrap>'+oTitle+'</td><td bgcolor="'+barColour+'" align="right" valign="middle" width="34"><nobr>'+
			'<a style="text-decoration:none;cursor:pointer;" href="javascript:showMinWin(\'MWJminiwinMIN'+window.MWJ_MINIWINS+'\',\'MWJminiwinMAX'+window.MWJ_MINIWINS+'\');" onfocus="this.blur()" onmouseover="window.status=\'Click to minimise the mini window\';return true;" onmouseout="window.status=\'\';return true;" title="Minimise.">'+
			'<img src="'+oMin+'" border="0" height="16" width="16" alt="Minimieren"></a>'+
			((oFull&&oDrag&&document.childNodes&&!oFullDrag)?'<a style="text-decoration:none;cursor:pointer;" href="javascript:maximiseWin(\'MWJminiwinMAX'+window.MWJ_MINIWINS+'\',\'MWJminiwinMIN'+window.MWJ_MINIWINS+'\');" onfocus="this.blur()" onmouseover="window.status=\'Click to maximise the mini window\';return true;" onmouseout="window.status=\'\';return true;" title="Maximise.">'+
			'<img src="'+oFull+'" border="0" height="16" width="16" alt="Maximieren"></a>':'')+
			'<a style="text-decoration:none;cursor:pointer;" href="javascript:hideMinWin(\'MWJminiwinMAX'+window.MWJ_MINIWINS+'\');" onfocus="this.blur()" onmouseover="window.status=\'Click to close the mini window\';return true;" onmouseout="window.status=\'\';return true;" title="Schließen">'+
			'<img src="'+oClose+'" border="0" height="16" width="16"  alt="Schließen"></a></nobr></td></tr></table>'+
			'</td></tr><tr><td>'+((anyExtra&&document.childNodes)?anyExtra:'')+'<table border="0" cellpadding="4" cellspacing="0" style="'+
			'border-left:1px solid #7f7f7f;border-top:1px solid #7f7f7f;border-right:1px solid white;border-bottom:1px solid white;" width="100%">'+
			'<tr><td style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid #dfdfdf;border-bottom:1px solid #dfdfdf;background-color:'+
			mainColour+';padding:0px;" valign="top"><div style="'+((oScroll&&document.childNodes&&!(!window.ActiveXObject&&!navigator.taintEnabled&&document.all)&&!(navigator.product=='Gecko'&&navigator.taintEnabled&&typeof(document.textContent)=='undefined')&&!(window.ActiveXObject&&!navigator.__ice_version&&window.ScriptEngineMajorVersion&&(ScriptEngineMajorVersion()+(0.1*ScriptEngineMinorVersion()))<5.5))?'overflow:auto;height:100%;':'')+'padding:2px;font-family:Arial;Verdana;font-size:11px">'+mainContent+'</div></td></tr></table></td></tr></table></td></tr></table></div>' );
		document.write(
			'<div id="MWJminiwinMIN'+window.MWJ_MINIWINS+'" style="width:'+oWidth+'px;z-index:1000;position:absolute;left:'+oLeft+'px;top:'+oTop+'px;visibility:'+((oVis==2)?'visible':'hidden')+';"'+(oFullDrag?theDragString:'')+'>'+
			'<table border="0" cellpadding="0" cellspacing="0" style="background-color:#bfbfbf;border-left:1px solid #dfdfdf;border-top:1px solid #dfdfdf;border-right:1px solid black;border-bottom:1px solid black;" width="100%"><tr>'+
			'<td style="background-color:#bfbfbf;border-left:1px solid white;border-top:1px solid white;border-right:1px solid #7f7f7f;border-bottom:1px solid #7f7f7f;">'+
			'<table border="0" cellpadding="0" cellspacing="1" width="100%" style="border:1px solid #bfbfbf;"><tr><td>'+
			'<table border="0" cellpadding="2" cellspacing="0" width="100%"><tr>'+
			'<td bgcolor="'+barColour+'" align="left" valign="middle" height="16" width="20">'+
			'<a style="text-decoration:none;cursor:pointer;" href="javascript:manuf();" onfocus="this.blur()" onmouseover="window.status=\'Click for information about creating these mini windows\';return true;" onmouseout="window.status=\'\';return true;" title="Info.">'+
			'<img src="'+oLogo+'" border="0" height="16" width="16" alt="Info."></a></td>'+
			'<td bgcolor="'+barColour+'" align="left" valign="middle" style="color:#ffffff;font-family:Arial,Sans-Serif;font-weight:bold;font-size:12px;cursor:pointer;" '+
			'onmouseover="window.status=\'Drag here to move the mini window\';return true;" onmouseout="window.status=\'\';return true;"'+
			(oFullDrag?'':theDragString)+' nowrap>'+oTitle+'</td><td bgcolor="'+barColour+'" align="right" valign="middle" width="34"><nobr>'+
			'<a style="text-decoration:none;cursor:pointer;" href="javascript:showMinWin(\'MWJminiwinMAX'+window.MWJ_MINIWINS+'\',\'MWJminiwinMIN'+window.MWJ_MINIWINS+'\');" onfocus="this.blur()" onmouseover="window.status=\'Click to restore the mini window\';return true;" onmouseout="window.status=\'\';return true;" title="Wiederherstellen">'+
			'<img src="'+oMax+'" border="0" height="16" width="16" alt="Wiederherstellen"></a>'+
			((oFull&&oDrag&&document.childNodes&&!oFullDrag)?'<a style="text-decoration:none;cursor:pointer;" href="javascript:showMinWin(\'MWJminiwinMAX'+window.MWJ_MINIWINS+'\',\'MWJminiwinMIN'+window.MWJ_MINIWINS+'\');maximiseWin(\'MWJminiwinMAX'+window.MWJ_MINIWINS+'\',\'MWJminiwinMIN'+window.MWJ_MINIWINS+'\');" onfocus="this.blur()" onmouseover="window.status=\'Click to maximise the mini window\';return true;" onmouseout="window.status=\'\';return true;" title="Maximise.">'+
			'<img src="'+oFull+'" border="0" height="16" width="16" alt="Maximieren"></a>':'')+
			'<a style="text-decoration:none;cursor:pointer;" href="javascript:hideMinWin(\'MWJminiwinMIN'+window.MWJ_MINIWINS+'\');" onfocus="this.blur()" onmouseover="window.status=\'Click to close the mini window\';return true;" onmouseout="window.status=\'\';return true;" title="Schließen">'+
			'<img src="'+oClose+'" border="0" height="16" width="16" alt="Schließen"></a></nobr></td></tr></table>'+
			'</td></tr></table></td></tr></table></div>' );
	}
	var tempOb = new Object(); tempOb.maxName = 'MWJminiwinMAX'+window.MWJ_MINIWINS; tempOb.minName = 'MWJminiwinMIN'+window.MWJ_MINIWINS; return tempOb;
}

function getRefToDivNest( divID, oDoc ) {
	if( !oDoc ) { oDoc = document; }
	if( document.layers ) {
		if( oDoc.layers[divID] ) { return oDoc.layers[divID]; } else {
			for( var x = 0, y; !y && x < oDoc.layers.length; x++ ) {
				y = getRefToDivNest(divID,oDoc.layers[x].document); }
			return y; } }
	if( document.getElementById ) { return document.getElementById(divID); }
	if( document.all ) { return document.all[divID]; }
	return document[divID];
}

function winMousePos(e) {
	//get the position of the mouse
	if( !e ) { e = window.event; } if( !e || ( typeof( e.pageX ) != 'number' && typeof( e.clientX ) != 'number' ) ) { return [0,0]; }
	if( typeof( e.pageX ) == 'number' ) { var xcoord = e.pageX; var ycoord = e.pageY; } else {
		var xcoord = e.clientX; var ycoord = e.clientY;
		if( !( ( window.navigator.userAgent.indexOf( 'Opera' ) + 1 ) || ( window.ScriptEngine && ScriptEngine().indexOf( 'InScript' ) + 1 ) || window.navigator.vendor == 'KDE' ) ) {
			if( document.documentElement && ( document.documentElement.scrollTop || document.documentElement.scrollLeft ) ) {
				xcoord += document.documentElement.scrollLeft; ycoord += document.documentElement.scrollTop;
			} else if( document.body && ( document.body.scrollTop || document.body.scrollLeft ) ) {
				xcoord += document.body.scrollLeft; ycoord += document.body.scrollTop; } } }
	return [xcoord,ycoord];
}

function clickDiv(div1,div2,e,isRes) {
	//make note of starting positions and detect mouse movements
	if( ( !window.ActiveXObject || navigator.userAgent.indexOf('Mac') == -1 || navigator.__ice_version ) && document.onmousemove == winIsMove ) { document.onmousemove = window.storeMOUSEMOVE; document.onmouseup = window.storeMOUSEUP; return; }
	if( ( e && ( e.which > 1 || e.button > 1 ) ) || ( window.event && ( window.event.which > 1 || window.event.button > 1 ) ) ) { return; }
	MWJ_winZind += 2;
	div1 = getRefToDivNest(div1); div2 = getRefToDivNest(div2); if( !div2 ) { return; } window.msStartCoord = winMousePos(e);
	div1.currentMWJAction = isRes ? true : false;
	if( isRes ) { window.lyStartCoord = [div1.offsetWidth,div1.getElementsByTagName('div')[1].parentNode.offsetHeight,div1.offsetHeight-div1.getElementsByTagName('div')[1].parentNode.offsetHeight];
	} else { window.lyStartCoord = div1.style?[parseInt(div1.style.left),parseInt(div1.style.top)]:[parseInt(div1.left),parseInt(div1.top)]; }
	if( div1.style ) { div1.style.zIndex = MWJ_winZind; div2.style.zIndex = MWJ_winZind + 1; } else { div1.zIndex = MWJ_winZind; div2.zIndex = MWJ_winZind + 1; }
	if( document.captureEvents && Event.MOUSEMOVE ) { document.captureEvents(Event.MOUSEMOVE); document.captureEvents(Event.MOUSEUP); }
	if( !window.ActiveXObject || navigator.userAgent.indexOf('Mac') == -1 || navigator.__ice_version ) { window.storeMOUSEMOVE = document.onmousemove; window.storeMOUSEUP = document.onmouseup; }
	window.storeLayer = [div1,div2]; document.onmousemove = winIsMove; document.onmouseup = winIsMove;
}

function winIsMove(e) {
	//move the layer to its newest position
	var msMvCo = winMousePos(e); if( !e ) { e = window.event ? window.event : ( new Object() ); }
	e.cancelBubble = true; if( e.stopPropagation ) e.stopPropagation();
	var newX = window.lyStartCoord[0] + ( msMvCo[0] - window.msStartCoord[0] );
	var newY = window.lyStartCoord[1] + ( msMvCo[1] - window.msStartCoord[1] );
	//reset the mouse monitoring as before - delay needed by Gecko to stop jerky response (hence two functions instead of one)
	//as long as the Gecko user does not release one window then click on another within 1ms (!) this will cause no problems
	if( e.type && e.type.toLowerCase() == 'mouseup' ) { document.onmousemove = window.storeMOUSEMOVE; document.onmouseup = window.storeMOUSEUP; }
	if( navigator.product == 'Gecko' ) { window.setTimeout('winIsMove2('+newX+','+newY+');',1); } else { winIsMove2(newX,newY); }
}

function winIsMove2(y,z) {
	if( window.storeLayer[0].currentMWJAction ) { doActualResize(window.storeLayer,y,z,window.lyStartCoord[2]);
	} else { for( var x = 0, oPix = ( document.childNodes ? 'px' : 0 ); x < 2; x++ ) {
		var theLayer = window.storeLayer[x].style ? window.storeLayer[x].style : window.storeLayer[x]; theLayer.left = y + oPix; theLayer.top = z + oPix; }
} }

function doActualResize(oDivs,y,z,offSet) {
	//resize - first to what you want, then again to what was possible (stops the drag handle moving inside the window)
	for( var x = 0; x < 2; x++ ) {
		var theLayer = oDivs[x]; if( y < 0 ) { y = 0; }
		if( !x && theLayer.getElementsByTagName('div')[1].style.overflow == 'auto' && navigator.product=='Gecko' && navigator.taintEnabled ) {
			//gecko bug (otherwise cannot make it get narrower and the drag handle moves wrong)
			var ppDv = theLayer.getElementsByTagName('div')[1];
			if( !ppDv.tmpDiv ) { ppDv.tmpDiv = document.createElement('div'); ppDv.appendChild( ppDv.tmpDiv );
				while( ppDv.childNodes[0] != ppDv.tmpDiv ) { ppDv.tmpDiv.appendChild( ppDv.childNodes[0] ); } }
			ppDv.tmpDiv.style.display = 'none'; ppDv.style.overflow = ''; ppDv.style.height = ''; }
		theLayer.style.width = y + 'px';
		if( !x ) {
			y = theLayer.getElementsByTagName('div')[1].parentNode.offsetWidth + 10; theLayer.style.width = y + 'px';
			if( z < 20 ) { z = 20; } theLayer.getElementsByTagName('div')[1].parentNode.style.height = z + 'px';
			if( !window.ActiveXObject && !navigator.taintEnabled ) { theLayer.getElementsByTagName('div')[1].style.height = ( z - 4 ) + 'px'; }
			z = theLayer.getElementsByTagName('div')[1].parentNode.offsetHeight;
			if( !window.ActiveXObject && !navigator.taintEnabled ) { theLayer.getElementsByTagName('div')[1].style.height = ( z - 4 ) + 'px'; z += 2; }
			theLayer.getElementsByTagName('div')[1].parentNode.style.height = z + 'px'; theLayer.style.height = ( z + offSet ) + 'px';
			if( theLayer.getElementsByTagName('div')[1].tmpDiv ) {
				ppDv.tmpDiv.style.display = 'block'; ppDv.style.overflow = 'auto'; ppDv.style.height = doNumMax(96+(ppDv.parentNode.offsetHeight/500))+'%'; }
} } }
function doNumMax(oNm) { return ( oNm > 99 ) ? 99 : oNm; }

function reWriteWin(theWin,minName,newContent) {
	//rewrite the window content if possible
	var theWin = getRefToDivNest(theWin), minName = getRefToDivNest(minName); if( theWin && document.childNodes && theWin.getElementsByTagName && theWin.getElementsByTagName('div')[1] ) {
		if( !window.ActiveXObject && !navigator.taintEnabled ) { theWin.getElementsByTagName('div')[1].style.height = ( theWin.getElementsByTagName('div')[1].offsetHeight - 4 ) + 'px'; }
		theWin.getElementsByTagName('div')[1].parentNode.style.height = theWin.getElementsByTagName('div')[1].parentNode.offsetHeight + 'px';
		if( window.ActiveXObject && navigator.platform.indexOf( 'Mac' ) + 1 && !navigator.__ice_version ) {
			var theOffset = theWin.offsetHeight - theWin.getElementsByTagName('div')[1].parentNode.offsetHeight;
		} else { var theOffset = theWin.offsetHeight - theWin.getElementsByTagName('div')[1].offsetHeight; }
		theWin.getElementsByTagName('div')[1].innerHTML = newContent;
		if( window.ActiveXObject && navigator.platform.indexOf( 'Mac' ) + 1 && !navigator.__ice_version ) {
			theWin.style.height = ( theWin.getElementsByTagName('div')[1].parentNode.offsetHeight + theOffset ) + 'px';
		} else { theWin.style.height = ( theWin.getElementsByTagName('div')[1].offsetHeight + theOffset ) + 'px'; }
		theWin.style.width = theWin.offsetWidth + 'px'; minName.style.width = theWin.offsetWidth + 'px';
} }

function changeWinBG(winName,newBG) {
	var theWin = getRefToDivNest(winName); if( theWin && theWin.parentNode && theWin.getElementsByTagName && theWin.getElementsByTagName('div')[1] ) {
		theWin.getElementsByTagName('div')[1].parentNode.style.backgroundColor = newBG;
} }

function moveWin(oMax,oMin,x,y) {
	oMax = getRefToDivNest(oMax); oMin = getRefToDivNest(oMin); if( !oMax ) { return; }
	if( oMax.style ) { oMax = oMax.style; oMin = oMin.style; } var oPix = document.childNodes ? 'px' : 0;
	oMax.left = x + oPix; oMin.left = x + oPix; oMax.top = y + oPix; oMin.top = y + oPix;
}

function resizeWin(oMax,oMin,y,z) {
	oMax = [getRefToDivNest(oMax),getRefToDivNest(oMin)]; if( !oMax[0] ) { return; }
	if( oMax[0].getElementsByTagName && document.childNodes ) {
		var oTitlSiz = oMax[0].offsetHeight - oMax[0].getElementsByTagName('div')[1].parentNode.offsetHeight;
		z = z - oTitlSiz; doActualResize(oMax,y,z,oTitlSiz);
} }

function maximiseWin( oMax, oMin ) {
	var div1 = getRefToDivNest(oMax), div2 = getRefToDivNest(oMin); if( !div2 ) { return; } MWJ_winZind += 2;
	if( div1.style ) { div1.style.zIndex = MWJ_winZind; div2.style.zIndex = MWJ_winZind + 1; } else { div1.zIndex = MWJ_winZind; div2.zIndex = MWJ_winZind + 1; }
	var newSet = findMaxSize();
	moveWin(oMax,oMin,newSet[0],newSet[1]);
	resizeWin(oMax,oMin,newSet[2],newSet[3]);
}

function findMaxSize() {
	if( typeof( window.pageXOffset ) == 'number' ) { var x = window.pageXOffset, y = window.pageYOffset;
	} else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
		var x = document.documentElement.scrollLeft, y = document.documentElement.scrollTop;
	} else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
		var x = document.body.scrollLeft, y = document.body.scrollTop;
	} else { var x = 0, y = 0; }
	if( window.innerWidth ) { var w = window.innerWidth, h = window.innerHeight;
	} else if( document.documentElement && document.documentElement.clientWidth ) {
		var w = document.documentElement.clientWidth, h = document.documentElement.clientHeight;
	} else if( document.body && document.body.clientWidth ) {
		var w = document.body.clientWidth, h = document.body.clientHeight;
	} else { var w = 400, h = 400; } if( window.opera || ( navigator.product == 'Gecko' && navigator.taintEnabled ) ) { w -= 16; }
	if( !window.ActiveXObject && !navigator.taintEnabled ) { h -= 4; }
	return [x,y,w,h]
}

function hideMinWin(thisDiv) {
	//this function hides the div
	thisDiv = getRefToDivNest(thisDiv); if( !thisDiv ) { return; }
	if( thisDiv.style ) { thisDiv.style.visibility = 'hidden'; } else { thisDiv.visibility = 'hide'; }
}

function showMinWin(thisDiv,thatDiv) {
	//this function shows the div and hides the old one if necessary
	thisDiv = getRefToDivNest(thisDiv); if( thatDiv ) { hideMinWin(thatDiv); } if( !thisDiv ) { return; }
	MWJ_winZind += 2; if( thisDiv.style ) { thisDiv.style.visibility = 'visible'; thisDiv.style.zIndex = MWJ_winZind;
	} else { thisDiv.visibility = 'show'; thisDiv.zIndex = MWJ_winZind; }
}

function manuf() {
	window.alert('PDF Katalog - by h.koch');
}