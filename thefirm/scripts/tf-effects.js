jQuery.noConflict();
(function($) {
$(function() {
    $(document).ready(function() {
    var boxhomesize = $('.boxhome').size();
    var movecount = $('.boxhome').size() - 3;
    var movecountteam = $('.teambox').size() - 4;
    var totalmoveteam = movecountteam;
    var totalmove = movecount;
    var i = 0;
    
    $('.socnetico').fadeTo(0, 0.5);
    
    $('.socnetico').hover( function() {
            $(this).stop().fadeTo(400, 1);
      }, 
      function () {
            $(this).stop().fadeTo(400, 0.5);
      }
    );
    
    if ($('.boxhome').size() > 3) {$('.scrolls').show(); $('.arrowchecker').text('1'); };
    if ($('.teambox').size() > 4) {$('.scrolls').show(); $('.arrowchecker').text('1'); };
    $('.scrollright').fadeTo(0, 0.5);
    $('.scrollleft').fadeTo(0, 0.25);
    
    $('.scrollleft').hover(
      function () {
        if (i > 0) { 
            $(this).stop().fadeTo(200, 0.75);
        }
      }, 
      function () {
        if (i > 0) { 
            $(this).stop().fadeTo(200, 0.5);
        }
      }
    );
    
    $('.scrollright').hover(
      function () {
        if (boxhomesize > 3) {
            if (i < totalmove) { 
                $(this).stop().fadeTo(200, 0.75);
            }
        } else {
            if (i < totalmoveteam) { 
                $(this).stop().fadeTo(200, 0.75);
            }            
        }
      }, 
      function () {
        if (boxhomesize > 3) {
            if (i < totalmove) { 
                $(this).stop().fadeTo(200, 0.5);
            }
        } else {
            if (i < totalmoveteam) { 
                $(this).stop().fadeTo(200, 0.5);
            }               
        }
      }
    );
    
        
    $('.scrollright').click(function() {
        if (boxhomesize > 3) {
            if (movecount > 0) {            
                $('.boxhome').eq(0).removeClass('boxhome').addClass('boxhome2');
                $('#teamwrap').animate({'left' : "-=320px"}, {duration: 400, easing: 'easeOutExpo'} );
                movecount--;
                i++;
            }
            if (i > 0) {
            $('.scrollleft').fadeTo(300, 0.5);
            }
            if (i == totalmove) {
            $('.scrollright').fadeTo(300, 0.25);
            }
        } else {
            if (movecountteam > 0) {            
                $('.teambox').eq(0).removeClass('teambox').addClass('teambox2');
                $('#teamwrap').animate({'left' : "-=235px"}, {duration: 400, easing: 'easeOutExpo'} );
                movecountteam--;
                i++;
            }
            if (i > 0) {
            $('.scrollleft').fadeTo(300, 0.5);
            }
            if (i == totalmoveteam) {
            $('.scrollright').fadeTo(300, 0.25);
            }            
        }
    });

    $('.scrollleft').click(function() {
        if (boxhomesize > 3) {
            if (totalmove != movecount) {
                i--;           
                $('.boxhome2').eq(i).removeClass('boxhome2').addClass('boxhome');
                $('#teamwrap').animate({'left' : "+=320px"}, {duration: 400, easing: 'easeOutExpo'});
                movecount++;
            }
            if (i == 0) {
            $('.scrollleft').fadeTo(300, 0.25);
            }
            if (i < totalmove) {
            $('.scrollright').fadeTo(300, 0.5);
            }
        } else {
            if (totalmoveteam != movecountteam) {
                i--;           
                $('.teambox2').eq(i).removeClass('teambox2').addClass('teambox');
                $('#teamwrap').animate({'left' : "+=235px"}, {duration: 400, easing: 'easeOutExpo'});
                movecountteam++;
            }
            if (i == 0) {
            $('.scrollleft').fadeTo(300, 0.25);
            }
            if (i < totalmoveteam) {
            $('.scrollright').fadeTo(300, 0.5);
            }            
        }
    });
        


    $('.backgroundimg').hide();
    $('.backgroundimg').eq(0).show();
    var bgimgsize = $('.backgroundimg').size();
    if (bgimgsize == 2) {
        radiBg2(0);
    };    

    if (bgimgsize > 2) {
        radiBg(0, bgimgsize);
    };


   // x 240 = 100  280
   // x = 280 * 100 / 240


   
    $(".postwrap, .galleryimage").hover(
      function () {
        
        $('.img_grayscale', this).stop().fadeTo('800', 1);
      }, 
      function () {
        $('.img_grayscale', this).stop().fadeTo('800', 0);

      }
    );
    
    $("ul.foot_menu_nav li").hover(
      function () {
        $('ul', this).stop().fadeTo('500', 1);
      }, 
      function () {
        $('ul', this).stop().fadeTo('500', 0, function() { $(this).css('display', 'none') ;} );

      }
    );

    $('.closemesagio').click(function() {
        $("#messageemail").animate({top: -100, opacity: 0}, 400, function() {
        $(this).css('display', 'none');    
        })   
    });
    
    });
    
    function radiBg(current, count) {
        $('#bgtimer').css({left: 0});
        var image = $('.backgroundimg');
        $('#bgtimer').animate({left:1000}, 10000, function() {

            if (current == count - 1) {
                image.eq(count - 1).fadeTo(1500, 0);
                image.eq(0).fadeTo(1500, 1);
                var newcurr = 0;            
            }else {
                image.eq(current).fadeTo(1500, 0);
                image.eq(current+1).fadeTo(1500, 1);
                var newcurr = current + 1;
            }

            radiBg(newcurr, 3);
        });

    };
    var dejo;
    function radiBg2(param) {

        $('#bgtimer').css({left: 0});
        var image = $('.backgroundimg');

        
         $('#bgtimer').animate({left:1000}, 10000, function() {
            if (param == 0) {
                image.eq(0).fadeTo(1500, 0);
                image.eq(1).fadeTo(1500, 1);
                dejo = 1;
            };
            if (param == 1) {
                image.eq(1).fadeTo(1500, 0);
                image.eq(0).fadeTo(1500, 1);
                dejo = 0;
            };
        
            radiBg2(dejo);
        });

    };

    
    
    $(window).load(function() {
        

    var co;
    function flashhomepage(sz, cnt) {
        co = cnt;
        if ( $('.replymes').text() == 'stop' )  return;
        if (co < sz) {
            $('.img_grayscalehome').eq(co).fadeTo(600, 1, function() {
                $('.img_grayscalehome').eq(co).fadeTo(600, 0, function() {
                    co++; flashhomepage(sz, co);
                });
            });
        } else {
            $('.img_grayscalehome').eq(0).fadeTo(600, 1, function() {
                $('.img_grayscalehome').eq(0).fadeTo(600, 0, function() {       
                    co=1;flashhomepage(sz, co);
                });
            });            
            
        };
    };
    var colbno = $('.colbno').text();
    var colbho = $('.colbho').text();
    

    
    $('.readmore, .readmoreinner, #submitC, #contactsubmit').hover(function(){
        $(this).stop().animate({backgroundColor: '#'+colbho}, 300);
    }, function() {
        $(this).stop().animate({backgroundColor: '#'+colbno}, 300);
    })
      
    
    var nekikur = 0; var nekikur2 = 0;
    $(".boxhome").each(function() {
        if (nekikur < $(this).height()) {nekikur = $(this).height()};
    });
    $(".boxhome").each(function() {
      $(this).css({'height' : nekikur + 'px'});
    });
    
    $(".teambox").each(function() {
        if (nekikur2 < $(this).height()) {nekikur2 = $(this).height()};
    });
    $(".teambox").each(function() {
      $(this).css({'height' : nekikur2+30 + 'px'});
    });
    
    $(".boxhome").hover(
      function () {
        $(".boxhome").not(this).addClass('inactiveBH');
        $(this).stop().animate({'width': 320, 'height': (nekikur+50), 'font-size' : 25}, {duration:300});
        
        $('.img_wrapperhome', this).stop().animate({width: 280, height: 204}, {duration:300});
        //$('h1', this).stop().animate({fontSize: '34px'}, {duration:300});
        //$('h2', this).stop().animate({fontSize: '18px'}, {duration:300});
        //$('p', this).stop().animate({fontSize: '16px'}, {duration:300});
        $('.replymes').text('stop');
        $('.img_grayscalehome', this).stop().fadeTo('300', 1);
        
        
        //$('.inactiveBH h1').stop().animate({fontSize: '26px'}, {duration:250});
        //$('.inactiveBH h2').stop().animate({fontSize: '14px'}, {duration:250});
        //$('.inactiveBH p').stop().animate({fontSize: '12px'}, {duration:250});
        $('.inactiveBH .bhomewrap').stop().fadeTo('250', 0.50);
        $(".inactiveBH .img_wrapperhome").stop().animate({width: 220, height: 160}, {duration:250});        
        $(".boxhome").not(this).stop().animate({'width': 260, 'height':nekikur}, {duration:250});
      }, 
      function () {
        
        $(this).stop().animate({'width': 280, 'height':nekikur}, {duration:300});
        //$('img', this).stop().animate({width: 240}, {duration:300});
        $('.img_wrapperhome', this).stop().animate({width: 240, height: 175}, {duration:300});
        
        $('.img_grayscalehome', this).stop().fadeTo('300', 0, function() {$('.replymes').text(''); });
        //flashhomepage(sizeofbw, 0);
       // $('h1', this).stop().animate({fontSize: '30px'}, {duration:300});
        //$('h2', this).stop().animate({fontSize: '16px'}, {duration:300});
        //$('p', this).stop().animate({fontSize: '14px'}, {duration:300});
        
        
     //   $('.inactiveBH h1').stop().animate({fontSize: '30px'}, {duration:250});
      //  $('.inactiveBH h2').stop().animate({fontSize: '16px'}, {duration:250});
      //  $('.inactiveBH p').stop().animate({fontSize: '14px'}, {duration:250});
        $('.inactiveBH .bhomewrap').stop().fadeTo('250', 1);
        $(".inactiveBH .img_wrapperhome").stop().animate({width: 240, height: 175}, {duration:250});   
        $(".boxhome").not(this).stop().animate({'width': 280, 'height':nekikur}, {duration:250});
        $('.inactiveBH').removeClass('inactiveBH');
      }
    );
    
  $(".teambox").hover(
      function () {
        $(".teambox").not(this).addClass('inactiveBH');
        $(this).stop().animate({'width': 245, 'height': (nekikur2+30+50), 'font-size' : 25}, {duration:300});
        
        $('.img_wrapperteam', this).stop().animate({width: 215, height: 212}, {duration:300});
        //$('h1', this).stop().animate({fontSize: '34px'}, {duration:300});
        //$('h2', this).stop().animate({fontSize: '18px'}, {duration:300});
        //$('p', this).stop().animate({fontSize: '16px'}, {duration:300});
        $('.replymes').text('stop');
        $('.img_grayscaleteam', this).stop().fadeTo('300', 1);
        
        
        //$('.inactiveBH h1').stop().animate({fontSize: '26px'}, {duration:250});
        //$('.inactiveBH h2').stop().animate({fontSize: '14px'}, {duration:250});
        //$('.inactiveBH p').stop().animate({fontSize: '12px'}, {duration:250});
        $('.inactiveBH .bhomewrap').stop().fadeTo('250', 0.50);
        $(".inactiveBH .img_wrapperteam").stop().animate({width: 175, height: 166}, {duration:250});        
        $(".teambox").not(this).stop().animate({'width': 205, 'height':nekikur2+30}, {duration:250});
      }, 
      function () {
        
        $(this).stop().animate({'width': 215, 'height':nekikur2+30}, {duration:300});
        //$('img', this).stop().animate({width: 240}, {duration:300});
        $('.img_wrapperteam', this).stop().animate({width: 185, height: 175}, {duration:300});
        
        $('.img_grayscaleteam', this).stop().fadeTo('300', 0, function() {$('.replymes').text(''); });
        //flashhomepage(sizeofbw, 0);
       // $('h1', this).stop().animate({fontSize: '30px'}, {duration:300});
        //$('h2', this).stop().animate({fontSize: '16px'}, {duration:300});
        //$('p', this).stop().animate({fontSize: '14px'}, {duration:300});
        /* UBACI COLOR IZ PANELA */
        

     //   $('.inactiveBH h1').stop().animate({fontSize: '30px'}, {duration:250});
      //  $('.inactiveBH h2').stop().animate({fontSize: '16px'}, {duration:250});
      //  $('.inactiveBH p').stop().animate({fontSize: '14px'}, {duration:250});
        $('.inactiveBH .bhomewrap').stop().fadeTo('250', 1);
        $(".inactiveBH .img_wrapperteam").stop().animate({width: 185, height: 175}, {duration:250});   
        $(".teambox").not(this).stop().animate({'width': 215, 'height':nekikur2+30}, {duration:250});
        $('.inactiveBH').removeClass('inactiveBH');
      }
    );
    var hei = $('.pageposttitle').height() + $('.pagepostsub').height();
    $('.pcontent').css({'height' : (380 - hei) + 'px'}, function() {}).jScrollPane();

                
		// Fade in images so there isn't a color "pop" document load and then on window load
		$(".imghBX").fadeIn(500);
		
		// clone image
		$('.imghBXhome').each(function(){
			var el = jQuery(this);
			el.css({"position":"absolute"}).wrap("<div class='img_wrapperhome' style=''>").clone().addClass('img_grayscalehome').css({"position":"absolute","z-index":"20","opacity":"0", "left" : "0"}).insertBefore(el).queue(function(){
				var el = jQuery(this);
                                
				el.dequeue();
			});
			this.src = grayscale(this.src);
                        
		});
		$('.imghBX').each(function(){
			var el = jQuery(this);
			el.css({"position":"absolute"}).wrap("<div class='img_wrapper' style=''>").clone().addClass('img_grayscale').css({"position":"absolute","z-index":"20","opacity":"0", "left" : "0"}).insertBefore(el).queue(function(){
				var el = jQuery(this);
                                
				el.dequeue();
			});
			this.src = grayscale(this.src);
                        
		});
		$('.imghBXinner').each(function(){
			var el = jQuery(this);
			el.css({"position":"absolute"}).wrap("<div class='img_wrapperi' style=''>").clone().addClass('img_grayscale').css({"position":"absolute","z-index":"20","opacity":"0"}).insertBefore(el).queue(function(){
				var el = jQuery(this);
                                
				el.dequeue();
			});
			this.src = grayscale(this.src);
		});
		$('.imghBXteam').each(function(){
			var el = jQuery(this);
			el.css({"position":"absolute"}).wrap("<div class='img_wrapperteam' style=''>").clone().addClass('img_grayscaleteam').css({"position":"absolute","z-index":"20","opacity":"0"}).insertBefore(el).queue(function(){
				var el = jQuery(this);
                                
				el.dequeue();
			});
			this.src = grayscale(this.src);
		});
                var sizeofbw = $('.img_grayscalehome').size();
                flashhomepage(sizeofbw, 0);
    });

  });
})(jQuery);

	function grayscale(src){
		var canvas = document.createElement('canvas');
		var ctx = canvas.getContext('2d');
		var imgObj = new Image();
		imgObj.src = src;
		canvas.width = 240;
		canvas.height = 175; 
		ctx.drawImage(imgObj, 0, 0); 
		var imgPixels = ctx.getImageData(0, 0, canvas.width, canvas.height);
		for(var y = 0; y < imgPixels.height; y++){
			for(var x = 0; x < imgPixels.width; x++){
				var i = (y * 4) * imgPixels.width + x * 4;
				var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
				imgPixels.data[i] = avg; 
				imgPixels.data[i + 1] = avg; 
				imgPixels.data[i + 2] = avg;
			}
		}
		ctx.putImageData(imgPixels, 0, 0, 0, 0, 240, 175);
		return canvas.toDataURL();
    }
        
