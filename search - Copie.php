<?php

// Récupération des variables dans l'url
	if (isset($_GET['ville']))
	{
		$nbImages = $_GET["nbImages"];
		$idPhoto = $_GET["idPhoto"];
		$ville = $_GET["ville"];
		$lgt = $_GET["lgt"];
		$lat = $_GET["lat"];
	} 
	else
	{	
		$ville = "lyon";
		$lat = 45.183;
		$lgt = 5.717;	
	}
	
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      .controls {
        margin-top: 16px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        padding: 0 11px 0 13px;
        width: 400px;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        text-overflow: ellipsis;
      }

      #pac-input:focus {
        border-color: #4d90fe;
        margin-left: -1px;
        padding-left: 14px;  /* Regular padding-left + 1. */
        width: 401px;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
}

    </style>
    <title>See all around</title>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <script>
	// This example adds a search box to a map, using the Google Place Autocomplete
	// feature. People can enter geographical searches. The search box will return a
	// pick list containing a mix of places and predicted search terms.

		function initialize() {

		  var markers = [];
		  var map = new google.maps.Map(document.getElementById('map-canvas'), {
			mapTypeId: google.maps.MapTypeId.SATELLITE
		  });

			// Récupération des variables php récupérée depuis l'url
			var lgt= <?php echo $lgt; ?>;
			var lat= <?php echo $lat; ?>;
		  
			//Positionnement de la carte sur les coordonnées voulues
			var defaultBounds = new google.maps.LatLngBounds(
				new google.maps.LatLng(lat,lgt),
				new google.maps.LatLng(lat,lgt)
			);
			map.fitBounds(defaultBounds);


			// Ajout de la boite de recherche
			var input = /** @type {HTMLInputElement} */(
				document.getElementById('pac-input'));
			map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

			var searchBox = new google.maps.places.SearchBox(
				/** @type {HTMLInputElement} */(input)
			);

			
			google.maps.event.addListener(searchBox, 'places_changed', function() {
				var places = searchBox.getPlaces();
				window.location  = "showImagesNb.php?ville=" + places[0].name + "&lat=" + places[0].geometry.location.lat() + "&lgt=" + places[0].geometry.location.lng();
		
				if (places.length == 0) {
					return;
				}
				for (var i = 0, marker; marker = markers[i]; i++) {
				  marker.setMap(null);
				}

				// Placement des markers
				markers = [];
				var bounds = new google.maps.LatLngBounds();
				for (var i = 0, place; place = places[i]; i++) {
				  var image = {
					url: place.icon,
					size: new google.maps.Size(71, 71),
					origin: new google.maps.Point(0, 0),
					anchor: new google.maps.Point(17, 34),
					scaledSize: new google.maps.Size(25, 25)
				  };

					var nbImages = 5 + 2*i;
					chart = showChart(nbImages);
					
				  // Create a marker for each place.
				  var marker = new google.maps.Marker({
					map: map,
					icon: chart,
					title: place.name,
					position: place.geometry.location
				  });

				  markers.push(marker);

				  bounds.extend(place.geometry.location);
				}

				map.fitBounds(bounds);
			});
		}

		function placeMarker(lat,lgt,ville,map){
			var markers = [];
			var location = new google.maps.LatLng(lat,lgt);
			var bounds = new google.maps.LatLngBounds();
			var marker = new google.maps.Marker({
				map: map,
				icon: showChart(nbImages),
				title: ville,
				position: location
			});
			markers.push(marker);
			bounds.extend(location);
			map.fitBounds(bounds);		
		}
		
		// Affichage du nombre d'images
		function showChart(nbImages){
			var hChape = 10 * nbImages;
			var chart = {
				path: 'M 0 0 L 20 0 L 20 '+ hChape +' L 0 '+ hChape +' z',
				fillColor: 'yellow',
				fillOpacity: 0.8,
				scale: 1,
				strokeColor: 'gold',
				strokeWeight: 5,			
				/*size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(25, 25)*/
			};
			return chart;
		}
			
		google.maps.event.addDomListener(window, 'load', initialize);
		
		
    </script>
    <style>
      #target {
        width: 345px;
      }
    </style>
  </head>
  <body>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="map-canvas"></div>
	
  </body>
</html>