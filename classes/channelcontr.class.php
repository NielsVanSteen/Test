<?php 
    //ChannelContr.
    Class ChannelContr extends Channel implements LinkUrl {

        public function insertChannel($name,$canUnpublish,$type) {  
            $FunctionsObj = new Functions();

            //Check if user logged in, and thus allowed to execute this method.
            $FunctionsObj->checkUserLoggedIn();

            //Validation.
            if(!$FunctionsObj->isAlphanumeric($FunctionsObj->stripSpaces($name))) {
                echo $FunctionsObj->outcomeMessage("error","'".$name."' is not alphanumeric.");
                return false;
            }
            if ($canUnpublish < 0 || $canUnpublish > 1 || $type < 0 || $type > 2) {
                echo $FunctionsObj->outcomeMessage("error","Select options container unknown values.");
                return false;
            }
            if (!$FunctionsObj->validateLength($name,3,30)) {
                echo $FunctionsObj->outcomeMessage("error","'".$name."' is too long or short.");
                return false;
            }

            //Real escape string.
            $name = $this->connect()->real_escape_string($name);
            $canUnpublish = $this->connect()->real_escape_string($canUnpublish);
            $type = $this->connect()->real_escape_string($type);

            //Execute sql.
            if ($this->setChannel($name,$canUnpublish,$type)) {
                echo $FunctionsObj->outcomeMessage("success","Channel has successfully been added.");
                return false;
            } else {
                echo $FunctionsObj->outcomeMessage("error","Failed to add channel.");
                return false;
            }
        }//Method insertChannel.

        public function deleteChannel($channelID) {
            $FunctionsObj = new Functions();

            //Check if user logged in, and thus allowed to execute this method.
            $FunctionsObj->checkUserLoggedIn();

            //Validation.
            if (!$FunctionsObj->isInteger($channelID)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }

            //Real escape string.
            $channelID = $this->connect()->real_escape_string($channelID);

            //Execute sql.
            if ($this->unSetChannel($channelID)) {
                echo $FunctionsObj->outcomeMessage("success","Channel has successfully been deleted.");
                return false;
            } else {
                echo $FunctionsObj->outcomeMessage("error","Failed to delete channel.");
                return false;
            }
        }//Method deleteChannel.

    }//ChannelContr.
?>