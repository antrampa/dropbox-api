/*
*	@Ajax.js
*	Ajax class
*	@Version 1.0
*
*	@Created : 24-10-2008
*	@Owner   : Antranik Ampartsoumian
*/

Ajax = {};																//Ajax class

																		//Creaye XHRs Object
Ajax.makeRequest = function(method, url, callbackMethod)
{
	this.request = (window.XMLHttpRequest) ? new XMLHttpRequest(): new ActiveXObject("MSXML2.XMLHTTP");
	this.request.onreadystatechange = callbackMethod;
	this.request.open(method, url, true);
	this.request.send(url);
}

Ajax.checkReadyState = function(_id)
{
	var textLoading = '<table bgcolor=green width=200><tr><td style="color:#ffffff; border:1px solid #ffffff;"><b>Loaaaaaaaading ...................</b></td></tr></table>';	
	switch( this.request.readyState )	
	{
		case 1:
			document.getElementById(_id).innerHTML = textLoading;
			document.body.style.cursor = 'wait';
			
			break;
		case 2:
			document.getElementById(_id).innerHTML = textLoading;
			document.body.style.cursor = 'wait';
			break;
		case 3:
			document.getElementById(_id).innerHTML = textLoading;
			document.body.style.cursor = 'wait';
			break;
		case 4:
			AjaxUpdater.isUpdating = false;								//in the file AjaxUpdater.js
			document.getElementById(_id).innerHTML = ''; 
			document.body.style.cursor = 'auto';
			return this.request.status;	
			break;
	}
}

Ajax.getResponse = function()
{
	if( this.request.getResponseHeader('Content-Type').indexOf('xml') != -1 )
	{
		return this.request.responseXML.documentElement;
	}
	else
	{
		return this.request.responseText;
	}
}







