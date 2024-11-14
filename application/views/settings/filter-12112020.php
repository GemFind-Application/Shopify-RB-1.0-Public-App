<?php

$loadfilter = $this->ringbuilder_lib->getRingFiltersRB($shop_url);

$diamondsettingcoockiedata = (json_decode($diamond_setting_cookie_data))[0];

//$diamondsettingcoockiedata = array();


$shapeArray  = array();

if ($save_ring_filter_cookie_data) {
    $savedfilter = json_decode($save_ring_filter_cookie_data);
} else if($ring_back_cookie_data){
    $savedfilter = json_decode($ring_back_cookie_data);
} else {
    $savedfilter = "";
}
if (isset($savedfilter)) {
    if (isset($savedfilter->shapeList)) {
        $shapeArray = explode(',', $savedfilter->shapeList);
    }
}

if (isset($diamondsettingcoockiedata->centerstone)) {
        $shapeArray = explode(',', $diamondsettingcoockiedata->centerstone);
}
if(isset($loadfilter['collections'][0])){
$show_filter_info = $this->ringbuilder_lib->showFilterInfo($shop_url);
 ?>

 <div class="filter-details">

  <div class="shape-container">

   <input name="currentpage" id="currentpage" type="hidden" value="<?=isset($savedfilter->currentPage) ? $savedfilter->currentPage : '1'?>">

   <input name="itemperpage" id="itemperpage" type="hidden" value="<?=isset($savedfilter->itemperpage) ? $savedfilter->itemperpage : $this->ringbuilder_lib->getResultPerPageforRing(); ?>">

   <input name="settingid" id="settingid" type="hidden" value="<?=isset($savedfilter->SID) ? $savedfilter->SID : ''?>">

   <input name="viewmode" id="viewmode" type="hidden" value="<?=isset($savedfilter->viewmode) ? $savedfilter->viewmode : 'gridmodewidecol'?>">

   <input name="orderby" id="orderby" type="hidden" value="<?=isset($savedfilter->orderBy) ? $savedfilter->orderBy : 'cost-l-h'?>">

   <?php if (isset($diamondsettingcoockiedata->carat)) { ?>
     <input name="caratvalue" id="caratvalue" type="hidden" value="<?php echo $diamondsettingcoockiedata->carat; ?>"> 
   <?php } ?>
<?php $collectionsOptions = (array) $loadfilter['collections'];?>
<?php if(!empty($collectionsOptions)){?>
<div class="color-filter shape-bg" id="collections-section">
      <ul>
           <?php foreach ($collectionsOptions as $options) : ?>
           <li class="<?=strtolower(str_replace(' ', '', $options->collectionName)) ?> <?=($options == end($collectionsOptions)) ? 'last' : ''?> <?php if(isset($savedfilter->ringcollection)){ if($savedfilter->ringcollection == 
            $options->collectionName){ echo "selected active";} } ?>" title="<?=$options->collectionName ?>" id="<?=strtolower(str_replace(' ', '', $options->collectionName)) ?>">
              <div class="collection-type">
                 <img src="<?=$options->collectionImage?>" title="<?=$options->collectionName?>" alt="<?=$options->collectionName?>" height="60" width="60" />
                 <input type="radio" class="input-assumpte" id="ring_collection_<?=strtolower($options->collectionName)?>" name="ring_collection" value="<?=$options->collectionName?>" <?php if(isset($savedfilter->ringcollection)){ if($savedfilter->ringcollection == $options->collectionName){ echo "checked='checked'";} } ?>/>
              </div>
              <label for="ring_collection_<?=$options->collectionName?>"><?=$options->collectionName?></label>
           </li>
           <?php endforeach; ?>
      </ul>
   </div>
<?php }?>

</div>

   <div class="shape-container shapepricefiltersection shape-flex">
    <?php $shapeOptions = (array) $loadfilter['shapes']; ?>
    <?php if(!empty($shapeOptions)){ ?>
      <div class="filter-main filter-alignment-right">
         <div class="filter-for-shape shape-bg">
            <h4 class="ring-label-shape">Shape
            <?php if($show_filter_info == 'true') {?>
              <span class="show-filter-info" onclick="showfilterinfo('shape');"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
            <?php } ?>
          </h4>
            <ul id="shapeul">
               <?php foreach ($shapeOptions as $options) : ?>
               <li class="<?=strtolower($options->shapeName) ?> <?=($options == end($shapeOptions)) ? 'last' : ''?>" title="<?=$options->shapeName ?>" id="<?=strtolower(str_replace(' ', '', $options->shapeName)) ?>">
                  <div class="shape-type <?=(in_array($options->shapeName, $shapeArray)) ? 'selected active' : ''?>">
                     <input type="checkbox" class="input-assumpte" id="ring_shape_<?=strtolower($options->shapeName)?>" name="ring_shape" value="<?=$options->shapeName?>" <?=(in_array($options->shapeName, $shapeArray)) ? 'checked="checked"' : ''?>/>
                  </div>
                  <label for="ring_shape_<?=$options->shapeName?>"><?=$options->shapeName?></label>
               </li>
               <?php endforeach; ?>      
              <input type="hidden" name="selected_shape" id="selected_shape" value="">
           </ul>
         </div>
      </div>
    <?php }?>
    <?php 
    $pricerange = (array) $loadfilter['priceRange'][0]; 
    $metalTypeOptions = (array) $loadfilter['metalType'];
    ?>
    <?php if(!empty($pricerange) || !empty($metalTypeOptions)) {?>
      <div class="filter-main filter-alignment-left">
        <div class="filter-for-shape shape-bg metal_price-filter">
       <?php if(!empty($pricerange)){ ?>
	   <?php $pricerange = (array) $loadfilter['priceRange'][0]; ?>
	   <?php $price_from = isset($savedfilter->PriceMin) ? $savedfilter->PriceMin : $pricerange['minPrice']; ?>
	   <?php $price_to = isset($savedfilter->PriceMax) ? $savedfilter->PriceMax : $pricerange['maxPrice']; ?>
        <div class="filter-main filter-alignment-left price-filter">
         <div class="filter-for-shape shape-bg">
            <h4 class="title"><?php echo 'Price'; ?>
              <?php if($show_filter_info == 'true') {?>
              <span class="show-filter-info" onclick="showfilterinfo('price');"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
            <?php } ?>
            </h4>
            <div class="slider_wrapper">
               <div class="price-main ui-slider" id="price_slider" data-min="<?php echo $pricerange['minPrice']; ?>" data-max="<?php echo $pricerange['maxPrice']; ?>">
                  <div class="price-left">
                     <span class="currency-icon">
                     	<?php 
                     	if($loadfilter['currencyFrom'] == 'USD'){
                     		echo "$"; 
                     	}else{
                     		echo $loadfilter['currencyFrom'].$loadfilter['currencySymbol']; 
                     	}
                     	?>
                     		
                     	</span>
                     <input type="text" class="ui-slider-val slider-left" name="price[from]" value="<?php echo $price_from; ?>" data-type="min"  inputmode="numeric" pattern="[-+]?[0-9]*[.,]?[0-9]+" />
                  </div>
                  <div class="price-right">
                     <span class="currency-icon">
                     	<?php 
                     	if($loadfilter['currencyFrom'] == 'USD'){
                     		echo "$"; 
                     	}else{
                     		echo $loadfilter['currencyFrom'].$loadfilter['currencySymbol']; 
                     	}
                     	?></span>

                     <input type="text" class="ui-slider-val slider-right" name="price[to]" value="<?php echo $price_to; ?>" data-type="max" inputmode="numeric" pattern="[-+]?[0-9]*[.,]?[0-9]+" />

                     <input type="hidden" name="priceto" class="slider-right-val" value="<?php echo round($pricerange['maxPrice'])  ?>">

                  </div>

               </div>

            </div>

         </div>

      </div>
    <?php }?>
    <?php if(!empty($metalTypeOptions)){?>
      <div class="color-filter clarity-filter metaltypeli">
        <div class="shape-bg filter-for-shape">
      <h4 class="ring-label-metal"><?php echo 'Metal'; ?>
        <?php if($show_filter_info == 'true') {?>
              <span class="show-filter-info" onclick="showfilterinfo('metal_type');"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
            <?php } ?>
      </h4>

      <ul style="padding-top: 8px;">

        <?php 
        $metalTypeOptions = array(
            '0' => array('metalType'=>'14K White Gold'),
            '1' => array('metalType'=>'14K Yellow Gold'),
            '2' => array('metalType'=>'14K Rose Gold'),
            '3' => array('metalType'=>'18K White Gold'),
            '4' => array('metalType'=>'18K Yellow Gold'),
            '5' => array('metalType'=>'18K Rose Gold'),
            '6' => array('metalType'=>'Platinum'),
        );

        foreach ($metalTypeOptions as $metalTypevalue) {
        $metalTypevalue = $metalTypevalue; 
        ?>

        <li class="<?php if(isset($savedfilter->ringmetalList)){ if($savedfilter->ringmetalList == $metalTypevalue['metalType']){ echo "selected active";} } ?>"><input type="radio" class="input-assumpte" id="ring_metal_<?=strtolower(str_replace(' ', '', $metalTypevalue['metalType']))?>" name="ring_metal" value="<?=$metalTypevalue['metalType']?>" <?php if(isset($savedfilter->ringmetalList)){ if($savedfilter->ringmetalList == $metalTypevalue['metalType']){ echo "checked='checked'";} } ?>/>

            <?php if($metalTypevalue['metalType'] == 'Platinum'){

              echo "<span class='metallabel platinum'>PT</span> Platinum";

            }

            if($metalTypevalue['metalType'] == '18K Rose Gold'){

              echo "<span class='metallabel rosegold'>18K</span> Rose Gold";

            }

            if($metalTypevalue['metalType'] == '18K Yellow Gold'){

              echo "<span class='metallabel yellowgold'>18K</span> Yellow Gold";

            }

            if($metalTypevalue['metalType'] == '14K Rose Gold'){

              echo "<span class='metallabel rosegold'>14K</span> Rose Gold";

            }

            if($metalTypevalue['metalType'] == '14K White Gold'){

              echo "<span class='metallabel whitegold'>14K</span> White Gold";

            }

            if($metalTypevalue['metalType'] == '14K Yellow Gold'){

              echo "<span class='metallabel yellowgold'>14K</span> Yellow Gold";

            }

            if($metalTypevalue['metalType'] == '18K White Gold'){

              echo "<span class='metallabel whitegold'>18K</span> White Gold";

            }            

            ?>

         </li>

        <?php } ?>

      </ul>
  </div>
   </div>
    <?php }?>
     
      </div>
    </div>
<?php }?>
   </div>    

</div>

<?php } else {

echo 'Something went wrong, please try after some time!';  

} ?>