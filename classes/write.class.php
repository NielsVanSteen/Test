<?php 
    //Write Class.
    class Write extends Dbh implements LinkUrl {

        protected function setArticle($articleTitle,$date,$articleSummary,$articleBody,$articleCategory,$articleSubcategory,$articleSigner,$articleURL) {
            $conn = $this->connect();
            $user = $_SESSION["userID"];
            $sql = "INSERT INTO article (author_id, creation_time, published, deleted, title, content, abstract, category_id, subcategory_id, signed_by, link)
            VALUES (?, ?, 0, 0, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("issssiiss",$user, $date, $articleTitle, $articleBody, $articleSummary, $articleCategory, $articleSubcategory, $articleSigner, $articleURL);
            return $stmt->execute();
        }//Method setArticle.

        protected function reSetArticle($articleTitle,$articleSummary,$articleBody,$articleSigner,$articleURL,$link) {
            $conn = $this->connect();
            $sql = "UPDATE article SET title=? ,content=? ,abstract=? ,signed_by=? ,link=? WHERE link=?";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("ssssss",$articleTitle, $articleBody, $articleSummary, $articleSigner, $articleURL, $link);
            $stmt->execute();
            return $stmt->get_result();
        }//Method reSetArticle.

        public function checkCatIsCat($articleCategory) {
            $conn = $this->connect();
            $sql = "SELECT * FROM category WHERE row_id=? AND parent_id=0";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("i",$articleCategory);
            $stmt->execute();
            return $stmt->get_result();
        }//Method checkCatIsCat.

        public function checkSubcatIsSubcat($articleSubcategory) {
            $conn = $this->connect();
            $sql = "SELECT * FROM category WHERE row_id=? AND parent_id !=0";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("i",$articleSubcategory);
            $stmt->execute();
            return $stmt->get_result();
        }//Method checkSubcatIsSubcat.

    }//Class Write.

?>