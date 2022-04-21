<?php
require_once "header.php";
if (isset($_SESSION['username'])) {
    if (isset($_POST['postid'])) {
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        if (!$connection) {
            die("Connection failed: " . $mysqli_connect_error);
        }

        $title = sanitise($_POST['title'], $connection);
        $created = sanitise($_POST['created'], $connection);;
        $content = sanitise($_POST['content'], $connection);;
        $image = sanitise($_POST['image'], $connection);;
        $postid = sanitise($_POST['postid'], $connection);;


        $title_errors = validateString($title, 1, 120);
        $created_errors = validateString($created, 20, 22);
        $content_errors = validateString($content, 1, 800);
        $imagine_errors = validateString($image, 1, 64);
        $errors = "";
        $errors = $title_errors . $created_errors . $content_errors . $imagine_errors;
        $query = "UPDATE posts SET title = '{}', created = '{$_POST['created']}', content = '{$_POST['content']}', image = '{$_POST['image']}' WHER Epostid = '{$_POST['postid']}' ";

        $result = mysqli_query($connection, $query);
        if ($errors = "") {
            if ($result) {
                echo "yay?";
                header("Location: index.php");
            }
            $indexes = [];
            foreach ($_POST as $key => $value) {
                $indexes[] = $key;
            }
        } else {
            echo "Try again, use the correct values this time,";
        }

    } elseif (isset($_POST['postidUpdate'])) {
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        if (!$connection) {
            die("Connection failed: " . $mysqli_connect_error);
        }
        $query = "SELECT postid, title, created, content, image FROM posts WHERE postid = '{$_POST['postidUpdate']}'";

        $result = mysqli_query($connection, $query);

        $n = mysqli_num_rows($result);

        if ($n > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $postid = $row['postid'];
                $title = $row['title'];
                $created = $row['created'];
                $content = $row['content'];
                $img = $row['image'];
            }

            $_POST['created'] = $created;
        } else {
            echo "Query failed, please try again";
        }
        echo <<<_END
<form id="update-post-form" name="postid" action="update_post.php" value="$postid" method="POST" >
            <div class="form-group">
            <label for="title">Title: </label>
            <input class="form-control" name="title" type="text" placeholder="{$title}"><br>
            </div>
            <div class="form-group">
            <label for="created">Created: </label>
            <input class="form-control" name="created" value="{$created}" placeholder="{$created}"><br>
            </div>
            <div class="form-group">
            <label  for="content">Content: </label>
            <textarea class="form-control" name="content" placeholder="{$content}"></textarea><br>
            </div>
            <div class="form-group">
            <label for="image">Image: </label>
            <input class="form-control" name="image" placeholder="{$img}"> <br>
            </div>
            <button name="postid" type="submit" class="btn btn-primary"  value="{$postid}">Update post</button>
        </div>
</form>
         
_END;

    }
} else {
    header("location: sign_in.php");
}

require_once "footer.php";