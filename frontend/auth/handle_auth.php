<?php

function forceLogout($clearSession = false) {
    // Destroy the php session.
    if($clearSession) {
        session_destroy(); 
    }
    $_POST["action"] = "login";
    $_SESSION["logged-in"] = "FALSE";
    ?><script>document.location = "/";</script><?php
    return;
}

// Safeguard for if needed vars arent set

// This is most likely a new user session
//      So initiate it as a user attempting to login
if(!isset($_SESSION["logged-in"]) || $_SESSION["logged-in"] == "FALSE") {
    $_POST["action"] = "login";
    $_SESSION["logged-in"] = "FALSE";
}
$Email = "";
if(isset($_POST['email'])) {
    $Email = $_POST['email'];
}
$password = "";
if(isset($_POST['password'])) {
    $password = $_POST['password'];
}
if($Email == "" || $password == "") {
    $_POST['action'] = "";
} 

// If the logged in user isnt activated
//       then disallow them access
if($_SESSION["logged-in"] == "TRUE") {
    debug_var("Is logged in");

    if($_SESSION["JSON-DAT"] != "" && $_SESSION["JSON-DAT"]->AccountStatus != "ACTIVE") {
        // Account isnt active
        debug_var("Account isnt active");

        $_SERVER["REQUEST_METHOD"] = "POST";
        $_POST['action'] = "AccountStatusIsntActive";
        $Email = $_SESSION["JSON-DAT"]->ContactEmail;
    } else {
        // Account is active
        debug_var("Account is active");
        try {        
            $userModel = new UserModel();
            
            // Request user data based of their Email
            $arrUsers = $userModel->getUserByUserID($_SESSION["JSON-DAT"]->UserID);
            // Convert the responce into JSON
            $jsonEncoded = json_decode(json_encode($arrUsers))[0];
    

            if($jsonEncoded->UserID != $_SESSION["JSON-DAT"]->UserID) {
                debug_var("Forcing logout");

                forceLogout();
                return;
            }
            $_SESSION["JSON-DAT"] = $jsonEncoded;
            
            debug_var("Session is valid");
        } 
        catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            echo $strErrorDesc;
        }
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] != "") {
    debug_var("Authenticating");
    try {
        $userModel = new UserModel();
        
        // Request user data based of their Email
        $arrUsers = $userModel->getUserByEmail($Email);
        // Convert the responce into JSON
        $jsonEncoded = json_decode(json_encode($arrUsers));

        if($_POST['action'] != "register" && !isset($jsonEncoded[0])) {
            $_SESSION["last-error"] = "AUTHENTICATION_FAILED";
            // forceLogout();
            return;
        }
        $jsonEncoded = $jsonEncoded[0];

        if($_POST['action'] == "AccountStatusIsntActive") {
            $_SESSION["JSON-DAT"] = $jsonEncoded;
            if($_SESSION["JSON-DAT"]->AccountStatus == "ACTIVE") {
                ?><script>document.location = "/";</script><?php
            }
            return;
        }
        else if($_POST['action'] == "login") {
            // User is attempting to login.
            debug_var("User is attempting to login");
            if(password_verify($password, $jsonEncoded->PasswordHash)) {
                // Setup the data within the users PHP Session
                //      This data tells the server whos logged in among various other details.
                $_SESSION["logged-in"] = "TRUE";
                $_SESSION["UserID"] = $jsonEncoded->UserID;
                $_SESSION["JSON-DAT"] = $jsonEncoded; 
                ?><script>document.location = "/";</script><?php
                exit();
            } else {
                $_SESSION["last-error"] = "AUTHENTICATION_FAILED";
            }
        } 
        else if($_POST['action'] == "register") {
            if(isset($jsonEncoded->UserID)) {
                $_SESSION["last-error"] = "Account already exists";
                ?> <div class="alert alert-danger" role="alert" style="position: absolute;top: 1%;left:1%">Account already exists with the provided email!</div> <?php
                return;
            }
            $createUserResponce = $userModel->createNewUser($Email, password_hash($password, PASSWORD_DEFAULT));

            // Request user data based of their Email
            $newUserAccountResponce = $userModel->getUserByUserID($createUserResponce->insert_id);
            // Convert the responce into JSON
            $newUserData = json_decode(json_encode($newUserAccountResponce))[0];
            echo "NEW ACCOUNT STUFF BUT JSON: "; print_r($newUserData);
            
            $_SESSION["logged-in"] = "TRUE";
            $_SESSION["UserID"] = $newUserData->UserID;
            $_SESSION["JSON-DAT"] = $newUserData; 
            $_SESSION["last-error"] = "New account warning";
            ?><script>document.location = "/";</script><?php
            return;
        }
    } 
    catch (Error $e) {
        $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        echo $strErrorDesc;
    }
}
?>