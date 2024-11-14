jQuery(document).ready(function() {
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

var diamondcookiedata = getCookie('comparediamondProductrb');
var islabsettings = getCookie('_islabsettingurl');

// console.log(diamondcookiedata);

//if(diamondcookiedata){
jQuery.ajax({
            url: baseurl + 'ringbuilder/diamondtools/loadcompare',
            data: {comparediamondProductrb:diamondcookiedata,shop:shopurl,pathprefixshop:pathprefixshop,is_lab_settings:islabsettings},
            type: 'POST',
            beforeSend: function(settings) {
                jQuery('.loading-mask.gemfind-loading-mask').show();
            },
            success: function(response) {
              jQuery('.compare-info').html(response);
              jQuery('.loading-mask.gemfind-loading-mask').hide();
            },
            error: function(xhr, status, errorThrown) {
              console.log('Error happens. Try again.');
              console.log(errorThrown);
            }
        });
// }else{
//     nocompare = '<p class="no_compare">Kindly select the atleast two diamonds for compare from <a href="'+finalshopurl+'"> Diamond Search </a> Page.';
//     jQuery('.compare-info').html(nocompare);
// }
});