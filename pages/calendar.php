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
        <title>Digon | Admin | Articles</title>
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
                  
            <!--Alert messages.-->
            <div class="calendar-alert-messages">
            </div>

            <div class="row">
                
                <!--Sidebar container.-->
                <div class="col-lg-3 col-md-12 col-sm-12 calendar-sort-filter-container">
                     <div class='list-group calendar-list-group'>
                        <a class='list-group-item list-group-item-action active disabled list-group-items-header'>Filter & sort articles</a>
                        <a class='list-group-item list-group-item-action disabled'>Show articles</a>
                        <a class='list-group-item list-group-item-action list-group-item-light' onchange="filterArticles()">
                            <select name="selectShowArticles" id="selectSortArticles">
                                <option value="all">All</option>
                                <option value="published">Published</option>
                                <option value="saved">Saved</option>
                                <option value="deleted">Deleted</option>
                            </select>
                        </a>
                        <a class='list-group-item list-group-item-action disabled'>Sort articles</a>
                        <a class='list-group-item list-group-item-action list-group-item-light'>
                            <select name="selectFilterArticles" id="selectFilterArticles" onchange="filterArticles()">
                                <option value="DATEASC">DATE ASC</option>
                                <option value="DATEDESC" selected>DATE DESC</option>
                            </select>
                        </a>
                        <a class='list-group-item list-group-item-action disabled'>Search articles</a>
                        <a class='list-group-item list-group-item-action list-group-item-light'>
                            <input type="text" class="form-control" id="searchKeyword" onkeyup="searchArticles(this.value)">
                        </a>
                    </div>
                </div>

                <!--Articles container.-->
                <div class="col-lg-9 col-md-12 col-sm-12 articles-article-overview-container" id="calendarArticlesContainer">
                    <!--Show all articles.-->
                    <?php 
                        $ArticleObj = new ArticleView();
                        $ArticleObj->showArticle('all','DATEDESC','',10);
                    ?>
                </div><!-- Articles container.-->   

            </div><!--Row.-->
            
        </main>
        
        <!--Overlay.-->
        <div class="overlay-wrapper">
            <div class="overlay-box" id="overlayBody">
            </div>
        </div>

    </body>
</html>