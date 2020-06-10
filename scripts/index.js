//Show the title of the articles of the correct subcategory on the index page.
function showArticlesIndex(id,name) {
    //Check if parameter is an integer.
    if(!IsInteger(id)) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>Unknown parameter.</p>");
        return false;
    }
    
    //Add subcategory to the breadcrumbs.
    if($('#breadcrumbSubcat').length){
        $("#breadcrumbSubcat").html("<a class='index-breadcrumb-button' onclick='showArticlesIndex("+id+",\""+name+"\")'>"+name+"</a>");
    } else {
        $(".breadcrumbs-index").append("<li class='breadcrumb-item active' aria-current='page' id='breadcrumbSubcat'><a class='index-breadcrumb-button' onclick='showArticlesIndex("+id+",\""+name+"\")'>"+name+"</a></li>");
    }
    
    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            id:id,
            showArticlesIndex:"showArticlesIndex"
        },
        success: function(data) {
            $(".articles-article-overview-container").html(data);
        },
    });
}//Function showArticlesIndex.