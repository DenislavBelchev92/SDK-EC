$(document).ready(function(){

	(function(window, gMapsPlugin, $) {

	
	var $mapster = $('#callout-map-location').MapsPlugin(gMapsPlugin.MAP_OPTIONS);
	
	$mapster.MapsPlugin('addMarker', {
		lat: 42.13120971,
		lng: 24.75013042,
		content: "sth"
	})
	
	}(window, window.gMapsPlugin || (window.gMapsPlugin = {}), jQuery));

	
	
});