<?php 
    //Functions.
    class Functions implements LinkUrl {

        public function isAlphanumeric($value) {
            return ctype_alnum($value);
        }//Method isAlphanumeric.

        public function stripAlphaNumeric($value) {
            return str_replace(array('.','/','_'), '',$value);
        }//Method stripAlphaNumeric.

        public function stripSpaces($value) {
            return str_replace(' ', '', $value);
        }//Method stripSpaces.

        public function replaceSpaces($value) {
            return str_replace(' ', '-', $value);
        }//Method replaceSpaces.

        public function stripUnderscores($value) {
            return str_replace('_', '', $value);
        }//Method stripUnderscores.
        
        public function validateLength($value,$min,$max) {
            if (strlen($value) < $min || strlen($value) > $max) {
                return false;
            } else {
                return true;
            }//If.
        }//Method validateLength.
        
        public function isInteger($value) {
           return is_int((int)$value);
        }//Method isInteger.

        public function path($value) {
            return "../". str_replace(',', '/', $value);
        }//Method path.

        public function outcomeMessage($outcome,$message) {
            if ($outcome === "success") {
               echo "<p class='alert alert-success' role='alert'>".$message."</p>";
            } else if($outcome === "error") {
                echo "<p class='alert alert-danger' role='alert'>".$message."</p>";
            } else {
                echo "<p class='alert alert-warning' role='alert'>".$message."</p>";
            }
        }//Method outcomeMessage.

        public function checkUserLoggedIn() {
            if (isset($_SESSION["userID"])) {
                return true;
            } else {
                die($this->outcomeMessage("error","You are not authorized the execute this command."));
            }
        }//Method checkUserLoggedIn.

    }//Functions.
?>