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
var ringcookiedata = getCookie('_shopify_ringsetting');
var diamondcookiedata = getCookie('_shopify_diamondsetting');
var islabsettings = getCookie('_islabsettingurl');

if(diamondcookiedata =='' || ringcookiedata =='' ){
    if(islabsettings == 1){
        var add_setting_url = 'islabsettings/1';
    }
window.location.replace(finalshopurl+ '/settings/');
}

jQuery(document).ready(function($) {
    $.ajax({
        url: baseurl + 'ringbuilder/diamondtools/loadcompletering',
        data: {ringcookie:ringcookiedata,diamondcookie:diamondcookiedata,shop:shopurl,pathprefixshop:pathprefixshop,final_shop_url:finalshopurl,is_lab_settings:islabsettings},
        type: 'POST',
        //dataType: 'json',
        cache: true,
        beforeSend: function(settings) {
            $('.loading-mask.gemfind-loading-mask').css('display', 'block');
        },
        success: function(response) {
            console.log('complete ring');
            $('#search-rings').html(response);
            $('.loading-mask.gemfind-loading-mask').css('display', 'none');
            
        },
        error: function(xhr, status, errorThrown) {
            console.log('Error happens. Try again.');
            console.log(errorThrown);
        }
    });
});