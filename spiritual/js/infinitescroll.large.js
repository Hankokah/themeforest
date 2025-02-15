(function ($) {
	$(window).load(function() {
		var $swmContainerInfiniteScroll = $('#swm-item-entries');
		$swmContainerInfiniteScroll.infinitescroll({
			loading: {
				msg: null,
				finishedMsg : null,				
				msgText: '<div class="infiniteScroll_loader"></div>',
			},
			navSelector  : 'div.infiniteScroll_pagination',
			nextSelector : 'div.infiniteScroll_pagination div.post-next a',
			itemSelector : '.swm-infinite-item-selector',
		}, function( newElements ) {
			var $swmNewInfiniteScrollElems = $( newElements ).css({ opacity: 0 });
			$(".fitVids").fitVids();
			$swmNewInfiniteScrollElems.imagesLoaded(function() {
				$('.pfi_gallery').flexslider({
					animation: 'fade',
					animationSpeed: 500,
					slideshow: false,
					smoothHeight: false,
					controlNav: true,
					directionNav: true,
					prevText: '<i class="fa fa-chevron-left"></i>',
					nextText: '<i class="fa fa-chevron-right"></i>' 
				});
			});
			$swmNewInfiniteScrollElems.imagesLoaded(function() {
				$swmNewInfiniteScrollElems.animate({ opacity: 1 });
				$swmContainerInfiniteScroll.isotope( 'appended', $swmNewInfiniteScrollElems );							
			});
			
			
			$('.swm_container').swm_auto_lightbox();
		});
	});
})(jQuery);