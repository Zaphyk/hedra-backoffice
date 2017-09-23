<?php
	require_once 'insert_utils.php';

	$time  = (isset($_GET["time"])) ? filter($_GET["time"]) : 1;
  	$ip = get_client_ip();
    $os = filter($_GET["specs"]);
  	
    InsertIfNull($app, "NO_DATA", $ip, ip_info($ip, "Country"), $os, false);

	$query = $app["pdo"]->prepare("UPDATE Analytics SET GameTime = GameTime + :ptime, Specs = :specs WHERE IP = :ip;");
  	$query->execute(array(":ip" => $ip, ":ptime" => (float) truncate($time), ":specs" => $os ));


  	return "true";

?>