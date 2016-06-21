/**
 * Code adapted by the1path.com originally by Chris Wharton
 */
(function ($) {
    $.cookieCuttr = function (options) {
        var defaults = {
			cookieAcceptButton: true,
            cookieMessage: text_before + '<a href="' + cookie_url + '">' + link_text + '</a>' + text_after,
            cookieExpires: 365,
            cookieAcceptButtonText: accept_text,
        };
        var options = $.extend(defaults, options);
        var message = defaults.cookieMessage;
		var cookieAcceptButton = options.cookieAcceptButton;
        var cookieMessage = message;
        var cookieExpires = options.cookieExpires;
        var cookieAcceptButtonText = options.cookieAcceptButtonText;
        var $cookieAccepted = $.cookie('cc_cookie_accept') == "cc_cookie_accept";
        $.cookieAccepted = function () {
            return $cookieAccepted;
        };
		
        if (cookieAcceptButton) {
            var cookieAccept = ' <a href="#accept" class="cc-cookie-accept"><span>&#10004; ' + cookieAcceptButtonText + '</span></a> ';
        } else {
            var cookieAccept = "";
        }
        
		if ($cookieAccepted) {
			//do nothing
		} else {
			$('body').append('<div class="cc-cookies"><div class="inner-cookie">' + cookieMessage + cookieAccept + '</div></div>');
		}
		
        $('.cc-cookie-accept').click(function (e) {
            e.preventDefault();
			$.cookie("cc_cookie_accept", "cc_cookie_accept", {
				expires: cookieExpires,
				path: '/'
			});
            $(".cc-cookies").fadeOut();
        });
    };
})(jQuery);