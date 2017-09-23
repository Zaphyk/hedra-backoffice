<?php	  
 	
	header("Access-Control-Allow-Origin:*");
	header("Access-Control-Allow-Methods:GET");
	header("Access-Control-Allow-Headers:Content-Type");
	header("Access-Control-Allow-Credentials:true");
 
    $user = filter($_GET["user"]);
    $pass = filter($_GET["password"]);

	$query = $app["pdo"]->prepare("SELECT Password FROM Users WHERE Username = :user;");
    $query->execute(array(":user" => $user));

    $names = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $names[] = $row;
    }
    $passwordhash = $names[0]['password'];

	if( password_verify($pass, $passwordhash) === true){
	  $token = bin2hex(openssl_random_pseudo_bytes(16));
	  $query = $app["pdo"]->prepare("UPDATE Users SET Token = :token WHERE Username = :user AND Password = :pass;");
	  $query->execute(array(":user" => $user, ":pass" => $passwordhash, ":token" => $token));
	
	  setcookie("token", $token, time() + (86400 * 30) * 60, "/");
	  setcookie("user", $user, time() + (86400 * 30) * 60, "/");
	  
	  header('Content-type: application/json');
	  return json_encode( array('token' => $token, 'user' => $user) );
	}else{
	  return json_encode("false");
	}
	
?>