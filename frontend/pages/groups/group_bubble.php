<?php

// If we are only displaying groups the user owned and the group isnt owned by the user, then dont display it
// else display
if(
    // If the flag is toggled check if the user doesnt own the group
    !(($GROUP_BUBBLE_FLAG___SHOW_OWNED_ONLY == "TRUE" && $group->GroupOwnerID != $_SESSION["JSON-DAT"]->UserID) ||
    // If the flag is not toggled check if the user owns the group
    ($GROUP_BUBBLE_FLAG___SHOW_OWNED_ONLY == "FALSE" && $group->GroupOwnerID == $_SESSION["JSON-DAT"]->UserID))

) {

    $memberCount = $groupModel->getMemberCountOfGroup($group->GroupID);
    $timeSince = humanTiming(strtotime($group->GroupStartDate));

?>



<div class="col" onclick="document.location = '/group/<?php echo $group->GroupID; ?>';">
    <div class="card card-cover h-100 overflow-hidden text-white bg-dark rounded-5 shadow-lg" style="background-image: url('image-url.something');">
    <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
        <h6 class="mb-1 lh-1 fw-bold"><?php echo $group->GroupNickname; ?></h6>
        <h6 class="mb-5 lh-1 fw-bold"><?php if($group->GroupStatus != "ACTIVE") { echo $group->GroupStatus; } ?></h6>
        <h2 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold"><?php echo $group->GroupSubject; ?></h2>
        <ul class="d-flex list-unstyled mt-auto">
        <li class="me-auto">
            <h7><?php echo $group->PrefferedFullName; if($group->GroupOwnerID == $_SESSION["JSON-DAT"]->UserID) { echo " (you)"; }?></h7>
        </li>
        <?php if($group->GroupLocation != "") { ?>
        <li class="d-flex align-items-center me-3">
            <svg class="bi me-2" width="1em" height="1em"><use xlink:href="#geo-fill"/></svg>
            <small><?php echo $group->GroupLocation; ?></small>
        </li>
        <?php } ?>
        <li class="d-flex align-items-center me-3">
            <svg class="bi me-2" width="1em" height="1em"><use xlink:href="#calendar3"/></svg>
            <small><?php echo $timeSince; ?></small>
        </li>
        <li class="d-flex align-items-center">
            <svg class="bi me-2" width="1em" height="1em"><use xlink:href="#people-circle"/></svg>
            <small><?php echo $memberCount; ?></small>
        </li>
        </ul>
    </div>
    </div>
</div>

<?php
}
?>