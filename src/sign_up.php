<?php

require_once 'header.php';
if (isset($_SESSION['username'])) {
    echo "Please sign out first";
}
if (isset($_POST['username'])) {
    $errors = "";
//        print_r(fetch_users($_POST));
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection) {
        die("Connection failed: " . $mysqli_connect_error);
    }

    $username = sanitise($_POST['username'], $connection);
    $password = sanitise($_POST['password'], $connection);
    $firstname = sanitise($_POST['firstname'], $connection);
    $lastname = sanitise($_POST['lastname'], $connection);
    $email = sanitise($_POST['email'], $connection);
    $age = sanitise($_POST['age'], $connection);
    $city = sanitise($_POST['city'], $connection);
    $county = sanitise($_POST['county'], $connection);
    $country = sanitise($_POST['country'], $connection);
    $phone = sanitise($_POST['phone'], $connection);


    $username_errors = validateString($username, 1, 32);
    $password_errors = validateString($password, 1, 64);
    $firstname_errors = validateString($firstname, 1, 64);
    $lastname_errors = validateString($lastname, 1, 64);
    $email_errors = validateString($email, 5, 128);
    $age_errors = validateInt($age, 1, 999);
    $city_errors = validateString($city, 1, 32);
    $county_errors = validateString($county, 1, 40);
    $country_errors = validateString($country, 1, 60);
    $phone_errors = validateInt($phone, 1, 999999999999999999999999);

    $errors = $username_errors . $password_errors . $firstname_errors . $lastname_errors . $email_errors . $age_errors . $city_errors . $county_errors . $country_errors . $phone_errors;
    if ($errors == "") {
        $query = "INSERT INTO noticeboard.users(username,password,firstname, lastname, email, age, city, county, country, phone) VALUES ('$username','$password', '$firstname','$lastname','$email','$age','$city','$county','$county','$phone')";

        $result = mysqli_query($connection, $query);


        if ($result) {
            $message = "<p>Sign up was successful, please return home</p><br>";
            header("location:sign_in.php");
        } else {
            $message = "<p>Sign up failed, please try again</p><br>";

        }

        echo $message . $errors;


        mysqli_close($connection);
    }


} else {

    echo <<<_END
    <div class="sign-up-container">
    <h2>Sign Up</h2>
    
    <form method="POST" action="sign_up.php">
        <h4>Create your login details</h4>
        <div class="form-group">
        <label  for="username" id="username">Username: </label>
        <input class="form-control form-control-sm" type="text" minlength="1" maxlength="32" name="username" required> 
        </div>
        <div class="form-group">
        <label for="password" id="password">Password: </label>
        <input class="form-control form-control-sm" name="password" type="password" minlength="1"  maxlength="64">
        </div>
        <div class="form-group">
        <label for="firstname" id="firstname">Firstname: </label>
        <input class="form-control form-control-sm" name="firstname" type="text" minlength="1"  maxlength="64" required>
        </div>
        <div class="form-group">
        <label for="lastname" id="lastname">Lastname: </label>
        <input class="form-control form-control-sm" name="lastname" type="text" minlength="1"  maxlength="64" required>
        </div>
        <div class="form-group">
        <label for="email" id="email">Email: </label>
        <input class="form-control form-control-sm" name="email" type="email"  maxlength="128" required>
        </div>
        <div class="form-group">
        <label for="age" id="age">Age: </label>
        <input class="form-control form-control-sm" name="age" type="number" minlength="1" maxlength="3" required>
        </div>
        <div class="form-group">
        <label for="city" id="city">City: </label>
        <input class="form-control form-control-sm" name="city" type="text" minlength="1" maxlength="32" required>
        </div>
        <div class="form-group">
        <label for="county" id="county">County: </label>
        <input class="form-control form-control-sm" name="county" type="text" minlength="1" maxlength="40" required>
        </div>
        <div class="form-group">
        <label for="country" id="country">Country: </label>
        <input class="form-control form-control-sm" name="country" type="text" minlength="1" maxlength="60" required>
        </div>
        <div class="form-group">
        <label for="phone" id="phone">Phone: </label>
        <input class="form-control form-control-sm" name="phone" type="number" minlength="1" maxlength="24" required>
        </div>
        <br>
        <div class="form-group">
        
        
        <button  class="btn btn-primary" type="submit">Submit</button>
    </form>
</div>
_END;

}

require_once "footer.php";

