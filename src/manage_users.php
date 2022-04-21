<?php
require_once "header.php";
include_once "nationality.php";
if (isset($_POST["uid"]) && $_SESSION['username'] == "admin") {

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    $query = "SELECT * FROM users WHERE uid = \"{$_POST['uid']}\"";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo <<<_END
            <h2>Edit user</h2>
            <form id="edit-user-form" action="update_user.php" class="form-group" method="POST">
            <h5>Edit the user's login details</h5>
            <input hidden="true" name="uid" value="{$row['uid']}">
            <div class="form-group">
            <label  for="username" id="username">Username: </label>
            <input class="form-control" placeholder="{$row['username']}" name="username" type="text" minlength="1" maxlength="32" required><br>
            </div>
            <div class="form-group">
            <label for="password" id="password">Password: </label>
            <input class="form-control" placeholder="{$row['password']}" name="password" type="password" minlength="1"  maxlength="64"required><br/>
            </div>
            <div class="form-group">
            <label for="firstname" id="firstname">Firstname: </label>
            <input class="form-control" placeholder="{$row['firstname']}" name="firstname" type="text" minlength="1"  maxlength="64"required><br/>
            </div>
            <div class="form-group">
            <label for="lastname" id="lastname">Lastname: </label>
            <input class="form-control" placeholder="{$row['lastname']}" name="lastname" type="text" minlength="1"  maxlength="64" required><br/>
            </div>
            <div class="form-group">
            <label for="email" id="email">Email: </label>
            <input class="form-control" placeholder="{$row['email']}" name="email" type="email"  maxlength="128" required><br/>
            </div>
            <div class="form-group">
            <label for="age" id="age">Age: </label>
            <input class="form-control" placeholder="{$row['age']}" name="age" type="number" minlength="1" maxlength="3" required><br/>
            </div>
            <div class="form-group">
            <label for="city" id="city">City: </label>
            <input class="form-control" placeholder="{$row['city']}" name="city" type="text" minlength="1" maxlength="32" required><br/>
            </div>
            <div class="form-group">
            <label for="county" id="county">County: </label>
            <input class="form-control" placeholder="{$row['county']}" name="county" type="text" minlength="1" maxlength="40" required><br/>
            </div>
            <div class="form-group">
            <label for="country" id="country">Country: </label>
            <input class="form-control" placeholder="{$row['country']}" name="country" type="text" minlength="1" maxlength="60" required><br/>
            </div>
            <div class="form-group">
            <label for="phone" id="phone">Phone: </label>
            <input class="form-control" placeholder="{$row['phone']}" name="phone" type="number" minlength="1" maxlength="24" required><br/>
            <button class="btn btn-primary" type="submit">Submit</button>
            </form>
            <form method="POST" action="remove_user.php">
            <button class="btn btn-danger" name="uid" value="{$row['uid']}" type="submit">Delete User</button>
            </form>
            _END;

    }
} elseif (isset($_SESSION['username'])) {
    if ($_SESSION['username'] == 'admin') {
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        $query = "SELECT * FROM users";


    } else {
        header("Location: index.php");
    }

    $result = mysqli_query($connection, $query);

    $n = mysqli_num_rows($result);
    $all = array();
    while ($rows = mysqli_fetch_assoc($result)) {
        $all[] = $rows;
    }
    echo "<div class='row'>";
    for ($row = 0; $row < sizeof($all); $row++) {
        $randomPaddingTop = rand(0, 100);
        echo <<<_END
    
         
            <div id="user-card"  class='col-xl-3 col-lg-3 col-sm-5' >
            <form id="form" onclick="clicky($(this))" method="post" action="manage_users.php">
            <input name="uid"  type="hidden" value="{$all[$row]['uid']}">
                <h3 style="padding-top: {$randomPaddingTop}px">{$all[$row]['username']} </h3>
                <p>{$all[$row]['password']}</p>
                <p>{$all[$row]['firstname']}</p>
                <p>{$all[$row]['lastname']}</p>
                <p>{$all[$row]['email']}</p>
                <p>{$all[$row]['age']}</p>
                <p>{$all[$row]['city']}</p>
                <p>{$all[$row]['county']}</p>
                <p>{$all[$row]['country']}</p>
                <p>{$all[$row]['phone']}</p>
                </form>
                <button  class="btn btn-primary" onclick="getNat2('{$all[$row]['firstname']}')" >Nationality</button>
            
            </div>
 _END;
    }
    echo "</div>";
    mysqli_close($connection);


} else {
    header('Location: sign_in.php');
}
require_once "footer.php";
