<?php

	$user = filter($_GET["user"]);

    $query = $app["pdo"]->prepare("SELECT Access FROM Users WHERE Username = :user;");
    $query->execute(array(":user" => $user));

    $names = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $names[] = $row;
    }

    if($names[0]["access"] != "")
      return ( $names[0]["access"] == "1" ) ? "true" : "false";
    else
      return "";


?>