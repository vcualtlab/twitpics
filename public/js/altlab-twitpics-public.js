(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */

	$( window ).load(function() {
		$('.altlabtwitpic-masonry').masonry({
		  // set itemSelector so .grid-sizer is not used in layout
		  itemSelector: '.altlabtwitpic-brick',
		  // use element for option
		  columnWidth: '.altlabtwitpic-grid-sizer',
		  percentPosition: true
		});

		// remove the attrs here - width height and scale - this is added in by some themes - we don't want them
		// $('.altlabtwitpic-brick img').removeAttr( "height" ).removeAttr( "width" ).removeAttr( "scale" );
		
		// $(".altlabtwitpic-brick img.lazy").lazyload();
		$(".altlabtwitpic-brick img.lazy").lazyload({
	        effect : "fadeIn",
	        load : adjustHeights
    	});

		function adjustHeights() {

		    var columnheight1 = 10;
		    var columnheight2 = 10;

		    jQuery('.altlabtwitpic-brick img').each(function(){
		        //if product in left column
		        itemheight = jQuery(this).height();
		        if(jQuery(this).css('left') == '0px'){
		            jQuery(this).css('top', columnheight1 + 'px');
		            columnheight1 += itemheight + 30;
		        }else{
		        //if in right column
		            jQuery(this).css('top', columnheight2 + 'px');
		            columnheight2 += itemheight + 30;
		        }

		    });

		    //don't forget to set post-container to the highest height
		    if(Math.max(columnheight1, columnheight2) >0){
		        jQuery('.altlabtwitpic-brick img').css('height', Math.max(columnheight1, columnheight2) + 'px');
		    }
		}

// maybe this https://bountify.co/small-fix-for-isotope-masonry-and-lazy-load


	});

})( jQuery );