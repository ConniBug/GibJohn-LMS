<?php
require_once __DIR__ . "/DatabaseHandler.php";

class UserModel extends DatabaseHandler {    
    public function __construct() {
        try {
            $this->openConnection();
        } 
        catch (Exception $err) {
            // If an error has occured throw an exception to the caller
            throw new Exception($err->getMessage());   
        }           
    }

    public function getUsers() {
        try {
            return $this->select(
                "SELECT * FROM `Users`", "", ""
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }   

    public function getUserByUsername($PrefferedFullName) {
        try {
            return $this->select(
                "SELECT * FROM `Users` WHERE `PrefferedFullName` = ?", 
                "s", 
                $PrefferedFullName
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }   

    public function getUserByEmail($Email) {
        try {
            return $this->select(
                "SELECT * FROM `Users` WHERE `ContactEmail` = ?", 
                "s", 
                $Email
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }   

    public function getUserByUserID($UserID) {
        try {
            return $this->select(
                "SELECT * FROM `Users` WHERE `UserID` = ?", 
                "s", 
                $UserID
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }

    public function getUsersRoleInGroup($GroupID, $UserID) {
        try {
            return $this->executeStatement2Args(
                "SELECT
                    *
                FROM
                    `group_assignments`
                WHERE
                    `TargetGroupID` = ? AND `TargetUserID` = ?;", 
                "ss", 
                $GroupID, $UserID
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }

    public function getUsersInGroup($GroupID) {
        try {
            $res = $this->select(
                "SELECT
                    `users`.`PrefferedFullName`,
                    `users`.`ContactEmail`,
                    `users`.`UserID`,
                    `group_assignments`.`TargetRole`
                FROM
                    `group_assignments`
                LEFT JOIN `users` ON `group_assignments`.`TargetUserID` = `users`.`UserID`
                WHERE
                    `group_assignments`.`TargetGroupID` = ?
                ORDER BY `group_assignments`.`TargetRole` DESC;", 
                "s", 
                $GroupID
            );
            return json_decode(json_encode($res));
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }  

    public function createNewUser($Email, $password) {
        try {
            return $this->executeStatement2Args(
                "INSERT INTO `Users` (`ContactEmail`, `PasswordHash`) VALUES (?, ?)", "ss", $Email, $password);
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    } 

    public function updateUser($UserID, $PrefferedFullName, $ContactEmail, $PhoneNumber, $MainRoleTitle, $AccountStatus) {
        try {
            return $this->executeStatement6Args(
                "UPDATE
                    `users`
                SET
                    `PrefferedFullName` = ?,
                    `ContactEmail` = ?,
                    `PhoneNumber` = ?,
                    `MainRoleTitle` = ?,
                    `AccountStatus` = ?
                WHERE
                    `users`.`UserID` = ?;", 

            "ssssss", 
            $PrefferedFullName, $ContactEmail, $PhoneNumber, $MainRoleTitle, $AccountStatus, $UserID);
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }

    public function updateStatus($NewStatus, $UserID) {
        try {
            return $this->executeStatement2Args(
                "UPDATE
                    `users`
                SET
                    `AccountStatus` = ?
                WHERE
                    `users`.`UserID` = ?;",
                "ss", 
                $NewStatus, $UserID
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }
}

