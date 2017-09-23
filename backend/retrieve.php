<?php

	header("Access-Control-Allow-Origin:*");
	header("Access-Control-Allow-Methods:GET");
	header("Access-Control-Allow-Headers:Content-Type");
	header("Access-Control-Allow-Credentials:true");

	$user = filter($_GET['user']);
	$token = filter($_GET['token']);

    $query = $app["pdo"]->prepare("SELECT Token FROM Users WHERE Username = :user;");
    $query->execute(array(":user" => $user));

    $names = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $names[] = $row;
    }

    if( !($names[0]["token"] == $token && $token != "NULL" && $token != "") ){
	  return "false";
    }
	

  	$retrieveType = filter($_GET["retrievetype"]);
  	if($retrieveType == "basic"){

  		$query = $app["pdo"]->prepare("SELECT * FROM analytics ORDER BY gametime DESC");
	    $query->execute();

	    $names = array();
	    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
	      $names[] = $row;
	    }

	    $text = "";
	    for($i = 0; $i < count($names); $i++){
	    	$text = $text . '"'.$names[$i]["ip"] . '", "'.$names[$i]["location"].'", "'.$names[$i]["gametime"].'", "'.$names[$i]["date"].'", "'.$names[$i]["plays"].'"';
	    	if($i != count($names)-1) $text = $text . ",";
	    }
	    return $text;

  	}else if ($retrieveType == "hardware"){
  		$query = $app["pdo"]->prepare("SELECT ip, Specs FROM Analytics ORDER BY gametime DESC");
	    $query->execute();

	    $names = array();
	    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
	      $names[] = $row;
	    }

	    $text = "";
	    for($i = 0; $i < count($names); $i++){
	    	$text = $text . '"'.$names[$i]["ip"] . '", "'.$names[$i]["specs"].'"';
	    	if($i != count($names)-1) $text = $text . ",";
	    }
	    return $text;
  	}
  	else if ($retrieveType == "bugs"){
  		$query = $app["pdo"]->prepare("SELECT * FROM BugReport");
	    $query->execute();

	    $names = array();
	    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
	      $names[] = $row;
	    }

	    $text = "";
	    for($i = 0; $i < count($names); $i++){
	    	$text = $text . '"'.$names[$i]["ip"] . '", "'.$names[$i]["bug"]. '", "'.$names[$i]["version"] . '", "'.$names[$i]["date"] . '"';
	    	if($i != count($names)-1) $text = $text . ",";
	    }
	    return $text;
  	}
  	else if ($retrieveType == "crashes"){
  		$query = $app["pdo"]->prepare("SELECT * FROM CrashReport");
	    $query->execute();

	    $names = array();
	    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
	      $names[] = $row;
	    }

	    $text = "";
	    for($i = 0; $i < count($names); $i++){
	    	$text = $text . '"'.$names[$i]["ip"] . '", "' . ip_info($names[$i]["ip"], "Country") . '", "'.$names[$i]["log"]. '", "'.$names[$i]["version"] . '", "'.$names[$i]["date"] . '"';
	    	if($i != count($names)-1) $text = $text . ",";
	    }
	    return $text;
  	}
  	return "";	

?>