/**
 *
 * HTML5 Color Picker
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Script Tutorials
 * http://www.script-tutorials.com/
 */

$(function(){
    var bCanPreview = true; // can preview

    // create canvas and context objects
    var canvas = document.getElementById('picker_1');
    var ctx = canvas.getContext('2d');
	var canvas2 = document.getElementById('picker_2');
    var ctx2 = canvas2.getContext('2d');
    // drawing active image
    var image = new Image();
    image.onload = function () {
        ctx.drawImage(image, 0, 0, image.width, image.height); // draw the image on the canvas
		ctx2.drawImage(image, 0, 0, image.width, image.height); // draw the image on the canvas
    }

    // select desired colorwheel
    var imageSrc = actionPath+'WebResources/Images/buttons/colorwheel1.png';
    image.src = imageSrc;

    $('#picker_1, #picker_2').mousemove(function(e) { // mouse move handler
        if (bCanPreview) {
            // get coordinates of current position
			cp_id	= $('#hid_colorpicker').val();
			
			var def_canvas = (cp_id == 1)? canvas : canvas2;
            var canvasOffset = $(def_canvas).offset();
            var canvasX = Math.floor(e.pageX - canvasOffset.left);
            var canvasY = Math.floor(e.pageY - canvasOffset.top);

            // get current pixel
            var imageData = ctx.getImageData(canvasX, canvasY, 1, 1);
            var pixel = imageData.data;

            // update preview color
            var pixelColor = "rgb("+pixel[0]+", "+pixel[1]+", "+pixel[2]+")";
            
			$('#temp_preview_colorpicker_'+cp_id).css('backgroundColor', pixelColor);
            // update controls
            $('#rVal_'+cp_id).val(pixel[0]);
            $('#gVal_'+cp_id).val(pixel[1]);
            $('#bVal_'+cp_id).val(pixel[2]);
            //$('#rgbVal').val(pixel[0]+','+pixel[1]+','+pixel[2]);

            var dColor = pixel[2] + 256 * pixel[1] + 65536 * pixel[0];
			var hex = '#' + ('0000' + dColor.toString(16)).substr(-6);
			if(hex == '#00000')
				hex = '#000000';
            $('#hexVal_'+cp_id).val(hex);
			if(cp_id == 1) {
				var iframe_color1 = $("#cardPreview").contents().find('.menu');
				iframe_color1.css({"background-color":hex});	
			}
			else {
				var iframe_color2 = $("#cardPreview").contents().find('.header');
				var iframe_color3 = $("#cardPreview").contents().find('.viewport');
				iframe_color2.css({"background-color":hex});
				iframe_color3.css({"background-color":hex});
				
			}
        }
    });
    $('#picker_1, #picker_2').click(function(e) { // click event handler
        bCanPreview = !bCanPreview;
    }); 
    $('.preview').click(function(e) { // preview click
		
		cp_id	= $('#hid_colorpicker').val();
		$('#temp_preview_colorpicker_'+cp_id).css({"background-color":$('#cardColour_'+cp_id).val()});
		$('#rVal_'+cp_id).val(hexToRgb($('#cardColour_'+cp_id).val()).r);
		$('#gVal_'+cp_id).val(hexToRgb($('#cardColour_'+cp_id).val()).g);
		$('#bVal_'+cp_id).val(hexToRgb($('#cardColour_'+cp_id).val()).b);
		$('#hexVal_'+cp_id).val($('#cardColour_'+cp_id).val());
        $('.colorpicker_'+cp_id).fadeToggle("slow", "linear");
        bCanPreview = true;
    });	
	$('.cancel_colorpicker').click(function(e) {
		var iframe_color1 = $("#cardPreview").contents().find('.menu');
		iframe_color1.css({"background-color":$('#cardColour').val()});
		
		cp_id	= $('#hid_colorpicker').val();
		$('#temp_preview_colorpicker_'+cp_id).css({"background-color":$('#cardColour_'+cp_id).val()});
		$('#rVal_'+cp_id).val(hexToRgb($('#cardColour_'+cp_id).val()).r);
		$('#gVal_'+cp_id).val(hexToRgb($('#cardColour_'+cp_id).val()).g);
		$('#bVal_'+cp_id).val(hexToRgb($('#cardColour_'+cp_id).val()).b);
		$('.colorpicker_'+cp_id).fadeToggle("slow", "linear");
	});
	
	$('.save_colorpicker').click(function(e) {		
		cp_id	= $('#hid_colorpicker').val();
		$('#cardColour_'+cp_id).val($('#hexVal_'+cp_id).val().toUpperCase());
		$('.preview_'+cp_id).css('backgroundColor', $('#temp_preview_colorpicker_'+cp_id).css('backgroundColor'));
		$('.colorpicker_'+cp_id).fadeToggle("slow", "linear");
	});
});

function setColorPicker(value)
{
	$('.colorpicker').hide();
	$('#hid_colorpicker').val(value);
}