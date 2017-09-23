<?php

	$user = filter($_GET["user"]);
    $pass = filter($_GET["pass"]);
	$pass = password_hash($pass, PASSWORD_DEFAULT);

    $query = $app["pdo"]->prepare("INSERT INTO Users (Username, Password, Access) VALUES(:user,:pass,0);");
    $query->execute(array(":user" => $user, ":pass" => $pass));

     $query = $app["pdo"]->prepare("SELECT ID FROM Users WHERE Username = :user AND Password = :pass;");
    $query->execute(array(":user" => $user, ":pass" => $pass));

    $names = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $names[] = $row;
    }

    if($names[0]["id"] != "")
      return "true";
    else
      return "false";

?>