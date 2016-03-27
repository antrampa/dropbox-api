<?php

	include("hinit.php");
	
	include("meta-header.php");
	
?>

<script type="text/xml">
<!--
<oa:widgets>
  <oa:widget wid="2127022" binding="#gallery" />
</oa:widgets>
-->
</script>

</head>
<body onLoad="MM_preloadImages('buttons ellion/ellion_2.png','buttons ellion/products_2.png','buttons ellion/orders_2.png','buttons ellion/olive-oil-_2.png','buttons ellion/history_2.png','buttons ellion/news_2.png','buttons ellion/contacts_2.png','buttons ellion/gr_2.png','buttons ellion/en_2.png','buttons ellion/de_2.png','buttons ellion/ru_2.png','buttons ellion/no_2.png','buttons ellion/g+_2.png','buttons ellion/f_2.png','buttons ellion/t_2.png','buttons ellion/message_2.png','buttons ellion/r_2.png')">
	<!-- CONTAINER -->
	<div class="container">
		
		<!-- LOGO + NAV  -->
        
        	<?php include("header.php"); ?>
        
		<div class="TopNavigation">
		  	
            <?php include("navigator.php") ?>		

        <p>&nbsp;</p>

<div id="gallery2" class="lbGallery1" style="height:500px;">
        <?php 
			//include("loginlinks.php");
		?>
        
        <h2><?=NEWS?></h2>
        <?php include("gadgets.php") ?>
        

</div>        
        <!-- <p> News / Events of Ellion Olive Oil</p> -->
        
        <div id="gallery" class="lbGallery">
          <ul>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
          </ul>
<?php

$sql = "SELECT N.*
		
		FROM news N 
		
				
		WHERE news_active = '1'
		
		
		ORDER BY news_sort, news_entry_date DESC
		
		";

$res = $myClass->excQuery($sql);


for( $i=0;$i<count($res);$i++ ):

?>
          <p>
          
              <div style="width:490px;">
              
              		
                    
              <?php if( strlen($res[$i]['news_image']) > 0 && file_exists("olive-oil-images/news/".$res[$i]['news_image'] ) === true ): ?>
              		
                    <div style="float:left; width:100px;">
                    
                    	<img src="olive-oil-images/news/<?=$res[$i]['news_image']?>" width="100" vspace="10" align="top"  />
                    
                    </div>
              
              <?php endif; ?>
	              	
                    
                    <div style="float:right; width:300px; margin-right:80px;">
              			
                       <a href="news-more.php?id=<?=$res[$i]['news_id']?>&title=<?=$res[$i]['news_title']?>&desc=<?=$res[$i]['news_short_text']?>" ><?=date('D, d M y',strtotime($res[$i]['news_entry_date']))?>
                       :: 
                      <?=$res[$i]['news_title']?></a>
                      
	                      <br />
                        
                        <p> <?=$res[$i]['news_short_text']?></p>  
              
              		</div>
              
               </div>
          
          </p>
          
          <p>
         		<br />&nbsp;<br />
          </p>
          
         

<?php

endfor;

?>
          
          
          <ul>
            <li></li>
          </ul>
        
        </div>
        
<p>&nbsp;</p>
    
        <div id="thumbs2" class="navigation">         
              
             
                <div style="clear: both; top:60%; position:absolute"></div>
          </div>
            </fieldset>
          </form>
        </div>
<p>&nbsp;</p>


<?php include("socials_news.php") ?>

</div>
</div>
		<!-- END LOGO + NAV  -->
		
		<!-- SLIDER -->
		<h2>&nbsp;</h2>
		<div id="thumbs" class="navigation">
		  <form id="ajax-contact-form" action="javascript:alert('success!');">
		  <fieldset class="info_fieldset">
</fieldset>
	      </form>
</div>
			<!-- END THUMB -->
	
			<div style="clear: both;"></div>
			
      
      
<script type="text/javascript" src="http://www.yourinspirationweb.com/WhiteFolio/swfobject.js"></script>
<script type="text/javascript">
			var s1 = new SWFObject("http://www.yourinspirationweb.com/WhiteFolio/imagerotator.swf","rotator","940","368","7");
			s1.addVariable("file","http://www.yourinspirationweb.com/WhiteFolio/madrid.xml");
			s1.addVariable("width","940");
			s1.addVariable("height","368");
			s1.addVariable("transition","blocks");
			s1.addVariable("shownavigation","false");
			s1.addParam("wmode","opaque");
			s1.write("slider");
		</script>
          <br/>
          <!-- END SLIDER -->
          
          <!-- ABOUT  -->
      </p>
      <div id="about">
			<!-- LOGO + NAV  -->
			<!-- END LOGO + NAV  -->
			
			<!-- START CONTAINER ABOUT -->
	  <div id="containerAbout">

				<!-- DESCRIPTION -->
				<!-- END DESCRIPTION -->
				
				<!-- SHORT NEWS FROM TWITTER -->
				<!-- END SHORT NEWS FROM TWITTER -->
  </div>
			<!-- END CONTAINER ABOUT -->
				
			<!-- SKILLS -->
			<!-- END SKILLS -->
</div>
		<!-- END ABOUT  -->

		<!-- PORTFOLIO  -->
		<!-- END PORTFOLIO GALLERY -->
	
		<!-- CONTACT  -->
		<!-- END CONTACT  -->
	
		<!-- FOOTER  -->
	  	<?php include("footer.php") ?>
		<!-- END FOOTER -->
		
	</div>
	<!-- END CONTAINER -->

						
<script type="text/javascript">
jQuery(document).ready(function($) {
	// We only want these styles applied when javascript is enabled
	$('div.navigation').css({'width' : '300px', 'float' : 'left'});
	$('div.content').css('display', 'block');

	// Initially set opacity on thumbs and add
	// additional styling for hover effect on thumbs
	var onMouseOutOpacity = 0.67;
	$('#thumbs ul.thumbs li').opacityrollover({
		mouseOutOpacity:   onMouseOutOpacity,
		mouseOverOpacity:  1.0,
		fadeSpeed:         'fast',
		exemptionSelector: '.selected'
	});
	
	// Initialize Advanced Galleriffic Gallery
	var gallery = $('#thumbs').galleriffic({
		delay:                     2500,
		numThumbs:                 15,
		preloadAhead:              10,
		enableTopPager:            true,
		enableBottomPager:         true,
		maxPagesToShow:            7,
		imageContainerSel:         '#slideshow',
		controlsContainerSel:      '#controls',
		captionContainerSel:       '#caption',
		loadingContainerSel:       '#loading',
		renderSSControls:          true,
		renderNavControls:         true,
		playLinkText:              'Play Slideshow',
		pauseLinkText:             'Pause Slideshow',
		prevLinkText:              '&lsaquo; Previous Photo',
		nextLinkText:              'Next Photo &rsaquo;',
		nextPageLinkText:          'Next &rsaquo;',
		prevPageLinkText:          '&lsaquo; Prev',
		enableHistory:             false,
		autoStart:                 false,
		syncTransitions:           true,
		enableKeyboardNavigation:  false,
		defaultTransitionDuration: 900,
		onSlideChange:             function(prevIndex, nextIndex) {
			// 'this' refers to the gallery, which is an extension of $('#thumbs')
			this.find('ul.thumbs').children()
				.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
				.eq(nextIndex).fadeTo('fast', 1.0);
		},
		onPageTransitionOut:       function(callback) {
			this.fadeTo('fast', 0.0, callback);
		},
		onPageTransitionIn:        function() {
			this.fadeTo('fast', 1.0);
		}
	});
});
</script>
	

</body>
</html>