<?php
require_once "header.php";
$errors = "";
$image = "";
$uid = "";

if (isset($_SESSION['username'])) {

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection) {
        die("Connection failed: " . $mysqli_connect_error);
    }

    $uidQuery = "SELECT uid FROM users WHERE username=\"{$_SESSION['username']}\"";
    $uidResult = mysqli_query($connection, $uidQuery);
    while ($row = mysqli_fetch_assoc($uidResult)) {
        $uid = $row['uid'];
    }
}
if (isset($_POST['title'])) {
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection) {
        die("Connection failed: " . $mysqli_connect_error);
    }
    $title = sanitise($_POST['title'], $connection);
    $content = sanitise($_POST['content'], $connection);
    $image = sanitise($_POST['image'], $connection);

    $title_errors = validateString($title, 1, 120);
    $content_errors = validateString($content, 1, 8000);
    $img_errors = validateString($image, 0, 64);
    $created = gmdate("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);

    $errors = $title_errors . $content_errors . $img_errors;


    if ($errors == "") {
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        if (!$connection) {
            die("Connection failed: " . $mysqli_connect_error);
        }

        if ($uid != "") {
            if ($image != "") {
                $query = "INSERT INTO posts (uid, title, created, content, image) VALUES ('$uid', '$title', '$created', '$content' '$image')";
            } else {
                $query = "INSERT INTO posts (uid, title, created, content) VALUES ('$uid', '$title', '$created', '$content')";
            }
        } else {
            if ($image != "") {
                $query = "INSERT INTO posts (title, created, content, image) VALUES ('$title', '$created', '$content', '$image')";
            } else {
                $query = "INSERT INTO posts (title, created, content) VALUES ('$title', '$created', '$content')";
            }
        }

        $result = mysqli_query($connection, $query);

    }
    if (isset($result)) {
        $message = "Post was created successfully, please return home<br>";
        header("location:index.php");
    } else {
        $message = "Post failed, please try again<br>";
    }
    echo $message . $errors;

    mysqli_close($connection);

} else {
    echo <<<_END

<h4>Create your post</h4>
<form id="create_post" method="POST" action="create_post.php">
    
    <div class="form-group">
        <label for="title" id="title">Title: </label>
        <input class="form-control" type="text" minlength="1" maxlength="120" name="title" required> <br>
    </div>
        <label for="content" id="content">Content: </label>
        <textarea name="content" class="form-control" minlength="1"  maxlength="800" required></textarea><br/>
        <label for="image" id="img">Image: </label>
        <input class="form-control" type="text" minlength="0" maxlength="64" name="image"> <br>
        <button onclick="refreshBody()" class="btn btn-primary"  type="submit">Submit</button>
    
</form>


_END;
}

require_once "footer.php";