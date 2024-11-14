/*$(document).ready(function() {
   $("#search-diamonds-form #submit").trigger("click");
   $('.loading-mask.gemfind-loading-mask').css('display', 'none');
});*/
// $(document).ready(function() {
//   checkStatus();
// });

function formSubmit(e,url,id){
            
            var options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                modalClass: 'custom-modal',
                buttons: [],
                opened: function($Event) {
                    $(".modal-footer").hide();
                }
            };
            
            var dataFormHint = $('#'+id);

            dataFormHint.validate({
                rules: {        
                  name: {
                    required: true
                  },
                  email:{
                    required: true,
                    emailcustom:true,
                  },
                  recipient_name:{
                    required: true
                  },
                  recipient_email:{
                    required: true,
                    emailcustom:true,
                  },
                  gift_reason:{
                    required: true
                  },
                  hint_message:{
                    required: true
                  },
                  friend_name:{
                    required: true
                  },
                  friend_email:{
                    required: true,
                    emailcustom:true,
                  },
                  message:{
                    required: true
                  },
                  gift_deadline:{
                    required: true,

                  },
                  phone:{
                    required: true,
                    phoneno: true
                  },
                  location:{
                    required: true,

                  },
                  avail_date:{
                    required: true,
                  },
                  appnt_time:{
                    required: true,
                  },
                  contact_pref:{
                    required: true,
                  }
                },
                messages: {
                    gift_deadline: "Select the Gift Deadline.",
                    avail_date: "Select your availability.",
                    contact_pref: "Please select one of the options.",
                },
                errorPlacement: function(error, element) 
                {
                    if ( element.is(":radio") ) 
                    {
                        error.appendTo( element.parents('.pref_container') );
                    }
                    else 
                    { // This is the default behavior 
                        error.insertAfter( element );
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: $('#'+id).serialize(),
                        dataType: 'json',
                        beforeSend: function(settings) {
                                    $('.loading-mask.gemfind-loading-mask').css('display', 'block');
                                },
                        success: function(response) {
                            console.log(response);
                            if(response.output.status == 2){
                                
                                $("#gemfind-drop-hint-required label").empty();   
                                $("#gemfind-request-more-required label").empty();
                                $("#gemfind-email-friend-required label").empty(); 
                                $("#gemfind-schedule-view-required label").empty(); 
                                $('.loading-mask.gemfind-loading-mask').css('display', 'none');
                                $('#gemfind-drop-hint-required label').append(response.output.msg); 
                                $('#gemfind-request-more-required label').append(response.output.msg);  
                                $('#gemfind-email-friend-required label').append(response.output.msg);
                                $('#gemfind-schedule-view-required label').append(response.output.msg);  


                                
                                
                                return true;
                            }
                            

                            if(response.output.status == 1){
                                console.log('email send');

                                var parId = $('#' + id).parent().attr('id');
                                //$('#' + parId + ' .note').html(response.output.msg);
                                $('.loading-mask.gemfind-loading-mask').css('display', 'none');
                                //$('#' + parId + ' .note').css('display', 'block');
                               // $('#' + parId + ' .note').css('color', 'green');
                                //$('#' + parId + ' .note').css('background', '#c6efd5');
                                $('#popup-modal .note').html(response.output.msg);
                                $('#popup-modal .note').css('display', 'block');
                                $('#popup-modal .note').css('color', 'green');
                                //$('#popup-modal .note').css('background', '#c6efd5');
                                $("#popup-modal").modal('show');
                                 $('#popup-modal').on('hidden.bs.modal', function () {
                                    console.log('close modal');
                                    $('.cancel.preference-btn').click();
                                });
                                setTimeout(function(){ $('#' + parId + ' .note').html(''); $('#' + parId + ' .note').css('display', 'none'); $('#' + parId + ' .note').css('background', '#fff');}, 5000);
                            } else {
                                console.log('some error');
                                var parId = $('#' + id).parent().attr('id');
                                //$('#' + parId + ' .note').html(response.output.msg);
                                $('#popup-modal .note').html(response.output.msg);
                                $('#popup-modal .modal-title').html('Error');
                                $('.loading-mask.gemfind-loading-mask').css('display', 'none');
                                $('#popup-modal .note').css('display', 'block');
                                $('#popup-modal .note').css('color', 'red');
                                $('#popup-modal .note').css('background', '#f7c6c6');
                                $("#popup-modal").modal('show');
                                $('#popup-modal').on('hidden.bs.modal', function () {
                                    console.log('close modal');
                                    $('.cancel.preference-btn').click();
                                });
                                setTimeout(function(){ $('#' + parId + ' .note').html(''); $('#' + parId + ' .note').css('display', 'none'); $('#' + parId + ' .note').css('background', '#fff');}, 5000);
                            }
                            document.getElementById(id).reset();
                            return true;
                        }
                    });
                }
            });


                jQuery.validator.addMethod("emailcustom",function(value,element) {
                    return this.optional(element) || /^[a-zA-Z0-9_\.%\+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,}$/i.test(value);
                },"Please enter valid email address");

                jQuery.validator.addMethod("phoneno", function(phone_number, element) {
                    phone_number = phone_number.replace(/\s+/g, "");
                    return this.optional(element) || phone_number.length > 9 && 
                    phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
                }, "<br />Please specify a valid phone number");

        
    }

// function checkStatus(){
//     var redirectUrl = window.location.origin;
//     console.log(redirectUrl);
//     $.ajax({
//             url: 'https://gemfind.us/ringbuilder/ringbuilder/diamondtools/storestatus',
//             data: "shop="+window.Shopify.shop,
//             type: 'POST',
          
//             success: function (response) {

//                if (response == "false") {
//                     alert("You haven't select any plan. Please select plan first");
//                     window.location.href=redirectUrl;
//                }
//             }
//         });
// }

function CallSpecification() {
    document.getElementById("diamond-data").style.display = "none";
    document.getElementById("diamond-specification").style.display = "block";
}

function CallDiamondDetail() {
    document.getElementById("diamond-data").style.display = "block";
    document.getElementById("diamond-content-data").style.display = "block";
    document.getElementById("diamond-specification").style.display = "none";
    var el1 = document.getElementById("drop-hint-main");
    if(el1){
        el1.style.display = "none";    
        document.getElementById("form-drop-hint").reset();
    }
    var el2 = document.getElementById("email-friend-main");
    if(el2){
        el2.style.display = "none";    
        document.getElementById("form-email-friend").reset();
    }
    var el3 = document.getElementById("req-info-main");
    if(el3){
        el3.style.display = "none";    
        document.getElementById("form-request-info").reset();
    }
    var el4 = document.getElementById("schedule-view-main");
    if(el4){
        el4.style.display = "none";    
        document.getElementById("form-schedule-view").reset();
    }
}

function CallShowform(e) {
    console.log('CallShowform');

    document.getElementById("diamond-specification").style.display = "none";
    var el1 = document.getElementById("drop-hint-main");
    if(el1){
        el1.style.display = "none";    
        document.getElementById("form-drop-hint").reset();
    }
    var el2 = document.getElementById("email-friend-main");
    if(el2){
        el2.style.display = "none";    
        document.getElementById("form-email-friend").reset();
    }
    var el3 = document.getElementById("req-info-main");
    if(el3){
        el3.style.display = "none";    
        document.getElementById("form-request-info").reset();

    }
    var el4 = document.getElementById("schedule-view-main");
    if(el4){
        el4.style.display = "none";    
        document.getElementById("form-schedule-view").reset();
    }
    document.getElementById("diamond-content-data").style.display = "none";
    var x = e.target.getAttribute("data-target");
    document.getElementById(x).style.display = "block";
    
            $('#gift_deadline').datepicker({minDate: 0});
            //$('#avail_date').datepicker({minDate: 0});
            function appoitmentTime(start,stop)
            {
                times='';   stopAMPM=stop;  interval=30;
                start=start.split(":");
                starth=parseInt(start[0]);
                startm=((parseInt(start[1])) ? parseInt(start[1]) : '0');
                stop=stop.split(":");
                stopAMPM = stopAMPM.slice(-2);
                stoph=((stopAMPM.trim()==="PM" && (stop[0]!="12" && stop[0]!="12 PM")) ? (+parseInt(stop[0].replace(":", "")) + (+12)) : parseInt(stop[0]));
                stopm=((parseInt(stop[1])) ? parseInt(stop[1]) : '0');
                size= stoph>starth ? stoph-starth+1 : starth-stoph+1
                hours=[...Array(size).keys()].map(i => i + starth);
                option='';
                for (hour in hours) {
                    for (min = startm; min < 60; min += interval)  {
                        startm=0
                        if ((hours.slice(-1)[0] === hours[hour]) && (min > stopm)) {
                            break;
                        }
                        if (hours[hour] > 11 && hours[hour] !== 24 ) {
                            times=('0' + (hours[hour]%12 === 0 ? '12': hours[hour]%12)).slice(-2) + ':' + ('0' + min).slice(-2) + " " + 'PM';
                        } else {
                            times=('0' +  (hours[hour]%12 === 0 ? '12': hours[hour]%12)).slice(-2) + ':' + ('0' + min).slice(-2) + " " + 'AM';
                        }
                    option += "<option value='"+times+"'>"+times+"</option>";
                    }
                }
                return option;
            }

            $('#avail_date').datepicker(
            {
                minDate: 0,
                onSelect: function(dateText) {
                    var curDate = $(this).datepicker('getDate');
                    var dayName = $.datepicker.formatDate('DD', curDate);
                    if($(".timing_days.active").length){
                        var timingDays = $.parseJSON($(".timing_days.active").html());
                        var dayId;
                        if(dayName == "Sunday")
                        {
                            dayId = 0;
                        }
                        else if(dayName == "Monday")
                        {
                            dayId = 1;
                        }
                        else if(dayName == "Tuesday")
                        {
                            dayId = 2;
                        }
                        else if(dayName == "Wednesday")
                        {
                            dayId = 3;
                        }
                        else if(dayName == "Thursday")
                        {
                            dayId = 4;
                        }
                        else if(dayName == "Friday")
                        {
                            dayId = 5;
                        }
                        else 
                        {
                            dayId = 6;
                        }
                        $.each(timingDays, function( index, value ) {
                            if(dayId == index)
                            {
                                var key = Object.keys(value);
                                if(index == 0) {
                                    option = appoitmentTime(value.sundayStart,value.sundayEnd);
                                }
                                else if(index == 1) {
                                    option = appoitmentTime(value.mondayStart,value.mondayEnd);
                                }
                                else if(index == 2) {
                                    option = appoitmentTime(value.tuesdayStart,value.tuesdayEnd);
                                }
                                else if(index == 3) {
                                    option = appoitmentTime(value.wednesdayStart,value.wednesdayEnd);                                    
                                }
                                else if(index == 4) {
                                    option = appoitmentTime(value.thursdayStart,value.thursdayEnd);                                    
                                }
                                else if(index == 5) {
                                    option = appoitmentTime(value.fridayStart,value.fridayEnd);
                                }
                                else if(index == 6) {
                                    option = appoitmentTime(value.saturdayStart,value.saturdayEnd);                                    
                                }
                                jQuery("#appnt_time").html(option);
                            }
                        });   
                        $("#appnt_time").show();   
                    }
                    else
                    {
                        $(".timing_not_avail").show();
                        $(".book-slots").prop("disabled", true);
                    }

                     
                },
                beforeShowDay: function(d) {                    
                    var day = d.getDay();
                    var closeDay = [];
                    var myarray = []; 
                    if($( ".form-schedule-view" ).hasClass(".timing_days.active")){
                        var timingDays = $.parseJSON($(".timing_days.active").html());
                        $.each(timingDays, function( index, value ) {
                                var key = Object.keys(value);
                                if(index == 0) {
                                    if(value.sundayStart == '' || value.sundayEnd == ''){
                                       closeDay.push(index);
                                    }  
                                }
                                else if(index == 1) {
                                    if(value.mondayStart == '' || value.mondayEnd == ''){
                                        closeDay.push(index);
                                    }
                                }
                                else if(index == 2) {
                                    if(value.tuesdayStart == '' || value.tuesdayEnd == ''){
                                        closeDay.push(index);
                                    }
                                }
                                else if(index == 3) {
                                    if(value.wednesdayStart == '' || value.wednesdayEnd == ''){
                                        closeDay.push(index);
                                    }
                                }
                                else if(index == 4) {
                                    if(value.thursdayStart == '' || value.thursdayEnd == ''){
                                        closeDay.push(index);
                                    }
                                }
                                else if(index == 5) {
                                    if(value.fridayStart == '' || value.fridayEnd == ''){
                                        closeDay.push(index);
                                    }
                                }
                                else if(index == 6) {
                                    if(value.saturdayStart == '' || value.saturdayEnd == ''){
                                        closeDay.push(index);
                                    }
                                }
                        });
                    }
                    $(".day_status_arr").each(function() {
                        myarray.push($(this).html());
                        closeDay.push(parseInt($(this).html()));
                    });
                    if($.inArray(day, closeDay) != -1) {
                        return [ false, "closed", "Closed on Monday" ];
                        //return [ true, "", "" ];
                    } else {
                        return [ true, "", "" ];
                    } 
                }
            });

$("#schview_loc").on('change', function (e) {
      $locationid = $(this).find(':selected').attr("data-locationid");
      console.log( $locationid );
      if($('#avail_date').val() != "")
      {
        $('#avail_date').datepicker('setDate', null);
      }
      $(".timing_days").removeClass("active");
      $(".timing_days").each(function( index ) {
          if($( this ).attr("data-location") == $locationid)
          {
            $(this).addClass("active");
            return false;
          }
      });
});
    
}


// function Videorun(e){
//     document.getElementById("diamondimg").style.display = "none";
//     document.getElementById("diamondvideo").style.display = "block"; 
//     //document.getElementById('diamondmainimage').setAttribute('src', document.getElementById('diamondimg').getAttribute('data-loadimg')); 
//     setTimeout(function(){ 
//         $(".main_slider_loader").hide();
//         $( '#iframevideo' ).show();     
//         document.getElementById('iframevideo').setAttribute('src', document.getElementById('iframevideo').getAttribute('src'));
//     }, 1000);
//     $(".main_slider_loader").show();
//     $( '#iframevideo' ).hide();     
// }



function Imageswitch2(e){
        document.getElementById("diamondimg").style.display = "block";
       // document.getElementById("diamondvideo").style.display = "none";      
        setTimeout(function(){ 
            document.getElementById('diamondmainimage').setAttribute('src', document.getElementById('thumbimg2').getAttribute('src'));
        }, 500);              
        document.getElementById('diamondmainimage').setAttribute('src', document.getElementById('diamondimg').getAttribute('data-loadimg'));
}
function Imageswitch1(e){   
        document.getElementById("diamondimg").style.display = "block";
        //document.getElementById("diamondvideo").style.display = "none";    
        setTimeout(function(){ 
            document.getElementById('diamondmainimage').setAttribute('src', document.getElementById('thumbimg1').getAttribute('src'));
        }, 500);
        document.getElementById('diamondmainimage').setAttribute('src', document.getElementById('diamondimg').getAttribute('data-loadimg'));
}

function Closeform(e){
        var x = e.target.getAttribute("data-target");
        var el1 = document.getElementById("form-drop-hint");
        if(el1){  
            el1.reset();
            $('#form-drop-hint label.error').remove();
        }
        var el2 = document.getElementById("form-email-friend");
        if(el2){  
            el2.reset();
            $('#form-email-friend label.error').remove();
        }
        var el3 = document.getElementById("form-request-info");
        if(el3){  
            el3.reset();
            $('#form-request-info label.error').remove();
        }
        var el4 = document.getElementById("form-schedule-view");
        if(el4){  
            el4.reset();
            $('#form-schedule-view #appnt_time').hide();
            $('#form-schedule-view label.error').remove();
        }
        document.getElementById(x).style.display = "none";
        document.getElementById("diamond-content-data").style.display = "block";
}

function focusFunction(e){
    
        if(!e.value){
        $(e).parent().addClass('moveUp');
        $(e).nextAll('span:first').addClass('moveUp'); 
        }    
    
}

function focusoutFunction(e){
    
        if(!e.value){
            $(e).parent().removeClass('moveUp');
            $(e).nextAll('span:first').removeClass('moveUp');
        }
    
}