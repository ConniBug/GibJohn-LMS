<?php
// print_r($work);
$workModel = new workModel();

// Get all submissions for this piece of work
$submissions = $workModel->getUsersWorkSubmission($work->WorkID, $userIndexing);
?>

<div onclick="document.location = '#';" class="card card-cover text-white bg-dark rounded-5 shadow-lg" style="margin-bottom: 5px;">
    <h2 class="pt-1" style="margin-left: 5px;">    
        <button onclick="document.location = `/group/<?php echo $currentGroupID; ?>/<?php echo $currentUnitID; ?>/<?php echo $work->WorkID; ?>/delete`;" type="button" class="btn btn-round">    
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="35" viewBox="0 0 24 24"><path d="M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z"/></svg>
        </button> 
            Task #<?php echo $workIndex; ?> - <?php echo $work->WorkTitle; ?>
    </h2>
    
    <hr style="margin-left: 5px;margin-top: 0%;margin-bottom: 2%;">
    <h5 class="pt-0 mt-0 mb-3 lh-1" style="margin-left: 5px;"><?php echo $work->WorkDescription; ?></h5>
    <hr style="margin-left: 5px;margin-top: 0%;margin-bottom: 2%;">
    <h5 class="pt-0 mt-0 mb-3 lh-1" style="margin-left: 5px;"><?php echo $work->WorkRewardPoints; ?> Points</h5>
    <h5 class="pt-0 mt-0 mb-3 lh-1" style="margin-left: 5px;"><?php echo humanTiming(strtotime($work->WorkDeadline)); ?> left</h5>
    <hr style="margin-left: 5px;margin-top: 0%;margin-bottom: 2%;">
     <?php
        $cnt = 0;
        // Go through all the submissions and print out the files infomation
        foreach($submissions as $submission) {
            $cnt = $cnt + 1;
            if($cnt == 1) {
               ?> <h5 class="pt-0 mt-0 mb-3 lh-1" style="margin-left: 5px;">Submissions</h5> <?php
            }
            ?>
            <h6 class="pt-0 mt-0 mb-3 lh-1" style="margin-left: 10px;">#<?php echo $cnt; ?> - <?php echo $submission->DocumentName; ?> - <?php echo $submission->SubmissionDate; ?></h6>

            <?php
        }
    ?>
    <!-- Submission popup button -->
    <?php 
        if($roleInGroup == "Student") { ?>

    <button onclick="submissionDataPopup(<?php echo $work->WorkID; ?>, '<?php echo $work->WorkTitle; ?>', '<?php echo $selectedGroupUnit->UnitID; ?>')" 
            type="button" class="btn btn-secondary btn-round" 
            data-toggle="modal" data-target="#submissionPopup">    
        <h5 class="fw-bold">Submit</h5>
    </button> 
    <?php } ?>
</div>