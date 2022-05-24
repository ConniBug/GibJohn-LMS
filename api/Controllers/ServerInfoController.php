<?php

class ServerInfoController extends BaseController
{
    /** 
     *  /api/serverinfo - Endpoint - Return api info.
     */
    public function handle() {
        try {
            $tmpArray = array( );
            $tmpArray["Name"] = "GibJohn Tutoring API";   
            $tmpArray["Type"] = "Restfull API";   
            $tmpArray["Version"] = "0.0.0.1b";   
            $tmpArray["Publicly Facing"] = "false";   

            // Convert the data into JSON
            $jsonEncoded = json_encode($tmpArray);

            // Send the responce as JSON
            $this->sendJSON($jsonEncoded, array('HTTP/1.1 200 Ok'));
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            echo $strErrorDesc;
        }
    }
}