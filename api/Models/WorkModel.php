<?php
require_once __DIR__ . "/DatabaseHandler.php";

class WorkModel extends DatabaseHandler {    
    public function __construct() {
        try {

        } 
        catch (Exception $err) {
            // If an error has occured throw an exception to the caller
            throw new Exception($err->getMessage());   
        }           
    }

    public function getWork() {
        try {
            return $this->select(
                "SELECT * FROM `work`", 
                "", 
                ""
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }
    
    public function getWorkByUnitID($UnitID) {
        try {
            $result = $this->select(
                "SELECT * FROM `work` WHERE `WorkUnitID` = ?", 
                "s", 
                $UnitID
            );
            return json_decode(json_encode($result));

        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }
    
    public function getWorkByID($WorkID) {
        try {
            $result = $this->select(
                "SELECT * FROM `work` WHERE `WorkID` = ?", 
                "s", 
                $WorkID
            );
            return json_decode(json_encode($result));

        } catch(Exception $e) {
            echo("getWorkByID:" . $e->getMessage());
            return;
        }
    }
    
    public function deleteWorkByID($WorkID) {
        try {
            $result = $this->executeStatement(
                "DELETE FROM `work` WHERE `WorkID` = ?", 
                "s", 
                $WorkID
            );
            return json_decode(json_encode($result));

        } catch(Exception $e) {
            echo("deleteWorkByID:" . $e->getMessage());
            return;
        }
    }

    public function createNewSubmission($SubmitterID, $SubmissionWorkID, $SubmittedDocumentID) {
        try {
            return $this->executeStatement3Args(
                "INSERT INTO 
                    `submissions` (`SubmitterID`, `SubmissionWorkID`, `SubmittedDocumentID`) 
                 VALUES 
                    (?, ?, ?)", 
                "sss", 
                $SubmitterID, $SubmissionWorkID, $SubmittedDocumentID
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    } 

    public function getUsersWorkSubmission($WorkUnitID, $UserID) {
        try {
            $res = $this->executeStatement2Args(
                "SELECT `work`.* , `documents`.*, `submissions`.* FROM `work`, `documents` 
                
                LEFT JOIN `submissions` 
                    ON `submissions`.`SubmittedDocumentID` = `documents`.`DocumentID`
                WHERE 
                    `work`.`WorkID` = ? AND 
                    `submissions`.`SubmissionWorkID` = `work`.`WorkID` AND 
                    `submissions`.`SubmitterID` = ? AND 
                    `documents`.`DocumentID` = `submissions`.`SubmittedDocumentID`;", 
                "ss", 
                $WorkUnitID, $UserID
            );
            $result = $res->get_result(); 
            if($result == false) {
                return "FALSE";
            } 
            $result = $result->fetch_all(MYSQLI_ASSOC);  
            $res->close();

            return json_decode(json_encode($result));
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    } 

    public function amountOfPossibleWorkForUnit($WorkUnitID) {
        try {
            $res = $this->executeStatement(
                "SELECT
                    COUNT(`work`.`WorkID`) AS Count
                FROM
                    `work`
                WHERE
                    `work`.`WorkUnitID` = ?;
                ", 
                "s", 
                $WorkUnitID
            );
            $result = $res->get_result(); 
            if($result == false) {
                return "FALSE";
            } 
            $result = $result->fetch_all(MYSQLI_ASSOC);  
            $res->close();

            return json_decode(json_encode($result));
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }

    public function amountOfWorkSubmittedByUserForUnitID($UserID, $WorkUnitID) {
        try {
            $res = $this->executeStatement2Args(
                "SELECT
                    COUNT(`work`.`WorkID`) AS Count
                FROM
                    `work`,
                    `documents`
                LEFT JOIN `submissions` ON `submissions`.`SubmittedDocumentID` = `documents`.`DocumentID`
                WHERE
                    `submissions`.`SubmissionWorkID` = `work`.`WorkID` AND 
                    `submissions`.`SubmitterID` = ? AND 
                    `work`.`WorkUnitID` = ? AND 
                    `documents`.`DocumentID` = `submissions`.`SubmittedDocumentID`;
                ", 
                "ss", 
                $UserID, $WorkUnitID
            );
            $result = $res->get_result(); 
            if($result == false) {
                return "FALSE";
            } 
            $result = $result->fetch_all(MYSQLI_ASSOC);  
            $res->close();

            return json_decode(json_encode($result));
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    } 

    public function createNewWork($WorkTitle, $WorkDescription, $WorkDeadline, $WorkRewardPoints, $WorkUnitID) {
        try {
            return $this->executeStatement5Args(
                "INSERT INTO `work` 
                        (`WorkTitle`, `WorkDescription`, `WorkDeadline`, `WorkRewardPoints`, `WorkUnitID`) 
                VALUES 
                        (?, ?, ?, ?, ?);", 
                "sssss", 
                $WorkTitle, $WorkDescription, $WorkDeadline, $WorkRewardPoints, $WorkUnitID
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    } 
}
