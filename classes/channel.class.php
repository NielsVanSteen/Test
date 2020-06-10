<?php 
    Class Channel extends Dbh implements LinkUrl {

        //Get all media channels.
        protected function getNonPublishedChannels($articleID) {
            $conn = $this->connect();
            $sql = "SELECT row_id, name, type FROM channel WHERE NOT EXISTS (
            SELECT NULL
            FROM articlechannel
            WHERE articlechannel.channel_id = channel.row_id AND articlechannel.article_id=?)";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("i", $articleID);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//getNonPublishedChannels.

        protected function getPublishedChannels($articleID) {
            $conn = $this->connect();
            $sql = "SELECT c.row_id AS c_row_id, c.name AS c_name, c.type AS c_type  FROM articlechannel ac
            LEFT JOIN channel c ON ac.channel_id=c.row_id
            WHERE ac.article_id=? AND c.can_unpublish=1";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("i", $articleID);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method getPublishedChannels.

        protected function getMediaChannels() {
            $conn = $this->connect();
            $sql = "SELECT * FROM channel";
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//GetMediaChannels.

        protected function setChannel($name,$canUnpublish,$type) {
            $conn = $this->connect();
            $sql = "INSERT INTO channel (name, can_unpublish, type)
            VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("sii", $name, $canUnpublish, $type);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method setChannel.

        protected function unSetChannel($channelID) {
            $conn = $this->connect();
            $sql = "DELETE FROM channel WHERE row_id=? AND type=2";
            $stmt = $conn->prepare($sql); 
            $stmt->bind_param("i", $channelID);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }//Method unSetchannel.

    }//Channel.
?>