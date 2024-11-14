$(document).ready(function() {
    //checkStatus();
	$('#is_page_load').val(0);
            $('#search-rings-form #submitby').val('ajax');
                $('form#search-rings-form').submit(function (e) {
                    e.preventDefault();
                    var selectedCookieShape = jQuery("#shapeul label.cookieselected").text();
                  
                    var selectedShape = jQuery("#shapeul .selected input[type='checkbox']").val();            

                    var selected_shape = selectedShape ? selectedShape : selectedCookieShape;

                    // var selected_shape = jQuery("#shapeul .selected input[type='checkbox']").val();
                    jQuery("#selected_shape").val(selected_shape);

                    var formdata = $('#search-rings-form').serialize();
					
					var formdataarr = formdata.split('&');
					var pre_form_load = $('#pre_form_load').val();
					var i;
					var ring_collection = 'ring_collection';
					var selected_shape = 'selected_shape';
					var ring_metal = 'ring_metal';
					var price_from = 'price%5Bfrom%5D';
					var price_to = 'price%5Bto%5D';
					
					var query_string = new Array();
					for (i = 0; i < formdataarr.length; i++) {
						
						var option_val = formdataarr[i];
						
						if(option_val.indexOf(ring_collection) !== -1){
							query_string.push(formdataarr[i]);
						}
						
						if(option_val.indexOf(selected_shape) !== -1){
							query_string.push(formdataarr[i]);
						}
						
						if(option_val.indexOf(ring_metal) !== -1){
							query_string.push(formdataarr[i]);
						}
						
						if(option_val.indexOf(price_from) !== -1){
							query_string.push(formdataarr[i]);
						}
						
						if(option_val.indexOf(price_to) !== -1){
							query_string.push(formdataarr[i]);
						}
						
					}
					
					var final_query_str = query_string.join("&");
					//final_query_str = final_query_str.replace("ring_shape", "selected_shape");
					
					if(pre_form_load == 1){
						var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'+final_query_str;
						window.history.pushState({path:newurl},'',newurl);
					}
					
					var is_page_load = $('#is_page_load').val();
					if(is_page_load == 1){
						$('.loading-mask.gemfind-loading-mask').css('display', 'block');
					}
					
					$.ajax({
                        url: $('#search-rings-form').attr('action'),
                        data: $('#search-rings-form').serialize(),
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

                            if (($('div.number-of-search strong').html() < 12) && ($('#currentpage').val() > 1)) {
                                $('#currentpage').val(1);
                                $("#search-rings-form #submit").trigger("click");
                            }

                            var mode = $("input#viewmode").val();
                           
                            setTimeout(function() {
                                    $('#'+mode).trigger('click');
                            }, 500);

                            if (mode == 'grid') {
                                $('li.grid-view a').addClass('active');
                                $('li.grid-view-wide a').removeClass('active');
                                $('#grid-mode-wide').addClass('cls-for-hide');
                                $('#grid-mode, #gridview-orderby, div.grid-view-sort').removeClass('cls-for-hide');
                            }

                            $('.change-view-result li a').click(function() {
                                $(this).addClass('active');
                                if ($(this).parent('li').attr('class') == 'grid-view-wide') {
                                    $('li.grid-view a').removeClass('active');
                                    $('#grid-mode-wide').removeClass('cls-for-hide');
                                    $('#grid-mode').addClass('cls-for-hide');
                                    $("input#viewmode").val('list');
                                } else {
                                    $('li.grid-view-wide a').removeClass('active');
                                    $('#grid-mode-wide').addClass('cls-for-hide');
                                    $('#grid-mode').removeClass('cls-for-hide');
                                    $("input#viewmode").val('grid');
                                }
                            });

                            $(document).click(function(e) {
                                $(".search-product-grid .product-inner-info").removeClass('active');
                            });

                            $("#pagesize option").each(function() {
                                if ($(this).val() == $("input#itemperpage").val()) {
                                    $(this).attr("selected", "selected");
                                    return;
                                }
                            });

                            $("#gridview-orderby option").each(function() {
                                if ($(this).val() == $("input#orderby").val()) {
                                    $(this).attr("selected", "selected");
                                    return;
                                }
                            });

                            $('.change-view li a').click(function(){
                                var modeenabled = $(this).attr('id');
                                $("input#viewmode").val(modeenabled);
                            });

                            $('#searchdidfield').keydown(function(e) {
                                if (e.keyCode == 13) {
                                    $('#searchsettingid').trigger('click');
                                }
                            });
                            $('#searchsettingid').click(function(){
                                if($('#searchdidfield').val() !=""){
                                    $('input#settingid').val($('#searchdidfield').val());
                                    $("#search-rings-form #submit").trigger("click");
                                } else {
                                    $('input#searchdidfield').effect("highlight", {color: '#f56666'}, 2000);
                                    return false;
                                }
                            });
                            if($('input#settingid').val()){
                                $('#searchintable').addClass('executed');
                            }
                            $('#searchdidfield').val($('input#settingid').val());
                            //$('input#settingid').val('');
                            $('#resetsearchdata').click(function(){
                               $('#searchdidfield').val();
                               $('input#settingid').val('');
                               $("#search-rings-form #submit").trigger("click");
                            });
                            $('.loading-mask.gemfind-loading-mask').css('display', 'none');
							
							//after the form is loaded
							$('#pre_form_load').val(1);

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
//             url: 'https://gemfind.us/ringbuilder/ringbuilder/settings/storestatus',
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
    
function ringmain(argument) {
      var filter_type = jQuery(".filter-left").children('.active').attr('id');
            jQuery.ajax({
            type: "POST",
            url: $('#search-rings-form').attr('action'),
            data: $('#search-rings-form').serialize(),
            type: 'POST',
            cache: true,
            beforeSend: function(settings) {
                if (jQuery(".placeholder-content").length == 0){
                    jQuery('.loading-mask.gemfind-loading-mask').css('display', 'block');
                }
            },
            success: function(response) {
            //console.log(response);
            jQuery(".placeholder-content").remove();
            jQuery('.result').html(response);
            jQuery('.loading-mask.gemfind-loading-mask').css('display', 'none');

                  $("#pagesize option").each(function() {
                    if ($(this).val() == $("input#itemperpage").val()) {
                        $(this).attr("selected", "selected");
                        return;
                    }
                });

                $("#gridview-orderby option").each(function() {
                    if ($(this).val() == $("input#orderby").val()) {
                        $(this).attr("selected", "selected");
                        return;
                    }
                });
                
            }
        });
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
    document.getElementById("settingid").value = document.getElementById("searchdidfield").value;
    document.getElementById("submit").click();
}

function mode(targetid) {
    var id = targetid.id;
    console.log(id);
    var items = document.getElementById("navbar").getElementsByTagName("li");
    for (var i = 0; i < items.length; ++i) {
      items[i].className = "";
    }
    document.getElementById(id).className = "active";
    if(id != 'navcompare')
    document.getElementById("filtermode").value = id;
    //jQuery('.loading-mask.gemfind-loading-mask').css('display', 'block');
    ringmain();
}

function gridSort(selectObject) {
    var orderBy = document.getElementById("orderby").value;
    var selectedvalue = selectObject.value;
    orderBy = selectedvalue;
    document.getElementById("orderby").value = selectedvalue;
    document.getElementById("currentpage").value = 1;
    document.getElementById("submit").click();
}

function SetBackValue(diamondid, requesteddata) {
    console.log(diamondid);
        var shopurl = $('#shopurl').val();
        var path_shop_url = $('#path_shop_url').val();

        var ringcollection = $("input[name='ring_collection']");
        var ringcollectionList = [];
        ringcollection.each(function() {
            if (this.checked === true) {
                ringcollectionList.push($(this).val());
            }
        });
        /*var ringshapeCheckboxes = $("input[name='ring_shape']");
        var ringshapeList = [];
        ringshapeCheckboxes.each(function() {
            if (this.checked === true) {
                ringshapeList.push($(this).val());
            }
        });*/
        var ringshapeList = [];
        ringshapeList.push($("input[name='selected_shape']").val());
        var ringmetalCheckboxes = $("input[name='ring_metal']");
        var ringmetalList = [];
        ringmetalCheckboxes.each(function() {
            if (this.checked === true) {
                ringmetalList.push($(this).val());
            }
        });

        var PriceMin = $("div#price_slider input.slider-left").val();
        var PriceMax = $("div#price_slider input.slider-right").val();
        var orderBy = $("input#orderby").val();
        var direction = $("input#direction").val();
        var currentPage = $("input#currentpage").val();
        var itemperpage = $("input#itemperpage").val();
        var filtermode = $("input#filtermode").val();
        var viewmode = $("input#viewmode").val();
        var settingid = $("input#settingid").val();
        var formdata = {
            'shapeList': ringshapeList.toString(),
            'ringcollection': ringcollectionList.toString(),
            'ringmetalList': ringmetalList.toString(),
            'PriceMin': PriceMin,
            'PriceMax': PriceMax,
            'Filtermode': filtermode,
            'viewmode': viewmode,
            'currentPage': currentPage,
            'orderBy': orderBy,
            'direction': direction,
            'itemperpage': itemperpage,
            'SID': settingid,
        };
        var expire = new Date();
        expire.setDate(expire.getDate() + 10 * 24 * 60 * 60 * 1000);
            $.cookie("_shopifysaveringbackvalue", JSON.stringify(formdata), {
                path: '/',
                expires: expire
            });

        /*$.ajax({
                url: $('#baseurl').val()+'ringbuilder/settings/ringurl',
                data: {id: diamondid, requesteddata: requesteddata,shopurl:shopurl,path_shop_url:path_shop_url},
                type: 'POST',
                //dataType: 'json',
                //cache: true,
                beforeSend: function(settings) {
                    $('.loading-mask.gemfind-loading-mask').css('display', 'block');
                },
                success: function(response) {
                    var responseData = $.parseJSON(response);
                    console.log(responseData.diamondviewurl);
                    
                    if(responseData.diamondviewurl == ''){
                        alert('Something went wrong. Please try again later.');
                        console.log('Something is wrong with Mounting detail API, please try after some time!');
                        $('.loading-mask.gemfind-loading-mask').css('display', 'none');
                    } else { 
                        //window.location.href = responseData.diamondviewurl;
                        $('.loading-mask.gemfind-loading-mask').css('display', 'block');
                    }
                    
                },
                error: function(xhr, status, errorThrown) {
                    $('.loading-mask.gemfind-loading-mask').css('display', 'none');
                    console.log('Error happens. Try again.');
                    console.log(errorThrown);
                }
            });*/

}


function SaveFilter() {
    
        $('.loading-mask.gemfind-loading-mask').css('display', 'block');
        var ringcollection = $("input[name='ring_collection']");
        var ringcollectionList = [];
        ringcollection.each(function() {
            if (this.checked === true) {
                ringcollectionList.push($(this).val());
            }
        });

        /*var ringshapeCheckboxes = $("input[name='ring_shape']");
        
        var ringshapeList = [];
        ringshapeCheckboxes.each(function() {

            if (this.checked === true) {
                ringshapeList.push($(this).val());
            }
        });*/
        var ringshapeList = [];
        ringshapeList.push($("input[name='selected_shape']").val());
        var ringmetalCheckboxes = $("input[name='ring_metal']");
        var ringmetalList = [];
        ringmetalCheckboxes.each(function() {
            if (this.checked === true) {
                ringmetalList.push($(this).val());
            }
        });


        var PriceMin = $("div#price_slider input.slider-left").val();
        var PriceMax = $("div#price_slider input.slider-right").val();
        var orderBy = $("input#orderby").val();
        var direction = $("input#direction").val();
        var currentPage = $("input#currentpage").val();
        var itemperpage = $("input#itemperpage").val();
        var filtermode = $("input#filtermode").val();
        var viewmode = $("input#viewmode").val();
        var settingid = $("input#settingid").val();
        var formdata = {
            'shapeList': ringshapeList.toString(),
            'ringcollection': ringcollectionList.toString(),
            'ringmetalList': ringmetalList.toString(),
            'PriceMin': PriceMin,
            'PriceMax': PriceMax,
            'Filtermode': filtermode,
            'currentPage': currentPage,
            'orderBy': orderBy,
            'viewmode': viewmode,
            'direction': direction,
            'itemperpage': itemperpage,
            'SID': settingid,
        };
        var expire = new Date();
        expire.setDate(expire.getDate() + 10 * 24 * 60 * 60 * 1000);
            $.cookie("_shopifysaveringfiltercookie", JSON.stringify(formdata), {
                path: '/',
                expires: expire
            });
        
        setTimeout(
            function() {
                $('.loading-mask.gemfind-loading-mask').css('display', 'none');
            }, 400);
    
}

function ResetFilter(redirectto='') {
    
    if(confirm("Are you sure you want to reset data?")){
        $.cookie("_shopifysaveringfiltercookie", '', {
            path: '/',
            expires: -1
        });
        $.cookie("_shopifysaveringbackvalue", '', {
            path: '/',
            expires: -1
        });
        $.cookie("_shopify_ringsetting", '', {
            path: '/',
            expires: -1
        });
        $.cookie("_shopify_diamondsetting", '', {
            path: '/',
            expires: -1
        });
		
        if(redirectto != ''){
			window.location.href = redirectto;
		} else {
			window.location.reload(); 
		}
    }
    
}