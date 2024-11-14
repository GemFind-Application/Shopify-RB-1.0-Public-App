<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('header');

$shopdata = array('shopurl' => $this->input->get('shop'));
$data = $this->general_model->getDiamondConfig($shopdata['shopurl']);


$this->load->view('settings/head', $shopdata);
$final_shop_url = $this->config->item('final_shop_url');
$isLabSettings = $request_setting_type;
?>
<?php
$shopdata = array('shopurl' => $this->input->get('shop'));
$show_filter_info = $this->ringbuilder_lib->showFilterInfo($shopdata['shopurl']);
$this->load->view('head', $shopdata);
$str_domain = explode(".", $shopdata['shopurl']);
$site_cookie_identifier = 'dnotfound_' . $str_domain[0];

//$navigation_api_rb = $this->ringbuilder_lib->getActiveNavigationRB($shopdata['shopurl']);
$navigation_api_rb = $this->ringbuilder_lib->getActiveNavigationRB($shopdata['shopurl']);


//print_r($navigation_api_rb);
// exit;
?>
<script type="text/javascript">
  var cookie_indentifier = '<?php echo $site_cookie_identifier ?>';
  var baseurl = '<?php echo base_url(); ?>';
</script>
<script type="text/javascript">
  var shopurl = '',
    baseurl = '',
    finalshopurl = '',
    isLabSettings = '';

  shopurl = '<?php echo $shopdata['shopurl']; ?>';
  baseurl = '<?php echo base_url() ?>';
  finalshopurl = '<?php echo $final_shop_url; ?>';
  isLabSettings = '<?php echo $isLabSettings; ?>';

  if (isLabSettings == 1) {
    var expire = new Date();
    expire.setDate(expire.getDate() + 10 * 24 * 60 * 60 * 1000);
    $.cookie("_islabsettingurl", 1, {
      path: '/',
      expires: expire
    });
  } else {
    $.cookie("_islabsettingurl", '', {
      path: '/',
      expires: -1
    });
  }
</script>
<script src="<?php echo base_url() ?>assets/js/d_cookie_check.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wnumb/1.2.0/wNumb.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/10.0.0/nouislider.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/10.0.0/nouislider.css" rel="stylesheet">
<script src="<?php echo base_url() ?>assets/js/touchit.js"></script>
<script src="<?php echo base_url() ?>assets/js/getcookie.js"></script>
<script src="<?php echo base_url() ?>assets/js/ringbuilder.js"></script>
<script src="<?php echo base_url() ?>assets/js/ringmain.js"></script>
<div class="ringbuilder-settings-index">
  <div class="loading-mask gemfind-loading-mask" style="display:none;">
    <div class="loader gemfind-loader">
      <p>Please wait...</p>
    </div>
  </div>
  <input type="hidden" id="is_page_load" value="0" />
  <?php //echo "inview";exit;
  ?>
  <div id="search-rings" class="flow-tabs">
    <div class="alert alert-danger dnotfound" style="display: none;">
      <?php echo "The ring that was sent to you is unfortunately no longer available."; ?>
    </div>
    <?php if (!empty($data->announcement_text)) { ?>
      <div class="diamond-bar">
        <?php echo $data->announcement_text; ?>
      </div>
    <?php }  ?>
    <div class="tab-section">



    </div>

    <div class="tab-content">

      <form id="search-rings-form" method="post" action="<?php echo base_url() ?>ringbuilder/settings/ringsearch" class="search_form">

        <input name="submitby" id="submitby" type="hidden" value="">
        <input name="is_lab_settings" id="is_lab_settings" type="hidden" value="<?php echo $isLabSettings; ?>">
        <input name="baseurl" id="baseurl" type="hidden" value="<?php echo base_url(); ?>">
        <input name="shopurl" id="shopurl" type="hidden" value="<?php echo $shopdata['shopurl']; ?>">
        <input name="path_prefix_shop" id="path_shop_url" type="hidden" value="<?php echo $this->input->get('path_prefix'); ?>">
        <input name="storeDealerid" id="storeDealerid" type="hidden" value="<?php echo $data->dealerid; ?>">

        <section class="rings-search">

          <div class="d-container">

            <div class="d-row">

              <div class="rings-filter">
                    <div class="diamond-filter-title save-reset-filters" style="display: block;">
                         <ul class="filter-left" id="navbar">
                            <?php $i = 0; foreach ($navigation_api_rb['navigation'] as $key => $value) { 
                              
                            if($value){ 
                               if($value != 'Compare'){
                            $id = strtolower($key); ?>
                            <?php if(isset($para)){ ?>
                               <li <?php if($id == $para){ ?> class="active" <?php } ?> id="<?php echo $id; ?>">
                               <a href="javascript:;" onclick="mode(<?php echo $id ?>);" title="<?php echo $value;?>">
                                  <?php echo $value; ?>
                                  <?php if($show_filter_info == 'true') {?>
                                    <span class="show-filter-info" onclick="showfilterinfo('<?php echo strtolower($id) ?>');"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                  <?php }?>
                               </a>
                            </li>
                            <?php } else { ?>
                               <li <?php if($i == 0){ ?> class="active" <?php } ?> id="<?php echo $id; ?>">
                               <a href="javascript:;" onclick="mode(<?php echo $id ?>);" title="<?php echo $value;?>">
                                  <?php echo $value; ?>

                               </a>
                               <?php if($show_filter_info == 'true') {?>
                                    <span class="show-filter-info" onclick="showfilterinfo('<?php echo strtolower($id) ?>');"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                  <?php }?>
                            </li>   
                            <?php } ?>
                          <?php $i++; } else { ?>
                            <li><a href="javascript:;" id="comparetop" title="<?php echo 'Compare';?>"><?php echo 'Compare';?></a></li>
                          <?php } } } ?>
                        </ul>
                        <ul class="filter-right">

                          <li><a href="javascript:;" onclick="SaveFilter();">Save Search</a></li>

                          <li><a href="javascript:;" onclick="ResetFilter('<?php echo $current_url . '/settings/'; ?>');">Reset</a></li>

                        </ul>

                    </div>

                <div class="filter-main-div" id="filter-main-div">
                  <!--Filter Placeholder Start-->
                  <?php echo file_get_contents(APPPATH . 'views/virtual-placeholders/ring-filter.html'); ?>
                  <!--Filter Placeholder End-->
                </div>

              </div>

            </div>

          </div>

        </section>
        
         <?php $i = 0; foreach ($navigation_api_rb['navigation'] as $key => $value) { 
            if($value){
                 if($value != 'Compare'){
              $id = strtolower($key);
              if(isset($para)){
                 if($id == $para){ ?>
                    <input type="hidden" name="filtermode" id="filtermode" value="<?php echo $id; ?>" />
                <?php }
              } else {
                  if($i == 0) { ?>
                    <input type="hidden" name="filtermode" id="filtermode" value="<?php echo $id; ?>" />
                  <?php }
              } $i++; } } } ?>

        <input type="submit" name="Submit" id="submit" style="visibility: hidden;font-size: 0px;">

      </form>

    </div>

  </div>

  <div class="result filter-advanced">
    <?php echo file_get_contents(APPPATH . 'views/virtual-placeholders/grid-view.html'); ?>
  </div>

  <div class="modal fade" id="show-filter-info" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!-- <h4 class="modal-title"></h4> -->
        </div>
        <div class="modal-body">
          <p class="note"></p>
        </div>
      </div>
    </div>
  </div>

  <!--Hidden set query string parameters-->
  <input type="hidden" id="pre_ring_collection" name="pre_ring_collection" value="<?php echo $ring_collection; ?>" />
  <input type="hidden" id="pre_selected_shape" name="pre_selected_shape" value="<?php echo $selected_shape; ?>" />
  <input type="hidden" id="pre_ring_metal" name="pre_ring_metal" value="<?php echo $ring_metal; ?>" />
  <input type="hidden" id="pre_price_from" name="pre_price_from" value="<?php echo $price_from; ?>" />
  <input type="hidden" id="pre_price_to" name="pre_price_to" value="<?php echo $price_to; ?>" />
  <input type="hidden" id="pre_form_load" name="pre_form_load" value="0" />

  <script type="text/javascript">
    var filtertype = '';
    var info_html = '';

    function showfilterinfo(filtertype) {
      var baseurl = '<?php echo base_url(); ?>'
      var shopname = '<?php echo ($shopdata['shopurl'] == 'bylu.myshopify.com' ? 'Ken & Dana Design' : 'Our site'); ?>';
      console.log(filtertype);

      if (typeof filtertype !== 'undefined' && filtertype == 'shape') {
        info_html = '<p>A diamond’s shape is not the same as a diamond’s cut. The shape refers to the general outline of the stone, and not its light refractive qualities. Look for a shape that best suits the ring setting you have chosen, as well as the recipient’s preference and personality. Here are some of the more common shapes that ' + shopname + ' offers:</p><div class="popup-Diamond-Table" style="height:160px;"><ol class="list-unstyled"><li><span class="popup-Dimond-Sketch"><img src="' + baseurl + '/assets/images/shapes/round.png" alt="round"></span><span>Round</span></li><li><span class="popup-Dimond-Sketch"><img src="' + baseurl + '/assets/images/shapes/asscher.png" alt="asscher"></span><span>Asscher</span></li><li><span class="popup-Dimond-Sketch"><img src="' + baseurl + '/assets/images/shapes/marquise.png" alt="marquise"></span><span>Marquise</span></li><li><span class="popup-Dimond-Sketch"><img src="' + baseurl + '/assets/images/shapes/oval.png" alt="oval"></span><span>Oval</span></li><li><span class="popup-Dimond-Sketch"><img src="' + baseurl + '/assets/images/shapes/cushion.png" alt="cushion"></span><span>Cushion</span></li><li><span class="popup-Dimond-Sketch"><img src="' + baseurl + '/assets/images/shapes/radiant.png" alt="radiant"></span><span>Radiant</span></li><li><span class="popup-Dimond-Sketch"><img src="' + baseurl + '/assets/images/shapes/pear-v2.png" alt="pear"></span><span>Pear</span></li><li><span class="popup-Dimond-Sketch"><img src="' + baseurl + '/assets/images/shapes/emerald.png" alt="emerald"></span><span>Emerald</span></li><li><span class="popup-Dimond-Sketch"><img src="' + baseurl + '/assets/images/shapes/heart.png" alt="heart_tn"></span><span>Heart</span></li><li><span class="popup-Dimond-Sketch"><img src="' + baseurl + '/assets/images/shapes/princess.png" alt="princess"></span><span>Princess</span></li></ol></div>';
      }

      if (typeof filtertype !== 'undefined' && filtertype == 'price') {
        info_html = 'This refer to different type of Price to filter and select the appropriate ring as per your requirements. Look for  best suit price of your chosen ring.';
      }
      if (typeof filtertype !== 'undefined' && filtertype == 'metal_type') {
        info_html = '<p>This refer to different type of Metal Type to filter and select the appropriate ring as per your requirements. Look for a metal type best suit of your chosen ring.</p>';
      }

      if (typeof filtertype == 'undefined') {
        info_html = "";
      }

     if(typeof filtertype !== 'undefined' && (filtertype == 'navminedsetting')){
             info_html = 'Formed over billions of years, natural diamonds are mined from the earth.  Diamonds are the hardest mineral on earth, which makes them an ideal material for daily wear over a lifetime.  Our natural diamonds are conflict-free and GIA certified.';
      }
      if(typeof filtertype !== 'undefined' && (filtertype == 'navlabsetting')){
           info_html = 'Lab-grown diamonds are created in a lab by replicating the high heat and high pressure environment that causes a natural diamond to form. They are compositionally identical to natural mined diamonds (hardness, density, light refraction, etc), and the two look exactly the same. A lab-grown diamond is an attractive alternative for those seeking a product with less environmental footprint.';
      }

      jQuery('#show-filter-info .modal-body p').html(info_html);
      filtertype = '';
      jQuery("#show-filter-info").modal("show");
    }
  </script>
</div>
<?php include('footer.php'); ?>