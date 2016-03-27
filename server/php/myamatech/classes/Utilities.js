/* 
* Utilities.js
* Version 1.00
*
* Created Date 2/11/2008
*
* Owner @Ampartsoumian Antranik 
*       @with Kris Hadlock's Book
*
*
*/

Utilities = {};

Utilities.includeJS = function(filepaths)
{
	for( var i=0; i<filepaths.length; i++ )	
	{
		document.write('<script type="text/javascript" src="' + filepaths[i] + '"></script>');	
	}
}

Utilities.includeCSS = function(filepaths)
{
	for( var i=0; i<filepaths.length; i++ )	
	{
		document.write('<link href="' + filepaths[i] + '" rel="stylesheet" type="text/css" />');	
	}
}
/*
etc

var myCSS = new Array("css/style.css", "css/myStyle1","css2/style2.css");
Utilities.includeCSS(myCSS);

*/

Utilities.getElement = function(i) { return document.getElementById(i); }

Utilities.debug = function(val)
{
	this.getElement('debug').innerHTML += val + "</br>";
}

/* sample 
*
*	<div id="debug"></div>
*/

Utilities.toggle = function(id)
{
	this.getElement(id).style.display = ( this.getElement(id).style.display == '' ) ? 'none' : '';
}

Utilities.createElement = function(e, obj)
{
	var element = document.createElement(e);
	for( prop in obj )
	{
		element[prop] = obj[prop];
	}
	return element;
}

/*
example
var test = Utilities.createElement('div',{id:'test', class:'test', innerHTML:'this is a test'} );

*/


Utilities.appendChild = function()
{
	if( this.appendChild.arguments.length >  1 )
	{
		var a = this.appendChild.arguments[0];
		for( var i=1; i<this.appendChild.arguments.length; i++ )
		{
			if( arguments[i] )
			{
				a.appendChild( this.appendChild.arguments[i] );
			}
		}
		return a;
	}
	else
	{
		return null;
	}
}


Utilities.removeChildren = function(node)
{
	if( node == null )
	{
		return;
	}
	
	while( node.hasChildNodes() )
	{
		node.removeChild( node.fristChild );
	}
}

Utilities.addListener = function( obj, eventName, listener )
{
	if( obj.attachEvent )
	{
		obj.attachEvent( "on" + eventName, listener );
	}
	else if( obj.addEventListener )
	{
		obj.addEventListener( eventName, listener, false );
	}
	else
	{
		return false;
	}
	return true;
}

Utilities.removeListener = function( obj, eventName, listener )
{
	if( obj.detachEvent )
	{
		obj.detachEvent( "on" + eventName, listener );
	}
	else if( obj.removeEventListener )
	{
		obj.removeEventListener( eventName, listener, false );
	}
	else
	{
		return false;
	}
	return true;
}

Utilities.changeOpac = function( opacity, id )
{
	var object = Utilities.getElement(id).style;
	object.opacity = ( opacity/100 );
	object.MozOpacity = ( opacity / 100 );
	object.KhtmlOpacity = ( opacity / 100 );
	object.filter = "alpha(opacity=" + opacity + ")";
}

















