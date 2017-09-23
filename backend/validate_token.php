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
    //return "  | " . $token . " | " . $names[0]["token"];
    if($names[0]["token"] == $token && $token != "NULL" && $token != ""){
	  return json_encode(true);
	}else{
      return json_encode(false);
	}
?>