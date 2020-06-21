//Open login dialox box on the index page.
function openLogindialog() {
    //Check if the url contains "login".
    url = window.location.href;
    if (!url.includes("login")) {
        return false;
    }

    //Open the overlay.
    Toggleoverlay('open',0);

    //Set the correct content in the dialog.
    heading = "Login";
    body = "<label for='username'>Username</label>\
            <input type='text' class='form-control' id='username' placeholder='Enter Username'>\
            <label for='password'>Password</label>\
            <input type='password' class='form-control' id='password' placeholder='Enter Password'>\
            <input type='radio' name='loginCookieRadio' value='1'>\
            <small>Save (or update) login data in a cookie.</small><br>\
            <input type='radio' name='loginCookieRadio' value='0' checked>\
            <small>Don't save (or delete) login data from the cookie.</small><br>\
            <small id='loginMessage'></small>";
    button = "<button class='btn btn-primary' onclick='login()''>Login</button>";
    openDialog(heading,body,button);

    //Prefill username and password from cookie, if they exist.
    if ($('#usernamePrefill').length) {
        $('#username').val($('#usernamePrefill').val());
    }
    if ($('#passwordPrefill').length) {
        $('#password').val($('#passwordPrefill').val());
    }

}//Function openLoginDialog.

//Log the user in.
function login() {
    //Get the username, password and cookie preset.
    username = document.getElementById("username").value;
    password = document.getElementById("password").value;
    cookiePreset = document.querySelector('input[name="loginCookieRadio"]:checked').value;

    //Validate the username and password.
    if (username == "" || password == "") {
        $("#loginMessage").html("Values are empty.");
        return false;
    }
    if (!IsAlphaNumeric(username) || !IsAlphaNumeric(password) || !IsAlphaNumeric(cookiePreset)) {
        $("#loginMessage").html("Values are not alphanumeric.");
        return false;
    }

    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            username:username,
            password:password,
            cookiePreset:cookiePreset,
            login:"login"
        },
        success: function(data) {
            //remove "/login" or "?login" from the url.
            newURL = url.replace("?login", "");
            newURL = newURL.replace("/login", "");
            document.location.href = newURL;
            Toggleoverlay('close',0);
        },
    });
}//Function login.

//Log the user out.
function logout() {
    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            logout:"logout"
        },
        success: function(data) {
           location.reload();
        },
    });
}//Function logout.

//Ask to delete the useraccount.
function askDeleteUser(id) {
    //Open the overlay.
    Toggleoverlay('open',0);

    //Set the correct content in the dialog.
    heading = "Delete User account";
    body = "<p>Are you sure you want to delete this user account?</p>";
    button = " <button class='btn btn-primary' onclick='deleteUser("+id+")'>Delete</button>";
    openDialog(heading,body,button);
}//Function askDeleteUser.

//Delete the user account.
function deleteUser(id) {
      //Call ajax.
      $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            id:id,
            deleteUser:"deleteUser"
        },
        success: function(data) {
            //location.reload();
            window.location.href = linkUrl+"account";
            $(".account-alert-messages").html(data);
        },
    });
}//Function deleteUser.