<?php
	require_once 'insert_utils.php';
	
	$gversion = filter($_GET["gversion"]);
	$ip = get_client_ip();
    $country = ip_info($ip, "Country");
    InsertIfNull($app, $gversion, $ip, $country, "NO_DATA", true);
    return "true";

?>