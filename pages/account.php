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
        <title>Digon | Admin | Profile</title>
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

            <!--Alert messages..-->
            <div class="account-alert-messages">
                <?php 
                    $FunctionsObj = new Functions();

                    //Check if alert message needs to be shown.
                    if(isset($_GET["message"])) {

                        switch ($_GET["message"]) {
                            //Fail
                                //password.
                                case 'password-alphanumeric':
                                    echo $FunctionsObj->outcomeMessage("error","Password is not alphanumeric, or is too long/short.");
                                    break;
                                case 'password-no-match':
                                    echo $FunctionsObj->outcomeMessage("error","New password does not match.");
                                    break;
                                case 'pass-wrong':
                                    echo $FunctionsObj->outcomeMessage("error","Old password is not correct.");
                                    break;
                                case 'newpass-same':
                                    echo $FunctionsObj->outcomeMessage("error","New password is the same as the old.");
                                    break;
                                case 'password-fail':
                                    echo $FunctionsObj->outcomeMessage("error","Failed to change password.");
                                    break;
                                //Username.
                                case 'username-alphanumeric':
                                    echo $FunctionsObj->outcomeMessage("error","New username is not alphanumeric or is too long/short.");
                                    break;
                                case 'username-fail':
                                    echo $FunctionsObj->outcomeMessage("error","Failed to change the username.");
                                    break;
                                //Displayname
                                case 'displayname-alphanumeric':
                                    echo $FunctionsObj->outcomeMessage("error","New displayname is not alphanumeric or is too long/short.");
                                    break;
                                case 'displayname-fail':
                                    echo $FunctionsObj->outcomeMessage("error","Failed to change the displayname.");
                                    break;
                                //Add account.
                                case 'addAccount-length':
                                    echo $FunctionsObj->outcomeMessage("error","Values are too long/short.");
                                    break;
                                case 'addAccount-alphanumeric':
                                    echo $FunctionsObj->outcomeMessage("error","Values are not alphanumeric.");
                                    break;
                                case 'addAccount-password':
                                    echo $FunctionsObj->outcomeMessage("error","Passwords do not match.");
                                    break;
                                case 'addAccount-fail':
                                    echo $FunctionsObj->outcomeMessage("error","Failed to add account.");
                                    break;
                                case 'addAccount-permission':
                                    echo $FunctionsObj->outcomeMessage("error","You do not have the permission to add an account, ony admin can add an account.");
                                    break;
                                //Delete account.
                                case 'deleteAccount-fail':
                                    echo $FunctionsObj->outcomeMessage("error","Failed to delete the account.");
                                    break;
                            //Succes.
                                //Pasword.
                                case 'pass-change':
                                    echo $FunctionsObj->outcomeMessage("success","Password has succesfully been changed.");
                                    break;
                                //Username.
                                case 'username-change':
                                    echo $FunctionsObj->outcomeMessage("success","Username has succesfully been changed.");
                                    break;
                                //Displayname.
                                case 'displayname-change':
                                    echo $FunctionsObj->outcomeMessage("success","Displayname has succesfully been changed.");
                                    break;
                                //Add account.
                                case 'addAccount':
                                    echo $FunctionsObj->outcomeMessage("success","Account has succesfully been added.");
                                    break;
                                //Delete account.
                                case 'deleteAccount':
                                    echo $FunctionsObj->outcomeMessage("success","Account has succesfully been deleted.");
                                    break;
                        }

                    }
                ?>
            </div>
            
            <!--Change account settings.-->
            <div class="row">
                <!--Title.-->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h3 class="account-settings-title">Change Account information</h3>
                </div>

                <!--Change password.-->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <form action="<?php echo LinkUrl::LINKURL ?>classes/handler.class.php?changePassword" method="POST">
                        <h4 class="account-settings-subtitle">Change password</h4>
                        <hr class="account-settings-subtitle-underline">
                        <div class="form-group">
                            <label for="changePasswordOld" class="account-settings-label text-primary">Old password</label>
                            <input type="password" class="form-control" id="changePasswordOld" name="changePasswordOld" placeholder="Enter old password..">
                        </div>
                        <div class="form-group">
                            <label for="changePasswordNew" class="account-settings-label text-primary">New password</label>
                            <input type="password" class="form-control" id="changePasswordNew" name="changePasswordNew" placeholder="Enter new password..">
                        </div>
                        <div class="form-group">
                            <label for="changePasswordNewConfirm" class="account-settings-label text-primary">Confirm new password</label>
                            <input type="password" class="form-control" id="changePasswordNewConfirm" name="changePasswordNewConfirm" placeholder="Confirm new password..">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="account-settings-button btn btn-primary btn-sm">Save</button>
                        </div>
                    </form>
                </div>

                <!--Change username and displayname.-->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <form action="<?php echo LinkUrl::LINKURL ?>classes/handler.class.php?changeUsername" method="GET">
                        <h4 class="account-settings-subtitle">Change username</h4>
                        <hr class="account-settings-subtitle-underline">
                        <div class="form-group">
                            <label for="changeUsername" class="account-settings-label text-primary">Username</label>
                            <input type="text" class="form-control" id="changeUsername" name="changeUsername" placeholder="Enter Username..">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="account-settings-button btn btn-primary btn-sm">Save</button>
                        </div>
                    </form>
                    <form action="<?php echo LinkUrl::LINKURL ?>classes/handler.class.php?changeDisplayname" method="GET">
                        <h4 class="account-settings-subtitle">Change displayname</h4>
                        <hr class="account-settings-subtitle-underline">
                        <div class="form-group">
                            <label for="changeDisplayname" class="account-settings-label text-primary">Displayname</label>
                            <input type="text" class="form-control" id="changeDisplayname" name="changeDisplayname" placeholder="Enter Displayname..">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="account-settings-button btn btn-primary btn-sm">Save</button>
                        </div>
                    </form>
                </div>
            </div><!--.Row.-->

            <!--View all accounts.-->
            <div class="row">
                 <!--Title.-->
                 <div class="col-lg-12 col-md-12 col-sm-12">
                    <hr class="account-settings-title-underline">
                    <h3 class="account-settings-title">View all accounts</h3>  
                </div>
                
                <!--Table with all accounts.-->
                <div class="col-lg-12 col-md-12 col-sm-12 account-accounts-table-container">
                    <table class="table table-bordered table-striped account-accounts-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Displayname</th>
                                <th scope="col">Password</th>
                                <th scope="col">function</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                //Display all users.
                                $UserViewObj = new UserView();
                                $UserViewObj->showUsers();
                            ?>
                        </tbody>
                    </table>
                </div><!--Row.-->
                
            </div>

            <!--Add an account.-->
            <div class="row">
                 <!--Title.-->
                 <div class="col-lg-12 col-md-12 col-sm-12">
                    <hr class="account-settings-title-underline">
                    <h3 class="account-settings-title">Add an account</h3>    
                </div>

                 <!--Change password.-->
                 <div class="col-lg-6 col-md-12 col-sm-12">
                    <form action="<?php echo LinkUrl::LINKURL ?>classes/handler.class.php?addAccount" method="POST">
                        <div class="form-group">
                            <label for="chooseUsername" class="account-settings-label text-primary">Username</label>
                            <input type="text" class="form-control" id="chooseUsername" name="chooseUsername" placeholder="Enter username..">
                        </div>
                        <div class="form-group">
                            <label for="chooseDisplayname" class="account-settings-label text-primary">Displayname</label>
                            <input type="text" class="form-control" id="chooseDisplayname" name="chooseDisplayname" placeholder="Enter displayname..">
                        </div>
                </div>

                <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="choosePassword" class="account-settings-label text-primary">Password</label>
                            <input type="password" class="form-control" id="choosePassword" name="choosePassword" placeholder="Enter password..">
                        </div>
                        <div class="form-group">
                            <label for="choosePasswordConfirm" class="account-settings-label text-primary">Confirm password</label>
                            <input type="password" class="form-control" id="choosePasswordConfirm" name="choosePasswordConfirm" placeholder="Confirm password..">
                        </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <button type="submit" class="account-settings-button btn btn-primary btn-sm">Save</button>
                        </div>
                    </form>
                </div>

            </div>
            
        </main>

        <!--Overlay.-->
        <div class="overlay-wrapper">
            <div class="overlay-box" id="overlayBody">
            </div>
        </div>
        
    </body>
</html>