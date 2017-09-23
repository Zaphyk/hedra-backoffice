<?php

	$user = filter($_GET["user"]);

    $query = $app["pdo"]->prepare("UPDATE Users SET Access=1 WHERE Username = :user;");
    $query->execute(array(":user" => $user));

    $names = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $names[] = $row;
    }

    if($names[0]["id"] != "")
      return "true";
    else
      return "false";


?>