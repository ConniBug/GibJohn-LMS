<?php
class DatabaseHandler {
    // Initial connection var
    protected $connection = null;
 
    // Class constructer.
    public function __construct() {
        $this->openConnection();
    }
 
    public function openConnection() {
        try {
            //echo "Openning sql connection. <br>";
            // Create a connection with the database.
            $this->connection = new mysqli(
                MYSQL_HOST, 
                MYSQL_USERNAME, 
                MYSQL_PASSWORD, 
                MYSQL_DATABASE_NAME
            );
            if ( mysqli_connect_errno())
                throw new Exception("SQL Connect Error: Could not connect to database.");  
        } 
        catch (Exception $err) {
            // If an error has occured throw an exception to the caller
            throw new Exception($err->getMessage());   
        }   
    }

    // A Simple method for submitting select requests
    public function select($query, $types, $params) {
        try {            
            $this->openConnection();
            $stmt = $this->executeStatement($query, $types,  $params);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);               
            $stmt->close();
 
            return $result;
        } catch(Exception $e) {
            // If an error has occured throw an exception to the caller
            throw New Exception( $e->getMessage() );
        }
        return false;
    }

    // A Simple method for submitting select requests
    public function selectBy2($query, $types, $params1, $params2) {
        try {
            $this->openConnection();
            $stmt = $this->executeStatement2Args($query, $types, $params1, $params2);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);               
            $stmt->close();
 
            return $result;
        } catch(Exception $e) {
            // If an error has occured throw an exception to the caller
            throw New Exception( $e->getMessage() );
        }
        return false;
    }

    // A Simple method for submitting querys
    public function query3($query, $types, $param1, $param2, $param3) {
        try {            
            $stmt = $this->executeStatement3Args($query, $types, $param1, $param2, $param3);
            $result = $stmt->get_result(); 
            if($result == false) {
                // echo "ErrNNo: " . $result->errno() "|";
                // throw New Exception( $result->errno() );
                return "FALSE";
            } 
            $result = $result->fetch_all(MYSQLI_ASSOC);  
       
            $stmt->close();

            

            return $result;
        } catch(Exception $e) {
            // If an error has occured throw an exception to the caller
            throw New Exception( $e->getMessage() );
        }
        return false;
    }
 
    // A Simple method for sending querys to the database
    public function executeStatement($query, $types, $params) {
        try {
            $this->openConnection();

            // Prepare sql query
            $sqliStatement = $this->connection->prepare( $query );
            
            // An error occured during query preparation
            if($sqliStatement === false) 
                throw New Exception("Query Prep Failed: $query");
 
            // Bind params to query using types
            if($params && $types != "")
                $sqliStatement->bind_param($types, $params);
 
            // Execute the query
            if(!$sqliStatement->execute())
                throw New Exception("Statement Execution Failed");

            // Return response
            return $sqliStatement;
        } catch(Exception $e) {
            // If an error has occured throw an exception to the caller
            throw New Exception( $e->getMessage() );
        }
    }
    // A Simple method for sending querys to the database with 2 args
    public function executeStatement2Args($query, $types, $params1, $params2) {
        try {
            $this->openConnection();
            $sqliStatement = $this->connection->prepare( $query );
            
            // An error occured during query preparation
            if($sqliStatement === false) 
                throw New Exception("Query Prep Failed: $query");

            // Bind params to query using types
            $sqliStatement->bind_param($types, $params1, $params2);
            
            // Execute the query
            if(!$sqliStatement->execute())
                throw New Exception("Statement Execution Failed");

            // Return response
            return $sqliStatement;
        } catch(Exception $e) {
            // If an error has occured throw an exception to the caller
            throw New Exception( $e->getMessage() );
        }   
    }
    // A Simple method for sending querys to the database with 3 args
    public function executeStatement3Args($query, $types, $params1, $params2, $params3) {
        try {
            $this->openConnection();

            // Prepare sql query
            $sqliStatement = $this->connection->prepare( $query );
            
            // An error occured during query preparation
            if($sqliStatement === false) 
                throw New Exception("Query Prep Failed: $query");

            // Bind params to query using types
            $sqliStatement->bind_param($types, $params1, $params2, $params3);
            
            // Execute the query
            if(!$sqliStatement->execute())
                throw New Exception("Statement Execution Failed");

            // Return response
            return $sqliStatement;
        } catch(Exception $e) {
            // If an error has occured throw an exception to the caller
            throw New Exception( $e->getMessage() );
        }   
    }
    // A Simple method for sending querys to the database with 4 args
    public function executeStatement4Args($query, $types, $params1, $params2, $params3, $params4) {
        try {
            $this->openConnection();

            // Prepare sql query
            $sqliStatement = $this->connection->prepare( $query );
            
            // An error occured during query preparation
            if($sqliStatement === false) 
                throw New Exception("Query Prep Failed: $query");

            // Bind params to query using types
            $sqliStatement->bind_param($types, $params1, $params2, $params3, $params4);
            
            // Execute the query
            if(!$sqliStatement->execute())
                throw New Exception("Statement Execution Failed");

            // Return response
            return $sqliStatement;
        } catch(Exception $e) {
            // If an error has occured throw an exception to the caller
            throw New Exception( $e->getMessage() );
        }   
    }
    // A Simple method for sending querys to the database with 6 args
    public function executeStatement5Args($query, $types, $params1, $params2, $params3, $params4, $params5) {
        try {
            $this->openConnection();

            // Prepare sql query
            $sqliStatement = $this->connection->prepare( $query );
            
            // An error occured during query preparation
            if($sqliStatement === false) 
                throw New Exception("Query Prep Failed: $query");

            // Bind params to query using types
            $sqliStatement->bind_param($types, $params1, $params2, $params3, $params4, $params5);
            
            // Execute the query
            if(!$sqliStatement->execute())
                throw New Exception("Statement Execution Failed");

            // Return response
            return $sqliStatement;
        } catch(Exception $e) {
            // If an error has occured throw an exception to the caller
            throw New Exception( $e->getMessage() );
        }   
    }
    // A Simple method for sending querys to the database with 6 args
    public function executeStatement6Args($query, $types, $params1, $params2, $params3, $params4, $params5, $params6) {
        try {
            $this->openConnection();

            // Prepare sql query
            $sqliStatement = $this->connection->prepare( $query );
            
            // An error occured during query preparation
            if($sqliStatement === false) 
                throw New Exception("Query Prep Failed: $query");

            // Bind params to query using types
            $sqliStatement->bind_param($types, $params1, $params2, $params3, $params4, $params5, $params6);
            
            // Execute the query
            if(!$sqliStatement->execute())
                throw New Exception("Statement Execution Failed");

            // Return response
            return $sqliStatement;
        } catch(Exception $e) {
            // If an error has occured throw an exception to the caller
            throw New Exception( $e->getMessage() );
        }   
    }
}
