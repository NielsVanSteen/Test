
//This function opens a subdir in a dir.
function DirClick(dirName,admin) {
    //Check if createpath is valid.
    if (!CreatePath()) {
        $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>This path is not allowed!</p>");
        return false;
    }

    //If function is called after creating folder 'dirName' will be undefined.
    if (dirName) {
        teller++;
        document.getElementById("breadcrumbs").innerHTML += '<li class="breadcrumb-item bread-crumb-item"><a class="bread-crumb-links" id="breadcrumbs-'+teller+'" data-value="'+escape(dirName)+'" onclick="BaseDir('+teller+','+admin+')">'+dirName+'</a></li>';
    }
    
    //Call CreatePath function and get the path from homeDirectory to current dir in an array.
    aPath = CreatePath();

    //Execute Ajax.
    $.ajax({
        type: "GET",
        url: linkUrl+"classes/handler.class.php",
        data: {
            aPath:aPath,
            admin:admin,
            dirClick:"dirClick"
        },
        success: function(data) {
            $(".files-directory-body").html(data);
        },
    });
}//Function DirClick.

//Go back in subdirectories.
function BaseDir(cur_level,admin) {
    //Change breadcrumbs path.
    for (i=cur_level;i<teller;i++) {
        $(".bread-crumb-item").eq(cur_level+1).remove();
    }
    teller = cur_level;

    //Execute dirclick function.
    DirClick(undefined,admin);
}//Function BaseDir.


//Create a directory in folder.
function CreateDir() {
    dirName = document.getElementById("dirName").value;

    //Check if dirname is not empty, and is alphanumeric.
    if (!IsAlphaNumeric(StripSpaces(dirName)) || !dirName) {
        document.getElementById("overlaySmall").style.color = "red";
        return false;
    }
    
    //Get the path from homeDirectory to current dir in an array.
    aPath = CreatePath();
    aPath.join(',');

    //Call ajax
    $.ajax({
        type: "GET",
        url: linkUrl+"classes/handler.class.php",
        data: {
            aPath:aPath,
            dirName:dirName,
            createDir:"createDir"
        },
        success: function(data) {
            $(".files-alert-messages").html(data);
            //close overlay.
            Toggleoverlay('close',0);
            //Go in to the created dir.
            DirClick(undefined,true);
        },
    });
}//Function CreateDir.

//Upload a file to "assets" function.
function UploadFile() {
    //Get all data from input file.
    var property = document.getElementById("file").files[0];
    var file_name = property.name;
    var file_extension = file_name.split('.').pop().toLowerCase();

    //Check if file is image/pdf.
    if(jQuery.inArray(file_extension, ['jpg','jpeg','png','pdf']) == -1) {
        $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>This file is not an image or a pdf file.</p>");
        Toggleoverlay('close',0);
        return false;
    }
    
    //Check if file is not too big.
    var file_size = property.size;
    if (file_size > 5000000) {
        $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>File is too big.</p>");
        Toggleoverlay('close',0);
        return false;
    }

    //Get path to the current directory in assets.
    aPath = CreatePath();
    aPath.join(',');
    
    //Add all the data to the formdata.
    var form_data = new FormData();
    form_data.append('file', property);
    form_data.append('aPath', aPath);
    form_data.append('uploadFile', aPath);

    //Call ajax.
    $.ajax({
        url: linkUrl+"classes/handler.class.php",
        method: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success:function(data){
            $(".files-alert-messages").html(data);
            Toggleoverlay('close',0);
            DirClick(undefined,true);
        }
    });
}//Function UploadFile.


//Ask to delete the file or folder.
function askDeleteFileFolder(dirPath,fileName,type) {
     //Open overlay.
     Toggleoverlay('open',0);

    //Personalise message.
    if (type == 'file') {
        file_folder = "File";
    }
    else {
        file_folder = "Folder";
    }

    //Set the correct content in the dialog.
    heading = "Delete "+file_folder;
    body = "<p>Are you sure you want to delete this "+file_folder+"?</p>";
    button = '<button class="btn btn-primary" onclick="deleteFileFolder(\''+dirPath+'\',\''+fileName+'\',\''+type+'\')">Yes, Delete</button>';
    openDialog(heading,body,button);
}//Function AskDelete.


//This function deletes a dir or a file.
function deleteFileFolder(dirPath,fileName,type) {

    //Check if al parameters exist.
    if (!dirPath || !fileName || !type) {
        $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>Not all parameters are valid</p>");
        return false;
    }

    //Remove . and / from dirpath.
    dirPathStripped = StripAlphaNumeric(dirPath);
    fileNameStripped = StripAlphaNumeric(fileName);

    //Check if parameters don't contain special characters.
    if (!IsAlphaNumeric(dirPathStripped) || !IsAlphaNumeric(fileNameStripped) || !IsAlphaNumeric(type)) {
        $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>Parameters container forbidden characters</p>");
        return false;
    }
    
    //Check if dirpath starts with the folder "assets". The user MAY NOT delete any item anywere alse.
    if (!dirPath.startsWith("../assets")) {
        $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>This path is not allowed</p>");
        Toggleoverlay('close',0);
        return false;
    }
    
    //Call ajax.
    $.ajax({
        type: "GET",
        url: linkUrl+"classes/handler.class.php",
        data: {
            dirPath:dirPath,
            fileName:fileName,
            type:type,
            deleteFileFolder:"deleteFileFolder"
        },
        success: function(data) {
            $(".files-alert-messages").html(data);
            Toggleoverlay('close',0);
            DirClick(undefined,true);
        },
    });
}//Function Delete.

//Insert the file into ckeditor.
function InsertFile(path,fileName,type) {
    if (type == "pdf")
        CKEDITOR.instances.ckeditor.insertHtml('<a href="'+path+'/'+fileName+'" target="_blank" class="pdf-ckeditor-a">'+fileName+'</a> <br>');
    else 
        CKEDITOR.instances.ckeditor.insertHtml('<img class="articles-article-img" src="'+path+'/'+fileName+'" class="images-ckeditor"> <br>');
}//Function InsertFile.

//Copy the file to the clipboard of the user.
function copyFile(path,fileName,type) {
    var inp =document.createElement('input');
    document.body.appendChild(inp);

    //Check if file is an image or a pdf file.
    if (type == "pdf") {
        copyText = '<a href="'+path+'/'+fileName+'" target="_blank" class="pdf-ckeditor-a">'+fileName+'</a>';
    } else {
        copyText = '<img class="articles-article-img" src="'+path+'/'+fileName+'" class="images-ckeditor">';
    }

    //Copy to clipboard.
    inp.value = copyText
    inp.select();
    try {
        document.execCommand('copy',false);
        $("#overlay-quick").fadeIn();
        document.getElementById("overlay-quick").innerHTML= "<p class='text-white'>Text has been copied</p>";
        setTimeout(function() {
            $("#overlay-quick").fadeOut();
        }, 1000);
    } catch (err) {
       alert("failed to copy text!")
    }
    inp.remove();
}//Function copyFile.