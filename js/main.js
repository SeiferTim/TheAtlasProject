var tilesToLoad = 0;
var tilesLoaded = 0;
var animClass = 'la-animate';

var drawing_canvas;

function loadedTile() {
	tilesLoaded++;
}

function getTile(target, col, row) {

	$.getJSON('./js/functions.php?action=getTileID&col=' + col + '&row=' + row, function(data) {
		if (data.id != -1)
		{
			$('<img class="tile_img not-empty" src="./js/functions.php?action=getTileImg&id=' + data.id + '" col="' + col + '" row="' + row + '"" tile_id="' + data.id + '" />').width(50).height(50).appendTo(target).dblclick(imgClick).load(function(){
				loadedTile();
				return false;
			});
		}
		else
		{
			$('<img class="tile_img empty" src="./js/functions.php?action=getEmptyTile" col="' + col + '" row="' + row + '" />').width(50).height(50).appendTo(target).dblclick(blankClick).load(function() {
				loadedTile();
				return false;
			});
		}
	});
	return false;

}

function drawMap() {

	var map = jQuery.infinitedrag("#wall", {}, {
		width:52,
		height:52,
		start_col: 0,
		start_row: 0,
		oncreate: function($element, col, row) {
			getTile($element, col, row);
			return false;
		},
		onstart: function(count) {
			// This should ideally trigger some kind of loading progress bar thing which uses map.currentLoaded/count to see how many it needs to load...
			tilesLoaded = 0;
			return false;
		},
		onfinish: function() {
			// finished loading - this does not indicate that all the IMAGES are finished loading... we'll need to check that another way...
			tilesToLoad = $('._tile').size();
			return false;
		}
	});

	map.center(0,0);
	map.draggable(true);
	return false;
}

window.onload = function() {
	drawMap();
	return false;
}

$(document).ready(function() {
	$('#close_view').click(function(){
		$('#tile_view').fadeOut(200,'swing');
		return false;
	});
	$('#close_draw').click(function(){
		$('#tile_draw').fadeOut(200,'swing');
		return false;
	});
	drawing_canvas = new $('#tile_draw_surface').dooScribPlugin({
		width:50,
		height:50,
		cssClass: 'drawSurface',
		penSize:1
	});
	$('#color').click(function(){
		drawing_canvas.lineColor($('#iColor').val());
	});
	var color = drawing_canvas.lineColor('#333');
	$('#iColor').val('#333')
$	('#clear').click(function(){
		drawing_canvas.clearSurface();
	});
	drawing_canvas.clearSurface();
	return false;
});

function blankClick(eventObject) {
	// placeholder for now...
	$('#tile_draw').fadeIn(200,'swing');
}

function imgClick(eventObject) {

	var src = $(this).attr('src');
	console.log($(this).attr('tile_id'));
	$.getJSON('./js/functions.php?action=getTileDetails&id=' + $(this).attr('tile_id'), function(data) {
		console.log(data);
		$('#createdon', '#tile_view').html(data.createdon);
		$('#rating', '#tile_view').html(data.rating);
		$('#level', '#tile_view').html(data.level);
		$.getJSON('./js/functions.php?action=getUserName&id=' + data.user_id, function(data) {
			console.log(data);
			$('#creator', '#tile_view').html(data.username);
			$('#tile_view').fadeIn(200,'swing');
			$('#large_tile').attr('src', src).width(600).height(600).load();
		});
	});
	return false;
}