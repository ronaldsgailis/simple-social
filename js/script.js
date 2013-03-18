jQuery(function($) {
	"use strict";
	$(function () {

        //detect mobile
        var is_mobile = false;
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
            is_mobile = true;
        }
        
		//on desktop browser open social shares in popup
        $('.social a').click(function(event){
            //
            if(!is_mobile) {
                event.preventDefault();
                var anchor = $(this);
                window.open(anchor.attr('href')+"&display=popup", anchor.text(),'width=600,height=400');
            }
        });
	});
});