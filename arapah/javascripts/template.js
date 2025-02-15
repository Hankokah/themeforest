jQuery.noConflict();

jQuery(document).ready(function($){	
	$(".carousel-posts").jCarouselLite({
       		scroll: 1,
			auto: 8000,
			btnNext: ".CarNext",
			btnPrev: ".CarPrev"
   		});	
	
	function portfolio_quicksand() {
		
		// Setting Up Our Variables
		var $filter;
		var $container;
		var $containerClone;
		var $filterLink;
		var $filteredItems
		
		// Set Our Filter
		$filter = $('.filter li.active a').attr('class');
		
		// Set Our Filter Link
		$filterLink = $('.filter li a');
		
		// Set Our Container
		$container = $('ul.filterable-grid');
		
		// Clone Our Container
		$containerClone = $container.clone();
		
		// Apply our Quicksand to work on a click function
		// for each for the filter li link elements
		$filterLink.click(function(e) 
		{
			// Remove the active class
			$('.filter li').removeClass('active');
			
			// Split each of the filter elements and override our filter
			$filter = $(this).attr('class').split(' ');
			
			// Apply the 'active' class to the clicked link
			$(this).parent().addClass('active');
			
			// If 'all' is selected, display all elements
			// else output all items referenced to the data-type
			if ($filter == 'all') {
				$filteredItems = $containerClone.find('li'); 
			}
			else {
				$filteredItems = $containerClone.find('li[data-type~=' + $filter + ']'); 
			}
			
			// Finally call the Quicksand function
			$container.quicksand($filteredItems, 
			{
				// The Duration for animation
				duration: 750,
				// the easing effect when animation
				easing: 'easeInOutCirc',
				// height adjustment becomes dynamic
				adjustHeight: 'dynamic' 
			});
			
			//Initalize our PrettyPhoto Script When Filtered
			$container.quicksand($filteredItems, 
				function () { lightbox(); }
			);			
		});
	}
		
	if(jQuery().quicksand) {
		portfolio_quicksand();	
	}
		
	function lightbox() {
		// Apply PrettyPhoto to find the relation with our portfolio item
		$("a[rel^='prettyPhoto']").prettyPhoto({
			// Parameters for PrettyPhoto styling
			animationSpeed:'fast',
			slideshow:5000,
			theme:'pp_default',
			show_title:false,
			overlay_gallery: false,
			social_tools: false
		});
	}
	
	if(jQuery().prettyPhoto) {
		lightbox();
	}
		
	if(jQuery().quicksand) {
		portfolio_quicksand();	
	}
		
	 // add class to anchor eg. .post a
	 $('.carousel-post a, .portfolio a').has('img').addClass('prettyPhoto');
	 $("a[class^='prettyPhoto']").prettyPhoto();
	 $('.carousel-post a, .portfolio a').has('img').attr('rel', '[gallery]'); //make sure gallery is wrapped in square brackets

	// add title from anchor to image description, add gallery for multiple images

	 $('.carousel-post a, .portfolio a').click(function () {
	 var desc = $(this).attr('title');
	 $('.carousel-post a, .portfolio a').has('img').attr('title', desc, 'rel', '[gallery]' ); //make sure gallery is wrapped&nbsp;&nbsp;square brackets

	}); 
	
	// Main Slider Arapah
	$("#arapah-slider").tabs({fx:{opacity: "toggle", duration: "fast"}}).tabs("rotate", 5000, true);
		$("#arapah-slider").hover(
			function() {
				$("#arapah-slider").tabs("rotate",0,true);
			},
			function() {
				$("#arapah-slider").tabs("rotate",5000,true);
			}
		);	
});
