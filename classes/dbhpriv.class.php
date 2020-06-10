<?php 
    //Database and server constants (only for dbh.class.php).
    interface DatabaseConst {
    
        /*
            This extra interface is used, so Geert and I don't have to change the values everytime we
            Take the project from GitHub since we won't upload this file to GitHub and keep our own version.
        */
        
        //Declare constants.
        const SERVERNAME = "localhost";
        const USERNAME = "root";
        const PASSWORD = "";
        const DBNAME = "nicms";
    }
    //Url constants. (for all classes).
    interface LinkUrl {
        //Complete link of the website.
        const LINKURL = "//localhost/Websites/nicms/";
    }
?>