<?php 
    //Database class.
    class Dbh implements DatabaseConst, LinkUrl {
        
        //Connection method.
        protected function connect() {
            $conn = new mysqli(DatabaseConst::SERVERNAME, DatabaseConst::USERNAME, DatabaseConst::PASSWORD, DatabaseConst::DBNAME);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            return $conn;
        }//Connect method.

    }//Db class.
?>