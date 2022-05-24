<?php
debug_json("Drawing Unit:", $unit);

$TotalWorkCount = $workModel->amountOfPossibleWorkForUnit($unit->UnitID)[0]->Count;
$WorkDoneCount = $workModel->amountOfWorkSubmittedByUserForUnitID($userIndexing, $unit->UnitID)[0]->Count;
$WorkLeftToDo = ($TotalWorkCount - $WorkDoneCount);
$PercentDone = 0;
$WorkComplete = $WorkDoneCount . "/" . $TotalWorkCount;

if($TotalWorkCount != 0 && $WorkDoneCount != 0) {
    $PercentDone = ($WorkDoneCount / $TotalWorkCount) * 100;
} else {
    if($WorkDoneCount >= $TotalWorkCount) {
        $PercentDone = 100;
    }
}
$WorkComplete = $WorkComplete . " (" . $PercentDone . "%" . ")";

$tmp = "";
if(isset($uri[4]) && $uri[4] == "view" && $_SESSION["JSON-DAT"]->UserID != $userIndexing) {
    $tmp = "/" . $uri[4] . "/" . $uri[5];
} ?>
<div onclick="document.location = '/group/<?php echo $group->GroupID; ?>/<?php echo $unit->UnitID; ?><?php echo $tmp; ?>';" class="card card-cover text-white bg-dark rounded-5 shadow-lg" style="margin-bottom: 5px;">
    <h2 class="pt-1" style="margin-left: 5px;">Unit - <?php echo $unit->UnitOrderIndex; ?></h2>
    <hr style="margin-left: 5px;margin-top: 0%;margin-bottom: 2%;">
    <h5 class="pt-0 mt-0 mb-3 lh-1" style="margin-left: 5px;"><?php echo $unit->UnitTopic; ?></h5>
    <h6 class="lh-1" style="margin-left: 5px;">Work: <?php echo $WorkComplete ?></h6>
    <h6 class="lh-1" style="margin-left: 5px;"># Late</h6>
    <h6 class="lh-1" style="margin-left: 5px;"># Days Left</h6>
</div>
