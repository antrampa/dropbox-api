/*
*	@AjaxUpdater.js
*	AjaxUpdater class
*	@Version 1.0
*
*	@Created : 24-10-2008
*	@Owner   : Antranik Ampartsoumian
*/

AjaxUpdater = {};

AjaxUpdater.initialize = function()
{
	AjaxUpdater.isUpdating = false;
}
AjaxUpdater.initialize();

AjaxUpdater.Update = function(method, service, callback)
{
	if( callback == undefined || callback == "" )
	{
		callback = AjaxUpdater.onResponse;
	}
	Ajax.makeRequest(method, service, callback);
	AjaxUpdater.isUpdating = true;
}

AjaxUpdater.UpdateInsert = function(method, service, callback)
{
	if( callback == undefined || callback == "" )
	{
		callback = AjaxUpdater.onResponse;
	}
	Ajax.makeRequest(method, service, callback);
	AjaxUpdater.isUpdating = true;
}

AjaxUpdater.onResponse = function()
{
	if( Ajax.checkReadyState('loading') == 200 )				//Done
	{
		AjaxUpdater.isUpdating = false;	
	}
}

AjaxUpdater.onResponse_shapes = function()
{
	if( Ajax.checkReadyState('loading') == 200 )				//Done
	{
		AjaxUpdater.isUpdating = false;	
	}
}



