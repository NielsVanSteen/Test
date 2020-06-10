<?php
    //Includes.
    include_once("../includes/autoload.inc.php");

    //Objects.
    $object = new AutoLoad();

    //Check if user is logged in.
    if(!isset($_SESSION["userID"])) {
        header("Location: ".LinkUrl::LINKURL."index");
    }
?>
<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>Digon | Admin | Channels</title>
        <?php 
            //Head tags.
            include "../includes/head.inc.php";
        ?>
    </head>
    <body>
        <?php 
            //Header.
            include_once "../includes/header.inc.php";
        ?>
        
        <!--Main.-->
        <main class="general-main container">

            <!--Navbar for admin pages.-->
            <?php 
                include_once "../includes/navbar.inc.php";
            ?>
            
            <!--Admin buttons.-->
            <div class="channels-admin-actions-container">
                <button class="btn btn-primary" onclick="askAddChannel()">Add a channel</button>
            </div>

            <!--Alert messages.-->
            <div class="channels-alert-messages"></div>


            <!--Table showing other channels.-->
            <div class="col-lg-12 col-md-12 col-sm-12 channels-table-container">
                <table class="table table-bordered table-striped channels-channel-table">
                    <?php 
                        //Show all media channels.
                        $channelViewObj = new ChannelView();
                        $channelViewObj->showMediaChannels();
                    ?>
                </table>
            </div>       
            
        </main>

        <!--Overlay-->
        <div class="overlay-wrapper">
            <div class="overlay-box" id="overlayBody">
            </div>
        </div>
        
    </body>
</html>


