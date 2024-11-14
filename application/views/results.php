<?php
$this->load->library('diamond_lib');

$list = $this->diamond_lib->getDiamonds($filter_data); 


$noimageurl = base_url()."/assets/images/no-image.jpg"; 
$loaderimg = base_url()."/assets/images/loader-2.gif"; 

$siteurl = base_url();
$shopurl = $filter_data['shopurl'];
$pathprefixshop = $filter_data['path_prefix_shop'];

$navigation_api = array();
$navigation_api = $this->diamond_lib->getActiveNavigation($shopurl);
$jc_options = $this->diamond_lib->getJCOptions($shopurl);
$access_token = $this->diamond_lib->getShopAccessToken($shopurl);
$finalshopurl = actual_shop_address($access_token,$shopurl,$pathprefixshop,true);
$base_shop_domain = actual_shop_address($access_token,$shopurl,$pathprefixshop);
$data = $this->general_model->getDiamondConfig($shopurl);
$shopStatus = $this->general_model->getAppStatus($shopurl);

$resultperpageoptions = $this->diamond_lib->getResultsPerPageOptions(); 
//Style Color API
$settings = $this->diamond_lib->getStyleSettings($shopurl);
$buttonTextHoverColor = $buttonTextColor = '#ffffff';
if(sizeof($settings) > 0){
	//linkColor
	if($settings['settings']['linkColor'][0]->color2 == "")
	{
		$linkColor = $settings['settings']['linkColor'][0]->color1;
	}
	else
	{
		$linkColor = $settings['settings']['linkColor'][0]->color2;
	}
}
?>

 <?php foreach ($list['data'] as $result) : 
  if ($result->fancyColorMainBody) {
          $diamondfiltertype = 'fancydiamonds';
      } elseif ($result->isLabCreated) {
          $diamondfiltertype = 'labcreated';
      } else {
          $diamondfiltertype = '';
      }
  endforeach;
  ?>

<?php if ($shopStatus == 'active') { ?>
<div class="search-details no-padding" id="scrollPage">
<div class="searching-result"> 
      <div class="number-of-search"> 
      <?php $dia_count =0; ?>
      <p><strong><?php echo number_format($list['pagination']['total']); ?></strong><?php echo 'Similar Diamonds | '; ?></p>
      <p> <?php echo 'Compare Items';?>(<span id="totaldiamonds"><?php echo $dia_count;?></span>)</p>
    </div>
    <div class="search-in-table" id="searchintable"> 
            <input type="text" name="searchdidfield" id="searchdidfield" placeholder="<?php echo 'Search Diamond Stock #'; ?>"><a href="javascript:;" title="close" id="resetsearchdata">X</a><button id="searchdid" title="Search Diamond"></button> 
          </div> 
    <div class="view-or-search-result"> 
      <div class="change-view-result"> 
        <ul> <li class="grid-view" data-placement="top"  data-toggle="tooltip" title="Grid View"> <a href="javascript:;"><?php echo 'Grid view'; ?></a> </li> <li class="list-view" data-placement="top"  data-toggle="tooltip" title="List View"> <a href="javascript:;" class="active"><?php echo 'list view'; ?></a> </li> </ul> 
        <div class="item-page"><p class="leftpp"><?php echo 'Per Page'; ?></p>
          <select class="pagesize" id="pagesize" name="pagesize" onchange="ItemPerPage(this)">
            <?php foreach ($resultperpageoptions as $value) { ?>
              <option value="<?php echo $value['value'] ?>"><?php echo $value['label'] ?></option>
            <?php } ?>
          </select>
        </div> 
        <div class="grid-view-sort cls-for-hide"> 
          <select name="gridview-orderby" id="gridview-orderby" class="gridview-orderby" onchange="gridSort(this)"> <option value="Cut"><?php echo 'Shape'; ?></option> <option value="Size"><?php echo 'Carat'; ?></option> <option value="Color"><?php echo 'Color'; ?></option> <?php if ($diamondfiltertype == 'fancydiamonds') { ?>
      <option value="FancyColorIntensity"><?php echo 'Intensity'; ?></option> <?php } ?> <option value="ClarityID"><?php echo 'Clarity'; ?></option> <option value="CutGrade"><?php echo 'Cut'; ?></option> <option value="Depth"><?php echo 'Depth'; ?></option> <option value="TableMeasure"><?php echo 'Table'; ?></option> <option value="Polish"><?php echo 'Polish'; ?></option> <option value="Symmetry"><?php echo 'Symmetry'; ?></option> <option value="Measurements"><?php echo 'Measurement'; ?></option> <option value="Certificate"><?php echo 'Certificate'; ?></option> <option value="FltPrice"><?php echo 'Price'; ?></option> </select> 
          <div class="gridview-dir-div">
            <a href="javascript:;" onclick="gridDire('DESC')" id="ASC" title="<?php echo 'Set Descending Direction'; ?>" class="active">ASC</a><a href="javascript:;" title="<?php echo 'Set Ascending Direction'; ?>" onclick="gridDire('ASC')" id="DESC">DESC</a>
          </div>
        </div>           
        </div> 
    </div> 
</div>
</div>
<?php } ?>
<?php if (isset($list['pagination']['total']) && $list['pagination']['total'] != 0 && $shopStatus == 'active') : ?>
<div class="search-details no-padding">
   
   <div class="table-responsive" id="list-mode">
      <table class="table" id="result_table">
         <thead class="table_header_wrapper">
            <tr> 
              <?php if($navigation_api['navigation']['navCompare']){ ?>
                <th class="selector-head" scope="col">javascript:;</th> 
              <?php }?>
              <th scope="col" title="Shape Sort Asc/Desc" class="table-sort" id="Cut" onclick="fnSort('Cut');"><?php echo 'Shape'; ?></th> 
             
             <th scope="col" class="table-sort" title="Carat Sort Asc/Desc" id="Size" onclick="fnSort('Size');"><?php echo 'Carat'; ?></th> 
             <th scope="col" title="Color Sort Asc/Desc" class="table-sort" id="Color" onclick="fnSort('Color');"><?php echo 'Color'; ?></th> 
             <?php if ($diamondfiltertype == 'fancydiamonds') { ?>
              <th scope="col" title="fancyColorIntensity Sort Asc/Desc" class="table-sort" id="FancyColorIntensity" onclick="fnSort('FancyColorIntensity');"><?php echo 'Intensity'; ?></th> 
             <?php } ?>
             <th scope="col" title="Clarity Sort Asc/Desc" class="table-sort" id="ClarityID" onclick="fnSort('ClarityID');"><?php echo 'Clarity'; ?></th> 
             <th scope="col" title="Cut Sort Asc/Desc" class="table-sort" id="CutGrade" onclick="fnSort('CutGrade');"><?php echo 'Cut'; ?></th> 
             <th scope="col" title="Depth Sort Asc/Desc" class="table-sort" id="Depth" onclick="fnSort('Depth');"><?php echo 'Depth'; ?></th> 
             <th title="Table Sort Asc/Desc" scope="col" class="table-sort" id="TableMeasure" onclick="fnSort('TableMeasure');"><?php echo 'Table'; ?></th> 
             <th scope="col" title="Polish Sort Asc/Desc" class="table-sort" id="Polish" onclick="fnSort('Polish');"><?php echo 'Polish'; ?></th> 
             <th title="Symmetry Sort Asc/Desc" scope="col" class="table-sort" id="Symmetry" onclick="fnSort('Symmetry');"><?php echo 'Sym.'; ?></th> 
             <th title="Measurement Sort Asc/Desc" scope="col" class="table-sort" id="Measurements" onclick="fnSort('Measurements');"><?php echo 'Measurement'; ?></th> 
             <?php if($jc_options['jc_options']->show_Certificate_in_Diamond_Search) { ?>
			 <th scope="col" title="Certificate Sort Asc/Desc" class="table-sort" id="Certificate" onclick="fnSort('Certificate');"><?php echo 'Cert.'; ?></th>
             <?php }?>
			 <?php if($jc_options['jc_options']->show_In_House_Diamonds_Column_with_SKU) {?>
              <th scope='col' title="In House Sorting Asc/Desc" class="table-sort" id="inhouse" onclick="fnSort('Inhouse');"><?php echo 'In House'; ?></th> 
             <?php } ?>
             <th scope="col" class="table-sort" title="Price Sort Asc/Desc" id="FltPrice" onclick="fnSort('FltPrice');">

              <?php if($result->currencyFrom){ ?>
              <?php echo 'Price ('.$result->currencyFrom.')'; ?>
              <?php }else{ ?>
              <?php echo 'Price' ; ?>
              <?php }?>
               
              </th>
             <!-- <th scope="col" class="video-data" title="Video Sorting Asc/Desc" id="dia_video"><?php //echo 'Video'; ?></th> -->
             <th scope="col" class="view-data" id="dia_view"><?php echo 'View'; ?></th></tr>
         </thead>
         <tbody>
            <?php foreach ($list['data'] as $result) : ?>
            <?php if($result->fancyColorMainBody) { if($result->biggerDiamondimage){ $imageurl = $result->biggerDiamondimage; } else { $imageurl = $noimageurl; }
                  } else { if($result->biggerDiamondimage){ $imageurl = $result->biggerDiamondimage; } else { $imageurl = $noimageurl;  } }
                  if($result->fancyColorMainBody){
                    $type = 'fancydiamonds';
                  }elseif($result->isLabCreated){
                    $type = 'labcreated';
                  }else{
                    $type = '';
                  }
                  if(isset($result->shape)){
                    $urlshape = str_replace(' ', '-',$result->shape).'-shape-';
                  }else {
                    $urlshape = '';
                  }
                  if(isset($result->carat)){
                    $urlcarat = str_replace(' ', '-',$result->carat).'-carat-';
                  }else {
                    $urlcarat = '';
                  }
                  if(isset($result->color)){
                    $urlcolor = str_replace(' ', '-',$result->color).'-color-';
                  } else {
                    $urlcolor = '';
                  }
                  if(isset($result->clarity)){
                    $urlclarity = str_replace(' ', '-',$result->clarity).'-clarity-';
                  }else{
                    $urlclarity = '';
                  }
                  if(isset($result->cut)){
                    $urlcut = str_replace(' ', '-',$result->cut).'-cut-';
                  }else{
                    $urlcut = '';
                  }
                  if(isset($result->cert)){
                    $urlcert = str_replace(' ', '-',$result->cert).'-certificate-';
                  }else{
                    $urlcert = '';
                  }
                  $urlstring = strtolower($urlshape.$urlcarat.$urlcolor.$urlclarity.$urlcut.$urlcert.'sku-'.$result->diamondId);
                  $diamondviewurl = ''; $diamondviewurl = $this->diamond_lib->getDiamondViewUrl($urlstring,$type,$base_shop_domain,$pathprefixshop); 

                 if ($result->fancyColorMainBody) {
                      $color_to_display =  $result->fancyColorMainBody;
                  } else {
                      $color_to_display = $result->color;
                  }

                  if ($result->fancyColorIntensity) {
                    $Intensity_to_display = $result->fancyColorIntensity;
                  }
      
                  ?>               
            <tr id="<?php echo $result->diamondId; ?>">
               
               <?php if($navigation_api['navigation']['navCompare']){ ?>
               <th scope="row" class="table-selecter"> <input type="checkbox" name="compare" value="<?php echo $result->diamondId; ?>"> <div class="state"> <label><?php echo 'Fill'; ?></label> </div> </th>
                <?php } ?>
               <td class="d-shape" id="Cutcol" onclick="SetBackValue('<?php echo $result->diamondId ?>'); location.href='<?php echo $diamondviewurl; ?>'">
                  <span class="imagecheck" data-src="<?php echo $imageurl; ?>" data-srcbig="<?php echo $result->biggerDiamondimage; ?>" data-id="<?php echo $result->diamondId; ?>"></span>
                  <img src="<?php echo $loaderimg; ?>" width="21" height="18" alt="<?php echo $result->shape.' '.$result->carat.' CARAT'; ?>" title="<?php echo $result->shape.' '.$result->carat.' CARAT'; ?>" />
                  <span class="shape-name"><?php echo $result->shape; ?></span>
               </td>
           <td id="Sizecol" class="d-carat" onclick="SetBackValue('<?php echo $result->diamondId ?>'); location.href='<?php echo $diamondviewurl; ?>'"><?php echo ($result->carat) ? $result->carat : '-'; ?></td> 
           <td id="Colorcol" class="d-color" onclick="SetBackValue('<?php echo $result->diamondId ?>'); location.href='<?php echo $diamondviewurl; ?>'"><?php echo ($color_to_display) ? $color_to_display : '-'; ?></td> 
           <?php if ($type == 'fancydiamonds') { ?>
                <td id="Intensitycol" onclick="SetBackValue('<?php echo $result->diamondId ?>');
                                          location.href = '<?php echo $diamondviewurl; ?>'"><?php echo ($Intensity_to_display) ? $Intensity_to_display : '-'; ?></td> 
              <?php } ?>
           <td id="ClarityIDcol" class="d-clarity" onclick="SetBackValue('<?php echo $result->diamondId ?>'); location.href='<?php echo $diamondviewurl; ?>'"><?php echo ($result->clarity) ? $result->clarity : '-'; ?></td> 
           <td id="CutGradecol" class="d-cut" onclick="SetBackValue('<?php echo $result->diamondId ?>'); location.href='<?php echo $diamondviewurl; ?>'">
            <?php  
              if($result->cut == 'Good'){
                echo 'G';
              } else if($result->cut == 'Very good'){
                echo 'VG';
              } else if($result->cut == 'Excellent'){
                echo 'Ex';
              } else if($result->cut == 'Fair'){
                echo 'F';
              } else if($result->cut == 'Ideal'){
                echo 'I';
              } else{
                echo '-';
              }
            ?>
            </td> 
           <td id="Depthcol" class="d-depth" onclick="SetBackValue('<?php echo $result->diamondId ?>'); location.href='<?php echo $diamondviewurl; ?>'"><?php echo ($result->depth) ? $result->depth : '-'; ?></td> 
           <td id="TableMeasurecol" class="d-tablemeasure" onclick="SetBackValue('<?php echo $result->diamondId ?>'); location.href='<?php echo $diamondviewurl; ?>'"><?php echo ($result->table) ? $result->table : '-'; ?></td> 
           <td id="Polishcol" class="d-polish" onclick="SetBackValue('<?php echo $result->diamondId ?>'); location.href='<?php echo $diamondviewurl; ?>'">
            <?php 
            if($result->polish == 'Good'){
              echo 'G';
            } else if($result->polish == 'Very good'){
              echo 'VG';
            } else if($result->polish == 'Excellent'){
              echo 'Ex';
            } else if($result->polish == 'Fair'){
              echo 'F';
            } else{
              echo '-';
            } 
            ?>
              
            </td> 
           <td id="Symmetrycol" class="d-symmetry" onclick="SetBackValue('<?php echo $result->diamondId ?>'); location.href='<?php echo $diamondviewurl; ?>'">
             <?php 
            if($result->symmetry == 'Good'){
              echo 'G';
            } else if($result->symmetry == 'Very good'){
              echo 'VG';
            } else if($result->symmetry == 'Excellent'){
              echo 'Ex';
            } else if($result->symmetry == 'Fair'){
              echo 'F';
            } else{
              echo '-';
            }
            ?>
            </td> 
           <td id="Measurementscol" class="d-measurement" onclick="SetBackValue('<?php echo $result->diamondId ?>'); location.href='<?php echo $diamondviewurl; ?>'"><?php echo $result->measurement; ?></td> 
           <?php if($jc_options['jc_options']->show_Certificate_in_Diamond_Search) { ?>
		   <td id="Certificatecol"><a href="javascript:void(0)" onclick="SetBackValue('<?php echo $result->diamondId ?>'); location.href='<?php echo $diamondviewurl; ?>'"><?php echo $result->cert; ?></a></td> 
           <?php }?>
		   <?php if($jc_options['jc_options']->show_In_House_Diamonds_Column_with_SKU) {?>
              <td id="inhousecol" onclick="SetBackValue('<?php echo $result->diamondId ?>'); location.href='<?php echo $diamondviewurl; ?>'"><?php echo ($result->inhouse) ? $result->inhouse : '-'; ?></td>
            <?php }?>
           <?php if($result->showPrice){?>
              <td id="FltPricecol" onclick="SetBackValue('<?php echo $result->diamondId ?>'); location.href='<?php echo $diamondviewurl; ?>'"><?php 
                $dprice = $result->fltPrice;
                $dprice = str_replace(',', '', $dprice);
                
                if($data->price_row_format == 'left'){
                  if($result->currencyFrom == 'USD'){
                    echo "$".number_format($dprice); 
                  }else{
                    echo number_format($dprice).' '.$result->currencySymbol.' '.$result->currencyFrom;
                  }
                }else{
                  if($result->currencyFrom == 'USD'){
                    echo "$".number_format($dprice); 
                  }else{
                    echo $result->currencyFrom.' '.$result->currencySymbol.' '.number_format($dprice);   
                  }
                }

               ?></td> 
            <?php }else{?>
              <td id="FltPricecol" onclick="SetBackValue('<?php echo $result->diamondId ?>'); location.href='<?php echo $diamondviewurl; ?>'"><?php echo "Call"; ?></td> 
            <?php }?>
        
           <td id="dia_viewcol" onmouseover="onMouseOverMoreInfo(this)" onmouseout="onMouseOutMoreInfo(this)">
           
            <svg width="20px" height="20px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000" class="bi bi-three-dots-vertical">
              <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
            </svg>

                <div class="icon-list">
                        <a href="javascript:;" title="View Diamond" onclick="SetBackValue('<?php echo $result->diamondId; ?>'); location.href='<?php echo $diamondviewurl; ?>'">
                            <svg fill="#000000" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                         viewBox="0 0 512 512" xml:space="preserve">
                      <g>
                        <g>
                          <path d="M256,189.079c-36.871,0.067-66.853,30.049-66.92,66.923c0.068,36.871,30.049,66.853,66.92,66.92
                            c36.871-0.067,66.853-30.049,66.92-66.92C322.853,219.128,292.871,189.147,256,189.079z M256,289.461
                            c-18.48,0-33.46-14.98-33.46-33.46c0-18.48,14.98-33.46,33.46-33.46s33.46,14.98,33.46,33.46
                            C289.46,274.481,274.48,289.461,256,289.461z"/>
                        </g>
                      </g>
                      <g>
                        <g>
                          <path d="M509.082,246.729C451.986,169.028,353.822,89.561,256,89.231c-98.014,0.33-196.379,80.332-253.082,157.498
                            c-3.89,5.576-3.89,12.965,0,18.541C60.015,342.972,158.179,422.44,256,422.769c98.014-0.329,196.38-80.332,253.082-157.498
                            C512.973,259.693,512.973,252.305,509.082,246.729z M256,356.379c-55.407-0.027-100.351-44.974-100.38-100.378
                            c0.029-55.405,44.975-100.354,100.38-100.38c55.407,0.027,100.351,44.974,100.38,100.38
                            C356.351,311.406,311.407,356.353,256,356.379z"/>
                        </g>
                      </g>
                      </svg>
                        </a>
                        <?php if ($result->hasVideo == true && !empty($result->videoFileName)) { ?>
                        <a href="javascript:;" title="Watch Video"  class="triggerVideo" data-id="<?php echo $result->diamondId; ?>" onclick="showModaldb()">
                          
                            <svg fill="#000000" width="20px" height="20px" viewBox="-4 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <title>video</title>
                        <path d="M15.5 13.219l6.844-3.938c0.906-0.531 1.656-0.156 1.656 0.938v11.625c0 1.063-0.75 1.5-1.656 0.969l-6.844-3.969v2.938c0 1.094-0.875 1.969-1.969 1.969h-11.625c-1.063 0-1.906-0.875-1.906-1.969v-11.594c0-1.094 0.844-1.938 1.906-1.938h11.625c1.094 0 1.969 0.844 1.969 1.938v3.031z"></path>
                        </svg>
                        </a>
                    <?php } ?>
                        <a href="javascript:;" title="Additional Information" data-id="<?php echo $result->diamondId; ?>" onclick="showAdditionalInformation('<?php echo $result->diamondId; ?>')">
                            <svg height="20px" width="20px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                         viewBox="0 0 512 512"  xml:space="preserve">                     
                        <g>
                          <path class="st0" d="M290.671,135.434c37.324-3.263,64.949-36.175,61.663-73.498c-3.241-37.324-36.152-64.938-73.476-61.675
                            c-37.324,3.264-64.949,36.164-61.686,73.488C220.437,111.096,253.348,138.698,290.671,135.434z"/>
                          <path class="st0" d="M311.31,406.354c-16.134,5.906-43.322,22.546-43.322,22.546s20.615-95.297,21.466-99.446
                            c8.71-41.829,33.463-100.86-0.069-136.747c-23.35-24.936-53.366-18.225-79.819,7.079c-17.467,16.696-26.729,27.372-42.908,45.322
                            c-6.55,7.273-9.032,14.065-5.93,24.717c3.332,11.515,16.8,17.226,28.705,12.871c16.134-5.895,43.3-22.534,43.3-22.534
                            s-12.595,57.997-18.869,87c-0.874,4.137-36.06,113.292-2.505,149.18c23.35,24.949,53.343,18.226,79.819-7.066
                            c17.467-16.698,26.729-27.373,42.908-45.334c6.55-7.263,9.009-14.054,5.93-24.706C336.66,407.733,323.215,402.01,311.31,406.354z"
                            />
                        </g>
                      </svg>
                        </a>
                    </div>       
              </td>
            </tr>
            <?php endforeach; ?>
         </tbody>
      </table>
   </div>
   <div class="search-view-grid cls-for-hide" id="grid-mode">
      <div class="grid-product-listing">
         <?php foreach ($list['data'] as $result) : ?>
            <?php $diamondviewurl = ''; 
              if($result->isLabCreated){
                $type = 'labcreated';
              } else {
                $type = '';
              }
                  if(isset($result->shape)){
                    $urlshape = str_replace(' ', '-',$result->shape).'-shape-';
                  }else {
                    $urlshape = '';
                  }
                  if(isset($result->carat)){
                    $urlcarat = str_replace(' ', '-',$result->carat).'-carat-';
                  }else {
                    $urlcarat = '';
                  }
                  if(isset($result->color)){
                    $urlcolor = str_replace(' ', '-',$result->color).'-color-';
                  } else {
                    $urlcolor = '';
                  }
                  if(isset($result->clarity)){
                    $urlclarity = str_replace(' ', '-',$result->clarity).'-clarity-';
                  }else{
                    $urlclarity = '';
                  }
                  if(isset($result->cut)){
                    $urlcut = str_replace(' ', '-',$result->cut).'-cut-';
                  }else{
                    $urlcut = '';
                  }
                  if(isset($result->cert)){
                    $urlcert = str_replace(' ', '-',$result->cert).'-certificate-';
                  }else{
                    $urlcert = '';
                  }
                  $urlstring = strtolower($urlshape.$urlcarat.$urlcolor.$urlclarity.$urlcut.$urlcert.'sku-'.$result->diamondId);
                  $diamondviewurl = ''; $diamondviewurl = $this->diamond_lib->getDiamondViewUrl($urlstring,$type,$base_shop_domain,$pathprefixshop); 
                  
                if ($result->fancyColorMainBody) {
                    $color_to_display =  $result->fancyColorMainBody;
                } else {
                    $color_to_display = $result->color;
                }

                if ($result->fancyColorIntensity) {
                  $Intensity_to_display = $result->fancyColorIntensity;
                }

              ?>
         <div class="search-product-grid" id="<?php echo $result->diamondId; ?>" >
          <?php if ($result->hasVideo == true) { ?>
                <a href="javascript:;" data-id="<?php echo $result->diamondId; ?>" class="triggerVideo" onclick="showModaldb()"> <i class="fa fa-video-camera"> </i> </a>
            <?php } ?>
            <div class="product-images"> 
               <a href="<?php echo $diamondviewurl; ?>"> <img src="<?php echo $loaderimg; ?>" alt="<?php echo $result->shape . ' ' . $result->carat . ' CARAT'; ?>" title="<?php echo $result->shape . ' ' . $result->carat . ' CARAT'; ?>" id="dimg_<?php echo $result->diamondId; ?>" />
               </a>
				<div style="display:none;"></div>
				<?php if ($result->hasVideo == true) { ?>
                                
				   <?php 
				   if(end(explode(".", $result->videoFileName)) == "mp4"){ ?>
					   <video id="dvideo_<?php echo $result->diamondId; ?>" class="diamond_video" autoplay loop muted="" playsinline="" style="display:none;">
							<source src="<?php //echo $result->videoFileName; ?>" type="video/mp4">
						</video>
				   <?php } ?>
				   
				<?php } ?>
            </div>
            <div class="product-details"> <div class="product-item-name"><a href="<?php echo $diamondviewurl; ?>" onclick="SetBackValue('<?php echo $result->diamondId ?>'); " title="<?php echo 'View Diamond' ?>"><span><?php echo $result->shape.' <strong>'.$result->carat.'</strong> CARAT'; ?></span>
              <span><?php  echo $color_to_display; if($result->color && $result->clarity || $result->cut){ echo ', ';} echo $result->clarity; if($result->cut) { echo ', '; } echo $result->cut; ?></span>
            </a></div> <div class="product-box-pricing"><a href="<?php echo $diamondviewurl; ?>" title="<?php echo 'View Diamond' ?>">
              <?php if($result->showPrice == 1){?>
                <span><?php 
                $dprice = $result->fltPrice;
                $dprice = str_replace(',', '', $dprice);
                
                if($data->price_row_format == 'left'){
                  if($result->currencyFrom == 'USD'){

                    echo "$".number_format($dprice); 

                  }else{

                    echo number_format($dprice).' '.$result->currencySymbol.' '.$result->currencyFrom;

                  }
                }else{

                  if($result->currencyFrom == 'USD'){

                    echo "$".number_format($dprice); 

                  }else{

                    echo $result->currencyFrom.' '.$result->currencySymbol.' '.number_format($dprice);   

                  }

                }
                ?></span>
              <?php }else{?>
                <span><?php echo "Call For Price"; ?></span>
              <?php }?>
            </a></div> 
            
            <?php if($navigation_api['navigation']['navCompare']){ ?>
            <div class="product-box-action"> <input type="checkbox" name="compare" value="<?php echo $result->diamondId; ?>"/> <div class="state"><label><?php echo 'Add to compare' ?></label></div> </div> 
            <?php }?>
            </div>
            <!-- <div class="product-video-icon"><?php //if($result->hasVideo){ ?><?php  //if(end(explode(".", $result->videoFileName)) == "mp4"){ ?><span title="Video" class="videoicon">
              <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
               width="29px" height="17px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" xml:space="preserve">
            <g>
              <g>
                <path d="M387.118,500.728c0,0,55.636,0,55.636-55.637V166.909c0-55.637-55.636-55.637-55.636-55.637H55.636
                  c0,0-55.636,0-55.636,55.637v278.182c0,55.637,55.636,55.637,55.636,55.637H387.118z"/>
                <polygon points="475.162,219.958 475.162,393.043 612,500.728 612,111.272    "/>
              </g>
            </g>
            </svg>
            </span> <?php //} ?><?php //} ?></div> -->
            <div class="product-slide-button"> <a href="javascript:void(0)" title="More Details" class="trigger-info"><?php echo 'menu' ?></a> </div>
            <div class="product-inner-info">
               <ul> 
                <li>
                  <p><span><?php echo 'Diamond ID' ?> </span><span><?php echo $result->diamondId; ?></span></p> 
                </li> 
                <li> 
                  <p><span><?php echo 'Shape' ?></span><span><?php echo $result->shape; ?></span></p> 
                </li>
                <?php if($jc_options['jc_options']->show_In_House_Diamonds_Column_with_SKU) {?> 
                <li>
                  <p><span><?php echo 'In House' ?></span><span><?php echo $result->inhouse; ?></span></p>
                </li> 
                <?php } ?>
                <li> 
                  <p><span><?php echo 'Carat' ?></span><span><?php echo ($result->carat) ? $result->carat : '-'; ?></span></p> 
                </li>
                <li> 
                  <p><span><?php echo 'Color' ?></span><span><?php echo ($color_to_display) ? $color_to_display : '-'; ?></span></p> 
                </li>
                <li> 
                  <p><span><?php echo 'Intensity' ?></span><span><?php echo ($Intensity_to_display) ? $Intensity_to_display : '-'; ?></span></p> 
              </li>
                <li> 
                  <p><span><?php echo 'Clarity' ?></span><span><?php echo ($result->clarity) ? $result->clarity : '-'; ?></span></p> 
                </li>
                <li> 
                  <p><span><?php echo 'Cut' ?></span><span><?php echo ($result->cut) ? $result->cut : 'NA'; ?></span></p> 
                </li>
                <li> 
                  <p><span><?php echo 'Depth' ?></span><span><?php echo ($result->depth) ? $result->depth.'%' : '-'; ?></span></p> 
                </li>
                <li> 
                  <p><span><?php echo 'Table' ?></span><span><?php echo ($result->table) ? $result->table.'%' : '-'; ?></span></p> 
                </li>                                
                <li> 
                  <p><span><?php echo 'Polish' ?></span><span><?php echo ($result->polish) ? $result->polish : '-'; ?></span></p> 
                </li> 
                <li> 
                  <p><span><?php echo 'Symmetry' ?></span><span><?php echo ($result->symmetry) ? $result->symmetry : '-'; ?></span></p> 
                </li> 
                <li> 
                  <p><span><?php echo 'Measurement' ?></span><span><?php echo $result->measurement; ?></span></p> 
                </li> 
                <li> 
                  <p><span><?php echo 'Certificate' ?></span><span><a href="javascript:;" onclick="javascript:window.open('<?php echo $result->certificateUrl ?>','CERTVIEW','scrollbars=yes,resizable=yes,width=860,height=550')"><?php echo $result->cert; ?></a></span></p> 
                </li>
                <li> 
                  <?php if($result->showPrice){?>
                    <p><span><?php echo 'Price' ?></span><span><?php 
                    if($result->currencyFrom == 'USD'){
                      echo "$".number_format($result->fltPrice);   
                    }else{
                      echo $result->currencyFrom.$result->currencySymbol.number_format($result->fltPrice);   
                    }
                    
                    ?></span></p> 
                  <?php }else{?>
                    <p><span><?php echo 'Price' ?></span><span><?php echo "Call"; ?></span></p> 
                  <?php }?>
                </li>  
              </ul>
            </div>
              <?php if($result->showPrice){
                $pricevar = number_format($result->fltPrice);
              }else{
                $pricevar = "Call";
              }?>
              <input type="hidden" name="diamondshape" id="diamondshape-<?php echo $result->diamondId; ?>" value="<?php echo $result->shape; ?>" /> 
              <input type="hidden" name="diamondsku" id="diamondsku-<?php echo $result->diamondId; ?>" value="<?php echo $result->diamondId; ?>" /> 
              <input type="hidden" name="diamondcarat" id="diamondcarat-<?php echo $result->diamondId; ?>" value="<?php echo $result->carat; ?>" /> 
              <input type="hidden" name="diamondtable" id="diamondtable-<?php echo $result->diamondId; ?>" value="<?php echo $result->table; ?>" /> 
              <input type="hidden" name="diamondcolor" id="diamondcolor-<?php echo $result->diamondId; ?>" value="<?php echo $color_to_display; ?>" /> 
              <input type="hidden" name="diamondcolor" id="diamondintensity-<?php echo $result->diamondId; ?>" value="<?php echo $Intensity_to_display; ?>" /> 
              <input type="hidden" name="diamondpolish" id="diamondpolish-<?php echo $result->diamondId; ?>" value="<?php echo $result->polish; ?>" /> 
              <input type="hidden" name="diamondsymm" id="diamondsymm-<?php echo $result->diamondId; ?>" value="<?php echo $result->symmetry; ?>" /> 
              <input type="hidden" name="diamondclarity" id="diamondclarity-<?php echo $result->diamondId; ?>" value="<?php echo $result->clarity; ?>" /> 
              <input type="hidden" name="diamondflr" id="diamondflr-<?php echo $result->diamondId; ?>" value="<?php echo $result->fluorescence; ?>" /> 
              <input type="hidden" name="diamonddepth" id="diamonddepth-<?php echo $result->diamondId; ?>" value="<?php echo $result->depth; ?>" /> 
              <input type="hidden" name="diamondmeasure" id="diamondmeasure-<?php echo $result->diamondId; ?>" value="<?php echo $result->measurement; ?>" /> 
              <input type="hidden" name="diamondcerti" id="diamondcerti-<?php echo $result->diamondId; ?>" value="<?php echo $result->cert; ?>" /> 
              <input type="hidden" name="diamondcutgrade" id="diamondcutgrade-<?php echo $result->diamondId; ?>" value="<?php echo $result->cut; ?>" /> 
              <input type="hidden" name="diamondimage" id="diamondimage-<?php echo $result->diamondId; ?>" value="" /> 
              <input type="hidden" name="diamondprice" id="diamondprice-<?php echo $result->diamondId; ?>" value="<?php echo $pricevar; ?>" />
          
         </div>
         <?php endforeach; ?>
      </div>
   </div>
   <div class="grid-paginatin" style="text-align:center;">
      <div class="btn-compare"> 
        <?php if($navigation_api['navigation']['navCompare']){ ?> 
          <!-- <a href="javaScript:void(0)" onclick="SetBackValue();" id="compare-main"><?php //echo 'Compare'; ?></a>  -->
           <a href="javaScript:void(0)"  onclick="SetBackValue();" id="compare-main"><?php echo 'Compare'; ?>(<span id="totaldiamonds1">0</span>)</a>
        <?php } ?> 
      </div>
      <?php $current = 1;
         $number = $list['perpage'];
         $pages = ceil($list['pagination']['total']/$number);
         if($list['pagination']['currentpage'] > 1){
           $current = $list['pagination']['currentpage'];
         }
      if($current-1 == 0){
        $value = 1;
      } else {
        $value = $current-1;
      }
        ?>
      <div class="pagination-div pagination_scroll">
        <input type="hidden" name="tool_version" value="Version 2.6.0">
         <ul>
             <li class="grid-next-double">
              <a href="javascript:void(0);" onclick="PagerClick('1');"></a>
            </li>
            <li data-placement="top"  data-toggle="tooltip" title="Previous" <?=($current == 1) ? 'class="disabled grid-next"' : 'class="grid-next"'?>>
               <a href="javascript:void(0);" <?php if(($current-1) != 0){ ?> onclick="PagerClick('<?php echo ($value) ?>');" <?php } ?>><?php echo ($value) ?></a>
            </li>
            <?php for($i=1; $i <= $pages; $i++)
               {
                 if($i<>$current){ 
                   if($i >= $current + 3){
                     continue;
                   }
                   if($i <= $current - 3){
                     continue;
                   }
               ?>
            <li>
               <a href="javascript:void(0);" onclick="PagerClick('<?php echo $i ?>');"><?php echo $i; ?></a>
            </li>
            <?php } else { ?>
            <li class="active">
               <a href="javascript:void(0);" class="active" onclick="PagerClick('<?php echo $i ?>');"><?php echo $i; ?></a>
            </li>
            <?php } } ?>
            <li data-placement="top"  data-toggle="tooltip" title="Next" <?=($current == $pages) ? 'class="disabled grid-previous"' : 'class="grid-previous"'?>>
               <a href="javascript:void(0);" <?php if($current != $pages){ ?> onclick="PagerClick('<?php echo ($current+1); ?>');" <?php } ?>><?php echo ($current+1); ?></a>
            </li>
            <li class="grid-previous-double">
              <a href="javascript:void(0);" onclick="PagerClick('<?php echo $pages; ?>');"></a>
            </li>
         </ul>
      </div>
      <?php
         if ($current == 1) {
             $from = 1;
             $to = $number;
         } else {
             $from = (($current - 1) * $number) + 1;
             $to = ($current * $number);
         }
         
         if ($list['pagination']['total'] < $to) {
             $to = $list['pagination']['total'];
         }
         
             echo "<div class='page-checked'><div class='result-bottom'>Results " . number_format($from) . " to " . number_format($to) . " of " . number_format($list['pagination']['total']). " </div></div> ";
         ?>
   </div>
</div>
<?php else: ?>
<div class="search-details no-padding no-result-main">
   <div class="searching-result no-result-div">
      <?php echo 'No Data Found.' ?>
   </div>
</div>
<?php endif; ?>

<div id="myDbModal" class="Dbmodal">
    <div class="Dbmodal-content">

        <span class="Dbclose">&times;</span>
         <div class="loader_rb" style="display: none;">
            <img src="<?php echo base_url('assets/images/diamond.gif') ?>" style="width: 200px; height: 200px;">
        </div>
        <iframe src="" id="iframevideodb" frameBorder="0" scrolling="no" style="width:100%; height:90%;" allow="autoplay"></iframe>
        <video width="100%" height="90%" id="mp4video" loop autoplay>
            <source src=""  type="video/mp4">
        </video>
    </div>
</div>

<!-- Additional Information Modal -->
<div id="dl-diamondInfoModal" class="dl-modal">
  <div class="dl-modal-content">
      <span class="dl-close">&times;</span>
      <h2>Additional Information</h2>
      <table id="dl-diamond-info-table">             
      </table>
  </div>
</div>

<script type="text/javascript">

      jQuery(document).ready(function () {

        //SET TOTAL DIAMOND ON LOAD
        var cookiesarraylenn = compareItemsarrayrb.length
              if(JSON.parse(localStorage.getItem("compareItemsrb"))){
                 var localStoragedataload = JSON.parse(localStorage.getItem("compareItemsrb")).length;  
              }
              else{
                  var localStoragedataload = 0;
              }

              var totalcntarray = cookiesarraylenn + localStoragedataload;
              jQuery('#totaldiamonds').text(totalcntarray);
              jQuery('#totaldiamonds1').text(totalcntarray);

              // console.log(totalcntarray);
              // console.log(cookiesarraylenn);
              // console.log(localStoragedataload);
      
        var  backdid =  jQuery('#backdiamondid').val();
        if(backdid){
          jQuery('.search-details #list-mode #'+backdid).addClass('selected_row');
          jQuery('#grid-mode #'+backdid).addClass('selected_grid');

          /*jQuery('.search-details #list-mode #'+backdid+' td').css('background','#d2d0d0');
          jQuery('.search-details #list-mode #'+backdid+' td').css('color','#000');
          jQuery('.search-details #list-mode #'+backdid+' td a').css('color','#000');
          jQuery('.search-details #list-mode #'+backdid+' th').css('background','#d2d0d0');*/
          jQuery('.search-details #list-mode #'+backdid+' td').css('color','<?php echo $buttonTextColor;?>');
          jQuery('.search-details #list-mode #'+backdid+' td a').css('color','<?php echo $buttonTextColor;?>');
          jQuery('.search-details #list-mode #'+backdid+' td').css('background','<?php echo $linkColor;?>');
          jQuery('.search-details #list-mode #'+backdid+' th').css('background','<?php echo $linkColor;?>');
          var viewmode = jQuery('#viewmode').val();
          var headerheight = parseInt(jQuery('header').outerHeight()) + 30;
          if(viewmode == '' || viewmode == 'list'){
            setTimeout(function(){
            jQuery('html, body').animate({
              scrollTop: jQuery('#list-mode #'+backdid).offset().top - headerheight
            }, 1000);
            },800);          
          }else{
            setTimeout(function(){
            jQuery('html, body').animate({
              scrollTop: jQuery('#grid-mode #'+backdid).offset().top - headerheight 
            }, 1000);
            },800);          
          }
        setTimeout(function(){
        ResetBackCookieFilter();
        jQuery('#backdiamondid').val(""); 
          },800); 
        }

        var is_enable_sticky = jQuery('#sticky_header').val();
        if(is_enable_sticky == 'true'){
          var stickyTop = jQuery('.table_header_wrapper').offset().top;
          jQuery(window).scroll(function() {
            var windowTop = jQuery(window).scrollTop();
            if (stickyTop < windowTop) {
              jQuery('.table_header_wrapper').addClass('fixed-table-head');
            } else {
              jQuery('.table_header_wrapper').removeClass('fixed-table-head');
            }
          });
        }
        // jQuery('[data-toggle="tooltip"]').tooltip();
        jQuery('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
      });

      jQuery('#compare-main').unbind().click(function () {
        console.log('form is submitting');
        compareDiamonds_dl();
      });

      jQuery('#comparetop').unbind().click(function () {
        console.log('form is submitting');
        compareDiamonds_dl();
      });

     jQuery("input:checkbox[name=compare]").click(function() {
      var selectedcheckboxidrb = jQuery(this).val();
      var checkbox = jQuery(this).is(':checked'); 

      if (checkbox == true) {

                var maxAllowed = 5;
              var cnt = compareItemsarrayrb.length;
              if(JSON.parse(localStorage.getItem("compareItemsrb"))){
                 var localStoragedatarb = JSON.parse(localStorage.getItem("compareItemsrb")).length;  
              }
              else{
                  var localStoragedatarb = 0;
              }
              var totalcnt = cnt + localStoragedatarb;
              if (totalcnt > maxAllowed) {
                  jQuery(this).prop("checked", "");
                  alert('You can select a maximum of 6 diamonds to compare! Please check your compare item page you have some items in your compare list.');
                   return false;
              }

        compareItemsarrayrb.push(selectedcheckboxidrb);
        var datacomparerb = {};
        datacomparerb.Image = jQuery("#diamondimage-" + selectedcheckboxidrb).val(), datacomparerb.Shape = jQuery("#diamondshape-" + selectedcheckboxidrb).val(), datacomparerb.Type = jQuery("#diamondtype-" + selectedcheckboxidrb).val(), datacomparerb.Sku = jQuery("#diamondsku-" + selectedcheckboxidrb).val(), datacomparerb.Carat = jQuery("#diamondcarat-" + selectedcheckboxidrb).val(), datacomparerb.Table = jQuery("#diamondtable-" + selectedcheckboxidrb).val(), datacomparerb.Color = jQuery("#diamondcolor-" + selectedcheckboxidrb).val(), datacomparerb.Polish = jQuery("#diamondpolish-" + selectedcheckboxidrb).val(), datacomparerb.Symmetry = jQuery("#diamondsymm-" + selectedcheckboxidrb).val(), datacomparerb.Clarity = jQuery("#diamondclarity-" + selectedcheckboxidrb).val(), datacomparerb.Fluorescence = jQuery("#diamondflr-" + selectedcheckboxidrb).val(), datacomparerb.Depth = jQuery("#diamonddepth-" + selectedcheckboxidrb).val(), datacomparerb.Measurement = jQuery("#diamondmeasure-" + selectedcheckboxidrb).val(), datacomparerb.Cert = jQuery("#diamondcerti-" + selectedcheckboxidrb).val(), datacomparerb.Cut = jQuery("#diamondcutgrade-" + selectedcheckboxidrb).val(), datacomparerb.Price = jQuery("#diamondprice-" + selectedcheckboxidrb).val(), datacomparerb.ID = jQuery("#diamondsku-" + selectedcheckboxidrb).val();
          datacomparerb.DiamondType = '<?php echo $type; ?>';

        compareItemsrb.push(datacomparerb);

        var total_diamonds = compareItemsarrayrb.length + localStoragedatarb;
        if (total_diamonds  <=  6) {
          jQuery('#totaldiamonds').text(total_diamonds);
          jQuery('#totaldiamonds1').text(total_diamonds);
        }
         console.log(compareItemsarrayrb);
        //console.log(datacomparerb);
      } else {
        if(JSON.parse(localStorage.getItem("compareItemsrb"))){
                 var localStoragedatarb = JSON.parse(localStorage.getItem("compareItemsrb")).length;  
              }
              else{
                  var localStoragedatarb = 0;
              }

        compareItemsarrayrb.pop(selectedcheckboxidrb);
        var total_diamonds = compareItemsarrayrb.length + localStoragedatarb;       
        jQuery('#totaldiamonds').text(total_diamonds);
        jQuery('#totaldiamonds1').text(total_diamonds);       
        
        jQuery.each(compareItemsrb, function(key, value) {
          if(value){
          if (selectedcheckboxidrb == value.ID) {
            compareItemsrb.splice(key, 1);
          }
          }
        });
      }
    });

    function compareDiamonds_dl() {
      var count = compareItemsrb.length;
      if (count > 0) {
        var expire = new Date();
        expire.setDate(expire.getDate() + 0.2 * 24 * 60 * 60 * 1000);
        var compareClickCount = localStorage.getItem("compareItemsrbClick");

        var finalItems = [];
        if (compareClickCount == '1') {
          const compareItemsNew = JSON.parse(localStorage.getItem("compareItemsrb"));
          finalItems = compareItemsNew.concat(compareItemsrb);

          jQuery.cookie("comparediamondProductrb", JSON.stringify(finalItems), {
            path: '/',
            expires: expire
          });

          localStorage.setItem("compareItemsrb", JSON.stringify(finalItems));
        } else {
          finalItems = compareItemsrb;

          jQuery.cookie("comparediamondProductrb", JSON.stringify(finalItems), {
            path: '/',
            expires: expire
          });
        }
        
        if (compareClickCount == null) {
          localStorage.setItem("compareItemsrbClick", 1);
          localStorage.setItem("compareItemsrb", JSON.stringify(finalItems));
        }
         window.location.href = '<?php echo $finalshopurl . '/diamondtools/compare/'; ?>';
      } else {
        if(JSON.parse(localStorage.getItem("compareItemsrb"))){
           window.location.href = '<?php echo $finalshopurl . '/diamondtools/compare/'; ?>';
        }else{
          alert('Please select minimum 2 diamonds to compare.');
          }
          document.querySelector('#navcompare').classList.remove('active');
      }
    }

      jQuery( "span.imagecheck" ).each(function() {
        var id = jQuery( this ).attr("data-id");
        if(jQuery('input#viewmode').val() == 'list'){
          var src = jQuery( this ).attr("data-src");  
          imageExists(src, function(exists) {
                  if(exists){
              jQuery('tr#'+id+' td img').attr('src',src);
            jQuery('div#'+id+' div.product-images img').attr('src',src);
            jQuery('input#diamondimage-'+id).val(src);
          
            } else {
               jQuery('tr#'+id+' td img').attr('src','<?php echo $noimageurl ?>');
             jQuery('div#'+id+' div.product-images img').attr('src','<?php echo $noimageurl ?>');
             jQuery('input#diamondimage-'+id).val('<?php echo $noimageurl ?>');
          
            } 
            });
        } else {
          if(jQuery('input#filtermode').val() == 'navfancycolored'){
            var src = jQuery( this ).attr("data-src");
            imageExists(src, function(exists) {
                    if(exists){
                jQuery('tr#'+id+' td img').attr('src',src);
              jQuery('div#'+id+' div.product-images img').attr('src',src);
              jQuery('input#diamondimage-'+id).val(src);
            
              } else {
                 jQuery('tr#'+id+' td img').attr('src','<?php echo $noimageurl ?>');
               jQuery('div#'+id+' div.product-images img').attr('src','<?php echo $noimageurl ?>');
               jQuery('input#diamondimage-'+id).val('<?php echo $noimageurl ?>');
            
              } 
              });
          } else {
            var src = jQuery( this ).attr("data-srcbig"); 
          imageExists(src, function(exists) {
                    if(exists){
                jQuery('tr#'+id+' td img').attr('src',src);
              jQuery('div#'+id+' div.product-images img').attr('src',src);
              jQuery('input#diamondimage-'+id).val(src);
            
              } else {
                 jQuery('tr#'+id+' td img').attr('src','<?php echo $noimageurl ?>');
               jQuery('div#'+id+' div.product-images img').attr('src','<?php echo $noimageurl ?>');
               jQuery('input#diamondimage-'+id).val('<?php echo $noimageurl ?>');
            
              } 
              });
          }
          
        } 
        
      });
    function imageExists(url, callback) {
        var img = new Image();
        img.onload = function() { callback(true); };
        img.onerror = function() { callback(false); };
        img.src = url;
      }

    function showModaldb() {
            jQuery("#iframevideodb").removeAttr("src");
            jQuery("#mp4video").removeAttr("src");
            jQuery("#mp4video").attr("src", '');
            jQuery('#myDbModal').modal('show');
            jQuery('.loader_rb').show();
            var divid = jQuery(event.currentTarget).data('id');
            console.log(divid);
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>/ringbuilder/settings/getdiamondvideos",
                data: {
                    action: 'getdiamondvideos',
                    product_id: divid
                },
                cache: true,
                success: function(response) {
                    response = JSON.parse(response);
                    console.log(response);
                    if (response.showVideo == true) {
                      var fileExtension = response.videoURL.replace(/^.*\./, '');
                      console.log (fileExtension);
                      if(fileExtension=="mp4"){
                          jQuery('#iframevideodb').hide();
                          setTimeout(function() {
                             jQuery("#mp4video").attr("src", response.videoURL);
                             jQuery('.loader_rb').hide();
                             jQuery('#mp4video').get(0).play();
                          }, 3000);
                      }else{
                        // jQuery('#mp4video').hide();
                        setTimeout(function() {
                              jQuery("#iframevideodb").attr("src", response.videoURL);
                              jQuery('.loader_rb').hide();
                              jQuery('#iframevideodb').show();
                          }, 3000);
                      }    
                    }
                }
            });
        }
        jQuery(".Dbclose").click(function() {
            jQuery('#myDbModal').modal('hide');
        });

        jQuery('.pagination_scroll').click(
        function(e) {
            jQuery('html, body').animate({
                scrollTop: jQuery('#scrollPage').position().top
            }, 800);
        });


        function onMouseOverMoreInfo(element) {
            const iconList = element.querySelector('.icon-list');

            if (iconList) {
                iconList.classList.add('icons-show'); // Show the icon list
            }
        }

        function onMouseOutMoreInfo(element) {
            const iconList = element.querySelector('.icon-list');
            if (iconList) {
                iconList.classList.remove('icons-show'); // Hide the icon list
            }
        }

        var modal = document.getElementById("dl-diamondInfoModal");

    function showAdditionalInformation(diamondId) {
        var domain = Shopify.shop;

        // Show the global loader
        jQuery('.loading-mask.gemfind-loading-mask').css('display', 'block');
        document.body.classList.add("dl-AddInfoModal");
        
        // Check if on the diamond detail page
        const isDetailPage = window.location.pathname.includes('/diamondlink/product/');
        let diamondType = 'NA';

        if (!isDetailPage) {
            diamondType = document.getElementById('filtermode').value;
        }

        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/ringbuilder/diamondtools/getDiamondDetails",
            data: {
                action: 'getDiamondDetails',
                id: diamondId,
                shop: domain,
                type: diamondType,
            },

            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);
                var diamondData = data.diamondData;

                // Reference to the table element
                var table = document.getElementById("dl-diamond-info-table");
                var currency = diamondData.currencySymbol;

                if (currency == "US$") {
                  currency = "$"
                }

                // Create table rows dynamically based on the diamondData object
                table.innerHTML = `
                    <tr><th>Diamond ID</th><td>${diamondData.diamondId}</td></tr>             
                    <tr><th>Shape</th><td>${diamondData.shape || 'N/A'}</td></tr>
                    <tr><th>Carat Weight</th><td>${diamondData.caratWeight || 'N/A'}</td></tr>               
                    <tr><th>Color</th><td>${diamondData.color || 'N/A'}</td></tr>
                    <tr><th>Clarity</th><td>${diamondData.clarity || 'N/A'}</td></tr>
                    <tr><th>Cut Grade</th><td>${diamondData.cutGrade || 'N/A'}</td></tr>
                    <tr><th>Depth</th><td>${diamondData.depth || 'N/A'}</td></tr>
                    <tr><th>Table</th><td>${diamondData.table || 'N/A'}</td></tr>
                    <tr><th>Polish</th><td>${diamondData.polish || 'N/A'}</td></tr>
                    <tr><th>Certificate</th><td>${diamondData.certificate || 'N/A'}</td></tr>
                    <tr><th>Measurement</th><td>${diamondData.measurement || 'N/A'}</td></tr>
                    <tr><th>Price</th><td>${currency}${Math.round(diamondData.fltPrice) || 'N/A'}</td></tr>              
                `;
                
                // Show the modal
                modal.style.display = "block";

                // Hide the global loader
                jQuery('.loading-mask.gemfind-loading-mask').css('display', 'none');
            },
            error: function() {
                // Handle errors if needed
                alert("An error occurred while fetching the diamond details.");
                
                // Hide the global loader even if there's an error
                jQuery('.loading-mask.gemfind-loading-mask').css('display', 'none');
            }
        });
    }


    // Event listener to close the modal when the close button is clicked
      var closeModal = document.getElementsByClassName("dl-close")[0];

      closeModal.onclick = function() {
          modal.style.display = "none";
          document.body.classList.remove("dl-AddInfoModal");
      };

      // Event listener to close the modal when clicking outside of the modal content
      window.onclick = function(event) {
          if (event.target == modal) {
              modal.style.display = "none";
            document.body.classList.remove("dl-AddInfoModal");
          }
      };


   
</script>