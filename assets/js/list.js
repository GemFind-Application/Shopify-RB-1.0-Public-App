$(document).ready(function() {
    diamondmain();
});

$(window).bind("load", function() {
        jQuery('.testSelAll.SumoUnder').insertAfter(".sumo_diamond_certificates .CaptionCont.SelectBox");
        jQuery('.SlectBox.SumoUnder').insertAfter(".sumo_gemfind_diamond_origin .CaptionCont.SelectBox");
});

function diamondmain($){
        jQuery.noConflict();
        var $searchModule = jQuery('#search-diamonds');
        //console.log(jQuery('#search-diamonds-form #baseurl').val());

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

        var filtermode =  jQuery('#search-diamonds-form #filtermode').val();
        
        var backvaluecookie = getCookie('shopifysavebackvalue');
        var ringsettingcookie = getCookie('_shopify_ringsetting');
        var checkringcookiedata = getCookie('_shopify_ringsetting');

        //console.log(backvaluecookie);
        
        if(filtermode == 'navstandard'){
            var backvaluecookie = getCookie('shopifysavebackvalue');    
        }else if(filtermode == 'navfancycolored'){
            var backvaluecookie = getCookie('shopifysavebackvaluefancy'); 
        }else{
            var backvaluecookie = getCookie('shopifysavebackvaluelabgrown');
        }

        if(filtermode == 'navfancycolored'){
          var diamondcookiedata = getCookie('savefiltercookiefancy');  
        }else if(filtermode == 'navlabgrown'){
          var diamondcookiedata = getCookie('savefiltercookielabgrown');  
        }else if(filtermode == 'navstandard'){
          var diamondcookiedata = getCookie('shopifysavefiltercookie');  
        }else{
          var diamondcookiedata = '';
        }
        //console.log("diamondcookiedata- "+diamondcookiedata);
        
        var searchdiamondform = jQuery('#search-diamonds-form').serialize();
        
        var islabsettings = getCookie('_islabsettingurl');

        jQuery.ajax({
            url: jQuery('#search-diamonds-form #baseurl').val()+'ringbuilder/diamondtools/loadfilter',
            data: {savedfilter:diamondcookiedata,searchformdata:searchdiamondform,savebackvalue:backvaluecookie,ringsetting:ringsettingcookie,checkringcookie:checkringcookiedata,is_lab_settings:islabsettings},
            type: 'POST',
            //dataType: 'json',
            cache: true,
            beforeSend: function(settings) {
                //jQuery('.loading-mask.gemfind-loading-mask').css('display', 'block');
            },
            success: function(response) {
				jQuery('.diamond-filter-title').show();
                jQuery('#filter-main-div').html(response);
                jQuery("#search-diamonds-form #submit").trigger("click");
                jQuery('button.accordion').click(function(e) {
                    e.preventDefault();
                    jQuery('button.accordion').toggleClass("active");
                    jQuery('.filter-advanced .panel').css('max-height', '383px');
                    jQuery('.filter-advanced .panel').toggleClass('cls-for-hide');
                });
               
                /*if(jQuery('#filtermode').val() != 'navlabgrown'){*/
                    
                    jQuery('.certificate-div p.select-all').click(function(){
                        
                        if(jQuery('.certificate-div p.select-all').hasClass('partial') && jQuery('.certificate-div p.select-all').hasClass('selected')){
                            jQuery('.certificate-div .selall ul.options li.selected').each(function(){
                                jQuery(this).trigger('click');
                            });    
                            jQuery('.certificate-div .selall ul.options li').each(function(){
                                    jQuery(this).trigger('click');
                            });
                        } else if(!jQuery('.certificate-div p.select-all').hasClass('partial') && jQuery('.certificate-div p.select-all').hasClass('selected')){
                            jQuery('.certificate-div .selall ul.options li').each(function(){
                                jQuery(this).trigger('click');
                            });
                        } else if(jQuery('.certificate-div p.select-all').hasClass('partial') && !jQuery('.certificate-div p.select-all').hasClass('selected')){                        
                            jQuery('.certificate-div .selall ul.options li.selected').each(function(){
                                jQuery(this).trigger('click');
                            });    
                            jQuery('.certificate-div .selall ul.options li').each(function(){
                                    jQuery(this).trigger('click');
                            });
                        } else {
                        jQuery('.certificate-div .selall ul.options li').each(function(){
                            jQuery(this).trigger('click');
                        });
                        }
                    });

                    //carat slider
                    var carat_slider = jQuery("#noui_carat_slider")[0];
                    //var carat_slider = document.getElementById('noui_carat_slider');
                    var $carat_min_input = jQuery(carat_slider).find("input[data-type='min']");
                    var $carat_max_input = jQuery(carat_slider).find("input[data-type='max']");

                    var $carat_min_val = parseFloat(jQuery(carat_slider).attr('data-min'))
                    var $carat_max_val = parseFloat(jQuery(carat_slider).attr('data-max'));
                    
                    var $start_carat_min = parseFloat($carat_min_input.val());
                    var $start_carat_max = parseFloat($carat_max_input.val());

                    var carat_slider_object = noUiSlider.create(carat_slider, {
                        start: [$start_carat_min, $start_carat_max],
                        //tooltips: [true, wNumb({decimals: 2})],
                        connect: true,
                        step: 0.01,
                        range: {
                            'min': $carat_min_val,
                            'max': $carat_max_val
                        },
                        format: wNumb({
                            decimals: 2,
                            prefix: '',
                            thousand: '',
                        })
                    });
                    carat_slider.noUiSlider.on('update', function( values, handle ) {
                        var carat_value_show = values[handle];
                        if ( handle ) {
                            $carat_max_input.val(carat_value_show);
                        } else {
                            $carat_min_input.val(carat_value_show);
                        }
                    });

                    var $carat_input1 = jQuery(carat_slider).find("input.slider-left");
                    var $carat_input2 = jQuery(carat_slider).find("input.slider-right");
                    var carat_inputs = [$carat_input1, $carat_input2];
                    slider_update_textbox(carat_inputs,carat_slider);

                    carat_slider.noUiSlider.on('change', function( values, handle ) {
                        jQuery("#search-diamonds-form #submit").trigger("click");
                    });

                    //Price slider
                    var price_slider = jQuery("#price_slider")[0];

                    if(price_slider){
                        var $price_min_input = jQuery(price_slider).find("input[data-type='min']");
                        var $price_max_input = jQuery(price_slider).find("input[data-type='max']");

                        var $price_min_val = parseFloat(jQuery(price_slider).attr('data-min'))
                        var $price_max_val = parseFloat(jQuery(price_slider).attr('data-max'));

                        var $start_price_min = parseFloat($price_min_input.val());
                        var $start_price_max = parseFloat($price_max_input.val());

                        var first_half_interval = 1;
                        var last_half_interval = 2500;
                        
                        if( $price_min_val > 10000 ){
                            var range = {
                                'min': [$price_min_val, first_half_interval],
                                'max': [$price_max_val]
                            }
                        } else {
                            var range = {
                                'min': [$price_min_val, first_half_interval],                    
                                'max': [$price_max_val]
                            }
                        }

                        var price_slider_object = noUiSlider.create(price_slider, {
                            start: [$start_price_min, $start_price_max],
                            //tooltips: [true, wNumb({decimals: 2})],
                            connect: true,
                            step: 1,
                            range: range,
                            format: wNumb({
                                decimals: 0,
                                prefix: '',
                                thousand: ',',
                            })
                        });

                        price_slider.noUiSlider.on('update', function( values, handle ) {
                            var price_value_show = values[handle];
                            if ( handle ) {
                                $price_max_input.val(price_value_show);
                            } else {
                                $price_min_input.val(price_value_show);
                            }
                        });

                        var $price_input1 = jQuery(price_slider).find("input.slider-left");
                        var $price_input2 = jQuery(price_slider).find("input.slider-right");
                        var price_inputs = [$price_input1, $price_input2];
                        slider_update_textbox(price_inputs,price_slider);

                        price_slider.noUiSlider.on('change', function( values, handle ) {
                            jQuery("#search-diamonds-form #submit").trigger("click");
                        });
                    }

                    // depth slider 
                    var depth_slider = jQuery("#depth_slider")[0];
                    var $depth_min_input = jQuery(depth_slider).find("input[data-type='min']");
                    var $depth_max_input = jQuery(depth_slider).find("input[data-type='max']");

                    var $depth_min_val = parseFloat(jQuery(depth_slider).attr('data-min'))
                    var $depth_max_val = parseFloat(jQuery(depth_slider).attr('data-max'));

                    var $start_depth_min = parseFloat($depth_min_input.val());
                    var $start_depth_max = parseFloat($depth_max_input.val());

                    var depth_slider_object = noUiSlider.create(depth_slider, {
                        start: [$start_depth_min, $start_depth_max],
                        //tooltips: [true, wNumb({decimals: 2})],
                        connect: true,
                        step: 1,
                        range: {
                            'min': $depth_min_val,
                            'max': $depth_max_val
                        },
                        format: wNumb({
                            decimals: 0,
                            prefix: '',
                            thousand: '',
                        })
                    });

                    depth_slider.noUiSlider.on('update', function( values, handle ) {
                        var depth_value_show = values[handle];
                        if ( handle ) {
                            $depth_max_input.val(depth_value_show);
                        } else {
                            $depth_min_input.val(depth_value_show);
                        }
                    });

                    
                    var $depth_input1 = jQuery(depth_slider).find("input.slider-left");
                    var $depth_input2 = jQuery(depth_slider).find("input.slider-right");
                    var depth_inputs = [$depth_input1, $depth_input2];
                    slider_update_textbox(depth_inputs,depth_slider);

                    depth_slider.noUiSlider.on('change', function( values, handle ) {
                        jQuery("#search-diamonds-form #submit").trigger("click");
                    });
                    
                    var table_slider = jQuery("#tableper_slider")[0];
                    var $table_min_input = jQuery(table_slider).find("input[data-type='min']");
                    var $table_max_input = jQuery(table_slider).find("input[data-type='max']");

                    var $table_min_val = parseFloat(jQuery(table_slider).attr('data-min'))
                    var $table_max_val = parseFloat(jQuery(table_slider).attr('data-max'));

                    var $start_table_min = parseFloat($table_min_input.val());
                    var $start_table_max = parseFloat($table_max_input.val());

                    var table_slider_object = noUiSlider.create(table_slider, {
                        start: [$start_table_min, $start_table_max],
                        //tooltips: [true, wNumb({decimals: 2})],
                        connect: true,
                        step: 1,
                        range: {
                            'min': $table_min_val,
                            'max': $table_max_val
                        },
                        format: wNumb({
                            decimals: 0,
                            prefix: '',
                            thousand: '',
                        })
                    });

                    table_slider.noUiSlider.on('update', function( values, handle ) {
                        var table_value_show = values[handle];
                        if ( handle ) {
                            $table_max_input.val(table_value_show);
                        } else {
                            $table_min_input.val(table_value_show);
                        }
                    });


                    var $table_input1 = jQuery(table_slider).find("input.slider-left");
                    var $table_input2 = jQuery(table_slider).find("input.slider-right");
                    var table_inputs = [$table_input1, $table_input2];
                    slider_update_textbox(table_inputs,table_slider);

                    table_slider.noUiSlider.on('change', function( values, handle ) {
                        jQuery("#search-diamonds-form #submit").trigger("click");
                    });

                jQuery('input:checkbox').change(function() {
                if(jQuery(this).attr('name') == 'diamond_fancycolor[]'){
                        jQuery.ajax({
                            url: jQuery('#search-diamonds-form #baseurl').val()+'ringbuilder/diamondtools/loadshape',
                            data: jQuery('#search-diamonds-form').serialize(),
                            type: 'POST',
                            dataType: 'json',
                            //cache: true,
                            beforeSend: function(settings) {
                                //jQuery('.loading-mask.gemfind-loading-mask').css('display', 'block');
                            },
                            success: function(response) {
                                jQuery('ul#shapeul li').css('display','none')
                                jQuery.each(response.shapes, function(key,value) {
                                  jQuery('li.'+value).css('display','block');
                                }); 
                            }
                        });
                    }
                // if (jQuery(this).is(':checked')) {
                //     jQuery(this).parent().addClass('selected active');
                //     jQuery("#search-diamonds-form #submit").trigger("click");
                // } else {
                //     jQuery(this).parent().removeClass('selected active');
                //     jQuery("#search-diamonds-form #submit").trigger("click");
                // }
                  if (jQuery(this).is(':checked')) {
                    jQuery("#inintfilter").val(0);
                    jQuery(this).parent().addClass('selected active');
                    jQuery("#search-diamonds-form #submit").trigger("click");
                } else {
                    if (jQuery('input:checkbox:checked').length < 1) {
                        jQuery("#inintfilter").val(1);
                    }
                    if(jQuery(this).parent().hasClass('selected')){
                        jQuery(this).parent().removeClass('selected active');
                        jQuery("#search-diamonds-form #submit").trigger("click");
                    }else{
                      jQuery("#search-diamonds-form #submit").trigger("click");
                     }
                   
                }
        });

        if(jQuery("#filtermode").val() == 'navfancycolored'){
            var element =  document.getElementById("navfancycolored");
            if (typeof(element) != 'undefined' && element != null){
                document.getElementById("navfancycolored").className = "active";                
            }
            if (typeof(document.getElementById("navstandard")) != 'undefined' && document.getElementById("navstandard") != null){
                document.getElementById("navstandard").className = "";           
            }
            if (typeof(document.getElementById("navlabgrown")) != 'undefined' && document.getElementById("navlabgrown") != null){
                document.getElementById("navlabgrown").className = "";             
            }
            
        } else if(jQuery("#filtermode").val() == 'navlabgrown'){
            var element =  document.getElementById("navlabgrown");
            if (typeof(element) != 'undefined' && element != null){
                document.getElementById("navlabgrown").className = "active";                
            }
            if (typeof(document.getElementById("navstandard")) != 'undefined' && document.getElementById("navstandard") != null){
                document.getElementById("navstandard").className = "";
            }
            if (typeof(document.getElementById("navfancycolored")) != 'undefined' && document.getElementById("navfancycolored") != null){
                document.getElementById("navfancycolored").className = "";    
            }
        } else {
            var element =  document.getElementById("navstandard");
            if (typeof(element) != 'undefined' && element != null){
                document.getElementById("navstandard").className = "active";                
            }
            if (typeof(document.getElementById("navfancycolored")) != 'undefined' && document.getElementById("navfancycolored") != null){
                document.getElementById("navfancycolored").className = "";
            }
            if (typeof(document.getElementById("navlabgrown")) != 'undefined' && document.getElementById("navlabgrown") != null){
                document.getElementById("navlabgrown").className = "";   
            }            
        }
               
                
    },
    error: function(xhr, status, errorThrown) {
        console.log('Error happens. Try again.');
        console.log(errorThrown);
        }
    });


}

function SaveFilter() {
        jQuery('.loading-mask.gemfind-loading-mask').css('display', 'block');
        var shapeCheckboxes = jQuery("input[name='diamond_shape[]']");
        var shapeList = [];
        shapeCheckboxes.each(function() {
            if (this.checked === true) {
                shapeList.push(jQuery(this).val());
            }
        });
        /*Cut*/
        var element = ".diamond_cut";
        var diamondCut = "";
        var cutStart = "";
        var cutStop = "";
        if( jQuery(element).length ){
            var cutCheckboxes = jQuery("input[name='diamond_cut']");
            var diamondCut = jQuery(element).val();
            var cutStart = jQuery(element).attr("data-start");
            var cutStop = jQuery(element).attr("data-stop");
        }

        /*Clarity*/
        var element = ".diamond_clarity";
        var diamondClarity = "";
        var ClarityStart = "";
        var ClarityStop = "";
        if( jQuery(element).length ){
            var cutCheckboxes = jQuery("input[name='diamond_clarity']");
            var diamondClarity = jQuery(element).val();
            var ClarityStart = jQuery(element).attr("data-start");
            var ClarityStop = jQuery(element).attr("data-stop");
        }

        /*diamond_fancycolor*/
        var element = ".diamond_diamondcolor";
        var diamondFancycolor = "";
        var FancycolorStart = "";
        var FancycolorStop = "";
        if( jQuery(element).length ){
            var cutCheckboxes = jQuery("input[name='diamond_fancycolor']");
            var diamondFancycolor = jQuery(element).val();
            var FancycolorStart = jQuery(element).attr("data-start");
            var FancycolorStop = jQuery(element).attr("data-stop");
        }
       
        /*Mined Color*/
        var element = ".diamond_color";
        var ColorList = "";
        var ColorStart = "";
        var ColorStop = "";
        if( jQuery(element).length ){
            var cutCheckboxes = jQuery("input[name='diamond_color']");
            var ColorList = jQuery(element).val();
            var ColorStart = jQuery(element).attr("data-start");
            var ColorStop = jQuery(element).attr("data-stop");
        }

        /*Polish List*/
        var element = ".diamond_polish";
        var PolishList = "";
        var PolishStart = "";
        var PolishStop = "";
        if( jQuery(element).length ){
            var cutCheckboxes = jQuery("input[name='diamond_polish']");
            var PolishList = jQuery(element).val();
            var PolishStart = jQuery(element).attr("data-start");
            var PolishStop = jQuery(element).attr("data-stop");
        }

        /*Fluorescence List*/
        var element = ".diamond_fluorescence";
        var FluorescenceList = "";
        var FluorescenceStart = "";
        var FluorescenceStop = "";
        if( jQuery(element).length ){
            var cutCheckboxes = jQuery("input[name='diamond_fluorescence']");
            var FluorescenceList = jQuery(element).val();
            var FluorescenceStart = jQuery(element).attr("data-start");
            var FluorescenceStop = jQuery(element).attr("data-stop");
        }

        /*Fluorescence List*/
        var element = ".diamond_symmetry";
        var SymmetryList = "";
        var SymmetryStart = "";
        var SymmetryStop = "";
        if( jQuery(element).length ){
            var cutCheckboxes = jQuery("input[name='diamond_symmetry']");
            var SymmetryList = jQuery(element).val();
            var SymmetryStart = jQuery(element).attr("data-start");
            var SymmetryStop = jQuery(element).attr("data-stop");
        }

       /*FANCY INTENSITY List*/
        var element = ".diamond_intensity";
        var IntintensityList = "";
        var IntintensityStart = "";
        var IntintensityStop = "";
        if( jQuery(element).length ){
            var cutCheckboxes = jQuery("input[name='diamond_intintensity']");
            var IntintensityList = jQuery(element).val();
            var IntintensityStart = jQuery(element).attr("data-start");
            var IntintensityStop = jQuery(element).attr("data-stop");
        }

        var certiCheckboxes = jQuery("select#certi-dropdown");
        var certificatelist = [];
        certificatelist.push(jQuery(certiCheckboxes).val());
        var caratMin = jQuery("div#noui_carat_slider input.slider-left").val();
        var caratMax = jQuery("div#noui_carat_slider input.slider-right").val();
        var PriceMin = jQuery("div#price_slider input.slider-left").val();
        var PriceMax = jQuery("div#price_slider input.slider-right").val();
        var depthMin = jQuery("div#depth_slider input.slider-left").val();
        var depthMax = jQuery("div#depth_slider input.slider-right").val();
        var tableMin = jQuery("div#tableper_slider input.slider-left").val();
        var tableMax = jQuery("div#tableper_slider input.slider-right").val();
        var SOrigin = jQuery("select#gemfind_diamond_origin").val();
        var orderBy = jQuery("input#orderby").val();
        var direction = jQuery("input#direction").val();
        var currentPage = jQuery("input#currentpage").val();
        var itemperpage = jQuery("input#itemperpage").val();
        var viewMode = jQuery("input#viewmode").val();
        var filtermode = jQuery("input#filtermode").val();
        var did = jQuery("input#did").val();
        var formdata = {
            'shapeList': shapeList.toString(),
            'caratMin': caratMin,
            'caratMax': caratMax,
            'PriceMin': PriceMin,
            'PriceMax': PriceMax,
            'certificate': certificatelist.toString(),
            'SymmetryList': SymmetryList.toString(),
            'polishList': PolishList.toString(),
            'depthMin': depthMin,
            'depthMax': depthMax,
            'tableMin': tableMin,
            'tableMax': tableMax,
            'FluorescenceList': FluorescenceList.toString(),
            'FluorescenceStart': FluorescenceStart,
            'FluorescenceStop': FluorescenceStop,
            'CutGradeList': diamondCut.toString(),
            'CutStart': cutStart,
            'CutStop': cutStop,
            'ClarityList': diamondClarity.toString(),
            'ClarityStart': ClarityStart,
            'ClarityStop': ClarityStop,
            'FancycolorList': diamondFancycolor.toString(),
            'FancycolorStart': FancycolorStart,
            'FancycolorStop': FancycolorStop,
            'ColorList': ColorList.toString(),
            'ColorStart': ColorStart,
            'ColorStop': ColorStop,
            'IntintensityList': IntintensityList.toString(),
            'IntintensityStart': IntintensityStart,
            'IntintensityStop': IntintensityStop,
            'SymmetryList': SymmetryList.toString(),
            'SymmetryStart': SymmetryStart,
            'SymmetryStop': SymmetryStop,
            'polishList': PolishList.toString(),
            'PolishStart': PolishStart,
            'PolishStop': PolishStop,
            'Filtermode': filtermode,
            'SOrigin': SOrigin,
            'currentPage': currentPage,
            'orderBy': orderBy,
            'direction': direction,
            'viewmode': viewMode,
            'itemperpage': itemperpage,
            'did': did,
        };
        var expire = new Date();
        var data="";
        expire.setDate(expire.getDate() + 10 * 24 * 60 * 60 * 1000);
        if(filtermode == 'navfancycolored'){
            data = jQuery.cookie("savefiltercookiefancy", JSON.stringify(formdata), {
                path: '/',
                expires: expire
            });
        } else if(filtermode == 'navstandard') {
            jQuery.cookie("shopifysavefiltercookie", JSON.stringify(formdata), {
                path: '/',
                expires: expire
            });    
        } else {
            jQuery.cookie("savefiltercookielabgrown", JSON.stringify(formdata), {
                path: '/',
                expires: expire
            });  
        }
        //console.log(data);
        setTimeout(
            function() {
                jQuery('.loading-mask.gemfind-loading-mask').css('display', 'none');
            }, 1000);
}


function ResetBackCookieFilter() {
    
        jQuery.cookie("shopifysavebackvaluefancy", '', {
            path: '/',
            expires: -1
        });
        jQuery.cookie("shopifysavebackvalue", '', {
            path: '/',
            expires: -1
        });
        jQuery.cookie("shopifysavebackvaluelabgrown", '', {
            path: '/',
            expires: -1
        });
        window.location.reload();
    
}


function ResetFilter() {
    if(confirm("Are you sure you want to reset data?")){

        localStorage.removeItem("compareItemsrb");
        localStorage.removeItem("compareItemsrbClick");
    
        jQuery.cookie("shopifysavefiltercookie", '', {
            path: '/',
            expires: -1
        });
        jQuery.cookie("savefiltercookiefancy", '', {
            path: '/',
            expires: -1
        });
        jQuery.cookie("savefiltercookielabgrown", '', {
            path: '/',
            expires: -1
        });
        jQuery.cookie("shopifysavebackvaluefancy", '', {
            path: '/',
            expires: -1
        });
        jQuery.cookie("shopifysavebackvalue", '', {
            path: '/',
            expires: -1
        });
        jQuery.cookie("shopifysavebackvaluelabgrown", '', {
            path: '/',
            expires: -1
        });
        jQuery.cookie("comparediamondProductrb", '', {
            path: '/',
            expires: -1
        });
         jQuery.cookie("_shopify_ringsetting", '', {
            path: '/',
            expires: -1
        });
        jQuery.cookie("_shopify_diamondsetting", '', {
            path: '/',
            expires: -1
        });
        
        window.location.reload();
    }
    
}

function slider_update_textbox(slider_inputs,slidername){
    // Listen to keydown events on the input field.    
    slider_inputs.forEach(function (input, handle) {
        input.change(function () {
            var vals = parseFloat(this.value);
            if(this.name == "price[to]" || this.name == "price[from]")
            {
                //console.log(this.name);
                var vals = parseFloat(this.value.replace(/,/g, ''));
            }
            else
            {
                var vals = parseFloat(this.value);
            }
            if(handle){
                slidername.noUiSlider.set([null, vals]);
            } else {
                slidername.noUiSlider.set([vals, null]);
            }
            jQuery("#search-diamonds-form #submit").trigger("click");
            //console.log(vals);
        });  
        input.keyup(function (e) {
            var values = slidername.noUiSlider.get();
            var value = parseFloat(values[handle]);
            // [[handle0_down, handle0_up], [handle1_down, handle1_up]]
            var steps = slidername.noUiSlider.steps();
            // [down, up]
            var step = steps[handle];
            var position;
            // 13 is enter,
            // 38 is key up,
            // 40 is key down.
            switch (e.which) {

                case 13:
                var vals = parseFloat(this.value);
                if(this.name == "price[to]" || this.name == "price[from]")
                {
                    //console.log(this.name);
                    var vals = parseFloat(this.value.replace(/,/g, ''));
                }
                else
                {
                    var vals = parseFloat(this.value);
                }
                if(handle){
                    slidername.noUiSlider.set([null, vals]);
                } else {
                    slidername.noUiSlider.set([vals, null]);
                }                        
                jQuery("#search-diamonds-form #submit").trigger("click");
                break;

                case 38:
                position = step[1];
                    // false = no step is set
                    if (position === false) {
                        position = 1;
                    }
                    // null = edge of slider
                    if (position !== null) {
                        // console.log(value);
                        // console.log(typeof value);
                        // console.log(position);
                        var vals = parseInt(value + position);
                        if(handle){
                            slidername.noUiSlider.set([null, vals]);
                        } else {
                            slidername.noUiSlider.set([vals, null]);
                        }
                    }
                    jQuery("#search-diamonds-form #submit").trigger("click");
                    break;
                case 40:
                    position = step[0];
                    if (position === false) {
                        position = 1;
                    }

                    if (position !== null) {
                        var vals = parseFloat(value - position);
                        if(handle){
                            slidername.noUiSlider.set([null, vals]);
                        } else {
                            slidername.noUiSlider.set([vals, null]);
                        }                                
                    }
                    jQuery("#search-diamonds-form #submit").trigger("click");
                    break;
                }
        });
    });
}