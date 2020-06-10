<?php 
    //Category Class.
    class Category extends Dbh implements LinkUrl {

        protected function getCategories() {
            $conn = $this->connect();
            $sql = "SELECT * FROM category WHERE parent_id=0";
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method getCategories.

        protected function getCategory($categoryID) {
            $conn = $this->connect();
            $sql = "SELECT * FROM category WHERE row_id=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("i", $categoryID);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method getCategory.

        protected function getSubcatsFromParentCat($parent_id) {
            $conn = $this->connect();
            $sql = "SELECT * FROM category WHERE parent_id=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("i", $parent_id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method getCategories.

        protected function getCatsAndSubcats() {
            $conn = $this->connect();
            $sql = "SELECT p.row_id AS p_row_id, p.category AS p_category, p.parent_id AS p_parent_id, c.row_id AS c_row_id, c.category AS c_category, c.parent_id AS c_parent_id 
            FROM category p LEFT JOIN category c
            ON p.row_id = c.parent_id WHERE p.parent_id=0 ORDER BY p.row_id ASC, c.row_id ASC";
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method getCatsAndSubcats.

        protected function setCatSubcat($categoryName,$parent_id) {
            $conn = $this->connect();
            $sql = "INSERT INTO category (category, parent_id)
            VALUES (?, ?)";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("si", $categoryName, $parent_id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method setCategory.

        protected function unsetCatSubcat($id) {
            $conn = $this->connect();
            $sql = "DELETE p FROM category p LEFT JOIN category c ON p.row_id = c.parent_id WHERE p.row_id=? OR p.parent_id=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("ii", $id, $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method unsetCatSubcat.

    }//Class Category.

?>