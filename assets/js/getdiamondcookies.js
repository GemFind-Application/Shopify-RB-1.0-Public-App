 /*Set Flow Start */
var shopify_flowdata = getCookie('_shopify_flow');
if(shopify_flowdata == "")
{
    var expire = new Date();
    expire.setDate(expire.getDate() + 0.2 * 24 * 60 * 60 * 1000);
    jQuery.cookie("_shopify_flow", "diamondfirst", {
     path: '/',
     expires: expire
    });
}

 $.cookie("_shopify_diamondsetting", '', {
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

var checkringcookiedata = getCookie('_shopify_ringsetting');
var islabsettings = getCookie('_islabsettingurl');

$.ajax({
    url: baseurl + 'ringbuilder/diamondtools/loadnav',
    data: {checkringcookie:checkringcookiedata,final_shop_url:finalshopurl,is_lab_settings:islabsettings},
    type: 'POST',
    //dataType: 'json',
    cache: true,
    beforeSend: function(settings) {
        //$('.loading-mask.gemfind-loading-mask').css('display', 'block');
    },
    success: function(response) {
        jQuery('#search-diamonds .tab-section').html(response);
        //$('.loading-mask.gemfind-loading-mask').css('display', 'block');
    },
    error: function(xhr, status, errorThrown) {
        console.log('Error happens. Try again.');
        console.log(errorThrown);
    }
});
