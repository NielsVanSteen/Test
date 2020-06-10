<?php
    include_once("../includes/autoload.inc.php");
    $object = new AutoLoad();
    
    //Ajax called from login.
    if(isset($_POST["login"])) {
       $UserContrObj = new UserContr();
       $UserContrObj->loginContr($_POST["username"],$_POST["password"],$_POST["cookiePreset"]);
       unset($UserContrObj);
    }//If.

    if(isset($_POST["logout"])) {
        $UserContrObj = new UserContr();
        $UserContrObj->logout();
        unset($UserContrObj);
     }//If.

    //Ajax called from DirClick.
    if(isset($_GET["dirClick"])) {
        $FileFolderObj = new FileView();
        $FileFolderObj->showFilesFolders($_GET["admin"],$_GET["aPath"]);
        unset($FileFolderObj);
    }//If.

     //Ajax called from CreateDir.
     if(isset($_GET["createDir"])) {
        $CreateDirObj = new FileContr();
        $CreateDirObj->createDir($_GET["aPath"],$_GET["dirName"]);
        unset($CreateDirObj);
    }//If.

     //Ajax called from Uploadfile.
     if(isset($_POST["uploadFile"])) {
        $UploadFileObj = new FileContr();
        $UploadFileObj->uploadFile($_FILES["file"], $_POST["aPath"]);
        unset($UploadFileObj);
    }//If.

    //Ajax called from Delete.
    if(isset($_GET["deleteFileFolder"])) {
        $DeleteObj = new FileContr();
        $DeleteObj->deleteFileFolder($_GET["dirPath"], $_GET["fileName"], $_GET["type"]);
        unset($DeleteObj);
    }//If.

    //Ajax called from ShowSubcategories.
    if(isset($_GET["showSubcategories"])) {
        $ShowSubcatObj = new CategoryView();
        $ShowSubcatObj->showSubcatFromParentCat($_GET["level"], $_GET["parent_id"]);
        unset($ShowSubcatObj);
    }//If.

    //Ajax called from SaveCategory.
    if(isset($_POST["saveArticle"])) {
        $SaveArticleObj = new WriteContr();
        $SaveArticleObj->createArticle($_POST["articleTitle"], $_POST["articleSummary"],$_POST["articleBody"], $_POST["articleCategory"], $_POST["articleSubcategory"],$_POST["articleSigner"],$_POST["articleURL"]);
        unset($SaveArticleObj);
    }//If.

      //Ajax called from saveEditArticle.
      if(isset($_POST["saveEditArticle"])) {
        $WriteContrObj = new WriteContr();
        $WriteContrObj->saveEditArticle($_POST["articleTitle"],$_POST["articleSummary"],$_POST["articleBody"],$_POST["articleSigner"],$_POST["articleURL"],$_POST["link"]);
        unset($WriteContrObj);
    }//If.

    //Ajax called from SaveCategory.
    if(isset($_GET["setCatSubcat"])) {
        $SetCategoryObj = new CategoryContr();
        $SetCategoryObj->createCatSubcat($_GET["catSubcatName"],$_GET["parent_id"]);
        unset($SetCategoryObj);
    }//If.

    //Ajax called from DeleteCategory.
    if(isset($_GET["deleteCatSubcat"])) {
        $DeleteCatSubcatObj = new CategoryContr();
        $DeleteCatSubcatObj->deleteCatSubcat($_GET["id"],$_GET["catSubcat"]);
        unset($DeleteCatSubcatObj);
    }//If.

    //Ajax called from ListCategories.
    if(isset($_GET["listCategories"])) {
        $ListCatSubcatObj = new CategoryView();
        $ListCatSubcatObj->showCatsAndSubcats();
        unset($ListCatSubcatObj);
    }//If.

    //Ajax called from showArticlesToPublish.
    if(isset($_GET["showArticlesToPublish"])) {
        $ShowArticlesToPublishObj = new ArticleView();
        $ShowArticlesToPublishObj->showArticle('undefined','undefined');
        unset($ShowArticlesToPublishObj);
    }//If.

    //Ajax called from publishArticle.
    if(isset($_POST["publishArticle"])) {
        $ArticleContrObj = new ArticleContr();
        $ArticleContrObj->publishArticle($_POST["articleID"],$_POST["aSelectedChannels"]);
        unset($ArticleContrObj);
    }//If.

    //Ajax called from publishArticle.
    if(isset($_POST["unpublishArticle"])) {
        $unpublishArticleObj = new ArticleContr();
        $unpublishArticleObj->unpublishArticle($_POST["articleID"],$_POST["aSelectedChannels"]);
        unset($unpublishArticleObj);
    }//If.

    //Ajax called from askDeleteArticle.
    if(isset($_GET["deleteArticle"])) {
        $DeleteArticleObj = new Articlecontr();
        $DeleteArticleObj->deleteArticle($_GET["id"]);
        unset($DeleteArticleObj);
    }//If.
    
    //Ajax called from showArticlesIndex.
    if(isset($_POST["showArticlesIndex"])) {
        $showArticlesIndexObj = new ArticleView();
        $showArticlesIndexObj->showArticlesIndex($_POST["id"]);
        unset($showArticlesIndexObj);
    }//If.

    //Ajax called from filterArticles.
    if(isset($_POST["filterArticles"])) {
        $filterArticlesObj = new ArticleView();
        $filterArticlesObj->showArticle($_POST["visibility"],$_POST["sort"],$_POST["keyword"],10);
        unset($filterArticlesObj);
    }//If.

    //Ajax called from change password form.
    if(isset($_GET["changePassword"])) {
        $UserObj = new UserContr();
        $UserObj->changePassword($_POST["changePasswordOld"],$_POST["changePasswordNew"],$_POST["changePasswordNewConfirm"]);
        unset($UserObj);
    }//If.

    //Ajax called from change username form.
    if(isset($_GET["changeUsername"])) {
        $UserObj = new UserContr();
        $UserObj->changeUsername($_GET["changeUsername"]);
        unset($UserObj);
    }//If.

    //Ajax called from change displayname form.
    if(isset($_GET["changeDisplayname"])) {
        $UserObj = new UserContr();
        $UserObj->changeDisplayname($_GET["changeDisplayname"]);
        unset($UserObj);
    }//If.

    //Ajax called from change add an account form.
    if(isset($_GET["addAccount"])) {
        $UserObj = new UserContr();
        $UserObj->addUser($_POST["chooseUsername"],$_POST["chooseDisplayname"],$_POST["choosePassword"],$_POST["choosePasswordConfirm"]);
        unset($UserObj);
    }//If.

    //Ajax called from load more articles on calendar page.
    if(isset($_POST["calendarLoadMoreArt"])) {
        $ArticleObj = new ArticleView();
        $ArticleObj->showArticle($_POST["visibility"],$_POST["sort"],$_POST["keyword"],$_POST["amount"]);
        unset($ArticleObj);
    }//If.

    //Ajax called from delete user account.
    if(isset($_POST["deleteUser"])) {
        $UserContrObj = new UserContr();
        $UserContrObj->deleteUser($_POST["id"]);
        unset($UserContrObj);
    }//If.

    //Ajax called from add channel.
    if(isset($_POST["addChannel"])) {
        $ChannelContrObj = new ChannelContr();
        $ChannelContrObj->insertChannel($_POST["name"],$_POST["canUnpublish"],$_POST["type"]);
        unset($ChannelContrObj);
    }//If.

    //Ajax called from show channels.
    if(isset($_POST["showChannels"])) {
        $ChannelViewObj = new ChannelView();
        $ChannelViewObj->showMediaChannels();
        unset($ChannelViewObj);
    }//If.

    //Ajax called from delete channel.
    if(isset($_POST["deleteChannel"])) {
        $ChannelContrObj = new ChannelContr();
        $ChannelContrObj->deleteChannel($_POST["channelID"]);
        unset($ChannelContrObj);
    }//If.

    //Ajax called from get media channels (askPublishArticle).
    if(isset($_POST["getNonPublishedMediaChannels"])) {
        $ChannelViewObj = new ChannelView();
        $ChannelViewObj->getChannelsNotPublished($_POST["articleID"]);
        unset($ChannelViewObj);
    }//If.

    //Ajax called from get media channels (askUnpublishArticle).
    if(isset($_POST["getPublishedMediaChannels"])) {
        $ChannelViewObj = new ChannelView();
        $ChannelViewObj->getChannelsPublished($_POST["articleID"]);
        unset($ChannelViewObj);
    }//If.

    
?>