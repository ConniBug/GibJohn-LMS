<script>
function submissionDataPopup(WorkID, WorkName, UnitID) {
    document.getElementById("WorkName").textContent = WorkName;

    document.getElementById("WorkID").value = WorkID;
    document.getElementById("UnitID").value = UnitID;
}
</script>

<div class="modal fade" id="workResourceUploadPopup" tabindex="-1" role="dialog" aria-labelledby="workResourceUploadPopup" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form action="/group/<?php echo $group->GroupID; ?>/upload" id="workResourceUploadForm" method="POST" enctype="multipart/form-data">
      
        <div class="text-center">
          <h4>
            <?php echo $group->GroupNickname; ?>
            <br>
            <hr style="width: 50%;margin-left: 25%; margin-top: 1%; margin-bottom: 1%;">
            <a id="WorkName">sss</a>
            <br>
            <hr style="margin-top: 1%; margin-bottom: 1%;">
            Upload Resource
          </h4>
        </div>
        <div class="modal-body">
          <div class="d-flex flex-column text-center">
            <div class="form-group">
              <input type="hidden" class="form-control" id="WorkID" name="WorkID" value="Not Set">
              <input type="hidden" class="form-control" id="UnitID" name="UnitID" value="Not Set">
            </div>

            <div class="form-group">
              <input type="file" name="workResourceUpload" id="workResourceUpload">
            </div>
          </div>
        </div>
      </form>
      <button onclick="document.getElementById('workResourceUploadForm').submit();" type="button" class="btn btn-secondary btn-block btn-round">Submit</button>
    </div>
  </div>
</div>