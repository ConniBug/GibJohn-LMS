<?php
$IS_SELF = "FALSE";

// Parse our url path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

try {
    $userModel = new UserModel();
    
    // Request user data based of their Email
    $arrUsers = $userModel->getUserByUserID($uri[2]);
    // Convert the responce into JSON
    $jsonEncoded = json_decode(json_encode($arrUsers))[0];

    if(!isset($jsonEncoded->UserID)) {
        $_SESSION["last-error"] = "INVALID_SELECTION";
        exit();
    }
    if($jsonEncoded->UserID == $_SESSION["JSON-DAT"]->UserID) {
        $IS_SELF = "TRUE";

        if(isset($uri[3]) && $uri[3] == "public") {
            $IS_SELF = "FALSE";
        }
    }
    
    if(isset($uri[3]) && $uri[3] == "admin" && $_SESSION["JSON-DAT"]->UserRole == "Admin") {
        $IS_SELF = "TRUE";
    }
    $ACTIVE_USER_DATA = $jsonEncoded;

    // The client is on /profile/<user_id>/update
    //      Collect the posted data and update it within the database
    if($IS_SELF && isset($uri[3]) && $uri[3] == "update") {
        // Set the return address for after the update has been performed
        $ReturnAddress = "/profile" . "/" . $jsonEncoded->UserID;
        if($_SESSION["JSON-DAT"]->UserRole == "Admin") {
            $ReturnAddress = "/profile" . "/" . $jsonEncoded->UserID . "/admin";
        }
        if(isset($_POST["send-to"])) {
            $ReturnAddress = $_POST["send-to"];
        }
        
        try {
            debug_json("Posted new data:", $_POST);
            if(!isset($_POST["PrefferedFullName"])) {
                throw(new Error("Data not posted"));
            }
            $userModel = new UserModel();
          
            // This is used to allow admins to update user status from the admin page or a users profile directly

            // Default the new AccountStatus to the current AccountStatus,
            //      This should only change if an admin modifys it
            $AccountStatus = $_SESSION["JSON-DAT"]->AccountStatus;

            // The user is an admin so they can modify the AccountStatus.
            if($_SESSION["JSON-DAT"]->UserRole == "Admin" && $_POST["AccountStatus"] != "") {
                // Apply the new account status to the AccountStatus var
                $AccountStatus = $_POST["AccountStatus"];
            }

            // Update the account with the new data
            $updateUserResponce = $userModel->updateUser(
                $jsonEncoded->UserID, $_POST["PrefferedFullName"], $_POST["ContactEmail"], $_POST["PhoneNumber"], $_POST["MainRoleTitle"], $AccountStatus
            );
        }
        catch (Error $e) {
          $strErrorDesc = $e->getMessage().' - Something went wrong!';
          $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
          debug_var($strErrorDesc, "ERR");
        }

        debug_var($ReturnAddress, "Return address");
        ?><script>document.location = "<?php echo $ReturnAddress; ?>";</script><?php
      }
} 
catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    debug_var($strErrorDesc, "ERR");
}
?>

<div style="width: 80%;position: absolute;"> 
    <div>
        <div class="container rounded bg-white" style="margin-left: 0%;">
            <div class="row">
                <div class="col-md-2 border-right">

                    <?php include "./pages/profile/bubble.php"; ?>

                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-1">
                        <form action="/profile/<?php echo $ACTIVE_USER_DATA->UserID; ?>/update" id="updateUserInfoForm" method="POST">
                            <div class="flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right" style="margin-bottom: 0px"><?php echo $ACTIVE_USER_DATA->PrefferedFullName; ?>'s Profile!</h4> 
                                <span class="text-black-50"> <?php echo $ACTIVE_USER_DATA->MainRoleTitle . ""; ?> </span>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12"><label class="labels">Full Name</label><br>
                                    <?php 
                                    if($IS_SELF == "TRUE") { 
                                        ?> <input id="PrefferedFullName" name="PrefferedFullName" type="text" class="form-control" value="<?php echo $ACTIVE_USER_DATA->PrefferedFullName; ?>"> 
                                    <?php 
                                    } else {
                                        echo $ACTIVE_USER_DATA->PrefferedFullName;
                                    }
                                    ?>
                                </div>
                                <div class="col-md-12"><label class="labels">Job Title</label><br>
                                    <?php 
                                    if($IS_SELF == "TRUE") { 
                                        ?> <input id="MainRoleTitle" name="MainRoleTitle" type="phonenumber" class="form-control" value="<?php echo $ACTIVE_USER_DATA->MainRoleTitle; ?>"> 
                                    <?php 
                                    } else {
                                        echo $ACTIVE_USER_DATA->MainRoleTitle;
                                    }
                                    ?>
                                </div>
                                <div class="col-md-12"><label class="labels">Mobile Number</label><br>
                                    <?php 
                                    if($IS_SELF == "TRUE") { 
                                        ?> <input id="PhoneNumber" name="PhoneNumber" type="phonenumber" class="form-control" value="<?php echo $ACTIVE_USER_DATA->PhoneNumber; ?>"> 
                                    <?php 
                                    } else {
                                        echo $ACTIVE_USER_DATA->PhoneNumber;
                                    }
                                    ?>
                                </div>
                                
                                <div class="col-md-12"><label class="labels">Email</label><br>
                                    <?php 
                                    if($IS_SELF == "TRUE") { 
                                        ?> <input id="ContactEmail" name="ContactEmail" type="email" class="form-control" value="<?php echo $ACTIVE_USER_DATA->ContactEmail; ?>"> 
                                    <?php 
                                    } else {
                                        ?><a href="mailto:<?php echo $ACTIVE_USER_DATA->ContactEmail; ?>"><?php echo $ACTIVE_USER_DATA->ContactEmail; ?></a> <?php
                                    }
                                    ?>
                                </div>
                                    <?php 
                                    if(isset($uri[3]) && $uri[3] != "public" && $_SESSION["JSON-DAT"]->UserRole == "Admin") { ?>
                                        <div class="col-md-12"><label class="labels">Account Status</label><br>
                                        <input id="AccountStatus" name="AccountStatus" type="email" class="form-control" value="<?php echo $ACTIVE_USER_DATA->AccountStatus; ?>"> 
                                    <?php } ?>
                                </div>
                            </div>
                        </form>
                            <?php 
                                    if($IS_SELF == "TRUE") { 
                            ?>          <button onclick="document.getElementById('updateUserInfoForm').submit();" type="button" class="btn btn-secondary btn-block btn-round">Submit</button>
                            <?php 
                                    }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
