<?php
	$key="5c54eb4e9dca0f260ab78ed280888c12";
	$username="21ea419de71b43ad";
	$userId = "12590977@N02";

	$BASE_URL = "https://query.yahooapis.com/v1/public/yql";

	// Ecriture de la requete
	//$yql_query = 'select * from flickr.people.publicphotos where user_id="12590977@N02" and api_key="5c54eb4e9dca0f260ab78ed280888c12"';
	// voir : https://www.flickr.com/services/api/flickr.photos.search.html
	//   $yql_query = 'select * from flickr.photos.search where text="paris" and api_key="' . $key .'"';//LatLng(48.8566667, 2.3509871)
    $yql_query = 'select * from flickr.photos.search where lat=48.8566667 and lon=2.3509871 and radius=20 and api_key="' . $key .'"';//LatLng(48.8566667, 2.3509871)
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

?>
