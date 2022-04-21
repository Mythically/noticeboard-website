<?php
require_once "header.php";
if (isset($_POST['postidRemove'])) {
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (!$connection) {
        die("Connection failed: " . $mysqli_connect_error);
    }

    $query = "DELETE FROM posts WHERE postid = {$_POST['postidRemove']}";
    $result = mysqli_query($connection, $query);

    if ($result)
        header("Location: index.php");

}

require_once "footer.php";