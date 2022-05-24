<?php
require_once __DIR__ . "/../Models/UserModel.php";

class UserController extends BaseController
{
    /** 
     *  /user/:Username/ Endpoint - Get a specific user by username.
     */
    public function handle() {
        // Create an instance of the UserModel
        $userModel = new UserModel();
        try {
            // get the username from the URL
            $username = $this->getUriPath()[3];

            // Request user data based of the username
            $arrUsers = $userModel->getUserByUsername($username);
            // Conver the responce into JSON
            $jsonEncoded = json_encode($arrUsers);

            // Send the responce as JSON
            $this->sendJSON($jsonEncoded, array('HTTP/1.1 200 Ok'));
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            echo $strErrorDesc;
        }
    }
}