
var tilesToLoad = 0;
var tilesLoaded = 0;

function getTile(target, col, row) {

	$.getJSON('./js/functions.php?action=getTileID&col=' + col + '&row=' + row, function(data) {
		console.log(data.id);
		if (data.id != -1)
		{
			$('<img class="tile_img not-empty" src="./js/functions.php?action=getTileImg&id=' + data.id + '" />').load(function(){
				$(this).width(50).height(50).appendTo(target).dblclick(imgClick);
			});
		}
		else
		{
			$('<img class="tile_img empty" src="./js/functions.php?action=getEmptyTile" />').load(function(){
				$(this).width(50).height(50).appendTo(target);
			});
		}
		tilesLoaded++;
	});

}

function drawMap() {
	var map = jQuery.infinitedrag("#wall", {}, {
		width:52,
		height:52,
		start_col: 0,
		start_row: 0,
		oncreate: function($element, col, row) {
			getTile($element, col, row);
			
		},
		onstart: function(count) {
			// something?
			console.log('starting');
			// This should ideally trigger some kind of loading progress bar thing which uses map.currentLoaded/count to see how many it needs to load...
			tilesToLoad = count;
		},
		onfinish: function() {
			// something else?
			console.log('finished');
			// finished loading - this does not indicate that all the IMAGES are finished loading... we'll need to check that another way...
		}
	});
	console.log('done loading');
	map.center(0,0);
	map.draggable(true);
	
}

$(document).ready(function() {
	drawMap();

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