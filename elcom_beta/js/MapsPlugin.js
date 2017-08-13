(function(window, gMapsPlugin){

	$.widget("DenisNameSpace.MapsPlugin", {
		options: {},
		
		_create: function(){
			var element = this.element[0];
				options = this.options;
				
			this.map = gMapsPlugin.createMap(element, options);
		},
		
		_refresh: function(){

		},
		
		addMarker: function( options){
			return this.map.addMarker(options);
		},
		
		findMarkers: function(callback) {
			return this.map.findBy(callback);
		},
		
		removeMarkers: function(callback) {
			this.map.removeBy(callback);
		},
		
		// Return all markers
		
		markers: function() {
			return this.map.markers.items;
		},
		
		destroy: function(){

		},

		_setOption: function(key, value){

		}
	});


})(window, gMapsPlugin);