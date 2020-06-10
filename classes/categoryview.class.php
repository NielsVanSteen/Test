<?php 
    //CategoryView.
    class CategoryView extends Category implements LinkUrl {

        public function showCategories() {
            //Execute sql.
            $result = $this->getCategories();
            if ($result->num_rows > 0) {
                echo '<select class="custom-select write-sub-categories-container" id="articleCategory" onchange="ShowSubCategories(this.value)">';
                echo '<option option="undefined" value="undefined" selected disabled>Choose a category</option>';
                while($row = $result->fetch_assoc()) {
                    echo '<option option="'.$row["row_id"].'" value="0,'.$row["row_id"].'"> '.$row["category"].'</option>';
                }//While.
                echo '</select> ';
            } else {
                echo 'no categories';
            }//If.
        }//Method showCategories.

        public function showSubcatFromParentCat($level,$parentID) {
            $FunctionsObj = new Functions();
            
            //Validation.
            if(!$FunctionsObj->isInteger($level) || !$FunctionsObj->isInteger($parentID)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }

            //Real escape string.
            $level = $this->connect()->real_escape_string($level);
            $parent_id = $this->connect()->real_escape_string($parentID);

            //Execute sql.
            $result = $this->getSubcatsFromParentCat($parentID);
            if ($result->num_rows > 0) {
                echo '<h3 class="write-category-title text-primary">Subcategory</h3>';
                echo '<select class="custom-select write-sub-categories-container" id="articleSubcategory" onchange="ShowSubCategories(this.value)">';
                echo '<option option="undefined" selected disabled>Choose a subcategory</option>';
                while($row = $result->fetch_assoc()) {
                    echo '<option option="'.$row["row_id"].'" value="'.($level + 1).','.$row["row_id"].'">'.$row["category"].'</option>';
                }
                echo '</div>';  

            } else {
                echo $FunctionsObj->outcomeMessage("success","All categories and subcategories have been selected.");
                return false;   
            } 
        }//Method showSubcategories.

        public function showCatsAndSubcats() {
            $FunctionsObj = new Functions();
            $row_id = "";

            //Execute sql.
            $result = $this->getCatsAndSubcats();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {

                    //See if category_id from the last record is the same as current category_id.
                    if ($row_id != $row["p_row_id"]) {
                        //If row_id != "", it means we need to close the div of that current category.
                        if ($row_id != "") {
                            echo "<div>";
                            echo "<input class='add-subcategory form-control' id='subcategoryName".$row_id."' type='text'>";
                            echo "<i class='fas fa-check text-success' onclick='AddSubcategory(".$row_id.")'></i>";
                            echo "</div> </div> </div>";
                        }
                        //Ouput the header and category on the screen.
                        echo "<div class='card categories-category-card'>";
                        echo "<div class='card-header bg-secondary text-white'>";
                        echo $row['p_category'];
                        echo "<i class='delete-categories-icon text-white far fa-trash-alt' onclick='AskCategoryDelete(".$row['p_row_id'].",0)'></i><br>";
                        echo "</div>";
                        echo "<div class='card-body text-primary text-left'>"; 

                        //Output the first coresponding subcategory of the category.
                        if ($row["c_category"]) {
                        echo $row['c_category'];
                        echo "<i class='delete-categories-icon text-dark far fa-trash-alt' onclick='AskCategoryDelete(".$row['c_row_id'].",1)'></i><br>"; 
                        }//If.

                    } else {
                        //Output all subcategories on screen (except 1st one, that one is outputted with the category.
                        echo $row['c_category'];
                        echo "<i class='delete-categories-icon text-dark far fa-trash-alt' onclick='AskCategoryDelete(".$row['c_row_id'].",1)'></i><br>";
                    }//If old row_id != current row_id.

                    //Set the row_id to the current row_id.
                    $row_id = $row["p_row_id"];     
                }//While.

            } else {
                echo $FunctionsObj->outcomeMessage("warning","No categories have been found! Create your first.");
                return false;
            }//If Result > 0.

            //Output the last div closing of the category.
            echo "<div>";
            echo "<input class='add-subcategory form-control' id='subcategoryName".$row_id."' type='text'>";
            echo "<i class='fas fa-check text-success' onclick='AddSubcategory(".$row_id.")'></i>";
            echo "</div> </div> </div>";
        }//Method showCatsAndSubcats.
        
        //Shows the subcats from parentcat on index page.
        public function ArticlesShowSubcats($parentID) {
            $FunctionsObj = new Functions();

            //Validation.
            if (!$FunctionsObj->isInteger($parentID)) {
                echo $FunctionsObj->outcomeMessage("error","Parameter is not an integer.");
                return false;
            }

            //Real escape string.
            $parentID = $this->connect()->real_escape_string($parentID);

            //Execute sql.
            $result = $this->getSubcatsFromParentCat($parentID);
            echo "<div class='list-group index-subcategories-listgroup'>";
            echo "<a class='list-group-item list-group-item-action active disabled list-group-items-header'>Categorieën</a>";
            if ($result->num_rows > 0) {
               
                while($row = $result->fetch_assoc()) {
                    echo "<a class='list-group-item list-group-item-action' onclick='showArticlesIndex(".$row["row_id"].",\"".$row['category']."\")'><i class='fa fa-file'></i>&nbsp;".$row['category']."</a>";
                }
            } else {
                echo "<a class='list-group-item list-group-item-action'><i class='fa fa-file'></i>&nbsp;No subcategory has been found.</a>";
            }
            echo "</div>";
        }//Method ArticleShowSubcats.

        public function showCategory($categoryID) {
            $FunctionsObj = new Functions();

            //Validation.
            if (!$FunctionsObj->isInteger($categoryID)) {
                echo $FunctionsObj->outcomeMessage("error","Parameter is not an integer.");
                return false;
            }

            //Real escape string.
            $categoryID = $this->connect()->real_escape_string($categoryID);

            //Execute sql.
            $result = $this->getCategory($categoryID);
            if ($result->num_rows > 0) {
               while($row = $result->fetch_assoc()) {
                   echo $row["category"];
               }
            }
        }//Method getCategory.

        //This method will be used on the digon website to link
        //to my index page.
        public function showLinksToCategories() {
            //Execute sql.
            $result = $this->getCategories();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<a href='index/".$row["row_id"]."'>".$row["category"]."</a>";
                }
            } else {
                echo 'no link were found';
            }//If.
        }//Method showLinkstoCategories.

    }//Class Media.

?>