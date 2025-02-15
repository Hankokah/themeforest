/**
 * AQPB Fields JS
 *
 * JS functionalities for some of the default fields
 */

jQuery.noConflict();

/** Fire up jQuery - let's dance! 
 */
jQuery(document).ready(function($){

	/** Colorpicker Field
	----------------------------------------------- */
	function tdpb_colorpicker() {
		$('#page-builder .input-color-picker').each(function(){
			var $this	= $(this),
				parent	= $this.parent();
				
			$this.wpColorPicker();
		});
	}
	
	tdpb_colorpicker();
	
	$('ul.blocks').bind('sortstop', function() {
		tdpb_colorpicker();
	});
	
	/** Media Uploader
	----------------------------------------------- */	
	$(document).on('click', '.td_upload_button', function(event) {
		var $clicked = $(this), frame,
			input_id = $clicked.prev().attr('id'),
			media_type = $clicked.attr('rel');
			
		event.preventDefault();
		
		// If the media frame already exists, reopen it.
		if ( frame ) {
			frame.open();
			return;
		}
		
		// Create the media frame.
		frame = wp.media.frames.td_media_uploader = wp.media({
			// Set the media type
			library: {
				type: media_type
			},
			view: {
				
			}
		});
		
		// When an image is selected, run a callback.
		frame.on( 'select', function() {
			// Grab the selected attachment.
			var attachment = frame.state().get('selection').first();
			
			$('#' + input_id).val(attachment.attributes.url);
			
			if(media_type == 'image') $('#' + input_id).parent().parent().parent().find('.screenshot img').attr('src', attachment.attributes.url);
			
		});

		frame.open();
	
	});
			
	/** Sortable Lists
	----------------------------------------------- */
	// AJAX Add New <list-item>
	function td_sortable_list_add_item(action_id, items) {
		
		var blockID = items.attr('rel'),
			numArr = items.find('li').map(function(i, e){
				return $(e).attr("rel");
			});
		
		var maxNum = Math.max.apply(Math, numArr);
		if (maxNum < 1 ) { maxNum = 0};
		var newNum = maxNum + 1;
		
		var data = {
			action: 'td_block_'+action_id+'_add_new',
			security: $('#tdpb-nonce').val(),
			count: newNum,
			block_id: blockID
		};
		
		$.post(ajaxurl, data, function(response) {
			var check = response.charAt(response.length - 1);
			
			//check nonce
			if(check == '-1') {
				alert('An unknown error has occurred');
			} else {
				items.append(response);
			}
						
		});
	};
	
	// Initialise sortable list fields
	function td_sortable_list_init() {
		$('.td-sortable-list').sortable({
			containment: "parent",
			placeholder: "ui-state-highlight"
		});
	}
	td_sortable_list_init();
	
	$('ul.blocks').bind('sortstop', function() {
		td_sortable_list_init();
	});
	
	
	$(document).on('click', 'a.td-sortable-add-new', function() {
		var action_id = $(this).attr('rel'),
			items = $(this).parent().children('ul.td-sortable-list');
			
		td_sortable_list_add_item(action_id, items);
		td_sortable_list_init
		return false;
	});
	
	// Delete Sortable Item
	$(document).on('click', '.td-sortable-list a.sortable-delete', function() {
		var $parent = $(this.parentNode.parentNode.parentNode);
		$parent.children('.block-tabs-tab-head').css('background', 'red');
		$parent.slideUp(function() {
			$(this).remove();
		}).fadeOut('fast');
		return false;
	});
	
	// Open/Close Sortable Item
	$(document).on('click', '.td-sortable-list .sortable-handle a', function() {
		var $clicked = $(this);
		
		$clicked.addClass('sortable-clicked');
		
		$clicked.parents('.td-sortable-list').find('.sortable-body').each(function(i, el) {
			if($(el).is(':visible') && $(el).prev().find('a').hasClass('sortable-clicked') == false) {
				$(el).slideUp();
			}
		});
		$(this.parentNode.parentNode.parentNode).children('.sortable-body').slideToggle();
		
		$clicked.removeClass('sortable-clicked');
		
		return false;
	});
	
});