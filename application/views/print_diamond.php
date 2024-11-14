<?php $diamond = (array) $this->diamond_lib->getDiamondById($diamond_id,$diamondtype,$shop); 
?>
<div class="printdiv" id="printdiv">
   <div class="print-header" style="background-color:#1979c3 !important; color: #fff !important;">
      <div class="header-container">
         <div class="header-title">
            <h2 style="color: #fff !important;"><?php echo 'Diamond Detail'; ?></h2>
         </div>
         <div class="header-date">
            <h4 style="color: #fff !important;"><?php echo date("d/m/Y"); ?></h4>
         </div>
      </div>
   </div>
   <section class="diamonds-search with-specification diamond-page">
      <div class="d-container">
         <div class="d-row">
            <div class="diamonds-print-preview no-padding" style="background-color: #f7f7f7 !important;      border: 1px solid #e8e8e8 !important;">
               <div class="diamond-info-one">
                  <img src="<?php echo $diamond['diamondData']['image2'] ?>" style="height: 100px;width: 100px;" />
               </div>
               <div class="diamond-info-two">
                  <img src="<?php echo $diamond['diamondData']['image1'] ?>" style="height: 100px;width: 165px;"/>
               </div>
               <div class="print-info">
                  <p>SKU# <span><?php echo $diamond['diamondData']['diamondId'] ?></span></p>
               </div>
            </div>
            <div class="print-diamond-certifications">
               <div class="diamonds-grade">
                  <img src="<?php echo $diamond['diamondData']['certificateIconUrl'] ?>" style="height: 75px;width: 75px;"/>
               </div>
               <div class="diamonds-grade-info">
                  <p><?php echo $diamond['diamondData']['subHeader']; ?></p>
               </div>
            </div>
            <div class="print-details">
               <div class="diamond-title">
                  <div class="diamond-name">
                     <h2><?php echo $diamond['diamondData']['mainHeader']; ?></h2>
                     <p><?php echo $diamond['diamondData']['subHeader']; ?></p>
                  </div>
                  <div class="diamond-price">
                     <span><?php 
                     if($diamond['diamondData']['currencyFrom'] == 'USD'){
                        echo "$".number_format($diamond['diamondData']['fltPrice']);
                     }else{
                        echo $diamond['diamondData']['currencyFrom'].$diamond['diamondData']['currencySymbol'].number_format($diamond['diamondData']['fltPrice']);
                     }
                      ?></span>
                  </div>
               </div>
               <div class="diamond-inner-details">
                  <ul>
                     <?php if(isset($diamond['diamondData']['diamondId'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Stock Number'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php echo $diamond['diamondData']['diamondId'] ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($diamond['diamondData']['fltPrice'])) {/* ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Price'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php echo $diamond['diamondData']['currencyFrom'].$diamond['diamondData']['currencySymbol'].$diamond['diamondData']['fltPrice']; ?></p>
                        </div>
                     </li>
                     <?php */} ?>
                     <?php if(isset($diamond['diamondData']['fltPrice'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Price Per Carat'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php 
                           if($diamond['diamondData']['currencyFrom'] == 'USD'){
                              echo "$".number_format(str_replace(',', '', $diamond['diamondData']['fltPrice'])/$diamond['diamondData']['caratWeight']);    
                           }else{
                              echo $diamond['diamondData']['currencyFrom'].$diamond['diamondData']['currencySymbol'].number_format(str_replace(',', '', $diamond['diamondData']['fltPrice'])/$diamond['diamondData']['caratWeight']); 
                           }
                           

                           ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($diamond['diamondData']['caratWeight'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Carat Weight'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php echo $diamond['diamondData']['caratWeight'] ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($diamond['diamondData']['cut'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Cut'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php echo $diamond['diamondData']['cut'] ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($diamond['diamondData']['color'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Color'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php echo $diamond['diamondData']['color'] ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($diamond['diamondData']['clarity'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Clarity'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php echo $diamond['diamondData']['clarity'] ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($diamond['diamondData']['certificate'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Report'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <span><?php echo $diamond['diamondData']['certificate']; ?></span>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($diamond['diamondData']['depth'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Depth %'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php echo $diamond['diamondData']['depth'].'%'; ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($diamond['diamondData']['table'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Table %'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php echo $diamond['diamondData']['table'].'%'; ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($diamond['diamondData']['polish'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Polish'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php echo $diamond['diamondData']['polish']; ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($diamond['diamondData']['symmetry'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Symmetry'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php echo $diamond['diamondData']['symmetry']; ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($diamond['diamondData']['gridle'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Girdle'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php echo $diamond['diamondData']['gridle']; ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($diamond['diamondData']['culet'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Culet'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php echo $diamond['diamondData']['culet']; ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($diamond['diamondData']['fluorescence'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Fluorescence'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php echo $diamond['diamondData']['fluorescence']; ?></p>
                        </div>
                     </li>
                     <?php } ?>
                     <?php if(isset($diamond['diamondData']['measurement'])) { ?>
                     <li>
                        <div class="diamond-specifications">
                           <p><?php echo 'Measurement'; ?></p>
                        </div>
                        <div class="diamond-quality">
                           <p><?php echo $diamond['diamondData']['measurement']; ?></p>
                        </div>
                     </li>
                     <?php } ?>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
<style type="text/css">
@media print {
   body {-webkit-print-color-adjust: exact !important;letter-spacing: 0.6px !important}
   header nav, footer {
      display: none !important;
   }
   @page {
      size:A4 portrait;
      margin-left: 10px !important;
      margin-right: 10px !important;
      margin-top: 0px !important;
      margin-bottom: 0px !important;
      -webkit-print-color-adjust: exact !important;
   }      
   * {
      -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
      color-adjust: exact !important;                 /*Firefox*/
   }
   /*DIAMONDS PRINT START*/
   .print-header {
      float: left;
      width: 100%;

   }
   .header-container {
      display: table;
      width: 100%;
      padding: 10px 0 !important;
   }
   .print-header h2,
   .print-header h4 {
      margin: 5px !important;
      padding: 0;
   }
   .print-header .header-title, .print-header .header-date {
      display: table-cell;
      text-align: left;
      vertical-align: middle;
      color: #fff !important;
   }
   .print-header .header-date {
      text-align: right;
   }
   .print-header h2 {
      font-size: 22px;
      font-weight: 400;
   }
   .print-header h4 {
      font-size: 18px;
      font-weight: 400;
   }
   .header-container {
      display: table;
      width: 100%;
      margin: 0 auto;
   }
   .diamonds-print-preview {
      float: left;
      width: 100%;
      background: #f7f7f7 !important;
      border: 1px solid #e8e8e8 !important;
      box-sizing: border-box;
      padding: 5px;
      margin-top: 9px;
   }
   .diamonds-print-preview .diamond-info-one, .diamonds-print-preview .diamond-info-two {
      float: left;
      width: 50%;
      text-align: center;
      padding: 6px;
      box-sizing: border-box;
      padding-bottom: 0px !important;
   }
   .diamonds-print-preview .print-info {
      float: left;
      width: 100%;
      text-align: center;
      margin: 5px 0;
   }
   .diamonds-print-preview .print-info span {
      font-size: 16px;
      color: #000 !important;
   }
   .diamonds-print-preview .print-info p {
      font-size: 18px;
      color: #000 !important;
      font-weight: 600;
      margin-bottom: 0px !important; 
   }
   .diamonds-print-preview .print-info p span {
      font-size: 18px;
      color: #1979c3 !important;
   }
   .diamonds-grade-info {
      display: table-cell;
      vertical-align: middle;
   }
   .diamonds-grade {
      display: table-cell;
      vertical-align: middle;
      width: 80px;
   }
   .print-diamond-certifications {
      float: left;
      width: 100%;
      clear: both;
      background: #e8e8e8 !important;
      padding: 5px;
      box-sizing: border-box;
      margin-top: 8px;
      border: 1px solid #e8e8e8 !important;
      margin-bottom: 7px;
   }
   .diamonds-grade-info p {
      margin: 0;
      padding: 0;
      font-size: 15px;
      color: #000 !important;
   }
   .print-details {
      float: left;
      width: 100%;
      clear: both;
      border: 1px solid #e8e8e8 !important;
   }
   .diamond-title {
      background: #1979c3 !important;
      display: table;
      width: 100%;
      vertical-align: middle;
      padding: 10px 10px;
      box-sizing: border-box;
   }
   .diamond-title h2 {
      color: #fff !important;
      font-size: 20px;
      font-weight: 400;
      margin: 0;
      padding: 0;
   }
   .diamond-title p {
      color: #fff !important;
      font-size: 14px;
      margin: 0;
      padding: 0;
      margin-top: 5px;
   }
   .diamond-title .diamond-name {
      display: table-cell;
      vertical-align: middle;
   }
   .diamond-title .diamond-price {
      display: table-cell;
      vertical-align: middle;
   }
   .diamond-title .diamond-price span{
      font-size: 16px;
      color: #fff !important;
   }
   .diamond-inner-details {
      float: left;
      width: 100%;
   }
   .diamond-inner-details ul {
      margin: 0;
      padding: 0;
      list-style: none;
   }
   .diamond-inner-details ul li {
      float: left;
      width: 100%;
      padding: 7px 15px;
      box-sizing: border-box;
      border-bottom: 1px solid #e8e8e8;
      margin-bottom: 0px !important;
      margin-top: 0px !important;
   }
   .diamond-inner-details ul li div {
      float: left;
      width: 50%;
      text-align: left;
   }
   .diamond-inner-details ul li .diamond-quality {
      text-align: right;
   }
   .diamond-specifications p {
      font-size: 14px;
      color: #000 !important;
      font-weight: 500;
      margin: 0;
      padding: 0;
   }
   .diamond-inner-details ul li:last-child {
      border: 0;
   }
}
</style>