<?php
require_once "header.php";
if (isset($_POST['uid']) && $_SESSION['username'] == "admin") {

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    $errors = "";
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
        $query = "UPDATE users SET username = '{$username}', password = '{$password}', firstname = '{$firstname}', lastname = '{$lastname}', email = '{$email}', age = '{$age}', city = '{$city}', county = '{$county}', country = '{$country}', phone = '{$phone}' WHERE uid = '{$_POST['uid']}'  ";

        if (mysqli_query($connection, $query)) {
            echo "Record updated successfully";
            header("Location: manage_users.php");
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        echo $errors;
        mysqli_close($connection);
    }
}


require_once "footer.php";