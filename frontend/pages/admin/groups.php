<script>
function popupSet(id, name) {
    document.getElementById("nNameSpot").textContent = name;
    document.getElementById("GROUPID").value = id;
}
</script>

<div class="card mb-3 mb-lg-5">
    <div class="card-header">
        <h4 class="card-header-title">Groups</h4>
    </div>
    <table class="table" role="grid">
        <tr role="row" class="odd">
            <td>Nickname</td>
            <td>Subject</td>
            <td>Location</td>
            <td>OwnerID</td>
            <td>Status</td>
            <td></td>
        </tr>

<?php 

try {
    $groupModel = new groupModel();
    
    if(isset($uri[2]) && $uri[2] == "update") {
        try {
            if($_POST["NEW_STATUS"] != "NULL") {
                $groupModel = new GroupModel();
                $groupModel->updateStatus($_POST["NEW_STATUS"], $_POST["GROUPID"]);
                
                ?><script>document.location = "/admin-groups";</script><?php      
            }
        } 
        catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            echo $strErrorDesc;
        }
    }

    $arrGroups = $groupModel->getGroups();
    // Convert the responce into JSON
    $jsonEncoded = json_decode(json_encode($arrGroups));

    foreach($jsonEncoded as $group) {
        ?>
            <tr role="row" class="odd">
                <td class="table-column-ps-0">
                    <a class="d-flex align-items-center" href="/group/<?php echo $group->GroupID; ?>">
                        <img src="https://i.imgur.com/kz8725t.jpeg" alt="" width="32" height="32" class="rounded-circle me-2">
                        <h5><?php echo $group->GroupNickname; ?></h5>
                    </a>
                </td>
                <td><?php echo $group->GroupSubject; ?></td>
                <td><?php echo $group->GroupLocation; ?></td>
                <td class="table-column-ps-0">
                    <a class="d-flex align-items-center" href="/profile/<?php echo $group->GroupOwnerID; ?>/admin">
                        <h5><?php echo $group->GroupOwnerID; ?></h5>
                    </a>
                </td>
                <td><?php echo $group->GroupStatus; ?></td>
                <td>
                    <!-- Popup toggle -->
                    <button onclick="popupSet('<?php echo $group->GroupID;?>', '<?php echo $group->GroupNickname;?>');" type="button" class="btn btn-secondary btn-round" data-toggle="modal" data-target="#manageGroupModel">
                        <h5 class="fw-bold">Modify</h5>
                    </button> 
                </td>
            </tr>
        <?php
    }
} 
catch (Error $e) {
    $strErrorDesc = $e->getMessage().' - Something went wrong!';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    echo $strErrorDesc;
}

?>
    </table>
</div>

<div class="modal fade" id="manageGroupModel" tabindex="-1" role="dialog" aria-labelledby="manageGroupModel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form action="/admin-groups/update" id="manageGroupModelForm" method="POST" role="form" class="form-horizontal">
            <div class="text-center">
                <h4>Update Group Info</h4>
                <h4 id="nNameSpot">asdasd</h4>
            </div>
            <div class="form-group">
                <div class="modal-body">
                    <div class="d-flex flex-column text-center">                    
                        <label for="statusDropdown">Group Status</label>
                        <select class="form-control" id="statusDropdown">
                            <option value="NULL">------</option>
                            <option value="ACTIVE">Active</option>
                            <option value="BANNED">Banned</option>
                            <option value="DENIED">Denied</option>
                        </select>
                        <input name="GROUPID" style="visibility: hidden;" type="text" value="N/A" id="GROUPID"> 
                        <input name="NEW_STATUS" style="visibility: hidden;" type="text" value="N/A" id="NEW_STATUS"> 
                    </div>
                </div>
            </div>
        </form>
      <button onclick="document.getElementById('NEW_STATUS').value = document.getElementById('statusDropdown').value; document.getElementById('manageGroupModelForm').submit();" type="button" class="btn btn-secondary btn-block btn-round">Apply</button>
    </div>
  </div>
</div>