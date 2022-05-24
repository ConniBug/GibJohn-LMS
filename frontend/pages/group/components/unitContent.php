<!-- 
    $selectedGroupUnit
    $roleInGroup    
-->

<?php
if(!isset($uri[3]) || $uri[3] == "") {
    ?> 
        <h2 class="">Please select a unit!</h2>
        <hr style="margin-left: 2%;margin-top: 1%;margin-bottom: 2%;width: 96%;">
    <?php
    return false;
}
$selectedGroupUnit;

$workModel = new WorkModel();
$workRecords = $workModel->getWorkByUnitID($selectedGroupUnit->UnitID);

?>

<h2 class="">Unit #<?php echo $selectedGroupUnit->UnitOrderIndex; ?> - <?php echo $selectedGroupUnit->UnitTopic; ?></h2>
<hr style="margin-left: 2%;margin-top: 1%;margin-bottom: 2%;width: 96%;">
<!-- <h5 class="pt-0 mt-0 mb-4 lh-1">Space Math</h5> -->

<div style="width: 100%; margin-left: 0%;margin-top: -1%;height: 80%;">
    <h2 style="margin-bottom: 0%;">Documents</h2>
    <hr style="margin-top: 0%;margin-bottom: 1%;">
    <div>
        <div id="unitResourcesListBox<?php echo $randomSeed; ?>" style="overflow-y: auto; height: 164.851px;" onclick="document.location = '#';" class="card card-cover text-white bg-dark rounded-5 shadow-lg" style="margin-bottom: 5px;">
            <?php
                // print_r($work);
                $unitModel = new UnitModel();

                // Get all submissions for this piece of work
                $resources = $unitModel->getWorkResourcesByUnitID($selectedGroupUnit->UnitID);

                $resourceIndex = 0;
                foreach($resources as $resource) {
                    $resourceIndex = $resourceIndex + 1;            
                    include __DIR__ . "/documentResourceRecord.php";
                }
                if($resourceIndex == 0) {
                    ?>
                        <div onclick="document.location = '#';" class="card card-cover text-white bg-dark rounded-5 shadow-lg" style="margin-bottom: 5px;">
                            <h2 class="pt-1" style="margin-left: 5px;">No resources for this unit!</h2>
        
                        </div>
                    <?php
                }
        
            ?>
        </div>
    </div>
</div>

<div style="width: 100%; margin-left: 0%;margin-top: 0%;">
    <h2 class="pb-0 mb-0 mt-0 lh-1">Work</h2>
    <hr style="margin-top: 2%;margin-bottom: 2%;">
    <div id="workListBox<?php echo $randomSeed; ?>" style="overflow-y: auto; height: 308.065px;margin-left: 0px;" class="row">
        <?php 
        if($roleInGroup == "Tutor") { ?>
                <div class="card card-cover text-white bg-dark rounded-5 shadow-lg" style="margin-bottom: 5px;padding-left: 0px;padding-right: 0px;">                        
                    <button type="button" class="btn btn-secondary btn-round" data-toggle="modal" data-target="#newWorkPopup">
                        <h5 class="fw-bold">New Work</h5>
                    </button> 
                </div>
        <?php 
        } ?>
        <?php

        $workIndex = 0;
        foreach($workRecords as $work) {
            $workIndex = $workIndex + 1;
            include __DIR__ . "/workRecord.php";
        }
        if($workIndex == 0) {
            ?>
                <div onclick="document.location = '#';" class="card card-cover text-white bg-dark rounded-5 shadow-lg" style="margin-bottom: 5px;">
                    <h2 class="pt-1" style="margin-left: 5px;">No work assigned for this unit!</h2>

                </div>
            <?php
        }
        ?>
        
    </div>
</div>
