/**
	Please note:
	This script was written by bebel.
	You can use it for your non commercial procjects.
    However, for commercial use, you have to get in contact with us first: http://thebebel.com
    (commercial use includes themeforest.)

	This script is an easy to use navigation script. see default options to know how to use it.
    enhances css script.

*/
(function($){

	$.fn.bnav = function(options) {

    if($(this).css('display') != "block") {
        $(this).find('li ul').hide();
    

        $(this).find('li ul').parent().hover(
          function () {

            $first_element = $(this).find('ul:first');


            $height = $first_element.height();
            $height = $height + 22;
            $first_element.css('top', '-'+$height+'px');  
            $first_element.css('zIndex', '20000');  
            $first_element.stop(true, true).fadeIn();

          },
          function () {

            $first_element.css('zIndex', '0');  
            $(this).find('ul:first').stop(true, true).hide();
          }

        );
    }
	}
})(jQuery);