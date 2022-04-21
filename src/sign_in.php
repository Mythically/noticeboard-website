<?php


require_once "header.php";

$show_signin_form = false;
$message = "";

$username = "";
$password = "";

$username_errors = "";
$password_errors = "";

$errors = "";

//if username is set, you're logged in, if not, you're not
if (isset($_SESSION['username'])) {

    echo "<br><h1>You are already logged in, please log out first.</h1><br>";

} elseif (isset($_POST['username'])) {


    $username = $_POST['username'];
    $password = $_POST['password'];

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection) {
        die("Connection failed: " . $mysqli_connect_error);
    }

    $username = sanitise($username, $connection);
    $password = sanitise($password, $connection);

    $username_errors = validateString($username, 1, 32);
    $password_errors = validateString($password, 1, 64);

    $errors = $username_errors . $password_errors;


    if ($errors == "") {

        $query = "SELECT * FROM noticeboard.users WHERE username='$username' AND password='$password'";

        $result = mysqli_query($connection, $query);

        $n = mysqli_num_rows($result);

        if ($n > 0) {
            $_SESSION['username'] = $_POST['username'];

            $message = "Hi, {$_SESSION['username']}, you have successfully logged in, please <a href='index.php'>click here</a><br>";
            header("location: index.php");

        } else {
            $show_signin_form = true;
            $message = "Sign in failed, please try again<br>";
            header("Location: sign_in.php");
        }

        mysqli_close($connection);

    } else {
        echo "<b>Sign-in Failed";
        echo "<br><br></b>";
        $show_signin_form = true;
    }
} else {

    $show_signin_form = true;
}


if ($show_signin_form) {
    echo <<<_END
<form id="sing-in-form" action="sign_in.php" method="post">
  <h5>Sign in:</h5>
  <div class="form-group">
  <label for="username">Username:</label> 
  <input class="form-control form-control-sm" type="text" minlength="1" maxlength="32" name="username" required>
  </div>
  <br>
  <div class="form-group">
  <label for="password">Password:</label>
  <input class="form-control form-control-sm" type="password" minlength="1" maxlength="64" name="password" required>
  </div>
  <br>
  <button class="btn btn-primary" type="submit" value="Sign-In">sign in</button>
</form>	
_END;
}


echo $message;

require_once "footer.php";
