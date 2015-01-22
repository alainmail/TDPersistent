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
    <title>Places search box ttt</title>
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

	  var defaultBounds = new google.maps.LatLngBounds(
		  new google.maps.LatLng(45.183, 5.717),
		  new google.maps.LatLng(45.283, 5.817));
	  map.fitBounds(defaultBounds);


	  // Create the search box and link it to the UI element.
	  var input = /** @type {HTMLInputElement} */(
		  document.getElementById('pac-input'));
	  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	  var searchBox = new google.maps.places.SearchBox(
		/** @type {HTMLInputElement} */(input));

	  // [START region_getplaces]
	  // Listen for the event fired when the user selects an item from the
	  // pick list. Retrieve the matching places for that item.
	  google.maps.event.addListener(searchBox, 'places_changed', function() {
		var places = searchBox.getPlaces();

		if (places.length == 0) {
			return;
		}
		for (var i = 0, marker; marker = markers[i]; i++) {
		  marker.setMap(null);
		}

		// For each place, get the icon, place name, and location.
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
	  // [END region_getplaces]

	  // Bias the SearchBox results towards places that are within the bounds of the
	  // current map's viewport.
	  google.maps.event.addListener(map, 'bounds_changed', function() {
		var bounds = map.getBounds();
		searchBox.setBounds(bounds);
	  });
	}
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
		
		
		// Pour passer une variable (la ville) au script php
		var pt = "Grenoble";
		document.write('<?php $ville;?>');
		document.write('<?php addVariable("'+pt+'");?>');
		
		
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
	
	<?php
	function addVariable($valeur)
	{
		$ville = $valeur;
		echo $ville;	
	}  
	
	showImagesNb();
	function showImagesNb(){	
		$key="5c54eb4e9dca0f260ab78ed280888c12";
		$username="21ea419de71b43ad";
		$userId = "12590977@N02";

		$BASE_URL = "https://query.yahooapis.com/v1/public/yql";

		// Ecriture de la requete
		//$yql_query = 'select * from flickr.people.publicphotos where user_id="12590977@N02" and api_key="5c54eb4e9dca0f260ab78ed280888c12"';
		// voir : https://www.flickr.com/services/api/flickr.photos.search.html
		//   $yql_query = 'select * from flickr.photos.search where text="paris" and api_key="' . $key .'"';//LatLng(48.8566667, 2.3509871)
	   // $yql_query = 'select * from flickr.photos.search where lat=48.8566667 and lon=2.3509871 and radius=20 and api_key="' . $key .'"';//LatLng(48.8566667, 2.3509871)
		$yql_query = 'select * from flickr.photos.search where text="paris" and radius=20 and api_key="' . $key .'"';//LatLng(48.8566667, 2.3509871)
		$yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";

		echo $yql_query_url . "<br>";
		
		// Make call with cURL
		$session = curl_init();
		curl_setopt($session, CURLOPT_URL, $yql_query_url);
		// Pour fonctionner chez Persistent
		//curl_setopt($session, CURLOPT_PROXY, 'frproxy.persistent.co.in');
		curl_setopt($session, CURLOPT_PROXYPORT, 8080);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($session, CURLOPT_VERBOSE, TRUE);
		curl_setopt($session, CURLOPT_PROXYTYPE, 'HTTP');
		//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($session, CURLOPT_RETURNTRANSFER,true);

		// Convert JSON to PHP object
		$json = curl_exec($session);
		$phpObj =  json_decode($json);
		
		// Exploitation des données
		$photos = $phpObj->query->results->photo;// Toutes les photos

		var_dump($photos); // var_dump() affiche les informations structurées d'une variable
		echo "<br>";
		var_dump($photos[0]); 
		echo "<br>".$photos[0]->title;
		echo "<br>".count($photos);
	}

?>
  </body>
</html>