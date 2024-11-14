<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('header');
$navigation_api = array();
$navigation_api = $this->diamond_lib->getActiveNavigation($this->input->get('shop'));
$para = $request_diamond_type;
$final_shop_url = $this->config->item('final_shop_url');

if($navigation_api['navigation']){
?>

<?php 
$shopdata = array('shopurl' => $this->input->get('shop'));
$show_filter_info = $this->diamond_lib->showFilterInfo($shopdata['shopurl']);
$sticky_header = $this->diamond_lib->getStickyHeader($shopdata['shopurl']);
$this->load->view('head',$shopdata );
$default_view_mode = $this->diamond_lib->getDefaultViewmode($this->input->get('shop'));
$str_domain = explode(".",$shopdata['shopurl']);
$site_cookie_identifier = 'dnotfound_'.$str_domain[0];
$data = $this->general_model->getDiamondConfig($shopdata['shopurl']);
?>
<script type="text/javascript">
	var cookie_indentifier = '<?php echo $site_cookie_identifier ?>';
	var baseurl = '<?php echo base_url();?>';
</script>
<script type="text/javascript">
    var shopurl = '',
      baseurl = '',
      pathprefixshop = '',
      finalshopurl = '';

  shopurl = '<?php echo $shop; ?>';
  baseurl = '<?php echo base_url()?>';
  finalshopurl = '<?php echo $final_shop_url; ?>';
</script>
<script src="<?php echo base_url()?>assets/js/getdiamondcookies.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.sumoselect.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wnumb/1.2.0/wNumb.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/10.0.0/nouislider.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/10.0.0/nouislider.css" rel="stylesheet">  
<script src="<?php echo base_url()?>assets/js/touchit.js"></script>
<script src="<?php echo base_url()?>assets/js/main.js"></script>
<script src="<?php echo base_url()?>assets/js/list.js"></script>
<link href="<?php echo base_url()?>assets/css/sumoselect.css" rel="stylesheet">
<div class="loading-mask gemfind-loading-mask" style="display:none;">
  <div class="loader gemfind-loader"><p>Please wait...</p>
  </div>
</div>
<input type="hidden" id="is_page_load" value="0" />
<div class="ringbuilder-diamond-index">
<div id="search-diamonds" class="flow-tabs">
   <div class="alert alert-danger dnotfound" style="display: none;">      
		<?php echo "The ring that was sent to you is unfortunately no longer available."; ?>
    </div>
    <?php if (!empty($data->announcement_text)) { ?>
            <div class="diamond-bar">
                  <?php   echo $data->announcement_text; ?>   
            </div>
<?php }  ?>
   <div class="tab-section">
      
   </div>
<form id="search-diamonds-form" method="post" action="<?php echo base_url()?>ringbuilder/diamondtools/diamondsearch" class="search_form">
   <input name="submitby" id="submitby" type="hidden" value="">
   <input type="hidden" name="inintfilter" id="inintfilter" value="1" />
   <input name="defaultshapevalue" id="defaultshapevalue" type="hidden" value="<?php echo $this->diamond_lib->getShapedefaultfilter(); ?>">
   <input name="baseurl" id="baseurl" type="hidden" value="<?php echo base_url(); ?>">
   <input name="shopurl" id="shopurl" type="hidden" value="<?php echo $_GET['shop']; ?>">
   <input name="path_prefix_shop" id="path_shop_url" type="hidden" value="<?php echo $_GET['path_prefix']; ?>">
   <input name="sticky_header" id="sticky_header" type="hidden" value="<?php echo $sticky_header; ?>">
   <section class="diamonds-search">
      <div class="d-container">
         <div class="d-row">
            <div class="diamonds-details no-padding">
               <div class="diamonds-filter">
                  <div class="diamond-filter-title" style="display:none;">
                     <ul class="filter-left" id="navbar">
                        <?php $i = 0; foreach ($navigation_api['navigation'] as $key => $value) { 
                        	
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
                        <li><a href="javascript:;" onclick="SaveFilter();"><?php echo 'Save Search';?></a></li>
                        <li><a href="javascript:;" onclick="ResetFilter();"><?php echo 'Reset';?></a></li>
                     </ul>
                  </div>
                  <div class="filter-main-div" id="filter-main-div">
					<!--Filter Placeholder Start-->
					<?php echo file_get_contents(APPPATH.'views/virtual-placeholders/filter.html');?>
					<!--Filter Placeholder End-->
				  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <?php $i = 0; foreach ($navigation_api['navigation'] as $key => $value) { 
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
   <input type="submit" name="Submit" id="submit" style="visibility: hidden;">
</form>
</div>
<div class="result filter-advanced">
<!--List Diamonds Placeholder Start-->
<?php if($default_view_mode == 'list') 
	echo file_get_contents(APPPATH.'views/virtual-placeholders/list-view.html');
	  else 
	echo file_get_contents(APPPATH.'views/virtual-placeholders/grid-view.html');  
?>
<!--List Diamonds Placeholder End-->
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

<script type="text/javascript">
   var filtertype = '';
   var info_html = '';
   
   function showfilterinfo(filtertype){
    var baseurl = '<?php echo base_url();?>'
    var shopname = '<?php echo ($shopdata['shopurl'] == 'bylu.myshopify.com' ? 'Ken & Dana Design' : 'Our site'); ?>';
    console.log(filtertype);
      if(typeof filtertype !== 'undefined' && filtertype == 'navstandard'){
         info_html = 'Formed over billions of years, natural diamonds are mined from the earth.  Diamonds are the hardest mineral on earth, which makes them an ideal material for daily wear over a lifetime.  Our natural diamonds are conflict-free and GIA certified.';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'navfancycolored'){
         info_html = 'Also known as fancy color diamonds, these are diamonds with colors that extend beyond GIA’s D-Z color grading scale. They fall all over the color spectrum, with a range of intensities and saturation. The most popular colors are pink and yellow.';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'navlabgrown'){
         info_html = 'Lab-grown diamonds are created in a lab by replicating the high heat and high pressure environment that causes a natural diamond to form. They are compositionally identical to natural mined diamonds (hardness, density, light refraction, etc), and the two look exactly the same. A lab-grown diamond is an attractive alternative for those seeking a product with less environmental footprint.';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'shape'){
         info_html = '<p>A diamond’s shape is not the same as a diamond’s cut. The shape refers to the general outline of the stone, and not its light refractive qualities. Look for a shape that best suits the ring setting you have chosen, as well as the recipient’s preference and personality. Here are some of the more common shapes that '+shopname+' offers:</p><div class="popup-Diamond-Table" style="height:160px;"><ol class="list-unstyled"><li><span class="popup-Dimond-Sketch"><img src="'+baseurl+'/assets/images/shapes/round.png" alt="round"></span><span>Round</span></li><li><span class="popup-Dimond-Sketch"><img src="'+baseurl+'/assets/images/shapes/asscher.png" alt="asscher"></span><span>Asscher</span></li><li><span class="popup-Dimond-Sketch"><img src="'+baseurl+'/assets/images/shapes/marquise.png" alt="marquise"></span><span>Marquise</span></li><li><span class="popup-Dimond-Sketch"><img src="'+baseurl+'/assets/images/shapes/oval.png" alt="oval"></span><span>Oval</span></li><li><span class="popup-Dimond-Sketch"><img src="'+baseurl+'/assets/images/shapes/cushion.png" alt="cushion"></span><span>Cushion</span></li><li><span class="popup-Dimond-Sketch"><img src="'+baseurl+'/assets/images/shapes/radiant.png" alt="radiant"></span><span>Radiant</span></li><li><span class="popup-Dimond-Sketch"><img src="'+baseurl+'/assets/images/shapes/pear-v2.png" alt="pear"></span><span>Pear</span></li><li><span class="popup-Dimond-Sketch"><img src="'+baseurl+'/assets/images/shapes/emerald.png" alt="emerald"></span><span>Emerald</span></li><li><span class="popup-Dimond-Sketch"><img src="'+baseurl+'/assets/images/shapes/heart.png" alt="heart_tn"></span><span>Heart</span></li><li><span class="popup-Dimond-Sketch"><img src="'+baseurl+'/assets/images/shapes/princess.png" alt="princess"></span><span>Princess</span></li></ol></div>';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'cut'){
         info_html = '<p>Not to be confused with shape, a diamond’s cut rating tells you how well its proportions interact with light. By evaluating the angles and proportions of the diamond, the cut grade is designed to tell you how sparkly and brilliant your stone is. Cut grading is usually not available for fancy shapes (any shape that is not round), because the mathematical formula that determines light return becomes less reliable when different length to width ratios are factored in.</p>';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'carat'){
         info_html = '<p>Carat is a unit of measurement to determine a diamond’s weight. Typically, a higher carat weight means a larger looking diamond, but that is not always the case. Look for the mm measurements of the diamond to determine its visible size.</p><img src="'+baseurl+'/assets/images/carat.jpg" alt="Carat">';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'price'){
         info_html = 'This refer to different type of Price to filter and select the appropriate ring as per your requirements. Look for a best suit Price of your chosen ring.';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'color'){
         info_html = '<p>The color scale measures the degree of colorlessness in a diamond. D is the highest and most  colorless grade, but also the most expensive. To get the most value for your budget, look for an eye colorless stone. For most diamonds, this is in the F-H range.</p><img src="'+baseurl+'/assets/images/color.jpg" alt="Color">';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'clarity'){
         info_html = '<p>A diamond’s clarity refers to the tiny traces of natural elements that are trapped inside the stone. 99% of diamonds contain inclusions or flaws. You do not need a flawless diamond - they are very rare and expensive - but you want to look for one that is perfect to the naked eye. Depending on the shape of the diamond, the sweet spot for clarity is usually between VVS2 to SI1.</p>';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'depth'){
         info_html = '<p>Depth percentage is the height of the diamond measured from the culet to the table, divided by the width of the diamond. The lower the depth %, the larger the diamond will appear (given the same weight), but if this number is too low then the brilliance of the diamond will be sacrificed. The depth percentage is one of the elements that determines the Cut grading.  </p>';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'table'){
         info_html = '<p>Table percentage is the width of a diamond’s largest facet (the table) divided by its overall width. It tells you how big the “face” of a diamond is.</p>';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'polish'){
         info_html = '<p>Polish describes how smooth the surface of a diamond is. Aim for an Excellent or Very Good polish rating.</p>';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'symmetry'){
         info_html = '<p>Symmetry describes how symmetrical the diamond is cut all the way around, which is a contributing factor to a diamond’s sparkle and brilliance. Aim for an Excellent or Very Good symmetry rating for round brilliant shapes, and Excellent to Good for fancy shapes.</p>';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'fluorescence'){
         info_html = '<p>Fluorescence tells you how a diamond responds to ultraviolet light - does it glow under a black light? Diamonds with no fluorescence are generally priced higher on the market, but it is rare for fluorescence to have any visual impact on the diamond; some fluorescence can even enhance the look of the stone.  '+shopname+' recommends searching for diamonds with none to medium fluorescence, and keeping open the option of strong fluorescence for additional value.</p>';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'fancy_color'){
         info_html = '<p>The color scale measures the degree of colorlessness in a diamond. D is the highest and most  colorless grade, but also the most expensive. To get the most value for your budget, look for an eye colorless stone. For most diamonds, this is in the F-H range.</p><img src="'+baseurl+'/assets/images/color.jpg" alt="Color">';
      }
      if(typeof filtertype !== 'undefined' && filtertype == 'fancy_intensity'){
         info_html = 'The main color, and if there is a secondary color, together define the color tone, however the strength of color is defined by the intensity level. The intensity level can be anywhere from a very soft shade to a very strong shade, and the stronger the shade the more valuable the diamond.';
         
      }

      if(typeof filtertype == 'undefined'){
         info_html = "";  
      }

      jQuery('#show-filter-info .modal-body p').html(info_html);
      filtertype = '';
      jQuery("#show-filter-info").modal("show");
   }
</script>
</div>
<?php }else{?>
   <h2>Please enter the dealer username and other APIs in admin setting screen</h2>
<?php }?>

<?php include('footer.php'); ?>