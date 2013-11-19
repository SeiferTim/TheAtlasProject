function getTile(target, col, row) {
	$.getJSON('./js/functions.php?action=getTileID&col=' + col + '&row=' + row, function(data) {
		if (data.id != -1)
		{
			$('<img class="tile_img"/>').attr('src','./js/functions.php?action=getTileImg&id=' + data.id).load(function(){
				$(this).attr('class', 'tile_img not-empty').width(50).height(50).dblclick(imgClick).appendTo(target);
			});
		}
		else
		{
			$('<img class="tile_img"/>').attr('src','./js/functions.php?action=getEmptyTile').load(function(){
				$(this).attr('class', 'tile_img empty').width(50).height(50).appendTo(target);
			});
		}
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

		}
	});
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