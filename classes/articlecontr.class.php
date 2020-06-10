<?php  

    class ArticleContr extends Article implements LinkUrl{

        //Publish a saved article.
        public function publishArticle($articleID,$aSelectedChannels) {
            $FunctionsObj = new Functions();

            //Check if user logged in, and thus allowed to execute this method.
            $FunctionsObj->checkUserLoggedIn();

            //Validation.
            if (!$FunctionsObj->isInteger($articleID) || !$FunctionsObj->isInteger($aSelectedChannels[0])) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }

            //Real escape string.
            $articleID = $this->connect()->real_escape_string($articleID);
            //$aSelectedChannels = $this->connect()->real_escape_string($aSelectedChannels);
            
            //Execute sql (change article table).
            $result = $this->reSetArticle($articleID,1);
            if ($result) {
                echo $FunctionsObj->outcomeMessage("success","The article has successfully been published.");
            } else {
                echo $FunctionsObj->outcomeMessage("error","Failed to publish the article.");
            }//If $result.

            //Execute sql (change articlechannel table).
            if ($aSelectedChannels[0] != "empty") {
                for ($i=0; $i < count($aSelectedChannels); $i++) { 
                    $aChannelInfo = explode(',',$aSelectedChannels[$i]);
                    if($this->setArticleChannel($articleID,$aChannelInfo[0])) {
                    } else {
                        echo $FunctionsObj->outcomeMessage("error","Failed to publish article on all channels.");
                        return false;
                    }
                }
                echo $FunctionsObj->outcomeMessage("success","Article has been published on all selected channels.");
            }
        }//Method publishArticle.

        public function unpublishArticle($articleID,$aSelectedChannels) {
            $FunctionsObj = new Functions();

            //Check if user logged in, and thus allowed to execute this method.
            $FunctionsObj->checkUserLoggedIn();

            //Validation.
            if (!$FunctionsObj->isInteger($articleID) || !$FunctionsObj->isInteger($aSelectedChannels[0])) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }

            //Real escape string.
            $articleID = $this->connect()->real_escape_string($articleID);

            //Check if article is not published on any media then delete article on website.
            $ChannelViewObj = new ChannelView();
            if (!$ChannelViewObj->articleViewGetPublishedMedia($articleID)->num_rows > 0) {
                
                //Execute sql (set published to 0 in article table).
                $result = $this->reSetArticle($articleID,0);
                if ($result) {
                    echo $FunctionsObj->outcomeMessage("success","The article has successfully been unpublished.");
                } else {
                    echo $FunctionsObj->outcomeMessage("error","Failed to unpublish the article.");
                }//If $result.
            }

            //Delete article on all published media.
            if ($aSelectedChannels[0] != "empty") {
                for ($i=0; $i < count($aSelectedChannels); $i++) { 
                    $aChannelInfo = explode(',',$aSelectedChannels[$i]);
                    $result = $this->unSetArticleChannel($articleID,$aChannelInfo[0]);
                    if($result) {
                    } else {
                        echo $FunctionsObj->outcomeMessage("error","Failed to unpublish articles on all channels.");
                        return false;
                    }
                }
                echo $FunctionsObj->outcomeMessage("success","Deleted article on all selected channels.");
            }
        }//Method unpublishArticle.
        
        //Delete Article.
        public function deleteArticle($articleID) {
            $FunctionsObj = new Functions();

            //Check if user logged in, and thus allowed to execute this method.
            $FunctionsObj->checkUserLoggedIn();

            //Validation.
            if (!$FunctionsObj->isInteger($articleID)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameter, is not an integer.");
                return false;
            }
            //Check if article is published on any channel.
            $ChannelViewObj = new ChannelView();
            if ($ChannelViewObj->articleViewGetPublishedMedia($articleID)->num_rows > 0) {
                echo $FunctionsObj->outcomeMessage("error","Article needs te be unpublished on all media channels before you can delete the article.");
                return false;
            }

            //Real escape string.
            $articleID = $this->connect()->real_escape_string($articleID);

            //Execute sql.
            $result = $this->unSetArticle($articleID);
            if ($result) {
                echo $FunctionsObj->outcomeMessage("success","Article has successfully been deleted.");
            } else {
                echo $FunctionsObj->outcomeMessage("error","Failed to delete article.");
            }
        }//Method deleteArticle.

        public function getArticleID($articleLink) {
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["a_row_id"];
                }
            }
        }//Method getArticleTitle.

        public function getArticleTitle($articleLink) {
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["a_title"];
                }
            }
        }//Method getArticleTitle.

        public function getArticleSummary($articleLink) {
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["a_abstract"];
                }
            }
        }//Method getArticleTitle.

        public function getArticleContent($articleLink) {
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["a_content"];
                }
            }
        }//Method getArticleTitle.

        public function getArticleSigner($articleLink) {
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["a_signed_by"];
                }
            }
        }//Method getArticleTitle.

        public function getArticleCatID($articleLink) {
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["c_row_id"];
                }
            }
        }//Method getArticleCatID.

        public function getArticleSubcatID($articleLink) {
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["s_row_id"];
                }
            }
        }//Method getARticleSubcat.


    }//ArticleContr.


?>