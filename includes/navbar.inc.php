<?php
    //Get url.
    $url = $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];
 
    //Check if user is logged in (only admin can log in).
    if (isset($_SESSION["userID"])) {

        echo "<ul class='nav nav-pills admin-navbar' style=\"z-index:1000\">";
   
        echo "<li class='nav-link admin-navbar-header'><span class='admin-burger-menu' onclick='toggleAdminNav()'>&#9776;</span>".$_SESSION['username']."</li>";
        echo "<li class='nav-item admin-nav-item'>"; 
        echo "<a class='nav-link nav-link-admin' href='".LinkUrl::LINKURL."index'>Index</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<a class='nav-link nav-link-admin' href='".LinkUrl::LINKURL."write'>Write</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<a class='nav-link nav-link-admin' href='".LinkUrl::LINKURL."files'>Files</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<a class='nav-link nav-link-admin' href='".LinkUrl::LINKURL."categories'>Categories</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<a class='nav-link nav-link-admin' href='".LinkUrl::LINKURL."channels'>Channels</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<a class='nav-link nav-link-admin' href='".LinkUrl::LINKURL."calendar'>Articles</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<a class='nav-link nav-link-admin' href='".LinkUrl::LINKURL."account'>Account</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<a class='nav-link nav-link-admin' href='".LinkUrl::LINKURL."FAQ'>FAQ</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<button class='button-logout' type='button' onclick='logout()'><i class='fas fa-sign-out-alt'></i></button>";
        echo "</li>";
        echo "</ul>";
    } 
?>