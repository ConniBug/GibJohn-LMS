<?php
// Contains important definitions
ini_set('memory_limit', '1024M'); // or you could use 1G

// include main config
require_once __DIR__ . "/../includes/config.php";

// include the base controller
require_once WEBROOT_API . "/Controllers/BaseController.php";

// include the user controller
require_once WEBROOT_API . "/Controllers/UserController.php";

// include the user model
require_once WEBROOT_API . "/Models/UserModel.php";

// include the UnitModel
require_once WEBROOT_API . "/Models/UnitModel.php";

// include the WorkModel
require_once WEBROOT_API . "/Models/WorkModel.php";

// include the DocumentModel
require_once WEBROOT_API . "/Models/DocumentModel.php";

// include the group model
require_once WEBROOT_API . "/Models/GroupModel.php";

// include the server info controller
require_once WEBROOT_API . "/Controllers/ServerInfoController.php";

// include the database model
require_once WEBROOT_API . "/Models/DatabaseHandler.php";

