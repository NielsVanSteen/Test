<?php 
    class ArticleView extends Article implements LinkUrl {

        public function showArticle($visibility,$sort,$keyword,$limit) {
            $FunctionsObj = new Functions();

            //Real escape string.
            $visibility = $this->connect()->real_escape_string($visibility);
            $sort = $this->connect()->real_escape_string($sort);
            $keyword = $this->connect()->real_escape_string($keyword);
            $limit = $this->connect()->real_escape_string($limit);

            //Execute sql.
            $result = $this->getArticles($visibility,$sort,$keyword,$limit);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="card calendar-article-container">';
                    echo '<div class="card-header">';
                    echo '<p class="calendar-article-header-title text-primary">'.$row["a_title"].'</p>';
                    echo '</div>';
                    echo '<div class="card-body calendar-article-card-body">';
                    echo '<p class="card-text">'.$row["a_abstract"].'</p>';
                    echo '<div class="calendar-article-card-inner-body">';
                    echo '<p class="calendar-article-card-inner-body-text text-primary">'.$row["u_displayname"].'</p>';
                    echo '<p class="calendar-article-card-inner-body-text text-secondary">'.$row["a_creation_time"].'</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="card-footer calendar-article-card-footer bg-white">';
                    echo '<ol class="breadcrumb calendar-article-breadcrumb-category bg-white">';
                    echo '<li class="breadcrumb-item">'.$row["c_category"].'</li>';
                    echo '<li class="breadcrumb-item text-secondary">'.$row["s_category"].'</li>';
                    echo '<div class="testerr">';
                    if ($row["a_deleted"] == 0) {
                        echo '<button class="btn btn-danger calendar-article-button delete-button" onclick="askDeleteArticle('.$row["a_row_id"].')" type="button"><i class="fas fa-trash-alt"></i></button>';
                        echo '<button class="btn btn-secondary calendar-article-button edit-button" onclick="editArticle(\''.$row["a_link"].'\')" type="button"><i class="fas fa-edit"></i></button>';
                        //Check if there are media channels the article can be published/unbpublished on and thus don't show publish/unpublish button if not necessary.
                        $ChannelViewObj = new ChannelView();
                        if ($ChannelViewObj->articleViewGetPublishedMedia($row["a_row_id"])->num_rows > 0) {
                            echo '<button class="btn btn-primary calendar-article-button unpublish-button" onclick="askUnpublishArticle('.$row["a_row_id"].')" type="button">
                              <i class="fas fa-upload"></i><i class="fas fa-ban"></i></button>';  
                        } else {
                            if ($row["a_published"] == 1) {
                                echo '<button class="btn btn-primary calendar-article-button unpublish-button" onclick="askUnpublishArticle('.$row["a_row_id"].')" type="button">
                                <i class="fas fa-upload"></i><i class="fas fa-ban"></i></button>';  
                            }
                        }
                        if ($ChannelViewObj->articleViewGetNonPublishedMedia($row["a_row_id"])->num_rows > 0) {
                            echo '<button class="btn btn-primary calendar-article-button publish-button" onclick="askPublishArticle('.$row["a_row_id"].')" type="button"><i class="fas fa-upload"></i></button>';
                        }
                    } else {
                        echo '<button class="btn btn-danger calendar-article-publish-button" type="button" disabled>Deleted</button>'; 
                    }
                    echo '</div>';
                    echo '</ol>';
                    echo '</div>';
                    echo '</div>';

                    //add facebook and linkedin share button. 
                    echo "<a target='_blank' id='fb-share-".$row["a_row_id"]."' 
                    href='https://www.facebook.com/sharer/sharer.php?u=https://".LinkUrl::LINKURL."pages/article/".$row["a_link"]."' class='d-none'></a>";
                    echo "<a target='_blank' id='linkedin-share-".$row["a_row_id"]."'
                    href='https://www.linkedin.com/sharing/share-offsite/?url=".LinkUrl::LINKURL."pages/article".$row["a_link"]."' class='d-none'>Share</a>";
                    echo "<a target='_blank' id='twitter-share-".$row["a_row_id"]."' href='http://www.twitter.com/share?url=https://".LinkUrl::LINKURL."pages/article".$row["a_link"]."' class='d-none'>Tweet</a>";

                }
                //Display load more button.
                echo "<div class='calendar-load-more'>";
                echo "<button class='btn btn-info' onclick='calendarLoadMoreArt()'>Load More</button>";
                echo "</div>";
            } else {
                echo $FunctionsObj->outcomeMessage("warning","No articles were found.");
            }
        }//Method showArticles.
        
        public function showArticlesIndex($subcatID) {
            $FunctionsObj = new Functions();

            //Validation.
            if(!$FunctionsObj->isInteger($subcatID)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }

            //Real escape string.
            $subcatID = $this->connect()->real_escape_string($subcatID);

            //Output data.
            $result = $this->getArticleFromSubcat($subcatID);
            
            if ($result->num_rows > 0) {
                echo "<table class='table-articles-overview'> ";
                
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>";
                    echo "<a href='".LinkUrl::LINKURL."article/".$row['a_link']."'>".$row["a_title"]."</a>";
                    echo "<div class='table-articles-admin-icons'>";
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                    $teller = true;
                }//While.
                echo "</table>";
                
            } else {
                 echo $FunctionsObj->outcomeMessage("warning","Er zijn geen artikels gevonden voor deze subcategorie.");
            }
        }//Method showArticlesIndex.
        
        public function showRelevantArticles($subcatID,$articleID) {
            $FunctionsObj = new Functions();
            
            //Validation.
            if(!$FunctionsObj->isInteger($subcatID)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }

            //Real escape string.
            $subcatID = $this->connect()->real_escape_string($subcatID);
            $articleID = $this->connect()->real_escape_string($articleID);
            
            //Execute sql.
            $result = $this->getArticleFromSubcat($subcatID);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    //Check if record is current article. If so highlight it.
                    if ($articleID == $row["a_row_id"]) {
                        echo "<a href='".LinkUrl::LINKURL."article/".$row['a_link']."' class='list-group-item list-group-item-action list-group-item-secondary'>".$row['a_title']."</a>";
                    } else {
                        echo "<a href='".LinkUrl::LINKURL."article/".$row['a_link']."' class='list-group-item list-group-item-action'>".$row['a_title']."</a>";
                    }
                }
            } else {
               echo " <a class='list-group-item list-group-item-action'>No articles found.</a>"; 
            }
        }//Method showRelevantArticles.
        
        public function showFullArticle($articleLink) {
            $FunctionsObj = new Functions();

            //Real escape string.
            $articleLink = $this->connect()->real_escape_string($articleLink);
            
            //Execute sql.
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {

                    //Check if article has been deleted.
                    if ($row["a_deleted"] == 1) {
                        $FunctionsObj->outcomeMessage('error',"Article has been deleted.");
                        return false;
                    }
                    echo "<h1 class='articles-article-title'>".$row['a_title']."</h1>";
                    
                    /*echo "<article class='articles-article-summary'>";
                    echo "<strong>".$row["a_abstract"]."</strong>";
                    echo "</article>";*/
                    
                    echo " <article class='articles-article-content'>";
                    echo $row['a_content'];
                    echo "</article>";
                    
                    echo " <article class='articles-article-info'>";
                    echo "<p>".$row['a_signed_by']."</p>";
                    echo "<p>".$row['a_creation_time']."</p>";
                    echo "</article>";
                }
            } else {
                $FunctionsObj->outcomeMessage("warning","No articles have been found");
            }
        }//Method showFullArticle.

        public function showArtchanArticlesXml($channelID) {
            $FunctionsObj = new Functions();
        
            //Validation.
            if(!$FunctionsObj->isInteger($channelID)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }

            //Real escape string.
            $channelID = $this->connect()->real_escape_string($channelID);
            
            //Execute sql.
            $result = $this->getArticleChannel($channelID);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<item xmlns:dc='ns:1'>" . PHP_EOL;
                    echo "<title>".$row["a_title"]."</title>" . PHP_EOL;
                    echo "<link>".LinkUrl::LINKURL."article/".$row["a_link"]."</link>" . PHP_EOL;
                    echo "<guid>".$row["c_row_id"]."</guid>" . PHP_EOL;
                    echo "<pubdate>".$row["c_published_date"]."</pubdate>" . PHP_EOL;
                    echo "<dc:creator>".$row["a_signed_by"]."</dc:creator>" . PHP_EOL;
                    echo "<description>".$row["a_abstract"]."</description>" . PHP_EOL;

                    //Get article content.
                    $content = $row["a_content"];

                    //Check if article has an image.
                    if (stripos($content,'class="articles-article-img" src="')) {
                        //Split on image tag (class + name + source).
                        $aContent = explode('class="articles-article-img" src="',$content);

                        //extract image url. 
                        //1: get only the entire image url. 
                        //2:split on assets (=get url only after in assets folder.) (reasons for this = url before assets changes = unpredictable what is can be.) 
                        //3: php dirname(file) + assets folder + img url in assets.)
                        $aImage = explode('"',$aContent[1]);
                        $aImage2 = explode('assets',$aImage[0]);
                        $image =  dirname(__FILE__)."/../assets".$aImage2[1];

                    } else {
                        //Take standard image.
                        $image = dirname(__FILE__)."/../images/no_image.png";
                    }

                    //Get image information.
                    $imageSize = filesize($image);
                    $aImageMime = getimagesize($image);
                    $imageMime = $aImageMime["mime"];

                    echo "<enclosure url='".$image."' length='".$imageSize."' type='".$imageMime."'></enclosure>" . PHP_EOL;
                    echo "<category>".$row["cat_category"]."</category>" . PHP_EOL;
                    echo "</item>" . PHP_EOL;
                }
            }
        }//Method showArtchanArticlesXml
        
    }//ArticleContr.

?>