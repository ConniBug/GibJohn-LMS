<div class="modal fade" id="newWorkPopup" tabindex="-1" role="dialog" aria-labelledby="newWorkPopupLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form action="/group/<?php echo $group->GroupID; ?>/<?php echo $selectedGroupUnit->UnitID; ?>/new" id="newWorkPopupForm" method="POST">
      
        <div class="text-center">
          <h4>
            <?php echo $group->GroupNickname; ?>
            <br>
            <hr style="width: 50%;margin-left: 25%; margin-top: 1%; margin-bottom: 1%;">
            <a id="WorkName"><?php echo $selectedGroupUnit->UnitTopic; ?></a>
            <br>
            <hr style="margin-top: 1%; margin-bottom: 1%;">
          </h4>
          <h5>
            Create new work item
          </h5>
        </div>
        <div class="modal-body">
          <div class="d-flex flex-column text-center">

            <div class="form-group">
              <input type="text" class="form-control" id="WorkTitle" name="WorkTitle" placeholder="Title">
            </div>
            <br>
            <div class="form-group">
              <textarea class="form-control" id="WorkDescription" name="WorkDescription" placeholder="WorkDescription" rows="3"></textarea>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="WorkPoints" name="WorkPoints" placeholder="Points for completion">
            </div>
            <br>
            <div class="form-group">
              <label for="WorkDeadline">Deadline:</label>
              <input class="form-control" type="datetime-local" 
                    id="WorkDeadline" name="WorkDeadline" 
                    value="2022-06-01T08:30">
            </div>
          </div>
        </div>
      </form>
      <button onclick="document.getElementById('newWorkPopupForm').submit();" type="button" class="btn btn-secondary btn-block btn-round">Create</button>
    </div>
  </div>
</div>