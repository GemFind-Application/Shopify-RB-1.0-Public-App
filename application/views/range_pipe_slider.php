<script type="text/javascript">
jQuery(document).ready(function ($) {
    /*clarity Slider*/
	if( $('#clarity-slider').length ){
		var clarity_array = <?php echo json_encode($claritys_attr); ?>;
		var claritysliders = $("#clarity-slider")[0]; 
		var max_step = parseInt($(claritysliders).attr('data-steps')); 
		var start = $('.diamond_clarity').attr("data-start");
		var stop = $('.diamond_clarity').attr("data-stop");
		csliders=noUiSlider.create(claritysliders, {
			start: [start, stop],
			connect: true,		
			range: {
				'min': 1,
				'max': max_step
			},
			step: 1,
			behaviour: 'none',
			margin:1,		
			pips: {
				mode: 'steps',
				density: max_step,
				filter: function() {
					return 1;
				}
			},
		});
		claritysliders.noUiSlider.on('update', function( values, handle ) {
		  var value = values[handle];    
		  $('#clarity-r-slider .noUi-pips .noUi-value').each(function(key, value) {
				$(this).html(clarity_array[key].clarityName);
				$(this).attr('data-clarity-id', clarity_array[key].clarityId);
				$(this).attr('title', clarity_array[key].clarityName);
				$(this).attr('data-placement', 'bottom');
		  });	  
		});
		claritysliders.noUiSlider.on('change', function( values, handle ) {
			var minValue = Number(values[0])-1;
			var maxValue = Number(values[1])-2;
			var clarity_ids = [];
			$('#clarity-r-slider .noUi-pips .noUi-value').each(function(key, value) {	
				if(key >= minValue  && key <= maxValue ){
					if($(this).attr('data-clarity-id') != "000")
						clarity_ids.push($(this).attr('data-clarity-id'));
				}
			});
			$('.diamond_clarity').val(clarity_ids);
			$('.diamond_clarity').attr("data-start",Number(values[0]));
			$('.diamond_clarity').attr("data-stop",Number(values[1]));
			$("#search-diamonds-form #submit").trigger("click");
		});
		claritysliders.noUiSlider.on('start', function( values, handle ) {
			$('#clarity-r-slider .noUi-tooltip').css('opacity','1');
			$('#clarity-r-slider .noUi-tooltip').css('display','block');
		});
		claritysliders.noUiSlider.on('end', function( values, handle ) {
			$('#clarity-r-slider .noUi-tooltip').fadeOut(2000);
		});
	}
	/*polish Slider*/
	if( $('#polish-slider').length ){
		var polish_array = <?php echo json_encode($polishs_attr); ?>;
		var polishsliders = $("#polish-slider")[0]; 
		var max_step = parseInt($(polishsliders).attr('data-steps'));
		var start = $('.diamond_polish').attr("data-start");
		var stop = $('.diamond_polish').attr("data-stop");
		csliders=noUiSlider.create(polishsliders, {
			start: [start, stop],
			connect: true,	
			range: {
				'min': 1,
				'max': max_step
			},
			step: 1,
			behaviour:'none',
			margin:1,		
			pips: {
				mode: 'steps',
				density: max_step,
				filter: function() {
					return 1;
				}
			},
		});
		polishsliders.noUiSlider.on('update', function( values, handle ) {
		  var value = values[handle];    
		  $('#polish-r-slider .noUi-pips .noUi-value').each(function(key, value) {
				$(this).html(polish_array[key].polishName);
				$(this).attr('data-polish-id', polish_array[key].polishId);
				$(this).attr('title', polish_array[key].polishName);
				$(this).attr('data-placement', 'bottom');
		  });	  
		});
		polishsliders.noUiSlider.on('change', function( values, handle ) {
			var minValue = Number(values[0])-1;
			var maxValue = Number(values[1])-2;
			var polish_ids = [];
			$('#polish-r-slider .noUi-pips .noUi-value').each(function(key, value) {	
				if(key >= minValue  && key <= maxValue ){
					if($(this).attr('data-polish-id') != "000")
						polish_ids.push($(this).attr('data-polish-id'));
				}
			});
			$('.diamond_polish').val(polish_ids);
			$('.diamond_polish').attr("data-start",Number(values[0]));
			$('.diamond_polish').attr("data-stop",Number(values[1]));	
			$("#search-diamonds-form #submit").trigger("click");
		});
		polishsliders.noUiSlider.on('start', function( values, handle ) {
			$('#polish-r-slider .noUi-tooltip').css('opacity','1');
			$('#polish-r-slider .noUi-tooltip').css('display','block');
		});
		polishsliders.noUiSlider.on('end', function( values, handle ) {
			$('#polish-r-slider .noUi-tooltip').fadeOut(2000);
		});
	}
	
	/*symmetry Slider*/
	if( $('#symmetry-slider').length ){
		var symmetry_array = <?php echo json_encode($symmetrys_attr); ?>;
		var symmetrysliders = $("#symmetry-slider")[0]; 
		var max_step = parseInt($(symmetrysliders).attr('data-steps'));
		var start = $('.diamond_symmetry').attr("data-start");
		var stop = $('.diamond_symmetry').attr("data-stop");		
		csliders=noUiSlider.create(symmetrysliders, {
			start: [start, stop],
			connect: true,		
			range: {
				'min': 1,
				'max': max_step
			},
			step: 1,
			behaviour:'none',
			margin:1,		
			pips: {
				mode: 'steps',
				density: max_step,
				filter: function() {
					return 1;
				}
			},
		});
		symmetrysliders.noUiSlider.on('update', function( values, handle ) {
		  var value = values[handle];    
		  $('#symmetry-r-slider .noUi-pips .noUi-value').each(function(key, value) {
				$(this).html(symmetry_array[key].symmetryName);
				$(this).attr('data-symmetry-id', symmetry_array[key].symmetryId);
				$(this).attr('title', symmetry_array[key].symmetryName);
				$(this).attr('data-placement', 'bottom');
		  });	  
		});
		symmetrysliders.noUiSlider.on('change', function( values, handle ) {
			var minValue = Number(values[0])-1;
			var maxValue = Number(values[1])-2;
			var symmetry_ids = [];
			$('#symmetry-r-slider .noUi-pips .noUi-value').each(function(key, value) {	
				if(key >= minValue  && key <= maxValue ){
					if($(this).attr('data-symmetry-id') != "000")
						symmetry_ids.push($(this).attr('data-symmetry-id'));
				}
			});
			$('.diamond_symmetry').val(symmetry_ids);
			$('.diamond_symmetry').attr("data-start",Number(values[0]));
			$('.diamond_symmetry').attr("data-stop",Number(values[1]));
			$("#search-diamonds-form #submit").trigger("click");
		});
		symmetrysliders.noUiSlider.on('start', function( values, handle ) {
			$('#symmetry-r-slider .noUi-tooltip').css('opacity','1');
			$('#symmetry-r-slider .noUi-tooltip').css('display','block');
		});
		symmetrysliders.noUiSlider.on('end', function( values, handle ) {
			$('#symmetry-r-slider .noUi-tooltip').fadeOut(2000);
		});
	}
	/*Cut Slider*/
	
	if( $('#cut-slider').length ){
		var cut_array = <?php echo json_encode($cuts_attr); ?>;
		var cutsliders = $("#cut-slider")[0]; 
		var max_step = parseInt($(cutsliders).attr('data-steps')); 
		var start = $('.diamond_cut').attr("data-start");
		var stop = $('.diamond_cut').attr("data-stop");
		csliders=noUiSlider.create(cutsliders, {
			start: [start, stop],
			connect: true,	
			range: {
				'min': 1,
				'max': max_step
			},
			step: 1,
			behaviour: 'none',
			margin:1,		
			pips: {
				mode: 'steps',
				density: max_step,
				filter: function() {
					return 1;
				}
			},
		});
		cutsliders.noUiSlider.on('update', function( values, handle ) {
		  var value = values[handle];    
		  $('#cut-r-slider .noUi-pips .noUi-value').each(function(key, value) {
				$(this).html(cut_array[key].cutName);
				$(this).attr('data-cut-id', cut_array[key].cutId);
				$(this).attr('title', cut_array[key].cutName);
				$(this).attr('data-placement', 'bottom');
		  });	  
		});
		cutsliders.noUiSlider.on('change', function( values, handle ) {
			var minValue = Number(values[0])-1;
			var maxValue = Number(values[1])-2;
			var cut_ids = [];
			$('#cut-r-slider .noUi-pips .noUi-value').each(function(key, value) {	
				if(key >= minValue  && key <= maxValue ){
					if($(this).attr('data-cut-id') != "000")
						cut_ids.push($(this).attr('data-cut-id'));

				}
			});
			$('.diamond_cut').val(cut_ids);
			$('.diamond_cut').attr("data-start",Number(values[0]));
			$('.diamond_cut').attr("data-stop",Number(values[1]));
			$("#search-diamonds-form #submit").trigger("click");
		});
		cutsliders.noUiSlider.on('start', function( values, handle ) {
			$('#cut-r-slider .noUi-tooltip').css('opacity','1');
			$('#cut-r-slider .noUi-tooltip').css('display','block');
		});
		cutsliders.noUiSlider.on('end', function( values, handle ) {
			$('#cut-r-slider .noUi-tooltip').fadeOut(2000);
		});
		function getCutToolTip(value) {

			value_index = value - 1; 	
		      return "<div class='more-tooltip-html'>"+cut_array[value_index].cutName+"</div>";
		}
	}
	/*color Slider*/
	if( $('#color-slider').length ){
		var color_array = <?php echo json_encode($colors_attr); ?>;
		var colorsliders = $("#color-slider")[0]; 
		var max_step = parseInt($(colorsliders).attr('data-steps')); 
		//max_step = max_step + 1;
		var start = $('.diamond_color').attr("data-start");
		var stop = $('.diamond_color').attr("data-stop");
		csliders=noUiSlider.create(colorsliders, {
			start: [start, stop],
			connect: true,	
			range: {
				'min': 1,
				'max': max_step
			},
			step: 1,
			behaviour:'none',
			margin:1,		
			pips: {
				mode: 'steps',
				density: max_step,
				filter: function() {
					return 1;
				}
			},
		});
		colorsliders.noUiSlider.on('update', function( values, handle ) {
		  var value = values[handle];    
		  $('#color-r-slider .noUi-pips .noUi-value').each(function(key, value) {
				$(this).html(color_array[key].colorName);
				$(this).attr('data-color-id', color_array[key].colorId);
				$(this).attr('title', color_array[key].colorName);
				$(this).attr('data-placement', 'bottom');
		  });	  
		});
		colorsliders.noUiSlider.on('change', function( values, handle ) {
			var totalCount = parseInt($(colorsliders).attr('data-steps')); 
			var minValue = Number(values[0])-1;
			var maxValue = Number(values[1])-2;
			
			var color_ids = [];
			$('#color-r-slider .noUi-pips .noUi-value').each(function(key, value) {	
				if(key >= minValue  && key <= maxValue ){
					if($(this).attr('data-color-id') != "000")
					color_ids.push($(this).attr('data-color-id'));
				}
			});
			$('.diamond_color').val(color_ids);
			$('.diamond_color').attr("data-start",Number(values[0]));
			$('.diamond_color').attr("data-stop",Number(values[1]));
			$("#search-diamonds-form #submit").trigger("click");
		});
		colorsliders.noUiSlider.on('start', function( values, handle ) {
			$('#color-r-slider .noUi-tooltip').css('opacity','1');
			$('#color-r-slider .noUi-tooltip').css('display','block');
		})
		colorsliders.noUiSlider.on('end', function( values, handle ) {
			$('#color-r-slider .noUi-tooltip').fadeOut(2000);
		})
		function getColorToolTip(value) {
			value_index = value - 1; 	
		      return "<div class='more-tooltip-html'>"+color_array[value_index].colorName+"</div>";
		}
	}
	/*diamondcolor Slider*/
	if( $('#diamondcolor-slider').length ){
		var diamondcolor_array = <?php echo json_encode($diamondcolors_attr); ?>;
		var diamondcolorsliders = $("#diamondcolor-slider")[0]; 
		var max_step = parseInt($(diamondcolorsliders).attr('data-steps')); 
		var start = $('.diamond_diamondcolor').attr("data-start");
		var stop = $('.diamond_diamondcolor').attr("data-stop");
		csliders=noUiSlider.create(diamondcolorsliders, {
			start: [start, stop],
			connect: true,	
			range: {
				'min': 1,
				'max': max_step
			},
			step: 1,
			behaviour: 'none',
			margin:1,		
			pips: {
				mode: 'steps',
				density: max_step,
				filter: function() {
					return 1;
				}
			},
		});
		diamondcolorsliders.noUiSlider.on('update', function( values, handle ) {
		  var value = values[handle];    
		  $('#diamondcolor-r-slider .noUi-pips .noUi-value').each(function(key, value) {
				$(this).html(diamondcolor_array[key].diamondcolorName);
				$(this).attr('data-diamondcolor-id', diamondcolor_array[key].diamondcolorId);
				$(this).attr('title', diamondcolor_array[key].diamondcolorName);
				$(this).attr('data-placement', 'bottom');
		  });	  
		});
		diamondcolorsliders.noUiSlider.on('change', function( values, handle ) {
			var minValue = Number(values[0])-1;
			var maxValue = Number(values[1])-2;
			var diamondcolor_ids = [];
			$('#diamondcolor-r-slider .noUi-pips .noUi-value').each(function(key, value) {	
				if(key >= minValue  && key <= maxValue ){
					if($(this).attr('data-diamondcolor-id') != "000")
						diamondcolor_ids.push($(this).attr('data-diamondcolor-id'));
				}
			});
			$('.diamond_diamondcolor').val(diamondcolor_ids);
			$('.diamond_diamondcolor').attr("data-start",Number(values[0]));
			$('.diamond_diamondcolor').attr("data-stop",Number(values[1]));
			$("#search-diamonds-form #submit").trigger("click");
		});
		diamondcolorsliders.noUiSlider.on('start', function( values, handle ) {
			$('#diamondcolor-r-slider .noUi-tooltip').css('opacity','1');
			$('#diamondcolor-r-slider .noUi-tooltip').css('display','block');
		});
		diamondcolorsliders.noUiSlider.on('end', function( values, handle ) {
			$('#diamondcolor-r-slider .noUi-tooltip').fadeOut(2000);
		});
	}
	/*intensity Slider*/
	if( $('#intensity-slider').length ){
		var intensity_array = <?php echo json_encode($intensitys_attr); ?>;
		var intensitysliders = $("#intensity-slider")[0]; 
		var max_step = parseInt($(intensitysliders).attr('data-steps')); 
		var start = $('.diamond_intensity').attr("data-start");
		var stop = $('.diamond_intensity').attr("data-stop");
		csliders=noUiSlider.create(intensitysliders, {
			start: [start, stop],
			connect: true,		
			range: {
				'min': 1,
				'max': max_step
			},
			step: 1,
			behaviour: 'none',
			margin:1,		
			pips: {
				mode: 'steps',
				density: max_step,
				filter: function() {
					return 1;
				}
			},
		});
		intensitysliders.noUiSlider.on('update', function( values, handle ) {
		  var value = values[handle];    
		  $('#intensity-r-slider .noUi-pips .noUi-value').each(function(key, value) {
				$(this).html(intensity_array[key].intensityName);
				$(this).attr('data-intensity-id', intensity_array[key].intensityId);
				$(this).attr('title', intensity_array[key].intensityName);
				$(this).attr('data-placement', 'bottom');
		  });	  
		});
		intensitysliders.noUiSlider.on('change', function( values, handle ) {
			var minValue = Number(values[0])-1;
			var maxValue = Number(values[1])-2;
			var intensity_ids = [];
			$('#intensity-r-slider .noUi-pips .noUi-value').each(function(key, value) {	
				if(key >= minValue  && key <= maxValue ){
					if($(this).attr('data-cut-id') != "000")
						intensity_ids.push($(this).attr('data-intensity-id'));
				}
			});
			$('.diamond_intensity').val(intensity_ids);
			$('.diamond_intensity').attr("data-start",Number(values[0]));
			$('.diamond_intensity').attr("data-stop",Number(values[1]));
			$("#search-diamonds-form #submit").trigger("click");
		});
		intensitysliders.noUiSlider.on('start', function( values, handle ) {
			$('#intensity-r-slider .noUi-tooltip').css('opacity','1');
			$('#intensity-r-slider .noUi-tooltip').css('display','block');
		});
		intensitysliders.noUiSlider.on('end', function( values, handle ) {
			$('#intensity-r-slider .noUi-tooltip').fadeOut(2000);
		});
	}
	
	/*fluorescence Slider*/
	if( $('#fluorescence-slider').length ){
		var fluorescence_array = <?php echo json_encode($fluorescences_attr); ?>;
		//console.log(fluorescence_array[0]['fluorescenceName']);
		if (fluorescence_array[0]) {
			fluorescence_array[0]['fluorescenceName']='None'
		}
		if (fluorescence_array[1]) {
			fluorescence_array[1]['fluorescenceName']='Faint'
		}
		if (fluorescence_array[2]) {
			fluorescence_array[2]['fluorescenceName']='Medium'
		}
		if (fluorescence_array[3]) {
			fluorescence_array[3]['fluorescenceName']='Strong'
		}
		if (fluorescence_array[4]) {
			fluorescence_array[4]['fluorescenceName']='Very Strong'
		}

		var fluorescencesliders = $("#fluorescence-slider")[0]; 
		var max_step = parseInt($(fluorescencesliders).attr('data-steps')); 
		var start = $('.diamond_fluorescence').attr("data-start");
		var stop = $('.diamond_fluorescence').attr("data-stop");
		csliders=noUiSlider.create(fluorescencesliders, {
			start: [start, stop],
			connect: true,		
			range: {
				'min': 1,
				'max': max_step
			},
			step: 1,
			behaviour: 'none',
			margin:1,		
			pips: {
				mode: 'steps',
				density: max_step,
				filter: function() {
					return 1;
				}
			},
		});
		fluorescencesliders.noUiSlider.on('update', function( values, handle ) {
		  var value = values[handle];   
		  //console.log(value.fluorescenceId);
		  $('#fluorescence-r-slider .noUi-pips .noUi-value').each(function(key, value) {
				$(this).html(fluorescence_array[key].fluorescenceName);
				$(this).attr('data-fluorescence-id', fluorescence_array[key].fluorescenceId);
				$(this).attr('title', fluorescence_array[key].fluorescenceName);
				$(this).attr('data-placement', 'bottom');

				//console.log(fluorescence_array[key].fluorescenceId);
		  });

		});
		fluorescencesliders.noUiSlider.on('change', function( values, handle ) {
			var minValue = Number(values[0])-1;
			var maxValue = Number(values[1])-2;
			var fluorescence_ids = [];
			$('#fluorescence-r-slider .noUi-pips .noUi-value').each(function(key, value) {	
				if(key >= minValue  && key <= maxValue ){
					if($(this).attr('data-fluorescence-id') != "000")
						fluorescence_ids.push($(this).attr('data-fluorescence-id'));
				}
			});
			$('.diamond_fluorescence').val(fluorescence_ids);
			$('.diamond_fluorescence').attr("data-start",Number(values[0]));
			$('.diamond_fluorescence').attr("data-stop",Number(values[1]));
			$("#search-diamonds-form #submit").trigger("click");
		});
		fluorescencesliders.noUiSlider.on('start', function( values, handle ) {
			$('#fluorescence-r-slider .noUi-tooltip').css('opacity','1');
			$('#fluorescence-r-slider .noUi-tooltip').css('display','block');
		});
		fluorescencesliders.noUiSlider.on('end', function( values, handle ) {
			$('#fluorescence-r-slider .noUi-tooltip').fadeOut(2000);
		});
	}
	$('#cut-r-slider .noUi-pips.noUi-pips-horizontal').insertAfter('#cut-r-slider .noUi-base .noUi-connect');
	$('#color-r-slider .noUi-pips.noUi-pips-horizontal').insertAfter('#color-r-slider .noUi-base .noUi-connect');
	$('#clarity-r-slider .noUi-pips.noUi-pips-horizontal').insertAfter('#clarity-r-slider .noUi-base .noUi-connect');
	$('#polish-r-slider .noUi-pips.noUi-pips-horizontal').insertAfter('#polish-r-slider .noUi-base .noUi-connect');
	$('#fluorescence-r-slider .noUi-pips.noUi-pips-horizontal').insertAfter('#fluorescence-r-slider .noUi-base .noUi-connect');
	$('#symmetry-r-slider .noUi-pips.noUi-pips-horizontal').insertAfter('#symmetry-r-slider .noUi-base .noUi-connect');
	$('#diamondcolor-r-slider .noUi-pips.noUi-pips-horizontal').insertAfter('#diamondcolor-r-slider .noUi-base .noUi-connect');
	$('#intensity-r-slider .noUi-pips.noUi-pips-horizontal').insertAfter('#intensity-r-slider .noUi-base .noUi-connect');
	
	$(".cut-slider .noUi-value").each(function( index ) {
		var range_left = $( this )[0].style.left;
		range_left = range_left.replace('%','');
		$(this).attr("data-range-left",range_left);
		$(this).addClass("range"+index);
	});
	$(".cut-slider .noUi-value").each(function( index ) {
		var range1 = $(".cut-slider .range"+index).attr("data-range-left");
		var range2 = $(".cut-slider .range"+(index+1)).attr("data-range-left");
		var range = range2 - range1;
		var left_range = range/2;
		console.log(".cut-slider .range"+index);
		console.log(".cut-slider .range"+(index+1));
		console.log(Math.ceil(left_range)+"%");
		//$(this).css("left",Math.ceil(left_range)+"%");
	});
	$('.noUi-value.noUi-value-horizontal.noUi-value-large').on('click', function () {
	    $(this).tooltip('show');
	});
});

</script>