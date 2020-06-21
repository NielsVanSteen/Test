<?php
    //Include all php files.
    include_once("includes/autoload.inc.php"); 

    //Create objects.
    $object = new AutoLoad();
    $CategoryViewObj = new CategoryView();
	
    //Make sure cat_id exists.
    if (isset($_GET["catID"])) {
        $cat_id = $_GET["catID"];
    } else {
        $cat_id = 1;
    }
?>
<!DOCTYPE html>
<html lnag="nl">
    <head>
        <title>Digon | Articles | Home</title>
        <?php 
            //Head tags.
            include "includes/head.inc.php";
        ?>
    </head>
    <body onload="openLogindialog()">
        <?php 
            //Header.
            include_once "includes/header.inc.php";
        ?>
		
        <main class="general-main container">

            <!--Navbar for admin pages-->
            <?php 
                include_once "includes/navbar.inc.php";
            ?>
          
            <!--Breadcrumbs-->
            <nav class="container general-nav nav-index" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumbs-index">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo LinkUrl::LINKURL;?>index"><?php echo $CategoryViewObj->showCategory($cat_id) ?></a></li>
                </ol>
            </nav>

             <!--Alert messages-->
             <div class="index-alert-messages"></div>
           
            <!--Sidebar container-->
            <div class="row">
                <div class="col-md-3 col-lg-3">
                    <!--Sidebar-->
                    <?php
                        //show subcategories.
                        $CategoryViewObj->ArticlesShowSubcats($cat_id);
                    ?>
                </div>

                <!--Article titles container-->
                <div class="col-md-9 col-lg-9 articles-article-overview-container">
                    <p class="alert alert-warning" role="alert">Klik op een subcategorie om de artikels weer te geven.</p>
                </div><!-- Article title container-->   
            </div><!--Row-->
              
        </main>
		
        <!--Overlay-->
        <div class="overlay-wrapper">
            <div class="overlay-box" id="overlayBody"></div>
        </div>

        <?php 
            if (isset($_COOKIE["username"])) {
                echo "<input type='hidden' value='".$_COOKIE["username"]."' id='usernamePrefill'>";
            }
            if (isset($_COOKIE["password"])) {
                echo "<input type='hidden' value='".$_COOKIE["password"]."' id='passwordPrefill'>";
            }
        ?>
        
    </body>
</html>


