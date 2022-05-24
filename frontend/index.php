<?php 
include "./../api/bootstrap.php";

$_SERVER["DEBUG_MODE"] = true;

// Start/Resume the PHP Session
session_start();
echo file_get_contents("header.html"); ?> 

<?php
function debug_json($title, $data) {
    if($_SERVER["DEBUG_MODE"] && !isset($data)) {
        return false;
    }
    $data = json_encode($data);
    ?> <script> console.log(`<?php echo $title; ?>`, JSON.parse(`<?php print_r($data); ?>`)); </script> <?php
    return true;
}
function debug_var($data, $title = ":") {
    if(!$_SERVER["DEBUG_MODE"] || !isset($data)) {
        return false;
    }
    ?> <script> console.log(`<?php echo $title; ?>`, `<?php print_r($data); ?>`); </script> <?php
    return true;
}

debug_json("_POST", $_POST);
debug_json("_SESSION", $_SESSION);

?>

<div id="notifications">
</div>

<?php 

// Import the Notification handler.
include "./Utils/NotificationHandler.php";

// Handle login requests
//      This code path gets executed by ./auth/index.php
include "./auth/handle_auth.php";

debug_var($_POST["action"], "Action:");

if(in_array($_POST["action"], array("login", "register")) || $_SESSION["logged-in"] == "FALSE") {
    debug_var("Running authentication");
    include "./auth/login.php"; 
    exit();
}
if(in_array($_POST["action"], array("AccountStatusIsntActive"))) {
    debug_var("AccountStatusIsntActive");
    include "./auth/account_not_active.php";
    exit();
}

include "./sidebar/sidebar.php"; 

?>

<div id="content" style="margin-left: 20%;width: 80%;transition: all 1.5s, opacity 1s;">
<script>
var onPageShow = [];
var onPageHide = [];
</script>

<?php
// Parse our url path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// print_r($uri);

if($uri[1] == "home") {
    include "./pages/home.php";
}
if($uri[1] == "profile") {
    include "./pages/profile/main.php";
}
if($uri[1] == "social") {
    include "./pages/social.php";
}
if($uri[1] == "admin-users") {
    include "./pages/admin/users.php";
}
if($uri[1] == "admin-groups") {
    include "./pages/admin/groups.php";
}
if($uri[1] == "groups") {
    include "./pages/groups/main.php";
}
if($uri[1] == "group") {
    include "./pages/group/main.php";
}
if($uri[1] == "logout") { 
    // Destroy the php session.
    session_destroy(); 
    $_POST["action"] = "login";
    ?>
    <script>
    // Force the page to reload.
    document.location = "/";
    </script>
    <?php
}

?>
</div>

<!-- Load logging functions -->
<script><?php echo file_get_contents(__DIR__ . "./../includes/logging.js"); ?></script>

<?php echo file_get_contents("footer.html"); ?> 