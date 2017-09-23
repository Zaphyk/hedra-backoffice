 <?php

require("../vendor/autoload.php");
include __DIR__ . '/filter.php';

$app = new Silex\Application();
$app["debug"] = true;

$dbopts = parse_url(getenv("DATABASE_URL"));
$app->register(new Herrera\Pdo\PdoServiceProvider(),
  array(
    "pdo.dsn" => "pgsql:dbname=".ltrim($dbopts["path"],"/").";host=".$dbopts["host"],
    "pdo.port" => $dbopts["port"],
    "pdo.username" => $dbopts["user"],
    "pdo.password" => $dbopts["pass"]
  )
);
$app["pdo"]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  "monolog.logfile" => "php://stderr",
));

// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
//    "twig.path" => __DIR__."/views",
));

// Our web handlers


$app->get("request", function() use($app) {

	try{
	    $type = filter($_GET["type"]);


		switch($type){

			case "status":
				return "0x1";

			default:
				if(file_exists(__DIR__ . '/' . $type.'.php'))
					return include __DIR__ . '/' . $type.'.php';
				else
					return include __DIR__ . '/404.php';
		}
		return "false";
	}catch (PDOException $e){
    	error_log( "ERROR: ". $e->getMessage() );
    	return "ERROR: ".$e->getMessage();
	}

});


$app->run();

