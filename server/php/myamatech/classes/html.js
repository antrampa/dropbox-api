// my html Classe
/*
*	html Classe
*	Version 1.0
*
*	Date 7/11/2008
*
*	Created Date 7/11/2008
*
*	Owner Antranik Ampartoumian
*/

html = {};

html.makeOnChage = function(id)
{
	var chbox = document.getElementById(id);
	//alert(id);
	//alert(chbox.checked);
	if( chbox.checked == true )
		chbox.checked = false;
	else if( chbox.checked == false )
		chbox.checked = true;
}



html.setOpacity_html = function(testObj_ID,value) 
{
	//alert(value);
	var testObj = document.getElementById(testObj_ID);
	testObj.style.opacity = value;///10;
	testObj.style.filter = 'alpha(opacity=' + value + ')';
	
	/*
	if( i<150 )	
	{
		var testObj = document.getElementById(testObj_ID);
		testObj.style.opacity = i;///10;
		testObj.style.filter = 'alpha(opacity=' + i + ')';
	 	//createDiv(testObj_ID);
		i+= 10;
		//alert(i);
		setTimeout("setOpacity('"+testObj_ID+"','12')",0.00001);
	}	
	*/
}

html.openWindow = function(url,target)
{
	window.open(url,target);
}

html.makeOnEdit = function(id,value)
{
	var text = '<div>asasd</div>'	
	//document.write(text);
}