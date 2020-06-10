//Show articles to publish.
function showArticlesToPublish() {
    //Call ajax.
    $.ajax({
        type: "GET",
        url: linkUrl+"classes/handler.class.php",
        data: {
            showArticlesToPublish:"showArticlesToPublish"
        },
        success: function(data) {
            $(".calendar-topublish-articles-container").html(data);
        },
    });
}//Function showArticlesToPublish.

//Filter the articles on the calendar page.
function filterArticles() {
    //Get the values.
    visibility = $("#selectSortArticles").val();
    sort = $("#selectFilterArticles").val();
    keyword = $("#searchKeyword").val();

    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            visibility:visibility,
            sort:sort,
            keyword:keyword,
            filterArticles:"filterArticles"
        },
        success: function(data) {
            $("#calendarArticlesContainer").html(data);
        },
    });
}//Function filterArticles.

//Ask to publish the article.
function askPublishArticle(articleID) {
    //Open the overlay.
    Toggleoverlay('open',0);

    //Get all the checkboxes of the differnt media channels.
    $.ajax({
        type: "POST",
        async: false, //Makes sure $.ajax is synchronous.
        url: linkUrl+"classes/handler.class.php",
        data: {
            articleID:articleID,
            getNonPublishedMediaChannels:"getNonPublishedMediaChannels"
        },
        success: function(data) {
            aChannels = JSON.parse(data);;
            console.log(aChannels);

            //Get checkboxes in correct html format.
            checkboxes = "<input type='checkbox' name='chkWebsite' value='0' disabled checked> <label class='no-margin-padding text-secondary' >Website</label><br>";
            aChannels.forEach(channel => {
                aChannelVals = channel.split(","); //0=ID, 1=type, 2=name;
                checkboxes += "<input type='checkbox' name='chkPublishChannels' id='"+aChannelVals[2]+"-"+articleID+"' value='"+aChannelVals[0]+","+aChannelVals[1]+"'>\
                <label class='no-margin-padding' >"+aChannelVals[2]+"</label><br>";
            });
        },
    });

    //Set the correct content in the dialog.
    heading = "Publish Article";
    body = "<p class='no-margin-padding'>Select all channels you want this article to be published on. To publish to social media channels please select one at a time and press publish.</p>"+checkboxes;
    button = "<button class='btn btn-primary' onclick='publishArticle("+articleID+")'>Publish</button>";
    openDialog(heading,body,button);
}//Function askPublishArticle.

//Publish article.
function publishArticle(articleID) {
    //Get all selected checkboxes
    var aSelectedChannels = [];
    $("input:checkbox[name=chkPublishChannels]:checked").each(function(){
        aSelectedChannels.push($(this).val());
    });

    //Check if array is empty to eliminate an error (Only publish to website).
    if (aSelectedChannels.length === 0) {
        aSelectedChannels[0] = "empty";
    }

    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            articleID:articleID,
            aSelectedChannels:aSelectedChannels,
            publishArticle:"publishArticle"
        },
        success: function(data) {
            showArticlesToPublish();
            $(".calendar-alert-messages").html(data);
            Toggleoverlay('close',0);
            filterArticles();

            //Check if facebook was checked.
            if($('#Facebook-'+articleID).is(":checked")) {
                document.getElementById("fb-share-"+articleID).click();
            }
            //Check if linkedIn was checked.
            if($('#LinkedIn-'+articleID).is(":checked")) {
                document.getElementById("linkedin-share-"+articleID).click();
            }
            //Check if Twitter was checked.
            if($('#Twitter-'+articleID).is(":checked")) {
                document.getElementById("twitter-share-"+articleID).click();
            }
        },
    });
}//Function publishArticle.

//Ask to unpublish article.
function askUnpublishArticle(articleID) {
    //Open the overlay.
    Toggleoverlay('open',0);

      //Get all the checkboxes of the different media channels the article is published on.
      $.ajax({
        type: "POST",
        async: false, //Makes sure $.ajax is synchronous.
        url: linkUrl+"classes/handler.class.php",
        data: {
            articleID:articleID,
            getPublishedMediaChannels:"getPublishedMediaChannels"
        },
        success: function(data) {
            aChannels = JSON.parse(data);;
            console.log(aChannels);
            //Get checkboxes in correct html format.
            checkboxes = "";
            aChannels.forEach(channel => {
                aChannelVals = channel.split(","); //0=ID, 1=type, 2=name;
                checkboxes += "<input type='checkbox' name='chkUnpublishChannels' value='"+aChannelVals[0]+","+aChannelVals[1]+"'> <label class='no-margin-padding' >"+aChannelVals[2]+"</label><br>";
            });     
            if (aChannels.length == 0) {
                checkboxes = "<input type='checkbox' name='chkWebsite' value='0' disabled checked> <label class='no-margin-padding text-secondary' >Website</label><br>";
            }
        },
    });

    //Set the correct content in the dialog.
    heading = "Unpublish Article";
    body = "<p class='no-margin-padding'>Select all channels you want this article to be unpublished on.</p>\
    <small>Social media sites will not be unpublished automatically this will only update the database.</small><br>"+checkboxes;
    button = "<button class='btn btn-primary' onclick='unpublishArticle("+articleID+")'>Unpublish</button>";
    openDialog(heading,body,button);
}//Function askPublishArticle.

//Unpublish te article.
function unpublishArticle(articleID) {
    //Get all selected checkboxes
    var aSelectedChannels = [];
    $("input:checkbox[name=chkUnpublishChannels]:checked").each(function(){
        aSelectedChannels.push($(this).val());
    });

    //Make sure array is not empty, to eliminate errors.
    if (aSelectedChannels && aSelectedChannels.length) {   
    } else {
        aSelectedChannels[0] = "empty";
     }

    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            articleID:articleID,
            aSelectedChannels:aSelectedChannels,
            unpublishArticle:"unpublishArticle"
        },
        success: function(data) {
            showArticlesToPublish();
            $(".calendar-alert-messages").html(data);
            Toggleoverlay('close',0);
            filterArticles();
        },
    });
}//Function publishArticle.

//Function editArticle.
function editArticle(id) {
    window.location = linkUrl+"write/"+id;
}//Function editArticle.

//Ask to delete article.
function askDeleteArticle(id) {
    //Open the overlay.
    Toggleoverlay('open',0);

    //Set the correct content in the dialog.
    heading = "Delete Article";
    body = "<p>Are you sure you want to delete this article?</p>";
    button = "<button class='btn btn-primary' onclick='deleteArticle("+id+")'>Delete</button>";
    openDialog(heading,body,button);
}//Function askDeleteArticle.

//Delete the article.
function deleteArticle(id) {
    //Call ajax.
    $.ajax({
        type: "GET",
        url: linkUrl+"classes/handler.class.php",
        data: {
            id:id,
            deleteArticle:"deleteArticle"
        },
        success: function(data) {
            showArticlesToPublish();
            $(".calendar-alert-messages").html(data);
            Toggleoverlay('close',0);
            filterArticles();
        },
    });
}//Function deleteArticle.

//Load more articles on the calendar page.
function calendarLoadMoreArt() {
    //Get values. And make sure the filters still apply after the load more.
    visibility = $("#selectSortArticles").val();
    sort = $("#selectFilterArticles").val();
    keyword = $("#searchKeyword").val();
    amount = amount + 10;

    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            amount:amount,
            visibility:visibility,
            sort:sort,
            keyword:keyword,
            calendarLoadMoreArt:"calendarLoadMoreArt"
        },
        success: function(data) {
            $("#calendarArticlesContainer").html(data);
        },
    });
}//Function calendarLoadMoreArt.

//Apply search on keypresses.
function searchArticles(keyword) {
    //Get values. And make sure the filters still apply after the load more.
    visibility = $("#selectSortArticles").val();
    sort = $("#selectFilterArticles").val();
    amount = amount + 10;

    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            amount:amount,
            visibility:visibility,
            sort:sort,
            keyword:keyword,
            calendarLoadMoreArt:"calendarLoadMoreArt"
        },
        success: function(data) {
            $("#calendarArticlesContainer").html(data);
        },
    });
}//Function searchArticles.