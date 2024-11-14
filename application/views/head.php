<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$this->load->library('diamond_lib');
$settings = $this->diamond_lib->getStyleSettings($shopurl);
if(sizeof($settings) > 0){
$selectedItemTextColor = '#ffffff';
$buttonTextHoverColor = $buttonTextColor = '#ffffff';
$slider_barmakian = '#0973ba';
//hoverEffect
if($settings['settings']['hoverEffect'][0]->color2 == "")
{
    $hoverEffect = $settings['settings']['hoverEffect'][0]->color1;
}
else
{
    $hoverEffect = $settings['settings']['hoverEffect'][0]->color2;
}
//columnHeaderAccent
if($settings['settings']['columnHeaderAccent'][0]->color2 == "")
{
    $columnHeaderAccent = $settings['settings']['columnHeaderAccent'][0]->color1;
}
else
{
    $columnHeaderAccent = $settings['settings']['columnHeaderAccent'][0]->color2;
}
//linkColor
if($settings['settings']['linkColor'][0]->color2 == "")
{
    $linkColor = $settings['settings']['linkColor'][0]->color1;
}
else
{
    $linkColor = $settings['settings']['linkColor'][0]->color2;
}
//callToActionButton
if($settings['settings']['callToActionButton'][0]->color2 == "")
{
    $callToActionButton = $settings['settings']['callToActionButton'][0]->color1;
}
else
{
    $callToActionButton = $settings['settings']['callToActionButton'][0]->color2;
}
?>
<style>
    #search-diamonds .ui-slider-horizontal .ui-slider-range { background-color: <?=$hoverEffect ?>; border-color: <?=$hoverEffect ?>; }
    #search-diamonds .noUi-horizontal .noUi-connect{ background-color: <?= $columnHeaderAccent; ?>; border-color: <?=$hoverEffect ?>; }
    body.dealer-3865 #search-diamonds .noUi-horizontal .noUi-connect{ background-color: <?=$slider_barmakian ?>; border-color: <?=$slider_barmakian ?>; }

    #search-diamonds .ui-slider .ui-slider-tooltip, #search-diamonds .ui-widget-content .ui-slider-handle { background-color: <?=$hoverEffect ?>; }
    #search-diamonds .ui-slider .noUi-handle{ background-color: <?= $columnHeaderAccent; ?>;}
    body.dealer-3865 #search-diamonds .ui-slider .noUi-handle{ background-color: <?=$slider_barmakian ?>;}
    .noUi-marker.noUi-marker-horizontal.noUi-marker-large:not(:first-child){background-color: <?=$linkColor ?>;}
    
    #search-diamonds .ui-slider .ui-slider-tooltip .ui-tooltip-pointer-down-inner {border-top: 7px solid <?=$hoverEffect ?> !important;}
    #search-rings .ui-slider-horizontal .ui-slider-range { background-color: <?=$hoverEffect ?>; border-color: <?=$hoverEffect ?>; }
    #search-rings .noUi-horizontal .noUi-connect{ background-color: <?= $columnHeaderAccent; ?> ; border-color: <?=$hoverEffect ?>; }
    body.dealer-3865 #search-rings .noUi-horizontal .noUi-connect{ background-color: <?=$slider_barmakian ?>; border-color: <?=$slider_barmakian ?>; }

    #search-rings .ui-slider .ui-slider-tooltip, #search-rings .ui-widget-content .ui-slider-handle { background-color: <?=$hoverEffect ?>; }
    #search-rings .ui-slider .noUi-handle{ background-color: <?= $columnHeaderAccent; ?>;}
    body.dealer-3865 #search-rings .ui-slider .noUi-handle{ background-color: <?=$slider_barmakian ?>;}

    #search-rings .ui-slider .ui-slider-tooltip .ui-tooltip-pointer-down-inner {border-top: 7px solid <?=$hoverEffect ?> !important;}
    .flow-tabs .tab-section li.tab-li.active a{background: <?=$columnHeaderAccent; ?>;}
    .flow-tabs .tab-section li.tab-li.active a:after{border-color: transparent transparent transparent <?=$columnHeaderAccent; ?>;}
    .flow-tabs .rings-search .color-filter ul li:hover { border-bottom: 2px solid <?=$columnHeaderAccent; ?>;}
    .flow-tabs .rings-search .color-filter ul li.active.selected { border-bottom: 2px solid <?=$columnHeaderAccent ?>;}
    .diamond-filter-title ul li a:hover {color: <?=$hoverEffect ?>;}
    .diamond-filter-title ul li a{color: <?=$linkColor ?>;}
    .product-controler ul li a { color: <?=$linkColor ?>;}
    .product-controler ul li a:hover {color: <?=$hoverEffect ?>;}
    .filter-for-shape ul li .shape-type.selected {background: <?=$columnHeaderAccent; ?>;}
    .flow-tabs .tab-section .tab-ul .tab-li.active a span.tab-title{ color: <?=$linkColor ?>;}
    .tab-li.active .tab-title{ color: <?=$linkColor ?>;}
      .flow-tabs .tab-section li.tab-li.active a span{
         color: <?=$linkColor ?>;
      }
   /* .filter-for-shape ul li .shape-type.selected { pointer-events: none;}*/

    
    .filter-for-shape .cut-main ul li.active {background: <?=$linkColor; ?>; color: <?=$buttonTextColor ?>;}
    .filter-advanced .accordion:before, .change-view-result ul li.list-view a.active:before, .change-view-result ul li.grid-view a.active:before, .change-view-result ul li a.active:before, .search-in-table button{background-color: <?=$callToActionButton; ?> !important; color: <?=$buttonTextColor ?>;}
    .change-view-result ul li.list-view a.active:before{background-color: <?=$hoverEffect; ?> !important; color: <?=$buttonTextColor ?>;}
    .search-details .table thead tr th {background: <?=$columnHeaderAccent ?>; color: <?=$buttonTextColor ?>; }
    .search-details .table tbody tr th.table-selecter .state label:before {border: 2px solid <?=$hoverEffect ?>; }
    .search-details .table tbody tr th.table-selecter input[type="checkbox"]:checked~.state label:after {background-color: <?=$hoverEffect ?>; }
    .search-details .table tbody tr th.table-selecter .state label:after {border: 1px solid <?=$hoverEffect ?>; }
    .search-details .table tbody tr th.table-selecter input[type="checkbox"]:checked~.state label:before {background-color: <?=$hoverEffect ?>;}
    .search-details .table tbody tr:hover td, .search-details .table tbody tr:hover th{background: <?=$hoverEffect ?>; color: <?=$buttonTextColor ?>; }    
    .search-details .table tbody tr:hover td a{ color: <?=$buttonTextColor ?>; }    
    .grid-paginatin ul li.active {background: <?=$callToActionButton ?>; color: <?=$buttonTextColor ?>;}
    .grid-paginatin ul li.active a{background: <?=$callToActionButton ?>; color: <?=$buttonTextColor ?>;}
    .grid-paginatin ul li.active:hover, .diamond-page .diamond-action button.addtocart:hover, .prefrence-action .preference-btn:hover, .compare-actions .view-product:hover, .grid-paginatin a#compare-main:hover, .grid-paginatin ul li:not(.grid-previous):not(.grid-next) a:hover, .compare-actions .delete-row:before, .compare-actions .delete-row{background: <?=$hoverEffect ?>; color: <?=$buttonTextHoverColor ?>; }
    .search-in-table button:hover { background-color: <?=$hoverEffect ?>; color: <?=$buttonTextHoverColor ?>; }
    .search-product-grid .product-details .product-box-pricing span {color: <?=$hoverEffect ?>; }
    .product-details .product-box-action label {color: <?=$hoverEffect ?>; }
    .product-details .product-box-action .state label:before { border: 2px solid <?=$hoverEffect ?>; }
    .product-details .product-box-action .state label:after {border: 1px solid <?=$hoverEffect ?>;}
    .product-details .product-box-action input[type="checkbox"]:checked~.state label:before {background: <?=$hoverEffect ?>;}
    .product-details .product-box-action input[type="checkbox"]:checked~.state label:after {background-color: <?=$hoverEffect ?>;}
    .product-controler ul li:before {background-color: <?=$hoverEffect ?>;}
    .specification-title h4 a {color: <?=$linkColor ?>;}
    .diamond-request-form .form-field .diamond-action span {color: <?=$hoverEffect ?>;}
    .diamond-page .diamond-action button.addtocart {background: <?=$callToActionButton ?>; color: <?=$buttonTextColor ?>; }
    .diamond-info h2 span {color: inherit; }
    .diamond-request-form .form-field label input:focus, .diamond-request-form .form-field label textarea:focus {border-color: <?=$hoverEffect ?>;}
    .prefrence-action .preference-btn {background: <?=$callToActionButton ?>; color: <?=$buttonTextColor ?>; }
    .diamond-request-form .form-field .prefrence-area input:checked~label:before {background: <?=$hoverEffect ?>;}
    .compare-product .filter-title ul.filter-left li:hover a {color: <?=$hoverEffect ?>; }
    .color-filter ul li.active, .filter-details .polish-depth ul li.active { background: <?=$linkColor; ?>; color: <?=$buttonTextColor ?>;}
    
    .ui-datepicker .ui-datepicker-prev span, .ui-datepicker .ui-datepicker-next span {border-color: transparent <?=$hoverEffect ?> transparent transparent; }  
    .ui-datepicker .ui-datepicker-next span {border-color: transparent transparent transparent <?=$hoverEffect ?>; }    
    .ui-datepicker .ui-datepicker-calendar .ui-datepicker-today {background: <?=$hoverEffect ?>; }
    .grid-paginatin a#compare-main {background: <?=$callToActionButton ?>; color: <?=$buttonTextColor ?>;}
    .product-controler ul li a:hover {color: <?=$hoverEffect ?>;}
    .product-slide-button .trigger-info:before{color:<?=$callToActionButton ?> !important; }
    .compare-actions .view-product {background: <?=$callToActionButton ?>; color: <?=$buttonTextColor ?>;}
    .compare-info table tbody tr th:nth-child(1) a:hover:before, .compare-info table tbody tr th:nth-child(1) a:before{background: <?=$callToActionButton ?>;}
    .compare-product .filter-title ul.filter-left li a{color:<?=$linkColor ?>;}
    .compare-product .filter-title ul.filter-left li a:hover{color:<?=$hoverEffect ?>;}
    .sumo_pagesize .optWrapper ul.options li.opt.selected{background-color: #E4E4E4; color: #000;}
    .SumoSelect > .optWrapper.multiple > .options li.opt.selected span i, .SumoSelect .select-all.selected > span i{background-color: <?=$callToActionButton.' !important' ?>;}
    .diamond-report .view_text a{color:<?=$callToActionButton ?> !important;}
    .internalusemodel.modal-slide .modal-inner-wrap, .dealerinfopopup.modal-slide .modal-inner-wrap{border:2px solid <?=$hoverEffect ?>;}
    .internalusemodel.modal-slide header button, .dealerinfopopup.modal-slide header button, #internaluseform button.preference-btn{background:<?=$callToActionButton.' !important' ?>;  box-shadow: none; color: <?=$buttonTextColor ?>; }
    a.internaluselink {color: <?=$callToActionButton ?>;}
    a.internaluselink:hover {color: <?=$hoverEffect ?>;}
    .internalusemodel .msg{padding: 2px; margin-bottom: 2px;}
    .internalusemodel .msg .error{color: #e40f0f;}
    .internalusemodel .msg .success{color: #29a529;}
    .breadcrumbs ul li a{color: <?=$linkColor ?> !important;}
    .breadcrumbs ul li a:hover{color: <?=$hoverEffect ?> !important;}
    svg#Capa_1{fill: <?=$callToActionButton ?>;}
    svg#Capa_1:hover{fill: <?=$hoverEffect ?>;}
    @media only screen and (min-width: 1025px){
      .flow-tabs .rings-search .shapepricefiltersection .filter-alignment-right .shape-type:hover{    background: <?=$columnHeaderAccent ?>;}
      .filter-for-shape ul li .shape-type:hover{background: <?=$columnHeaderAccent; ?>;}  
      .color-filter ul li:hover{background: <?=$hoverEffect; ?>; color: <?=$selectedItemTextColor; ?>; } 
      .filter-for-shape .cut-main ul li:hover {background: <?=$hoverEffect; ?>; color: <?=$selectedItemTextColor ?>; }
    }
    .diamond-filter-title{background-color: <?= $columnHeaderAccent; ?>}
    .diamond-filter-title{background: <?php echo $columnHeaderAccent; ?> !important;}
   

    .search-product-grid .product-details .product-box-pricing span {color: #000; }.SumoSelect > .optWrapper > .options li.opt:hover{background-color: <?=$hoverEffect; ?> !important;color: <?=$selectedItemTextColor ?> !important;}
    .filter-advanced .SumoSelect>.optWrapper>.options li.opt.selected{background-color: <?=$linkColor; ?> !important;color: <?=$selectedItemTextColor ?> !important;}
    
    .gemfind-tool-ringbuilder .search-details .change-view-result ul li a.active{background-color:inherit;}
    .product-controler ul li:before {background-color: <?=$callToActionButton ?>;}
    .product-controler ul li:hover:before {background-color: <?=$hoverEffect ?>;}
    .product-controler ul li a:hover {color: <?=$hoverEffect ?>;}
    .filter-details .filter-advanced-main ul li:hover{background-color: <?=$hoverEffect ?>;color: <?=$selectedItemTextColor; ?>;}
    .ring-request-form .diamond-action button.addtocart:hover{background-color: <?=$hoverEffect; ?>;color: <?=$selectedItemTextColor; ?>;}
    .ring-request-form .diamond-action button.addtocart{background-color: <?=$callToActionButton; ?>;color: <?=$selectedItemTextColor; ?>;}
    .prefrence-action .preference-btn.btn-cencel{background-color: <?=$callToActionButton; ?>;color: <?=$selectedItemTextColor; ?>;}
    .prefrence-action .preference-btn.btn-cencel:hover{background-color: <?=$hoverEffect; ?>;color: <?=$selectedItemTextColor; ?>;}
    .diamond-request-form .form-field .diamond-action span{color:#010101;}
    a.internaluselink{color: <?= $callToActionButton; ?>}
    .filter-details i.fa.fa-info-circle{color: <?=$callToActionButton ?>;}
    .ringbuilder-settings-index .searching-result .change-view ul li a.active{background-color: <?=$callToActionButton; ?>;}
    .ringbuilder-settings-index .searching-result .change-view ul li a:hover{background-color: <?=$hoverEffect; ?>;}
    .diamond-filter-title #navbar li.active a{color:<?=$hoverEffect; ?>;}
    .diamond-filter-title ul li:hover, .diamond-filter-title ul li a:hover{color:<?=$hoverEffect; ?>;}
    .diamond-filter-title ul li.active, .diamond-filter-title ul li.active a{color:<?=$hoverEffect; ?>;}
    .filter-for-shape ul li .shape-type.unselected { pointer-events: none; opacity: 0.5;}
    .filter-for-shape ul li .selected-shape.unselected { pointer-events: none; opacity: 0.5;}
    .ring-request-form .diamond-action a.tryonbtn{font-size: 18px;line-height: 25px;}
    .ringbuilder-diamond-completering .diamond-action a.tryonbtn{
      background-color: <?=$callToActionButton ?>;
    }
</style>
<script>
        var compareItemsarrayrb = [];
        var compareItemsrb = [];
</script>
<?php } ?>