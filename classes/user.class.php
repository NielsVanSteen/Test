<?php 
    //User.
    class User extends Dbh implements LinkUrl {

        protected function login($username,$password) {
            $conn = $this->connect();
            $sql = "SELECT * FROM user WHERE username=? AND password=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("ss",$username, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method login. 

        public function getUsers() {
            $conn = $this->connect();
            $sql = "SELECT * FROM user";
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method getUsers.

        public function insertUser($username,$displayname,$password) {
            $conn = $this->connect();
            $sql = "INSERT INTO user (username, password, display_name, function)
            VALUES (?, ?, ?, '0')";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("sss",$username, $password, $displayname);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method inertUser.

        protected function getCurUser($userID,$password) {
            $conn = $this->connect();
            $sql = "SELECT * FROM user WHERE row_id=? AND password=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("is",$userID, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method getUser.

        protected function reSetPassword($newPassword,$userID) {
            $conn = $this->connect();
            $sql = "UPDATE user SET password=? WHERE row_id=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("si",$newPassword, $userID);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method reSetPassword.

        protected function reSetUsername($newUsername,$id) {
            $conn = $this->connect();
            $sql = "UPDATE user SET username=? WHERE row_id=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("si",$newUsername, $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method reSetUsername.

        protected function reSetDisplayname($newDisplayname,$id) {
            $conn = $this->connect();
            $sql = "UPDATE user SET display_name=? WHERE row_id=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("si",$newDisplayname, $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method reSetDisplayname.

        protected function unSetUser($userID) {
            $conn = $this->connect();
            $sql = "DELETE FROM user WHERE row_id=? AND function=0";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("i",$userID);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method unSetUser.

        protected function getUserName($userID) {
            $conn = $this->connect();
            $sql = "SELECT display_name FROM user WHERE row_id=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("i",$userID);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method getUserName.

    }//UserContr.

?>