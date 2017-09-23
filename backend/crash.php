<?php
	require_once 'insert_utils.php';

	$ex  = filter($_GET["ex"]);
  	$st  = (isset($_GET["version"])) ? filter($_GET["version"]) : "UNKNOWN";
  	$ip = get_client_ip();
  	$query = $app["pdo"]->prepare("INSERT INTO CrashReport (IP, Log, Version, Date) VALUES(:ip, :ex, :v, NOW()); ");
  	$query->execute(array(":ip" => $ip, ":ex" => $ex, ":v" => $v));

  	return "true";


?>