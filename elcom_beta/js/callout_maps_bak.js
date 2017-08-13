$(document).ready(function(){

	(function(window, gMapsPlugin, $) {
	var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
	
	//map options
	var options = gMapsPlugin.MAP_OPTIONS;
	
	element = document.getElementById('callout-map-location');
	//map
	map = gMapsPlugin.createMap(element, options);
//	map.zoom(12);
//	alert(map.zoom());

	
	map._on({
		obj: this,
		name: 'click',
		callback: function() {
			alert('click');
			console.log(event);
			console.log(this);
		} 
	});

	var marker2 = map.addMarker({
		id: 2,
		lat: 37.751350,
		lng: -122.475883,
		draggable: true,
		events: [{
			name: 'click',
			callback: function(e, marker) { 
				console.log(marker);
				console.log(e);
    			}
		},{
			name: 'dragend',
			callback: function(){ 
				alert('dragend');
    			}
		}],
		content: '<div style="color: #F00">nekvo info 2</div>',
		icon: iconBase + 'parks.png',
		cluster: {
			zoom:1
		}
	});
	
	//map._removeMarker(marker2);
	//var isFound = map.findMarkerByLat(37.751350);
	//console.log(map.markers);
	//console.log(isFound);
	
	
	var found = map.findBy(function(marker) {
		return marker.id === 2;
	});
	
	//console.log(found);
	
	for (var i = 0; i < 80; i++) {
		map.addMarker({
			id: 2,
			lat: 37.781350 + Math.random(),
			lng: -122.485883 + Math.random(),
			cluster: {

			}
		});
		
		map.addMarker({
			id: 1,
			lat: 37.781350 + Math.random(),
			lng: -122.485883 + Math.random(),
			cluster: {

			}
		});
	}
	
	//map.removeBy(function(marker) {
	//	return marker.id===2;
	//});
	
	$('#callout-map-location').MapsPlugin();
	
	
	}(window, window.gMapsPlugin || (window.gMapsPlugin = {}), jQuery));

	
	
});