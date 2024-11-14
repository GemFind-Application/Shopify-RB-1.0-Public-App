//For Tryon button
jQuery(document).ready(function ($) {

    $("a.tryonbtn").fancybox({
        type: "iframe",
        iframe: {
            // Iframe template
            tpl: '<iframe id="tryoniFrameID" allowfullscreen class="fancybox-iframe" scrolling="auto" width="1200" height="800" allow="camera"></iframe>'
        }
    });
    
    //when click on close
    window.addEventListener('message', function(event) {
        
        if (~event.origin.indexOf('https://cdn.camweara.com')) { 
            
            if(event.data == "closeIframe"){ //Close
                
                //var iframe = document.getElementById("iFrameID"); 
                //iframe.contentWindow.location.replace("");
                //iframe.style.display = "none";
 
                $.fancybox.close();
                
            } else if(event.data.includes("buynow")){
                
                $('#product_addtocart_form').submit();
            }
        }
    });
});