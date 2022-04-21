<?php
//var_dump($_POST);
require_once "credentials.php";
require_once "cleanup.php";
session_start();
echo "</select>";
echo <<< _END
    <!DOCTYPE html>
    <head>
        <title>Noticeboard</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link id="theme" rel="stylesheet" href="../css/style.css">
    </head>
    <body onload="updateClock();">
   
    <div id="date"></div>
    <div id="sorted" class='container'>
     <nav class="nav">
            <a href="index.php"><h1 class="navbar-brand">Myth's Notices</h1></a>
_END;

if (isset($_SESSION['username'])) {
    echo <<<_END
            <li class="nav-item">         
                <a href="create_post.php">create post </a> 
            </li>
            <li class="nav-item">         
                <a href="your_posts.php">your posts </a> 
            </li>
            <li>
                <a href="manage_users.php">manage users </a>
            </li>
            <li class="nav-item">
                <a href='sign_out.php'>sign out ({$_SESSION['username']})</a>   
            </li>     
                         
_END;
} else {
    echo <<<_END
 
            <li class="nav-item">
                <a class="nav-link" href='index.php'>home </a> 
            </li>
            <li class="nav-item">         
                <a href="create_post.php">create post </a> 
            </li>
            <li class="nav-item">
                <a class="nav-link" href='sign_up.php'>sign up </a> 
            </li>
            <li class="nav-item">
                <a class="nav-link" href='sign_in.php'>sign in </a>
            </li>
_END;
}
echo "<button onclick='changeMode()' type=\"button\" id='changeStyle' class=\"btn btn-dark margin-left-0 \"> <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"35\" height=\"35\" fill=\"currentColor\" class=\"bi bi-brightness-low\" viewBox=\"0 0 16 16\">
  <path d=\"M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm.5-9.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 11a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm5-5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm-11 0a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9.743-4.036a.5.5 0 1 1-.707-.707.5.5 0 0 1 .707.707zm-7.779 7.779a.5.5 0 1 1-.707-.707.5.5 0 0 1 .707.707zm7.072 0a.5.5 0 1 1 .707-.707.5.5 0 0 1-.707.707zM3.757 4.464a.5.5 0 1 1 .707-.707.5.5 0 0 1-.707.707z\"/>
</svg><span class='align-text-top'>Light mode</span></button> ";
echo "</nav><div id=\"clock\"></div>";
?>