$(document).ready(function() {
  ringbuildermain();
  createnav();
});


function ringbuildermain() {


        var $searchModule = $('#search-rings');
        var searchringformdata = $('#search-rings-form').serialize();

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

        var ringbackvaluecookiedata = getCookie('_shopifysaveringbackvalue');
        var saveringfiltercookiedata = getCookie('_shopifysaveringfiltercookie');
        var ringsettingcookiedata = getCookie('_shopify_ringsetting');
        var diamondsettingcookiedata = getCookie('_shopify_diamondsetting');
		
		//get hidden values
		var pre_ring_collection = $('#pre_ring_collection').val();
		var pre_selected_shape = $('#pre_selected_shape').val();
		var pre_ring_metal = $('#pre_ring_metal').val();
		var pre_price_from = $('#pre_price_from').val();
		var pre_price_to = $('#pre_price_to').val(); 
        
        
        $.ajax({

            url: $('#search-rings-form #baseurl').val() + 'ringbuilder/settings/loadringfilter/',

            data: {searchringform: searchringformdata, ringbackvaluecookie: ringbackvaluecookiedata, saveringfiltercookie: saveringfiltercookiedata, ringsettingcookie: ringsettingcookiedata, diamondsettingcookie: diamondsettingcookiedata, ringcollection: pre_ring_collection, selectedShape:pre_selected_shape, selectedMetal: pre_ring_metal, priceFrom: pre_price_from, priceTo: pre_price_to},

            type: 'POST',

            //dataType: 'json',

            cache: true,

            beforeSend: function(settings) {

                //$('.loading-mask.gemfind-loading-mask').css('display', 'block');

            },

            success: function(response) {
                
                $('#filter-main-div').html(response);

                $("#search-rings-form #submit").trigger("click");

                // $('input:checkbox').change(function() {

                //     if ($(this).is(':checked')) {

                //         $('#shapeul li > div').removeClass('selected active');

                //         $("input:checkbox").attr("checked", false);

                //         $(this).attr("checked", true);
                        
                //         $(this).parent().addClass('selected active');

                //         $("#search-rings-form #submit").trigger("click");

                //     } else {

                //         $(this).parent().removeClass('selected active');

                //         $("#search-rings-form #submit").trigger("click");

                //     }

                // });

                $('input:checkbox').change(function() {
                    var isCookieSet = getCookie('_shopify_diamondsetting');

                   if (isCookieSet === "") { // Check if the cookie is not set
                        if ($(this).is(':checked')) {
                            console.log('IS checked');
                            $('#shapeul li > div').removeClass('selected active');
                            $('input:checkbox').not(this).prop('checked', false);
                            $(this).parent().addClass('selected active');
                            $("#search-rings-form #submit").trigger("click");   
                        } else {
                            console.log('IS Unchecked');
                            $(this).parent().removeClass('selected active');
                            $("#search-rings-form #submit").trigger("click");
                        }
                    }else{
                        if ($(this).is(':checked')) {
                            $('#shapeul li > div').removeClass('selected active');
                            $('input:checkbox').not(this).prop('checked', false);
                            $("#search-rings-form #submit").trigger("click");
                        } else {
                             $(this).parent().addClass('selected active'); 
                            $("#search-rings-form #submit").trigger("click");
                           
                        }

                    }
                    
                });

                var storeDealerid = $('#storeDealerid').val();
                console.log(storeDealerid);

                 //Price slider
                var price_slider = jQuery("#price_slider")[0];
                console.log("price_slider");
                console.log(price_slider);

                if(price_slider){


                    var $price_min_input = jQuery(price_slider).find("input[data-type='min']");
                    var $price_max_input = jQuery(price_slider).find("input[data-type='max']");

                    var $price_min_val = parseFloat(jQuery(price_slider).attr('data-min'))
                    var $price_max_val = parseFloat(jQuery(price_slider).attr('data-max'));

                    var $start_price_min = parseFloat($price_min_input.val());
                    var $start_price_max = parseFloat($price_max_input.val());

                    var first_half_interval = 200;
                    var last_half_interval = 2500;
                    
                    if( $price_min_val > 10000 ){
                        var range = {
                            'min': [$price_min_val, first_half_interval],
                            '50%': [10000, last_half_interval],
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
                            thousand: storeDealerid == 4311 ? '' : ',',
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
                        jQuery("#search-rings-form #submit").trigger("click");
                    });

                 }

                $('input[type=radio][name=ring_collection]').on('click', function() {

                    $self = $(this);

                    if ($self.hasClass('is-checked')) {

                        $self.prop('checked', false).removeClass('is-checked');

                        $(this).parent().removeClass('selected active');

                        $('#collections-section ul li').removeClass('selected active');

                        $("#search-rings-form #submit").trigger("click");

                    } else {

                        $('input[type=radio][name=ring_collection]').removeClass('is-checked');

                        $('#collections-section ul li').removeClass('selected active');

                        $self.addClass('is-checked');

                        $(this).parent().addClass('selected active');

                        $(this).parent().parent().addClass('selected active');

                        $("#search-rings-form #submit").trigger("click");

                    }

                });

                $('input[type=radio][name=ring_metal]').on('click', function() {

                    $self = $(this);

                    if ($self.hasClass('is-checked')) {

                        $self.prop('checked', false).removeClass('is-checked');

                        $(this).parent().removeClass('selected active');

                        $('.metaltypeli ul li').removeClass('selected active');

                        $("#search-rings-form #submit").trigger("click");

                    } else {

                        $('input[type=radio][name=ring_metal]').removeClass('is-checked');

                        $('.metaltypeli ul li').removeClass('selected active');

                        $self.addClass('is-checked');

                        $(this).parent().addClass('selected active');

                        $("#search-rings-form #submit").trigger("click");

                    }

                });

                $('#collections-section input[type=radio][name=ring_collection]').on('click', function() {

                    $.ajax({

                        url: $('#search-rings-form #baseurl').val() + 'ringbuilder/settings/updatefilter/',

                        data: $('#search-rings-form').serialize(),

                        type: 'POST',

                        //dataType: 'json',

                        cache: true,

                        success: function(response) {
       //                      var responseData = $.parseJSON(response);

       //                      $('.filter-for-shape ul li').css('opacity', 1);
							// $('.filter-for-shape ul li').css('pointer-events', 'auto');
							// if (responseData.hiddenshape) {
							// 	$(responseData.hiddenshape).css('opacity', 0.5);
							// 	$(responseData.hiddenshape).css('pointer-events', 'none');
							// }
							
							// $('#collections-section ul li').css('opacity', 1);
							// $('#collections-section ul li').css('pointer-events', 'auto');
							// if (responseData.hiddencollection) {
							// 	$(responseData.hiddencollection).css('opacity', 0.5);
							// 	$(responseData.hiddencollection).css('pointer-events', 'none');
							// 	$(responseData.hiddencollection).attr("checked", false);
							// }

							// $('.metaltypeli li').css('opacity', 1);
							// $('.metaltypeli li').css('pointer-events', 'auto');
							// if (responseData.hiddenmetaltype) {
							// 	$(responseData.hiddenmetaltype).css('opacity', 0.5);
							// 	$(responseData.hiddenmetaltype).css('pointer-events', 'none');
							// }

                            var responseData = jQuery.parseJSON(response);
                            jQuery('#collections-section ul li').css('opacity', 1);
                            jQuery('#collections-section ul li').css('pointer-events', 'auto');
                            jQuery('.metaltypeli li').css('opacity', 1);
                            jQuery('.metaltypeli li').css('pointer-events', 'auto');
                            if (responseData.hiddencollection) {
                                jQuery(responseData.hiddencollection).css('opacity', 0.5);
                                jQuery(responseData.hiddencollection).css('pointer-events', 'none');
                                jQuery(responseData.hiddencollection).attr("checked", false);
                            } 
                            if (responseData.hiddenmetaltype) {
                                jQuery(responseData.hiddenmetaltype).css('opacity', 0.5);
                                jQuery(responseData.hiddenmetaltype).css('pointer-events', 'none');
                                jQuery(responseData.hiddenmetaltype).attr("checked", false);
                            }

                        }

                    });

                });

                $('#shapeul input:checkbox').change(function() {

                    $.ajax({

                        url: $('#search-rings-form #baseurl').val() + 'ringbuilder/settings/updatefilter/',

                        data: $('#search-rings-form').serialize(),

                        type: 'POST',

                        //dataType: 'json',

                        cache: true,

                        success: function(response) {
                            //console.log(response);
       //                      var responseData = $.parseJSON(response);

       //                      $('.filter-for-shape ul li').css('opacity', 1);
							// $('.filter-for-shape ul li').css('pointer-events', 'auto');
							// if (responseData.hiddenshape) {
							// 	$(responseData.hiddenshape).css('opacity', 0.5);
							// 	$(responseData.hiddenshape).css('pointer-events', 'none');
							// }

							// $('#collections-section ul li').css('opacity', 1);
							// $('#collections-section ul li').css('pointer-events', 'auto');
							// if (responseData.hiddencollection) {
							// 	$(responseData.hiddencollection).css('opacity', 0.5);
							// 	$(responseData.hiddencollection).css('pointer-events', 'none');
							// 	$(responseData.hiddencollection).attr("checked", false);

							// }

							// $('.metaltypeli li').css('opacity', 1);
							// $('.metaltypeli li').css('pointer-events', 'auto');
							// if (responseData.hiddenmetaltype) {
							// 	$(responseData.hiddenmetaltype).css('opacity', 0.5);
							// 	$(responseData.hiddenmetaltype).css('pointer-events', 'none');
							// }
                            var responseData = jQuery.parseJSON(response);
                            jQuery('#collections-section ul li').css('opacity', 1);
                            jQuery('#collections-section ul li').css('pointer-events', 'auto');
                            jQuery('.metaltypeli li').css('opacity', 1);
                            jQuery('.metaltypeli li').css('pointer-events', 'auto');
                            if (responseData.hiddencollection) {
                                jQuery(responseData.hiddencollection).css('opacity', 0.5);
                                jQuery(responseData.hiddencollection).css('pointer-events', 'none');
                                jQuery(responseData.hiddencollection).attr("checked", false);
                            } 
                            if (responseData.hiddenmetaltype) {
                                jQuery(responseData.hiddenmetaltype).css('opacity', 0.5);
                                jQuery(responseData.hiddenmetaltype).css('pointer-events', 'none');
                            }

                        }

                    });

                });

                /*if ($('#price_slider').length){

                    new numberSlider('price', true);

                }*/
            },
            error: function(xhr, status, errorThrown) {

                console.log('Error happens. Try again.');

                console.log(errorThrown);

            }

        });

    //Custom Slider class
    /*var labelSlider = function($slider, $select) {



        var self = this;

        this.slider = $slider;

        this.select = $select;

        this.items = $select.children();

        this.qty = $select.children().length;

        this.width = 0;

        this.height = 0;

        this.start = $select.find('option:selected:first').index();

        this.end = $select.find('option:selected:last').index() + 1;

        this.slider.slider({

            min: 0,

            max: this.qty,

            range: true,

            values: [this.start, this.end],

            slide: function(e, ui) {

                if (ui.values[1] - ui.values[0] < 1)

                    return false;

            },

            change: function(e, ui) {

                for (var i = 0; i < self.qty; i++)

                    if (i >= ui.values[0] && i < ui.values[1]) {

                        self.items.eq(i).attr('selected', 'selected');

                    } else {

                        self.items.eq(i).removeAttr('selected');

                    }

            }

        }).touchit();

        var options = [];

        this.items.each(function() {

            options.push('<b>' + $(this).text() + '</b>')

        });

        this.width = 100 / options.length;

        this.slider.after('<div class="ui-slider-legend"><p class="first" style="width:' + this.width + '%;"><span style=""></span>' +

            options.join('</p><p style="width:' + this.width + '%;"><span style=""></span>') + '</p></div>');

    };

    var numberSlider = function(type, decimal) {

        decimal = decimal === undefined ? false : true;

        if (type == 'price') {

            var maxPrice = $('div.price-right input.slider-right-val').val();

            var rules = {

                price: [

                    [0, maxPrice, 1]

                ]

            };

        }


        var createArrayByRule = function(rule) {

            var a = [],

                b = [];

            for (var i = 0; i < rule.length; i++)

                for (var j = rule[i][0]; j <= rule[i][1]; j += rule[i][2])

                    a.push(j);

            for (var i = 0; i < a.length; i++)

                b.push(i * 10);

            return {

                trueValues: a,

                values: b

            };

        };



        var findNearest = function(includeLeft, includeRight, value, values) {



            var nearest = null,

                diff = null;

            for (var i = 0; i < values.length; i++) {

                if ((includeLeft && values[i] <= value) || (includeRight && values[i] >= value)) {

                    var newDiff = Math.abs(value - values[i]);

                    if (diff == null || newDiff < diff) {

                        nearest = values[i];

                        diff = newDiff;

                    }

                }

            }

            return nearest;

        };



        var getRealValue = function(sliderValue, tv, values, d) {



            for (var i = 0; i < values.length; i++) {

                if (d) {

                    if (Math.round(values[i] * 100) >= Math.round(sliderValue * 100))

                        return tv[i];

                } else {

                    if (values[i] >= sliderValue)

                        return tv[i];

                }

            }

            return 0;

        };



        var getFakeValue = function(inputValue, tv, values, d) {



            for (var i = 0; i < tv.length; i++) {

                if (d) {

                    if (Math.round(tv[i] * 100) >= Math.round(inputValue * 100))

                        return values[i];

                } else {

                    if (tv[i] >= inputValue)

                        return values[i];

                }

            }

            return 0;



        };



        var setRangeValues = function(side, value) {



            value = getFakeValue(value, arrayByRule.trueValues, arrayByRule.values, decimal);

            $slider.slider("values", side, value);

        };



        var arrayByRule = createArrayByRule(rules[type]),

            $slider = $("#" + type + "_slider"),

            $leftVal = $slider.find('.slider-left'),

            $rightVal = $slider.find('.slider-right'),

            rangeMin = parseFloat(rules[type][0][0]),

            rangeMax = parseFloat(rules[type][0][1]);



        $slider.slider({

            orientation: 'horizontal',

            range: true,

            min: arrayByRule.values[0],

            max: arrayByRule.values[arrayByRule.values.length - 1],

            values: [arrayByRule.values[0], arrayByRule.values[arrayByRule.values.length - 1]],

            slide: function(event, ui) {

                var includeLeft = event.keyCode != $.ui.keyCode.RIGHT,

                    includeRight = event.keyCode != $.ui.keyCode.LEFT,

                    value = findNearest(includeLeft, includeRight, ui.value, arrayByRule.values),

                    n = getRealValue(value, arrayByRule.trueValues, arrayByRule.values, decimal);



                if (ui.value == ui.values[0]) {

                    $slider.slider('values', 0, value);

                    decimal ? $leftVal.val(n.toFixed(2)) : $leftVal.val(n);

                } else {

                    $slider.slider('values', 1, value);

                    decimal ? $rightVal.val(n.toFixed(2)) : $rightVal.val(n);

                }

            },

            stop: function() {

                $("#search-rings-form #submit").trigger("click");

            },

            create: function(event, ui) {

                setRangeValues(0, $leftVal.val());

                setRangeValues(1, $rightVal.val());

            }



        }).addClass(type).touchit();



        $leftVal.on('keyup blur', function(e) {

            var v = this.value = this.value.replace(/[^0-9\.]/g, ''),

                currentRightValue = getRealValue($slider.slider('values', 1), arrayByRule.trueValues, arrayByRule.values, decimal);



            if ((e.type == 'keyup' && e.keyCode == 13) || e.type == 'blur') {

                if (v.length) {

                    if (v < rangeMin) {

                        setRangeValues(0, rangeMin);

                        this.value = rangeMin;

                    } else if (v > currentRightValue) {

                        setRangeValues(0, currentRightValue);

                        this.value = currentRightValue;

                    } else {

                        setRangeValues(0, v);

                    }

                } else {

                    setRangeValues(0, rangeMin);

                    this.value = rangeMin;

                }

                $("#search-rings-form #submit").trigger("click");

            }



        });



        $rightVal.on('keyup blur', function(e) {

            var v = this.value = this.value.replace(/[^0-9\.]/g, ''),

                currentLeftValue = getRealValue($slider.slider('values', 0), arrayByRule.trueValues, arrayByRule.values, decimal);



            if ((e.type == 'keyup' && e.keyCode == 13) || e.type == 'blur') {

                if (v.length) {

                    if (v > rangeMax) {

                        setRangeValues(1, rangeMax);

                        this.value = rangeMax;

                    } else if (v < currentLeftValue) {

                        setRangeValues(1, currentLeftValue);

                        this.value = currentLeftValue;

                    } else {

                        setRangeValues(1, v);

                    }

                } else {

                    setRangeValues(1, rangeMax);

                    this.value = rangeMax;

                }

                $("#search-rings-form #submit").trigger("click");

            }



        });

    };



    $(window).keydown(function(event) {

        if (event.keyCode == 13)

            return false;

    });*/



//If search module container exists hook slider to DOM

/*if ($searchModule.length) {

    if ($('#price_slider').length)

        new numberSlider('price', true);

    $searchModule.find('.ui-slider-handle:even').addClass('left-handle');

    $searchModule.find('.ui-slider-handle:odd').addClass('right-handle');

}*/
}

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
        url: $('#search-rings-form #baseurl').val() + 'ringbuilder/settings/loadnav/',
        data: {diamondsettingcookie:diamondsettingcookiedata,finalshopurl:finalshopurl,is_lab_settings:islabsettings},
        type: 'POST',
        //dataType: 'json',
        cache: true,
        beforeSend: function(settings) {
            //$('.loading-mask.gemfind-loading-mask').css('display', 'block');
        },
        success: function(response) {
            
            $('#search-rings .tab-section').html(response);
        },
         error: function(xhr, status, errorThrown) {
            console.log('Error happens. Try again.');
            console.log(errorThrown);
        }
    });
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
            jQuery("#search-rings-form #submit").trigger("click");
        });           
        /*input.keyup(function (e) {
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
                if(handle){
                    slidername.noUiSlider.set([null, vals]);
                } else {
                    slidername.noUiSlider.set([vals, null]);
                }                        
                jQuery("#search-rings-form #submit").trigger("click");
                break;

                case 38:
                position = step[1];
                    // false = no step is set
                    if (position === false) {
                        position = 1;
                    }
                    // null = edge of slider
                    if (position !== null) {
                        console.log(value);
                        console.log(typeof value);
                        console.log(position);
                        var vals = parseInt(value + position);
                        if(handle){
                            slidername.noUiSlider.set([null, vals]);
                        } else {
                            slidername.noUiSlider.set([vals, null]);
                        }
                    }
                    jQuery("#search-rings-form #submit").trigger("click");
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
                    jQuery("#search-rings-form #submit").trigger("click");
                    break;
                }
        });*/
    });
}