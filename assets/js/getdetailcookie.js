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
var checkdiamondcookiedata = getCookie('_shopify_diamondsetting');
       
$.ajax({
    url: baseurl + 'ringbuilder/settings/view',
    data: {checkdiamondcookie:checkdiamondcookiedata,tempvar:1},
    type: 'POST',
    //dataType: 'json',
    cache: true,
    beforeSend: function(settings) {
        $('.loading-mask.gemfind-loading-mask').css('display', 'block');
    },
    success: function(response) {
        console.log('response');
    },
    error: function(xhr, status, errorThrown) {
        console.log('Error happens. Try again.');
        console.log(errorThrown);
    }
});

$(document).ready(function() {
  
  createnav();
});

function createnav(){
    $.cookie("_shopify_ringsetting", '', {
            path: '/',
            expires: -1
        });

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

    var diamondsettingcookiedata = getCookie('_shopify_diamondsetting');
    var islabsettings = getCookie('_islabsettingurl');
    

    $.ajax({
        url:  baseurl + 'ringbuilder/settings/loadringproduct/',
        data: {diamondsettingcookie:diamondsettingcookiedata,shop:shopurl,baseshopurl:base_shop_url,pathprefixshop:pathprefixshop,ring_path:ringpath, final_shop_url:finalshopurl,is_lab_settings:islabsettings},
        type: 'POST',
        //dataType: 'json',
        cache: true,
        beforeSend: function(settings) {
            $('.loading-mask.gemfind-loading-mask').css('display', 'block');
        },
        success: function(response) {
            $('#search-rings').html(response);
            $('.loading-mask.gemfind-loading-mask').css('display', 'none');
        },
         error: function(xhr, status, errorThrown) {
            console.log('Error happens. Try again.');
            console.log(errorThrown);
        }
    });
}
