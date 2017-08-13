

(function(window, List, google) {
	
	var gMapsPlugin = (function() {
		function gMapsPlugin(element, options) {
			this.gMap = new google.maps.Map(element, options);
			this.markers = List.create();
			if(options.cluster) {
				this.markerCluster = new MarkerClusterer(this.gMap,[], options.cluster.options);
			}
		};
		
		return gMapsPlugin;
	}());
	
	gMapsPlugin.prototype = {
		zoom: function(zoom_level) {
			if (zoom_level) {
				this.gMap.setZoom(zoom_level);
			} else {
				return this.gMap.getZoom();
			}
		},
		//_on: function(event, callback) {
		//	google.maps.event.addListener(this.gMap, event, callback);	
		//}
		_on: function(options) {
			var self = this;
			google.maps.event.addListener(options.obj, options.event, function(event) {
				options.callback.call(self, event, options.obj);
			});	
		},
		
		addMarker: function(options) {
			
			var marker,
				self = this;
			options.position = {
				lat: options.lat,
				lng: options.lng
			}
			
			marker = this._create_marker(options);
			this.markers.add(marker);
			
			if(options.cluster) {
				this.markerCluster.addMarker(marker);
			} 
			
			if(options.events) {
				this._attachEvents(marker, options.events);
			}

			if(options.content) {
				this._on({
					obj: marker,
					event: 'click',
					callback: function() {
							var infoWindow = new google.maps.InfoWindow({
							content: options.content
						});
						infoWindow.open(this.gMap, marker);
					}

				})
			}
			
			return marker;
		},

		_attachEvents: function(obj, events) {
			var self=this;
			events.forEach(function(event) {
				self._on({
					obj: obj,
					event: event.name,
					callback: event.callback
				});	
			});	
		},
		
		
		findBy: function(callback) {
				return this.markers.find(callback);
		},
		
		removeBy: function(callback) {
			var self = this;
			self.markers.find(callback, function(markers){
				
				markers.forEach(function(marker) {
					if (self.markerCluster) {
						self.markerCluster.removeMarker(marker);
					} else {
						marker.setMap(null);
					}
				});
			});
			
		},
		
		_create_marker: function(options) {

			options.map = this.gMap;

			return new google.maps.Marker(options);
		}
		
		
	};
	
	gMapsPlugin.createMap = function(element, options) {
		return new gMapsPlugin(element, options);
	};
	
	window.gMapsPlugin = gMapsPlugin;
	
}(window, List, google));



