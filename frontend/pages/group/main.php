<?php
// Used for converting php time into a human readable form
function humanTiming ($time) {
    // DeltaTime - eg time passed since timestamp
    $deltaTime = $time - time();
    // Ensure the time isnt in the past, if so defult to 1 second since event
    $deltaTime = ($deltaTime<1)? 1 : $deltaTime;
    $tokens = array (
        31536000 => 'Year',
        2592000 => 'Month',
        604800 => 'Week',
        86400 => 'Day',
        3600 => 'Hour',
        60 => 'Minute',
        1 => 'Second'
    );
  
    // If the deltatime is less than the left key of the above tokens
    //    Is lower than our time stamp we skip its usage
    foreach ($tokens as $unit => $text) {
        if ($deltaTime < $unit) continue;
        $numberOfUnits = floor($deltaTime / $unit);
        return $numberOfUnits." ".$text.(($numberOfUnits>1)?'s':'')." ";
    }
  }

$IS_SELF = "FALSE";
// $DEBUG_MODE = "TRUE";
// Parse our url path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

debug_var($uri);

try {
    $groupModel = new GroupModel();
    $userModel = new UserModel();
    $unitModel = new UnitModel();
    $workModel = new WorkModel();
    $documentModel = new DocumentModel();
    
    // Request group record data based of the GroupID
    $group = $groupModel->getGroupByID($uri[2]);

    $roleInGroup = $userModel->getUsersRoleInGroup($uri[2], $_SESSION["JSON-DAT"]->UserID);
    $result = $roleInGroup->get_result()->fetch_all(MYSQLI_ASSOC);
    $roleInGroup->close();
    $roleInGroup = $result[0]["TargetRole"];
    if(!isset($roleInGroup)) {
        ?><script>document.location = "/groups";</script><?php
    }

    $currentGroupID = $uri[2];
    // Get all users within the group
    $usersInGroup = $userModel->getUsersInGroup($currentGroupID);
    debug_json("Users in group:", $usersInGroup);
    
    if(isset($uri[3])) {
        $currentUnitID = $uri[3];
    }
    if(isset($uri[4])) {
        $currentWorkID = $uri[4];
    }
    // Request all the units within the group
    $groupUnits = $groupModel->getGroupUnitsByGroupID($currentGroupID);

    if(isset($uri[3])) {
        if($uri[3] == "new") {
            if($uri[4] == "unit" && $roleInGroup == "Tutor") {
                if(!isset($_POST["UnitTopic"])) {
                    ?><script>document.location = document.location + "/../../";</script><?php
                    throw(new Error("Data not posted"));
                }
                $res = $unitModel->createNewUnit($currentGroupID, $_POST["UnitTopic"], $_POST["UnitOrderID"], $_POST["UnitFinishDate"]);
                
                ?><script>document.location = document.location + "/../../<?php echo $res->insert_id; ?>";</script><?php
                exit();
            }
        } else if(isset($uri[4]) && $uri[4] == "view") {
            if($roleInGroup != "Tutor") {
                ?><script>document.location = document.location + "/../../<?php echo $res->insert_id; ?>";</script><?php
                exit();
            }
        }
        else if($uri[3] == "submit") {
            if(!isset($_POST["WorkID"])) {
                throw(new Error("Data not posted"));
            }


            // Upload the document to the document Table
            $res = $documentModel->uploadNewDocument(
                basename($_FILES["workFileUpload"]["name"]), $_SESSION["JSON-DAT"]->UserID, "false"
            );
            $DocumentID = $res->insert_id;

            // Post the submission for the work record
            $res = $workModel->createNewSubmission(
                $_SESSION["JSON-DAT"]->UserID, $_POST["WorkID"], $DocumentID
            );
            $SubmissionID = $res->insert_id;


            /////////////////////////////////////////////////////////////////////////////
            // Save to disk
            /////////////////////////////////////////////////////////////////////////////
            $target_file = __DIR__ . "/uploads" . "/" . basename($_FILES["workFileUpload"]["name"]) . "." . $DocumentID . "." . "DOCUMENT";
            $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            if (move_uploaded_file($_FILES["workFileUpload"]["tmp_name"], $target_file)) {
                debug_var("The file ". htmlspecialchars( $target_file ). " has been uploaded.");
            } else {
                debug_var("Sorry, there was an error uploading your file.");
            }
            /////////////////////////////////////////////////////////////////////////////
            
            ?><script>document.location = document.location + "/../<?php echo $_POST["UnitID"]; ?>";</script><?php
            exit();
        }
        else {
            // Request the selected unit
            $selectedGroupUnit = $groupModel->getGroupUnitByUnitID($currentUnitID);
            if(isset($uri[4]) && $uri[4] == "new") {
                $WorkTitle = $_POST["WorkTitle"];
                $WorkDescription = $_POST["WorkDescription"];
                $WorkPoints = $_POST["WorkPoints"];
                $WorkDeadline = $_POST["WorkDeadline"];

                if($_POST["WorkDescription"] == "" || $_POST["WorkPoints"] == "" || $_POST["WorkTitle"] == "" ) {
                    echo "Not all fields contained data";   
                    ?><script>document.location = "/group/<?php echo $currentGroupID; ?>/<?php echo $currentUnitID; ?>";</script><?php
                    exit();
                }
                $res = $workModel->createNewWork($WorkTitle, $WorkDescription, $WorkDeadline, $WorkPoints, $currentUnitID);
                debug_json("New Work:", $res);
                ?><script>document.location = "/group/<?php echo $currentGroupID; ?>/<?php echo $currentUnitID; ?>";</script><?php
            } else if(isset($currentWorkID)) {
                // Request the selected unit
                $selectedWorkUnit = $workModel->getWorkByID($currentWorkID);
                // print_r($selectedWorkUnit);
                if($selectedWorkUnit == Array()) {
                    ?><script>document.location = "/group/<?php echo $currentGroupID; ?>/<?php echo $currentUnitID; ?>";</script><?php
                    exit();
                }
                if(isset($uri[5]) && $uri[5] == "delete") {
                    $res = $workModel->deleteWorkByID($currentWorkID);

                    debug_json("Deleted Work:", $res);
                    ?><script>document.location = "/group/<?php echo $currentGroupID; ?>/<?php echo $currentUnitID; ?>";</script><?php
                    exit();
                }
            }
        }
    }
    
    debug_json("Group Record:", $group);
    debug_json("Group Unit Records:", $groupUnits);
}
catch (Error $e) {
    $strErrorDesc = $e->getMessage().' - Something went wrong in group!';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    echo "main:" . $strErrorDesc;
    print_r($e);
}
?>

<div class=" bg-dark" style="width: 80%;"> 
    <!-- Top left -->
    <div style="position: absolute;width: 40%; margin-left: 0%; padding-left: 1rem;">
        <div class="row">
            <div class="col-md-9 border-right">
                <h2 class="pb-0 mb-0 mt-3 lh-1"><?php echo $group->GroupNickname; ?></h2>
                <hr style="margin-top: 2%;margin-bottom: 2%;">
                <h5 class="pt-0 mt-0 mb-4 lh-1"><?php echo $group->GroupSubject; ?></h5>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9 border-right">
                <h5 class="pb-0 mb-0 mt-3 lh-1">Announcements</h5>
                <hr style="margin-top: 2%;margin-bottom: 2%;">
            </div>
        </div>
    </div>


    <div style="position: absolute; width: 40%; margin-left: 40%;">
        <div class="card mb-3 mb-lg-5">
            <div class="card-header">
                <h4 class="card-header-title">Tutors/Students</h4>
            </div>

            <table class="table" role="grid">
                <tr role="row" class="odd">
                    <td>Full Name & Profile Picture</td>
                    <td>Contact Email</td>
                    <td>Group Role</td>
                </tr>
                <?php 
                foreach($usersInGroup as $user) {
                    ?>
                        <tr role="row">
                            <td class="table-column-ps-0">
                                <a class="d-flex align-items-center">
                                    <img src="https://i.imgur.com/kz8725t.jpeg" alt="" width="32" height="32" class="rounded-circle me-2">
                                    <h5><?php echo $user->PrefferedFullName; ?></h5>
                                </a>
                            </td>
                            <td><?php echo $user->ContactEmail; ?></td> 
                            <td><?php echo $user->TargetRole; ?></td>
                            <td>
                                <!-- Popup toggle -->
                                <?php 
                                $tmp = "/";
                                if(isset($uri[4]) && $uri[4] == "view") {
                                    $tmp = "/../../";
                                } ?>
                                <button onclick="document.location = document.location + '<?php echo $tmp; ?>view/<?php echo $user->UserID; ?>';" type="button" class="btn btn-secondary btn-round" 
                                                                        data-toggle="modal" data-target="#displayWorkDoneModel">
                                    <h6 class="fw-bold">View Work</h6>
                                </button> 
                            </td> 
                      </tr>
                    <?php
                }
                ?>
            </table>
        </div>


        <?php 
            if(isset($uri[4]) && $uri[4] == "view") {
                $userBeingViewed = $userModel->getUserByUserID($uri[5])[0];
            } ?>

        <div class="modal fade" id="displayWorkDoneModel" tabindex="-1" role="dialog" aria-labelledby="displayWorkDoneModel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="text-center">
                        <h4>Work Completed</h4>
                        <h4 id="nNameSpot"><?php echo $userBeingViewed["PrefferedFullName"]; ?>'s Completed Work</h4>
                    </div>
                    <div class="modal-body">
                    <?php 
                        $userIndexing = $uri[5];
                        $groupUnits;
                        $roleInGroup = "TutorReview";
                        $selectedGroupUnit = $groupModel->getGroupUnitByUnitID($currentUnitID);
                                                
                        $unitListBox_offset          = 1.74;
                        $unitListListBox_offset = 1.690711355738062;
                        $workListBox_offset = 3.1;
                        $unitResourcesListBox_offset = 9.60011355738062;                            
                        include __DIR__ . "/components/widgets/displayUnits.php"; 

                        $roleInGroup = "Tutor";

                    ?>
                    </div>
                </div>
            </div>
        </div>
        <?php 
        if(isset($uri[4]) && $uri[4] == "view") {
            ?>      
            <script>
            $('#displayWorkDoneModel').modal("toggle");
            </script>
        <?php } ?>
    </div>

    
    <div style="position: absolute; width: 40%; margin-left: 0%; margin-top: 17%; padding-left: 1rem;">
        <!-- <h2 class="pb-0 mb-0 mt-3 lh-1">Bottom left</h2> -->

        <h2 class="">Units Overview</h2>
        <hr style="margin-top: -1%; margin-bottom: 2%;">

        <?php 
        
        $userIndexing = $_SESSION["JSON-DAT"]->UserID;
        $groupUnits;
        $roleInGroup;
        $selectedGroupUnit;

        $unitListBox_offset          = 1.74;
        $unitListListBox_offset = 1.690711355738062;
        $workListBox_offset = 3.1;
        $unitResourcesListBox_offset = 9.60011355738062;
        include __DIR__ . "/components/widgets/displayUnits.php"; 
        
        ?>

    </div>

    <div style="position: absolute;width: 40%; margin-left: 40%; margin-top: 17%;padding-right: 1%;">
        <!-- <h2 class="pb-0 mb-0 mt-3 lh-1">Bottom Right</h2> -->
    </div>
</div>

</div>

<?php
if($roleInGroup == "Tutor") {
    include __DIR__ . "/components/popups/newUnitPopup.php";
    include __DIR__ . "/components/popups/newWorkPopup.php";
}
    include __DIR__ . "/components/popups/submissionPopup.php";
?>
