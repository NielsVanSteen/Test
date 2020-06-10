//Show the subcategory on the write page.
function ShowSubCategories(value) {
    /*
        *Onclick event on an option inside a select, does not work with chrome. The solution i used is an onchange event on the select itself.
        *Using this solution i can only send 1parameter trough value="". Since all the parameters are integers I seperated them with a comma.
        *And thus I will need to split them.
    */
    aValue = value.split(',');
    level = aValue[0];
    parent_id = aValue[1];
        
    //Category has been selected/reselected, so remove the error/succes message.
    $("#categoriesInfoMessages").remove();

    //Call ajax.
    $.ajax({
        type: "GET",
        url: linkUrl+"classes/handler.class.php",
        data: {
            level:level,
            parent_id:parent_id,
            showSubcategories:"showSubcategories"
        },
        success: function(data) {
            
            if($("#sub-category-level-"+level).length !== 0) {
                //Clear the data in the class.
                $("#sub-category-level-"+level).empty();
                //Add new data in the class.
                $("#sub-category-level-"+level).append(data); 
            } else {
                //Create class and add data into it.
                $(".container-subcategories").append("<div class='write-categories-container' id='sub-category-level-"+level+"'>"+data+"</div>");
                subcatLevels++;
            }
        },//Succes.
    });
}//Function ShowSubCategories.

//Function SaveArticle.
function SaveArticle() {
    //Get all the values.
    articleTitle = document.getElementById("articleTitle").value;
    articleSummary = document.getElementById("articleSummary").value;
    articleBody = CKEDITOR.instances.ckeditor.getData();
    mArticleCategory = document.getElementById("articleCategory").value;
    mArticleSubcategory = document.getElementById("articleSubcategory").value;
    articleSigner = document.getElementById("articleSigner").value;
    articleURL = document.getElementById("articleURL").value;

    //Values of the category and subcategory ID contain 2 values, their ID, and their Parent_ID,
    //They are separated by a , so we split the value and take the last value (row_id).
    aArticleCategory = mArticleCategory.split(',');
    articleCategory = aArticleCategory[1];
    aArticleSubcategory = mArticleSubcategory.split(',');
    articleSubcategory = aArticleSubcategory[1];
 
    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            articleTitle:articleTitle,
            articleSummary:articleSummary,
            articleBody:articleBody,
            articleCategory:articleCategory,
            articleSubcategory:articleSubcategory,
            articleSigner:articleSigner,
            articleURL:articleURL,
            saveArticle:"saveArticle"
        },
        success: function(data) {
            $(".write-alert-messages").html(data);
            window.scrollTo(0,0);
        },
    });
}//Function saveArticle.

//Sets the content of the article in the correct input boxes.
function setContentToEditArticle() {
    //Check if the url contains "write/".
    url = window.location.href;
    if (!url.includes("write/")) {
        return false;
    }

    //Set the content of the article in the correct inputs.
    document.getElementById("articleTitle").value = document.getElementById("titleInput").value;
    document.getElementById("articleSummary").value = document.getElementById("summaryInput").value;
    document.getElementById("articleSigner").value = document.getElementById("signerInput").value;
    document.getElementById("articleURL").value = ReplaceSpaces(document.getElementById("linkInput").value);

    $(document).ready(function() {
        document.getElementById("ckeditor").value = document.getElementById("contentInput").value;
    });
}//Function setContentToEditArticle.

function saveEditArticle(link) {
    //get Values.
    articleTitle = document.getElementById("articleTitle").value;
    articleSummary = document.getElementById("articleSummary").value;
    articleBody = CKEDITOR.instances.ckeditor.getData();
    articleSigner = document.getElementById("articleSigner").value;
    articleURL = document.getElementById("articleURL").value;

    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            articleTitle:articleTitle,
            articleSummary:articleSummary,
            articleBody:articleBody,
            articleSigner:articleSigner,
            articleURL:articleURL,
            link:link,
            saveEditArticle:"saveEditArticle"
        },
        success: function(data) {
            $(".write-alert-messages").html(data);
            window.scrollTo(0,0);
        },
    });
}//Function saveEditArticle.

//Show a previev of the image.
function askPreviewImg(image_path,image,extension) {
    //Open overlay.
    Toggleoverlay('open',0);

   //Set the correct content in the dialog.
   heading = "Image preview";
   body = "<figure class='image-preview-figure'><img class='image-preview' src='"+image_path+"/"+image+"' alt='Image Preview'></figure>";
   button = "";
   openDialog(heading,body,button);
}//Function AskDelete.