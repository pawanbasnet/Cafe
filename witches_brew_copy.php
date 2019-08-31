<?php
session_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title> Witches Brew! </title>
    <meta charset="utf-8" />

    <?php
    
    require_once("login.php");
    require_once("menu_list.php");
    require_once("hsu_conn_sess.php");
    ?>
    
    <link rel="stylesheet" media="all" href="witches_brew.css">

 </head>

<body>
    <div class="content">
    <h1> Welcome to Witches Brew! </h1>
    <?php
    if (!array_key_exists('next-stage', $_SESSION)) {
        login();
        $_SESSION['next-stage'] = "menu_list";
    }
    elseif ($_SESSION['next-stage'] == "menu_list")
    {
        menu_list();
        session_destroy();
    }


    else {
        ?>
        <p> <strong> YIKES! should NOT have been able to reach
                here! </strong> </p>
        <?php

        session_destroy();
        session_start();

        login();
        $_SESSION['next-stage'] = "menu_list";
    }
    ?>
    </div>