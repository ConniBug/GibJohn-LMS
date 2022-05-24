<?php 
$newUnitID = $groupModel->getNewUnitOrderIdForNewUnitByGroupID($group->GroupID)->Highest;
?>

<div class="modal fade" id="newUnitPopup" tabindex="-1" role="dialog" aria-labelledby="newUnitPopupLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form action="/group/<?php echo $group->GroupID; ?>/new/unit" id="newUnitPopupForm" method="POST">
      
        <div class="text-center">
          <h4><?php echo $group->GroupNickname; ?><br><hr style="margin-top: 1%; margin-bottom: 1%;">Create a new unit</h4>
        </div>
        <div class="modal-body">
          <div class="d-flex flex-column text-center">

            <div class="form-group">
              <input type="text" class="form-control" id="UnitTopic" name="UnitTopic" placeholder="Topic">
            </div>
            <br>
            <div class="form-group">
              <input type="hidden" class="form-control" id="UnitOrderID" name="UnitOrderID" value="<?php echo $newUnitID; ?>">
            </div>
            <br>
            <div class="form-group">
              <label for="UnitFinishDate">Unit End Date:</label>
              <input class="form-control" type="datetime-local" 
                    id="UnitFinishDate" name="UnitFinishDate" 
                    value="2022-06-01T08:30">
            </div>
          </div>
        </div>
      </form>
      <button onclick="document.getElementById('newUnitPopupForm').submit();" type="button" class="btn btn-secondary btn-block btn-round">Create</button>
    </div>
  </div>
</div>