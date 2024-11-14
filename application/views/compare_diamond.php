<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('header');

$this->load->helper('common');

$final_shop_url = $this->config->item('final_shop_url');
$shopurl = $shop_data['shop'];   
$pathprefixshop = $shop_data['path_prefix'];

$shopdata = array('shopurl' => $shopurl);
$this->load->view('head',$shopdata );

$navigation_api = array();
$navigation_api = $this->diamond_lib->getActiveNavigation($shopurl);
$show_filter_info = $this->diamond_lib->showFilterInfo($shopdata['shopurl']);
?>
<script>
  var shopurl = '',
      baseurl = '',
      pathprefixshop = '',
      finalshopurl = '';

  shopurl = '<?php echo $shopurl; ?>';
  baseurl = '<?php echo base_url()?>';
  pathprefixshop = '<?php echo $pathprefixshop; ?>';
  finalshopurl = '<?php echo $final_shop_url; ?>';
</script>
<script src="<?php echo base_url()?>assets/js/compare.diamond.js"></script>
<script src="<?php echo base_url()?>assets/js/getdiamondcookies.js"></script>
<?php
//$currency = $block->getCurrencySymbol();
if (sizeof($navigation_api['navigation']) > 0) : ?>
<style type="text/css">
   tr.remove{display: none;}
</style>
<div class="loading-mask gemfind-loading-mask" style="display: none;">
  <div class="loader gemfind-loader"><p>Please wait...</p>
  </div>
</div>
<div class="ringbuilder-diamond-index">
<div id="search-diamonds" class="flow-tabs">
    <div class="tab-section"></div>
   <section class="compare-product diamonds-search">
      <div class="d-container">
         <div class="d-row">
            <div class="diamonds-details no-padding">
               <div class="diamonds-filter">
                  <div class="diamond-filter-title">
                     <ul class="filter-left">
                       <?php foreach ($navigation_api['navigation'] as $key => $value) { 
                        if($value){ 
                        if($key == 'navStandard'){ $id = strtolower($key); ?>
                           <li id="<?php echo $id; ?>"><a href="<?php echo $final_shop_url.'/diamondtools/'; ?>" title="<?php echo $value;?>"><?php echo $value; ?></a>
                              <?php if($show_filter_info == 'true') {?>
                              <span class="show-filter-info" onclick="showfilterinfo('standard');"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                            <?php }?>
                           </li>
                        <?php } else if($key == 'navFancyColored'){ $id = strtolower($key); ?>
                           <li id="<?php echo $id; ?>"><a href="<?php echo $final_shop_url.'/diamondtools/diamondtype/navfancycolored'; ?>" title="<?php echo $value;?>"><?php echo $value; ?></a>
                                 <?php if($show_filter_info == 'true') {?>
                                    <span class="show-filter-info" onclick="showfilterinfo('fancy_colored');"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                  <?php }?>
                           </li>
                        <?php } else if($key == 'navLabGrown'){ $id = strtolower($key); ?>
                           <li id="<?php echo $id; ?>"><a href="<?php echo $final_shop_url.'/diamondtools/diamondtype/navlabgrown'; ?>" title="<?php echo $value;?>"><?php echo $value; ?></a>
                                 <?php if($show_filter_info == 'true') {?>
                              <span class="show-filter-info" onclick="showfilterinfo('lab_grown_diamond');"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                              <?php }?>
                           </li>
                        <?php } else { ?> 
                        <li class="active"><a href="javascript:;" class="active" id="comparetop" title="<?php echo 'Compare';?>"><?php echo 'Compare';?></a></li>
                        <?php } } } ?>
                     </ul>
                  </div>
               </div>
               <div class="compare-info"></div>
            </div>
         </div>
      </div>
   </section>
</div>
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
<?php else: echo 'Please configure the Gemfind Diamond Search App from admin.'; endif; ?>

<script type="text/javascript">
   var filtertype = '';
   var info_html = '';
   function showfilterinfo(filtertype){
      if(typeof filtertype !== 'undefined' && filtertype == 'standard'){
         info_html = 'Apply Standard filter';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'fancy_colored'){
         info_html = 'Apply Fancy Colored filter';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'lab_grown_diamond'){
         info_html = 'Apply Lab Grown filter';
      }
      if(typeof filtertype == 'undefined'){
         info_html = "";  
      }

      jQuery('#show-filter-info .modal-body p').html(info_html);
      jQuery("#show-filter-info").modal("show");
    }
    
</script>

<?php include('footer.php'); ?>