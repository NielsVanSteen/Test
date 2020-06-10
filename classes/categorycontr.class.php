<?php 
    //CategoryContr.
    class CategoryContr extends Category implements LinkUrl {

        public function createCatSubcat($catSubcatName,$parentID) {
            $FunctionsObj = new Functions();

            //Check if user logged in, and thus allowed to execute this method.
            $FunctionsObj->checkUserLoggedIn();

            //Validation.
            if(!$FunctionsObj->isAlphanumeric($FunctionsObj->stripSpaces($catSubcatName))) {
                echo $FunctionsObj->outcomeMessage("error","'".$catSubcatName."' is not alphanumeric.");
                return false;
            }
            if (!$FunctionsObj->validateLength($catSubcatName,3,30)) {
                echo $FunctionsObj->outcomeMessage("error","'".$catSubcatName."' is too long or short.");
                return false;
            }
            if (!$FunctionsObj->isInteger($parentID)) {
                echo $FunctionsObj->outcomeMessage("error","Parameter is not an integer.");
                return false;
            }

            //Real escape string.
            $catSubcatName = $this->connect()->real_escape_string($catSubcatName);
            $parentID = $this->connect()->real_escape_string($parentID);

            //Execute sql.
            if($this->setCatSubcat($catSubcatName,$parentID)) {
                echo $FunctionsObj->outcomeMessage("success","'".$catSubcatName."' has successfully been added.");
                return false;
            } else {
                echo $FunctionsObj->outcomeMessage("error","Failed to add '".$catSubcatName."'.");
                return false;
            }
        }//Method createCategory.

        public function deleteCatSubcat($id,$catSubcat) {
            $FunctionsObj = new Functions();

            //Check if user logged in, and thus allowed to execute this method.
            $FunctionsObj->checkUserLoggedIn();

            //Validation.
            if (!$FunctionsObj->isInteger($id) || !$FunctionsObj->isInteger($catSubcat)) {
                echo $FunctionsObj->outcomeMessage("error","Parameters aren't integers.");
                return false;
            }

            //Real escape string.
            $id = $this->connect()->real_escape_string($id);
            $catSubcat = $this->connect()->real_escape_string($catSubcat);
   

            //Check if cat is cat or subcat is subcat; 0=cat;1=subcat.
            $WriteCheckCatSubcatObj = new Write();
            switch ($catSubcat) {
                case 0:
                    $result = $WriteCheckCatSubcatObj->checkCatIsCat($id);
                    break;
                case 1:
                    $result = $WriteCheckCatSubcatObj->checkSubcatIsSubcat($id);
                    break;
                default:
                    echo $FunctionsObj->outcomeMessage("error","Parameter should be a boolean.");
                    break;
            }

            //Execute sql.
            if (!$result) {
                echo $FunctionsObj->outcomeMessage("error","Category/subcategory is not a catagory/subcategory..");
                return false;
            }

            //Check if cat has subcats.
            $result = $this->getSubcatsFromParentCat($id);
            if ($result->num_rows > 0) {
                echo $FunctionsObj->outcomeMessage("error","Category has subcategories, first delete all subcategories.");
                return false;
            }

            //Execute sql.
            if ($this->unsetCatSubcat($id)) {
                echo $FunctionsObj->outcomeMessage("success","Record has succesfully been deleted.");
                return false;
            } else {
                echo $FunctionsObj->outcomeMessage("error","Failed to delete record.");
                return false;
            }
        }//Method deleteCategory.

        public function getSubcat($subcatID) {
            $FunctionsObj = new Functions();

            //Validation.
            if (!$FunctionsObj->isInteger($subcatID)) {
                echo $FunctionsObj->outcomeMessage("error","Parameter isn't an integer.");
                return false;
            }
            
            //Real escape string.
            $subcatID = $this->connect()->real_escape_string($subcatID);

            //Execute sql.
            $result = $this->getCategory($subcatID);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["category"];
                }
            }
        }//Method getSubcat.

    }//CategoryContr.

?>