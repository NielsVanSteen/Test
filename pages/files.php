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
<html lnag="nl">
    <head>
        <title>Digon | Admin | Files</title>
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
        
        <!-- Main.-->
        <main class="general-main container">

            <!--Navbar for admin pages.-->
            <?php 
                include_once "../includes/navbar.inc.php";
            ?>
            
             <!--Directory Actions.-->
            <div class="admin files-admin-div">
                <button type="button" class="btn btn-primary buttons" onclick="Toggleoverlay('open',1)">Create Folder</button>
                <button type="button" class="btn btn-primary buttons" onclick="Toggleoverlay('open',2)">Upload File</button>
            </div>
             
            <!--Alert messages.-->
            <div class="files-alert-messages"></div>
              
            <!--Container of the directory window.-->
            <div class="files-file-directory-container card">
                <!--Breadcrumbs-->
                <nav aria-label="breadcrumb" class="files-breadcrumbs-directory-path card-header">
                    <ol class="breadcrumb" id="breadcrumbs">
                        <li class="breadcrumb-item bread-crumb-item"><a class="bread-crumb-links" id="breadcrumbs-0" data-value="assets" onclick="BaseDir(0,'true')">assets</a></li>
                    </ol>
                </nav>
                <!--Directory body.-->
                <div class="files-directory-body card-body">
                     <?php
                        $admin = "true";
                        $fileFolderObj = new FileView();
                        $fileFolderObj->showFilesFolders($admin, null);
                        unset($fileFolderObj);
                    ?>
                </div>
             </div>

        </main>
        
        <!--Overlay-->
        <div class="overlay-wrapper">
            <div class="overlay-box" id="overlayBody">
            </div>
        </div>
        
    </body>
</html>


