/**
 *	CrunchPress Panel File
 *	---------------------------------------------------------------------
 * 	@version	1.0
 * 	@author		CrunchPress
 * 	@link		http://crunchpress.com
 * 	@copyright	Copyright (c) CrunchPress
 * 	---------------------------------------------------------------------
 * 	This file contains the jQuery script that animate the CrunchPress 
 *  panel elements.
 *	---------------------------------------------------------------------
 */

 
 jQuery(document).ready(function(){
	
	// Accordion Css
	jQuery('#panel-nav li a#parent').click(function(){
		if (jQuery(this).attr('class') != 'active'){
			jQuery('#panel-nav li ul').slideUp();
			jQuery(this).next().slideToggle();
			jQuery('#panel-nav li a').removeClass('active');
			jQuery(this).addClass('active');
		}else{
			jQuery('#panel-nav li ul').slideUp();
			jQuery(this).removeClass('active');
		}
		return false;
	});
	jQuery('#panel-nav li a#children').click(function(){
		if (jQuery(this).attr('class') != 'c-active'){
			jQuery('#panel-nav li a#children').removeClass('c-active');
			jQuery(this).addClass('c-active');
		}
		var selectedDiv = jQuery('div#panel-elements').children('#'+jQuery(this).attr('rel'));
		selectedDiv.fadeIn();
		selectedDiv.siblings().not('.panel-element-head, .panel-element-tail').hide();
		return false;
	});
	jQuery('#panel-nav ul li:first a').triggerHandler('click');
	jQuery('#panel-nav ul li:first ul li:first a').triggerHandler('click');
	// Upload Button
	jQuery("input#upload_image_text").change(function(){
		jQuery(this).siblings("input[type='hidden']").val(jQuery(this).val());
	});
	var custom_uploader;

var random_class;

jQuery('input:button.upload_image_button').click(function(e) {

e.preventDefault();

random_class=Math.floor((Math.random() * 200) + 1);

attachment_id = jQuery(this).siblings("#upload_image_attachment_id");

upload_field = jQuery(this).siblings("#upload_image_text");

upload_field.attr("class","upload_"+random_class);



        //If the uploader object has already been created, reopen the dialog

       if (custom_uploader) {

           custom_uploader.open();

           return;

       }

        //Extend the wp.media object

       custom_uploader = wp.media.frames.file_frame = wp.media({

           title: 'Select Image',

           button: {

               text: 'Select Image'

           },

           multiple: false

       });

        //When a file is selected, grab the URL and set it as the text field's value

       custom_uploader.on('select', function() {

           attachment = custom_uploader.state().get('selection').first().toJSON();

attachment_id.val(attachment.id);

           jQuery('.upload_'+random_class).val(attachment.url);

       });



       //Open the uploader dialog

       custom_uploader.open();



});

	
	
	// Mini Color
	jQuery(".color-picker").miniColors({
		change: function(hex, rgb) {
			jQuery("#console").prepend('HEX: ' + hex + ' (RGB: ' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ')<br />');
		}
		
	});
	
	// Create Sidebar
	jQuery("div#add-more-sidebar").click(function(){
		var clone_item = jQuery(this).parents('.panel-input').siblings('#selected-sidebar').find('.default-sidebar-item').clone(true);
		var clone_val = jQuery(this).siblings('input#add-more-sidebar').val();
		if(clone_val.indexOf("&") > 0){
			alert('You can\'t use the special charactor ( such as & ) as the sidebar name.');
			return;
		}
		if(clone_val == '' || clone_val == 'type title here') return;
		clone_item.removeClass('default-sidebar-item').addClass('sidebar-item');
		clone_item.find('input').attr('name',function(){
			return jQuery(this).attr('id') + '[]';
		});
		clone_item.find('input').attr('value', clone_val);
		clone_item.find('.slider-item-text').html(clone_val);
		jQuery("#selected-sidebar").append(clone_item);
		jQuery(".sidebar-item").slideDown();
	});
	jQuery(".sidebar-item").css('display','block');
	jQuery(".panel-delete-sidebar").click(function(){
	
		var deleted_sidebar = jQuery(this);
		jQuery.confirm({
			'message'	: 'Are you sure to do this?',
			'buttons'	: {
				'Delete'	: {
					'class'	: 'confirm-yes',
					'action': function(){
						deleted_sidebar.parents("#sidebar-item").slideUp("200",function(){
							jQuery(this).remove();
						});
					}
				},
				'Cancel'	: {
					'class'	: 'confirm-no',
					'action': function(){ return false; }
				}
			}
		});
	});
	jQuery('input#add-more-sidebar').setBlankText();
	
	// Upload Font
	jQuery('div#add-more-font').click(function(){
		var clone_item = jQuery(this).siblings('#added-font').find('.default-font-item').clone(true);
		clone_item.removeClass('default-font-item').addClass('font-item');
		clone_item.find('input').attr('name',function(){
			return jQuery(this).attr('id') + '[]'; 
		});
		jQuery("#added-font").append(clone_item);
		jQuery('.font-item').slideDown();
	});
	jQuery(".font-item").css('display','block');
	jQuery(".panel-delete-font").click(function(){
		var deleted_font = jQuery(this);
	
		jQuery.confirm({
			'message'	: 'Are you sure to do this?',
			'buttons'	: {
				'Delete'	: {
					'class'	: 'confirm-yes',
					'action': function(){
						deleted_font.parents("#font-item").slideUp('200',function(){
							jQuery(this).remove();
						});
					}
				},
				'Cancel'	: {
					'class'	: 'confirm-no',
					'action': function(){ return false; }
				}
			}
		});
	});
	jQuery("input.upload-font-button").click(function(){
		attachment_id = jQuery(this).siblings(".font-attachment-id");
		upload_font = jQuery(this).siblings(".upload-font-text");
		font_name_box = jQuery(this).parents('#font-item').find(".cp_upload_font_name");
		tb_show('Upload Media', 'media-upload.php?post_id=&amp;TB_iframe=true');
		window.send_to_editor = function(html){
			attid = jQuery(html).attr('attid');
			font_url = jQuery(html).attr('href');
			jQuery.get(font_url, function(data){
				var font_family_pos = data.indexOf('"font-family":"');
				if( font_family_pos > 0 ){
					attachment_id.val(attid);
					upload_font.val(font_url);				
					font_family_pos = font_family_pos + 15
				
					var font_family_pos_end = data.indexOf('"', font_family_pos + 1);
					var font_name = data.substring(font_family_pos, font_family_pos_end);
					font_name_box.val(font_name);
					
					var custom_font = jQuery(".cp-panel-select-font-family").children('option:nth-child(2)');
					jQuery("<option rel='" + font_url + "' >" + "- " + font_name + "</option>").insertAfter(custom_font);
					tb_remove();
				}else{
					tb_remove();
					alert( 'Only CUFON ( .js file ) is supported with the upload font function. If it\'s already cufon try choosing the "File URL" as link instead of the "Attachment ID" when you click the "Insert to post" button.' );
				}
			});
		}
		return false;
	});
	
	//Submit Button
	jQuery("#goodlayer-panel-form").submit(function(){
		
		setTimeout(function() {
			jQuery('#panel-element-save-complete').children(".panel-element-save-text").html("Save Options Complete");
			var y = jQuery(window).scrollTop() + 140;
			jQuery('#panel-element-save-complete').css('top', y);
			jQuery('#panel-element-save-complete').show().delay('2000').fadeOut();
			loading.removeClass('now-loading');	
			
		}, 5000);
		
		var loading = jQuery(this).find('.loading-save-changes');
		loading.addClass('now-loading');
		jQuery.post(ajaxurl,jQuery(this).serialize(),function(data){
		
				jQuery('#panel-element-save-complete').children(".panel-element-save-text").html("Save Options Complete");
			
			var y = jQuery(window).scrollTop() + 140;
			jQuery('#panel-element-save-complete').css('top', y);
			jQuery('#panel-element-save-complete').show().delay('2000').fadeOut();
			loading.removeClass('now-loading');			
		});
		return false;
		
		
	});
	
	// Import Dummies Data
	jQuery('#import-dummies-data').click(function(){
		var now_loading = jQuery(this).siblings('#import-now-loading');
		now_loading.fadeIn();
		jQuery.post(ajaxurl,{ action:'load_dummy_data' },function(data){
			if( data == 1 ){

				var y = jQuery(window).scrollTop() + 140;
				jQuery('#panel-element-save-complete').children(".panel-element-save-text").html("Import Option Complete");
				jQuery('#panel-element-save-complete').css('top', y);
				jQuery('#panel-element-save-complete').show().delay('2000').fadeOut();		
				now_loading.fadeOut();
				
			}else{
			
				now_loading.hide();
				alert(data);
				
			}
			
		});
	
	});

	
	// Load Example Font
	jQuery(".cp-panel-select-font-family").change(function(){
		var selected_combobox = jQuery(this);
		var selected_rel = selected_combobox.find("option:selected").attr('rel');
		
		if( typeof selected_rel === 'undefined' ){
			var sample_text = selected_combobox.parent().siblings("#panel-font-sample");
			jQuery.post(ajaxurl,{ action:'get_cp_font_url', font: jQuery(this).val().substring(2) },function(data){
				if( data ){
					if( data.type == "Google Font" ){
						jQuery('head').append('<link rel="stylesheet" type="text/css" href="' + data.url + '" >');
						sample_text.html(URL.sample_text);			
						//jQuery.fontAvailable(selected_combobox.val());
						sample_text.css('font-family',selected_combobox.val().substring(2));	
					}else if( data.type == "Cufon" ){
						var script = document.createElement("script");
						script.type = "text/javascript";
						script.src = data.url;
						jQuery('head').append(script);
						// Cufon.hasFont(selected_combobox.val());		
						Cufon.replace(sample_text, {fontFamily: selected_combobox.val().substring(2)});
					}
				}
			}, 'json');		
		}else{
			var script = document.createElement("script");
			var sample_text = selected_combobox.parent().siblings("#panel-font-sample");
			
			script.type = "text/javascript";
			script.src = selected_rel;
			jQuery('head').append(script);
			// Cufon.hasFont(selected_combobox.val());		
			Cufon.replace(sample_text, {fontFamily: selected_combobox.val().substring(2)});
		}

	});
	jQuery(".cp-panel-select-font-family").each(function(){
		jQuery(this).triggerHandler("change");
	})
	
	// Change the style of <select>
	if (!jQuery.browser.opera) {
        jQuery('.combobox select').each(function(){
            var title = jQuery(this).attr('title');
            if( jQuery('option:selected', this).val() != ''  ) title = jQuery('option:selected',this).text();
            jQuery(this)
                .css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
                .after('<span rel="combobox">' + title + '</span>')
                .change(function(){
                    val = jQuery('option:selected',this).text();
                    jQuery(this).next().text(val);
                    })
        });
    };
	
	// Style of on off button
	jQuery("div.checkbox-switch").click(function(){
		if(jQuery(this).hasClass('checkbox-switch-on')){
			jQuery(this).removeClass('checkbox-switch-on').addClass('checkbox-switch-off');
		}else{
			jQuery(this).removeClass('checkbox-switch-off').addClass('checkbox-switch-on');
		}
	});
	
	//radioimage check-list
	jQuery('.radio-image-wrapper input').change(function(){
		jQuery(this).parent().parent().find(".check-list").removeClass("check-list");
		jQuery(this).siblings("label").children("#check-list").addClass("check-list");
		
		var panel_body = jQuery(this).parents('.panel-body');
		if( jQuery(this).val() == 'post-right-sidebar' ){
			panel_body.siblings('.cp-default-post-left-sidebar').slideUp();
			panel_body.siblings('.cp-default-post-right-sidebar').slideDown();
		}else if( jQuery(this).val() == 'post-left-sidebar' ){
			panel_body.siblings('.cp-default-post-right-sidebar').slideUp();
			panel_body.siblings('.cp-default-post-left-sidebar').slideDown();
		}else if( jQuery(this).val() == 'post-both-sidebar' ){
			panel_body.siblings('.cp-default-post-left-sidebar').slideDown();
			panel_body.siblings('.cp-default-post-right-sidebar').slideDown();
		}else if( jQuery(this).val() == 'post-no-sidebar' ){
			panel_body.siblings('.cp-default-post-left-sidebar').slideUp();
			panel_body.siblings('.cp-default-post-right-sidebar').slideUp();
		}		
	})
	jQuery('.radio-image-wrapper input:checked').each(function(){
		jQuery(this).triggerHandler("change");
	});
	
	//background combobox
	jQuery('#cp_background_style').change(function(){
		if(jQuery(this).val() == 'Pattern'){
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_pattern').slideDown();
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_custom').slideUp();
		}else if(jQuery(this).val() == 'Custom Image'){
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_pattern').slideUp();
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_custom').slideDown();	
		}else if(jQuery(this).val() == 'Color'){
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_pattern').slideUp();
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_custom').slideUp();	
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_color').slideDown();	
		}else{
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_pattern').slideUp();
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_custom').slideUp();
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_color').slideUp();
		}
	});
	jQuery('#cp_background_style').each(function(){
		if(jQuery(this).val() == 'Pattern'){
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_pattern').css('display','block');
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_custom').css('display','none');
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_color').css('display','none');
		}else if(jQuery(this).val() == 'Custom Image'){
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_pattern').css('display','none');
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_color').css('display','none');
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_custom').css('display','block');
		}else if(jQuery(this).val() == 'Color'){
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_pattern').css('display','none');
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_custom').css('display','none');	
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_color').css('display','block');				
		}else{
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_pattern').css('display','none');
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_custom').css('display','none');
			jQuery(this).parents('.panel-body').siblings('.body-cp_background_color').css('display','none');
		}
	});
	
	// Load Default Color
	
	// Load Default Color
	jQuery('#cp_load_default_color_button').click(function(){
		jQuery.confirm({
			'message'	: 'Are you sure reset colors ?',
			'buttons'	: {
				'Yes'	: {
					'class'	: 'confirm-yes',
					'action': function(){
						jQuery('.color-picker').each(function(){
							jQuery(this).val(jQuery(this).attr('color_scheme_1'));		
							jQuery(this).trigger('keyup.miniColors');
						});
						
					}
				},
				'No'	: {
					'class'	: 'confirm-no',
					'action': function(){ return false; }
				}
			}
		});	
	});


	jQuery('#color_scheme_1').click(function(){
		jQuery('.color-picker').each(function(){
			jQuery(this).val(jQuery(this).attr('color_scheme_1'));
			jQuery(this).trigger('keyup.miniColors');
		});
	});	
	// Load Blue Color
	jQuery('#color_scheme_2').change(function(){
		jQuery('.color-picker').each(function(){
			jQuery(this).val(jQuery(this).attr('color_scheme_2'));		
			jQuery(this).trigger('keyup.miniColors');
		});
	});
	// Load Brown Color
	jQuery('#color_scheme_3').change(function(){
		jQuery('.color-picker').each(function(){
			jQuery(this).val(jQuery(this).attr('color_scheme_3'));		
			jQuery(this).trigger('keyup.miniColors');
			
		});
	});	
	// Load Red Color
	jQuery('#color_scheme_4').change(function(){
		jQuery('.color-picker').each(function(){
			jQuery(this).val(jQuery(this).attr('color_scheme_4'));
			jQuery(this).trigger('keyup.miniColors');
		});
	});
	
	// Load Red Color
	jQuery('#color_scheme_5').change(function(){
		jQuery('.color-picker').each(function(){
			jQuery(this).val(jQuery(this).attr('color_scheme_5'));
			jQuery(this).trigger('keyup.miniColors');
		});
	});
	
	// Load Red Color
	jQuery('#color_scheme_6').change(function(){
		jQuery('.color-picker').each(function(){
			jQuery(this).val(jQuery(this).attr('color_scheme_6'));
			jQuery(this).trigger('keyup.miniColors');
		});
	});
		
	// Sliderbar
	jQuery('div[rel="sliderbar"]').each(function(){
		var bar_id = jQuery(this).attr('id');
		var init_val = jQuery(this).siblings('input[name="' + bar_id + '"]').attr('value');
		jQuery(this).slider({ min:10, max:50, value: init_val,
			slide: function(event, ui){
				jQuery(this).siblings('input[name="' + bar_id + '"]').attr('value',ui.value);
				jQuery(this).siblings('#slidertext').html(ui.value + ' px');
			}
		});
	});
	
});

// a function to check if selected font is currenty available for use
(function($) {
    
	    /* $('input[type=text]').each(function(){
		   var $this = $(this).addClass('clearable');
	  	 });*/
	
jQuery.fn.clearable = function() {
 
  $('.morelink').on('click', function() {
    var $this = $(this);
    if ($this.hasClass('less')) {
      $this.removeClass('less');
      $this.html(config.moreText);
    } else {
      $this.addClass('less');
      $this.html(config.lessText);
    }
    $this.parent().prev().toggle();
    $this.prev().toggle();
    return false;
  });
 
}

$(document).ready(function(){
	$('.upload_image_text').clearable();
	$('#cp_panel_social_network input').clearable();
	
});

	var element;
    $.fontAvailable = function(fontName) {
        var width, height;
        
        // prepare element, and append to DOM
        if(!element) {
            element = $( document.createElement( 'span' ))
                .css( 'visibility', 'hidden' )
                .css( 'position', 'absolute' )
                .css( 'top', '-10000px' )
                .css( 'left', '-10000px' )
                .html( 'abcdefghijklmnopqrstuvwxyz' )
                .appendTo( document.body );
        }
        
        // get the width/height of element after applying a fake font
        width = element
            .css('font-family', '__FAKEFONT__')
            .width();
        height = element.height();
        
        // set test font
        element.css('font-family', fontName);
        
        return width !== element.width() || height !== element.height();
    }
	
	$.fn.setBlankText = function(){
		this.live("blur", function(){
			var default_value = $(this).attr("rel");
			if ($(this).val() == ""){
				$(this).val(default_value);
				$(this).css('font-style','italic');
				$(this).css('color','#999');
			}
			
		}).live("focus", function(){
			var default_value = $(this).attr("rel");
			if ($(this).val() == default_value){
				$(this).val("");
				$(this).css('font-style','normal');
				$(this).css('color','#444');
			}
		});
	}
})(jQuery);