<?php
require_once __DIR__ . "/DatabaseHandler.php";

class DocumentModel extends DatabaseHandler {    
    public function __construct() {
        try {

        } 
        catch (Exception $err) {
            // If an error has occured throw an exception to the caller
            throw new Exception($err->getMessage());   
        }           
    }

    public function getDocuments() {
        try {
            return $this->select(
                "SELECT * FROM `documents`", 
                "", 
                ""
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    }       
    
    public function getDocumentByID($DocumentID) {
        try {
            $result = $this->select(
                "SELECT * FROM `documents` WHERE `DocumentID` = ?", 
                "s", 
                $DocumentID
            );
            return json_decode(json_encode($result));

        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    } 

    public function uploadNewDocument($DocumentName, $DocumentOwnerID, $DocumentPublic) {
        try {
            return $this->executeStatement3Args(
                "INSERT INTO 
                    `documents` (`DocumentName`, `DocumentOwnerID`, `DocumentPublic`) 
                 VALUES 
                    (?, ?, ?)", 
                "sss", 
                $DocumentName, $DocumentOwnerID, $DocumentPublic
            );
        } catch(Exception $e) {
            echo($e->getMessage());
            return;
        }
    } 
}
