<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?=$myClass->getSomeDesc("Τίτλος Ιστοσελίδας","config","config_value","config_title AND confug_lang_id = '".$DEFAULT_LANGUAGE."' ")?></title>
 
   
    <meta name="keywords" content="<?=$myClass->getSomeDesc("Λέξεις Κλειδιά","config","config_value","config_title AND confug_lang_id = '".$DEFAULT_LANGUAGE."' ")?>" />
 	<meta name="description" content="<?=$myClass->getSomeDesc("META DESCRIPTION","config","config_value","config_title AND confug_lang_id = '".$DEFAULT_LANGUAGE."' ")?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <!-- CSS -->
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<link rel="stylesheet" href="css/galleriffic-2.css" type="text/css" />
	
	 <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<link rel="icon" type="image/x-icon" href="favicon.ico" />
	
	<!-- JAVASCRIPT -->
	<script type="text/javascript" src="<?=SITE_URL?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?=SITE_URL?>/js/verticalscroller.js"></script>
	<script type="text/javascript" src="<?=SITE_URL?>/js/jquery.galleriffic.js"></script>
	<script type="text/javascript" src="<?=SITE_URL?>/js/jquery.opacityrollover.js"></script>
	<script type="text/javascript" src="<?=SITE_URL?>/js/contact_form.js"></script>
    <script type="text/javascript" src="<?=SITE_URL?>/js/registry_form.js"></script>
    
    <script type="text/javascript" src="<?=SITE_URL?>/classes/function.js"></script>
    <script type="text/javascript" src="<?=SITE_URL?>/classes/function_no2.js"></script>
	
	<!-- We only want the thunbnails to display when javascript is disabled -->
<script type="text/javascript" src="<?=SITE_URL?>/js/noscript.js"></script>
<script src="<?=SITE_URL?>/scripts/jquery.js" type="text/javascript"></script>
<script src="<?=SITE_URL?>/scripts/lightbox.js" type="text/javascript"></script>

<script type="text/javascript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
    </script>
<link href="<?=SITE_URL?>/css/lightbox.css" rel="stylesheet" type="text/css" />
<link href="<?=SITE_URL?>/css/sample_lightbox_layout.css" rel="stylesheet" type="text/css" />
<style type="text/css">
/* BeginOAWidget_Instance_2127022: #gallery */

		.lbGallery {
	padding-left: 20px;
	padding-top: 20px;
	padding-right: 20px;
	padding-bottom: 20px;
	width: 540px;
	height: auto;
	text-align:left;
	background-color: #FFF;
		}
		.lbGallery ul { list-style: none; margin:0;padding:0; }
		.lbGallery ul li { display: inline;margin:0;padding:0; }
		.lbGallery ul li a{text-decoration:none;}
			
		.lbGallery ul li a img {
			/*border color, width and margin for the images*/
			border-color: #3e3e3e;
			border-left-width: 10px;
			border-top-width: 10px;
			border-right-width: 10px;
			border-bottom-width: 20px;
			margin-left:5px;
			margin-right:5px;
			margin-top:5px;
			margin-bottom:5px:
			}
			
		.lbGallery ul li a:hover img {	
			/*background color on hover*/
			border-color: #ffffff;
			border-left-width: 10px;
			border-top-width: 10px;
			border-right-width: 10px;
			border-bottom-width: 20px;
		}
			
		#lightbox-container-image-box {
			border-top: 0px none #ffffff;
			border-right: 0px none #ffffff;
			border-bottom: 0px none #ffffff;
			border-left: 0px none #ffffff;
			}
			
		#lightbox-container-image-data-box { 
			border-top: 0px;
			border-right: 0px none #ffffff;
			border-bottom: 0px none #ffffff;
			border-left: 0px none #ffffff;
			}
/* EndOAWidget_Instance_2127022 */
</style>