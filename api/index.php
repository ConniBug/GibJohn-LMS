<?php
// Include the include handler.
require __DIR__ . "/bootstrap.php";

// Parse our url path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// If we arent querying any paths 
//   return an error 404.
if(!isset($uri[1]) || $uri[1] != "api") {
    header("HTTP/1.1 404 Not Found");
    echo "404 Not Found";
    exit();
}

switch($uri[2]) {
    case("user"):       //  /api/user*
        $controller = new UserController();
        break;
    case("serverinfo"): //  /api/serverinfo
        $controller = new ServerInfoController();
        break;
    default:            //  /*                     Everything else
        $controller = new BaseController();
        break;
}
$controller->handle();
