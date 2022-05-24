<?php
require_once __DIR__ . "/DatabaseHandler.php";

class GroupModel extends DatabaseHandler {    
    public function __construct() {
        try {

        } 
        catch (Exception $err) {
            // If an error has occured throw an exception to the caller
            throw new Exception($err->getMessage());   
        }           
    }

    public function getGroups() {
        try {
            return $this->select(
                "SELECT * FROM `groups`", "", ""
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }  

    public function getMemberCountOfGroup($GroupID) {
        try {
            $result = $this->select(
               "SELECT 
                    COUNT(`groups`.`GroupID`)           AS RecordCount, 
                    `group_assignments`.`TargetGroupID` AS GroupID 
                FROM 
                    `groups` 
                LEFT JOIN 
                    `group_assignments` 
                ON 
                    `group_assignments`.`TargetGroupID` = `groups`.`GroupID` 
                WHERE 
                    `group_assignments`.`TargetGroupID` = `groups`.`GroupID` AND `groups`.`GroupID` = ?;", 
                "i", 
                $GroupID
            );
            return(json_decode(json_encode($result))[0]->RecordCount);
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }

    public function getGroupsByUserID($UserID) {
        try {
            return $this->select(
                "SELECT `groups`.*, `users`.*, `group_assignments`.`TargetUserID` FROM `groups` LEFT JOIN `group_assignments` ON `group_assignments`.`TargetGroupID` = `groups`.`GroupID` LEFT JOIN `users` ON `users`.`UserID` = `groups`.`GroupOwnerID` WHERE `group_assignments`.`TargetGroupID` = `groups`.`GroupID` AND `group_assignments`.`TargetUserID` = ?;", 
                "i", 
                $UserID
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }  

    public function getGroupUnitsByGroupID($GroupID) {
        try {
            // Get the unit from the database based on the given GroupID
            $responce = $this->select(
                "SELECT * FROM `units` WHERE `UnitGroupID` = ?;", 
                "i", 
                $GroupID
            ); $responce = json_decode(json_encode($responce));

            // Ensure the record contains content returning it, 
            //   If it doesnt exist throw an error.
            if(!isset($responce[0])) {
                throw new Exception("NO_UNITS_FOUND");
            }
            return $responce;

        } catch(Exception $e) {
            // echo($e->getMessage());
            return false;
        }
    }  

    public function getGroupUnitByUnitID($UnitID) {
        try {
            // Get the unit from the database based on the given GroupID
            $responce = $this->select(
                "SELECT * FROM `units` WHERE `UnitID` = ?;", 
                "i", 
                $UnitID
            ); $responce = json_decode(json_encode($responce));

            // Ensure the record contains content returning it, 
            //   If it doesnt exist throw an error.
            if(!isset($responce[0])) {
                throw new Exception("UNIT_NOT_FOUND");
            }
            return $responce[0];

        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }  

    public function getNewUnitOrderIdForNewUnitByGroupID($GroupID) {
        try {
            // Get the unit from the database based on the given GroupID
            $responce = $this->select(
                "SELECT MAX(`UnitOrderIndex`) + 1 AS Highest FROM `units` WHERE `UnitGroupID` = ?;", 
                "i", 
                $GroupID
            ); $responce = json_decode(json_encode($responce));

            // Ensure the record contains content returning it, 
            //   If it doesnt exist throw an error.
            if(!isset($responce[0])) {
                throw new Exception("UNIT_NOT_FOUND");
            }
            if($responce[0]->Highest == 0) {
                $responce[0]->Highest = 1;
            }
            return $responce[0];

        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    } 

    // Return the group record in JSON Form
    public function getGroupByID($GroupID) {
        try {
            // Get the record from the database
            $responce = $this->select(
                "SELECT * FROM `groups` WHERE `GroupID` = ?", 
                "i", 
                $GroupID
            ); $responce = json_decode(json_encode($responce));

            // Ensure the record contains content returning it, 
            //   If it doesnt exist throw an error.
            if(!isset($responce[0])) {
                throw new Exception("GROUP_DOESNT_EXIST");
            }
            return $responce[0];
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    } 

    public function createNewGroup($GroupNickname, $GroupSubject, $GroupLocation, $GroupEndDate, $GroupOwnerID,  $GroupStatus) {
        try {
            return $this->executeStatement6Args(
                "INSERT INTO `groups`(
                    `GroupNickname`, `GroupSubject`,
                    `GroupLocation`, `GroupEndDate`,
                    `GroupOwnerID`,  `GroupStatus`
                )
                VALUES(
                    ?, ?, ?, ?, ?, ?
                );",
                "ssssss", 
                $GroupNickname, $GroupSubject, 
                $GroupLocation, $GroupEndDate, 
                $GroupOwnerID,  $GroupStatus
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }

    public function assignUserToGroup($TargetUserID, $TargetGroupID, $TargetRole, $AssignerID) {
        try {
            return $this->executeStatement4Args(
                "INSERT INTO `group_assignments`(
                    `TargetUserID`,
                    `TargetGroupID`,
                    `TargetRole`,
                    `AssignerID`
                ) VALUES(?, ?, ?, ?);",
                "ssss", 
                $TargetUserID, $TargetGroupID, 
                $TargetRole, $AssignerID
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }

    public function updateStatus($NewStatus, $GroupID) {
        try {
            return $this->executeStatement2Args(
                "UPDATE
                    `groups`
                SET
                    `GroupStatus` = ?
                WHERE
                    `groups`.`GroupID` = ?;",
                "ss", 
                $NewStatus, $GroupID
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }




}
