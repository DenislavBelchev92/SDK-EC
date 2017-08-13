(function(window, google, gMapsPlugin) {
	
	gMapsPlugin.MAP_OPTIONS = {
		center: {
			lat: 42.13120971,
			lng: 24.75013042
		},
		zoom: 10,
		cluster: {
			options: {
				styles: [{
					url: 'images/m1.png',
					height: 50,
					width: 55,
				},{
					url: 'images/m2.png',
					height: 50,
					width: 55,
					textColor: '#F00',
					textSize: 18
				}]
			}
		}
	};
	
}(window, google, window.gMapsPlugin || (window.gMapsPlugin = {})));
