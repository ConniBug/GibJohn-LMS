<?php
require_once __DIR__ . "/DatabaseHandler.php";

class UnitModel extends DatabaseHandler {    
    public function __construct() {
        try {

        } 
        catch (Exception $err) {
            // If an error has occured throw an exception to the caller
            throw new Exception($err->getMessage());   
        }           
    }

    public function createNewUnit(
                        $UnitGroupID, $UnitTopic, 
                        $UnitOrderIndex, $UnitFinishDate) {
        try {
            return $this->executeStatement4Args(
                "INSERT INTO `units` 
                        (`UnitGroupID`, `UnitTopic`, `UnitOrderIndex`, `UnitFinishDate`) 
                VALUES 
                        (?, ?, ?, ?)", 
                "ssss", 
                $UnitGroupID, $UnitTopic, 
                $UnitOrderIndex, $UnitFinishDate
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    } 


    public function getWorkResourcesByUnitID($UnitID) {
        try {
            return json_decode(json_encode($this->select(
                "SELECT
                    `unit_resources`.`UnitResourceName`,
                    `documents`.`DocumentName`,
                    `unit_resources`.`UnitResourceUploadDate`
                FROM
                    `unit_resources`
                LEFT JOIN `documents` ON `unit_resources`.`UnitResourceDocumentID` = `documents`.`DocumentID`
                WHERE
                    `documents`.`DocumentID` = `unit_resources`.`UnitResourceDocumentID` AND `unit_resources`.`UnitResourceUnitID` = ?;", 
                "s", 
                $UnitID
            )));
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    } 
}
