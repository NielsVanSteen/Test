//Check if alphanumeric.
function IsAlphaNumeric(value) {
    if (! /^[a-zA-Z0-9]+$/.test(value)) {
        return false;
    } else {
        return true;
    }
}//Function IsAlpheNummeric.

//Remove all non alphanumeric characters.
function StripAlphaNumeric(value) {
    return value.replace(/[\W_]+/g,"");
}//Function StripAlphaNumeric.

//Remove all spaces.
function StripSpaces(value) {
    return value.replace(/ /g,"");
}//Function StripSpaces.

function ReplaceSpaces(value) {
    return value.replace(/-/g, ' ');
}//Function StripSpaces.

//Validate the length.
function ValidateLength(value,min,max) {
    if (value.length < min || value.length > max) {
        return false;
    } else {
        return true;
    }
}//Function ValidateLength.

//Check if integer.
function IsInteger(value) {
    return Number.isInteger(value);
}//Function IsInteger.

//Create current path in array format.
function CreatePath() {
    var aPath = new Array();

    //Go through all breadcrumbs data-values and add to array, then afterwards pass to php.
    for (i=0;i<=teller;i++) {
        relativePath = document.getElementById("breadcrumbs-"+i).getAttribute('data-value');
        //Check if first dir == "assets"
        if (i == 0) {
            if (relativePath != "assets") {
                return false;
            }
        }
        aPath.push(relativePath);
    }//For.

    return aPath;
}//Function CreatePath.

//Toggle the admin navigation bar on small screens.
function toggleAdminNav() {
    if ($('.admin-nav-item').css('display') == 'none') {
        $(".admin-nav-item").slideDown();
    } else {
        $(".admin-nav-item").slideUp();
    }
}//Function toggleAdminNav.

//Toggle visibility of the overlay, and the correct content.
function Toggleoverlay(toggle,content) {
    //Check if close or open is clicked.
    if (toggle == "close") {
        //Close overlay.
        $(".overlay-wrapper").fadeOut();
        $(".overlay-box").css({
            'margin-top' : '0px'
        });
        //Enable scroll.
        $("body").removeClass("stop-scrolling");
        //For mobile.
        $('body').unbind('touchmove')

    }else if(toggle == "open") { 
        //Open overlay.
        $(".overlay-wrapper").fadeIn();
        $(".overlay-box").css({
            'margin-top' : '100px'
        });
        //Disable scroll.
        $('body').addClass('stop-scrolling');
        //for mobile.
        $('body').bind('touchmove', function(e){e.preventDefault()});

    } else {
        alert("Unknown parameter.");
        return false;
    }//If val==0.

    //Change content of the overlay.
    switch (content) {
        case 1:
            document.getElementById("overlayBody").innerHTML ='\
                <h2 class="overlay-title">Create Directory</h2>\
                <i class="fas fa-times close-overlay" onclick="Toggleoverlay(\'close\',0)"></i>\
                <div class="form-group">\
                    <label for="dirName">Directory Name</label>\
                    <input type="text" class="form-control" id="dirName" placeholder="Enter Name">\
                    <small id="overlaySmall" class="overlay-small">The name must be alphanumeric, spaces will be replaced with underscores. The length must be between 1 and 30</small>\
                </div>\
                <div class="button-container">\
                    <button class="btn btn-secondary" onclick="Toggleoverlay(\'close\',0)">Close</button>\
                    <button class="btn btn-primary" onclick="CreateDir()">Create</button>\
                </div>\
            ';
            break;
        case 2:
            document.getElementById("overlayBody").innerHTML ='\
                <h2 class="overlay-title">Upload File</h2>\
                <i class="fas fa-times close-overlay" onclick="Toggleoverlay(\'close\',0)"></i>\
                <div class="form-group">\
                    <label for="dirName">Select File</label><br>\
                    <input type="file" name="file" id="file" accept="image/jpeg,image/png,application/pdf,image/jpg"><br>\
                    <small id="overlaySmall" class="overlay-small">Only images (jpg,jpeg,png) and pdf files are allowed, The name of the\
                    file has to be alphanumeric. And the length has to be between 1 and 30</small>\
                </div>\
                <div class="button-container">\
                    <button class="btn btn-secondary" onclick="Toggleoverlay(\'close\',0)">Close</button>\
                    <button class="btn btn-primary" onclick="UploadFile()">Upload</button>\
                </div>\
            ';
            break;
        case 3:
            document.getElementById("overlayBody").innerHTML = '\
                <h2 class="overlay-title">Add Category</h2>\
                <i class="fas fa-times close-overlay" onclick="Toggleoverlay(\'close\',0)"></i>\
                <div class="form-group">  \
                    <label for="categoryName">Category name</label>\
                    <input type="text" class="form-control" id="categoryName" placeholder="Enter Category..">\
                    <small>The name must be alphanumeric, spaces are allowed. And the name has to be between 3 and 30 characters</small>\
                </div>\
                <div class="button-container">\
                    <button class="btn btn-secondary" onclick="Toggleoverlay(\'close\',0)">Close</button>\
                    <button class="btn btn-primary" onclick="SaveCategory(0)">Save</button>\
                </div>\
            ';
            break;
        default:
            break;
    }//Switch.
}//Function toggleoverlay.


//Opens the dialog box.
function openDialog(heading,body,button) {
    document.getElementById("overlayBody").innerHTML = '\
    <h2 class="overlay-title">'+heading+'</h2>\
    <i class="fas fa-times close-overlay" onclick="Toggleoverlay(\'close\',0)"></i>\
    <div class="form-group">  \
        '+body+'\
    </div>\
    <div class="button-container">\
        <button class="btn btn-secondary" onclick="Toggleoverlay(\'close\',0)">Close</button>\
        '+button+'\
    </div>\
';
}//Function openDialog.

//Toggles the visibility of the sections on the FAQ page.
function toggleFAQ(id) {
    if ($("#faq-section-article-"+id).css('display') == 'none') {
      $(".faq-section-articles").slideUp();
      $(".faq-angle").css({'transform' : 'rotate(0deg)'});

      $("#faq-angle-"+id).css({'transform' : 'rotate(180deg)'});
    } else {
      $(".faq-angle").css({'transform' : 'rotate(0deg)'});
    }

    $("#faq-section-article-"+id).slideToggle();
  }//Function toggleFAQ.