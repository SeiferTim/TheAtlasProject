function loadImage(path, width, height, target, img_class) {
    loaded = false;
    $('<img class="' + img_class + '" src="'+ path +'">').load(path, function(response, status, xhr) {
	    //console.log(response);
	    if (status != 'error') {
    	    $(this).width(width).height(height).appendTo(target);
	     	loaded = true;	
	    }
    });
    return loaded;
}

$(document).ready(function() {
	var map = jQuery.infinitedrag("#wall", {}, {
		width:52,
		height:52,
		start_col: 0,
		start_row: 0,
		oncreate: function($element,col,row) {
			var tile_name = "/tiles/tile_" + col + "_" + row + ".png";
			if(!loadImage(tile_name, 50,50,$element, 'tile_img not_empty')) {
				loadImage('/tiles/tile_empty.png',50,50,$element,'tile_img empty');
			}	
		}
	});
	map.center(0,0);
	map.draggable(true);

});