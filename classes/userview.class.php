<?php 
    class UserView extends User implements LinkUrl {
        public function showUsers() {
            $FunctionsObj = new Functions();
            
            //Check if user logged in, and thus allowed to execute this method.
            $FunctionsObj->checkUserLoggedIn();

            //Get all the users.
            $result = $this->getUsers();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    //Display data.
                    echo "<tr>";
                    echo "<th scope='row'>".$row["row_id"]."</th>";
                    echo "<td>".$row["username"]."</td>";
                    echo "<td>".$row["display_name"]."</td>";
                    echo "<td>";
                    echo "**********";
                    echo "</td>";
                    //Check if user is admin or moderator to show the correct badge.
                    if ($row["function"] == 1) {
                        echo "<td><span class='badge-danger badge'>Admin</span></td>";
                        echo "<td><button class='btn btn-danger btn-sm' disabled>Delete</button></td>";
                    } else {
                        echo "<td><span class='badge-success badge'>Moderator</span></td>";
                        if ($_SESSION["userFunction"] == 1) {
                            echo "<td><button class='btn btn-danger btn-sm' onclick='askDeleteUser(".$row['row_id'].")'>Delete</button></td>";
                        } else {
                            echo "<td><button class='btn btn-danger btn-sm' disabled>Delete</button></td>";
                        }
                    }
                    echo "</tr>";
                }
            }
        }//Method Users.

        public function showUserName() {
            $FunctionsObj = new Functions();

            //Check if user logged in, and thus allowed to execute this method.
            $FunctionsObj->checkUserLoggedIn();

            //Get username.
            $result = $this->getUserName($_SESSION["userID"]);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["display_name"];
                }
            }
        }//Method getUserName.
    }
    
?>