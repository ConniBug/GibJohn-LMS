<div class="card mb-3 mb-lg-5">
    <div class="card-header">
        <h4 class="card-header-title">Users</h4>
    </div>

    <table class="table" role="grid">
        <tr role="row" class="odd">
            <td>UserID</td>
            <td>Full Name & Profile Picture</td>
            <td>Contact Email</td>
            <td>Account Status</td>
            <td>Role Title</td>
        </tr>
<?php 

try {
    $userModel = new UserModel();
    
    if(isset($uri[2]) && $uri[2] == "update") {
        try {
            if($_POST["NEW_STATUS"] != "NULL") {
                $userModel->updateStatus($_POST["NEW_STATUS"], $_POST["USERID"]);
                
                ?><script>document.location = "/admin-users";</script><?php      
            }
        }
        catch (Error $e) {
            $strErrorDesc = $e->getMessage().' - Something went wrong!';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            echo $strErrorDesc;
        }
    }

    $arrUsers = $userModel->getUsers();
    // Convert the responce into JSON
    $jsonEncoded = json_decode(json_encode($arrUsers));

    foreach($jsonEncoded as $user) {
        ?>
            <tr role="row" class="odd">
                <td><?php echo $user->UserID; ?></td>
                <td class="table-column-ps-0">
                    <a class="d-flex align-items-center" href="/profile/<?php echo $user->UserID; ?>/admin">
                        <img src="https://i.imgur.com/kz8725t.jpeg" alt="" width="32" height="32" class="rounded-circle me-2">
                        <h5><?php echo $user->PrefferedFullName; ?></h5>
                    </a>
                </td>
                <td><?php echo $user->ContactEmail; ?></td>
                <td><?php echo $user->AccountStatus; ?></td>
                <td><?php echo $user->MainRoleTitle; ?></td>
                <td>
                    <!-- Popup toggle -->
                    <button onclick="popupSet('<?php echo $user->UserID;?>', '<?php echo $user->PrefferedFullName;?>');" type="button" class="btn btn-secondary btn-round" data-toggle="modal" data-target="#manageUserModel">
                        <h5 class="fw-bold">Modify</h5>
                    </button> 
                </td>
            </tr>
        <?php
    }
} 
catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    echo $strErrorDesc;
}

?>
    </table>
</div>

<?php
include __DIR__ . "/components/popups/manageUserPopup.php";
?>