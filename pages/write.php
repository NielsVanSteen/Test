<?php
    //Includes.
    include_once("../includes/autoload.inc.php");

    //Objects.
    $object = new AutoLoad();
    $ArticleContr = new Articlecontr();

    //Check if user is logged in.
    if(!isset($_SESSION["userID"])) {
        header("Location: ".LinkUrl::LINKURL."index");
    }
?>
<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>Digon | Admin | Write</title>
        <?php 
            //Head tags.
            include "../includes/head.inc.php";
        ?>
        <script>
            /*Textarea met ckeditor vervangen.*/
            $(document).ready(function() {
                CKEDITOR.replace( 'ckeditor' );  
            });
            
        </script>
    </head>
    <?php 
        //Header.
        include_once "../includes/header.inc.php";

        //Check if edit-article is true.
        if (isset($_GET["article-link"])) {
            $link = $_GET["article-link"];
            echo " <body onload='setContentToEditArticle()'>";
            echo "<input type='hidden' name='titleInput' id='titleInput' value='".$ArticleContr->getArticleTitle($link)."'>";
            echo "<input type='hidden' name='summaryInput' id='summaryInput' value='".$ArticleContr->getArticleSummary($link)."'>";
            echo "<input type='hidden' name='contentInput' id='contentInput' value='".$ArticleContr->getArticleContent($link)."'>";
            echo "<input type='hidden' name='signedInput' id='signerInput' value='".$ArticleContr->getArticleSigner($link)."'>";
            echo "<input type='hidden' name='linkInput' id='linkInput' value='".$link."'>";
        } else {
            echo "<body>";
        }
    ?>
        
        <!-- Main.-->
        <main class="general-main container">

            <!--Navbar for admin pages.-->
            <?php 
                include_once "../includes/navbar.inc.php";
            ?>
            
            <!--Alert messages.-->
            <div class="write-alert-messages"></div>
            
            <!-- Title and summary.-->
            <div class="card card-body bg-light">
                <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="text" class="form-control" id="articleTitle" placeholder="Enter Title">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Summary</label>
                    <textarea class="form-control" id="articleSummary" placeholder="Enter Summary"></textarea>
                </div>
            </div>
            
            <!--CKEditor.-->
            <div class="write-ckeditor-container">
                <textarea name="ckeditor" id="ckeditor" rows="20"></textarea>
            </div>
            
            <!--Navbar for the tabs.-->
            <nav class="write-nav-tabs">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#tabPublish" role="tab" data-toggle="tab">Publish</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tabCategories" role="tab" data-toggle="tab">Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tabFiles" role="tab" data-toggle="tab">Files</a>
                    </li>
                </ul> 
            </nav>
            
            <!--All the tabs from the navbar above.-->
            <div class="tab-content write-tabpane-container">  
                
                <!-- Tab pane publish.-->
                <div role="tabpanel" class="tab-pane fade show active" id="tabPublish">
                    <div class="write-publish-row d-lg-flex d-lg-fler-row">
                        <div class="flex-fill write-publish-extra">
                            <label for="exampleInputEmail1">Signed</label>
                            <input type="text" class="form-control" id="articleSigner" placeholder="Enter Signer.." value="<?php $UserViewObj = new UserView(); echo $UserViewObj->showUserName(); ?>">
                        </div>
                        <div class="flex-fill write-publish-extra">
                            <label for="exampleInputEmail1">Permalink</label>
                            <input type="text" class="form-control" id="articleURL" placeholder="Enter Permalink..">
                        </div>
                    </div>
                    <div class="flex-fill write-publish-extra-button-container">
                        <?php
                            //Check if article will be created or edited.
                            if (isset($_GET["article-link"])) {
                                echo '<button class="btn btn-primary" onclick="saveEditArticle(\''.$link.'\')" type="submit">Edit</button>';
                            } else {
                                echo "<button class='btn btn-primary' onclick='SaveArticle()' type='submit'>Save</button>";
                            }   
                        ?>
                    </div>
                </div><!--Tab pane publish.-->
                
                <!-- Tab pane Categories.-->
                <div role="tabpanel" class="tab-pane fade" id="tabCategories"> 
                    <div class="container-fluid card card-body bg-light">
                         <div class="container"> 
                        <h3 class="write-category-title text-primary">Category</h3>
                            <?php 
                               //Show all categories.
                                $categoryObj = new CategoryView();
                                $categoryObj->showCategories();
                            ?>
                        </div>
                        <div class="container container-subcategories"></div>
                    </div>
                </div><!-- Tab pane Categories.-->

                <!-- Tab pane Files-->
                <div role="tabpanel" class="tab-pane fade files-file-directory-container card" id="tabFiles">
                    <nav aria-label="breadcrumb" class="files-breadcrumbs-directory-path card-header">
                        <ol class="breadcrumb" id="breadcrumbs">
                            <li class="breadcrumb-item bread-crumb-item"><a class="bread-crumb-links" id="breadcrumbs-0" data-value="assets" onclick="BaseDir(0,'false')">assets</a></li>
                        </ol>
                    </nav>
                    <div class="files-directory-body card-body">
                        <?php 
                            //Include the files and folders.
                            //$admin='false' -> no delete icon on hover, but insert/copy buttons.
                            $admin = "false";
                            $fileFolderObj = new FileView();
                            $fileFolderObj->showFilesFolders($admin,null);
                        ?>
                    </div>
                </div><!-- Tab pane Files.-->

            </div> 
        </main>
        <!--Overlay.-->
        <div class="overlay-wrapper">
            <div class="overlay-box" id="overlayBody"></div>
        </div>
        <div class="card card-body bg-dark" id="overlay-quick"></div>   

    </body>
</html>


