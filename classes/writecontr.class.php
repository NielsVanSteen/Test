<?php 
    //Category Class.
    class WriteContr extends Write implements LinkUrl {

        //Properties.
        public $date;

        public function createArticle($articleTitle,$articleSummary,$articleBody,$articleCategory,$articleSubcategory,$articleSigner,$articleURL) {
            $FunctionsObj = new Functions();
            $this->date = date('Y-m-d H:i:s');

            //Check if user logged in, and thus allowed to execute this method.
            $FunctionsObj->checkUserLoggedIn();

            //Validation.
            if (empty($articleTitle) || empty($articleSummary) || empty($articleBody) || empty($articleCategory) || empty($articleSubcategory) || empty($articleURL)) {
                echo $FunctionsObj->outcomeMessage("error","Not all variables contain a value.");
                return false;
            }
            if (is_int($articleCategory) || is_int($articleSubcategory)) { 
                echo $FunctionsObj->outcomeMessage("error","Please select a category and subcategory.");
                return false;
            }
            $result = $this->checkCatIsCat($articleCategory);
            if ($result->num_rows <= 0) {
                echo $FunctionsObj->outcomeMessage("error","Selected category is not a valid category.");
                return false;
            }
            $result = $this->checkSubcatIsSubcat($articleSubcategory);
            if ($result->num_rows <= 0) {
                echo $FunctionsObj->outcomeMessage("error","Selected subcategory is not a valid category.");
                return false;
            }

            //Real escape string.
            $articleTitle = $this->connect()->real_escape_string($articleTitle);
            $articleSummary = $this->connect()->real_escape_string($articleSummary);
            $articleBody = $this->connect()->real_escape_string($articleBody);
            $articleCategory = $this->connect()->real_escape_string($articleCategory);
            $articleSubcategory = $this->connect()->real_escape_string($articleSubcategory);
            $articleSigner = $this->connect()->real_escape_string($articleSigner);
            $articleURL = $this->connect()->real_escape_string($articleURL);

            //Execute sql.
            if($this->setArticle($articleTitle,$this->date,$articleSummary,$articleBody, $articleCategory, $articleSubcategory, $articleSigner, $FunctionsObj->replaceSpaces(strtolower($articleURL)))) {
                echo $FunctionsObj->outcomeMessage("success","Article has successfully been saved.");
            } else {
                echo $FunctionsObj->outcomeMessage("success","Failed to save article.");
            }
        }//Method createArticle.

        public function saveEditArticle($articleTitle,$articleSummary,$articleBody,$articleSigner,$articleURL,$link) {
            $FunctionsObj = new Functions();

            //Check if user logged in, and thus allowed to execute this method.
            $FunctionsObj->checkUserLoggedIn();
         
            //Validation
            if (empty($articleTitle) || empty($articleSummary) || empty($articleBody) || empty($articleSigner || empty($articleURL))) {
                echo $FunctionsObj->outcomeMessage("error","Not all variables contain a value.");
                return false;
            }

            //Real escape string.
            $articleTitle = $this->connect()->real_escape_string($articleTitle);
            $articleSummary = $this->connect()->real_escape_string($articleSummary);
            $articleBody = $this->connect()->real_escape_string($articleBody);
            $articleSigner = $this->connect()->real_escape_string($articleSigner);
            $articleURL = $this->connect()->real_escape_string($articleURL);
            $link = $this->connect()->real_escape_string($link);

            //Article saved.
            if($this->reSetArticle($articleTitle,$articleSummary,$articleBody,$articleSigner,$FunctionsObj->replaceSpaces(strtolower($articleURL)),$link)) {
                echo $FunctionsObj->outcomeMessage("success","Article has successfully been edited.");
            } else {
                echo $FunctionsObj->outcomeMessage("success","Failed to edit article.");
            }
        }//Method saveEditArticle.

    }//Class WriteContr.

?>