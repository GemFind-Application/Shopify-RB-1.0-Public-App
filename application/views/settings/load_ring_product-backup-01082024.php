<?php
error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);

defined('BASEPATH') OR exit('No direct script access allowed');
$noimageurl = base_url()."/assets/images/no-image.jpg";
//$final_shop_url = $this->config->item('final_shop_url');
$loadingimageurl = base_url()."/assets/images/loader-2.gif";
$tszview = base_url()."/assets/images/360-view.png";
$printIcon = base_url()."/assets/images/print_icon.gif"; 
$jc_options = $this->diamond_lib->getJCOptions($shop);

$getStoreData = $this->general_model->getDiamondConfig($shop);
$site_key=$getStoreData->site_key;
$secret_key=$getStoreData->secret_key;

//$diamondtype = $this->uri->segment(4); 
?>
<?php $setting = $this->ringbuilder_lib->getProductRing($ring_path,$shop,$is_lab_settings);  

$settingData = str_replace("'", '', json_encode($setting));


//$results = $this->ringbuilder_lib->getActiveNavigationRB($shop);
$results = $this->diamond_lib->getActiveNavigation($shop);
$minedDiamond = $results['navigation']['navStandard'];
$labgrownDiamond = $results['navigation']['navLabGrown'];
// echo "<pre>";
// print_r($results);

?>

<?php $rb_config_data = $this->ringbuilder_lib->getRBConfig($shop); 

?>
<?php if(sizeof($setting['ringData']) > 0) {

   $settingid = $setting['ringData']['settingId'];
   $hasvideo = $type = 0;
   if(isset($setting['ringData']['videoURL']) && $setting['ringData']['videoURL'] != '' && $setting['ringData']['videoFileName'] != "0") {
      $headers = isset($setting['ringData']['videoURL']); 

      if($headers){
         $hasvideo = 1;
         if (strpos($setting['ringData']['videoURL'], '.mp4') !== false) {
            $type = 1; 
         } else {
            $type = 2; 
         }
      }
   } else {
     $hasvideo = 0;
   }

?>
<?php if(isset($setting['ringData']['mainImageURL'])){
         $imgurl = $setting['ringData']['mainImageURL']; 
      }
?>

 <!-- Form Captcha -->
<!--  <script>
    function verifyCaptcha(token){
      console.log(token);
        console.log('success!');
    };

    var onloadCallback = function() {
        jQuery( ".g-recaptcha" ).each(function() {
            grecaptcha.render(jQuery( this ).attr('id'), {
                'sitekey' :  $site_key,
                'callback' : verifyCaptcha
            });
        });
    };
</script>  -->


<?php if(!empty($site_key)) { ?>
<script
    src="https://www.google.com/recaptcha/api.js?onload=onloadCallback"
    async defer></script>

    <script>
var onloadCallback = function() {
    grecaptcha.execute();
};

function setResponse(response) { 
    document.getElementById('captcha-response').value = response; 
    document.getElementById('captcha-response-one').value = response;  
    document.getElementById('captcha-response-two').value = response; 
    document.getElementById('captcha-response-three').value = response; 
    
}
</script>
<?php } ?>

<div id="fb-root"></div>

<?php if(!empty($site_key)) { ?>
  <script type="text/javascript">
     function onSubmit(token) {
      console.log(token);
          if(!token){
            alert("Something Wrong went with captcha");
            return false;
          }
          
 }
    window.sitekey = '<?php echo $site_key; ?>';

    function validate(event) {
      event.preventDefault();
     var captchaevent =  grecaptcha.execute();
   }
</script>
  <!-- <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>" data-callback="onSubmit" data-size="invisible"></div> -->
 <?php } ?>

 <style type="text/css">
  
.grecaptcha-badge{
       visibility: visible !important;
       bottom: 110px !important;
}
</style> 

<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v9.0&appId=2069310279975989&autoLogAppEvents=1" nonce="JmRFxYOJ"></script>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
<div class="tab-section">
<?php if (!empty($rb_config_data->announcement_text)) { ?>
            <div class="diamond-bar">
                  <?php   echo $rb_config_data->announcement_text; ?>   
            </div>
<?php }  ?>
<?php
$checkDiamondCookie['diamondid'] = json_decode($check_diamond_cookie)[0];
if($is_lab_settings == 1 ){
   $add_lab_url = 'islabsettings/1';
}
?>
<?php $carat_range_decoded = stripslashes($rb_config_data->settings_carat_ranges); 

 if($setting['ringData']['currencyFrom'] == 'USD'){
      $currencySymbol = '$';
   }else{
      $currencySymbol = $setting['ringData']['currencyFrom'].$setting['diamondData']['currencySymbol'];
   }
   
// print_r($rb_config_data);

?>
<input type="hidden" name="" id="carat_range_input" value='<?php echo $carat_range_decoded; ?>'>
<ul class="tab-ul">
   <?php if ($checkDiamondCookie['diamondid']) { ?>
      <li class="tab-li"><div><a href="javascript:;" onclick="diamond()"><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Diamond'; ?></strong></span><i class="diamond-icon tab-icon"></i></a></div></li>
   <?php } else { ?>
      <li class="tab-li active"><div><a href="javascript:;" onclick="setting()"><i class="back-icon"></i><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Setting'; ?></strong></span><i class="ring-icon tab-icon"></i></a></div></li>
   <?php } ?>
   <?php if (!$checkDiamondCookie['diamondid']) { ?>
      <li class="tab-li"><div><a href="javascript:;" onclick="diamond()"><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Diamond'; ?></strong></span><i class="diamond-icon tab-icon"></i></a></div></li>
   <?php } else { ?>
      <li class="tab-li active"><div><a href="javascript:;" onclick="setting()"><i class="back-icon"></i><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Setting'; ?></strong></span><i class="ring-icon tab-icon"></i></a></div></li>
   <?php } ?>
   <li class="tab-li"><div><a href="javascript:;"><span class="tab-title"><?php echo 'Review'; ?><strong><?php echo 'Complete Ring'; ?></strong></span><i class="finalring-icon tab-icon"></i></a></div></li>
</ul>
       
</div>
<div class="tab-content">
      <div class="d-container">
         <div class="d-row">
            <div class="diamonds-preview no-padding">
               <div class="diamond-info">
                  <div class="diamond-image">
                        <div class="top-icons">
                        <span class="zoom-icon" id="zoom_me">
                           <svg 
                              data-placement="top"  data-toggle="tooltip" title="Zoom"
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="22px" height="22px">
                           <path fill-rule="evenodd"  fill="rgb(148, 148, 148)"
                            d="M22.001,20.308 C22.001,20.775 21.835,21.174 21.505,21.505 C21.174,21.835 20.775,22.001 20.308,22.001 C19.832,22.001 19.436,21.833 19.118,21.498 L14.583,16.976 C13.006,18.069 11.247,18.616 9.308,18.616 C8.047,18.616 6.842,18.371 5.691,17.882 C4.541,17.393 3.549,16.732 2.716,15.899 C1.883,15.066 1.222,14.074 0.733,12.924 C0.244,11.773 -0.001,10.568 -0.001,9.308 C-0.001,8.047 0.244,6.842 0.733,5.692 C1.222,4.541 1.883,3.550 2.716,2.717 C3.549,1.884 4.541,1.222 5.691,0.733 C6.842,0.244 8.047,-0.001 9.308,-0.001 C10.568,-0.001 11.774,0.244 12.924,0.733 C14.075,1.222 15.066,1.884 15.899,2.717 C16.732,3.550 17.393,4.541 17.882,5.692 C18.371,6.842 18.616,8.047 18.616,9.308 C18.616,11.247 18.070,13.006 16.977,14.583 L21.511,19.119 C21.838,19.445 22.001,19.841 22.001,20.308 ZM13.493,5.123 C12.333,3.964 10.938,3.384 9.308,3.384 C7.677,3.384 6.282,3.964 5.123,5.123 C3.964,6.282 3.384,7.677 3.384,9.308 C3.384,10.938 3.964,12.333 5.123,13.492 C6.282,14.651 7.677,15.231 9.308,15.231 C10.938,15.231 12.333,14.652 13.493,13.492 C14.652,12.333 15.231,10.938 15.231,9.308 C15.231,7.677 14.652,6.282 13.493,5.123 ZM13.116,10.154 L10.154,10.154 L10.154,13.116 C10.154,13.230 10.112,13.330 10.028,13.413 C9.945,13.497 9.846,13.539 9.731,13.539 L8.885,13.539 C8.770,13.539 8.671,13.497 8.587,13.413 C8.504,13.330 8.462,13.230 8.462,13.116 L8.462,10.154 L5.500,10.154 C5.385,10.154 5.286,10.112 5.202,10.028 C5.119,9.944 5.077,9.845 5.077,9.731 L5.077,8.884 C5.077,8.770 5.119,8.671 5.202,8.587 C5.286,8.503 5.385,8.461 5.500,8.461 L8.462,8.461 L8.462,5.500 C8.462,5.385 8.504,5.286 8.587,5.202 C8.671,5.118 8.770,5.077 8.885,5.077 L9.731,5.077 C9.846,5.077 9.945,5.118 10.028,5.202 C10.112,5.286 10.154,5.385 10.154,5.500 L10.154,8.461 L13.116,8.461 C13.231,8.461 13.330,8.503 13.414,8.587 C13.497,8.671 13.539,8.770 13.539,8.884 L13.539,9.731 C13.539,9.845 13.497,9.944 13.414,10.028 C13.330,10.112 13.231,10.154 13.116,10.154 Z"/>
                           </svg>
                        </span>
                     <?php if($hasvideo) { ?>
                        <a href="javascript:;" class="videoicon" data-id="<?php echo $setting['ringData']['settingId']; ?>" onclick="Videorun()">
                           <svg 
                              
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="24px" height="21px">
                           <path fill-rule="evenodd"  fill="rgb(148, 148, 148)"
                            d="M23.224,21.000 C22.545,21.000 18.182,16.957 18.182,16.425 L18.182,11.128 C18.182,10.596 22.448,6.553 23.224,6.553 C24.000,6.553 24.000,7.275 24.000,7.275 L24.000,20.278 C24.000,20.278 23.903,21.000 23.224,21.000 ZM16.291,19.917 L1.164,19.917 C0.521,19.917 -0.000,19.550 -0.000,19.098 L-0.000,8.455 C-0.000,8.003 0.521,7.636 1.164,7.636 L16.291,7.636 C16.934,7.636 17.454,8.003 17.454,8.455 L17.454,19.098 C17.454,19.550 16.934,19.917 16.291,19.917 ZM12.364,7.223 C10.355,7.223 8.727,5.606 8.727,3.612 C8.727,1.617 10.355,-0.000 12.364,-0.000 C14.372,-0.000 16.000,1.617 16.000,3.612 C16.000,5.606 14.372,7.223 12.364,7.223 ZM4.364,7.223 C2.757,7.223 1.454,5.930 1.454,4.334 C1.454,2.738 2.757,1.444 4.364,1.444 C5.970,1.444 7.273,2.738 7.273,4.334 C7.273,5.930 5.970,7.223 4.364,7.223 Z"/>
                           </svg>
                        </a>
                     <?php } ?>
                     </div>
                 
                     <div class="diamondimg" id="ringimg" data-loadimg="<?php echo $loadingimageurl; ?>">
                        <img src="<?php echo $imgurl; ?>" data-src="<?php echo $imgurl; ?>" id="diamondmainimage" alt="<?php echo $setting['ringData']['settingName'] ?>" title="<?php echo $setting['ringData']['settingName'] ?>">
                     </div>
                     <h2><?php echo 'SKU#' ?><span><?php echo $setting['ringData']['styleNumber'] ?></span></h2>
                  </div>
                  <div class="product-thumb">
                     <div class="thumg-img diamention">
                     <?php if(isset($setting['ringData']['mainImageURL'])){ ?>
                        <a href="javascript:;" onclick="Imageswitch1(event);" id="main_image" class="fancybox">
                        <img src="<?php echo $loadingimageurl; ?>" data-src="<?php echo $setting['ringData']['mainImageURL'] ?>" style="width:40px; height: 40px;" alt="<?php echo $setting['ringData']['settingName'] ?>" title="<?php echo $setting['ringData']['settingName'] ?>" class="thumbimg" id="thumbimg1" />
                        </a>
                        <div style="display: none;" id="hidden-content">
                           <img src="<?php echo $setting['ringData']['mainImageURL'] ?>" alt="<?php echo $setting['ringData']['settingName'] ?>" title="<?php echo $setting['ringData']['settingName'] ?>" />
                        </div>
                     <?php } ?>
                     <?php $i=2; foreach ($setting['ringData']['extraImage'] as $thumbimage) { ?>
                        <?php if(is_404($thumbimage)) ?>
                        <a href="javascript:;"  onclick="Imageswitch2('thumbimg<?php echo $i; ?>');">
                        <img src="<?php echo $loadingimageurl; ?>" data-src="<?php echo $thumbimage; ?>" style="width:40px; height: 40px;" alt="<?php echo $setting['ringData']['settingName'] ?>" title="<?php echo $setting['ringData']['settingName'] ?>" class="thumbimg" id="thumbimg<?php echo $i; ?>" />
                        </a>
                     <?php $i++;  } ?>
                        
                     </div>
                  </div>
               </div>
            </div>
            <div class="ring-details no-padding ring-request-form">
               <div class="ring-data" id="ring-data">
                  <div class="ring-specification-title">
                     <h2><?php echo $setting['ringData']['settingName'] ?></h2>
                     <h4 class="spec-icon ring_spec_container"><span class="ring_spec" onclick="CallSpecification();">Ring Specification</span>
                        <a href="javascript:;" id="spcfctn" onclick="CallSpecification();">
                           <?php //echo 'Specification' ?>
                           <svg version="1.1" data-placement="bottom"  data-toggle="tooltip" title="Specification" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                              width="20px" height="20px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" xml:space="preserve">
                              <g>
                                 <g id="New_x5F_Post">
                                    <g>
                                       <path d="M545.062,286.875c-15.854,0-28.688,12.852-28.688,28.688v239.062h-459v-459h239.062
                                          c15.854,0,28.688-12.852,28.688-28.688S312.292,38.25,296.438,38.25H38.25C17.136,38.25,0,55.367,0,76.5v497.25
                                          C0,594.883,17.136,612,38.25,612H535.5c21.114,0,38.25-17.117,38.25-38.25V315.562
                                          C573.75,299.727,560.917,286.875,545.062,286.875z M605.325,88.95L523.03,6.655C518.556,2.18,512.684,0,506.812,0
                                          s-11.743,2.18-16.218,6.675l-318.47,318.45v114.75h114.75l318.45-318.45c4.494-4.495,6.675-10.366,6.675-16.237
                                          C612,99.297,609.819,93.445,605.325,88.95z M267.75,382.5H229.5v-38.25L506.812,66.938l38.25,38.25L267.75,382.5z"/>
                                    </g>
                                 </g>
                              </g>
                           </svg>
                        </a>
                     </h4>
                  </div>
                  <div class="diamond-content-data" id="ring-content-data">
                     <div class="diamond-desc">
                        <p><?php echo $setting['ringData']['description'];  ?></p>
                     </div>
                     <div class="form-field diamonds-info">
                        <div class="intro-field">
                           <?php if(sizeof($setting['ringData']['configurableProduct']) > 0){ ?>
                              <?php 
                                 foreach ($setting['ringData']['configurableProduct'] as $value) {
                                    $value = (array) $value;
                                    $metalarray[] = $value['metalType'];
                                    if($value['sideStoneQuality']){
                                       $sidestonearray[] = $value['sideStoneQuality'];
                                    }
                                    if($value['diamondShape']){
                                       $diamondShapeArray[] = $value['diamondShape'];

                                    }
                                    $centerstonesizearray[] = $value['centerStoneSize'];
                                    $sidestn = strtolower(str_replace(' ', '', str_replace('|', '-', $value['sideStoneQuality'])));
                                    $centerstnsize = strtolower(str_replace(' ', '', $value['centerStoneSize']));
                                    $mtltyp = strtolower(str_replace(' ', '-', $value['metalType']));
                                    ?>
                                 <?php } ?>
                           <?php if(sizeof(array_unique($metalarray)) >= 1){ 
                              $metaltypedata = $this->ringbuilder_lib->getMetaltype($setting['ringData']['metalType'],$setting['ringData']['configurableProduct']);

                              ?>
                           <div class="metal-type prdctdrpdwn"><span class="title"><?php echo 'Metal Type'; ?></span>
                              <select class="metaltyp-drpdwn" name="metal_type" id="metal_type" onchange="changemetal(this)">
                                 <?php sort($metaltypedata); foreach ($metaltypedata as $singlemetaltype) { 
                                    
                                    $url_metal_type = strtolower(str_replace('&', '%26', $singlemetaltype['metaltype']));
                                    $url_metal_type = str_replace(' ', '-', $url_metal_type);
                                    $url_metal_type = str_replace('/', '-', $url_metal_type);

                                    $url_setting_name = strtolower(str_replace('&', '%26', $setting['ringData']['settingName']));
                                    $url_setting_name = str_replace(' ', '-', $url_setting_name);
                                    $url_setting_name = str_replace('/', '-', $url_setting_name);
                                    
                                    $newringurl = $url_metal_type.'-metaltype-'.$url_setting_name;
                                 ?>
                                    <option <?php if($singlemetaltype['metaltype'] == $setting['ringData']['metalType']){ ?> value="<?php echo $setting['ringData']['settingId']; ?>" <?php } else { ?> value="<?php echo $singlemetaltype['gfid']; ?>" <?php } ?> data-id="<?php echo $newringurl; ?>" <?php if($singlemetaltype['metaltype'] == $setting['ringData']['metalType']){ echo 'selected="selected"';} ?>><?php echo $singlemetaltype['metaltype']; ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                        <?php } ?>
                  
                           <?php if(!empty($sidestonearray) && sizeof(array_unique($sidestonearray)) >= 1){ 
                             
                              $sidestonedata = $this->ringbuilder_lib->getSidestone($setting['ringData']['metalType'],$setting['ringData']['configurableProduct']);
                              foreach ($sidestonedata as $key => $value) {
                                 $finalsidestonedata[] = $this->ringbuilder_lib->getSidestonefinal($key, $sidestonedata);
                              }
                              ?>
                           <div class="ring-size prdctdrpdwn"><span class="title"><?php echo 'Side Stone Quality'; ?></span>
                              <select class="stonequality-drpdwn" name="stonequality" id="stonequality" onchange="changequality(this)">
                                 <?php foreach ($finalsidestonedata as $singlesideStoneQuality) { 
                                    if(isset($setting['ringData']['sideStoneQuality'][0])){
                                       $currentsettingsidestoneqty = $setting['ringData']['sideStoneQuality'][0];
                                    } else {
                                       $currentsettingsidestoneqty = '';
                                    }
                                    ?>
                                    <option value="<?php echo $singlesideStoneQuality['gfInventoryId'] ?>" <?php if($singlesideStoneQuality['sideStoneQuality'] == $currentsettingsidestoneqty){ echo 'selected="selected"';} ?>><?php echo $singlesideStoneQuality['sideStoneQuality']; ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <?php }  ?>
                           <?php if(!empty($centerstonesizearray) && sizeof(array_unique($centerstonesizearray)) >= 1 && !empty($sidestonearray) && sizeof(array_unique($sidestonearray)) >= 1){ 

                               $centarstonedata = $this->ringbuilder_lib->getCenterstone($setting['ringData']['metalType'],str_replace('"]', '', str_replace('["', '', $setting['ringData']['sideStoneQuality'])),$setting['ringData']['configurableProduct']);
                                 
                              ?>
                           <div class="ring-size prdctdrpdwn"><span class="title"><?php echo 'Center Stone Size (Ct.)'; ?></span>
                              <select class="centerstonesize-drpdwn" name="centerstonesize" id="centerstonesize" onchange="changecenterstone(this)">
                                 <?php  
                                  $previousValue = array();
                                 foreach ($centarstonedata as $centkey => $singlecenterstonesizearray) { 
                                    
                                    $previousValue[] = $singlecenterstonesizearray['centerStoneSize'];
                                    if($centkey == 0){
                                       $tempvar = $singlecenterstonesizearray['centerStoneSize'];
                                       $optionval = "0 - ".$tempvar;
                                    }else{
                                       $tempvar = $previousValue[$centkey - 1] + 0.01;
                                       $optionval = $tempvar . " - ". $singlecenterstonesizearray['centerStoneSize'];
                                    }
                                    ?>
                                    <option value="<?php echo $singlecenterstonesizearray['gfInventoryId'] ?>" <?php if($singlecenterstonesizearray['gfInventoryId'] == $setting['ringData']['settingId']){ $centerStoneSize = $singlecenterstonesizearray['centerStoneSize']; echo 'selected="selected"';} ?>><?php echo $singlecenterstonesizearray['centerStoneSize']; ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <?php } elseif(!empty($centerstonesizearray) && sizeof(array_unique($centerstonesizearray)) >= 1) {
                             $centarstonedata = $this->ringbuilder_lib->getCenterstone($setting['ringData']['metalType'],null,$setting['ringData']['configurableProduct']);

                              ?>
                              
                              <div class="ring-size prdctdrpdwn"><span class="title"><?php echo 'Center Stone Size (Ct.)'; ?></span>
                                 <select class="centerstonesize-drpdwn" name="centerstonesize" id="centerstonesize" onchange="changecenterstone(this)">
                                    <?php  
                                    $previousValue = array();
                                    foreach ($centarstonedata as $centkey => $singlecenterstonesizearray) {
                                       $previousValue[] = $singlecenterstonesizearray['centerStoneSize'];
                                    if($centkey == 0){
                                       $tempvar = $singlecenterstonesizearray['centerStoneSize'];
                                       $optionval = "0 - ".$tempvar;
                                    }else{
                                       $tempvar = $previousValue[$centkey - 1] + 0.01;
                                       $optionval = $tempvar . " - ". $singlecenterstonesizearray['centerStoneSize'];
                                    }
                                     ?>
                                       <option value="<?php echo $singlecenterstonesizearray['gfInventoryId'] ?>" <?php if($singlecenterstonesizearray['gfInventoryId'] == $setting['ringData']['settingId']){ $centerStoneSize = $singlecenterstonesizearray['centerStoneSize']; echo 'selected="selected"';} ?>><?php echo $singlecenterstonesizearray['centerStoneSize']; ?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                           <?php } ?>
                           <?php } ?>

                            <?php if(!empty($diamondShapeArray) && sizeof(array_unique($diamondShapeArray)) >= 1){ 
                            
                              $diamondShapeData = $this->ringbuilder_lib->getDiamondShape($setting['ringData']['metalType'],$setting['ringData']['configurableProduct']);
                              foreach ($diamondShapeData as $key => $value) {
                                 $finalDiamondShapeData[] = $this->ringbuilder_lib->getDiamondShapeFinal($key, $diamondShapeData , $setting['ringData']['settingId']);
                              }
                              ?>
                           <div class="ring-size prdctdrpdwn"><span class="title"><?php echo 'Diamond Shape'; ?></span>
                              <select class="diamondshape-drpdwn" name="diamondshape" id="diamondshape" onchange="changediamondshape(this)">
                                 <?php foreach ($finalDiamondShapeData as $singleDiamondShape) { 
                                   
                                    if(isset($setting['ringData']['settingId'])){
                                       $currentDiamondShape = $setting['ringData']['settingId'];
                                    } else {
                                       $currentDiamondShape = '';
                                    }
                                    ?>
                                    <option value="<?php echo $singleDiamondShape['gfInventoryId'] ?>" <?php if($singleDiamondShape['gfInventoryId'] == $currentDiamondShape){ echo 'selected="selected"';} ?>><?php echo $singleDiamondShape['diamondShape']; ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <?php }  ?>

                           <?php

                            $ringsizearray = array(); 
                           if(sizeof($setting['ringData']['ringSize']) > 0){ ?>
                           <div class="ring-size prdctdrpdwn"><span class="title"><?php echo 'Ring Size'; ?></span>
                              <select class="ringsize-drpdwn" name="ring_size" id="ring_size" onchange="updatesize();">
                                 <?php foreach ($setting['ringData']['ringSize'] as $ringsize) { 
                                    $ringsizearray[] = str_replace(array('.25','.75'), array('',''), $ringsize);
                                 } ?>
                                 <option value="0"><?php echo "Select Ring Size"; ?></option>
                                 <?php foreach (array_unique($ringsizearray) as $singlevalue) { ?>
                                       <option value="<?php echo $singlevalue; ?>"><?php echo $singlevalue; ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <?php } ?>
                          
                  

                             <?php if(empty($checkDiamondCookie['diamondid'])) { ?>
                              <?php if(isset($minedDiamond) || isset($labgrownDiamond)) { ?>
                                 <div class="ring-size prdctdrpdwn"><span class="title"><?php echo 'Center Diamond Type'; ?></span>
                                       <select class="diamondtype-drpdwn" name="ring_size" id="diamond_type" onchange="changediamondtype()">
                                         <?php if ($setting['ringData']['isLabSetting'] == 1) { ?>

                                            <?php if(isset($labgrownDiamond)) { ?> 
                                               <option value="<?php echo $labgrownDiamond; ?>"> <?php echo $labgrownDiamond; ?> </option>    
                                            <?php } ?>  

                                            <?php if(isset($minedDiamond)) { ?> 
                                               <option value="<?php echo $minedDiamond; ?>"> <?php echo $minedDiamond; ?> </option>
                                            <?php } ?>
                                           
                                          <?php } else { ?>   
                                            <?php if(isset($minedDiamond)) { ?> 
                                               <option value="<?php echo $minedDiamond; ?>"> <?php echo $minedDiamond; ?> </option>
                                            <?php } ?>

                                            <?php if(isset($labgrownDiamond)) { ?> 
                                               <option value="<?php echo $labgrownDiamond; ?>"> <?php echo $labgrownDiamond; ?> </option>    
                                            <?php } ?>  

                                          <?php } ?>                               
                                       </select>
                                    </div>
                              <?php } ?> 
                           <?php } ?> 
                          
                        </div>
                        <p class="imagenote"><span><?php echo 'NOTE:'; ?></span><?php echo ' All metal color images may not be available.'; ?></p>
                        <?php if (!empty($rb_config_data->announcement_text_rbdetail)) {?>
                                    <div class="diamond-bar-detail">
                                        <?php   echo $rb_config_data->announcement_text_rbdetail; ?>   
                                    </div>
                        <?php }  ?>
                        <div class="product-controler">

                           <ul>
                              <?php if ($this->ringbuilder_lib->isHintEnabled($shop) == 'true'): ?>
                              <li><a href="javascript:;" class="showForm" onclick="CallShowform(event);" data-target="drop-hint-main"><?php echo 'Drop A Hint';?></a></li>
                              <?php endif; ?>
                              
                              <?php if ($this->ringbuilder_lib->isMoreInfoEnabled($shop) == 'true'): ?>
                              <li><a href="javascript:;" class="showForm" onclick="CallShowform(event);" data-target="req-info-main"><?php echo 'Request More Info';?></a></li>
                              <?php endif; ?>
                              <?php if ($this->ringbuilder_lib->isEmailtoFriendEnabled($shop) == 'true'): ?>
                              <li><a href="javascript:;" class="showForm" onclick="CallShowform(event);" data-target="email-friend-main"><?php echo 'E-Mail A Friend';?></a></li>
                              <?php endif; ?>
                               <?php if ($this->diamond_lib->isPrintDetailEnabled($shop) == 'true'): ?>
                              <li style="display: none;"><a href="javascript:;" data="<?php echo $printIcon; ?>" class="prinddia" id="prinddia" ><?php echo 'Print Details' ?></a></li>
                              <?php endif; ?>
                              <?php if ($this->ringbuilder_lib->isScheduleViewingEnabled($shop) == 'true'): ?>
                              <li><a href="javascript:;" class="showForm schedule-view-link" onclick="CallShowform(event);" data-target="schedule-view-main"><?php echo 'Schedule Viewing';?></a></li>
                              <?php endif; ?>
                           </ul>
                        </div>
                        <?php if($checkDiamondCookie['diamondid']){
                        
                        $diamondsetting = (json_decode($check_diamond_cookie))[0];

                        //print_r($diamondsetting);
                         
                        $carat_rang = [];
                        if(!empty($rb_config_data)){
                          $settings_carat_ranges = trim($rb_config_data->settings_carat_ranges);
                           $carat_ranges_vals = json_decode($settings_carat_ranges, true);
                           $carat_weight = $centerStoneSize;
                           $carat_rang = $carat_ranges_vals["$carat_weight"];

                           // echo "<pre>";
                           // print_r($rb_config_data->settings_carat_ranges);
                        }
   
                        $min_range = (isset($carat_rang[0]) ? $carat_rang[0] : ($centerStoneSize - 0.1));
                        $max_range = (isset($carat_rang[1]) ? $carat_rang[1] : ($centerStoneSize + 0.1));
              
                        //echo $centerStoneSize;
                        // echo $min_range;
                        // echo $max_range;


                        if ($diamondsetting->carat < $min_range || $diamondsetting->carat > $max_range) { ?>
                           <div><p style="color:red"><?php echo 'This ring will not properly fit with selected diamond.'; ?></p></div>
                        <?php } } ?>
                        
                        <div class="diamond-action">
                           <?php if($setting['ringData']['showPrice']){?>
                              <span><?php 
                              // if($setting['ringData']['currencyFrom'] == 'USD'){
                              //    $priceval = str_replace( ',', '', $setting['ringData']['cost']);
                              //    echo "$".number_format($priceval, 2,'.',',');
                              // }else{
                              //   $priceval = str_replace( ',', '', $setting['ringData']['cost']);
                              //   echo $setting['ringData']['currencyFrom'].$setting['ringData']['currencySymbol'].number_format($priceval, 2,'.',',');
                              //   //  echo $setting['ringData']['currencyFrom'].$setting['ringData']['currencySymbol'].(float)number_format((float)str_replace( ',', '', $setting['ringData']['cost']), 2, '.', '');   
                              // }   
                              $rprice = $setting['ringData']['cost'];
                              $rprice = str_replace(',', '', $rprice);
                              if($getStoreData->price_row_format == 'left'){

                                 if($setting['ringData']['currencyFrom'] == 'USD'){
 
                                   echo "$".number_format($rprice); 
 
                                 }else{
 
                                   echo number_format($rprice).' '.$setting['ringData']['currencySymbol'].' '.$setting['ringData']['currencyFrom'];
 
                                 }
                                 }else{
 
                                 if($setting['ringData']['currencyFrom'] == 'USD'){
 
                                   echo "$".number_format($rprice); 
 
                                 }else{
 
                                   echo $setting['ringData']['currencyFrom'].' '.$setting['ringData']['currencySymbol'].' '.number_format($rprice);   
 
                                 }
 
                               }
 
                                                           
                               ?>
                                 
                              </span>
                              <?php if($setting['ringData']['rbEcommerce']){?>
                                 <form action="<?php echo $this->ringbuilder_lib->getSubmitUrlRing($setting['ringData']['settingId'],$baseshopurl,$pathprefixshop); ?>" method="post" id="product_addtocart_form">
                                    <input type="hidden" name="ringsizesettingonly" id="ringsizesettingonly" value="<?php echo $setting['ringData']['ringSize']?>" />
                                    <input type="hidden" name="ringmetaltype" id="ringmetaltype" value="<?php echo $setting['ringData']['metalType']?>" />
                                    <input type="hidden" name="islabsettings" id="islabsettings" value="<?php echo $is_lab_settings?>" />
                                    <input type="hidden" name="sidestonequalityvalue" id="sidestonequalityvalue" value="<?php echo $setting['ringData']['sideStoneQuality'][0]?>" />
                                    <input type="hidden" name="centerstonesizevalue" id="centerstonesizevalue" value="<?php echo $setting['ringData']['centerStoneMinCarat']?>" />
                                    <?php if($showBuySettingOnly){ ?>
                           <div class="box-tocart">
                                       <button type="submit" title="Buy Setting Only" class="addtocart tocart" id="product_addtocart_button"><?php echo 'Buy Setting Only' ?></button>
                                    </div>
                           <?php } ?>
                                 </form>
                              <?php }?>
                           <?php }else{?>
                              <span><?php echo "Call For Price"; ?></span>
                           <?php }?>
                           <?php
                           if($checkDiamondCookie['diamondid']){
                              $redirectURI = '/diamondtools/completering/';
                           }else{
                              if($is_lab_settings == 1){
                                $redirectURI = '/diamondtools/diamondtype/navlabgrown'; 
                              }else{
                                $redirectURI = '/diamondtools/';
                              }
                           }
                           ?>
                           <form action="<?php echo $final_shop_url.$redirectURI; //echo $this->ringbuilder_lib->getAddDiamondUrl($setting['ringData']['settingId'],$final_shop_url); ?>" method="post" id="add_diamondtoring_form">
                              <input type="hidden" name="ringsizewithdia" id="ringsizewithdia" value="F" />
                              <input type="hidden" name="ringmaxcarat" id="ringmaxcarat" value="<?php echo $setting['ringData']['centerStoneMaxCarat'] ?>" />
                              <input type="hidden" name="ringmincarat" id="ringmincarat" value="<?php echo $setting['ringData']['centerStoneMinCarat'] ?>" />
                              <input type="hidden" name="centerStoneFit" id="centerStoneFit" value="<?php echo $setting['ringData']['centerStoneFit'] ?>" />
                              <input type="hidden" name="islabsettings" id="islabsettings" value="<?php echo $is_lab_settings?>" />
                              <input type="hidden" name="setting_id" id="setting_id" value="<?php echo $setting['ringData']['settingId'] ?>" />
                              <input type="hidden" name="sidestonequalityvalue" id="sidestonequalityvalue" value="<?php echo $setting['ringData']['sideStoneQuality'][0]?>" />
                              <input type="hidden" name="centerstonesizevalue" id="centerstonesizevalue" value="<?php echo $setting['ringData']['centerStoneMinCarat'].'-'.$setting['ringData']['centerStoneMaxCarat']?>" />
                              <div class="box-tocart">
                                 <?php if($checkDiamondCookie['diamondid']) { ?>            
                                       <button type="submit" title="Complete Your Ring" onclick='changeRingSize(event)' class="addtocart tocart" id="add_diamondtoring_button"><?php echo 'Complete Your Ring'?></button>
                                 <?php } else { ?>
                                       <button type="submit" title="Add Your Diamond" onclick='changeRingSize(event)' class="addtocart tocart" id="add_diamondtoring_button"><?php echo 'Add Your Diamond'?></button>
                                 <?php } ?>                                    
                              </div>
                           </form>
                     
                     <!--Tryon button-->
                     <?php 
                     $config_data = $this->general_model->getDiamondConfig($shop);
                     $charge_details = $this->general_model->getAppDetails($shop);

                     // Assuming $setting['ringData']['styleNumber'] contains your SKU value
                      $sku = $setting['ringData']['styleNumber'];

                      // Check if SKU contains a colon
                      if (strpos($sku, ':') !== false) {
                          // Extract the part of the SKU before the colon
                          $sku_parts = explode(':', $sku);
                          $sku = $sku_parts[0];
                      }

                     
                     //If enabled in Admin Setting then only show
                    if(isset($config_data->display_tryon) && $config_data->display_tryon == 1 && $shop == 'gemfind-app-store.myshopify.com' ){ 
                     $sku_first = current(array_slice(explode("-", $sku), 0, 1));
                     ?>
                     <a title="Tryon" href="https://cdn.camweara.com/gemfind/index_client.php?company_name=Gemfind&ringbuilder=1&skus=<?php echo $sku_first; ?>&buynow=0" class="tryonbtn fancybox fancybox.iframe" data-fancybox-type="iframe" id="tryon">Virtual Try On</a>
                     <?php }?>

                     <?php 
                     if(isset($config_data->display_tryon) && $config_data->display_tryon == 1 && $charge_details->plan == 'Gemfind Tryon Plan'){ 
                     $sku_first = current(array_slice(explode("-",  $sku), 0, 1));
                     ?>
                     <a title="Tryon" href="https://cdn.camweara.com/gemfind/index_client.php?company_name=Gemfind&ringbuilder=1&skus=<?php echo $sku_first; ?>&buynow=0" class="tryonbtn fancybox fancybox.iframe" data-fancybox-type="iframe" id="tryon">Virtual Try On</a>
                     <?php }?>
                     
                     <?php
                      $ringviewurl = $final_shop_url."/settings/view/path/".$ring_path;
                      //print_r($ringviewurl);
                     ?>
                     <ul class="list-inline social-share">
                        <?php if($jc_options['jc_options']->show_Pinterest_Share) { ?>
                        <li class="save_pinterest">
                           <a class="save_pint" data-pin-do="buttonPin" href="https://www.pinterest.com/pin/create/button/?url=<?php echo $ringviewurl;?>&media=<?php echo $imageurl; ?>&description=<?php echo $diamond['diamondData']['subHeader'] ?>" data-pin-height="28"></a>
                        </li>
                        <?php } ?>
                        <?php if($jc_options['jc_options']->show_Twitter_Share) { ?>
                        <li class="share_tweet">
                           <a href="https://twitter.com/share?ref_src=<?php echo $ringviewurl;?>" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                        </li>
                        <?php } ?>
                        <?php if($jc_options['jc_options']->show_Facebook_Share) { ?>
                        <li class="share_fb">
                           <div class="fb-share-button" data-href="<?php echo $ringviewurl;?>" data-layout="button" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $ringviewurl;?>" class="fb-xfbml-parse-ignore">Share</a></div>
                        </li>
                        <?php } ?>
                        <?php if($jc_options['jc_options']->show_Facebook_Like) { ?>
                        <li class="like_fb">
                           <div class="fb-like"  data-width="" data-layout="button_count" data-share="false" data-action="like" data-size="small" ></div>
                        </li>
                        <?php } ?>
                     </ul>
                        </div>
                     </div>
                  </div>
            
                  <div class="diamond-forms">
                     <?php 
                     if($setting['ringData']['metalType']){
                     $metaltype = strtolower(str_replace(' ', '-', $setting['ringData']['metalType'])).'-metaltype-';
                     } else {
                     $metaltype = '';   
                     } 
                     $name = strtolower(str_replace(' ', '-', $setting['ringData']['settingName']));
                     $sku = '-sku-'.str_replace(' ', '-', $setting['ringData']['settingId']);
                     $ringurl = $metaltype.$name.$sku;
                     ?>
                     <?php if ($this->ringbuilder_lib->isHintEnabled($shop) == true): ?>
                     <div class="form-main no-padding diamond-request-form" id="drop-hint-main">
                        <div class="requested-form">
                           <h2><?php echo 'Drop A Hint';?></h2>
                           <p><?php echo 'Because you deserve this.';?></p>
                        </div>
                        <div id="gemfind-drop-hint-required">
                           <label style="margin-left: 20px; color: red"></label>
                        </div>
                        <div class="note" style="display: none;"></div>
                        <form method="post" enctype="multipart/form-data"
                           data-hasrequired="<?php /* @escapeNotVerified */ echo '* Required Fields' ?>"
                           class="form-drop-hint" id="form-drop-hint">
                           <input name="ringurl" type="hidden" value="<?php echo $final_shop_url.'/settings/view/path/'.$ringurl; ?>">
                           <input name="settingid" type="hidden" value="<?php echo $setting['ringData']['settingId']; ?>">
                           <input name="islabsettings" type="hidden" value="<?php echo $is_lab_settings; ?>">
                           <input name="shopurl" type="hidden" value="<?php echo $shop; ?>">
                           <div class="form-field">
                              <label>
                              <input name="name" id="drophint_name" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" type="text" class="" data-validate="{required:true}" placeholder=" ">
                              <span><?php echo 'Your Name';?></span>
                              </label>
                              <label>
                              <input name="email" id="drophint_email" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" type="email" class="" data-validate="{required:true, 'validate-email':true}" placeholder=" ">
                              <span><?php echo 'Your E-mail';?></span>
                              </label>
                              <label>
                              <input name="recipient_name" id="drophint_rec_name" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" type="text" class="" data-validate="{required:true}" placeholder=" ">
                              <span><?php echo 'Hint Recipient\'s Name';?></span>
                              </label>
                              <label>
                              <input name="recipient_email" id="drophint_rec_email" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" type="email" class="" data-validate="{required:true, 'validate-email':true}" placeholder=" ">
                              <span><?php echo 'Hint Recipient\'s E-mail';?></span>
                              </label>
                              <label>
                              <input name="gift_reason" id="gift_reason" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" type="text" class="" data-validate="{required:true}" placeholder=" ">
                              <span><?php echo 'Reason For This Gift';?></span>
                              </label>
                              <label>
                              <textarea name="hint_message" rows="2" cols="20" id="drophint_message" class="" data-validate="{required:true}" placeholder="Add A Personal Message Here ..."></textarea>
                              </label>
                              <label>
                                 <div class="has-datepicker--icon">
                                    <input name="gift_deadline" id="gift_deadline" autocomplete="false" readonly title="Gift Deadline" value="" type="text" data-validate="{required:true}" placeholder="Gift Deadline">
                                 </div>
                              </label>

                              <?php if(!empty($site_key)) { ?>
                               <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>" data-badge="inline" data-size="invisible" 
                                 data-callback="setResponse">
                              </div><br>
                                  <input type="hidden" id="captcha-response" name="captcha-response" />
                                  <input type="hidden" id="secret-key" name="secret-key" value="<?php echo $secret_key; ?>" />
                              <?php } ?>
                              <div class="prefrence-action">
                                 <div class=" prefrence-action action">
                                    <button type="button" data-target="drop-hint-main" onclick="Closeform(event);" class="cancel preference-btn btn-cencel"><span><?php echo 'Cancel';?></span></button>
                                    <button type="submit" onclick="formSubmit(event,'<?php echo base_url().'ringbuilder/settings/resultdrophint'; ?>','form-drop-hint')" title="Submit" class="preference-btn">
                                    <span><?php echo 'Drop Hint';?></span>
                                    </button>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                     <?php endif; ?>
                     <?php if ($this->ringbuilder_lib->isEmailtoFriendEnabled($shop) == true): ?>
                     <div class="form-main no-padding diamond-request-form" id="email-friend-main">
                        <div class="requested-form">
                           <h2><?php echo 'E-Mail A Friend';?></h2>
                        </div>
                        <div id="gemfind-email-friend-required">
                           <label style="margin-left: 20px; color: red"></label>
                        </div>
                        <div class="note" style="display: none;"></div>
                        <form method="post" enctype="multipart/form-data"
                           data-hasrequired="<?php /* @escapeNotVerified */ echo '* Required Fields' ?>"
                           data-mage-init='{"validation":{}}'  class="form-email-friend" id="form-email-friend">
                           <input name="ringurl" type="hidden" value="<?php echo $final_shop_url.'/settings/view/path/'.$ringurl; ?>">
                           <input name="settingid" type="hidden" value="<?php echo $setting['ringData']['settingId']; ?>">
                           <input name="islabsettings" type="hidden" value="<?php echo $is_lab_settings; ?>">
                           <input name="shopurl" type="hidden" value="<?php echo $shop; ?>">
                           <div class="form-field">
                              <label>
                              <input id="email_frnd_name" name="name" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" placeholder=""  type="text" class="" data-validate="{required:true}">
                              <span for="email_frnd_name"><?php echo 'Your Name';?></span>
                              </label>
                              <label>
                              <input name="email" type="email"  onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" placeholder=""  id="email_frnd_email" class="" data-validate="{required:true}">
                              <span><?php echo 'Your E-mail';?></span>
                              </label>
                              <label>
                              <input name="friend_name" type="text" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" placeholder="" id="email_frnd_fname" class="" data-validate="{required:true}">
                              <span><?php echo 'Your Friend\'s Name';?></span>
                              </label>
                              <label>
                              <input name="friend_email" type="email" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" placeholder=""  id="email_frnd_femail" class="" data-validate="{required:true}">
                              <span><?php echo 'Your Friend\'s E-mail';?></span>
                              </label>
                              <label>
                              <textarea name="message" rows="2" placeholder="Add A Personal Message Here ..."  cols="20" id="email_frnd_message" class="" data-validate="{required:true}"></textarea>
                              </label>

                              <?php if(!empty($site_key)) { ?>
                                <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>" data-badge="inline" data-size="invisible" 
                                 data-callback="setResponse">
                              </div><br><br>
                                  <input type="hidden" id="captcha-response-two" name="captcha-response-two" />
                                  <input type="hidden" id="secret-key" name="secret-key" value="<?php echo $secret_key; ?>" />
                                <?php } ?>
                              <div class="prefrence-action">
                                 <div class=" prefrence-action action">
                                    <button type="button" data-target="email-friend-main" onclick="Closeform(event);" class="cancel preference-btn btn-cencel"><span><?php echo 'Cancel';?></span></button>
                                    <button type="submit" onclick="formSubmit(event,'<?php echo base_url().'ringbuilder/settings/resultemailfriend'; ?>','form-email-friend')" title="Submit" class="preference-btn">
                                    <span><?php echo 'Send To Friend';?></span>
                                    </button>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                     <?php endif; ?>
                     <?php if ($this->ringbuilder_lib->isMoreInfoEnabled($shop) == true): ?>
                     <div class="form-main no-padding diamond-request-form" id="req-info-main">
                        <div class="requested-form">
                           <h2><?php echo 'Request More Information';?></h2>
                           <p><?php echo 'Our specialists will contact you.';?></p>
                        </div>
                        <div id="gemfind-request-moreinfo-required">
                           <label style="margin-left: 20px; color: red"></label>
                        </div>
                        <div id="gemfind-request-more-required">
                           <label style="margin-left: 20px; color: red"></label>
                        </div>
                        <div class="note" style="display: none;"></div>
                        <form method="post" enctype="multipart/form-data"
                           data-hasrequired="<?php /* @escapeNotVerified */ echo '* Required Fields' ?>"
                           data-mage-init='{"validation":{}}'  class="form-request-info" id="form-request-info">
                           <input name="ringurl" type="hidden" value="<?php echo $final_shop_url.'/settings/view/path/'.$ringurl; ?>">
                           <input name="settingid" type="hidden" value="<?php echo $setting['ringData']['settingId']; ?>">
                            <input name="shopurl" type="hidden" value="<?php echo $shop; ?>">
                            <input name="islabsettings" type="hidden" value="<?php echo $is_lab_settings; ?>">
                           <div class="form-field">
                              <label>
                              <input name="name" type="text" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" id="reqinfo_name" placeholder=""  class="" data-validate="{required:true}">
                              <span><?php echo 'Your Name';?></span>
                              </label>
                              <label>
                              <input name="email" type="email" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" id="reqinfo_email" placeholder=""  class="" data-validate="{required:true}">
                              <span><?php echo 'Your E-mail Address';?></span>
                              </label>
                              <label>
                              <input name="phone" type="text" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" id="reqinfo_phone" placeholder=""  class="" data-validate="{required:true}">
                              <span><?php echo 'Your Phone Number';?></span>
                              </label>
                              <label>
                              <textarea name="hint_message" rows="2" cols="20" placeholder="Add A Personal Message Here ..."  id="reqinfo_message" class="" data-validate="{required:true}"></textarea>
                              </label>
                              <div class="prefrence-area">
                                 <p><?php echo 'Contact Preference:';?></p>
                                 <ul class="pref_container">
                                    <li>
                                       <input type="radio" class="radio required-entry"  name="contact_pref" value="By Email">
                                       <label><?php echo 'By Email';?></label>
                                    </li>
                                    <li>
                                       <input type="radio" class="radio required-entry"  name="contact_pref" value="By Phone">
                                       <label><?php echo 'By Phone';?></label>
                                    </li>
                                 </ul>
                                 <br><br>

                              <?php if(!empty($site_key)) { ?>
                                 <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>" data-badge="inline" data-size="invisible" 
                                          data-callback="setResponse">
                                    </div><br>
                                  <input type="hidden" id="captcha-response-one" name="captcha-response-one" />
                                  <input type="hidden" id="secret-key" name="secret-key" value="<?php echo $secret_key; ?>" />
                                <?php } ?>
                                 <div class="prefrence-action">
                                    <div class=" prefrence-action action">
                                       <button type="button" data-target="req-info-main" onclick="Closeform(event);" class="cancel preference-btn btn-cencel">
                                       <span><?php echo 'Cancel';?></span>
                                       </button>
                                       <button type="submit" onclick="formSubmit(event,'<?php echo base_url().'ringbuilder/settings/resultreqinfo'; ?>','form-request-info')" title="Submit" class="preference-btn">
                                       <span><?php echo 'Request';?></span>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                     <?php endif; ?>
                     <?php if ($this->ringbuilder_lib->isScheduleViewingEnabled($shop) == true): ?>
                     <div class="form-main no-padding diamond-request-form" id="schedule-view-main">
                        <div class="requested-form">
                           <h2><?php echo 'Schedule A Viewing';?></h2>
                           <p><?php echo 'See This Item & More In Our Store';?></p>
                        </div>                        
                        <div id="gemfind-schedule-view-required">
                           <label style="margin-left: 20px; color: red"></label>
                        </div>
                        <div class="note" style="display: none;"></div>
                        <form method="post" enctype="multipart/form-data"
                           data-hasrequired="<?php /* @escapeNotVerified */ echo '* Required Fields' ?>"
                           data-mage-init='{"validation":{}}'  class="form-schedule-view" id="form-schedule-view">
                           <input name="ringurl" type="hidden" value="<?php echo $final_shop_url.'/settings/view/path/'.$ringurl; ?>">
                           <input name="settingid" type="hidden" value="<?php echo $setting['ringData']['settingId']; ?>">
                            <input name="shopurl" type="hidden" value="<?php echo $shop; ?>">
                            <input name="islabsettings" type="hidden" value="<?php echo $is_lab_settings; ?>">
                           <div class="form-field">
                              <label>
                              <input name="name" type="text" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" id="schview_name" placeholder=""  class="" data-validate="{required:true}">
                              <span><?php echo 'Your Name';?></span>
                              </label>
                              <label>
                              <input name="email" type="email" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" id="schview_email" placeholder=""  class="" data-validate="{required:true}">
                              <span><?php echo 'Your E-mail Address';?></span>
                              </label>
                              <label>
                              <input name="phone" type="text" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" id="schview_phone" placeholder=""  class="" data-validate="{required:true}">
                              <span><?php echo 'Your Phone Number';?></span>
                              </label>
                              <label>
                              <textarea name="hint_message" rows="2" cols="20" placeholder="Add A Personal Message Here ..."  id="schview_message" class="" data-validate="{required:true}"></textarea>
                              </label>
                              <label>
                                 <select data-validate="{required:true}" name="location"  placeholder=""  id="schview_loc">
                                    <option value=""><?php echo '--Location--'; ?></option>
                                    <?php 
                                       $retailerInfo = (array) $setting['ringData']['retailerInfo'];
                                       //$addressList = (array) $retailerInfo['addressList'];
                                       $addressList = (array) $setting['ringData']['addressList'];

                                        ?>
                                    <?php foreach ($addressList as $value) { $value = (array) $value; ?>   
                                    <option data-locationid="<?php echo $value['locationID']; ?>" value="<?php echo $value['locationName']; ?>"><?php echo $value['locationName']; ?></option>
                                    <?php } ?>
                                 </select>
                              </label>
                              <label>
                                 <div class="has-datepicker--icon">
                                    <input name="avail_date" id="avail_date" readonly autocomplete="false" placeholder="When are you available?"  title="When are you available?" value="" type="text" data-validate="{required:true}">
                                 </div>
                              </label>
                              <?php
                        /*echo "<pre>";
                        print_r((array) $retailerInfo['timingList']);*/
                        $timingListArr = (array)$setting['ringData']['timingList'];
                        if(empty($timingListArr)) 
                        {
                           ?>
                           <label class="timing_not_avail" style="display:none;">Slots not available on selected date</label>
                           <?php
                        }
                        else
                        {
                           foreach($timingListArr as $key => $timingList){
                                 $timingDays[0] = array(
                                    "sundayStart" => $timingList->sundayStart,
                                    "sundayEnd" => $timingList->sundayEnd
                                 );
                                 $timingDays[1] = array(
                                    "mondayStart" => $timingList->mondayStart,
                                    "mondayEnd" => $timingList->mondayEnd
                                 );
                                 $timingDays[2] = array(
                                    "tuesdayStart" => $timingList->tuesdayStart,
                                    "tuesdayEnd" => $timingList->tuesdayEnd
                                 );
                                 $timingDays[3] = array(
                                    "wednesdayStart" => $timingList->wednesdayStart,
                                    "wednesdayEnd" => $timingList->wednesdayEnd
                                 );
                                 $timingDays[4] = array(
                                    "thursdayStart" => $timingList->thursdayStart,
                                    "thursdayEnd" => $timingList->thursdayEnd
                                 );
                                 $timingDays[5] = array(
                                    "fridayStart" => $timingList->fridayStart,
                                    "fridayEnd" => $timingList->fridayEnd
                                 );
                                 $timingDays[6] = array(
                                    "saturdayStart" => $timingList->saturdayStart,
                                    "saturdayEnd" => $timingList->saturdayEnd
                                 );
                                 if($timingList->storeClosedSun == "Yes")
                                 {
                                    $dayStatusArr[0] = 0;
                                 }
                                 if($timingList->storeClosedMon == "Yes")
                                 {
                                    $dayStatusArr[1] = 1;
                                 }
                                 if($timingList->storeClosedTue == "Yes")
                                 {
                                    $dayStatusArr[2] = 2;
                                 }
                                 if($timingList->storeClosedWed == "Yes")
                                 {
                                    $dayStatusArr[3] = 3;
                                 }
                                 if($timingList->storeClosedThu == "Yes")
                                 {
                                    $dayStatusArr[4] = 4;
                                 }
                                 if($timingList->storeClosedFri == "Yes")
                                 {
                                    $dayStatusArr[5] = 5;
                                 }
                                 if($timingList->storeClosedSat == "Yes")
                                 {
                                    $dayStatusArr[6] = 6;
                                 }
                                 ?>
                                 <span class="timing_days" data-location="<?php echo $timingList->locationID;?>" style="display:none;"><?php echo json_encode($timingDays);?></span>
                                 <?php
                                 foreach($dayStatusArr as $key => $value)
                                 {
                                    ?>
                                    <span style="display:none;" class="day_status_arr"><?php echo $value;?></span>
                                    <?php
                                 }  
                              }
                           ?>
                           <label>
                             <select id="appnt_time" class=""  placeholder=""  name="appnt_time" style="display:none;"></select>
                           </label>
                           <?php } ?>


                            <?php if(!empty($site_key)) { ?>
                            <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>" data-badge="inline" data-size="invisible" 
                                 data-callback="setResponse">
                              </div><br>
                                  <input type="hidden" id="captcha-response-three" name="captcha-response-three" />
                                  <input type="hidden" id="secret-key" name="secret-key" value="<?php echo $secret_key; ?>" />
                            <?php } ?>
                              <div class="prefrence-action">
                                 <div class=" prefrence-action action">
                                    <button type="button" data-target="schedule-view-main" onclick="Closeform(event);" class="cancel preference-btn btn-cencel"><span><?php echo 'Cancel';?></span></button>
                                    <button type="submit" onclick="formSubmit(event,'<?php echo base_url().'ringbuilder/settings/resultscheview'; ?>','form-schedule-view')" title="Submit" class="preference-btn book-slots">
                                    <span><?php echo 'Request';?></span>
                                    </button>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                     <?php endif; ?>
                  </div>
               </div>
               <div class="diamond-specification cls-for-hide" id="ring-specification">
               <div class="specification-info">
                  <div class="specification-title">
                     <h2><?php echo 'Setting Details'; ?></h2>
                     <h4>
                        <a href="javascript:;" id="dmnddtl" onclick="CallDiamondDetail();">
                           
                           <svg version="1.1" data-placement="bottom"  data-toggle="tooltip" title="Close" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 52 52" width="20px" height="20px" style="enable-background:new 0 0 52 52;display: inline;vertical-align: text-bottom; fill:#828282 !important;" xml:space="preserve">
                              <g>
                                 <path d="M26,0C11.664,0,0,11.663,0,26s11.664,26,26,26s26-11.663,26-26S40.336,0,26,0z M26,50C12.767,50,2,39.233,2,26
                                       S12.767,2,26,2s24,10.767,24,24S39.233,50,26,50z"/>
                                 <path d="M35.707,16.293c-0.391-0.391-1.023-0.391-1.414,0L26,24.586l-8.293-8.293c-0.391-0.391-1.023-0.391-1.414,0
                                    s-0.391,1.023,0,1.414L24.586,26l-8.293,8.293c-0.391,0.391-0.391,1.023,0,1.414C16.488,35.902,16.744,36,17,36
                                    s0.512-0.098,0.707-0.293L26,27.414l8.293,8.293C34.488,35.902,34.744,36,35,36s0.512-0.098,0.707-0.293
                                    c0.391-0.391,0.391-1.023,0-1.414L27.414,26l8.293-8.293C36.098,17.316,36.098,16.684,35.707,16.293z"/>
                              </g>
                           </svg>
                        </a>
                     </h4>
                  </div>
                  <ul>
                     <?php if(isset($setting['ringData']['styleNumber'])) { ?>
                     <li>
                        <div class="diamonds-details-title">
                           <p><?php echo 'Setting Number' ?></p>
                        </div>
                        <div class="diamonds-info">
                           <p><?php echo $setting['ringData']['styleNumber'] ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($setting['ringData']['cost'])) { ?>
                     <li>
                        <div class="diamonds-details-title">
                           <p><?php echo 'Price' ?></p>
                        </div>
                        <div class="diamonds-info">
                           <?php if($setting['ringData']['showPrice']){?>
                              <p><?php 
                              if($getStoreData->price_row_format == 'left'){

                                 if($setting['ringData']['currencyFrom'] == 'USD'){
 
                                   echo "$".number_format($rprice); 
 
                                 }else{
 
                                   echo number_format($rprice).' '.$setting['ringData']['currencySymbol'].' '.$setting['ringData']['currencyFrom'];
 
                                 }
                                 }else{
 
                                 if($setting['ringData']['currencyFrom'] == 'USD'){
 
                                   echo "$".number_format($rprice); 
 
                                 }else{
 
                                   echo $setting['ringData']['currencyFrom'].' '.$setting['ringData']['currencySymbol'].' '.number_format($rprice);   
 
                                 }
 
                               }
                              
                              ?></p>
                           <?php }else{?>
                              <p><?php echo "Call For Price"; ?></p>
                           <?php }?>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($setting['ringData']['metalType'])) { ?>
                     <li>
                        <div class="diamonds-details-title">
                           <p><?php echo 'Metal Type' ?></p>
                        </div>
                        <div class="diamonds-info">
                           <p><?php echo $setting['ringData']['metalType'] ?></p>
                        </div>
                     </li>
                     <?php } ?>
                  </ul>
               </div>
               <?php if($setting['ringData']['sideDiamondDetail']->noOfDiamonds != ''){ ?>
                <div class="specification-info">
                  <div class="specification-title">
                     <h2><?php echo 'Side Diamond Details' ?></h2>
                  </div>
                  <ul>
                     <?php if($setting['ringData']['sideDiamondDetail']->noOfDiamonds != '') { ?>
                     <li>
                        <div class="diamonds-details-title">
                           <p><?php echo 'Number of Diamonds' ?></p>
                        </div>
                        <div class="diamonds-info">
                           <p><?php echo $setting['ringData']['sideDiamondDetail']->noOfDiamonds ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if($setting['ringData']['sideDiamondDetail']->diamondCut != '') { ?>
                     <li>
                        <div class="diamonds-details-title">
                           <p><?php echo 'Cut' ?></p>
                        </div>
                        <div class="diamonds-info">
                           <p><?php echo $setting['ringData']['sideDiamondDetail']->diamondCut; ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if($setting['ringData']['sideDiamondDetail']->minimumCaratWeight != '') { ?>
                     <li>
                        <div class="diamonds-details-title">
                           <p><?php echo 'Minimum Carat Weight(ct.tw.)' ?></p>
                        </div>
                        <div class="diamonds-info">
                           <p><?php echo $setting['ringData']['sideDiamondDetail']->minimumCaratWeight; ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if($setting['ringData']['sideDiamondDetail']->minimumColor != '') { ?>
                     <li>
                        <div class="diamonds-details-title">
                           <p><?php echo 'Minimum Color' ?></p>
                        </div>
                        <div class="diamonds-info">
                           <p><?php echo $setting['ringData']['sideDiamondDetail']->minimumColor ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if($setting['ringData']['sideDiamondDetail']->minimumClarity != '') { ?>
                     <li>
                        <div class="diamonds-details-title">
                           <p><?php echo 'Minimum Clarity' ?></p>
                        </div>
                        <div class="diamonds-info">
                           <p><?php echo $setting['ringData']['sideDiamondDetail']->minimumClarity ?></p>
                        </div>
                     </li>
                     <?php } ?>
                  </ul>
               </div>
               <?php } ?>
               <?php 
               
               if(isset($setting['ringData']['sideDiamondDetail1']) && !empty($setting['ringData']['sideDiamondDetail1'])){ ?>
                     <div class="specification-info">
                     <div class="specification-title">
                        <h2><?php echo 'Side Diamond Details'; ?></h2>
                     </div>
                     <ul>
                     <?php $v = 1; foreach ($setting['ringData']['sideDiamondDetail1'] as $singlesideDiamondDetail1) {  ?>
                        <?php if($singlesideDiamondDetail1->noOfDiamonds != '') { ?>
                        <li>
                           <div class="diamonds-details-title">
                              <p><?php echo 'Number of Diamonds '.$v; ?></p>
                           </div>
                           <div class="diamonds-info">
                              <p><?php echo $singlesideDiamondDetail1->noOfDiamonds ?></p>
                           </div>
                        </li>
                        <?php } ?>
                        <?php if($singlesideDiamondDetail1->diamondCut != '') { ?>
                        <li>
                           <div class="diamonds-details-title">
                              <p><?php echo 'Cut '.$v; ?></p>
                           </div>
                           <div class="diamonds-info">
                              <p><?php echo $singlesideDiamondDetail1->diamondCut; ?></p>
                           </div>
                        </li>
                        <?php } ?>
                        <?php if($singlesideDiamondDetail1->minimumCaratWeight != '') { ?>
                        <li>
                           <div class="diamonds-details-title">
                              <p><?php echo 'Minimum Carat Weight(ct.tw.) '.$v; ?></p>
                           </div>
                           <div class="diamonds-info">
                              <p><?php echo $singlesideDiamondDetail1->minimumCaratWeight; ?></p>
                           </div>
                        </li>
                        <?php } ?>
                        <?php if($singlesideDiamondDetail1->minimumColor != '') { ?>
                        <li>
                           <div class="diamonds-details-title">
                              <p><?php echo 'Minimum Color '.$v; ?></p>
                           </div>
                           <div class="diamonds-info">
                              <p><?php echo $singlesideDiamondDetail1->minimumColor ?></p>
                           </div>
                        </li>
                        <?php } ?>
                        <?php if($singlesideDiamondDetail1->minimumClarity != '') { ?>
                        <li>
                           <div class="diamonds-details-title">
                              <p><?php echo 'Minimum Clarity '.$v; ?></p>
                           </div>
                           <div class="diamonds-info">
                              <p><?php echo $singlesideDiamondDetail1->minimumClarity ?></p>
                           </div>
                        </li>
                        <?php } ?>
                        <?php if($singlesideDiamondDetail1->diamondQuality != '') { ?>
                        <li>
                           <div class="diamonds-details-title">
                              <p><?php echo 'Diamond Quality '.$v; ?></p>
                           </div>
                           <div class="diamonds-info">
                              <p><?php echo $singlesideDiamondDetail1->diamondQuality ?></p>
                           </div>
                        </li>
                        <?php } ?>
                     
                  <?php $v++; } ?> 
                  </ul>
                  </div>
               <?php } ?>
               <?php if($setting['ringData']['centerStoneFit'] != ""){ ?>
               <div class="specification-info canbesetwith">
                  <div class="specification-title">
                     <h2><?php echo 'Can Be Set With' ?></h2>
                  </div>
                  <ul>
                     <?php    $centerstone = explode(',', $setting['ringData']['centerStoneFit']); ?>
                     <?php foreach ($centerstone as $centerstonesingle) { ?>
                     <li>
                        <div class="diamonds-details-title">
                           <p><?php echo $centerstonesingle; ?></p>
                        </div>
                        <div class="diamonds-info">
                           <p><?php 
                           echo $setting['ringData']['centerStoneMinCarat'].'-'.$setting['ringData']['centerStoneMaxCarat'] ?></p>
                        </div>
                     </li>
                 <?php } ?>
                  </ul>
               </div>
               <?php }  ?>
               
            </div>
            </div>
         </div>
         <?php  if($setting['ringData']['internalUselink'] == "Yes"){ ?>
         <div class="d-row">
            <?php $dealerInfoarray = (array) $setting['ringData']['retailerInfo']; ?>
            <div class="internaluse">
               <?php echo 'Internal use Only:'; ?> <a href="javascript:;" id="internaluselink" class="internaluselink" title="<?php echo 'Dealer Info'; ?>"><?php echo 'Click Here'; ?></a> <?php echo 'for Dealer Info.'; ?>
               <div class="modal fade auth-section" id="auth-section" role="dialog">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  
                </div>
                <div class="modal-body">
                  <div class="msg" id="msg"></div>
                  <form class="internaluseform" id="internaluseform" method="post">
                          <input type="password" id="auth_password" name="password" value="" placeholder="<?php echo 'Enter Your Gemfind Password'; ?>">
                          <input name="shopurl" type="hidden" value="<?php echo $shop; ?>">
                          <input name="settingId" type="hidden" value="<?php echo $setting['ringData']['settingId']; ?>">
                          <input name="isLabSetting" type="hidden" value="<?php echo $setting['ringData']['isLabSetting']; ?>">
                          <button type="submit" onclick="internaluselink()" title="Submit" class="preference-btn">
                          <span><?php echo 'Submit'; ?></span>
                          </button>
                        </form>
                </div>
              </div>
            </div>
            </div>
                      <div class="modal fade dealer-detail-section" id="dealer-detail-section" role="dialog">
                             <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h1 class="modal-title">Vendor Information</h1>
                                </div>
                                  <div class="modal-body">
                                    <div class="dealer-info-section" id="dealer-info-section">
                                  <table>
                                     <tr>
                                        <td><?php echo 'Dealer Name:'; ?></td>
                                        <td id="retailerName"></td>
                                     </tr>
                                     <tr>
                                        <td><?php echo 'Dealer Company:'; ?></td>
                                        <td id="retailerCompany"></td>
                                     </tr>
                                     <tr>
                                        <td><?php echo 'Dealer City/State:'; ?></td>
                                        <td id="retailerCity"></td>
                                     </tr>
                                     <tr>
                                        <td><?php echo 'Dealer Contact No.:'; ?></td>
                                        <td id="retailerContactNo"></td>
                                     </tr>
                                     <tr>
                                        <td><?php echo 'Dealer Email:'; ?></td>
                                        <td id="retailerEmail"></td>
                                     </tr>
                                     <tr>
                                        <td><?php echo 'Dealer Lot number of the item:'; ?></td>
                                        <td id="retailerLotNo"></td>
                                     </tr>
                                     <tr>
                                        <td><?php echo 'Dealer Stock number of the item:'; ?></td>
                                        <td id="retailerStockNo"></td>
                                     </tr>
                                     <tr>
                                        <td><?php echo 'Wholesale Price:'; ?></td>                                
                                          <td id="wholesalePrice">                                                                                
                                      </td>
                                     </tr>
                                     <tr>
                                        <td><?php echo 'Third Party:'; ?></td>
                                        <td id="thirdParty"></td>
                                     </tr>
                                     <tr>
                                        <td><?php echo 'Diamond Id:'; ?></td>
                                        <td id="diamondID"></td>
                                     </tr>
                                     <tr>
                                        <td><?php echo 'Seller Name:'; ?></td>
                                        <td id="sellerName"></td>
                                     </tr>
                                     <tr>
                                        <td><?php echo 'Seller Address:'; ?></td>
                                        <td id="sellerAddress"></td>
                                     </tr>
                                     <tr>
                                        <td><?php echo 'Dealer Fax:'; ?></td>
                                        <td id="retailerFax"></td>
                                     </tr>
                                     <tr>
                                        <td><?php echo 'Dealer Address:'; ?></td>
                                        <td id="retailerAddress"></td>
                                     </tr>
                                  </table>
                                </div>
                            </div>
                        </div>
                      </div>
                  </div>
             
            </div>
         </div>
      <?php }?>
      </div>
   </div>
<?php } else { 
   //echo 'Something went wrong with API, please try after some time!'; 
   $redirect_uri = 'https://'.$baseshopurl.'/apps/ringbuilder/settings';
   $diamond_not_found = true;
   /*$shop_main_domain*/
   $str_domain = explode(".",$shop);
   $site_cookie = "dnotfound_".$str_domain[0];
    ?>
   <div class="loading-mask gemfind-loading-mask" id="gemfind-loading-mask" style="display: block;">
      <div class="loader gemfind-loader">
         <p>Please wait...</p>
      </div>
   </div>
   <script type="text/javascript">
      var expire = new Date();
      var site_cookie = '<?php echo $site_cookie ?>';
      expire.setDate(expire.getDate() + 0.2 * 24 * 60 * 60 * 1000);
      jQuery.cookie(site_cookie, "1", {
         path: '/',
         expires: expire
      });
     window.location.href = '<?php echo $redirect_uri; ?>';
   </script>
<?php 
}
?> 
 <div id="SettingModal" class="Rbmodal">
        <!-- Modal content -->
        <div class="Rbmodal-content">

            <span class="Rbclose">&times;</span>
            <div class="loader_rb" style="display: none;">
            <img src="<?php echo base_url('assets/images/ring.gif') ?>" style="width: 200px; height: 200px;">
            </div>
            <iframe src="" id="setting_iframevideo" frameBorder="0" scrolling="no" style="width:100%; height:98%;" allow="autoplay"> </iframe>

            <video style="width:100%; height:90%;" id="setting_mp4video" loop autoplay>
                <source src=""  type="video/mp4">
            </video>
        </div>
    </div>
<script src="<?php echo base_url() ?>assets/js/custom_tryon.js?v=<?php echo time();?>"></script>
<script type="text/javascript">
   $('div.diamention img').each(function() {
            var src = $(this).attr("data-src");  
            var id = $(this).attr("id");  
            imageExists1(src, id, function(exists) {
               if(exists){
                  $('#'+id).attr('src',src);
               } else {
                  $('#'+id).attr('src','<?php echo $noimageurl ?>');
               } 
            });
         });
       
       // setTimeout(function(){ 
         // if($(".videoicon").length) 
         // {
         //    setTimeout(function(){ 
         //       document.getElementById("ringimg").style.display = "block";
         //       // document.getElementById("ringvideo").style.display = "block";
         //      }, 500);
         //    $('#ringimg img').attr('src', $('#ringimg').attr('data-loadimg'));
         // }
       //  }, 300);
       
       /*setTimeout(function(){ 
         var src = $( 'div.main_video img' ).attr("data-src");  
         imageExistsVideo(src, function(exists) {
            if(exists){
              $( 'div.main_video img' ).attr('src',src);
            } else {
              $( 'div.main_video img' ).attr('src','<?php echo $noimageurl ?>');
            } 
         });   
         $(".main_slider_loader").hide();
         $(".main_video a").click();
         //$( '#iframevideo' ).show(); 
        }, 700);
        
        function imageExistsVideo(url, callback) {
           var img = new Image();
           img.onload = function() { callback(true); };
           img.onerror = function() { callback(false); };
           img.src = url;
         }*/
      function imageExists1(url, id, callback) {
          var img = new Image();
          img.onload = function() { callback(true); };
          img.onerror = function() { callback(false); };
          img.src = url;
      }
      $("#internaluselink").on('click',function(){
                $('#msg').html('');
                $('#internaluseform input#auth_password').val('');
                $("#auth-section").modal("show");
            });


        function internaluselink(){
         $('#internaluseform').validate({
                rules: {        
                  password: {
                    required: true
                  }
              },
              submitHandler: function(form) {
            $.ajax({
                url: '<?php echo base_url() ?>'+"ringbuilder/settings/authenticate",
                data: $('#internaluseform').serialize(),
                type: 'POST',
                dataType: 'json',
                cache: true,
                beforeSend: function(settings) {
                    $('.loading-mask.gemfind-loading-mask').css('display', 'block');
                },
                success: function(response) {
                  var currencySymbol = '<?php echo $currencySymbol; ?>';
                 
                  if(response.output.status == 1){

                    var retailerName = response.output.dealerInfo.retailerName ? response.output.dealerInfo.retailerName : 'NA';
                    var retailerCompany = response.output.dealerInfo.retailerCompany ? response.output.dealerInfo.retailerCompany : 'NA';
                    var retailerCity = response.output.dealerInfo.retailerCity ? response.output.dealerInfo.retailerCity : 'NA';
                    var retailerState = response.output.dealerInfo.retailerState ? response.output.dealerInfo.retailerState : 'NA';
                    var retailerContactNo = response.output.dealerInfo.retailerContactNo ? response.output.dealerInfo.retailerContactNo : 'NA';
                    var retailerEmail = response.output.dealerInfo.retailerEmail ? response.output.dealerInfo.retailerEmail : 'NA';
                    var retailerLotNo = response.output.dealerInfo.retailerLotNo ? response.output.dealerInfo.retailerLotNo : 'NA';
                    var retailerStockNo = response.output.dealerInfo.retailerStockNo ? response.output.dealerInfo.retailerStockNo : 'NA';
                    var wholesalePrice = response.output.dealerInfo.wholesalePrice ? response.output.dealerInfo.wholesalePrice : 'NA';
                    var thirdParty = response.output.dealerInfo.thirdParty ? response.output.dealerInfo.thirdParty : 'NA';
                    var diamondID = response.output.dealerInfo.diamondID ? response.output.dealerInfo.diamondID : 'NA';
                    var sellerName = response.output.dealerInfo.sellerName ? response.output.dealerInfo.sellerName : 'NA';
                    var sellerAddress = response.output.dealerInfo.sellerAddress ? response.output.dealerInfo.sellerAddress : 'NA';
                    var retailerFax = response.output.dealerInfo.retailerFax ? response.output.dealerInfo.retailerFax : 'NA';
                    var retailerAddress = response.output.dealerInfo.retailerAddress ? response.output.dealerInfo.retailerAddress : 'NA';           


                     $('#retailerName').text(retailerName);
                     $('#retailerCompany').text(retailerCompany);
                     $('#retailerCity').text(retailerCity +'/'+ retailerState);
                     $('#retailerContactNo').text(retailerContactNo);
                     $('#retailerEmail').text(retailerEmail);
                     $('#retailerLotNo').text(retailerLotNo);
                     $('#retailerStockNo').text(retailerStockNo);
                     $('#wholesalePrice').text(currencySymbol + wholesalePrice);
                     $('#thirdParty').text(thirdParty);
                     $('#diamondID').text(diamondID);
                     $('#sellerName').text(sellerName);
                     $('#sellerAddress').text(sellerAddress);
                     $('#retailerFax').text(retailerFax);
                     $('#sellerAddress').text(sellerAddress);

              
                     $('#msg').html('<span class="success">'+response.output.msg+'</span>');
                     $("#auth-section").modal("hide");
                     $("#dealer-detail-section").modal("show");
                  } else {
                     $('#msg').html('<span class="error">'+response.output.msg+'</span>');
                     $('#internaluseform input#auth_password').val('');
                  }
                  $('.loading-mask.gemfind-loading-mask').css('display', 'none');
                }
            });
            }
            });
         
      }

      // function internaluselink(){
      //    $('#internaluseform').validate({
      //           rules: {        
      //             password: {
      //               required: true
      //             }
      //         },
      //         submitHandler: function(form) {
      //       $.ajax({
      //           url: '<?php echo base_url() ?>'+"ringbuilder/diamondtools/authenticate",
      //           data: $('#internaluseform').serialize(),
      //           type: 'POST',
      //           dataType: 'json',
      //           cache: true,
      //           beforeSend: function(settings) {
      //               $('.loading-mask.gemfind-loading-mask').css('display', 'block');
      //           },
      //           success: function(response) {
      //             console.log(response);
      //             if(response.output.status == 1){
      //                $('#msg').html('<span class="success">'+response.output.msg+'</span>');
      //                $("#auth-section").modal("hide");
      //                $("#dealer-detail-section").modal("show");
      //             } else {
      //                $('#msg').html('<span class="error">'+response.output.msg+'</span>');
      //                $('#internaluseform input#auth_password').val('');
      //             }
      //             $('.loading-mask.gemfind-loading-mask').css('display', 'none');
      //           }
      //       });
      //       }
      //       });
         
      // }


       $(document).ready(function() {
            var settingData = '<?php echo $settingData ?>';
            var post_setting_data = JSON.stringify(settingData);
            var product_track_url = window.location.href;

            console.log('coming inside tracking script');

          
                  $.ajax({
                     url: '<?php echo base_url() ?>'+"ringbuilder/settings/productTracking",
                     data: {setting_data:post_setting_data,track_url:product_track_url},
                     type: 'POST',
                     dataType: 'json',
                     success: function(response) {


                      
                     }
                     }).done(function(data) {
                        
                  });


                      $("#zoom_me").click(function() {
               //console.log($('#main_image img').attr('data-src'));
                  $.fancybox.open({
                      src  : '#hidden-content',
                      type : 'inline',
                      opts : {
                        afterShow : function( instance, current ) {
                          console.info('done!');
                        }
                      }
                    });
              });
             
      });

        // Define the initial URL values
      var url = jQuery("#add_diamondtoring_form").attr("action");
      var labgrown = url + "diamondtype/navlabgrown";
      var type = "";

      // Function to set the action URL based on the selected dropdown option
      function setActionUrl() {
          var selectedOption = jQuery('.diamondtype-drpdwn option:selected').val();
          
          if (selectedOption == "Lab Grown") {
              jQuery("#add_diamondtoring_form").attr("action", labgrown);
          } else if (selectedOption == "Mined") {
              var mined = url.replace('diamondtype/navlabgrown', '');
              jQuery("#add_diamondtoring_form").attr("action", mined);
          }
      }

      // Initial setup when the page loads
      setActionUrl();

      // Event handler for dropdown change
      function changediamondtype() {
          setActionUrl();
      }

      console.log(labgrown);
      console.log(url);

    
         
</script>

<script type="text/javascript">
   function setting()
   {
     jQuery.removeCookie('_shopify_ringsetting', {path: '/'});
     jQuery.removeCookie('_shopifysaveringbackvalue', {path: '/'});
     jQuery.removeCookie('_shopifysaveringfiltercookie', {path: '/'});
     //jQuery.removeCookie('shopifysavebackvalue', {path: '/'});
      window.location.href="<?php echo $final_shop_url.'/settings/'; ?>"
   }

   function diamond()
   {
     jQuery.removeCookie('_shopify_diamondsetting', {path: '/'});
     jQuery.removeCookie('shopifysavebackvalue', {path: '/'});
     jQuery.removeCookie('shopifysavefiltercookie', {path: '/'});
     window.location.href="<?php echo $final_shop_url.'/diamondtools/'; ?>"
   }

   function Videorun() {
    jQuery("#setting_iframevideo").removeAttr("src");
    jQuery("#setting_mp4video").removeAttr("src");
    jQuery("#setting_mp4video").attr("src", '');
    jQuery('#SettingModal').modal('show');
    jQuery('.loader_rb').show();

   var divid = jQuery(event.currentTarget).data('id');
       jQuery.ajax({
            type: "POST",
            url  : "<?php echo base_url(); ?>/ringbuilder/settings/getringvideos",
            data: {
                action: 'getringvideos',
                product_id: divid
            },
            cache: true,
            success: function(response) {
               res = JSON.parse(response);
                console.log(res);
    
                if (res.showVideo == true) {
                    var fileExtension = res.videoURL.replace(/^.*\./, '');
                    console.log (fileExtension);
                    if(fileExtension=="mp4"){
                        jQuery('#setting_iframevideo').hide();
                        setTimeout(function() {
                           jQuery("#setting_mp4video").attr("src", res.videoURL);
                           jQuery('.loader_rb').hide();
                           jQuery('#setting_mp4video').get(0).play();
                        }, 3000);
                    }
                    else{
                        jQuery('#setting_mp4video').hide();
                        setTimeout(function() {
                            jQuery("#setting_iframevideo").attr("src", res.videoURL);
                            jQuery('.loader_rb').hide();
                            jQuery('#setting_iframevideo').show();
                        }, 3000);
                    }
                }   
            }
        });
        jQuery(".Rbclose").click(function() {
        jQuery('#SettingModal').modal('hide');
        });
   }


</script>