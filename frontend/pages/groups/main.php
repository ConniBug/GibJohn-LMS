<?php
// Used for converting php time into a human readable form
function humanTiming ($time) {
  // DeltaTime - eg time passed since timestamp
  $deltaTime = time() - $time;
  // Ensure the time isnt in the past, if so defult to 1 second since event
  $deltaTime = ($deltaTime<1)? 1 : $deltaTime;
  $tokens = array (
      31536000 => 'Y',
      2592000 => 'M',
      604800 => 'w',
      86400 => 'd',
      3600 => 'h',
      60 => 'm',
      1 => 's'
  );

  // If the deltatime is less than the left key of the above tokens
  //    Is lower than our time stamp we skip its usage
  foreach ($tokens as $unit => $text) {
      if ($deltaTime < $unit) continue;
      $numberOfUnits = floor($deltaTime / $unit);
      return $numberOfUnits.$text.(($numberOfUnits>1)?'':'');
  }
}

// Parse our url path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if(!isset($_SESSION["rate-limits"])) {
  $_SESSION["rate-limits"] = json_decode(json_encode(
    array("createGroup" => array("last" => 0, "minTime" => 5000))
  ));
}

if(isset($uri[2]) && $uri[2] == "new") {
  print_r($_SESSION["rate-limits"]->createGroup);
  if($_SESSION["rate-limits"]->createGroup->last + $_SESSION["rate-limits"]->createGroup->minTime > floor(microtime(true) * 1000)) {
    echo "<br>please wait: " . ($_SESSION["rate-limits"]->createGroup->minTime / 1000) - (((floor(microtime(true) * 1000)) - $_SESSION["rate-limits"]->createGroup->last ) / 1000) . " Seconds <br>";
    ?><script>document.location = "/groups/rate-limit";</script><?php
    return;
  }
  $_SESSION["rate-limits"]->createGroup->last = floor(microtime(true) * 1000);

  try {
    print_r($_POST);
    $groupModel = new GroupModel();
    
    $createNewGroupResponce = $groupModel->createNewGroup(
      $_POST["GroupNickname"], $_POST["GroupSubject"], $_POST["GroupLocation"], $_POST["GroupEndDate"], $_SESSION["JSON-DAT"]->UserID, "AWAITING_APPROVAL"
    );

    // Assign creator as a tutor within the group
    $assignmentResponce = $groupModel->assignUserToGroup($_SESSION["JSON-DAT"]->UserID, $createNewGroupResponce->insert_id, "Tutor", $_SESSION["JSON-DAT"]->UserID);

    
    ?><script>document.location = "/group/<?php echo $createNewGroupResponce->insert_id; ?>";</script><?php
  } 
  catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    echo $strErrorDesc;
  }
}

try {
    $groupModel = new GroupModel();
    
    // Request user data based of their user id
    $arrGroups = $groupModel->getGroupsByUserID($_SESSION["JSON-DAT"]->UserID);
    // Convert the responce into JSON
    $groupsFound = json_decode(json_encode($arrGroups));

    debug_json("Groups Found", $groupsFound);
  
    $FOUND_GROUPS = $groupsFound;
} 
catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    echo $strErrorDesc;
}
?>

<div class="px-4 py-0" id="enrolledGroupsContainer">
  <h2 class="pb-2 border-bottom">Enrolled Groups</h2>
    <div class="row g-4 py-3 row-cols-2 row-cols-lg-2">
      <?php 
      try {
        $GROUP_BUBBLE_FLAG___SHOW_OWNED_ONLY = "FALSE";
        foreach($FOUND_GROUPS as $group) {
          include __DIR__ . "/group_bubble.php";
        }
      } 
      catch (Error $e) {
        $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        echo $strErrorDesc;
      }
      ?>
    </div>
  </div>

  <div class="px-4 py-2" id="yourGroupsContainer">
    <h2 class="pb-2 border-bottom">Your Groups</h2>
    <div class="row g-4 py-3 row-cols-2 row-cols-lg-2">
      <?php 
        try {
          foreach($FOUND_GROUPS as $group) {
            $GROUP_BUBBLE_FLAG___SHOW_OWNED_ONLY = "TRUE";
            include __DIR__ . "/group_bubble.php";
          }
        } 
        catch (Error $e) {
          $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
          $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
          echo $strErrorDesc;
        }
        ?>
      <!-- Create group popup button -->
      <button type="button" class="btn btn-secondary btn-round" data-toggle="modal" data-target="#newGroupModel">
        <h5 class="fw-bold">New </h5>
      </button> 
    </div>
  </div>
</div>

<div class="modal fade" id="newGroupModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="/groups/new" id="createNewGroupForm" method="POST">
        <div class="text-center">
          <h4>Create a new group</h4>
        </div>
        <div class="modal-body">
          <div class="d-flex flex-column text-center">
            <div class="form-group">
              <input type="text" class="form-control" id="GroupNickname" name="GroupNickname" placeholder="Nickname">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="GroupSubject" name="GroupSubject" placeholder="Subject">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="GroupLocation" name="GroupLocation" placeholder="Location/Room">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="GroupEndDate" name="GroupEndDate" placeholder="End Date">
            </div>
          </div>
        </div>
      </form>
      <button onclick="document.getElementById('createNewGroupForm').submit();" type="button" class="btn btn-secondary btn-block btn-round">Submit</button>
    </div>
  </div>
</div>