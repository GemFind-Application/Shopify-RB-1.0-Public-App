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

jQuery(document).ready(function($) {
    /*if(checkringcookiedata == "")
    {
        window.location.href= finalshopurl+"/settings";
    }
    else
    {
        $.ajax({
            url: baseurl + 'ringbuilder/diamondtools/loadproduct',
            data: {checkringcookie:checkringcookiedata,shop:shopurl,pathprefixshop:pathprefixshop,diamond_path:diamondpath, final_shop_url:finalshopurl,is_lab_settings:islabsettings,diamond_type:diamondType},
            type: 'POST',
            //dataType: 'json',
            cache: true,
            beforeSend: function(settings) {
                $('.loading-mask.gemfind-loading-mask').css('display', 'block');
            },
            success: function(response) {
                $('#diamonds-product-view').html(response);
                $("#search-diamonds-form #submit").trigger("click");
                $('.loading-mask.gemfind-loading-mask').css('display', 'none');
            },
            error: function(xhr, status, errorThrown) {
                console.log('Error happens. Try again.');
                console.log(errorThrown);
            }
        });
    }*/
    
    $.ajax({
        url: baseurl + 'ringbuilder/diamondtools/loadproduct',
        data: {checkringcookie:checkringcookiedata,shop:shopurl,pathprefixshop:pathprefixshop,diamond_path:diamondpath, final_shop_url:finalshopurl,is_lab_settings:islabsettings,diamond_type:diamondType},
        type: 'POST',
        //dataType: 'json',
        cache: true,
        beforeSend: function(settings) {
            $('.loading-mask.gemfind-loading-mask').css('display', 'block');
        },
        success: function(response) {
            $('#diamonds-product-view').html(response);
            $("#search-diamonds-form #submit").trigger("click");
            $('.loading-mask.gemfind-loading-mask').css('display', 'none');
        },
        error: function(xhr, status, errorThrown) {
            console.log('Error happens. Try again.');
            console.log(errorThrown);
        }
    });
});