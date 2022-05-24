<script>
// JavaScript code to spawn a temp message popup
function spawnTemp(type, message, duration = 5000) {
  var deleteMe = $(`<div class="alert alert-${type}" role="alert" style="position: absolute;right:1%;z-index: 1;bottom: 1%;">${message}</div>`).appendTo("#notifications");

  // Delete after 5 Seconds
  setTimeout(function() {
    deleteMe.remove();
  }, duration);
}

<?php
// Proxy PHP Function to call the JavaScript function
function showMessage($type, $str) {
    ?> spawnTemp(`<?php echo $type; ?>`, `<?php echo $str; ?>`); <?php
}
// Proxy PHP Function to call the JavaScript function
function showMessageForXTime($type, $str, $duration) {
    ?> spawnTemp(`<?php echo $type; ?>`, `<?php echo $str; ?>`, <?php echo $duration; ?>); <?php
}

// Used to test that messages will display when an issue occurs
// $_SESSION["last-error"] = "TEST";

// Below lists cases for all of the possible errors that need notifications.
if(isset($_SESSION["last-error"])) {
    if($_SESSION["last-error"] == "INVALID_LOGIN_CREDS") {
        showMessageForXTime("danger", "Invalid login details, please try again!", 10000);
        unset($_SESSION["last-error"]);
    
    } else if($_SESSION["last-error"] == "AUTHENTICATION_FAILED") {
        showMessage("danger", "Invalid login details, please try again!");
        unset($_SESSION["last-error"]);
    
    } else if($_SESSION["last-error"] == "INVALID_SELECTION") {
        showMessage("danger", "Selection invalid please try again!");
        unset($_SESSION["last-error"]);
    
    } else if($_SESSION["last-error"] == "Account already exists") {
        showMessage("danger", "Account already exists!");
        unset($_SESSION["last-error"]);
    
    } else if($_SESSION["last-error"] == "New account warning") {
        showMessage("success", "Account created successfully<br>You will be contacted by you Tutor when your account has been activated!");
        unset($_SESSION["last-error"]);
    
    } else if($_SESSION["last-error"] == "TEST") {
        showMessage("danger", "Test message!!!");
        unset($_SESSION["last-error"]);
    
    } else if($_SESSION["last-error"] == "") {
    
    } else {
        echo "last-error: ";print_r($_SESSION["last-error"]); echo "<br>";
    }
}
?>
</script>
