<!-- 
    $groupUnits 
    $roleInGroup
    $selectedGroupUnit
    
    $unitListBox_offset          = 1.74;
    $unitListListBox_offset = 1.690711355738062;
    $workListBox_offset = 3.1;
    $unitResourcesListBox_offset = 9.60011355738062;
-->
<?php 
$randomSeed = rand(10,100);
?>

<div id="unitListBox<?php echo $randomSeed; ?>" style="height: 548.851px; margin-left: -2%;" class="row">
    <div class="col-md-3">

        <!-- Draw all the units -->
        <div id="unitListListBox<?php echo $randomSeed; ?>" style="overflow-y: auto; overflow-x: none;height: 548.851px;">
            <?php
            if($groupUnits) {
                foreach($groupUnits as $unit) {
                    include __DIR__ . "/../unitBox.php";
                }
            }

            ?>

            <?php 
            if($roleInGroup == "Tutor") { ?>
                <div class="card card-cover text-white bg-dark rounded-5 shadow-lg" style="margin-bottom: 5px;">                        
                    <!-- Create group unit popup button -->
                    <button type="button" class="btn btn-secondary btn-round" data-toggle="modal" data-target="#newUnitPopup">
                        <h5 style="padding-bottom: 40%;padding-top: 40%;" class="fw-bold">New</h5>
                    </button> 
                    <!-- <h6 class="pr-1 lh-1" style="margin-left: 5px;text-align: right;">View ></h6> -->
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <div style="margin-left: -1%;" class="col-md-9">
        <div class="row">
            <?php
                include __DIR__ . "/../unitContent.php";
            ?>
        </div>
    </div>
</div>

<script>
let hookedFunc<?php echo $randomSeed; ?> = window.onresize;

// Manages organising and sizing of components
function resizeListener<?php echo $randomSeed; ?>() {

    if(hookedFunc<?php echo $randomSeed; ?>) {
        hookedFunc<?php echo $randomSeed; ?>();
    }
    
    unitListBox<?php echo $randomSeed; ?> = document.getElementById("unitListBox<?php echo $randomSeed; ?>");
    unitListListBox<?php echo $randomSeed; ?> = document.getElementById("unitListListBox<?php echo $randomSeed; ?>");
    workListBox<?php echo $randomSeed; ?> = document.getElementById("workListBox<?php echo $randomSeed; ?>");
    unitResourcesListBox<?php echo $randomSeed; ?> = document.getElementById("unitResourcesListBox<?php echo $randomSeed; ?>");


    unitListBox<?php echo $randomSeed; ?>.style.height = window.innerHeight / <?php echo $unitListBox_offset; ?>;
    unitListListBox<?php echo $randomSeed; ?>.style.height = window.innerHeight / <?php echo $unitListListBox_offset; ?>;
    workListBox<?php echo $randomSeed; ?>.style.height = window.innerHeight / <?php echo $workListBox_offset; ?>;
    unitResourcesListBox<?php echo $randomSeed; ?>.style.height = window.innerHeight / <?php echo $unitResourcesListBox_offset; ?>;
}
// console.log("Display Units Loaded! - seed: <?php echo $randomSeed; ?>");

window.onresize = function(){
    resizeListener<?php echo $randomSeed; ?>();
}; 
resizeListener<?php echo $randomSeed; ?>();
</script>