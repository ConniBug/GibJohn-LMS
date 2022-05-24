<script>
function popupSet(id, name) {
    document.getElementById("nNameSpot").textContent = name;
    document.getElementById("USERID").value = id;
}
</script>

<div class="modal fade" id="manageUserModel" tabindex="-1" role="dialog" aria-labelledby="manageUserModel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="/admin-users/update" id="manageUserModelForm" method="POST" role="form" class="form-horizontal">
            <div class="text-center">
                <h4>Update User Status</h4>
                <h4 id="nNameSpot"> name here </h4>
            </div>
            <div class="form-user">
                <div class="modal-body">
                    <div class="d-flex flex-column text-center">                    
                        <label for="statusDropdown">User Status</label>
                        <select class="form-control" id="statusDropdown">
                            <option value="NULL">------</option>
                            <option value="ACTIVE">Active</option>
                            <option value="BANNED">Banned</option>
                            <option value="ACCOUNT_NOT_ACTIVATED">Deactivate</option>
                        </select>
                        <input name="USERID" style="visibility: hidden;" type="text" value="N/A" id="USERID"> 
                        <input name="NEW_STATUS" style="visibility: hidden;" type="text" value="N/A" id="NEW_STATUS"> 
                    </div>
                </div>
            </div>
        </form>
      <button onclick="document.getElementById('NEW_STATUS').value = document.getElementById('statusDropdown').value; document.getElementById('manageUserModelForm').submit();" type="button" class="btn btn-secondary btn-block btn-round">Apply</button>
    </div>
  </div>
</div>