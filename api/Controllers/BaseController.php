<?php
class BaseController {
    public $testEnv;
    public $buffer;

    // Class constructer with a built in test script.
    public function __construct() {

    }

    // Return 404 when a gateway doesnt exist. 
    public function __call($name, $arguments) {
        $this->sendJSON(`{"status_code": "404 Not Found", "reason": "'$name' Doesnt Exist" }`, array('HTTP/1.1 404 Not Found'));
    }
    
    /**
     * Send API Responce as JSON.
     *
     * @param mixed  $responce
     * @param string $extraHeaders
     */
    protected function sendJSON($responce, $extraHeaders=array()) {
        // Declare responce as json
        header('Content-type: application/json');
        
        // Loop though the extraHeaders array and add them one at a time.
        if (is_array($extraHeaders) && count($extraHeaders) > 0) {
            foreach ($extraHeaders as $extraHeader) {
                header($extraHeader);
            }
        }
        
        // Call the proxy functions as this is user output
        echo($responce);
        exit();
    }
}