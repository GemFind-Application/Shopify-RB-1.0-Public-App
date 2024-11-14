<?php
$this->load->library('diamond_lib');
$this->load->helper('common');
include_once( 'head.php' );

$noimageurl = base_url()."/assets/images/no-image.jpg"; 



  
$compare_products = json_decode($compare_diamond_data, true);
//print_r($compare_products);

# Initialise a new array.
$compareItems = [];
# Iterate over every associative array in the data array.
foreach ($compare_products as $compare_product) {
    # Iterate over every key-value pair of the associative array.
    foreach ($compare_product as $key => $value) {
        # Ensure the sub-array specified by the key is set.
        if (!isset($compareItems[$key]))
            $compareItems[$key] = [];
        # Insert the value in the sub-array specified by the key.
        $compareItems[$key][] = $value;
    }
}

if (empty($compare_products)) { ?>
<div class="emptydata">
    <h2> NO DIAMONDS TO COMPARE </h2>
</div>
<?php } else {
//$alphaarray = array(0 => 'a_col', 1 => 'b_col', 2 => 'c_col', 3 => 'd_col', 4 => 'e_col');
$alphaarray = array( 0 => 'a_col', 1 => 'b_col', 2 => 'c_col', 3 => 'd_col', 4 => 'e_col',5 => 'f_col' );
?>
<div class="responsive-table">
   <table id="compare-sortable">
      <?php
         $i = 0;
         foreach ($compareItems as $key => $value):
             if ($key == 'Image'):
                 ?>
      <thead class="thead-dark">
         <tr class="ui-state-default" id="disable-drag">
            <?php
              for ($j = 0; $j < count($value); $j++){
                   if ($i++ == 0): ?>
              <td></td>
              <?php endif; ?>
              <td class="<?php echo $alphaarray[$j]; ?>">
                <?php $diamond_image = preg_replace('/\s/', '', $value[$j]); //print($diamond_image); exit();?>
                <img  alt="No Image" src="<?php if (!empty($diamond_image)) { echo $diamond_image; } else { echo $noimageurl; } ?>" />
              </td>
              <?php } ?>
         </tr>
      </thead>
      <?php
         else: $k = 0; ?>
      <?php if($key=='ID'): continue; endif; ?>
      <?php if($key == 'DiamondType'): continue; endif; ?>

      <tbody>
      <tr class="enable-drag">
         <?php
            for ($j = 0; $j < count($value); $j++):
                if ($k++ == 0): ?>
         <th><a href="javascript:;" class="rowremove" title="Remove Row" onclick="this.parentNode.parentNode.className= 'remove'"><?php echo 'Remove'; ?> </a>
            <?php if($key=='Sku'): echo '#'; endif; echo $key; ?>
         </th>
         <?php endif; ?>
         <td class="<?php echo $alphaarray[$j]; ?>">
            <?php 
               if($key=='Price' && $value[$j] != 'Call'): echo $this->diamond_lib->getCurrencySymbol($shopurl); endif; 
               echo ($value[$j]) ? $value[$j] : '-'; 
               if($key=='Table' && $value[$j]): echo '%'; endif;
               if($key=='Depth' && $value[$j]): echo '%'; endif; 
               ?>
         </td>
         <?php endfor; ?>
      </tr>
      </tbody>
      <?php endif;
         endforeach;
         ?>
       
      <tfoot>
         <tr class="compare-actions">
            <?php
               $k = 0;
               for ($i = 0; $i < count($compareItems['Sku']); $i++):
                   ?>
            <?php if ($k++ == 0): ?>
            <td></td>
            <?php endif; ?>
            <td class="<?php echo $alphaarray[$i]; ?>">
               <div class="actions-row">
                <?php
                  if(isset($compareItems['Shape'])){
                      $urlshape = str_replace(' ', '-',$compareItems['Shape'][$i]).'-shape-';
                  }else {
                      $urlshape = '';
                  }

                  if(isset($compareItems['Carat'])){
                      $urlcarat = str_replace(' ', '-',$compareItems['Carat'][$i]).'-carat-';
                  }else {
                      $urlcarat = '';
                  }
                  if(isset($compareItems['Color'])){
                      $urlcolor = str_replace(' ', '-',$compareItems['Color'][$i]).'-color-';
                  } else {
                      $urlcolor = '';
                  }
                  if(isset($compareItems['Clarity'])){
                      $urlclarity = str_replace(' ', '-',$compareItems['Clarity'][$i]).'-clarity-';
                  }else{
                      $urlclarity = '';
                  }
                  if(isset($compareItems['Cut'])){
                      $urlcut = str_replace(' ', '-',$compareItems['Cut'][$i]).'-cut-';
                  }else{
                      $urlcut = '';
                  }
                  if(isset($compareItems['Cert'])){
                      $urlcert = str_replace(' ', '-',$compareItems['Cert'][$i]).'-certificate-';
                  }else{
                      $urlcert = '';
                  }

                  $urlstring = strtolower($urlshape.$urlcarat.$urlcolor.$urlclarity.$urlcut.$urlcert.'sku-'.$compareItems['ID'][$i]);

                  $type = '';
                  if(isset($compareItems['DiamondType'])){
                      $type = $compareItems['DiamondType'][$i];
                  }
                  $diamondviewurl = $this->diamond_lib->getDiamondViewUrl($urlstring,$type,$shopurl,$pathprefixshop);
                  ?>
                  <a href="<?php echo $diamondviewurl; ?>" class="view-product"><?php echo 'View'; ?>
                  </a>
                  <a href="javascript:;" class="delete-row" data-toggle="tooltip" data-placement="bottom" title="Remove Diamond" onclick="removeDummy('<?php echo $alphaarray[ $i ]; ?>','<?php echo $compareItems['ID'][ $i ]; ?>')"></a>
               </div>
            </td>
            <?php endfor;
               ?>
         </tr>
      </tfoot>
   </table>
    <div class="mobile-compare-view">
     <div class="compare-main-container">
     
       <?php
       foreach ($compare_products as $key => $value):
       ?>
        <div class="compare-items">
          <div class="item-col-1">
            <img  alt="Diamond" src="<?php if(!empty($value['Image'])){echo $value['Image'];} else{echo $noimageurl;} ?>" />
            <span class="diamond-value shape-type"><?php echo $value['Shape'] ?></span>
          </div>
          <div class="item-col-2">
            <span class="diamond-value"><?php echo ($value['Carat'] ? $value['Carat'] : "-" )?></span>
            <span class="diamond-label"><?php echo "Carat" ?></span>
            <span class="diamond-value"><?php echo $value['Clarity']?></span>
            <span class="diamond-label"><?php echo "Clarity" ?></span>
          </div>
          <div class="item-col-3">
            <span class="diamond-value"><?php echo ($value['Cut'] ? $value['Cut'] : "-")?></span>
            <span class="diamond-label"><?php echo "Cut" ?></span>
            <span class="diamond-value"><?php echo $value['Color']?></span>
            <span class="diamond-label"><?php echo "Color" ?></span>
          </div>
          <div class="item-col-4">
            <span class="diamond-value"><?php echo $this->diamond_lib->getCurrencySymbol($shopurl).$value['Price']?></span>
            <span class="diamond-label"><?php echo "Price" ?></span>
            <?php if(isset($value['Shape'])){
                      $urlshape = str_replace(' ', '-',$value['Shape']).'-shape-';
                  }else {
                      $urlshape = '';
                  }

                  if(isset($value['Carat'])){
                      $urlcarat = str_replace(' ', '-',$value['Carat']).'-carat-';
                  }else {
                      $urlcarat = '';
                  }
                  if(isset($value['Color'])){
                      $urlcolor = str_replace(' ', '-',$value['Color']).'-color-';
                  } else {
                      $urlcolor = '';
                  }
                  if(isset($value['Clarity'])){
                      $urlclarity = str_replace(' ', '-',$value['Clarity']).'-clarity-';
                  }else{
                      $urlclarity = '';
                  }
                  if(isset($value['Cut'])){
                      $urlcut = str_replace(' ', '-',$value['Cut']).'-cut-';
                  }else{
                      $urlcut = '';
                  }
                  if(isset($value['Cert'])){
                      $urlcert = str_replace(' ', '-',$value['Cert']).'-certificate-';
                  }else{
                      $urlcert = '';
                  }

                  $urlstring = strtolower($urlshape.$urlcarat.$urlcolor.$urlclarity.$urlcut.$urlcert.'sku-'.$value['ID']);

                  $type = '';
                  if(isset($value['Type'])){
                      $type = $value['Type'];
                  }
                  $diamondviewurl = $this->diamond_lib->getDiamondViewUrl($urlstring,$type,$shopurl,$pathprefixshop);
                  ?>
                  <a href="<?php echo $diamondviewurl; ?>" class="view-product"><?php echo 'View'; ?>
                  </a>
          </div>
        </div>
       <?php endforeach;?>
     </div>
   </div>
</div>
<?php } ?>
<script type="text/javascript">
  
       jQuery(document).ready(function ($) {
           $("#compare-sortable tbody").sortable({
               cursor: "move",
               placeholder: "sortable-placeholder",
               helper: function (e, tr)
               {
                   var $originals = tr.children();
                   var $helper = tr.clone();
                   $helper.children().each(function (index)
                   {
                       $(this).width($originals.eq(index).width());
                   });
                   return $helper;
               }
           }).disableSelection();
           $('.shape-type input:checkbox').change(function () {
               if ($(this).is(':checked'))
                   $(this).parent().addClass('selected');
               else
                   $(this).parent().removeClass('selected');
           });
           var acc = document.getElementsByClassName("accordion");
           var i;
           for (i = 0; i < acc.length; i++) {
               acc[i].addEventListener("click", function () {
                   this.classList.toggle("active");
                   var panel = this.nextElementSibling;
                   if (panel.style.maxHeight) {
                       panel.style.maxHeight = null;
                   } else {
                       panel.style.maxHeight = panel.scrollHeight + "px";
                   }
               });
           }
       });

       function removeDummy(className,selectedcheckboxidrb) {
        jQuery('.loading-mask').show();
        var elements = document.getElementsByClassName(className);
        var diamondcookiedata = getCookie('comparediamondProductrb');
        while (elements.length > 0) {
            elements[0].parentNode.removeChild(elements[0]);
        }
        if(jQuery('.compare-actions td').length == 1 ){
          var redirectURL = 'https://'+ '<?php echo $shopurl ?>' + '/apps/ringbuilder/diamondtools/compare/';

          window.location.replace(redirectURL);
          console.log(redirectURL);
        }
         compareItemsarrayrb.pop(selectedcheckboxidrb);
         jQuery.ajax({ 
         url: '<?php echo base_url(); ?>ringbuilder/diamondtools/removeDiamondrb',
         data: {action: 'removeDiamondrb', selectedcheckboxidrb : selectedcheckboxidrb,comparediamondProductrb:diamondcookiedata },
         type: 'POST',
         success: function(response) {
            if(JSON.parse(localStorage.getItem("compareItemsrb"))){
                var delLocaldatarb = JSON.parse(localStorage.getItem("compareItemsrb"));
                var removeLocaldata = delLocaldatarb.map(delLocaldatarb => delLocaldatarb.ID);
                var index = delLocaldatarb.findIndex(delLocaldatarb => delLocaldatarb.ID == selectedcheckboxidrb);
                if (index > -1) {
                     delLocaldatarb.splice(index, 1);
                     localStorage.removeItem('compareItemsrb');
                }
                localStorage.setItem('compareItemsrb', JSON.stringify(delLocaldatarb));
            } 
            console.log(index);
            console.log(delLocaldatarb);

            if(JSON.parse(getCookie('comparediamondProductrb'))){
                var delcookiedata = JSON.parse(getCookie('comparediamondProductrb'));
                var removecookiedata = delcookiedata.map(delcookiedata => delcookiedata.ID);
                var cookieindex = delcookiedata.findIndex(delcookiedata => delcookiedata.ID == selectedcheckboxidrb);
                if (cookieindex > -1) {
                     delcookiedata.splice(cookieindex, 1);
                     jQuery.removeCookie('comparediamondProductrb');
                }
                    jQuery.cookie("comparediamondProductrb", JSON.stringify(delcookiedata), {
                        path: '/',
                        expires: expire
                    });
            } 

            console.log(cookieindex);
            console.log(delcookiedata);
            jQuery('.loading-mask').hide();
          }
        });
    }
   
   // function removeDummy(className) {
   //     var elements = document.getElementsByClassName(className);
   //     while(elements.length > 0){
   //         elements[0].parentNode.removeChild(elements[0]);
   //     }
   //     if($('.compare-actions td').length == 1 ){
   //      var redirectURL = 'https://'+ '<?php echo $shopurl ?>' + '/apps/rinbuilder/diamondtools/';
   //      window.location.replace(redirectURL);
   //     }
   // }
   jQuery(document).ready(function () {
    jQuery('[data-toggle="tooltip"]').tooltip();
  });
</script>