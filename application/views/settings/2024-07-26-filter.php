<?php

$loadfilter = $this->ringbuilder_lib->getRingFiltersRB($shop_url);
$shopStatus = $this->general_model->getAppStatus($shop_url);

$isShowPrice = $loadfilter['isShowPrice']; 

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
    if (isset($savedfilter->shapeList) && !empty($savedfilter->shapeList)) {
        $shapeArray = explode(',', $savedfilter->shapeList);
    }
}

if (isset($diamondsettingcoockiedata->centerstone)) {
        $shapeArray = explode(',', $diamondsettingcoockiedata->centerstone);
}
if(isset($loadfilter['collections'][0]) && $shopStatus == 'active'){
$show_filter_info = $this->ringbuilder_lib->showFilterInfo($shop_url);
$data = $this->general_model->getDiamondConfig($shop_url);

$pageResult = $this->ringbuilder_lib->getResultPerPageforRing();

$products_per_page = !empty($data->products_pp) ? $data->products_pp : $pageResult;

$sorting_order = !empty($data->sorting_order) ? $data->sorting_order : 'cost-l-h' ;

 ?>

 <div class="filter-details">

  <div class="shape-container">

   <input name="currentpage" id="currentpage" type="hidden" value="<?=isset($savedfilter->currentPage) ? $savedfilter->currentPage : '1'?>">


  <input name="itemperpage" id="itemperpage" type="hidden" value="<?=isset($savedfilter->itemperpage) ? $savedfilter->itemperpage : $products_per_page; ?>">


   <input name="settingid" id="settingid" type="hidden" value="<?=isset($savedfilter->SID) ? $savedfilter->SID : ''?>">

   <input name="viewmode" id="viewmode" type="hidden" value="<?=isset($savedfilter->viewmode) ? $savedfilter->viewmode : 'gridmodewidecol'?>">


   <input name="orderby" id="orderby" type="hidden" value="<?=isset($savedfilter->orderBy) ? $savedfilter->orderBy : $sorting_order; ?>">

   <?php if (isset($diamondsettingcoockiedata->carat)) { ?>
     <input name="caratvalue" id="caratvalue" type="hidden" value="<?php echo $diamondsettingcoockiedata->carat; ?>"> 
   <?php } ?>
   
   <?php if (isset($diamondsettingcoockiedata->centerstonemincarat)) { ?>
		<input name="centerstonemincarat" id="centerstonemincarat" type="hidden" value="<?php echo $diamondsettingcoockiedata->centerstonemincarat; ?>"> 
	<?php } ?>
		
	<?php if (isset($diamondsettingcoockiedata->centerstonemaxcarat)) { ?>
		<input name="centerstonemaxcarat" id="centerstonemaxcarat" type="hidden" value="<?php echo $diamondsettingcoockiedata->centerstonemaxcarat; ?>"> 
	<?php } ?>
   
<?php $collectionsOptions = (array) $loadfilter['collections'];?>
<?php if(!empty($collectionsOptions)){?>
<div class="color-filter shape-bg" id="collections-section">
      <ul>
           <?php foreach ($collectionsOptions as $options) : ?>
				<li class="<?= strtolower(str_replace(' ', '', $options->collectionName)) ?> <?= ($options == end($collectionsOptions)) ? 'last' : '' ?> <?php
				if (isset($savedfilter->ringcollection)) {
					if ($savedfilter->ringcollection == $options->collectionName) {
						echo "selected active";
					}
				} else if($ringcollection != ''){
					if (trim($ringcollection) == $options->collectionName) {
						echo "selected active";
					}
				}
				?>" title="<?= $options->collectionName ?>" id="<?= strtolower(str_replace(' ', '', $options->collectionName)) ?>">
					<div class="collection-type">
						<img src="<?= $options->collectionImage ?>" title="<?= $options->collectionName ?>" alt="<?= $options->collectionName ?>" height="60" width="60" />
						<input type="radio" class="input-assumpte" id="ring_collection_<?= strtolower($options->collectionName) ?>" name="ring_collection" value="<?= $options->collectionName ?>" 
					   <?php
						if (isset($savedfilter->ringcollection)) {
							if ($savedfilter->ringcollection == $options->collectionName) {
								echo "checked='checked'";
							}
						} else if($ringcollection != ''){
							if (trim($ringcollection) == $options->collectionName) {
								echo "checked='checked'";
							}
						}
						?>/>
					</div>
					<label for="ring_collection_<?= $options->collectionName ?>"><?= $options->collectionName ?></label>
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
             <?php  if($shapeArray) { ?>
              <li class="<?= strtolower($options->shapeName) ?> <?= ($options == end($shapeOptions)) ? 'last' : '' ?>" title="<?= $options->shapeName ?>" id="<?= strtolower(str_replace(' ', '', $options->shapeName)) ?>">
                  <div class="shape-type   
                       <?php 
                       if($options->shapeName == trim($selectedShape)){
                          echo 'selected active';
                       } 
                       if(in_array($options->shapeName, $shapeArray)){
                          echo '';
                       }else{
                          echo 'unselected';
                       }
                       ?>" >
                      <input type="checkbox" class="input-assumpte shape-input" id="ring_shape_<?= strtolower($options->shapeName) ?>" name="ring_shape" value="<?= $options->shapeName ?>" <?=($options->shapeName == trim($selectedShape) ? 'checked="checked"' : '')?> <?=(in_array($options->shapeName, $shapeArray)) ? 'checked="checked"' : '' ?>/>
                  </div>
                  <label  class="selected-shape   
                       <?php 
                       if($options->shapeName == trim($selectedShape)){
                          echo 'selected active';
                       } 
                       if(in_array($options->shapeName, $shapeArray)){
                          echo 'cookieselected active';
                       }else{
                          echo 'unselected';
                       }
                       ?>" 
                       for="ring_shape_<?= $options->shapeName ?>"><?= $options->shapeName ?></label>
              </li>
           <?php } else { ?>
      					<li class="<?= strtolower($options->shapeName) ?> <?= ($options == end($shapeOptions)) ? 'last' : '' ?>" title="<?= $options->shapeName ?>" id="<?= strtolower(str_replace(' ', '', $options->shapeName)) ?>">
      						<?php 
      						 $shape_class = "";
      						 if($options->shapeName == trim($selectedShape)){
      							$shape_class = 'selected active';
      						 } 
      						 if(in_array($options->shapeName, $shapeArray)){
      							$shape_class = 'selected active';
      						 }
      						 ?>
      						<div class="shape-type <?php echo $shape_class;?>" >
      							<input type="checkbox" class="input-assumpte shape-input" id="ring_shape_<?= strtolower($options->shapeName) ?>" name="ring_shape" value="<?= $options->shapeName ?>" <?=($options->shapeName == trim($selectedShape) ? 'checked="checked"' : '')?> <?=(in_array($options->shapeName, $shapeArray)) ? 'checked="checked"' : '' ?>/>
      						</div>
      						<label for="ring_shape_<?= $options->shapeName ?>"><?= $options->shapeName ?></label>
      				</li>
            <?php } ?>
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
	   <?php 
		$pricerange = (array) $loadfilter['priceRange'][0]; 
		$saved_price_min = str_replace(',', '', $savedfilter->PriceMin);
		$saved_price_max = str_replace(',', '', $savedfilter->PriceMax);
		$price_from = isset($savedfilter->PriceMin) ? $saved_price_min : $pricerange['minPrice'];
		$price_to = isset($savedfilter->PriceMax) ? $saved_price_max : $pricerange['maxPrice']; 
		
		$price_from = isset($priceFrom) ? $priceFrom : $price_from;
		$price_to = isset($priceTo) ? $priceTo : $price_to;

		$price_from = str_replace(',', '', $price_from);
		$price_to = str_replace(',', '', $price_to);
	   ?>
        <div class="filter-main filter-alignment-left price-filter">
        <?php  if ($isShowPrice == '1'){ ?> 
         <div class="filter-for-shape shape-bg">
            <h4 class="title"><?php echo 'Price'; ?>
              <?php if($show_filter_info == 'true') {?>
              <span class="show-filter-info" onclick="showfilterinfo('price');"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
            <?php } ?>
            </h4>
            <div class="slider_wrapper">
               <div class="price-main ui-slider" id="price_slider" data-min="<?php echo $pricerange['minPrice']; ?>" data-max="<?php echo $pricerange['maxPrice']; ?>">
                  <?php if($data->price_row_format == 'left') { ?> 
                     <div class="price-left price-filter_left">
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
                  <div class="price-right price-filter_right">
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
                  <?php } else { ?>
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

                  <?php } ?>

               </div>

            </div>

         </div>
      <?php  } ?>                 
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
      
        foreach ($metalTypeOptions as $metalTypevalue) {
        $metalTypevalue = (array)$metalTypevalue; 
        ?>

        <li id="ring_metal_<?= strtolower(str_replace(' ', '', $metalTypevalue['metalType'])) ?>" class="<?php
			if (isset($savedfilter->ringmetalList)) {
				if ($savedfilter->ringmetalList == $metalTypevalue['metalType']) {
					echo "selected active";
				}
			}
			
			if (isset($selectedMetal)) {
				if ($selectedMetal == $metalTypevalue['metalType']) {
					echo "selected active";
				}
			}
			?>"><input type="radio" class="input-assumpte"  name="ring_metal" value="<?= $metalTypevalue['metalType'] ?>"  <?php
					if (isset($savedfilter->ringmetalList)) {
						if ($savedfilter->ringmetalList == $metalTypevalue['metalType']) {
							echo "checked='checked'";
						}
					}
					
					if (isset($selectedMetal)) {
						if ($selectedMetal == $metalTypevalue['metalType']) {
							echo "checked='checked'";
						}
					}
					?>/>

				<?php
				$metalType = explode(" ", $metalTypevalue['metalType']);
				if ($metalType[0] == "Platinum") {
					$metalType[0] = "PT";
					$metalType[1] = "Platinum";
				}
				echo "<span class='metallabel " . strtolower($metalType[1]) . strtolower($metalType[2]) . "'>" . $metalType[0] . "</span> " . $metalType[1] . $metalType[2];
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

<style>
  
/*filter*/

.price-filter_left input, .price-filter_right input{
    padding: 5px !important;
    width: 120px !important;
    text-align: left !important; 
  }
  
  .price-main .price-filter_right span.currency-icon{
    right: 7px !important;
  }
  .price-main .price-filter_left span.currency-icon{
    left: 65px !important;
  }
  .ringbuilder-settings-index .price-main .price-filter_right span.currency-icon {
      left: 0 !important;
  }
  .ringbuilder-settings-index .price-main .price-filter_left span.currency-icon, .ringbuilder-settings-index .price-main .price-filter_right span.currency-icon {   
      text-align: right !important;
  }
  @media screen and (max-width: 767px) {
  body #search-diamonds .ui-slider .price-filter_right .ui-slider-val.slider-right{
      padding: 5px !important;   
  }
  
   .price-filter_left input, .price-filter_right input{
      width: 105px !important;
   }
  
  }

 </style>