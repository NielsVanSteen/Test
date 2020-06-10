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
        <title>Digon | Admin | Categories</title>
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
             
            <!--Admin actions div.-->
            <div class="admin categories-admin-div">
                <button class="btn btn-primary" onclick="Toggleoverlay('open',3)">Add Category</button>
            </div>
            
            <!--Alert messages.-->
            <div class="categories-alert-messages"></div>
            
            <!--Container of the directory window.-->
            <div class="categories-category-directory-container card card-body bg-light">
                <div class="categories-category-container d-flex flex-row flex-wrap">
                    <?php
                        $CatSubcatObj = new CategoryView();
                        $CatSubcatObj->showCatsAndSubcats();
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


