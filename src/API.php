<?php
require_once "credentials.php";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$connection) {
    die("Connection failed: " . $mysqli_connect_error);
}
$query = "SELECT * FROM noticeboard.posts LEFT OUTER JOIN noticeboard.users u on posts.uid = u.uid";
if (isset($_COOKIE['sort'])) {
    $query .= " ORDER BY " . $_COOKIE['sort'];
}

$result = mysqli_query($connection, $query);

$n = mysqli_num_rows($result);
$response = array();
if ($n > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
//
    }
} else {
    echo "No data was received, please try again";

}
echo json_encode($response);
mysqli_close($connection);

