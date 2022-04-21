<?php
require_once "header.php";
if (isset($_SESSION['username'])) {
    $query = "SELECT * FROM noticeboard.posts INNER JOIN noticeboard.users USING (uid) WHERE username = \"{$_SESSION['username']}\"";

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    $errors = "";
    if (!$connection) {
        die("Connection failed: " . $mysqli_connect_error);
    }
    $result = mysqli_query($connection, $query);
    echo "<div class='row'>";

    $n = mysqli_num_rows($result);
    if ($n > 0)
        while ($rows = mysqli_fetch_assoc($result)) {
            $postid = $rows['postid'];
            if (isset($rows['firstname'])) {
                $names = $rows['firstname'];
                $names .= " " . $rows['lastname'];
            } else {
                $names = "Anonymous";
            }
            $title = $rows['title'];
            $created = $rows['created'];
            $content = $rows['content'];
            $img = $rows['image'];

            echo <<<_END
        
            <div class='col-xl-3 col-lg-4 col-sm-6'>
            <div class="card">
            <div class="card-body">
            <img id="img" src="$img" alt="$img">
            <h5>$title</h5> 
            <p>$names</p>
            <p>$created</p>
            <p>$content</p>
            <form name="postidUpdate" method="POST" action="update_post.php">
            <button name="postidUpdate" type="submit"  value="$postid"  class="btn btn-primary">Update</button>
            </form>
             <form  name="postidRemove"  method="POST" action="remove_post.php">
            <button name="postidRemove" type="submit" value="$postid"  class="btn btn-danger" >Remove</button>
            </form>
        
            </div>
            </div>
            </form>
            </div>
         

_END;
        }
    echo "</div>";
} else {
    header("Location: sign_in.php");
}
require_once "footer.php";
