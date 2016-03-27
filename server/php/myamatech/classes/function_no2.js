/*
* JavaScript Functions No2
* 
* @Version 1.0
* @15-10-2009
*
* @Version 1.0
* @15-10-2009
*
* @Owner © Antonis Ampartsoumian
*  
*/




function addRowOverUrl( tblID, tblCountInputID, thisRowNum, photoID )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var divKeywords = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_ov_brand' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_ov_category_keywords' + iteration;
		div.innerHTML = iteration;
		//otherDivs += ',' + div.id;
		divKeywords = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_ov_target' + iteration;
		div.innerHTML = iteration;
		otherDivs += ',' + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_ov_web_site' + iteration;
		div.innerHTML = iteration;
		otherDivs += ',' + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_ov_website_url' + iteration;
		div.innerHTML = iteration;
		otherDivs += ',' + div.id;
	 cellLeft.appendChild(div); 
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('get_new_photos_overview_website.php?photoID='+photoID,this,iteration,'#@%ampa%@#',otherDivs);
	 
	 /*
	 //Add a line too for the keywords
	 var otherDivs = "";
 	 var row = tbl.insertRow(lastRow+1);		
	
	 var cellLeft = row.insertCell(0); //colspan(5)
	 cellLeft.setAttribute("colSpan","5"); 
		var div = document.createElement('div');
		div.id = 'div_ov_web_site_keywords' + iteration;
		div.innerHTML = iteration;
		otherDivs =  div.id;
	 cellLeft.appendChild(div); 
	 */
	 getDescriptionInnerHTMLSomeDivWithCountSplit('get_over_website_keywords.php',this,iteration,'#@%ampa%@#',divKeywords);
	
	document.getElementById(tblCountInputID).value++;
}


function addRowOverUrl_keywords( tblID, tblCountInputID, thisRowNum, containTableNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_ov_web_site_keyword_category_id'+containTableNum+'_' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_site_keywords_id'+containTableNum+'_' + iteration;
		div.innerHTML = iteration;
		otherDivs += ',' + div.id;
	 cellLeft.appendChild(div); 
	
	 getDescriptionInnerHTMLSomeDivWithCountSplit_container('get_new_photos_website_keywords_dropLists.php',this,containTableNum,'#@%ampa%@#',otherDivs,iteration)
	
	document.getElementById(tblCountInputID).value++;
}


function getDescriptionInnerHTMLSomeDivWithCountSplit_container(url,obj,Count,Split,fieldValueIDs,subContainerCount)
{
	url += '?id=' + obj.value+'\&Count='+Count+'\&subContainerCount='+subContainerCount;
	
	//alert(url);
	var TablefieldValueIDs = fieldValueIDs.split(",");
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			var table = res.split(Split);
			//alert(res);
			for( var i=0; i < TablefieldValueIDs.length; i++ )
			{
				var divid = TablefieldValueIDs[i];
				//alert(divid);
				Utilities.getElement(divid).innerHTML = table[i];
				//alert(Utilities.getElement(divid).innerHTML);
			}
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
			//document.body.style.cursor = 'auto';
			//document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
}


function getDescriptionInnerHTMLSomeDivWithCountSplit_secondCounter(url,obj,Count,Split,fieldValueIDs,secCounter)
{
	url += '?id=' + obj.value+'\&Count='+Count;
	url += '\&secCounter='+secCounter;
	//alert(url);
	var TablefieldValueIDs = fieldValueIDs.split(",");
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			var table = res.split(Split);
			//alert(res);
			for( var i=0; i < TablefieldValueIDs.length; i++ )
			{
				var divid = TablefieldValueIDs[i];
				//alert(divid);
				Utilities.getElement(divid).innerHTML = table[i];
				//alert(Utilities.getElement(divid).innerHTML);
			}
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
			//document.body.style.cursor = 'auto';
			//document.getElementById('loading').innerHTML = '';
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
}


var fnd_sec = "";

function findOption_withCtgry(site,divID,Obj,catID) { //sel, evt
	
	fnd += String.fromCharCode(event.keyCode);
   //alert(divID);
   //document.getElementById(divID).style.display = 'block';
	var xmlHttp = getxmlHttp();
	
	var ObjID = Obj.id;
	var url = site;
	url += '?objID=' + ObjID + '\&catID='+ catID + '\&text=' + fnd;
	
	

  xmlHttp.onreadystatechange=function()
    {
    if(xmlHttp.readyState==4)
      {
		  	
      		document.getElementById(divID).innerHTML=xmlHttp.responseText;
			//alert(xmlHttp.responseText);
			document.getElementById(divID).style.display = 'block';
     	   document.getElementById('loading').innerHTML = "";
	  }
	  else
	   {
			document.getElementById('loading').innerHTML = "Loading...";
	   }
    }
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);

}

function findOption_withCtgry_v2(site,divID,Obj,catID) { //sel, evt
	
	var txt =  Obj.value;
	
   //alert(catID);
   //document.getElementById(divID).style.display = 'block';
	var xmlHttp = getxmlHttp();
	
	var ObjID = Obj.id;
	var url = site;
	url += '?objID=' + ObjID + '\&catID='+ catID + '\&text=' + txt;
	
	

  xmlHttp.onreadystatechange=function()
    {
    if(xmlHttp.readyState==4)
      {
		  	//alert(xmlHttp.responseText);
      		document.getElementById(divID).innerHTML=xmlHttp.responseText;
			
			document.getElementById(divID).style.display = 'block';
     	  	document.getElementById('loading').innerHTML = "";
	  }
	  else
	   {
			document.getElementById('loading').innerHTML = "Loading...";
	   }
    }
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);

}


function addRowParamSEOKeywords( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_seo_category' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	
	 getDescriptionInnerHTMLSomeDivWithCountSplit('get_seoKeywords_categoyDropList.php',this,iteration,'#@%ampa%@#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}




function addRowParamSEOOvWebsites( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	//alert(lastRow);
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_seo_website' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 //alert(tblCountInputID);
	
	 getDescriptionInnerHTMLSomeDivWithCountSplit('get_seoOv_websiteDropList.php',this,iteration,'#@%ampa%@#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}

function put_item_to_colorprop(url,item_id,colorprop_id,divid,filters)
{
	//alert(item_id + ' ' +colorprop_id);
	url += '?id=' + item_id+'\&colorprop_id='+colorprop_id;
	url += '\&' + filters;
	//alert(url);
		
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divid).innerHTML = res;	
      	}
		
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
	
}

function put_item_to_colorprop_v2(url,item_id,colorprop_id,divid,filters,selectedUses,use)
{
	//alert(item_id + ' ' +colorprop_id);
	url += '?id=' + item_id+'\&colorprop_id='+colorprop_id;
	url += '\&selectedUses=' + selectedUses;
	url += '\&use=' + use;
	url += '\&' + filters;
	
	//alert(url);
	
	if( selectedUses == "first" )
		divid += "1";
	else if( selectedUses == "second" )
		divid += "2";
	else if( selectedUses == "third" )
		divid += "3";
	else if( selectedUses == "fourth" )
		divid += "4";	
		
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divid).innerHTML = res;	
      	}
		
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
	
}

function addRowDetailsInvoicing( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_aa' + iteration;
		div.innerHTML = iteration+1;
		
	 cellLeft.appendChild(div); 
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_detail_item' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
		 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_detail_desc' + iteration;
		div.innerHTML = '';
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_detail_qty' + iteration;
		div.innerHTML = '';
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_detail_unitprice' + iteration;
		div.innerHTML = '';
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_detail_discount' + iteration;
		div.innerHTML = '';
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_detail_fprice' + iteration;
		div.innerHTML = '';
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_detail_value' + iteration;
		div.style.fontWeight = 'normal';
		div.innerHTML = '';
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_invoicing_newRows.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowInvoicingOffer( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var divKeywords = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_offer_text' + iteration;
		div.innerHTML = 'Offer ID:';
		//otherDivs = div.id;
	 cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_offer_field' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
		divKeywords = div.id;
	 cellLeft.appendChild(div); 
	 
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../live_search/get_invoicing_NewOffers.php',this,iteration,'#@%ampa%@#',divKeywords);
	
	document.getElementById(tblCountInputID).value++;
}

function deleteColorProp(site,divID,ObjID) 
{	
	var xmlHttp = getxmlHttp();
	
	var url = site;
	url += '?objID=' + ObjID;
	
	

  xmlHttp.onreadystatechange=function()
    {
    if(xmlHttp.readyState==4)
      {
		  	//alert(xmlHttp.responseText);
      		document.getElementById(divID).innerHTML=xmlHttp.responseText;
			
			
	  }
	  else
	   {
			document.getElementById(divID).innerHTML = "Loading...";
	   }
    }
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);

}


function loadSubFolders(url,div,num)
{
	var xmlHttp = getxmlHttp();
	url += '\&num='+num;
	xmlHttp.onreadystatechange=function()
    {
    if(xmlHttp.readyState==4)
      {
		  	//alert(xmlHttp.responseText);
      		document.getElementById(div).innerHTML=xmlHttp.responseText;
			
			
	  }
	  else
	   {
			document.getElementById(div).innerHTML = "Loading...";
	   }
    }
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);
}

function addRowDetailsOfferMyGlassPlateOnlySmaples( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_aa' + iteration;
		div.innerHTML = iteration;
		
	 cellLeft.appendChild(div); 
	
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_status' + iteration;
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_shape' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_4code_mgp' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	
	 
	 
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_detail_desc' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_detail_minqty2' + iteration;
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_detail_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_detail_masterpack' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	  var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_detail_euro' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	  var cellLeft = row.insertCell(9);
		var div = document.createElement('div');
		div.id = 'div_detail_euro_qty' + iteration;
		div.style.fontWeight = 'normal';
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	  var cellLeft = row.insertCell(10);
		var div = document.createElement('div');
		div.id = 'div_detail_discount' + iteration;
		div.style.fontWeight = 'normal';
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(11);
		var div = document.createElement('div');
		div.id = 'div_detail_price_after_disc' + iteration;
		div.style.fontWeight = 'normal';
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(12);
		var div = document.createElement('div');
		div.id = 'div_detail_price_pcs_after_disc' + iteration;
		div.style.fontWeight = 'normal';
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 
	 var cellLeft = row.insertCell(13);
		var div = document.createElement('div');
		div.id = 'div_detail_position' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	 
	 var cellLeft = row.insertCell(14);
		var div = document.createElement('div');
		div.id = 'div_detail_remark' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 
	 
	 
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_offerMyGlassPlate_newRows_dropListsNew_onlySamples.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowMaterialCompany( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_comp_text' + iteration;
		div.innerHTML = 'Company:';
		
	 cellLeft.appendChild(div); 
	
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_comp_dl' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
	 cellLeft.appendChild(div);  	
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../live_search/get_material_newRows_dl.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}



function addRowMaterialCompanyBasicInfo( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	 
	 var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_comp_dl' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
	 cellLeft.appendChild(div);  	
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_material_newRows_basicInfo_dl.php',droplist,iteration,'#newRowsSplit#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowMaterialToNewSupplier( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_supCompany' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
		cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_supplier_type' + iteration;
		div.innerHTML = 'ampa' + iteration; 
		otherDivs += ',' + div.id;
		
	 cellLeft.appendChild(div);
	 
	  var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_metal_supplier' + iteration;
		div.innerHTML = ''; 
		otherDivs += ',' + div.id;
		
	 cellLeft.appendChild(div);
	 
	
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getMaterialSupplier_dropLists_2.php',this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}


function addRowMaterialToCategoryDeprtmnt( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_cat_dl' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
		cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_catdprt' + iteration;
		div.innerHTML = '';
		otherDivs += ',' + div.id;
		
	 cellLeft.appendChild(div);
	 
	
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getMaterialCauseDrptmn_dropLists.php',this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}

function deletePhoto_v2(url,id,photoFieldName,tableName,idFieldName,photo,returnUrl)
{	
	if( confirm('Are you sure?') )
	{
		url += '?id='+id;
		url += '\&photoFieldName='+photoFieldName+'\&returnUrl='+returnUrl;
		url += '\&tableName='+tableName+'\&idFieldName='+idFieldName;
		url += '\&photo='+photo;
		//alert( url );
		parent.location = url;
	}
}

function addRowPrOrderOtherMaterial( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_pur_orderOtherMat_date' + iteration;
		div.innerHTML = "Style";
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pur_orderOtherMat_company' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_pur_orderOtherMat_supplier' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_pur_orderOtherMat_qtyr' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_pur_orderOtherMat_balance' + iteration;
		div.innerHTML = '';
		//otherDivs += "," + div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_pur_orderOtherMat_receiving_button' + iteration;
		div.innerHTML = iteration;
		otherDivs += "," + div.id;
	 cellLeft.appendChild(div); 
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_pur_otherMaterialOrder_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowPurchasingOtherMaterial( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_pur_othermaterial_date' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pur_othermaterial_supplier' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_pur_othermaterial_inv_no' + iteration;
		div.innerHTML = '' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_pur_othermaterial_qty' + iteration;
		div.innerHTML = '' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_pur_othermaterial_price_kilo' + iteration;
		div.innerHTML = '' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_pur_othermaterial_price_pc' + iteration;
		div.innerHTML = '' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	  
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_pur_keno' + iteration;
		div.innerHTML = '';
		
	 cellLeft.appendChild(div);
	 
	
	 
	 		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_purch_other_material_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowConsOtherMaterial( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_pur_cons_othermaterial_date' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	
	 var cellLeft = row.insertCell(1);
	 cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_cons_company' + iteration;
		div.innerHTML = '' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	
	 var cellLeft = row.insertCell(2);
	 cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_cons_othermaterial_qty' + iteration;
		div.innerHTML = '' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 var cellLeft = row.insertCell(3);
	 cellLeft.align = 'center';
		var div = document.createElement('div');
		div.id = 'div_pur_cons_othermaterial_orderno' + iteration;
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	  
	 var cellLeft = row.insertCell(4);
	 	var div = document.createElement('div');
		div.id = 'div_pur_cons_othermaterial_action' + iteration;
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 		
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_purch_othermaterial_cons_dropLists_2.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function getDescriptionInnerHTMLSomeDivWithCountSplitFiled(url,obj,Count,Split,fieldValueIDs,field)
{
	url += '?id=' + obj.value+'\&Count='+Count;
	url += '\&field='+field;
	//alert(url);
	var TablefieldValueIDs = fieldValueIDs.split(",");
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			var table = res.split(Split);
			//alert(res);
			for( var i=0; i < TablefieldValueIDs.length; i++ )
			{
				var divid = TablefieldValueIDs[i];
				//alert(divid);
				//Utilities.getElement(divid).innerHTML = table[i];
				document.getElementById(divid).innerHTML = table[i];
				//alert(Utilities.getElement(divid).innerHTML);
			}
			//Utilities.getElement('style_code').value =  Utilities.getElement('tempPatternCode').value + Utilities.getElement('tempProtColorCode').value;
			//document.body.style.cursor = 'auto';
			//document.getElementById('loading').innerHTML = '';
			
			obj.style.backgroundColor = 'green';
			obj.style.color = 'white';
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
}

function saveShapeDifficult(url,obj,fieldName,linkID)
{
	url += '?id=' + obj.value+'\&fieldName='+fieldName;
	url += '\&linkID='+linkID;
	//alert(url);
	
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			if( res == 1 )
			{
				obj.style.borderColor = 'green';
				obj.style.borderWidth = '2px';
				obj.style.backgroundColor = 'green';
				obj.style.color = '#ffffff';
			}
			else
				alert(res);
			//alert(obj.style.borderColor);
      	}
		
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function getShapeCorrectQty(ObjQty,mastQty)
{
	qty = ObjQty.value;
	//q = qty % mastQty;
	
	//qa = parseInt(qty / mastQty);
	//if( qa < 1 ) qa = 1;
	
	if( qty < mastQty )
	{
		alert("The Minimum Quantity is " + mastQty + " pcs ");
		ObjQty.value = mastQty; // * qa;
	}	
}


function saveMoldEparkeiaImport(url,mold_id,orders_id,company_id,budgetObjID,important_id,command)
{
	url += '?mold_id=' + mold_id+'\&orders_id='+orders_id;
	url += '\&company_id='+company_id;
	url += '\&important_id='+important_id;
	url += '\&command='+command;
	url += '\&budget='+document.getElementById(budgetObjID).value;
	
	//alert(url);
	
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			
      	}
		
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}


function saveStageTwo_v2(week_program_id,pcsID,kilnID,otherQtyID,insertedDate,order_id,idOfWeekProgram)
{
	var pcs  = document.getElementById(pcsID).value;
	var kiln = document.getElementById(kilnID).value;
	var otherQty = document.getElementById(otherQtyID).value;
	//alert(kiln);	
	
	week_program_id = document.getElementById(idOfWeekProgram).value;
	//alert(week_program_id);
	
	var url = 'production_schedule_add_edit/update_stage_two_submit_once.php';
	url += '?week_program_id='+week_program_id;
	url += '\&pcs='+pcs;
	url += '\&kiln='+kiln;
	url += '\&otherQty='+otherQty;
	url += '\&insertedDate='+insertedDate; 
	url += '\&order_id='+order_id; 
	
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(idOfWeekProgram).value = res;
			
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}

function saveStageOneCalHours(week_program_idDefault,pcsID,kilnID,otherQtyID,insertedDate,order_id,idOfWeekProgram,obj,header_id)
{
	var pcs  = document.getElementById(pcsID).value;
	var kiln = document.getElementById(kilnID).value;
	var otherQty = document.getElementById(otherQtyID).value;
	//alert(document.getElementById(pcsID).value);	
	
	week_program_id = document.getElementById(idOfWeekProgram).value;
	//alert(week_program_id);
	
	var url = 'production_schedule_add_edit/update_stage_one_calchours_submit_once.php';
	url += '?week_program_id='+week_program_id;
	url += '\&pcs='+document.getElementById(pcsID).value; //pcs;
	url += '\&kiln='+kiln;
	url += '\&otherQty='+otherQty;
	url += '\&insertedDate='+insertedDate; 
	url += '\&order_id='+order_id; 
	url += '\&header_id='+header_id; 
	
	//alert(url);
	
	var loadingWindow;
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			
			//alert( res );
			
			var tbl = res.split('#mySpliter#');
			
			//alert( tbl[0] );
			//alert( tbl[1] );
			
			document.getElementById('div_calhours').innerHTML = tbl[0];
			document.getElementById(idOfWeekProgram).value = tbl[1];
			
			loadingWindow.close();
			//this.window.focus();
			alert('ok');
			
			
			//document.getElementById('div_calhours').innerHTML = res;
			//alert('ok');
			
			obj.style.backgroundColor = 'green';
			obj.style.color = 'white';
			
			document.getElementById('loading').innerHTML = '';
			
			
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			var top = (screen.height / 2) - 100;
			var left = (screen.width / 2) - 150;
			loadingWindow = window.open('mywindow.html','myWind','width=300,height=200,top='+top+', left='+left+'');
			document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function confirmCm2(obj)
{
	
	var url = "confirm_cm2.php?value="+obj.value;
	//url += '\&cm2='+cm2;
	//url += '\&qty='+qty;
	
	var xmlHttp = getxmlHttp();
	var res;
	
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			res = xmlHttp.responseText;
			var total = document.getElementById('total_cm2');
			
			res = parseFloat(res);
			
			document.getElementById('total_cm2').value = res;//parseFloat( qty + parseFloat(total.value) );
			alert('Confirm has done! \n You must click to the button \"Add\"');
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}


function getKilnCm2_v3( cm2,qty,returnID,uniqeID,order_id,resCount )
{
	document.getElementById(returnID).innerHTML = parseFloat( cm2 * qty ); 
	
	var url = "get_total_programCm2_v3.php?uniqeID="+uniqeID;
	url += '\&order_id='+order_id;
	url += '\&cm2='+cm2;
	url += '\&qty='+qty;
	url += '\&resCount='+resCount;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	var res;
	
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			res = xmlHttp.responseText;
			var total = document.getElementById('total_cm2');
			
			
			res = parseFloat(res);
			total.value = '';
			
			total.value = res;//parseFloat( qty + parseFloat(total.value) );
	
      	}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
   
	
}

function saveOfferStatus(url,obj,fieldName,linkID,thevalue)
{
	url += '?id=' + thevalue+'\&fieldName='+fieldName;
	url += '\&linkID='+linkID;
	//alert(url);
	
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			if( res == 1 )
			{
				obj.style.borderColor = 'green';
				obj.style.borderWidth = '2px';
				obj.style.backgroundColor = 'green';
				obj.style.color = '#ffffff';
			}
			else
				alert(res);
			//alert(obj.style.borderColor);
      	}
		
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}

function addRowBonusEdit( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_aa' + iteration;
		div.innerHTML = iteration + 1;
		//otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_emploee' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_type' + iteration;
		div.innerHTML = iteration;
		otherDivs += ',' + div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_grade' + iteration;
		div.innerHTML = iteration;
		otherDivs += ',' + div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_amount' + iteration;
		div.innerHTML = iteration;
		otherDivs += ',' + div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_comment' + iteration;
		div.innerHTML = iteration;
		otherDivs += ',' + div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_month' + iteration;
		div.innerHTML = iteration;
		otherDivs += ',' + div.id;
	 cellLeft.appendChild(div);
	 
	
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_editBonus_newRows.php',this,iteration,'#@%ampa%@#',otherDivs);
	
	document.getElementById(tblCountInputID).value++;
}

function addRowConsGlass( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_pur_glass_date' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	  var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pur_glass_company' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_pur_glass_supplier' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_pur_glass_inv_num' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
		 
	 
	
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_cons_glass_dropLists_v2.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowOrderGlass( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
	 //cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pur_order_id' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	  
	
	var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_pur_glass_date' + iteration;
		div.innerHTML = iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_pur_glass_company' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_pur_glass_supplier' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_pur_glass_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  
	 
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_pur_glass_balance' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_pur_glass_lastprice' + iteration;
		div.innerHTML = '';
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 
	 
	  var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_action' + iteration;
		div.innerHTML = '';// + iteration;
		
	 cellLeft.appendChild(div);  
	 
	
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_order_glass_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowPurchasingGlass( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_date' + iteration;
		div.innerHTML = iteration;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_supplier' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_inv_num' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_price_per_kg' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_price_per_pc' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	  var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_pur_mold_qty' + iteration;
		div.innerHTML = 'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 
	
	  	
	 
	 
		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_purch_glass_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}



function addRowDosologio( tblID, tblCountInputID, thisRowNum, loans_id )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = loans_id;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_dos_increament' + iteration;
		div.innerHTML = '';//iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_dos_capital' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_dos_interest' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_dos_date' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_dosologio_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowDosologioAdd( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_dos_increament' + iteration;
		div.innerHTML = '';//iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_dos_capital' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_dos_interest' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_dos_date' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../live_search/get_dosologio_dropListsAdd.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowAccountingBudget( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_budget_company' + iteration;
		div.innerHTML = '';//iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_budget_year' + iteration;
		div.innerHTML = '';//iteration + 1;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_budget_scenario' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_budget_sc_amount' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_budget_calc' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_budget_amount_pc' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_budget_distrib' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_budget_wayofDstr' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_accounting_budget_rows_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowAddCashReceivables ( tblID, tblCountInputID, thisRowNum, field )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_receivables_amount' + iteration;
		div.innerHTML = iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_receivables_credit_days' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_receivables_week' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_receivables_action' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplitFiled('../../../live_search/get_addCashReceivables_rows_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs, field); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowAddCashReceivablesOrders ( tblID, tblCountInputID, thisRowNum, field )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_receivables_amount' + iteration;
		div.innerHTML = iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_receivables_credit_days' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_receivables_week' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_receivables_paid' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_receivables_paid_date' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_receivables_action' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplitFiled('../../../live_search/get_addCashReceivablesOrders_rows_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs, field); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowAddPaymentCapital( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_add_paymcap_amount' + iteration;
		div.innerHTML = iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_add_paymcap_date' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_add_paymcap_type' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_addPaymentCapital_rows_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowAddCashPaymentExpenses ( tblID, tblCountInputID, thisRowNum, field )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_receivables_amount' + iteration;
		div.innerHTML = iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_receivables_credit_days' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_receivables_week' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_receivables_paid' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_receivables_payment_date' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_receivables_action' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplitFiled('../../../live_search/get_addCashPaymentExpenses_rows_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs,field); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowAddCashPaymentLoans ( tblID, tblCountInputID, thisRowNum, field )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_receivables_amount' + iteration;
		div.innerHTML = iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_receivables_credit_days' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_receivables_week' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_receivables_paid' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_receivables_payment_date' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_receivables_action' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplitFiled('../../../live_search/get_addCashPaymentLoans_rows_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs, field); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowAddCashPaymentCheque ( tblID, tblCountInputID, thisRowNum, field )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_receivables_amount' + iteration;
		div.innerHTML = iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_receivables_credit_days' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_receivables_week' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_receivables_paid' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_receivables_payment_date' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_receivables_action' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplitFiled('../../../live_search/get_addCashPaymentCheque_rows_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs,field); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowAddCashPaymentOtherExpensesBudget ( tblID, tblCountInputID, thisRowNum, field )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_receivables_amount' + iteration;
		div.innerHTML = iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_receivables_credit_days' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_receivables_week' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_receivables_paid' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_receivables_payment_date' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_receivables_action' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplitFiled('../../../live_search/get_addCashPaymentOtherExpBudget_rows_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs,field); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowAddCashPaymentOtherExpensesBudget_V2 ( tblID, tblCountInputID, thisRowNum, field )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_receivables_amount' + iteration;
		div.innerHTML = iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_receivables_credit_days' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_receivables_week' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_receivables_paid' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	 
	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplitFiled('../../../live_search/get_addCashPaymentOtherExpBudget_rows_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs,field); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowAddCashReceivablesUnderDisc ( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_receivables_amount' + iteration;
		div.innerHTML = iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_receivables_credit_days' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_receivables_week' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_receivables_paid' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_receivables_action' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_addCashReceivablesUnderDisc_rows_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowAddCashReceivablesProjectList ( tblID, tblCountInputID, thisRowNum, field )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_receivables_amount' + iteration;
		div.innerHTML = iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_receivables_credit_days' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_receivables_week' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_receivables_paid' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_receivables_action' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplitFiled('../../../live_search/get_addCashReceivablesProjectList_rows_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs,field); 

		
	document.getElementById(tblCountInputID).value++;
	
}

function addRowAddTransExpenses ( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_details_trans_date' + iteration;
		div.innerHTML = iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_details_trans_type' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_details_trans_rec_no' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_details_trans_desc' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_details_trans_currency' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_details_trans_amount' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_details_trans_rate' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(7);
		var div = document.createElement('div');
		div.id = 'div_details_trans_euro' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		//otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	  var cellLeft = row.insertCell(8);
		var div = document.createElement('div');
		div.id = 'div_details_trans_payment' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_addTravelExpenses_rows_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 
	 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowAddTransCashiers ( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length - 1;
    var iteration = document.getElementById(tblCountInputID).value;
	if( parseInt( thisRowNum ) < parseInt( iteration ) )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	
	var otherDivs = "";
	var koma = ",";
	
	var row = tbl.insertRow(lastRow);		
	
		
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_details_trans_cash_currency' + iteration;
		div.innerHTML = iteration + 1;
		otherDivs = div.id;
	 cellLeft.appendChild(div); 
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_details_trans_cash_down' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_details_trans_cash_return' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);  	
	 cellLeft.align = 'center';
	 
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_details_trans_cash_exrate' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_details_trans_cash_euro' + iteration;
		div.innerHTML = '';//'ampa' + iteration;
		otherDivs += koma + div.id;
	 cellLeft.appendChild(div);
	 cellLeft.align = 'center';
	 
	 
	 
	
	  	
		
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/get_addTravelCashier_rows_dropLists.php',droplist,iteration,'#@%ampa%@#',otherDivs); 
	 

		
	document.getElementById(tblCountInputID).value++;
	
}


function addRowGlassToNewSupplier( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow-1);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_supText' + iteration;
		div.innerHTML = 'Supplier:';
		//otherDivs = div.id;
		cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_supplier' + iteration;
		div.innerHTML = 'ampa' + iteration; 
		otherDivs =  div.id;
		
	 cellLeft.appendChild(div);
	 
	
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'v' + iteration;
		div.innerHTML = ''; 
		//otherDivs += ','+ div.id;
		
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'b' + iteration;
		div.innerHTML = ''; 
		//otherDivs += ','+ div.id;
		
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'a' + iteration;
		//div.innerHTML = div.id; 
		//otherDivs += ','+ div.id;
		
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = '' + iteration;
		div.innerHTML = ''; 
		//otherDivs += ','+ div.id;
		
	 cellLeft.appendChild(div);
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../cp_v3/live_search/getGlassSupplier_dropLists.php',this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}

function denyChangeToCheckBox(_checkbox)
{
	if( _checkbox.checked != true ){
       _checkbox.checked = true;
    }else if( _checkbox.checked != false ){
       _checkbox.checked = false;
    }
}

function addRowMachinessDptm( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow-1);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_layer_dptm' + iteration;
		div.innerHTML = 'Deparment' + ( iteration + 1 ) + ':';
		//otherDivs = div.id;
		cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_dptm' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
		cellLeft.appendChild(div);
	 
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../live_search/getDptm_newRow.php',this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}

function addRowMachinessCompany( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_layer_company' + iteration;
		div.innerHTML = 'Company' + ( iteration + 1 ) + ':';
		//otherDivs = div.id;
		cellLeft.appendChild(div); 
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_company' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
		cellLeft.appendChild(div);
	 
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/machines_newCompany.php',this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}


function addRowMachinessDptmEdit( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	
	 
	 var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_dptm' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
		cellLeft.appendChild(div);
	 
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getDptmEdit_newRow.php',this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}



function addRowMachinessMaintenance( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	
	 
	 var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_maint_dptm' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
		cellLeft.appendChild(div);
	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_maint_code' + iteration;
		div.innerHTML = '';
		otherDivs += ',' + div.id;
		cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_maint_desc' + iteration;
		div.innerHTML = '';
		otherDivs += ',' + div.id;
		cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_maint_freq' + iteration;
		div.innerHTML = '';
		otherDivs += ',' + div.id;
		cellLeft.appendChild(div);
	 
	
	var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_maint_instruc' + iteration;
		div.innerHTML = '';
		otherDivs += ',' + div.id;
		cellLeft.appendChild(div);
	
	var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_maint_time' + iteration;
		div.innerHTML = '';
		otherDivs += ',' + div.id;
		cellLeft.appendChild(div);
	
		
	var cellLeft = row.insertCell(6);
		var div = document.createElement('div');
		div.id = 'div_maint_upload' + iteration;
		div.innerHTML = 'aaa';
		otherDivs += ',' + div.id;
		cellLeft.appendChild(div);	
		
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getMaintenance_newRow.php',this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}

function save_maintenance(url,obj,link_id,div_id,comments)
{
	url += '?link_id=' + link_id;
	url += '\&comments=' + comments;
	//alert(url);
	
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			if( res == 1 )
			{
				window.opener.document.getElementById(div_id).innerHTML = 'Done';
				obj.style.borderColor = 'green';
				obj.style.borderWidth = '2px';
				obj.style.backgroundColor = '#ffffff';
				obj.style.color = 'green';
				window.close();
			}
			else
				alert(res);
			//alert(obj.style.borderColor);
      	}
		
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function checkTimeFormat(obj)
{
	var time = new Array();
	
	if( obj.value.indexOf(":") > 0 ){
		time = obj.value.split(':');
	}else{
		time[0] = obj.value;
		
		//alert( time[0] );
	}
	
	var time_str = "00:00";
	if( time[0].length < 2 )
	{
		if( time[0] < 10 )
			time_str = "0" + time[0] + ":"; //"0:00";
		else
			time_str = time[0] + ":"; //"0:00";
			
		obj.value = time_str;
	}
	else if( time[0].length <= 2 )
	{
		time_str = time[0] + ":";//":00";
		
		obj.value = time_str;
	}
	
	//Min
	if( time[1].length < 2 )
	{
		if( time[1] >= 6 ) time[1] = 5;
		
		time_str = time[0] + ":" + time[1];// + "0";
		obj.value = time_str;
	}
	else if( time[1].length <= 2 )
	{
		if( time[1] >= 60 ) time[1] = 59;
		
		time_str = time[0] + ":" + time[1];
		obj.value = time_str;
	}
	
	
	
	//alert(time[0] + ' : ' + time[1] );
}


function saveArchetypeReceive(url,obj,link_id,div_id)
{
	url += '?link_id=' + link_id;
	//alert(url);
	
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(div_id).innerHTML = res;
		}
		
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function addRowReceiveArchetype( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	
	 
	 var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_order_date' + iteration;
		div.innerHTML = '';
		otherDivs = div.id;
		cellLeft.appendChild(div);
	
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_order_company' + iteration;
		div.innerHTML = '';
		otherDivs += ',' + div.id;
		cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_order_supplier' + iteration;
		div.innerHTML = '';
		otherDivs += ',' + div.id;
		cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_order_action' + iteration;
		div.innerHTML = '';
		//otherDivs += ',' + div.id;
		cellLeft.appendChild(div);
	 
	
		
	getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getArchetypeReceive_newRow.php',this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}


function addRowDayCashAvailability( tblID, tblCountInputID, thisRowNum, url )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	
	 
	 var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_daycash_valeur_value' + iteration;
		div.innerHTML = '';
		div.style.textAlign = 'center';
		otherDivs = div.id;
		cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_daycash_date' + iteration;
		div.innerHTML = '';
		div.style.textAlign = 'center';
		otherDivs += ',' + div.id;
		cellLeft.appendChild(div);
	 
	
		
	getDescriptionInnerHTMLSomeDivWithCountSplit(url,this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}

function includeExcludeShapeToMold(url,obj,mold_id,shape_id,divID)
{
	var action = '';
	if( obj.checked == true )
	{
		action = 'add';
	}
	else
	{
		action = 'delete';
	}
	
	url += '?mold_id=' + mold_id;
	url += '\&shape_id=' + shape_id;
	url += '\&action=' + action;
	//alert(url);
	
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
		}
		
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function saveWeekCm2(url,obj,order_no,calendar_id,cm2,company_id)
{
	url += '?order_no='+order_no;
	url += '\&calendar_id='+calendar_id;
	url += '\&cm2='+cm2;
	url += '\&company_id='+company_id;
	
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			if( res == 1 )
			{
				obj.style.borderColor = 'green';
				obj.style.borderWidth = '2px';
				obj.style.backgroundColor = 'green';
				obj.style.color = '#ffffff';
			}
			else
				alert(res);
			
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}

function reloadWeekCM2DropList(url,obj,Count,order_no,cm2,company,divID)
{
	url += '?order_no='+order_no;
	url += '\&cm2='+cm2;
	url += '\&company_id='+company;
	url += '\&Count=' + Count;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
			
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function deliveryDateBooked(url,qty,orders_id,order_no,code,company,typosDialogis,divID )
{
	url += '?qty='+qty;
	url += '\&orders_id='+orders_id;
	url += '\&order_no='+order_no;
	url += '\&code=' + code;
	url += '\&company=' + company;
	url += '\&typosDialogis=' + typosDialogis;
	url += '\&divID=' + divID;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
			
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function deliveryDateUnBooked(url,booked_items_id,divID)
{
	url += '?booked_items_id='+booked_items_id;
	url += '\&divID=' + divID;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
			
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function saveDeliveryReady(url,orders_no,link_id,DeliveryReadyStatus,dviID)
{
	url += '?orders_no='+orders_no;
	url += '\&link_id=' + link_id;
	url += '\&DeliveryReadyStatus=' + DeliveryReadyStatus;
	url += '\&dviID=' + dviID;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(dviID).innerHTML = res;
			
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}


function addToWarehouse(url,order_id,order_no,order_type,itemCode,warehouse_qty,booked_item_id,divID)
{
	url += '?order_id='+order_id;
	url += '\&order_no=' + order_no;
	url += '\&order_type=' + order_type;
	url += '\&itemCode=' + itemCode;
	url += '\&warehouse_qty=' + warehouse_qty;
	url += '\&booked_item_id=' + booked_item_id;
	url += '\&divID=' + divID;
	
	//alert(url);
	
	var xmlHttp = getxmlHttp();
	xmlHttp.onreadystatechange=function()
    {
   	 	if(xmlHttp.readyState==4)
      	{
			var res = xmlHttp.responseText;
			//alert(res);
			document.getElementById(divID).innerHTML = res;
			
      	}
		else
		{
			//document.body.style.cursor = 'wait';
			//document.getElementById('loading').innerHTML = textLoadingF;
		}
    }
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);
}

function addRowMachineReplacementPart( tblID, tblCountInputID, thisRowNum, url )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var row = tbl.insertRow(lastRow);		
	
	
	 
	 var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_mach_replacement_desc' + iteration;
		div.innerHTML = '';
		div.style.textAlign = 'center';
		otherDivs = div.id;
		cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_mach_replacement_supplier' + iteration;
		div.innerHTML = '';
		div.style.textAlign = 'center';
		otherDivs += ',' + div.id;
		cellLeft.appendChild(div);
	
	var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_mach_replacement_price' + iteration;
		div.innerHTML = '';
		div.style.textAlign = 'center';
		otherDivs += ',' + div.id;
		cellLeft.appendChild(div);
	
	
	var cellLeft = row.insertCell(3);
		var div = document.createElement('div');
		div.id = 'div_mach_replacement_desired_qty' + iteration;
		div.innerHTML = '';
		div.style.textAlign = 'center';
		otherDivs += ',' + div.id;
		cellLeft.appendChild(div);
	 
	var cellLeft = row.insertCell(4);
		var div = document.createElement('div');
		div.id = 'div_mach_replacement_photo' + iteration;
		div.innerHTML = '';
		div.style.textAlign = 'center';
		otherDivs += ',' + div.id;
		cellLeft.appendChild(div);
	
	var cellLeft = row.insertCell(5);
		var div = document.createElement('div');
		div.id = 'div_mach_replacement_delete' + iteration;
		div.innerHTML = '';
		div.style.textAlign = 'center';
		//otherDivs += ',' + div.id;
		cellLeft.appendChild(div);
	
		
	getDescriptionInnerHTMLSomeDivWithCountSplit(url,this,iteration,'#theMySpliter#',otherDivs)
	
	document.getElementById(tblCountInputID).value++;
}



function addRowShopPhotos( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var divKeywords = "";
	var row = tbl.insertRow(lastRow-2);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_ph_text' + iteration;
		div.innerHTML = 'Photo' + (iteration + 1);
		//otherDivs = div.id;
	 cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_ph_photo' + iteration;
		//div.innerHTML = iteration;
		otherDivs = div.id;
		//divKeywords = div.id;
	 cellLeft.appendChild(div); 
	 
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('shop_drop_photo.php',this,iteration,'#@%ampa%@#',otherDivs);
	
	document.getElementById(tblCountInputID).value++;
}



function addRowProductPhotos( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var divKeywords = "";
	var row = tbl.insertRow(lastRow - 2);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_ph_text' + iteration;
		div.innerHTML = 'Φωτογταφία' + (iteration + 1)+'η';
		//otherDivs = div.id;
	 cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_ph_photo' + iteration;
		//div.innerHTML = iteration;
		otherDivs = div.id;
		//divKeywords = div.id;
	 cellLeft.appendChild(div); 
	 
	 
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('product_drop_photo.php',this,iteration,'#@%ampa%@#',otherDivs);
	
	document.getElementById(tblCountInputID).value++;
}

function addRowMeletesPhotos( tblID, tblCountInputID, thisRowNum )
{
	//alert(tblCountInputID);
	var tbl = document.getElementById(tblID);
	var lastRow = tbl.rows.length;
    var iteration = document.getElementById(tblCountInputID).value;
	if( thisRowNum < iteration )
	{
		//alert(thisRowNum+' < '+ iteration);
		return;
	}
	iteration++;
	
	var droplist = document.createElement('select');	//Mhn se apasxolei apla min to sbiseis oute na allakseis kati. Asto etsi
	droplist.value = 0;
	var koma = ",";
	
	var otherDivs = "";
	var divKeywords = "";
	var row = tbl.insertRow(lastRow-2);		
	
	var cellLeft = row.insertCell(0);
		var div = document.createElement('div');
		div.id = 'div_ph_text' + iteration;
		div.innerHTML = 'Photo' + (iteration + 1) + ':';
		//otherDivs = div.id;
	 cellLeft.appendChild(div); 
	
	var cellLeft = row.insertCell(1);
		var div = document.createElement('div');
		div.id = 'div_ph_photo' + iteration;
		//div.innerHTML = iteration;
		otherDivs = div.id;
		//divKeywords = div.id;
	 cellLeft.appendChild(div);
	 
	 var cellLeft = row.insertCell(2);
		var div = document.createElement('div');
		div.id = 'div_ph_stadia' + iteration;
		//div.innerHTML = iteration;
		otherDivs += ',' + div.id;
		//divKeywords = div.id;
	 cellLeft.appendChild(div);
	 
	 getDescriptionInnerHTMLSomeDivWithCountSplit('meleti_drop_photo.php',this,iteration,'#@%ampa%@#',otherDivs);
	
	document.getElementById(tblCountInputID).value++;
}

function submit(frm)
{
	alert('aasds');
	var name = forms['frmRegistry'].name.value;
	
	alert(name);
}