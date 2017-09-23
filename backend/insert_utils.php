<?php

    function InsertIfNull($app, $gversion, $ip, $country, $specs, $update){
         $ipexists = false;

        $query = $app["pdo"]->prepare("SELECT ID FROM Analytics WHERE IP = :ip;");
        $query->execute(array(":ip" => $ip));

        $names = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
          $names[] = $row;
        }

        if($names[0]["id"] != ""){
          $app["monolog"]->addDebug("Row " . $names[0]["id"]);
          $ipexists = true;

        }else{
          $ipexists = false;
        }


        if($ipexists === false){
            if($os != ""){
                  $query2 = $app["pdo"]->prepare("INSERT INTO Analytics (IP, Plays, Location, GameVersion, GameTime, Specs, Date) VALUES(:ip, 1, :country, :gversion, 0, :specs, NOW());");
                  $query2->execute(array(":ip" => $ip, ":country"=>$country, ":gversion" => $gversion, ":specs" => $specs ));
            }else{
                $query2 = $app["pdo"]->prepare("INSERT INTO Analytics (IP, Plays, Location, GameVersion, GameTime, Date) VALUES(:ip, 1, :country, :gversion, 0, NOW());");
                $query2->execute(array(":ip" => $ip, ":country"=>$country, ":gversion" => $gversion));
            }
      	  return;
      	}

      	if($update === true){
        	$query3 = $app["pdo"]->prepare("UPDATE Analytics SET Plays = Plays + 1, GameVersion = :gversion  WHERE IP = :ip ");
            $query3->execute(array(":ip" => $ip, ":gversion" => $gversion ));
      	}

      return;
    }

    function truncate($number){
    	return number_format((float)$number, 3, '.', '');
    }


    function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER["HTTP_X_FORWARDED_FOR"], FILTER_VALIDATE_IP))
                    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                if (filter_var(@$_SERVER["HTTP_CLIENT_IP"], FILTER_VALIDATE_IP))
                    $ip = $_SERVER["HTTP_CLIENT_IP"];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }

    function get_client_ip() {
        $ipaddress = "";
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
            $ipaddress = $_SERVER["HTTP_CLIENT_IP"];
        else if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            $ipaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
        else if(isset($_SERVER["HTTP_X_FORWARDED"]))
            $ipaddress = $_SERVER["HTTP_X_FORWARDED"];
        else if(isset($_SERVER["HTTP_FORWARDED_FOR"]))
            $ipaddress = $_SERVER["HTTP_FORWARDED_FOR"];
        else if(isset($_SERVER["HTTP_FORWARDED"]))
            $ipaddress = $_SERVER["HTTP_FORWARDED"];
        else if(isset($_SERVER["REMOTE_ADDR"]))
            $ipaddress = $_SERVER["REMOTE_ADDR"];
        else
            $ipaddress = "UNKNOWN";
        return $ipaddress;
    }

?>