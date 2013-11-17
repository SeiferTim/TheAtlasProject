function fileExists(filename)
{
	$.ajax({
		url: filename,
		type: 'HEAD',
		dataType: 'jsonp',
		timeout:5000,
		error: function(error){
			exists = false;
		},
		success: function(){
			exists = true;
		},
		complete: function() {
			if (exists === 1) {
				return true;
			} else {
				return false;
			}
		}
	});
}


function loadImage(path, width, height, target, img_class) {
	var img = $('<img class="' + img_class + '" src="' + path + '"/>').load(function(){
		$(this).width(width).height(height).appendTo(target).click(imgClick);
	});
}

$(document).ready(function() {
	var map = jQuery.infinitedrag("#wall", {}, {
		width:52,
		height:52,
		start_col: 0,
		start_row: 0,
		oncreate: function($element,col,row) {
			var tile_name = "/tiles/tile_" + col + "_" + row + ".png";
			//if (fileExists(tile_name))
				loadImage(tile_name, 50,50,$element, 'tile_img not_empty');
			//else	
			//	loadImage('/tiles/tile_empty.png', 50,50,$element, 'tile_img empty');

		}
	});
	map.center(0,0);
	map.draggable(true);

	$('#close_view').click(function(){
		$('#tile_view').fadeOut(200,'swing');
	});
	

});

function imgClick(eventObject) {
	var src = $(this).attr('src');
	$('#tile_view').fadeIn(200,'swing');
	$('#large_tile').attr('src', src).load(function() {
		$(this).width(600).height(600);
		
	});
}