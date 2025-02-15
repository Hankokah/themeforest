var $j = jQuery.noConflict();

$j(document).ready(function() {

	/* MOVE DOWN MENU */
	moveDownMenu();
	
	/* DROP DOWN MENU LEVEL 2 */
	dropDownMenu();
	
	selectMenu();
	
	initBigSlider();
	
	initSmallSlider();
	
	initAccordion();
	
	initTabs();
	
	stylePriceingTables();
	
	initProgressBars();
	
	initMessages();
	
	centerCircle();
	
	stylishSelectContent();
	stylishSelectFooter();
	
	backToTop();
	
	fitVideo();
	
	filterMenu();
	
	checkForIpad();
	
	placeholderReplace();
	
	initParallax(parallax_speed);
	
});

var on_change = true;
var size1 = true;
var size2 = true;
var size3 = true;
var size4 = true;
var size1_width = 1120;
var size2_width = 960;
var size3_width = 500;

$j(window).load(function(){
	
	magicPanes();
	
	initPortfolioSingleInfo();
	initPortfolioList();
	initPortfolioFilter();
	
	
	$width = $j(window).width();
	if($width > size1_width) { size1 = false; }
	else { size2 = false; }
	
	//after load of all pictures show sliders/portfolios
	$j('.flexslider, .slider_small, .portfolio_outer').css('visibility','visible');
	
	$j('.touch .main_menu li:has(div.second)').doubleTapToGo(); // load script to close menu on youch devices
	
});

$j(window).resize(function(){
	$width = $j(window).width();
	$content = $j('.content').width();
	magicPanes();
	initPortfolioList();
	
	$scrollHeight = $j(".portfolio_container").height();
	
	if($width > size1_width && size1 === true){
		size2 = true;
		size3 = true;
		size4 = true;
		size1 = false;
		
		centerCircle();
		setTimeout(function(){
			updateImageHolders();
		},100);
	}
	
	if($width < size1_width && size2 === true){
		size1 = true;
		size3 = true;
		size4 = true;
		size2 = false;
		
		centerCircle();
		setTimeout(function(){
			updateImageHolders();
		},100);
	}
	
	
	if($width < size2_width && size3 === true){
		size1 = true;
		size2 = true;
		size4 = true;
		size3 = false;
		
		$j(".portfolio_detail").css('margin-top',0);
		centerCircle();
		setTimeout(function(){
			updateImageHolders();
		},100);
	}
	
	if($width < size3_width && size4 === true){
		size1 = true;
		size2 = true;
		size3 = true;
		size4 = false;
		
		$j(".portfolio_detail").css('margin-top',0);
		centerCircle();
		setTimeout(function(){
			updateImageHolders();
		},100);
	}
	
});

function dropDownMenu(){
	var menu_items = $j('.no-touch .drop_down > ul > li');

	menu_items.each( function(i) {
		if ($j(menu_items[i]).find('.second').length > 0) {
			// var maxWidth = Math.max.apply(null, $j(menu_items[i]).find('ul > li').map(function (){
					// return $j(this).width()-50;
			// }).get());
			// $j(menu_items[i]).find('.second').css('width',maxWidth);
			// $j(menu_items[i]).find('ul > li').not("ul > li > ul > li").css('width',maxWidth);
		
			//$j(menu_items[i]).data('original_height', $j(menu_items[i]).find('.second .inner2 > ul').height() + 'px');
			
			$j(menu_items[i]).find('.second').hide();
			$j(menu_items[i]).find('.second').css({'visibility': 'visible','height': '0px'});
			var size = $j(menu_items[i]).find('ul > li').size()*10 + 200;
			$j(menu_items[i]).mouseenter(function(){
				$j(menu_items[i]).find('.second').css('display', 'block');
				$j(menu_items[i]).find('.second').stop().animate({'height': $j(menu_items[i]).find('.second .inner2 > ul').height()}, size, function() {
					$j(menu_items[i]).find('.second').css('overflow', 'visible');
					
				});
				dropDownMenuThirdLevel();
			}).mouseleave( function(){
				$j(menu_items[i]).find('.second').stop().animate({'height': '0px'},size, function() {
					$j(menu_items[i]).find('.second').css('overflow', 'hidden');
					$j(menu_items[i]).find('.second').css('visivility', 'hidden');
					
				});
			});
		}

	});
}

function dropDownMenuThirdLevel(){
	var menu_items2 = $j('.no-touch .drop_down ul li > .second > .inner > .inner2 > ul > li');
	menu_items2.each( function(i) {
		if ($j(menu_items2[i]).find('ul').length > 0) {
			var sum=0;
			$j(menu_items2[i]).find('ul li').each( function(){ sum+=$j(this).height();});
			
			$j(menu_items2[i]).data('original_height', sum + 'px');
			
			var size = $j(menu_items2[i]).find('ul > li').size()*10 + 200;
			$j(menu_items2[i]).mouseenter(function(){
				$j(menu_items2[i]).find('ul').css({'visibility': 'visible','height': '0px'});
				$j(menu_items2[i]).find('ul').css('display', 'block');
				$j(menu_items2[i]).find('ul').stop().animate({'height': $j(menu_items2[i]).data('original_height')}, size, function() {
					$j(menu_items2[i]).find('ul').css('overflow', 'visible');
				});
			}).mouseleave(function(){
				$j(menu_items2[i]).find('ul').stop().animate({'height': '0px'},size, function() {
					$j(menu_items2[i]).find('ul').css('overflow', 'hidden');
					$j(menu_items2[i]).find('.second').css('visivility', 'hidden');
				});
			});
		}
	});
}

function magicPanes(){
	$magicLine = $j("#magic");
	$magicLine2 = $j("#magic2");
	$menulinks = $j(".main_menu > ul > li");
	if($j(".main_menu .active").length > 0){
		$j('body').removeClass('single');
		
		$magicLine.width($j(".active").outerWidth(true)).css("left", $j(".active").position().left);
		$magicLine2.width($j(".active").outerWidth(true)).css("left", $j(".active").position().left).data("origLeft", $magicLine.position().left).data("origWidth", $magicLine.width());
	
		$menulinks.mouseenter(function() {
			$el = $j(this);
			$leftPos = $el.position().left;
			$newWidth = $el.outerWidth(true);
			
			return $magicLine2.stop().animate({
				left: $leftPos,
				width: $newWidth
			});
		}).mouseleave(function() {
			
			return $magicLine2.stop().animate({
				left: $magicLine2.data("origLeft"),
				width: $magicLine2.data("origWidth")
			});
		});
		
		$j('nav > ul > li a').each(function(i) {
			$j(this).click(function(){
				
				if($j(this).attr('href') !== "http://#" && $j(this).attr('href') != "#"){
				
					//if($j('.move_down').length > 0){
						$j('a').parent().removeClass('active');
						if($j(this).closest('.second').length === 0){
							$j(this).parent().addClass('active');
						}else{
							$j(this).closest('.second').parent().addClass('active');
						}
						
						//if($j(this).closest('.second').length == 0){
							//leftPos = $j(this).position().left;
							//newWidth = $j(this).outerWidth(true);
						//}else{
							//leftPos = $j(this).closest('.second').parent().position().left;
							//newWidth = $j(this).closest('.second').parent().outerWidth(true);
						//}
						
						$magicLine2.data("origLeft", $leftPos).data("origWidth", $newWidth);
						$magicLine2.stop().animate({
							left: $leftPos,
							width: $newWidth
						});
						return $magicLine.stop().animate({
							left: $leftPos,
							width: $newWidth
						});
						
					//}
					
				}else{
					return false;
				}
			});
		});
		
	}else{
		$j('body').addClass('single');
	}
}


function initAccordion(){
	$j( ".accordion" ).accordion({
		collapsible: true,
		active: false,
		heightStyle: "content"
	});
	
	$j(".toggle").addClass("accordion ui-accordion ui-accordion-icons ui-widget ui-helper-reset")
	.find("h5")
	.addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-top ui-corner-bottom")
	.hover(function() { $j(this).toggleClass("ui-state-hover"); })
	.prepend('<span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>')
	.click(function() {
	$j(this)
		.toggleClass("ui-accordion-header-active ui-state-active ui-state-default ui-corner-bottom")
		.find("> .ui-icon").toggleClass("ui-icon-triangle-1-e ui-icon-triangle-1-s").end()
		.next().toggleClass("ui-accordion-content-active").slideToggle(200);
		return false;
	})
	.next()
	.addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom")
	.hide(); 
	
}

function initTabs(){

	var $tabsNav = $j('.tabs-nav'),
	$tabsNavLis = $tabsNav.children('li'),
	$tabContent = $j('.tab-content');
	$tabsNav.each(function() {
		var $this = $j(this);
		$this.next().children('.tab-content').stop(true,true).hide().first().show();
		$this.children('li').first().addClass('active').stop(true,true).show();
	});
	$tabsNavLis.on('click', function(e) {
		var $this = $j(this);
		$this.siblings().removeClass('active').end().addClass('active');
		$this.parent().next().children('.tab-content').stop(true,true).hide().siblings( $this.find('a').attr('href') ).fadeIn();
		e.preventDefault();
	}); 
}

function stylePriceingTables(){
	
	$j('.price_table ul li.cell').each(function(){
		$height = $j(this).height();
		$padding = (54 - $height)/2;
		$j(this).css('padding',$padding+'px 0px');
	});
}

function initProgressBars(){
	$j('.progress_bars').each(function() {
		$j(this).appear(function() {
			$j(this).find('.progress_bar').each(function() {
				var percentage = $j(this).find('.progress_content').data('percentage');
				$j(this).find('.progress_content').css('width', '0%');
				$j(this).find('.progress_number').css('width', '0%');
				$j(this).find('.progress_content').animate({
					width: percentage+'%'
				}, 2000);
				$j(this).find('.progress_number').html(percentage+'%');
				$j(this).find('.progress_number').animate({
					width: percentage+'%'
				}, 2000);
			});
		});
	});
	
	var timeOuts = new Array(); 
	$j('.progress_bars2').each(function() {
		$j(this).appear(function() {
			$j(this).find('.progress_bar').each(function(i) {
				var number = $j(this).find('.progress_content').data('number');
				
				var bars = $j(this).find('.bar');
			
				bars.each(function(i){
					if(i < number){
						var time = (i + 1)*350;
						timeOuts[i] = setTimeout(function(){
						$j(bars[i]).addClass('active');
						},time);
					}
				});
				
			});
		});
	});
	
	var timeOuts2 = new Array(); 
	$j('.progres_bars3').each(function() {
		$width = 100/($j(this).find('.bar_holder').length);
		$j(this).find('.progress_bar').each(function() {
			$j(this).width($width+'%');
		});
		$j(this).appear(function() {
			$j(this).find('.progress_bar').each(function(i) {
				
				var number = $j(this).find('.bar_holder').data('number');
				
				var bars = $j(this).find('.bar');
			
				bars.each(function(i){
					if(i < number){
						var time = (i + 1)*200;
						timeOuts2[i] = setTimeout(function(){
							$j(bars[9-i]).addClass('active');
						},time);
					}
				});
				
			});
		});
	});
	
}

function initMessages(){
	$j('.message').each(function(){
		$j(this).find('.close').click(function(e){
			e.preventDefault();
			$j(this).parent().fadeOut(500);
		});
	});
}

var $scrollHeight;
function initPortfolioSingleInfo(){
	var $sidebar   = $j(".portfolio_single_follow");
	if($j(".portfolio_single_follow").length > 0){
	
		offset = $sidebar.offset();
		$scrollHeight = $j(".portfolio_container").height();
		$scrollOffset = $j(".portfolio_container").offset();
		$window = $j(window);
		topPadding = 15;
		
		$window.scroll(function() {
			if($window.width() > 960){
				if ($window.scrollTop() > offset.top) {
					if ($window.scrollTop() + topPadding + $sidebar.height() + 24 < $scrollOffset.top + $scrollHeight) {
						$sidebar.stop().animate({
							marginTop: $window.scrollTop() - offset.top + topPadding
						});
					} else {
						$sidebar.stop().animate({
							marginTop: $scrollHeight - $sidebar.height() - 24
						});
					}
				} else {
					$sidebar.stop().animate({
						marginTop: 0
					});
				}		
			}else{
				$sidebar.css('margin-top',0);
			}
			
		});
	}
}

function centerCircle(){
	/*center circle text*/
	$j('.circle_item .circle div').each(function(){
		$height = $j(this).height();
		$padding = (163 - $height)/2;
		$j(this).css('padding',$padding+'px 0px');
	});
	
	/* center text on right side of circle */
	$j('.circle_left .text').each(function(){
		$height = $j(this).height();
		$padding = (163 - $height - 10)/2;
		console.log($padding);
		if($padding > 0){
			$j(this).css('padding-top',$padding);
			$j(this).css('padding-bottom',$padding);
		}else{
			$j(this).css('padding-top',0);
			$j(this).css('padding-bottom',0);
		}
	});
}

function initParallax(speed){
	
	if($j('html').hasClass('touch')){
		$j('.parallax section').each(function() {
			var $self = $j(this);
			var section_height = $self.data('height');
			$self.height(section_height);
			var rate = 0.5;
			
			var bpos = (- $j(this).offset().top) * rate;
			$self.css({'background-position': 'center ' + bpos  + 'px' });
			
			$j(window).bind('scroll', function() {
				var bpos = (- $self.offset().top + $j(window).scrollTop()) * rate;
				$self.css({'background-position': 'center ' + bpos  + 'px' });
			});
		});
	}else{
		$j('.parallax section').each(function() {
			var $self = $j(this);
			var section_height = $self.data('height');
			$self.height(section_height);
			var rate = (section_height / $j(document).height()) * speed;
			
			var distance = $j.elementoffset($self);
			var bpos = - (distance * rate);
			$self.css({'background-position': 'center ' + bpos  + 'px' });
			
			$j(window).bind('scroll', function() {
				var distance = $j.elementoffset($self);
				var bpos = - (distance * rate);
				$self.css({'background-position': 'center ' + bpos  + 'px' });
			});
		});
	}
	return this;
	
}

$j.elementoffset = function($element) {
	var fold = $j(window).scrollTop();
	return (fold) - $element.offset().top + 104;
};

function initPortfolioList(){
	
	$j('.portfolio_holder').isotope({
		itemSelector: '.element',
		animationEngine : 'jquery',
		animationOptions: {
			duration: 500,
			easing: 'swing',
			queue: false
		}
		
	});
	
	var config_portfolio = {    
		interval: 100,
		over: function(){
			$height = $j(this).find("img").height();
			$j(this).height($height+21);
			$j(this).find(".image").stop().animate({
				height: 0,
				margin:0,
				easing: 'easeInOutQuart'
			}, 400, function() {  
				$j(this).parent().find("p,a.view,hr").fadeIn(200);
			});
		}, // function = onMouseOver callback (REQUIRED)    
		timeout: 0, // number = milliseconds delay before onMouseOut    
		out: function(){
			
			$j(this).find("p,a.view,hr").hide(100);
			$j(this).find(".image").stop().animate({
				height: $height,
				margin: "0px 0px 5px 0px",
				easing: 'easeInOutQuart'
			}, 400, function() {
				$j(this).parent().css('height','auto');
			});
		} // function = onMouseOut callback (REQUIRED)    
	};
	
	$j(".portfolio_holder .article_inner").each(function(){
		$j(this).hoverIntent(config_portfolio);
	});
	
}

function initPortfolioFilter(){
	$j('.filter a:first').addClass('current');
	$j('.filter a').click(function(){
		var selector = $j(this).attr('data-filter');
		$j('.portfolio_holder').isotope({ filter: selector });
		
		$j(".filter a").removeClass("current");
		$j(this).addClass("current");
		
		return false;
	});
}

function selectMenu(){
	var $menu_select = $j("<div class='select'><ul></ul></div>");
	$j("<span>&nbsp;</span>").prependTo($menu_select);
	$menu_select.appendTo(".selectnav");
	if($j(".main_menu").hasClass('drop_down')){
		$j(".main_menu ul li a").each(function(){
			var menu_url = $j(this).attr("href");
			var menu_text = $j(this).text();
			if ($j(this).parents("li").length === 2) { menu_text = "&nbsp;&nbsp;&nbsp;" + menu_text; }
			if ($j(this).parents("li").length === 3) { menu_text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + menu_text; }
			if ($j(this).parents("li").length > 3) { menu_text = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + menu_text; }
			
			// $j("<li><a href="+menu_url+">"+menu_text+"</a></li>").appendTo($menu_select.find('ul'));
			var li = $j("<li />");
			var link = $j("<a />", {"href": menu_url, "html": menu_text}).appendTo(li);
			li.appendTo($menu_select.find('ul'));
		});
	}else if($j(".main_menu").hasClass('move_down')){
		$j(".main_menu ul li a").each(function(){
			var menu_url = $j(this).attr("href");
			var menu_text = $j(this).text();
			if ($j(this).parents("div.mc").length === 1) { menu_text = "&nbsp;&nbsp;&nbsp;" + menu_text; }
			if ($j(this).hasClass('sub')) { menu_text = "&nbsp;&nbsp;&nbsp;" + menu_text; }
			
			//$j('<li><a href=' + menu_url + '>' + menu_text + '</a></li>').appendTo($menu_select.find('ul'));
			var li = $j("<li />");
			var link = $j("<a />", {"href": menu_url, "html": menu_text}).appendTo(li);
			li.appendTo($menu_select.find('ul'));
		});
	}
	
	
	$j(".select span").click(function () {
		if ($j(".select ul").is(":visible")){
			$j(".select ul").slideUp();
		} else {
			$j(".select ul").slideDown();
		}
	});
	
	$j(".selectnav ul li a").click(function () {
		$j(".select ul").slideUp();
	});

}

function updateImageHolders(){
	//reinitialize height of slides in small slider and portfolio
	$j(".content .slider_small .slide_item .image").each(function(){
		$height = $j(this).find('img').height();
		$j(this).height($height);
	});
	
	$j(".portfolio_holder article .image").each(function(){
		$height = $j(this).find('img').height();
		$j(this).height($height);
	});
}

function stylishSelectContent(){
	if ($j(".gform_wrapper").length === 0 && $j(".woocommerce .checkout").length === 0 && $j(".woocommerce .variations_form").length === 0 && $j(".woocommerce-account .country_select").length === 0 && $j(".woocommerce .woocommerce-ordering").length === 0 && $j(".woocommerce-cart .shipping_calculator").length === 0 ) {
		$j('.content select').not("#rating").sSelect({ddMaxHeight: '300px'});
	}
}

function stylishSelectFooter(){
	$j('footer select').sSelect();
}

function backToTop(){
	$j(document).on('click','.back_to_top',function(e){
		e.preventDefault();
		$j('body,html').animate({scrollTop: 0}, 800);
	});
}

function fitVideo(){	
	$j(".portfolio_images").fitVids();
	$j(".video_holder").fitVids();
}

function filterMenu(){
	var filter_items = $j('div.filter > ul > li');
	
		filter_items.each( function(i) {
			
			if ($j(filter_items[i]).find('ul').length>0) {
				$j(filter_items[i]).data('original_height', '29px');
				$j(filter_items[i]).find('ul:first').hide();
				$j(filter_items[i]).find('ul:first').css({'visibility':'visible', 'height':$j(this).data('original_height'), 'opacity': 0, 'z-index':0});
				
				$j(filter_items[i]).hover(
						function() {
							$j(this).find('ul:first').css("height",$j(this).data('original_height'));
							$j(this).find('ul:first').css("display","block");
							$j(this).find('ul:first').css("overwlow","hidden");
							$j(this).find('ul:first').css("z-index",10);
							$j(this).find('ul:first').stop().animate({'opacity': 1}, 500);
						}, function() {
							$j(this).find('ul:first').stop();
							$j(this).find('ul:first').css('overflow','hidden');
							
							$j(this).find('ul:first').stop().animate({'opacity': 0}, 500,'',function(){
								$j(this).hide();
								
							});
							$j(this).find('ul:first').css("z-index",0);
							
						});
				
			}
		});
}

function checkForIpad(){
	Modernizr.addTest('ipad', function () {
		return !!navigator.userAgent.match(/iPad/i);
	});
}

function placeholderReplace(){
    $j('[placeholder]').focus(function() {
     var input = $j(this);
      if (input.val() === input.attr('placeholder')) {
        if (this.originalType) {
          this.type = this.originalType;
          delete this.originalType;
        }
        input.val('');
        input.removeClass('placeholder');
      }
    }).blur(function() {
      var input = $j(this);
      if (input.val() === '') {
        if (this.type === 'password') {
          this.originalType = this.type;
          this.type = 'text';
        }
        input.addClass('placeholder');
        input.val(input.attr('placeholder'));
      }
    }).blur();

    $j('[placeholder]').parents('form').submit(function () {
       $j(this).find('[placeholder]').each(function () {
           var input = $j(this);
           if (input.val() === input.attr('placeholder')) {
               input.val('');
           }
       });
   });
} 