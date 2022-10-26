<?php

require_once "header.php";
require_once "serverside_validation.php";

//  initally set form to false
$show_signup_form = false;

$message = "";
$username = $password = $firstname = $lastname = $email = $age = $city = $county = $country = $phone = "";
$username_errors = $password_errors = $firstname_errors = $lastname_errors = $email_errors = $age_errors = $city_errors = $county_errors = $country_errors = $phone_errors = "";
$errors = "";

//  if user is logged in, block assess to the page and display message
if (isset($_SESSION['loggedIn']))
{
    echo "<p class='text-center'>You are already logged in, please log out first.</p>";
}
//  user has attempted to log in, check form data against database
elseif (isset($_POST['username']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $city = $_POST['city'];
    $county = $_POST['county'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    //  gather the user entered values, sanitise and validate them using the php functions in the serverside_validation.php file. return error messages if it fails the sanitisation/validation
    $username = sanitise($username, $connection);
    $password = sanitise($password, $connection);
    $firstname = sanitise($firstname, $connection);
    $lastname = sanitise($lastname, $connection);
    $email = sanitise($email, $connection);
    $age = sanitise($age, $connection);
    $city = sanitise($city, $connection);
    $county = sanitise($county, $connection);
    $country = sanitise($country, $connection);
    $phone = sanitise($phone, $connection);

    $username_errors = validateString($username, 1, 32);
    $password_errors = validateString($password, 1, 64);
    $firstname_errors = validateString($firstname, 1, 64);
    $lastname_errors = validateString($lastname, 1, 64);
    $email_errors = validateEmail($email);
    $age_errors = validateInt($age, 1, 999);
    $city_errors = validateString($city, 0, 32);
    $county_errors = validateString($county, 0, 40);
    $country_errors = validateString($country, 0, 60);
    $phone_errors = validatePhone($phone);

    $errors = $username_errors . $password_errors . $firstname_errors . $lastname_errors . $email_errors . $age_errors . $city_errors . $county_errors . $country_errors . $phone_errors;

    //  if there are no error messages returned from the sanitisation/validation functions, go through the process of searching the database. else, display an error message
    if ($errors == "") {

        //  query to check if the username and password already exist on the database, or if username is already taken
        $query = "SELECT * FROM users WHERE username='$username' OR (username='$username' AND password='$password')";
        $result = mysqli_query($connection, $query);

        $n = mysqli_num_rows($result);
        
        //  if there is a match on the query, user already exists - show signup form and error message.
        if ($n > 0)
        {

            $show_signup_form = true;
        
            $message = "<p class='error'>Username already exists, try a different username.</p><br>";

        }
        //  if user does not exist on database, go through process of inserting the data into the database
        else 
        {
            $query = "INSERT INTO users (username, password, firstname, lastname, email, age, city, county, country, phone) VALUES ('$username', '$password', '$firstname', '$lastname', '$email', '$age', '$city', '$county', '$country', '$phone')";
            
            if (mysqli_query($connection, $query))
            {
                $message = 
                "<div class='text-center' id='newpost'><h3 class='h3 mb-3 font-weight-normal text-center'>User account created! </h3>
                <p>You have successfully created a new account.</p><p>Please <a href='sign_in.php'>click here</a> to log in.</p></div><br>";
    
            }
            else
            {
                die("Error creating the new account: " . mysqli_error($connection));
            }
        }
    }
    else
    {
        echo "<p class='error'>Sign up failed, please try again.</p><br>";
    }
    //  close the connection when finished
    mysqli_close($connection);
}

//  user has arrived at the sign up page for the first time, display signup form to allow attempt of signup
else
{
    $show_signup_form = true;
}

//  display signin form
if ($show_signup_form)
{
    echo<<<_END
    <div class="text-center" id="signup">    
        <form class="form-group" action="sign_up.php" method="post">
            <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
            <label for="usernameSignUp">Username</label><br>
            <small id="usernameHelpBlock" class="form-text text-muted">Username must be between 1 and 32 characters</small>
            <input type="text" class="form-control" placeholder="Username" minlength="1" maxlength="32" id="usernameSignUp" name="username" aria-describedby="usernameHelpBlock" required autofocus><br>
            <label for="passwordId">Password</label><br>
            <small id="passwordHelpBlock" class="form-text text-muted">Password must be between 1 and 64 characters</small>
            <input type="password" class="form-control" placeholder="Password" minlength="1" maxlength="64" id="passwordId" name="password" aria-describedby="passwordHelpBlock" required>
            <input type="checkbox" class="form-check-input" id="flexCheckDefault" onClick="passwordToggle()">
            <label class="form-check-label" for="flexCheckDefault">Show Password</label><br><br>
            <label for="firstnameSignUp">First Name</label><br>
            <small id="firstnameHelpBlock" class="form-text text-muted">First Name must be between 1 and 64 characters</small>
            <input type="text" class="form-control" placeholder="e.g. John" minlength="1" maxlength="64" id="firstnameSignUp" name="firstname" aria-describedby="firstnameHelpBlock" required><br>
            <label for="lastnameSignUp">Last Name</label><br>
            <small id="lastnameHelpBlock" class="form-text text-muted">Last Name must be between 1 and 64 characters</small>
            <input type="text" class="form-control" placeholder="e.g. Doe" minlength="1" maxlength="64" id="lastnameSignUp" name="lastname" aria-describedby="lastnameHelpBlock" required><br>
            <label for="emailSignUp">Email Address</label><br>
            <small id="emailHelpBlock" class="form-text text-muted">Last Name must be between 3 and 64 characters and must include the @ symbol</small>
            <input type="email" class="form-control" placeholder="e.g. example@address.co.uk" minlength="3" maxlength="128" id="emailSignUp" name="email" aria-describedby="emailHelpBlock" required><br>
            <label for="ageSignUp">Age</label><br>
            <small id="ageHelpBlock" class="form-text text-muted">Age must be a number between 1 and 999</small>
            <input type="number" class="form-control" placeholder="e.g. 20" min="1" max="999" id="ageSignUp" name="age" aria-describedby="ageHelpBlock" required><br>
            <label for="citySignUp">City (optional)</label><br>
            <small id="cityHelpBlock" class="form-text text-muted">City must be between 1 and 32 characters</small>
            <input type="text" class="form-control" placeholder="e.g. Manchester" minlength="1" maxlength="32" id="citySignUp" name="city" aria-describedby="cityHelpBlock"><br>
            <label for="countySignUp">County (optional)</label><br>
            <small id="countyHelpBlock" class="form-text text-muted">County must be between 1 and 40 characters</small>
            <input type="text" class="form-control" placeholder="e.g. Lancashire" minlength="1" maxlength="40" id="countySignUp" name="county" aria-describedby="countyHelpBlock"><br>
            <label for="countrySignUp">Country (optional)</label><br>
            <small id="countryHelpBlock" class="form-text text-muted">Country must be between 1 and 60 characters</small>
            <input type="text" class="form-control" placeholder="e.g. United Kingdom" minlength="1" maxlength="60" id="countrySignUp" name="country" aria-describedby="countryHelpBlock"><br>
            <label for="phoneSignUp">Phone Number (optional)</label><br>
            <small id="cityHelpBlock" class="form-text text-muted">Phone Number must be a number between 1 and 24 characters</small>
            <input type="text" class="form-control" placeholder="e.g. 01234567890" minlength="1" maxlength="24" pattern="[0-9]{0,24}" id="phoneSignUp" name="phone" aria-describedby="phoneHelpBlock"><br>
            <input type="submit" class="btn btn-lg btn-primary btn-block" value="Sign up">
        </form>
    </div>
_END;
}

echo $message;

require_once "footer.php";

?>