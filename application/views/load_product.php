<?php 
$getStoreData = $this->general_model->getDiamondConfig($shop);
$site_key=$getStoreData->site_key;
$secret_key=$getStoreData->secret_key;
?>

 <!-- Form Captcha Start-->

 <?php if(!empty($site_key)) { ?>
 <script>
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
</script> 
<script
    src="https://www.google.com/recaptcha/api.js?onload=onloadCallback"
    async defer></script>

    <script>
var onloadCallback = function() {
    grecaptcha.execute();
};

function setResponse(response) { 
    document.getElementById('captcha-response-four').value = response;  
    document.getElementById('captcha-response-five').value = response;
    document.getElementById('captcha-response-six').value = response;
    document.getElementById('captcha-response-seven').value = response;     
}
</script>

<?php } ?>

<div id="fb-root"></div>

<?php if(!empty($site_key)) { ?>
  <script type="text/javascript">
     function onSubmit(token) {
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

 <?php } ?>

 <style type="text/css">
  
.grecaptcha-badge{
      visibility: visible !important;
       bottom: 110px !important;
}
</style> 

<!-- Form Captcha Ends-->

<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v9.0&appId=1003857163475797&autoLogAppEvents=1" nonce="Uo0Kr4VM"></script>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('common');

$noimageurl = base_url() . "/assets/images/no-image.jpg";
$loadingimageurl = base_url() . "/assets/images/loader-2.gif";
$tszview = base_url() . "/assets/images/360-view.png";
$printIcon = base_url() . "/assets/images/print_icon.gif";

$diamondtype = $this->uri->segment(4);

$diamond = $this->diamond_lib->getProduct($diamond_path, $diamond_type, $shop);

$diamondData = $this->diamond_lib->getProduct($diamond_path, $diamond_type, $shop);

if (isset($diamondData['diamondData'])) {
    $unsetKeys = [
        'contactNo',
        'contactEmail',
        'costPerCarat',
        'vendorName',
        'vendorEmail',
        'vendorContactNo',
        'vendorAddress',
        'wholeSalePrice',
        'vendorStockNo',
        'vendorID',
        'vendorFax',
        'retailerStockNo'
    ];

   
    foreach ($unsetKeys as $key) {
        unset($diamondData['diamondData'][$key]);
    }

    if (isset($diamondData['diamondData']['retailerInfo'])) {
        $unsetRetailerKeys = [
            'retailerCompany',
            'retailerName',
            'retailerCity',
            'retailerState',
            'retailerContactNo',
            'retailerEmail',
            'retailerLotNo',
            'retailerStockNo',
            'wholesalePrice',
            'thirdParty',
            'sellerName',
            'sellerAddress',
            'retailerAddress',
        ];

        foreach ($unsetRetailerKeys as $key) {
           
            unset($diamondData['diamondData']['retailerInfo']->$key);
        }
    }
}

//file_put_contents('pathlog.txt', json_encode($diamond));

$access_token = $this->diamond_lib->getShopAccessToken($shop);
$base_shop_domain = actual_shop_address($access_token, $shop, $pathprefixshop);

//redirect($final_shop_url.'/settings'); 
$checkRingCookieData = (json_decode($check_ring_cookie_data))[0];
// print_r($check_ring_cookie_data);
// exit;
$jc_options = $this->diamond_lib->getJCOptions($shop);
$data = $this->general_model->getDiamondConfig($shop);

$rb_config_data = $this->diamond_lib->getRBConfigAdmin($shop);
$carat_rang = [];
if (!empty($rb_config_data)) {
   $settings_carat_ranges = trim($rb_config_data->settings_carat_ranges);
   $carat_ranges_vals = json_decode($settings_carat_ranges, true);

   $carat_weight = $diamond['diamondData']['caratWeight'];
   $carat_rang = $carat_ranges_vals["$carat_weight"];
}
?>
<?php if (sizeof($diamond['diamondData']) > 0) {
   $diamondid = $diamond['diamondData']['diamondId'];
   $hasvideo = $type = 0;

   if (isset($diamond['diamondData']['videoFileName']) && $diamond['diamondData']['videoFileName'] != '' && $diamond['diamondData']['videoFileName'] != "0") {
      $headers = is_404($diamond['diamondData']['videoFileName']);
      if ($headers) {
         $hasvideo = 1;
         if (strpos($diamond['diamondData']['videoFileName'], '.mp4') !== false) {
            $type = 1;
         } else {
            $type = 2;
         }
      }
   } else {
      $hasvideo = 0;
   }

?>
   <?php if (isset($diamond['diamondData']['image1'])) {
      $imgurl = $diamond['diamondData']['image1'];
   }
   ?>
   <?php if ($diamond['diamondData']['fancyColorMainBody']) {
      if (is_404($diamond['diamondData']['colorDiamond'])) {
         $imageurl = $diamond['diamondData']['colorDiamond'];
      } else {
         $imageurl = $noimageurl;
      }
   } else {
      if (is_404($diamond['diamondData']['image2'])) {
         $imageurl = $diamond['diamondData']['image2'];
      } else {
         $imageurl = $noimageurl;
      }
   } ?>
   <?php
   if ($is_lab_settings == 1) {
      $add_lab_url = 'islabsettings/1';
   }

   if($diamond['diamondData']['currencyFrom'] == 'USD'){
      $currencySymbol = '$';
   }else{
      $currencySymbol = $diamond['diamondData']['currencyFrom'].$diamond['diamondData']['currencySymbol'];
   }

   ?>
   <style type="text/css">
      .main_slider_loader {
         display: block;
      }

      #iframevideo {
         display: none;
      }
   </style>
   <section class="diamonds-search with-specification diamond-page flow-tabs">
      <?php if (!empty($rb_config_data->announcement_text)) { ?>
         <div class="diamond-bar">
            <?php echo $rb_config_data->announcement_text; ?>
         </div>
      <?php }  ?>
      <div class="tab-section">

         <ul class="tab-ul">

            <?php if ($checkRingCookieData) { ?>
               <li class="tab-li">
                  <div><a href="javascript:;" onclick="setting()"><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Setting'; ?></strong></span><i class="ring-icon tab-icon"></i></a></div>
               </li>
            <?php } else { ?>
               <li class="tab-li active">
                  <div><a href="javascript:;" onclick="diamond()"><i class="back-icon"></i><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Diamond'; ?></strong></span><i class="diamond-icon tab-icon"></i></a></div>
               </li>
            <?php } ?>
            <?php if (!$checkRingCookieData) { ?>
               <li class="tab-li">
                  <div><a href="javascript:;" onclick="setting()"><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Setting'; ?></strong></span><i class="ring-icon tab-icon"></i></a></div>
               </li>
            <?php } else { ?>
               <li class="tab-li active">
                  <div><a href="javascript:;" onclick="diamond()"><i class="back-icon"></i><span class="tab-title"><?php echo 'Choose Your'; ?><strong><?php echo 'Diamond'; ?></strong></span><i class="diamond-icon tab-icon"></i></a></div>
               </li>
            <?php } ?>
            <li class="tab-li">
               <div><a href="javascript:;"><span class="tab-title"><?php echo 'Review'; ?><strong><?php echo 'Complete Ring'; ?></strong></span><i class="finalring-icon tab-icon"></i></a></div>
            </li>

         </ul>

      </div>
      <div class="d-container">
         <div class="d-row">
            <div class="diamonds-preview no-padding">
               <div class="diamond-info">
                  <div class="product-thumb">
                     <?php if (isset($diamond['diamondData']['image1'])) { ?>
                        <div class="thumg-img diamention">
                           <a href="javascript:;" onclick="Imageswitch1(event);">
                              <img src="<?php echo $loadingimageurl; ?>" data-src="<?php echo $diamond['diamondData']['image1'] ?>" style="width:auto; height: 40px; object-fit: contain;" alt="<?php echo $diamond['diamondData']['mainHeader'] ?>" title="<?php echo $diamond['diamondData']['mainHeader'] ?>" class="thumbimg" id="thumbimg1" />
                           </a>
                        </div>
                     <?php } ?>
                     <div class="thumg-img main_image">
                        <a href="javascript:;" onclick="Imageswitch2(event);">
                           <img src="<?php echo $loadingimageurl; ?>" data-src="<?php echo $imageurl ?>" style="width:40px; height: 40px;" alt="<?php echo $diamond['diamondData']['mainHeader'] ?>" title="<?php echo $diamond['diamondData']['mainHeader'] ?>" class="thumbimg" id="thumbimg2" />
                        </a>
                     </div>
                     <?php if ($hasvideo) { ?>
                        <?php if ($type == 1) { ?>
                           <div class="thumg-img main_video">
                              <a href="javascript:;" class="videoicon" data-id="<?php echo $diamond['diamondData']['diamondId']; ?>" onclick="VideorunDb()">
                                 <img style="height: 40px;" src="<?php echo $tszview ?>" id="img1iframe" class="video" />
                              </a>
                           </div>
                        <?php } else { ?>
                           <div class="thumg-img main_video">
                              <a href="javascript:;" class="videoicon" data-id="<?php echo $diamond['diamondData']['diamondId']; ?>" onclick="VideorunDb()">
                                 <img style="height: 40px;" src="<?php echo $tszview ?>" id="img1iframe" class="iframe">
                              </a>
                           </div>
                        <?php } ?>
                     <?php } ?>
                  </div>
                  <div class="diamond-image">
   
                     <div class="diamondimg" id="diamondimg" data-loadimg="<?php echo $loadingimageurl; ?>">
                        <img src="<?php echo $imageurl; ?>" id="diamondmainimage" alt="<?php echo $diamond['diamondData']['mainHeader'] ?>" title="<?php echo $diamond['diamondData']['mainHeader'] ?>">
                     </div>
                  </div>
                  <?php
                  if ($jc_options['jc_options']->show_In_House_Diamonds_First) {
                  ?><h2 style="text-transform:capitalize;"><?php echo 'Stock Number '; ?><span><?php echo $diamond['diamondData']['stockNumber']; ?></span></h2><?php
                                                                                                                                                               } else {
                                                                                                                                                                  ?><h2><?php echo 'SKU#'; ?><span><?php echo $diamond['diamondData']['diamondId']; ?></span></h2><?php
                                                                                                                                                                                                                                                               }
                                                                                                                                                                                                                                                                  ?>
                  <?php if ($shop !== 'earthena-jewelry.myshopify.com') { ?>
                  <div class="diamond-report">
                     <?php $report_available = TRUE; ?>
                     
                     <?php if ($jc_options['jc_options']->show_Certificate_in_Diamond_Search) { ?>
                        <p><b><?php echo 'Diamond Grading Report: '; ?></b></p>
                        <div class="view_text">
                           <?php if ($diamond['diamondData']['certificateUrl']) { ?>
                              <a href="javascript:void(0);" onclick="javascript:window.open('<?php echo $diamond['diamondData']['certificateUrl']; ?>','CERTVIEW','scrollbars=yes,resizable=yes,width=860,height=550')"><?php echo ' View'; ?></a>
                           <?php } else { ?>
                              <?php $report_available = FALSE; ?>
                              <p>Not Available</p>
                           <?php } ?>
                        </div>
                     <?php } ?>                    
                  </div>
                  <?php } ?>
                  <?php if ($jc_options['jc_options']->show_Certificate_in_Diamond_Search) { ?>
                     <div class="diamond-grade">
                        <div class="grade-logo">
                           <img src="<?php echo $diamond['diamondData']['certificateIconUrl'] ?>" style="width:94px; height: 94px; max-width:inherit;" alt="<?php echo $diamond['diamondData']['mainHeader'] ?>" title="<?php echo $diamond['diamondData']['mainHeader'] ?>">
                        </div>
                        <div class="grade-info">
                           <?php if ($report_available) { ?>
                              <p><?php echo $diamond['diamondData']['subHeader'] ?></p>
                           <?php } else { ?>
                              <p>Not available, please contact retailer.</p>
                           <?php } ?>
                        </div>
                     </div>
                  <?php } ?>
               </div>
               <?php if ($diamond['diamondData']['internalUselink'] == 'Yes') { ?>
                  <?php $dealerInfoarray = (array) $diamond['diamondData']['retailerInfo']; ?>
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
                                    <input name="diamondId" type="hidden" value="<?php echo $diamond['diamondData']['diamondId']; ?>">
                                    <input name="diamondtype" type="hidden" value="<?php echo $diamond_type ?>">
                                    <button type="submit" onclick="internaluselink()" title="Submit" class="preference-btn">
                                       <span><?php echo 'Submit'; ?></span>
                                    </button>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                      <div class="modal fade dealer-detail-section" id="dealer-detail-section" tabindex="-1" aria-hidden="true" role="dialog">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
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
               <?php } ?>
            </div>
            <div class="diamonds-details no-padding diamond-request-form">
               <div class="diamond-data" id="diamond-data">
                  <div class="specification-title">
                     <h2><?php echo $diamond['diamondData']['mainHeader'] ?></h2>
                     <h4 class="spec-icon diamond_spec_container" id="rb-dl-specification-title-desktop"><span class="diamond_spec" onclick="CallSpecification();">Diamond Specification</span><a href="javascript:;" title="Diamond Specification" id="spcfctn" onclick="CallSpecification();">
                           <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" xml:space="preserve">
                              <g>
                                 <g id="New_x5F_Post">
                                    <g>
                                       <path d="M545.062,286.875c-15.854,0-28.688,12.852-28.688,28.688v239.062h-459v-459h239.062
                                       c15.854,0,28.688-12.852,28.688-28.688S312.292,38.25,296.438,38.25H38.25C17.136,38.25,0,55.367,0,76.5v497.25
                                       C0,594.883,17.136,612,38.25,612H535.5c21.114,0,38.25-17.117,38.25-38.25V315.562
                                       C573.75,299.727,560.917,286.875,545.062,286.875z M605.325,88.95L523.03,6.655C518.556,2.18,512.684,0,506.812,0
                                       s-11.743,2.18-16.218,6.675l-318.47,318.45v114.75h114.75l318.45-318.45c4.494-4.495,6.675-10.366,6.675-16.237
                                       C612,99.297,609.819,93.445,605.325,88.95z M267.75,382.5H229.5v-38.25L506.812,66.938l38.25,38.25L267.75,382.5z" />
                                    </g>
                                 </g>
                              </g>
                           </svg>
                        </a>
                     </h4>
                  </div>
                  <div class="diamond-content-data" id="diamond-content-data">
                     <?php if ($jc_options['jc_options']->show_Certificate_in_Diamond_Search) { ?>
                        <div class="diamond-desc">
                           <p><?php echo $diamond['diamondData']['subHeader'] ?></p>
                        </div>
                     <?php } ?>
                     <div class="form-field diamonds-info">
                       <div class="intro-field">
                           <ul>
                             <li>
                                 <strong><?php echo 'Cut :' ?></strong>
                                 <p><?php if ($diamond['diamondData']['cut'] != '') {
                                       echo $diamond['diamondData']['cut'];
                                    } else {
                                       echo 'NA';
                                    } ?></p>
                              </li>
                              <li>
                                 <strong><?php echo 'Polish :'; ?></strong>
                                 <p><?php if ($diamond['diamondData']['polish'] != '') {
                                       echo $diamond['diamondData']['polish'];
                                    } else {
                                       echo 'NA';
                                    } ?></p>
                              </li>
                               <li>
                                 <strong><?php echo 'Symmetry :'; ?></strong>
                                 <p><?php if ($diamond['diamondData']['symmetry'] != '') {
                                       echo $diamond['diamondData']['symmetry'];
                                    } else {
                                       echo 'NA';
                                    } ?></p>
                              </li>                            
                           </ul>
                           <ul>
                              <li>
                                 <strong><?php echo 'Color :' ?></strong>
                                 <p><?php
                                    if ($diamond['diamondData']['fancyColorMainBody']) {
                                       echo $diamond['diamondData']['fancyColorIntensity'] . ' ' . $diamond['diamondData']['fancyColorMainBody'];
                                    } elseif ($diamond['diamondData']['color'] != '') {
                                       echo $diamond['diamondData']['color'];
                                    } else {
                                       echo 'NA';
                                    }
                                    ?></p>
                              </li>
                              <li>
                                 <strong><?php echo 'Clarity :'; ?></strong>
                                 <p><?php if ($diamond['diamondData']['clarity'] != '') {
                                       echo $diamond['diamondData']['clarity'];
                                    } else {
                                       echo 'NA';
                                    } ?></p>
                              </li>
                               <li>
                                 <strong><?php echo 'Fluorescence :'; ?></strong>
                                 <p><?php if ($diamond['diamondData']['fluorescence'] != '') {
                                       echo $diamond['diamondData']['fluorescence'];
                                    } else {
                                       echo 'NA';
                                    } ?></p>
                              </li>
                           </ul>
                        </div>
                        <div class="specification-title" >
                           <h4 class="spec-icon diamond_spec_container" id="rb-dl-specification-title-mobile"><span class="diamond_spec" onclick="CallSpecification();">Diamond Specification</span><a href="javascript:;" title="Diamond Specification" id="spcfctn" onclick="CallSpecification();">
                                 <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" xml:space="preserve">
                                    <g>
                                       <g id="New_x5F_Post">
                                          <g>
                                             <path d="M545.062,286.875c-15.854,0-28.688,12.852-28.688,28.688v239.062h-459v-459h239.062
                                             c15.854,0,28.688-12.852,28.688-28.688S312.292,38.25,296.438,38.25H38.25C17.136,38.25,0,55.367,0,76.5v497.25
                                             C0,594.883,17.136,612,38.25,612H535.5c21.114,0,38.25-17.117,38.25-38.25V315.562
                                             C573.75,299.727,560.917,286.875,545.062,286.875z M605.325,88.95L523.03,6.655C518.556,2.18,512.684,0,506.812,0
                                             s-11.743,2.18-16.218,6.675l-318.47,318.45v114.75h114.75l318.45-318.45c4.494-4.495,6.675-10.366,6.675-16.237
                                             C612,99.297,609.819,93.445,605.325,88.95z M267.75,382.5H229.5v-38.25L506.812,66.938l38.25,38.25L267.75,382.5z" />
                                          </g>
                                       </g>
                                    </g>
                                 </svg>
                              </a>
                           </h4>
                         </div>
                        <div class="product-controler">
                           <ul>
                              <?php if ($this->diamond_lib->isHintEnabled($shop) == 'true') : ?>
                                 <li><a href="javascript:;" class="showForm" onclick="CallShowform(event);" data-target="drop-hint-main"><?php echo 'Drop A Hint'; ?></a></li>
                              <?php endif; ?>
                              <?php if ($this->diamond_lib->isMoreInfoEnabled($shop) == 'true') : ?>
                                 <li><a href="javascript:;" class="showForm" onclick="CallShowform(event);" data-target="req-info-main"><?php echo 'Request More Info'; ?></a></li>
                              <?php endif; ?>
                              <?php if ($this->diamond_lib->isEmailtoFriendEnabled($shop) == 'true') : ?>
                                 <li><a href="javascript:;" class="showForm" onclick="CallShowform(event);" data-target="email-friend-main"><?php echo 'E-Mail A Friend'; ?></a></li>
                              <?php endif; ?>
                              <?php if ($this->diamond_lib->isPrintDetailEnabled($shop) == 'true') : ?>
                                 <li><a href="javascript:;" data="<?php echo $printIcon; ?>" class="prinddia" id="prinddia"><?php echo 'Print Details' ?></a></li>
                              <?php endif; ?>
                              <?php if ($this->diamond_lib->isScheduleViewingEnabled($shop) == 'true') : ?>
                                 <li><a href="javascript:;" class="showForm" onclick="CallShowform(event);" data-target="schedule-view-main"><?php echo 'Schedule Viewing'; ?></a></li>
                              <?php endif; ?>
                           </ul>
                        </div>
                        <div class="diamond-action">
                           <?php if ($diamond['diamondData']['showPrice']) { ?>
                              <span><?php
                               $dprice = $diamond['diamondData']['fltPrice'];
                               $dprice = str_replace(',', '', $dprice);
                               if($data->price_row_format == 'left'){

                                 if($diamond['diamondData']['currencyFrom'] == 'USD'){
    
                                    echo "$".number_format($dprice);    
    
                                 }else{
    
                                    echo number_format($dprice).' '.$diamond['diamondData']['currencySymbol'].' '.$diamond['diamondData']['currencyFrom']; 
    
                                 }  
                              }else{
    
                               if($diamond['diamondData']['currencyFrom'] == 'USD'){
    
                                    echo "$".number_format($dprice);    
    
                                 }else{
    
                                    echo $diamond['diamondData']['currencyFrom'].' '.$diamond['diamondData']['currencySymbol'].' '.number_format($dprice); 
    
                                 }  
                              }
                                    ?></span>
                           <?php } else { ?>
                              <span>Call For Price</span>
                           <?php } ?>
                           <?php

                           if ($checkRingCookieData) {
                              $setting = json_decode($check_ring_cookie_data);
                              if ($setting[0]->ringmincarat > '0.00') {
                                 $TempCaratMin = ($setting[0]->ringmincarat * 10) / 100;
                                 $CaratMin = ($setting[0]->ringmincarat - $TempCaratMin);
                              } else {
                                 $CaratMin = $diamond['diamondData']['caratWeight'];
                              }
                              if ($setting[0]->ringmaxcarat > '0.00') {
                                 $TempCaratMax = ($setting[0]->ringmaxcarat * 10) / 100;
                                 $CaratMax = ($setting[0]->ringmaxcarat + $TempCaratMax);
                              } else {
                                 $CaratMax = $setting[0]->ringmaxcarat;
                              }
                              if ($diamond['diamondData']['caratWeight'] > $CaratMax || $diamond['diamondData']['caratWeight'] < $CaratMin) { ?>
                                 <div>
                                    <p style="color: red;"><?php echo 'This diamond will not properly fit with selected setting.'; ?></p>
                                 </div>
                           <?php }
                           } ?>
                           <?php
                           if ($checkRingCookieData->setting_id) {
                              $redirectURI = '/diamondtools/completering/';
                           } else {
                              $redirectURI = '/settings/';
                           }
                           ?>

                           <?php if ($diamond['diamondData']['showPrice'] && $diamond['diamondData']['dsEcommerce']) { /*?>
                           <form action="<?php echo $this->diamond_lib->getSubmitUrl($diamond['diamondData']['diamondId'],$base_shop_domain,$pathprefixshop,$diamond_type); ?>" method="post" id="product_addtocart_form">
                              <div class="box-tocart">
                                 <button type="submit" title="Buy Diamond Only" class="addtocart tocart" onclick="showLoader();" id="product-addtocart-button"><?php echo 'Buy Diamond Only'?></button>
                              </div>
                           </form>
                        <?php */
                           ?>
                           
                           <form action="<?php echo $this->diamond_lib->getSubmitUrl($diamond['diamondData']['diamondId'], $shop, $pathprefixshop, $diamond_type); ?>" method="post" id="product_addtocart_form">
                              <div class="box-tocart">
                                 <button type="submit" title="Add to Cart" class="addtocart tocart" onclick="showLoader();" id="product-addtocart-button"><?php echo 'Add to Cart' ?></button>
                              </div>
                           </form>
                        <?php  } ?>
                           <form action="<?php echo $final_shop_url . $redirectURI; //echo $this->diamond_lib->getAddDiamondUrl($diamond['diamondData']['diamondId'],$shop,$pathprefixshop); 
                                          ?>" method="post" id="completering_addtocart_form">
                              <input type="hidden" name="diamondid" id="diamondid" value="<?php echo $diamond['diamondData']['diamondId'] ?>" />
                              <input type="hidden" name="centerstone" id="centerstone" value="<?php echo $diamond['diamondData']['shape'] ?>" />
                              <input type="hidden" name="carat" id="carat" value="<?php echo $diamond['diamondData']['caratWeight'] ?>" />
                              <input type="hidden" name="diamondtype" id="diamondtype" value="<?php echo $diamond_type ?>" />

                              <input type="hidden" name="centerstonemincarat" id="centerstonemincarat" value="<?php echo (isset($carat_rang[0]) ? $carat_rang[0] : ($diamond['diamondData']['caratWeight'] - 0.1)); ?>" />
                              <input type="hidden" name="centerstonemaxcarat" id="centerstonemaxcarat" value="<?php echo (isset($carat_rang[1]) ? $carat_rang[1] : ($diamond['diamondData']['caratWeight'] + 0.1)); ?>" />

                              <div class="box-tocart">
                                 <?php if ($checkRingCookieData->setting_id) { ?>
                                    <button type="submit" title="Complete Your Ring" class="addtocart tocart" onclick="showLoader();" id="completering_addtocart_button"><?php echo 'Complete Your Ring'; ?></button>
                                 <?php } else { ?>

                                    <button type="submit" title="Add Your Setting" class="addtocart tocart" onclick="showLoader();" id="completering_addtocart_button"><?php echo 'Add Your Setting'; ?></button>
                                 <?php } ?>
                              </div>
                           </form>
                           <?php
                           $dimaondpath = $this->uri->segment(3);
                           $diamondviewurl = $final_shop_url . "/diamondtools/product/" . $diamond_path;
                           ?>
                           <ul class="list-inline social-share">
                              <?php if ($jc_options['jc_options']->show_Pinterest_Share) { ?>
                                 <li class="save_pinterest">
                                    <a class="save_pint" data-pin-do="buttonPin" href="https://www.pinterest.com/pin/create/button/?url=<?php echo $diamondviewurl; ?>&media=<?php echo $imageurl; ?>&description=<?php echo $diamond['diamondData']['subHeader'] ?>" data-pin-height="28"></a>
                                 </li>
                              <?php } ?>
                              <?php if ($jc_options['jc_options']->show_Twitter_Share) { ?>
                                 <li class="share_tweet">
                                    <a href="https://twitter.com/share?ref_src=<?php echo $diamondviewurl; ?>" class="twitter-share-button" data-show-count="false">Tweet</a>
                                    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                 </li>
                              <?php } ?>
                              <?php if ($jc_options['jc_options']->show_Facebook_Share) { ?>
                                 <li class="share_fb">
                                    <div class="fb-share-button" data-href="<?php echo $diamondviewurl; ?>" data-layout="button" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $diamondviewurl; ?>" class="fb-xfbml-parse-ignore">Share</a></div>
                                 </li>
                              <?php } ?>
                              <?php if ($jc_options['jc_options']->show_Facebook_Like) { ?>
                                 <li class="like_fb">
                                    <div class="fb-like" data-href="<?php echo $diamondviewurl; ?>" data-width="" data-layout="button_count" data-share="false" data-action="like" data-size="small"></div>
                                 </li>
                              <?php } ?>
                           </ul>
                        </div>

                        <!-- <div class="diamond-action">
                        <span><?php //echo $diamond['diamondData']['currencyFrom'].$diamond['diamondData']['currencySymbol'].$diamond['diamondData']['fltPrice']; 
                              ?></span>
                        <form action="<?php //echo $this->diamond_lib->getSubmitUrl($diamond['diamondData']['diamondId'],$shop,$pathprefixshop); 
                                       ?>" method="post" id="product_addtocart_form">
                           <div class="box-tocart">
                              <button type="submit" title="Add to Cart" class="addtocart tocart" onclick="showLoader();" id="product-addtocart-button"><?php //echo 'Add to Cart'
                                                                                                                                                         ?></button>
                           </div>
                        </form>
                     </div> -->
                     </div>
                  </div>
                  <?php

                  if (isset($diamond['diamondData']['shape'])) {
                     $urlshape = str_replace(' ', '-', $diamond['diamondData']['shape']) . '-shape-';
                  } else {
                     $urlshape = '';
                  }
                  if (isset($diamond['diamondData']['caratWeight'])) {
                     $urlcarat = str_replace(' ', '-', $diamond['diamondData']['caratWeight']) . '-carat-';
                  } else {
                     $urlcarat = '';
                  }
                  if (isset($diamond['diamondData']['color'])) {
                     $urlcolor = str_replace(' ', '-', $diamond['diamondData']['color']) . '-color-';
                  } else {
                     $urlcolor = '';
                  }
                  if (isset($diamond['diamondData']['clarity'])) {
                     $urlclarity = str_replace(' ', '-', $diamond['diamondData']['clarity']) . '-clarity-';
                  } else {
                     $urlclarity = '';
                  }
                  if (isset($diamond['diamondData']['cut'])) {
                     $urlcut = str_replace(' ', '-', $diamond['diamondData']['cut']) . '-cut-';
                  } else {
                     $urlcut = '';
                  }
                  if (isset($diamond['diamondData']['certificate'])) {
                     $urlcert = str_replace(' ', '-', $diamond['diamondData']['certificate']) . '-certificate-';
                  } else {
                     $urlcert = '';
                  }
                  $urlstring = strtolower($urlshape . $urlcarat . $urlcolor . $urlclarity . $urlcut . $urlcert . 'sku-' . $diamond['diamondData']['diamondId']);
                  $diamondviewurl = '';
                  $diamondviewurl = $this->diamond_lib->getDiamondViewUrl($urlstring, '', $shop, $pathprefixshop);

                  // echo $final_shop_url;
                  $diamondviewurl = $diamondviewurl . $diamond_type;
                  //echo $diamondviewurl = $final_shop_url;


                  ?>
                  <div class="diamond-forms">
                     <?php if ($this->diamond_lib->isHintEnabled($shop) == true) : ?>
                        <div class="form-main no-padding diamond-request-form" id="drop-hint-main">
                           <div class="requested-form">
                              <h2><?php echo 'Drop A Hint'; ?></h2>
                              <p><?php echo 'Because you deserve this.'; ?></p>
                           </div>
                           <div id="gemfind-drop-hint-required">
                              <label style="margin-left: 20px; color: red"></label>
                           </div>
                           <div class="note" style="display: none;"></div>
                           <form method="post" enctype="multipart/form-data" data-hasrequired="<?php echo '* Required Fields'; ?>" data-mage-init='{"validation":{}}' class="form-drop-hint" id="form-drop-hint">
                              <input name="diamondurl" type="hidden" value="<?php echo $diamondviewurl; ?>">
                              <input name="diamondid" type="hidden" value="<?php echo $diamond['diamondData']['diamondId']; ?>">
                              <input name="diamondtype" type="hidden" value="<?php echo $diamond_type; ?>">
                              <input name="shopurl" type="hidden" value="<?php echo $shop; ?>">
                              <div class="form-field">
                                 <label>
                                    <input name="name" id="drophint_name" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" type="text" class="" data-validate="{required:true}" placeholder=" ">
                                    <span><?php echo 'Your Name'; ?></span>
                                 </label>
                                 <label>
                                    <input name="email" id="drophint_email" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" type="email" class="" data-validate="{required:true, 'validate-email':true}" placeholder=" ">
                                    <span><?php echo 'Your E-mail'; ?></span>
                                 </label>
                                 <label>
                                    <input name="recipient_name" id="drophint_rec_name" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" type="text" class="" data-validate="{required:true}" placeholder=" ">
                                    <span><?php echo 'Hint Recipient\'s Name'; ?></span>
                                 </label>
                                 <label>
                                    <input name="recipient_email" id="drophint_rec_email" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" type="email" class="" data-validate="{required:true, 'validate-email':true}" placeholder=" ">
                                    <span><?php echo 'Hint Recipient\'s E-mail'; ?></span>
                                 </label>
                                 <label>
                                    <input name="gift_reason" id="gift_reason" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" type="text" class="" data-validate="{required:true}" placeholder=" ">
                                    <span><?php echo 'Reason For This Gift'; ?></span>
                                 </label>
                                 <label>
                                    <textarea name="hint_message" rows="2" cols="20" id="drophint_message" class="" data-validate="{required:true}" placeholder="Add A Personal Message Here ..."></textarea>
                                 </label>
                                 <label>
                                    <div class="has-datepicker--icon">
                                       <input name="gift_deadline" id="gift_deadline" autocomplete="false" readonly title="Gift Deadline" value="" type="text" placeholder="Gift Deadline">
                                    </div>
                                 </label>

                                 <?php if(!empty($site_key)) { ?>
                                  <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>" data-badge="inline" data-size="invisible" 
                                 data-callback="setResponse">
                                  </div><br>
                                  <input type="hidden" id="captcha-response-four" name="captcha-response-four" /> 
                                  <input type="hidden" id="secret-key" name="secret-key" value="<?php echo $secret_key; ?>" />
                                <?php } ?>

                                 <div class="prefrence-action">
                                    <div class=" prefrence-action action">
                                       <button type="button" data-target="drop-hint-main" onclick="Closeform(event);" class="cancel preference-btn btn-cencel"><span><?php echo 'Cancel'; ?></span></button>
                                       <button type="submit" onclick="formSubmit(event,'<?php echo base_url() . 'ringbuilder/diamondtools/resultdrophint'; ?>','form-drop-hint')" title="Drop Hint" class="preference-btn">
                                          <span><?php echo 'Drop Hint'; ?></span>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     <?php endif; ?>
                     <?php if ($this->diamond_lib->isEmailtoFriendEnabled($shop) == true) : ?>
                        <div class="form-main no-padding diamond-request-form" id="email-friend-main">
                           <div class="requested-form">
                              <h2><?php echo 'E-Mail A Friend'; ?></h2>
                           </div>
                           <div id="gemfind-email-friend-required">
                              <label style="margin-left: 20px; color: red"></label>
                           </div>
                           <div class="note" style="display: none;"></div>
                           <form method="post" enctype="multipart/form-data" data-hasrequired="<?php echo '* Required Fields'; ?>" data-mage-init='{"validation":{}}' class="form-email-friend" id="form-email-friend">
                              <input name="diamondurl" type="hidden" value="<?php echo $diamondviewurl; ?>">
                              <input name="diamondid" type="hidden" value="<?php echo $diamond['diamondData']['diamondId']; ?>">
                              <input name="diamondtype" type="hidden" value="<?php echo $diamond_type; ?>">
                              <input name="shopurl" type="hidden" value="<?php echo $shop; ?>">
                              <div class="form-field">
                                 <label>
                                    <input id="email_frnd_name" name="name" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" placeholder="" type="text" class="">
                                    <span for="email_frnd_name"><?php echo 'Your Name'; ?></span>
                                 </label>
                                 <label>
                                    <input name="email" type="email" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" placeholder="" id="email_frnd_email" class="">
                                    <span><?php echo 'Your E-mail'; ?></span>
                                 </label>
                                 <label>
                                    <input name="friend_name" type="text" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" placeholder="" id="email_frnd_fname" class="">
                                    <span><?php echo 'Your Friend\'s Name'; ?></span>
                                 </label>
                                 <label>
                                    <input name="friend_email" type="email" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" placeholder="" id="email_frnd_femail" class="">
                                    <span><?php echo 'Your Friend\'s E-mail'; ?></span>
                                 </label>
                                 <label>
                                    <textarea name="message" rows="2" placeholder="Add A Personal Message Here ..." cols="20" id="email_frnd_message" class=""></textarea>
                                 </label>

                                <?php if(!empty($site_key)) { ?>
                                <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>" data-badge="inline" data-size="invisible" 
                                       data-callback="setResponse">
                                 </div><br>
                                  <input type="hidden" id="captcha-response-six" name="captcha-response-six" />
                                  <input type="hidden" id="secret-key" name="secret-key" value="<?php echo $secret_key; ?>" />
                                <?php } ?>
                                 <div class="prefrence-action">
                                    <div class=" prefrence-action action">
                                       <button type="button" data-target="email-friend-main" onclick="Closeform(event);" class="cancel preference-btn btn-cencel"><span><?php echo 'Cancel'; ?></span></button>
                                       <button type="submit" onclick="formSubmit(event,'<?php echo base_url() . 'ringbuilder/diamondtools/resultemailfriend'; ?>','form-email-friend')" title="Send To Friend" class="preference-btn">
                                          <span><?php echo 'Send To Friend'; ?></span>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     <?php endif; ?>
                     <?php if ($this->diamond_lib->isMoreInfoEnabled($shop) == true) : ?>
                        <div class="form-main no-padding diamond-request-form" id="req-info-main">
                           <div class="requested-form">
                              <h2><?php echo 'Request More Information'; ?></h2>
                              <p><?php echo 'Our specialists will contact you.'; ?></p>
                           </div>
                           <div id="gemfind-request-more-required">
                              <label style="margin-left: 20px; color: red"></label>
                           </div>
                           <div class="note" style="display: none;"></div>
                           <form method="post" enctype="multipart/form-data" data-hasrequired="<?php echo '* Required Fields'; ?>" data-mage-init='{"validation":{}}' class="form-request-info" id="form-request-info">
                              <input name="diamondurl" type="hidden" value="<?php echo $diamondviewurl; ?>">
                              <input name="diamondid" type="hidden" value="<?php echo $diamond['diamondData']['diamondId']; ?>">
                              <input name="diamondtype" type="hidden" value="<?php echo $diamond_type; ?>">
                              <input name="shopurl" type="hidden" value="<?php echo $shop; ?>">
                              <div class="form-field">
                                 <label>
                                    <input name="name" type="text" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" id="reqinfo_name" placeholder="" class="">
                                    <span><?php echo 'Your Name'; ?></span>
                                 </label>
                                 <label>
                                    <input name="email" type="email" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" id="reqinfo_email" placeholder="" class="">
                                    <span><?php echo 'Your E-mail Address'; ?></span>
                                 </label>
                                 <label>
                                    <input name="phone" type="text" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" id="reqinfo_phone" placeholder="" class="">
                                    <span><?php echo 'Your Phone Number'; ?></span>
                                 </label>
                                 <label>
                                    <textarea name="hint_message" rows="2" cols="20" placeholder="Add A Personal Message Here ..." id="reqinfo_message" class=""></textarea>
                                 </label>
                                 <div class="prefrence-area">
                                    <p><?php echo 'Contact Preference:'; ?></p>
                                    <ul class="pref_container">
                                       <li>
                                          <input type="radio" class="radio required-entry" name="contact_pref" value="By Email">
                                          <label><?php echo 'By Email'; ?></label>
                                       </li>
                                       <li>
                                          <input type="radio" class="radio required-entry" name="contact_pref" value="By Phone">
                                          <label><?php echo 'By Phone'; ?></label>
                                       </li>
                                    </ul>
                                    <?php if(!empty($site_key)) { ?>
                                      <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>" data-badge="inline" data-size="invisible" 
                                          data-callback="setResponse">
                                    </div><br>
                                       <input type="hidden" id="captcha-response-five" name="captcha-response-five" />
                                       <input type="hidden" id="secret-key" name="secret-key" value="<?php echo $secret_key; ?>" />
                                     <?php } ?>
                                    <div class="prefrence-action">
                                       <div class=" prefrence-action action">
                                          <button type="button" data-target="req-info-main" onclick="Closeform(event);" class="cancel preference-btn btn-cencel">
                                             <span><?php echo 'Cancel'; ?></span>
                                          </button>
                                          <button type="submit" onclick="formSubmit(event,'<?php echo base_url() . 'ringbuilder/diamondtools/resultreqinfo'; ?>','form-request-info')" title="Request More Info" class="preference-btn">
                                             <span><?php echo 'Request'; ?></span>
                                          </button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     <?php endif; ?>
                     <?php if ($this->diamond_lib->isScheduleViewingEnabled($shop) == true) : ?>
                        <div class="form-main no-padding diamond-request-form" id="schedule-view-main">
                           <div class="requested-form">
                              <h2><?php echo 'Schedule A Viewing'; ?></h2>
                              <p><?php echo 'See This Item & More In Our Store'; ?></p>
                           </div>
                           <div id="gemfind-schedule-view-required">
                              <label style="margin-left: 20px; color: red"></label>
                           </div>
                           <div class="note" style="display: none;"></div>
                           <form method="post" enctype="multipart/form-data" data-hasrequired="<?php echo '* Required Fields'; ?>" data-mage-init='{"validation":{}}' class="form-schedule-view" id="form-schedule-view">
                              <input name="diamondurl" type="hidden" value="<?php echo $diamondviewurl; ?>">
                              <input name="diamondid" type="hidden" value="<?php echo $diamond['diamondData']['diamondId']; ?>">
                              <input name="diamondtype" type="hidden" value="<?php echo $diamond_type; ?>">
                              <input name="shopurl" type="hidden" value="<?php echo $shop; ?>">
                              <div class="form-field">
                                 <label>
                                    <input name="name" type="text" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" id="schview_name" placeholder="" class="">
                                    <span><?php echo 'Your Name'; ?></span>
                                 </label>
                                 <label>
                                    <input name="email" type="email" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" id="schview_email" placeholder="" class="">
                                    <span><?php echo 'Your E-mail Address'; ?></span>
                                 </label>
                                 <label>
                                    <input name="phone" type="text" onfocus="focusFunction(this)" onfocusout="focusoutFunction(this)" id="schview_phone" placeholder="" class="">
                                    <span><?php echo 'Your Phone Number'; ?></span>
                                 </label>
                                 <label>
                                    <textarea name="hint_message" rows="2" cols="20" placeholder="Add A Personal Message Here ..." id="schview_message" class=""></textarea>
                                 </label>
                                 <label>
                                    <select name="location" placeholder="" id="schview_loc">
                                       <option value=""><?php echo '--Location--'; ?></option>
                                       <?php $retailerInfo = (array) $diamond['diamondData']['retailerInfo'];
                                       $addressList = (array) $retailerInfo['addressList']; ?>
                                       <?php foreach ($addressList as $value) {
                                          $value = (array) $value; ?>
                                          <option data-locationid="<?php echo $value['locationID']; ?>" value="<?php echo $value['locationName']; ?>"><?php echo $value['locationName']; ?></option>
                                       <?php } ?>
                                    </select>
                                 </label>
                                 <label>
                                    <div class="has-datepicker--icon">
                                       <input name="avail_date" id="avail_date" readonly autocomplete="false" placeholder="When are you available?" title="When are you available?" value="" type="text">
                                    </div>
                                 </label>
                                 <?php
                                 /*echo "<pre>";
							print_r((array) $retailerInfo['timingList']);*/
                                 $timingListArr = (array)$retailerInfo['timingList'];
                                 if (empty($timingListArr)) {
                                 ?>
                                    <label class="timing_not_avail" style="display:none;">Slots not available on selected date</label>
                                    <?php
                                 } else {
                                    foreach ($timingListArr as $key => $timingList) {
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
                                       if ($timingList->storeClosedSun == "Yes") {
                                          $dayStatusArr[0] = 0;
                                       }
                                       if ($timingList->storeClosedMon == "Yes") {
                                          $dayStatusArr[1] = 1;
                                       }
                                       if ($timingList->storeClosedTue == "Yes") {
                                          $dayStatusArr[2] = 2;
                                       }
                                       if ($timingList->storeClosedWed == "Yes") {
                                          $dayStatusArr[3] = 3;
                                       }
                                       if ($timingList->storeClosedThu == "Yes") {
                                          $dayStatusArr[4] = 4;
                                       }
                                       if ($timingList->storeClosedFri == "Yes") {
                                          $dayStatusArr[5] = 5;
                                       }
                                       if ($timingList->storeClosedSat == "Yes") {
                                          $dayStatusArr[6] = 6;
                                       }
                                    ?>
                                       <span class="timing_days" data-location="<?php echo $timingList->locationID; ?>" style="display:none;"><?php echo json_encode($timingDays); ?></span>
                                       <?php
                                       foreach ($dayStatusArr as $key => $value) {
                                       ?>
                                          <span style="display:none;" class="day_status_arr"><?php echo $value; ?></span>
                                    <?php
                                       }
                                    }
                                    ?>
                                    <label>
                                       <select id="appnt_time" class="" placeholder="" name="appnt_time" style="display:none;"></select>
                                    </label>
                                    <?php } ?>
                                    <?php if(!empty($site_key)) { ?>
                                     <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>" data-badge="inline" data-size="invisible" 
                                          data-callback="setResponse">
                                    </div><br>
                                    <input type="hidden" id="captcha-response-seven" name="captcha-response-seven" />
                                    <input type="hidden" id="secret-key" name="secret-key" value="<?php echo $secret_key; ?>" />
                                  <?php } ?>
                                 <div class="prefrence-action">
                                    <div class=" prefrence-action action">
                                       <button type="button" data-target="schedule-view-main" onclick="Closeform(event);" class="cancel preference-btn btn-cencel"><span><?php echo 'Cancel'; ?></span></button>
                                       <button type="submit" onclick="formSubmit(event,'<?php echo base_url() . 'ringbuilder/diamondtools/resultscheview'; ?>','form-schedule-view')" title="Request" class="preference-btn book-slots">
                                          <span><?php echo 'Request'; ?></span>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     <?php endif; ?>
                  </div>
               </div>
               <div class="diamond-specification cls-for-hide" id="diamond-specification">
                  <div class="specification-info">
                     <div class="specification-title">
                        <h2><?php echo 'Diamond Details'; ?></h2>
                        <h4 class="close-spec-icon">
                           <a href="javascript:;" id="dmnddtl" onclick="CallDiamondDetail();">

                              <svg version="1.1" data-placement="bottom" data-toggle="tooltip" title="Close" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 52 52" width="20px" height="20px" style="enable-background:new 0 0 52 52;display: inline;vertical-align: text-bottom; fill:#828282 !important;" xml:space="preserve">
                                 <g>
                                    <path d="M26,0C11.664,0,0,11.663,0,26s11.664,26,26,26s26-11.663,26-26S40.336,0,26,0z M26,50C12.767,50,2,39.233,2,26
                                       S12.767,2,26,2s24,10.767,24,24S39.233,50,26,50z" />
                                    <path d="M35.707,16.293c-0.391-0.391-1.023-0.391-1.414,0L26,24.586l-8.293-8.293c-0.391-0.391-1.023-0.391-1.414,0
                                    s-0.391,1.023,0,1.414L24.586,26l-8.293,8.293c-0.391,0.391-0.391,1.023,0,1.414C16.488,35.902,16.744,36,17,36
                                    s0.512-0.098,0.707-0.293L26,27.414l8.293,8.293C34.488,35.902,34.744,36,35,36s0.512-0.098,0.707-0.293
                                    c0.391-0.391,0.391-1.023,0-1.414L27.414,26l8.293-8.293C36.098,17.316,36.098,16.684,35.707,16.293z" />
                                 </g>
                              </svg>
                           </a>
                        </h4>
                     </div>
                     <ul>
                        <?php if (isset($diamond['diamondData']['diamondId'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Stock Number'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <?php if ($jc_options['jc_options']->show_In_House_Diamonds_First == 1) { ?>
                                    <p><?php echo $diamond['diamondData']['stockNumber'] ?></p>
                                 <?php } else { ?>
                                    <p><?php echo $diamond['diamondData']['diamondId'] ?></p>
                                 <?php } ?>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['fltPrice'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Price'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <?php if ($diamond['diamondData']['showPrice']) { ?>
                                    <p><?php
                                       if($getStoreData->price_row_format == 'left'){

                                          if($diamond['diamondData']['currencyFrom'] == 'USD'){
          
                                            echo "$".number_format($diamond['diamondData']['fltPrice']);
          
                                          }else{
          
                                            echo number_format($diamond['diamondData']['fltPrice']).' '.$diamond['diamondData']['currencySymbol'].' '.$diamond['diamondData']['currencyFrom'];
          
                                          }
                                          }else{
          
                                          if($diamond['diamondData']['currencyFrom'] == 'USD'){
          
                                            echo "$".number_format($diamond['diamondData']['fltPrice']); 
          
                                          }else{
          
                                            echo $diamond['diamondData']['currencyFrom'].' '.$diamond['diamondData']['currencySymbol'].' '.number_format($diamond['diamondData']['fltPrice']);   
          
                                          }
          
                                        }
                                       ?></p>
                                 <?php } else { ?>
                                    <p>Call For Price</p>
                                 <?php } ?>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['fltPrice'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Price Per Carat'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <?php if ($diamond['diamondData']['showPrice']) { ?>
                                    <?php if (isset($diamond['diamondData']['caratWeight'])) {
                                       $percarat = str_replace(',', '', $diamond['diamondData']['fltPrice']) / $diamond['diamondData']['caratWeight'];
                                    ?>
                                       <p><?php
                                          if($getStoreData->price_row_format == 'left'){

                                             if($diamond['diamondData']['currencyFrom'] == 'USD'){
                                             
                                               echo "$".number_format($percarat);
                                             
                                             }else{
                                             
                                               echo number_format($percarat).' '.$diamond['diamondData']['currencySymbol'].' '.$diamond['diamondData']['currencyFrom'];
                                             
                                             }
                                             }else{
                                             
                                             if($diamond['diamondData']['currencyFrom'] == 'USD'){
                                             
                                               echo "$".number_format($percarat); 
                                             
                                             }else{
                                             
                                               echo $diamond['diamondData']['currencyFrom'].' '.$diamond['diamondData']['currencySymbol'].' '.number_format($percarat);   
                                             
                                             }
                                             
                                             }
                                          ?></p>
                                    <?php } else { ?>
                                       <p><?php
                                          if ($diamond['diamondData']['currencyFrom'] == 'USD') {
                                             echo "$" . number_format($diamond['diamondData']['fltPrice']);
                                          } else {
                                             echo $diamond['diamondData']['currencyFrom'] . $diamond['diamondData']['currencySymbol'] . number_format($diamond['diamondData']['fltPrice']);
                                          }

                                          ?></p>
                                    <?php } ?>
                                 <?php } else { ?>
                                    <p>Call For Price</p>
                                 <?php } ?>
                              </div>
                           </li>
                        <?php } ?>
                        <?php
                        if ($jc_options['jc_options']->show_In_House_Diamonds_Column_with_SKU) {
                           if (isset($diamond['diamondData']['inhouse'])) { ?>
                              <li>
                                 <div class="diamonds-details-title">
                                    <p><?php echo 'In House'; ?></p>
                                 </div>
                                 <div class="diamonds-info">
                                    <p><?php echo $diamond['diamondData']['inhouse'] ?></p>
                                 </div>
                              </li>
                        <?php }
                        } ?>
                        <?php if (isset($diamond['diamondData']['caratWeight'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Carat Weight'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo $diamond['diamondData']['caratWeight'] ?></p>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['cut'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Cut'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo $diamond['diamondData']['cut'] ?></p>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['color'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Color'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php
                                    if ($diamond['diamondData']['fancyColorMainBody']) {
                                       echo $diamond['diamondData']['fancyColorIntensity'] . ' ' . $diamond['diamondData']['fancyColorMainBody'];
                                    } elseif ($diamond['diamondData']['color'] != '') {
                                       echo $diamond['diamondData']['color'];
                                    } else {
                                       echo 'NA';
                                    }
                                    ?></p>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['clarity'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Clarity'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo $diamond['diamondData']['clarity'] ?></p>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['depth'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Depth %'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo ($diamond['diamondData']['depth']) ? $diamond['diamondData']['depth'] . '%' : '-'; ?></p>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['table'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Table %'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo ($diamond['diamondData']['table']) ? $diamond['diamondData']['table'] . '%' : '-'; ?></p>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['polish'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Polish'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo ($diamond['diamondData']['polish']) ? $diamond['diamondData']['polish'] : '-'; ?></p>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['symmetry'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Symmetry'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo ($diamond['diamondData']['symmetry']) ? $diamond['diamondData']['symmetry'] : '-'; ?></p>
                              </div>
                           </li>

                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['gridle'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Girdle'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo ($diamond['diamondData']['gridle']) ? $diamond['diamondData']['gridle'] : '-'; ?></p>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['culet'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Culet'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo ($diamond['diamondData']['culet']) ? $diamond['diamondData']['culet'] : '-'; ?></p>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['fluorescence'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Fluorescence'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo ($diamond['diamondData']['fluorescence']) ? $diamond['diamondData']['fluorescence'] : '-'; ?></p>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['measurement'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Measurement'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo ($diamond['diamondData']['measurement']) ? $diamond['diamondData']['measurement'] : '-'; ?></p>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['fancyColorMainBody']) && !empty($diamond['diamondData']['fancyColorMainBody'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Fancy Color Main Body'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo ($diamond['diamondData']['fancyColorMainBody']) ? $diamond['diamondData']['fancyColorMainBody'] : '-'; ?></p>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['fancyColorIntensity']) && !empty($diamond['diamondData']['fancyColorIntensity'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Fancy Color Intensity'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo ($diamond['diamondData']['fancyColorIntensity']) ? $diamond['diamondData']['fancyColorIntensity'] : '-'; ?></p>
                              </div>
                           </li>
                        <?php } ?>
                        <?php if (isset($diamond['diamondData']['fancyColorOvertone']) && !empty($diamond['diamondData']['fancyColorOvertone'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Fancy Color Overtone'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo ($diamond['diamondData']['fancyColorOvertone']) ? $diamond['diamondData']['fancyColorOvertone'] : '-'; ?></p>
                              </div>
                           </li>
                        <?php } ?>
                         <?php if (isset($diamond['diamondData']['origin']) && !empty($diamond['diamondData']['origin'])) { ?>
                           <li>
                              <div class="diamonds-details-title">
                                 <p><?php echo 'Origin'; ?></p>
                              </div>
                              <div class="diamonds-info">
                                 <p><?php echo ($diamond['diamondData']['origin']) ? $diamond['diamondData']['origin'] : '-'; ?></p>
                              </div>
                           </li>
                        <?php } ?>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="search-form">
         <div class="test121" style="display:none;"></div>
         <form id="search-diamonds-form" method="post" action="<?php echo base_url() . 'ringbuilder/diamondtools/diamondsearch'; ?>">
            <input name="submitby" id="submitby" type="hidden" value="" />
            <input name="baseurl" id="baseurl" type="hidden" value="<?php echo base_url(); ?>" />
            <input name="shopurl" id="shopurl" type="hidden" value="<?php echo $shop; ?>" />
            <input name="path_prefix_shop" id="path_shop_url" type="hidden" value="<?php echo $pathprefixshop; ?>" />
            <input name="viewmode" id="viewmode" type="hidden" value="list" />
            <input type="hidden" name="orderby" id="orderby" value="FltPrice" />
            <input type="hidden" name="direction" id="direction" value="ASC" />
            <input type="hidden" name="currentpage" id="currentpage" value="1" />
            <input type="hidden" name="diamond_shape[]" id="diamond_shape" value="<?php echo $diamond['diamondData']['shape'] ?>" />
            <input type="hidden" name="diamond_cut[]" id="diamond_cut" value="<?php echo $diamond['diamondData']['cutGradeID']; ?>" />
            <input type="hidden" name="diamond_color[]" id="diamond_color" value="<?php echo $diamond['diamondData']['colorID']; ?>" />
            <input type="hidden" name="diamond_clarity[]" id="diamond_clarity" value="<?php echo $diamond['diamondData']['clarityID']; ?>" />

            <input type="hidden" name="diamond_certificates[]" id="diamond_certificates" value="<?php echo $diamond['diamondData']['certificate'] ?>" />

            <?php if ($diamond['diamondData']['fancyColorMainBody']) { ?>
               <input type="hidden" name="filtermode" id="filtermode" value="navfancycolored">
            <?php } else if ($diamond['diamondData']['certificate'] == 'GCAL' || $diamond['diamondData']['origin'] == 'LAB-CREATED') { ?>
               <input type="hidden" name="filtermode" id="filtermode" value="navlabgrown">
            <?php } else { ?>
               <input type="hidden" name="filtermode" id="filtermode" value="navstandard">
            <?php } ?>
            <input type="hidden" name="diamond_carats[from]" value="<?php echo ($diamond['diamondData']['caratWeight'] - 0.10) ?>" />
            <input type="hidden" name="diamond_carats[to]" value="<?php echo ($diamond['diamondData']['caratWeight'] + 0.10)  ?>" />
            <input type="hidden" name="price[from]" value="0" />
            <input type="hidden" name="price[to]" value="100000" />
            <input type="hidden" name="diamond_table[from]" value="0" />
            <input type="hidden" name="diamond_table[to]" value="100" />
            <input type="hidden" name="diamond_depth[from]" value="0" />
            <input type="hidden" name="diamond_depth[to]" value="100" />
            <input name="itemperpage" id="itemperpage" type="hidden" value="<?php echo $this->diamond_lib->getResultsPerPage(); ?>" />
            <input type="hidden" name="gemfind_diamond_origin" value="" />
            <input type="hidden" name="did" id="did" value="" />
            <input type="submit" name="Submit" id="submit" style="visibility: hidden;">
         </form>
      </div>
      <div class="result filter-advanced">
         <div style="text-align: center; margin: 50px; font-size: 16px;"><b><?php echo 'Loading Similar Diamonds...'; ?></b></div>
      </div>
      <div class="print-diamond-details" style="display: none;">
         <div class="dimond_data"></div>
      </div>

      <div id="printMessageBox">Please wait while we create your document</div>
   </section>

   <script src="<?php echo base_url() ?>assets/js/jquery.PrintArea.js"></script>
   <script>
      //$(".prinddia").attr('href','<?php //echo $final_shop_url.'/printdiamond/id/'.$diamond['diamondData']['diamondId'];
                                    ?>');
      //$(".prinddia").attr('href','<?php //echo base_url().'diamondtools/printdiamond/id/'.$diamond['diamondData']['diamondId'];
                                    ?>');

      var typedata = '';
      if (window.location.href.indexOf("labcreated") > -1) {
         typedata = 'labcreated';
      }


      $("#prinddia").click(function() {
         var mode = 'iframe'; //popup
         var close = mode == "popup";
         var options = {
            mode: mode
         };
         var dimond_id = '<?php echo $diamond['diamondData']['diamondId']; ?>';
         var shop = '<?php echo $shop; ?>';
         var diamond_type = typedata;
         // console.log(diamond_type);
         jQuery.ajax({
            url: '<?php echo base_url() . 'ringbuilder/diamondtools/printdiamond' ?>',
            data: {
               diamondid: dimond_id,
               shop: shop,
               diamondtype: diamond_type
            },
            type: 'POST',
            //dataType: 'json',
            cache: true,
            beforeSend: function(settings) {
               jQuery('#printMessageBox').show();
            },
            success: function(response) {
               //console.log(response);
               $(".dimond_data").html(response);


               setTimeout(function() {
                  jQuery('#printMessageBox').hide();
                  $(".dimond_data").printArea(options);
               }, 5000);

            },
            error: function(xhr, status, errorThrown) {
               console.log('Error happens. Try again.');
               console.log(errorThrown);
            }
         });



      });

      //$(".prinddia").printPage();


      function showLoader() {
         document.getElementById("gemfind-loading-mask").style.display = "block";
      }


      $('#search-diamonds-form #submitby').val('ajax');
      $('form#search-diamonds-form').submit(function(e) {
         e.preventDefault();
         $.ajax({
            url: $('#search-diamonds-form').attr('action'),
            data: $('#search-diamonds-form').serialize(),
            type: 'POST',
            //dataType: 'json',
            cache: true,
            beforeSend: function(settings) {
               $('.loading-mask.gemfind-loading-mask').css('display', 'block');
            },
            success: function(response) {

               $('.result').html(response);
               $('.loading-mask.gemfind-loading-mask').css('display', 'none');
               if (($('div.number-of-search strong').html() < 20) && ($('#currentpage').val() > 1)) {
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
               if ($("input#direction").val() == 'ASC') {
                  $('#ASC').addClass('active');
                  $('#DESC').removeClass('active');
               } else {
                  $('#DESC').addClass('active');
                  $('#ASC').removeClass('active');
               }

               $("#pagesize option").each(function() {
                  if ($(this).val() == $("input#itemperpage").val()) {
                     $(this).attr("selected", "selected");
                     return;
                  }
               });
               $("#gemfind_diamond_origin").change(function() {
                  $("#search-diamonds-form #submit").trigger("click");
               });

               $('th#' + $("input#orderby").val()).addClass($("input#direction").val());

               $("input[name='compare']").change(function() {
                  var maxAllowed = 5;
                  var cnt = $("input[name='compare']:checked").length;
                  if (cnt > maxAllowed) {
                     $(this).prop("checked", "");
                     alert('You can select maximum ' + maxAllowed + ' diamonds to compare!');
                  }
               });
               $('#searchdidfield').keydown(function(e) {
                  if (e.keyCode == 13) {
                     $('#searchdid').trigger('click');
                  }
               });
               $('#searchdid').click(function() {
                  if ($('#searchdidfield').val() != "") {
                     $('input#did').val($('#searchdidfield').val());
                     $("#search-diamonds-form #submit").trigger("click");
                  } else {
                     $('input#searchdidfield').effect("highlight", {
                        color: '#f56666'
                     }, 2000);
                     return false;
                  }
               });
               if ($('input#did').val()) {
                  $('#searchintable').addClass('executed');
               }
               $('#searchdidfield').val($('input#did').val());
               $('input#did').val('');
               $('#resetsearchdata').click(function() {
                  $('#searchdidfield').val();
                  $('input#did').val('');
                  $("#search-diamonds-form #submit").trigger("click");
               });
               $('.loading-mask.gemfind-loading-mask').css('display', 'none');

               $('#gridview-orderby').SumoSelect({
                  forceCustomRendering: true,
                  triggerChangeCombined: false
               });

               $('#pagesize').SumoSelect({
                  forceCustomRendering: true,
                  triggerChangeCombined: false
               });
               $('.pagesize.SumoUnder').insertAfter(".sumo_pagesize .CaptionCont.SelectBox");
               $('.gridview-orderby.SumoUnder').insertAfter(".sumo_gridview-orderby .CaptionCont.SelectBox");

            },
            error: function(xhr, status, errorThrown) {
               $('.loading-mask.gemfind-loading-mask').css('display', 'none');
               console.log('Error happens. Try again.');
               console.log(errorThrown);
            }
         });
      });


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
         if (direction == "ASC") {
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

      function ItemPerPage(selectObject) {
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
         if (id != 'navcompare')
            document.getElementById("filtermode").value = id;
      }

      function SetBackValue(diamondid) {

         var shapeCheckboxes = jQuery("input[name='diamond_shape[]']");
         var shapeList = [];
         shapeCheckboxes.each(function() {
            if (this.checked === true) {
               shapeList.push(jQuery(this).val());
            }
         });
         var cutCheckboxes = jQuery("input[name='diamond_cut[]']");
         var CutGradeList = [];
         cutCheckboxes.each(function() {
            if (this.checked === true) {
               CutGradeList.push(jQuery(this).val());
            }
         });
         var colorCheckboxes = jQuery("input[name='diamond_color[]']");
         var ColorList = [];
         colorCheckboxes.each(function() {
            if (this.checked === true) {
               ColorList.push(jQuery(this).val());
            }
         });
         var clarityCheckboxes = jQuery("input[name='diamond_clarity[]']");
         var ClarityList = [];
         clarityCheckboxes.each(function() {

            if (this.checked === true) {
               ClarityList.push(jQuery(this).val());
            }
         });
         var polishCheckboxes = jQuery("input[name='diamond_polish[]']");
         var polishList = [];
         polishCheckboxes.each(function() {
            if (this.checked === true) {
               polishList.push(jQuery(this).val());
            }
         });
         var symmetryCheckboxes = jQuery("input[name='diamond_symmetry[]']");
         var SymmetryList = [];
         symmetryCheckboxes.each(function() {
            if (this.checked === true) {
               SymmetryList.push(jQuery(this).val());
            }
         });
         var fluorescenceCheckboxes = jQuery("input[name='diamond_fluorescence[]']");
         var FluorescenceList = [];
         fluorescenceCheckboxes.each(function() {
            if (this.checked === true) {
               FluorescenceList.push(jQuery(this).val());
            }
         });

         var fancycolorCheckboxes = jQuery("input[name='diamond_fancycolor[]']");
         var FancycolorList = [];
         fancycolorCheckboxes.each(function() {
            if (this.checked === true) {
               FancycolorList.push(jQuery(this).val());
            }
         });


         var intintensityCheckboxes = jQuery("input[name='diamond_intintensity[]']");
         var intintensityList = [];
         intintensityCheckboxes.each(function() {
            if (this.checked === true) {
               intintensityList.push(jQuery(this).val());
            }
         });

         var certiCheckboxes = jQuery("select#certi-dropdown");
         var certificatelist = [];
         certificatelist.push(jQuery(certiCheckboxes).val());
         var caratMin = jQuery("div#carat_slider input.slider-left").val();
         var caratMax = jQuery("div#carat_slider input.slider-right").val();
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
            'SymmetryList': SymmetryList.toString(),
            'polishList': polishList.toString(),
            'depthMin': depthMin,
            'depthMax': depthMax,
            'tableMin': tableMin,
            'tableMax': tableMax,
            'FluorescenceList': FluorescenceList.toString(),
            'FancycolorList': FancycolorList.toString(),
            'IntintensityList': intintensityList.toString(),
            'CutGradeList': CutGradeList.toString(),
            'ColorList': ColorList.toString(),
            'ClarityList': ClarityList.toString(),
            'SOrigin': SOrigin,
            'currentPage': currentPage,
            'orderBy': orderBy,
            'direction': direction,
            'viewmode': viewMode,
            'filtermode': filtermode,
            'did': did,
         };
         console.log(formdata);
         var expire = new Date();
         expire.setTime(expire.getTime() + 0.5 * 3600 * 1000);
         if (filtermode == 'navfancycolored') {
            jQuery.cookie("savebackvaluefancy", JSON.stringify(formdata), {
               path: '/',
               expires: expire
            });
         } else if (filtermode == 'navstandard') {
            jQuery.cookie("shopifysavebackvalue", JSON.stringify(formdata), {
               path: '/',
               expires: expire
            });
         } else {
            jQuery.cookie("savebackvaluelabgrown", JSON.stringify(formdata), {
               path: '/',
               expires: expire
            });
         }
      }
   </script>
   <script type="text/javascript">
      var src = $('div.diamention img').attr("data-src");
      imageExists1(src, function(exists) {
         if (exists) {
            $('div.diamention img').attr('src', src);
         } else {
            $('div.diamention img').attr('src', '<?php echo $noimageurl ?>');
         }
      });
      setTimeout(function() {
         var src = $('div.main_image img').attr("data-src");
         imageExists1(src, function(exists) {
            if (exists) {
               $('div.main_image img').attr('src', src);
            } else {
               $('div.main_image img').attr('src', '<?php echo $noimageurl ?>');
            }
         });
      }, 500);

      // setTimeout(function() {
      //    var src = $('div.main_video img').attr("data-src");
      //    imageExists1(src, function(exists) {
      //       if (exists) {
      //          $('div.main_video img').attr('src', src);
      //       } else {
      //          $('div.main_video img').attr('src', '<?php echo $noimageurl ?>');
      //       }
      //    });
      //    $(".main_slider_loader").hide();
      //    $(".main_video a").click();
      //    //$( '#iframevideo' ).show();	
      // }, 700);

      function imageExists1(url, callback) {
         var img = new Image();
         img.onload = function() {
            callback(true);
         };
         img.onerror = function() {
            callback(false);
         };
         img.src = url;
      }


      /*var options1 = {
                  type: 'popup',
                  responsive: true,
                  innerScroll: true,
                  modalClass: 'internalusemodel'
             };
             var options2 = {
                  type: 'popup',
                  responsive: true,
                  innerScroll: true,
                  title: 'Vendor Infromation',
                  modalClass: 'dealerinfopopup'
             };*/
      /*var popup = modal(options1, $('#auth-section'));
      var popup = modal(options2, $('#dealer-info-section'));*/
      $("#internaluselink").on('click', function() {
         $('#msg').html('');
         $('#internaluseform input#auth_password').val('');
         $("#auth-section").modal("show");
      });


       function internaluselink() {

         $('#internaluseform').validate({
            rules: {
               password: {
                  required: true
               }
            },
            submitHandler: function(form) {
               $.ajax({
                  url: '<?php echo base_url() ?>' + "ringbuilder/diamondtools/authenticate",
                  data: $('#internaluseform').serialize(),
                  type: 'POST',
                  dataType: 'json',
                  cache: true,
                  beforeSend: function(settings) {
                     $('.loading-mask.gemfind-loading-mask').css('display', 'block');
                  },
                  success: function(response) {
                     console.log(response);
                     var currencySymbol = '<?php echo $currencySymbol; ?>';

                     if (response.output.status == 1) {

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

                        $('#msg').html('<span class="success">' + response.output.msg + '</span>');
                        $("#auth-section").modal("hide");
                        $("#dealer-detail-section").modal("show");
                     } else {
                        $('#msg').html('<span class="error">' + response.output.msg + '</span>');
                        $('#internaluseform input#auth_password').val('');
                        $('#msg').fadeOut(5000);
                     }
                     $('.loading-mask.gemfind-loading-mask').css('display', 'none');
                  }
               });
            }
         });


      }



      // function internaluselink() {

      //    $('#internaluseform').validate({
      //       rules: {
      //          password: {
      //             required: true
      //          }
      //       },
      //       submitHandler: function(form) {
      //          $.ajax({
      //             url: '<?php echo base_url() ?>' + "ringbuilder/diamondtools/authenticate",
      //             data: $('#internaluseform').serialize(),
      //             type: 'POST',
      //             dataType: 'json',
      //             cache: true,
      //             beforeSend: function(settings) {
      //                $('.loading-mask.gemfind-loading-mask').css('display', 'block');
      //             },
      //             success: function(response) {
      //                console.log(response);
      //                if (response.output.status == 1) {
      //                   $('#msg').html('<span class="success">' + response.output.msg + '</span>');
      //                   $("#auth-section").modal("hide");
      //                   $("#dealer-detail-section").modal("show");
      //                } else {
      //                   $('#msg').html('<span class="error">' + response.output.msg + '</span>');
      //                   $('#internaluseform input#auth_password').val('');
      //                   $('#msg').fadeOut(5000);
      //                }
      //                $('.loading-mask.gemfind-loading-mask').css('display', 'none');
      //             }
      //          });
      //       }
      //    });


      // }

      $(document).ready(function() {
         var diamondData = '<?php echo json_encode($diamondData) ?>';
         var post_diamond_data = JSON.stringify(diamondData);
         var product_track_url = window.location.href;

         setTimeout(function() {
            $.ajax({
               url: '<?php echo base_url() ?>' + "ringbuilder/diamondtools/productTracking",
               data: {
                  diamond_data: post_diamond_data,
                  track_url: product_track_url
               },
               type: 'POST',
               dataType: 'json',
               success: function(response) {

               }
            }).done(function(data) {

            });
         }, 2000);
      });
      $(document).ready(function() {
         //$('.main_image a').trigger('click');
         $('#diamondmainimage').attr("src", $('#thumbvar').val());
         $('[data-toggle="tooltip"]').tooltip();
      });
   </script>
<?php } else { ?>
   <div class="diamond-nf">
      <?php //echo 'Diamond not found. Please try again after some time.'; 
      $redirect_uri = $final_shop_url . '/diamondtools';
      $diamond_not_found = true;
      /*$shop_main_domain*/
      $str_domain = explode(".", $shop);
      $site_cookie = "dnotfound_" . $str_domain[0];
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
   </div>
<?php } ?>

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

</script>

<script type="text/javascript">


    function VideorunDb()
   {
       jQuery("#detail_iframevideodb").removeAttr("src");
       jQuery("#mp4video").removeAttr("src");
       jQuery("#mp4video").attr("src", '');
       jQuery('#detail_DbModal').modal('show');
       jQuery('.loader_rb').show();
       var divid = jQuery(event.currentTarget).data('id');
       console.log(divid);
         jQuery.ajax({
               type: "POST",
               url  : "<?php echo base_url(); ?>/ringbuilder/settings/getdiamondvideos",
               data: {
                   action: 'getdiamondvideos',
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
                       jQuery('#detail_iframevideodb').hide();
                       setTimeout(function() {
                          jQuery("#detail_mp4video").attr("src", res.videoURL);
                          jQuery('.loader_rb').hide();
                          jQuery('#detail_mp4video').get(0).play();
                       }, 3000);
                   }else{
                       jQuery('#detail_mp4video').hide();
                       setTimeout(function() {
                           jQuery("#detail_iframevideodb").attr("src", res.videoURL);
                           jQuery('.loader_rb').hide();
                           jQuery('#detail_iframevideodb').show();
                       }, 3000);
                   }    
               }
           }
       });

       jQuery(".Dbclose").click(function() {
           jQuery('#detail_DbModal').modal('hide');
       });
   }
</script>

<div id="detail_DbModal" class="Dbmodal" style="display: none;">
    <div class="Dbmodal-content">
        <span class="Dbclose">&times;</span>
         <div class="loader_rb" style="display: none;">
            <img src="<?php echo base_url('assets/images/diamond.gif') ?>" style="width: 200px; height: 200px;">
        </div>
        <iframe src="" id="detail_iframevideodb" frameBorder="0" scrolling="no" style="width:100%; height:90%;" allow="autoplay"></iframe>
        <video width="100%" height="90%" id="detail_mp4video" loop autoplay>
            <source src="" type="video/mp4">
        </video>
    </div>
</div>