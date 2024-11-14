/*Set Flow Start */
var shopify_flowdata = getCookie('_shopify_flow');
if(shopify_flowdata == "")
{
    var expire = new Date();
    expire.setDate(expire.getDate() + 0.2 * 24 * 60 * 60 * 1000);
    jQuery.cookie("_shopify_flow", "ringfirst", {
     path: '/',
     expires: expire
    });
}

if(shopify_flowdata == "ringfirst")
{
    // $.cookie("_shopify_diamondsetting", '', {
    //     path: '/',
    //     expires: -1
    // });
}

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
    url: baseurl + 'ringbuilder/settings',
    data: {checkdiamondcookie:checkdiamondcookiedata},
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