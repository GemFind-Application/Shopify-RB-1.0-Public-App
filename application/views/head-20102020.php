<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$this->load->library('diamond_lib');
$settings = $this->diamond_lib->getStyleSettings($shopurl);
if(sizeof($settings) > 0){
$selectedItemTextColor = '#ffffff';
$buttonTextHoverColor = $buttonTextColor = '#ffffff';
$sliderColor = $settings['settings']['hoverEffect'][0]->color1;
$selectedItemColor = $settings['settings']['hoverEffect'][0]->color1;
$selectedItemhoverColor = $settings['settings']['hoverEffect'][0]->color2;
$gridColor = $settings['settings']['columnHeaderAccent'][0]->color1;
$gridHoverColor = $settings['settings']['columnHeaderAccent'][0]->color2;
$buttonBackgroundColor = $settings['settings']['callToActionButton'][0]->color1;
$buttonhoverColor = $settings['settings']['callToActionButton'][0]->color2;
$linkColor = $settings['settings']['linkColor'][0]->color1;
$linkHoverColor = $settings['settings']['linkColor'][0]->color2;
$slider_barmakian = '#0973ba';
?>
<style>
    #search-diamonds .ui-slider-horizontal .ui-slider-range { background-color: <?=$sliderColor ?>; border-color: <?=$sliderColor ?>; }
    #search-diamonds .noUi-horizontal .noUi-connect{ background-color: <?=$sliderColor ?>; border-color: <?=$sliderColor ?>; }
    body.dealer-3865 #search-diamonds .noUi-horizontal .noUi-connect{ background-color: <?=$slider_barmakian ?>; border-color: <?=$slider_barmakian ?>; }

    #search-diamonds .ui-slider .ui-slider-tooltip, #search-diamonds .ui-widget-content .ui-slider-handle { background-color: <?=$sliderColor ?>; }
    #search-diamonds .ui-slider .noUi-handle{ background-color: <?=$sliderColor ?>;}
    body.dealer-3865 #search-diamonds .ui-slider .noUi-handle{ background-color: <?=$slider_barmakian ?>;}
    
    #search-diamonds .ui-slider .ui-slider-tooltip .ui-tooltip-pointer-down-inner {border-top: 7px solid <?=$sliderColor ?> !important;}
	#search-rings .ui-slider-horizontal .ui-slider-range { background-color: <?=$sliderColor ?>; border-color: <?=$sliderColor ?>; }
	#search-rings .noUi-horizontal .noUi-connect{ background-color: <?=$sliderColor ?>; border-color: <?=$sliderColor ?>; }
	body.dealer-3865 #search-rings .noUi-horizontal .noUi-connect{ background-color: <?=$slider_barmakian ?>; border-color: <?=$slider_barmakian ?>; }

	#search-rings .ui-slider .ui-slider-tooltip, #search-rings .ui-widget-content .ui-slider-handle { background-color: <?=$sliderColor ?>; }
	#search-rings .ui-slider .noUi-handle{ background-color: <?=$sliderColor ?>;}
	body.dealer-3865 #search-rings .ui-slider .noUi-handle{ background-color: <?=$slider_barmakian ?>;}

	#search-rings .ui-slider .ui-slider-tooltip .ui-tooltip-pointer-down-inner {border-top: 7px solid <?=$sliderColor ?> !important;}
    .flow-tabs .tab-section li.tab-li.active a{background: <?=$selectedItemhoverColor ?>;}
    .flow-tabs .tab-section li.tab-li.active a:after{border-color: transparent transparent transparent <?=$selectedItemhoverColor ?>;}
    .flow-tabs .rings-search .color-filter ul li:hover { border-bottom: 2px solid <?=$selectedItemColor ?>;}
    .flow-tabs .rings-search .color-filter ul li.active.selected { border-bottom: 2px solid <?=$selectedItemColor ?>;}
    .diamond-filter-title ul li a:hover {color: <?=$hoverEffect ?>;}
    .product-controler ul li a { color: <?=$linkColor ?>;}
    .product-controler ul li a:hover {color: <?=$hoverEffect ?>;}
    .filter-for-shape ul li .shape-type.selected {background: <?=$selectedItemColor ?>;}
    
    .filter-for-shape .cut-main ul li.active {background: <?=$selectedItemColor ?>; color: <?=$buttonTextColor ?>;}
    .filter-advanced .accordion:before, .change-view-result ul li.list-view a.active:before, .change-view-result ul li.grid-view a.active:before, .change-view-result ul li a.active:before, .search-in-table button{background-color: <?=$buttonBackgroundColor ?>; color: <?=$buttonTextColor ?>;}
    .diamond-filter-title ul li a{color: <?=$linkColor ?>; }
    .search-details .table thead tr th {background: <?=$gridColor ?>; color: <?=$buttonTextColor ?>; }
    .search-details .table tbody tr th.table-selecter .state label:before {border: 2px solid <?=$selectedItemColor ?>; }
    .search-details .table tbody tr th.table-selecter input[type="checkbox"]:checked~.state label:after {background-color: <?=$selectedItemColor ?>; }
    .search-details .table tbody tr th.table-selecter .state label:after {border: 1px solid <?=$selectedItemColor ?>; }
    .search-details .table tbody tr th.table-selecter input[type="checkbox"]:checked~.state label:before {background-color: <?=$selectedItemColor ?>;}
    .search-details .table tbody tr:hover td, .search-details .table tbody tr:hover th{background: <?=$gridHoverColor ?>; color: <?=$buttonTextColor ?>; }    
    .search-details .table tbody tr:hover td a{ color: <?=$buttonTextColor ?>; }    
    .grid-paginatin ul li.active {background: <?=$buttonBackgroundColor ?>; color: <?=$buttonTextColor ?>;}
    .grid-paginatin ul li.active a{background: <?=$buttonBackgroundColor ?>; color: <?=$buttonTextColor ?>;}
    .grid-paginatin ul li.active:hover, .diamond-page .diamond-action button.addtocart:hover, .prefrence-action .preference-btn:hover, .compare-actions .view-product:hover, .grid-paginatin a#compare-main:hover, .grid-paginatin ul li:not(.grid-previous):not(.grid-next) a:hover, .compare-actions .delete-row:before, .compare-actions .delete-row{background: <?=$buttonhoverColor ?>; color: <?=$buttonTextHoverColor ?>; }
    .change-view-result ul li.list-view a:hover, .change-view-result ul li.grid-view a:hover, .change-view-result ul li a:hover{color: <?=$buttonTextColor ?>; }
    .search-in-table button:hover { background-color: <?=$buttonhoverColor ?>; color: <?=$buttonTextHoverColor ?>; }
    .search-product-grid .product-details .product-box-pricing span {color: <?=$selectedItemColor ?>; }
    .product-details .product-box-action label {color: <?=$selectedItemColor ?>; }
    .product-details .product-box-action .state label:before { border: 2px solid <?=$selectedItemColor ?>; }
    .product-details .product-box-action .state label:after {border: 1px solid <?=$selectedItemColor ?>;}
    .product-details .product-box-action input[type="checkbox"]:checked~.state label:before {background: <?=$selectedItemColor ?>;}
    .product-details .product-box-action input[type="checkbox"]:checked~.state label:after {background-color: <?=$selectedItemColor ?>;}
    .product-controler ul li:before {background-color: <?=$selectedItemColor ?>;}
    .specification-title h4 a {color: <?=$linkColor ?>;}
    .diamond-request-form .form-field .diamond-action span {color: <?=$selectedItemColor ?>;}
    .diamond-page .diamond-action button.addtocart {background: <?=$buttonBackgroundColor ?>; color: <?=$buttonTextColor ?>; }
    .diamond-info h2 span {color: <?=$linkColor ?>; }
    .diamond-request-form .form-field label input:focus, .diamond-request-form .form-field label textarea:focus {border-color: <?=$selectedItemColor ?>;}
    .prefrence-action .preference-btn {background: <?=$buttonBackgroundColor ?>; color: <?=$buttonTextColor ?>; }
    .diamond-request-form .form-field .prefrence-area input:checked~label:before {background: <?=$selectedItemColor ?>;}
    .compare-product .filter-title ul.filter-left li:hover a {color: <?=$hoverEffect ?>; }
    .color-filter ul li.active, .filter-details .polish-depth ul li.active { background: <?=$selectedItemColor ?>; color: <?=$buttonTextColor ?>;}
    
    .ui-datepicker .ui-datepicker-prev span, .ui-datepicker .ui-datepicker-next span {border-color: transparent <?=$selectedItemColor ?> transparent transparent; }  
    .ui-datepicker .ui-datepicker-next span {border-color: transparent transparent transparent <?=$selectedItemColor ?>; }    
    .ui-datepicker .ui-datepicker-calendar .ui-datepicker-today {background: <?=$selectedItemColor ?>; }
    .grid-paginatin a#compare-main {background: <?=$buttonBackgroundColor ?>; color: <?=$buttonTextColor ?>;}
    .product-controler ul li a:hover {color: <?=$hoverEffect ?>;}
    .product-slide-button .trigger-info:before{color:<?=$buttonBackgroundColor ?> !important; }
    .compare-actions .view-product {background: <?=$buttonBackgroundColor ?>; color: <?=$buttonTextColor ?>;}
    .compare-info table tbody tr th:nth-child(1) a:hover:before, .compare-info table tbody tr th:nth-child(1) a:before{background: <?=$buttonBackgroundColor ?>;}
    .compare-product .filter-title ul.filter-left li a{color:<?=$linkColor ?>;}
    .compare-product .filter-title ul.filter-left li a:hover{color:<?=$hoverEffect ?>;}
    .sumo_pagesize .optWrapper ul.options li.opt.selected{background-color: #E4E4E4; color: #000;}
    .SumoSelect > .optWrapper.multiple > .options li.opt.selected span i, .SumoSelect .select-all.selected > span i{background-color: <?=$buttonBackgroundColor.' !important' ?>;}
    .diamond-report .view_text a{color:<?=$buttonBackgroundColor ?> !important;}
    .internalusemodel.modal-slide .modal-inner-wrap, .dealerinfopopup.modal-slide .modal-inner-wrap{border:2px solid <?=$selectedItemColor ?>;}
    .internalusemodel.modal-slide header button, .dealerinfopopup.modal-slide header button, #internaluseform button.preference-btn{background:<?=$buttonBackgroundColor.' !important' ?>;  box-shadow: none; color: <?=$buttonTextColor ?>; }
    a.internaluselink {color: <?=$buttonBackgroundColor ?>;}
    a.internaluselink:hover {color: <?=$hoverEffect ?>;}
    .internalusemodel .msg{padding: 2px; margin-bottom: 2px;}
    .internalusemodel .msg .error{color: #e40f0f;}
    .internalusemodel .msg .success{color: #29a529;}
    .breadcrumbs ul li a{color: <?=$linkColor ?> !important;}
    .breadcrumbs ul li a:hover{color: <?=$hoverEffect ?> !important;}
    svg#Capa_1{fill: <?=$linkColor ?>;}
    svg#Capa_1:hover{fill: <?=$hoverEffect ?>;}
    .flow-tabs .rings-search .shapepricefiltersection .filter-alignment-right .shape-type:hover{    background: <?=$selectedItemColor ?>;}
    @media only screen and (min-width: 1025px){
      .filter-for-shape ul li .shape-type:hover{background: <?=$selectedItemhoverColor ?>;}  
      .color-filter ul li:hover, .filter-details .polish-depth ul li:hover, .filter-for-shape .cut-main ul li:hover {background: <?=$selectedItemhoverColor ?>; color: <?=$selectedItemTextColor ?>; }
    }
    
</style>
<?php } ?>