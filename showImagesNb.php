<?php
		// Récupération des variables dans l'url
		$ville = $_GET["ville"];
		$lgt = $_GET["lgt"];
		$lat = $_GET["lat"];
		
		// Parametres de mon compte yahoo
		$key="5c54eb4e9dca0f260ab78ed280888c12";
		$username="21ea419de71b43ad";
		$userId = "12590977@N02";

		$BASE_URL = "https://query.yahooapis.com/v1/public/yql";
		
		// Ecriture de la requete
		//$yql_query = 'select * from flickr.photos.search where text="'.$ville.'" and radius=200 and api_key="' . $key .'"';
		$yql_query = 'select * from flickr.photos.search where lat='.$lat.' and lon='.$lgt.' and api_key="' . $key .'"';
		$yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
		
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
		var_dump($json);
		$phpObj =  json_decode($json);
		
		// Exploitation des données
		$photos = $phpObj->query->results->photo;// Toutes les photos	
		$nbImages = count($photos);
		$idPhoto = $photos[0]->id; // Id de la première image
		
		//var_dump($photos); // var_dump() affiche les informations structurées d'une variable
		//var_dump($photos[0]);
		
		//echo "<br>".$photos[0]->farm;
		
		// Construction de l'url de l'image à afficher
		//$urlImage = "<img src='https://farm" . $photos[0]->farm . ".staticflickr.com/" . $photos[0]->server . "/" . $photos[0]->id . "_" . $photos[0]->secret . ".jpg'/>";
		//echo $urlImage;
		// Relance la page avec la nouvelle ville
	//	echo "<script language='JavaScript'>window.open('search.php?nbImages=".$nbImages."&idPhoto=".$idPhoto."&ville=".$ville."&idServer=".$photos[0]->server."&id=".$photos[0]->id."&idSecret=".$photos[0]->secret."&idFarm=".$photos[0]->farm."&lgt=".$lgt."&lat=".$lat."', '_self');</script>";

?>