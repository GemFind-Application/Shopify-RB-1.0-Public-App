   var $searchModule = jQuery('#search-diamonds');
    jQuery(document).ready(function($) {
        //checkStatus();
			$('#is_page_load').val(0);
            $('#search-diamonds-form #submitby').val('ajax');
                $('form#search-diamonds-form').submit(function (e) {
                    e.preventDefault();
					
					var is_page_load = $('#is_page_load').val();
                    if(is_page_load == 1){
                        $('.loading-mask.gemfind-loading-mask').css('display', 'block');
                    }
					
                    $.ajax({
                        url: $('#search-diamonds-form').attr('action'),
                        data: $('#search-diamonds-form').serialize(),
                        type: 'POST',
                        //dataType: 'json',
                        cache: true,
                        beforeSend: function(settings) {
                            //$('.loading-mask.gemfind-loading-mask').css('display', 'block');
                        },
                        success: function(response) {
                            
                            $('.result').html(response);
                            $('.loading-mask.gemfind-loading-mask').css('display', 'none');
							$('#is_page_load').val(1);
							
                            if (($('div.number-of-search strong').html() < 20) && ($('#currentpage').val() > 1)) {
                                $('#currentpage').val(1);
                                $("#search-diamonds-form #submit").trigger("click");
                            }

                            var totalDia = $('div.number-of-search strong').html();
                            var total_diamonds = parseInt(totalDia.replace(/,/, ''));
                            var itemppage = parseInt($('#itemperpage').val());
                            var totalpage = Math.ceil(total_diamonds/itemppage);

                            if (($('div.number-of-search strong').html() > 20) && ($('#currentpage').val() > totalpage)) {
                                $('#currentpage').val(1);
                                $("#search-diamonds-form #submit").trigger("click");
                            }

                            var mode = $("input#viewmode").val();
                            if (mode == 'grid') {
                                $('li.grid-view a').addClass('active');
                                $('li.list-view a').removeClass('active');
                                $('#list-mode').addClass('cls-for-hide');
                                $('#grid-mode, #gridview-orderby, div.grid-view-sort').removeClass('cls-for-hide');
                            }

                            $('.change-view-result li a').click(function() {
                                $(this).addClass('active');
                                $(".table-responsive input:checkbox[name=compare]").prop("checked", false);
                                if ($(this).parent('li').attr('class') == 'list-view') {
                                    $('li.grid-view a').removeClass('active');
                                    $('#list-mode').removeClass('cls-for-hide');
                                    $('#grid-mode, div.grid-view-sort').addClass('cls-for-hide');
                                    $("input#viewmode").val('list');
                                } else {
                                    $('li.list-view a').removeClass('active');
                                    $('#list-mode').addClass('cls-for-hide');
                                    $('#grid-mode, div.grid-view-sort').removeClass('cls-for-hide');
                                    $("input#viewmode").val('grid');
                                }
                            });

                            $(".search-product-grid .trigger-info").click(function(e) {
                                $(this).parent().next().toggleClass('active');
                                e.stopPropagation();
                            });

                            $(".search-product-grid .product-inner-info").click(function(e) {
                                e.stopPropagation();
                            });

                            $(document).click(function(e) {
                                $(".search-product-grid .product-inner-info").removeClass('active');
                            });

                            $("#gridview-orderby option").each(function() {
                                if ($(this).val() == $("input#orderby").val()) {
                                    $(this).attr("selected", "selected");
                                    return;
                                }
                            });
                            if($("input#direction").val() == 'ASC'){
                                $('#ASC').addClass('active');
                                $('#DESC').removeClass('active');
                            } else{
                                $('#DESC').addClass('active');
                                $('#ASC').removeClass('active');
                            }

                            $("#pagesize option").each(function() {
                                if ($(this).val() == $("input#itemperpage").val()) {
                                    $(this).attr("selected", "selected");
                                    return;
                                }
                            });

                            $('th#' + $("input#orderby").val()).addClass($("input#direction").val());
                            $('#gridview-orderby').SumoSelect({
                                forceCustomRendering: true,
                                triggerChangeCombined:false
                            });

                            $('#pagesize').SumoSelect({
                                forceCustomRendering: true,
                                triggerChangeCombined:false
                            });
                            $('.pagesize.SumoUnder').insertAfter(".sumo_pagesize .CaptionCont.SelectBox");
                            $('.gridview-orderby.SumoUnder').insertAfter(".sumo_gridview-orderby .CaptionCont.SelectBox");

                            // $("input[name='compare']").change(function() {
                            //     var maxAllowed = 5;
                            //     var cnt = $("input[name='compare']:checked").length;
                            //     if (cnt > maxAllowed) {
                            //         $(this).prop("checked", "");
                            //         alert('You can select maximum ' + maxAllowed + ' diamonds to compare!');
                            //     }
                            // });
                            $('#searchdidfield').keydown(function(e) {
                                if (e.keyCode == 13) {
                                    $('#searchdid').trigger('click');
                                }
                            });
                            $('#searchdid').click(function(){
                                if($('#searchdidfield').val() !=""){
                                    $('input#did').val($('#searchdidfield').val());
                                    $("#search-diamonds-form #submit").trigger("click");
                                } else {
                                    $('input#searchdidfield').effect("highlight", {color: '#f56666'}, 2000);
                                    return false;
                                }
                            });
                            if($('input#did').val()){
                                $('#searchintable').addClass('executed');
                            }
                            $('#searchdidfield').val($('input#did').val());
                            $('input#did').val('');
                            $('#resetsearchdata').click(function(){
                               $('#searchdidfield').val();
                               $('input#did').val('');
                               $("#search-diamonds-form #submit").trigger("click");
                            });
                            jQuery.each(compareItemsarrayrb, function(key, value) {
                                if(value){
                                    if(mode == 'grid'){
                                      jQuery("#grid-mode  #"+value+" input:checkbox[name=compare]").prop('checked',true);
                                        jQuery("#grid-mode  #"+value+" input:checkbox[name=compare]").val();
                                    }else{
                                        jQuery("#list-mode tbody tr#"+value+" input:checkbox[name=compare]").prop('checked',true);
                                        jQuery("#list-mode tbody tr#"+value+" input:checkbox[name=compare]").val();
                                   }
                                    
                                }
                            });
                            var total_diamonds = compareItemsarrayrb.length;
                            if (total_diamonds <= 6) {
                                jQuery('#totaldiamonds').text(total_diamonds);
                            }

                            $('.loading-mask.gemfind-loading-mask').css('display', 'none');
                        },
                        error: function(xhr, status, errorThrown) {
                            $('.loading-mask.gemfind-loading-mask').css('display', 'none');
                            console.log('Error happens. Try again.');
                            console.log(errorThrown);
                        }
                    });
                });      
            });


// function checkStatus(){
//     var redirectUrl = window.location.origin;
//     console.log(redirectUrl);
//     $.ajax({
//             url: 'https://gemfind.us/ringbuilder/ringbuilder/diamondtools/storestatus',
//             data: "shop="+window.Shopify.shop,
//             type: 'POST',
          
//             success: function (response) {

//                if (response == "false") {
//                     alert("You haven't select any plan. Please select plan first");
//                     window.location.href=redirectUrl;
//                }
//             }
//         });
// }

function fnSort(strSort) {
    var orderBy = document.getElementById("orderby").value;
    var direction = document.getElementById("direction").value;
    if (strSort == orderBy) {
        if (direction == "ASC")
            direction = 'DESC';
        else
            direction = 'ASC';
    } else {
        direction = 'ASC';
    }
    orderBy = strSort;
    direction = direction;
    document.getElementById("orderby").value = strSort;
    document.getElementById("direction").value = direction;
    document.getElementById("currentpage").value = 1;
    document.getElementById("submit").click();
}

function gridSort(selectObject) {
    var orderBy = document.getElementById("orderby").value;
    var direction = document.getElementById("direction").value;
    var selectedvalue = selectObject.value;
    orderBy = selectedvalue;
    direction = direction;
    document.getElementById("orderby").value = selectedvalue;
    document.getElementById("direction").value = direction;
    document.getElementById("currentpage").value = 1;
    document.getElementById("submit").click();
}

function gridDire(selectedvalue) {
    var direction = document.getElementById("direction").value;
    var selectedvalue = selectedvalue;
    if (direction != selectedvalue) {
        direction = selectedvalue;
    }
    if(direction == "ASC"){
        document.getElementById('DESC').className = "";
        document.getElementById('ASC').className = "active";
    } else {
        document.getElementById('DESC').className = "active";
        document.getElementById('ASC').className = "";
    }
    document.getElementById("direction").value = direction;
    document.getElementById("currentpage").value = 1;
    document.getElementById("submit").click();
}

function ItemPerPage(selectObject){
    var resultperpage = document.getElementById("itemperpage").value;
    var selectedvalue = selectObject.value;
    resultperpage = selectedvalue;
    document.getElementById("itemperpage").value = selectedvalue;
    document.getElementById("currentpage").value = 1;
    document.getElementById("submit").click();
}

function PagerClick(intpageNo) {
    document.getElementById("currentpage").value = intpageNo;
    document.getElementById("submit").click();
}


function mode(targetid) {
    var id = targetid.id;
    var items = document.getElementById("navbar").getElementsByTagName("li");
    for (var i = 0; i < items.length; ++i) {
      items[i].className = "";
    }
    document.getElementById(id).className = "active";
    if(id != 'navcompare')
    document.getElementById("filtermode").value = id;
    jQuery('.loading-mask.gemfind-loading-mask').css('display', 'block');
    diamondmain();
}

function SetBackValue(diamondid) {
  
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

        /*Symmetry List*/
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
        var orderBy = jQuery("input#orderby").val();
        var direction = jQuery("input#direction").val();
        var currentPage = jQuery("input#currentpage").val();
        var viewMode = jQuery("input#viewmode").val();
        var did = diamondid;
        var filtermode = jQuery("input#filtermode").val();
        var formdata = {
            'shapeList': shapeList.toString(),
            'caratMin': caratMin,
            'caratMax': caratMax,
            'PriceMin': PriceMin,
            'PriceMax': PriceMax,
            'certificate': certificatelist.toString(),
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
            'currentPage': currentPage,
            'orderBy': orderBy,
            'direction': direction,
            'viewmode': viewMode,
            'filtermode':filtermode,
            'did': did,
        };
        
        console.log(formdata);
        var expire = new Date();
        expire.setTime(expire.getTime() + 0.5 * 3600 * 1000);
        jQuery.cookie("shopifysavebackvaluefiltermode",filtermode , {
            path: '/',
            expires: expire
            });

        if(filtermode == 'navfancycolored'){
            jQuery.cookie("shopifysavebackvaluefancy", JSON.stringify(formdata), {
            path: '/',
            expires: expire
            });
        } else if(filtermode == 'navstandard'){
            jQuery.cookie("shopifysavebackvalue", JSON.stringify(formdata), {
            path: '/',
            expires: expire
            });            
        } else {
            jQuery.cookie("shopifysavebackvaluelabgrown", JSON.stringify(formdata), {
            path: '/',
            expires: expire
            });  
        }

    
}

/**
 * Use this functions to show and hide video on hover on diamond page
 */
function hideThis(param) {
    
    if(jQuery('#dvideo_'+param).length){
        jQuery('#dimg_'+param).hide();
        jQuery('#dvideo_'+param).show();
    }
}

function showThis(param){
    
    if(jQuery('#dvideo_'+param).length){
        jQuery('#dimg_'+param).show();
        jQuery('#dvideo_'+param).hide();
    }
}