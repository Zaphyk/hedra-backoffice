<?php

	$report = filter($_GET["report"]);
  	$version = filter($_GET["version"]);

  	$ip = get_client_ip();
  	$query = $app["pdo"]->prepare("INSERT INTO BugReport (IP, Bug, Version, Date) VALUES(:ip, :bug, :ver, NOW()); ");
  	$query->execute(array(":ip" => $ip, ":bug" => $report, ":ver" => $version));
  	
  	return "true";	

	
?>