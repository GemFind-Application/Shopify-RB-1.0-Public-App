<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('header');

$shop = $this->input->get('shop');
$pathprefixshop = $this->input->get('path_prefix');

$final_shop_url = $this->config->item('final_shop_url');

$diamondType = $this->uri->segment(5);

$access_token = $this->diamond_lib->getShopAccessToken($shop);
$finalshopurl = actual_shop_address($access_token, $shop, $pathprefixshop, true);

$shopdata = array('shopurl' => $shop);

$this->load->view('head', $shopdata);

?>
<script type="text/javascript">
  var shopurl = '',
    baseurl = '',
    pathprefixshop = '',
    finalshopurl = '';

  shopurl = '<?php echo $shop; ?>';
  baseurl = '<?php echo base_url() ?>';
  pathprefixshop = '<?php echo $pathprefixshop; ?>';
  diamondpath = '<?php echo $diamond_path; ?>';
  finalshopurl = '<?php echo $finalshopurl; ?>';
  diamondType = '<?php echo $diamondType; ?>';
</script>
<div class="loading-mask gemfind-loading-mask" id="gemfind-loading-mask">
  <div class="loader gemfind-loader">
    <p>Please wait...</p>
  </div>
</div>
<script src="<?php echo base_url() ?>assets/js/diamonddetailcookie.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.sumoselect.js"></script>
<script src="<?php echo base_url() ?>assets/js/touchit.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/view.js"></script>
<link href="<?php echo base_url() ?>assets/css/sumoselect.css" rel="stylesheet">

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.js"></script> -->



<?php
if ($this->uri->segment(4) == 'invalid') { ?>
  <h3 class="flash-message error"> Invalid Request </h3>
<?php } ?>
<?php
if ($this->uri->segment(4) == 'error') { ?>
  <h3 class="flash-message error"> Something went wrong. Please try again later. </h3>
<?php } ?>

<div class="ringbuilder-diamond-view">
  <div class="diamonds-product-view" id="diamonds-product-view">
    <!-- <div class="breadcrumbs">
   <ul class="items">
      <li class="item search">
         <a href="<?php //echo $final_shop_url; 
                  ?>" title="Return To Search Results">Return To Search Results</a>
      </li>
   </ul>
   </div> -->

  </div>
</div>

<div class="modal fade" id="popup-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
      <div class="modal-body">
        <p class="note"></p>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  jQuery(document).on('submit', 'form#completering_addtocart_form', function(e) {
    /*var pageURL = jQuery(location).attr("href");
    console.log(pageURL);*/
    var pathname = window.location.pathname;
    var pathArr = pathname.split('/');
    var diamond_path;

    if (pathArr[pathArr.length - 1] == "labcreated") {
      diamond_path = pathArr[5] + '/' + pathArr[6];
    } else if (pathArr[pathArr.length - 1] == "fancydiamonds") {
      diamond_path = pathArr[5] + '/' + pathArr[6];
    } else {
      diamond_path = pathArr[5];
    }

    /*var pathinfo = new URL(pageURL);*/
    /*console.log(pathinfo);*/


    console.log('form is submitting');
    var final_shop_url = '<?php echo $final_shop_url; ?>';
    var diamondData = [];
    var data = {};
    data.centerstone = jQuery("form#completering_addtocart_form #centerstone").val();
    data.carat = jQuery("form#completering_addtocart_form #carat").val();
    data.diamondid = jQuery("form#completering_addtocart_form #diamondid").val();
    data.diamondtype = jQuery("form#completering_addtocart_form #diamondtype").val();

    data.centerstonemincarat = jQuery("form#completering_addtocart_form #centerstonemincarat").val();
    data.centerstonemaxcarat = jQuery("form#completering_addtocart_form #centerstonemaxcarat").val();

    data.diamondpath = diamond_path;

    diamondData.push(data);
    console.log(data);
    var expire = new Date();
    expire.setDate(expire.getDate() + 0.2 * 24 * 60 * 60 * 1000);
    jQuery.cookie("_shopify_diamondsetting", JSON.stringify(diamondData), {
      path: '/',
      expires: expire
    });
    //return;


  });
</script>

<?php include('footer.php'); ?>