function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
var checkdnotfound = getCookie(cookie_indentifier);
if(checkdnotfound == '1'){
    jQuery(document).ready(function(){
        jQuery('.dnotfound').css('display','block');    
        $.cookie(cookie_indentifier, '', {
            path: '/',
            expires: -1
        });
    });
    jQuery(window).on('load', function() { 
        setTimeout(function () {
            jQuery('.dnotfound').fadeOut();  
        }, 6000);
    });
}
