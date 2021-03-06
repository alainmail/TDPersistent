<?php

// Récupération des variables dans l'url
	if (isset($_GET['ville']))
	{
		$nbImages = $_GET["nbImages"];
		$idPhoto = $_GET["idPhoto"];
		$ville = $_GET["ville"];
		$lgt = $_GET["lgt"];
		$lat = $_GET["lat"];
		
		//Url image
		$idFarm = "'" . $_GET["idFarm"] . "'";
		$idServer = "'" . $_GET["idServer"] . "'";
		$id = "'" . $_GET["id"] . "'";
		$idSecret = "'" . $_GET["idSecret"] . "'";
	} 
	else
	{	
		$nbImages = 1;
		$ville = "lyon";
		$lat = 45.183;
		$lgt = 5.717;	
		$idFarm = 0;
		$idServer = 0;
		$id = 0;
		$idSecret = 0;
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
	  
	  #image {
		position: absolute;
	    top:90px; 
		left:87px
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
    <title>Visit the most amazing places around</title>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <script>
		function initialize() {
			// Récupération des variables php récupérée depuis l'url
			var lat= <?php echo $lat; ?>;
			var lgt= <?php echo $lgt; ?>;
			//var ville= <?php echo $ville; ?>;
			var nbImages= <?php echo $nbImages; ?>;

			var mapOptions = {
				scaleControl: true,
				center: new google.maps.LatLng(lat, lgt),
				zoom: 13,
				mapTypeId: google.maps.MapTypeId.SATELLITE
			};
		  
			var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

			// MARKER
			var infoNb = nbImages + " images sont";
			if(parseInt(nbImages)==1) infoNb = nbImages + " image est";
			else if(parseInt(nbImages)==0) infoNb = "Aucune image n'est";
			infoNb += " en ligne sur Flickr pour ce lieu."
			
			var marker = new google.maps.Marker({
				map: map,
				position: map.getCenter(),
				icon: showChart(nbImages),
				title: infoNb
			});
			
			// SEARCH BOX
			// Ajout de la boite de recherche
			var input = /** @type {HTMLInputElement} */(
				document.getElementById('pac-input'));
			map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

			var searchBox = new google.maps.places.SearchBox(
				/** @type {HTMLInputElement} */(input)
			);

			// Affichage de l'image
			afficheImage();
			
			// Traitement de la saisie d'une ville dans la boite de recherche
			google.maps.event.addListener(searchBox, 'places_changed', function() {
				var places = searchBox.getPlaces();
				window.location  = "showImagesNb.php?ville=" + places[0].name + "&lat=" + places[0].geometry.location.lat() + "&lgt=" + places[0].geometry.location.lng();
			});
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
			};
			return chart;
		}
		
		function afficheImage()
		{
			if(id != ""){
				var idFarm= <?php echo $idFarm; ?>;
				var idServer= <?php echo $idServer; ?>;
				var id= <?php echo $id; ?>;
				var idSecret= <?php echo $idSecret; ?>;
			
				//dynamically add an image and set its attribute
				var img = document.createElement("img");
				img.src="https://farm" + idFarm + ".staticflickr.com/" + idServer + "/" + id + "_" + idSecret + ".jpg";
				img.id="picture"
				var foo = document.getElementById("image");
				foo.appendChild(img);
			}
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
	<div id="image">&nbsp;</div>
  </body>
</html>