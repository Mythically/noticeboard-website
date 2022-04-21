<?php


require_once "header.php";

if (!isset($_SESSION['username'])) {
    // user isn't logged in, display a message saying they must be:
    echo "You must be logged in to view this page.<br>";
    header("location sign_in.php");
} else {
    //cleanup
    $_SESSION = array();
    setcookie(session_name(), "", time() - 2592000, '/');
    session_destroy();

    echo "You have successfully logged out, please <a href='index.php'>click here</a><br>";
    header("location: index.php");
}

// finish of the HTML for this page:
require_once "footer.php";

?>