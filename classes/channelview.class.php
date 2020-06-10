<?php 
    //Channel.
    Class ChannelView extends channel implements LinkUrl {
         //Show all media channels.
         public function showMediaChannels() {
            $FunctionsObj = new Functions();

            //Execute sql.
            $result = $this->getMediaChannels();
            if ($result->num_rows > 0) {
                echo "<tr>";
                echo " <th>#</th>";
                echo "<th>Channel</th>";
                echo "<th>Unpublish</th>";
                echo "<th>Type</th>";
                echo "<th>Actions</th>";
                echo "</tr>";

                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['row_id']."</td>";
                    echo "<td>".$row['name']."</td>";

                    //Select correct badge, unpublish.
                    if ($row["can_unpublish"] == 1)
                        echo "<td><span class='badge badge-success'>Yes</span></td>";
                    else
                        echo "<td><span class='badge badge-danger'>No</span></td>";
                    
                    //Select correct badge type.
                    if ($row['type'] == 0) 
                        echo " <td><span class='badge badge-warning'>Other</span></td>";
                    else if ($row['type'] == 1)
                        echo " <td><span class='badge badge-primary'>Social Media</span></td>";
                    else 
                        echo " <td><span class='badge badge-danger'>RSS</span></td>";
                    
                    //Only delete button for RSS-feeds
                    if ($row['type'] == 2)
                        echo " <td><button class='btn btn-danger btn-sm' onclick='askDeleteChannel(".$row["row_id"].")'>Delete</button></td>";
                    else    
                        echo "<td></td>";
                    
                    echo "</tr>";
                }
            } else {
                echo $FunctionsObj->outcomeMessage("warning","No channels have been found.");
            }
        }//showMediaChannels.

        public function getChannelsNotPublished($articleID) {
            $aChannels = array();
            //Execute sql.
            $result = $this->getNonPublishedChannels($articleID);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    array_push($aChannels,$row["row_id"].','.$row["type"].','.$row["name"]);
                }
            }
            echo json_encode($aChannels);
        }//Method getMediaChannels.
        
        public function getChannelsPublished($articleID) {
            $aChannels = array();
            //Execute sql.
            $result = $this->getPublishedChannels($articleID);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    array_push($aChannels,$row["c_row_id"].','.$row["c_type"].','.$row["c_name"]);
                }
            }
            echo json_encode($aChannels);
        }//Method getMediaChannels.

        //This function is used in ArticleView class, if return false is true it means 
        //Article is not yet published on ALL media platforms, this 'publish' button should exist.
        public function articleViewGetNonPublishedMedia($articleID) {
            return $this->getNonPublishedChannels($articleID);
        }//Method articleViewGetNonPublishedMedia.

        //Same as method above but for unpublish.
        public function articleViewGetPublishedMedia($articleID) {
            return $this->getPublishedChannels($articleID);
        }//Method articleViewGetNonPublishedMedia.


    }//ChannelView.
?>