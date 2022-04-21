<?php
require_once "header.php";
if (isset($_POST['uid']) && ($_SESSION['username'] == "admin")) {
    echo "we're in boissssssss";
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (!$connection) {
        die("Connection failed: " . $mysqli_connect_error);
    }

    $query = "DELETE FROM noticeboard.users WHERE uid = '{$_POST['uid']}'";
    $result = mysqli_query($connection, $query);

    if ($result)
        header("Location: manage_users.php");
}
require_once "footer.php";
