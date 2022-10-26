<?php

require_once "header.php";
require_once "serverside_validation.php";

//  initally set form to false
$show_admin_edituser_form = false;

$message = "";
$username = $password = $firstname = $lastname = $email = $age = $city = $county = $country = $phone = "";
$username_errors = $password_errors = $firstname_errors = $lastname_errors = $email_errors = $age_errors = $city_errors = $county_errors = $country_errors = $phone_errors = "";
$errors = "";

//  if user is not logged in, block assess to the page and display message
if (!isset($_SESSION['loggedIn']))
{
    echo "<p class='text-center'>You must be logged in as the admin to view this page. If you require to change your details when you signed up to your account, contact the admin.</p>";
}
else
{
    $username = $_SESSION['username'];

    //  if user is logged in but not as admin, block assess to the page and display message
    if ($username != "admin")
    {
        echo "<p class='text-center'>You must be logged in as the admin to view this page. If you require to change your details when you signed up to your account, contact the admin.</p>";
    }

    //  open page only if logged in as admin
    else
    {
        $update = $_POST['update'];

        //  if edit button has been initialised and is not equal to an empty value, show the form to allow user to edit the user. if not, display message saying no user data was received
        if (isset($update) && $update != "")
        { 
            $show_admin_edituser_form = true;
        }
        else
        {
            echo "<p class='text-center'>No user data was received. Go back and try again.</p>";
        }
    }
}

//  once the edit form has been submitted, go through the process of updating the details on the database
if(isset($_POST['username']))
{
    $uid = $_POST['update'];
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

    //  if there are no error messages returned from the sanitisation/validation functions, go through the process of updating the details on the database. else, display an error message
    if ($errors == "")
    {
        $query = "UPDATE users SET username = '$username', password = '$password', firstname = '$firstname', lastname = '$lastname', email = '$email', age = '$age', city = '$city', county = '$county', country = '$country', phone = '$phone' WHERE uid = $uid;";
            
        //  if query is successfully run, disable the forms and display the success message. else, kill the connection to the database and display the error message
        if (mysqli_query($connection, $query))
        {
            $show_admin_edituser_form = false;
            $message = 
            "<div class='text-center' id='newpost'><h3 class='h3 mb-3 font-weight-normal text-center'>User details edited! </h3>
            <p>You have successfully edited the user's details.</p><p>Please <a href='admin_manage_users.php'>click here</a> to return to the Manage Users page.</p></div>";

        }   
        else
        {
            die("Error editing the user details: " . mysqli_error($connection));
        }
    }
    else
    {
        echo "<p class='error'>Failed to edit user details, please try again.</p><br>";
    }

    //  close the connection when finished
    mysqli_close($connection);    

}

//  if the user is logged in as an admin, display this edit post form
if ($show_admin_edituser_form)
{
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    //  query to gather the already submitted values from the user details the admin is requesting to edit. prefill the input boxes with the values
    $query = "SELECT * FROM users WHERE uid = $update;";

    $result = mysqli_query($connection, $query);

    $row = mysqli_fetch_assoc($result);

    echo <<<_END
    <div class="text-center" id="edituser">    
        <form class="form-group" action="edit_user.php" method="post">
            <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
            <label for="usernameSignUp">Username</label><br>
            <small id="usernameHelpBlock" class="form-text text-muted">Username must be between 1 and 32 characters</small>
            <input type="text" class="form-control" placeholder="Username" minlength="1" maxlength="32" id="usernameEdit" name="username" aria-describedby="usernameHelpBlock" value="{$row['username']}" required autofocus><br>
            <label for="passwordId">Password</label><br>
            <small id="passwordHelpBlock" class="form-text text-muted">Password must be between 1 and 64 characters</small>
            <input type="password" class="form-control" placeholder="Password" minlength="1" maxlength="64" id="passwordId" name="password" aria-describedby="passwordHelpBlock" value="{$row['password']}" required>
            <input type="checkbox" class="form-check-input" id="flexCheckDefault" onClick="passwordToggle()">
            <label class="form-check-label" for="flexCheckDefault">Show Password</label><br><br>
            <label for="firstnameSignUp">First Name</label><br>
            <small id="firstnameHelpBlock" class="form-text text-muted">First Name must be between 1 and 64 characters</small>
            <input type="text" class="form-control" placeholder="e.g. John" minlength="1" maxlength="64" id="firstnameEdit" name="firstname" aria-describedby="firstnameHelpBlock" value="{$row['firstname']}" required><br>
            <label for="lastnameSignUp">Last Name</label><br>
            <small id="lastnameHelpBlock" class="form-text text-muted">Last Name must be between 1 and 64 characters</small>
            <input type="text" class="form-control" placeholder="e.g. Doe" minlength="1" maxlength="64" id="lastnameEdit" name="lastname" aria-describedby="lastnameHelpBlock" value="{$row['lastname']}" required><br>
            <label for="emailSignUp">Email Address</label><br>
            <small id="emailHelpBlock" class="form-text text-muted">Last Name must be between 3 and 64 characters and must include the @ symbol</small>
            <input type="email" class="form-control" placeholder="e.g. example@address.co.uk" minlength="3" maxlength="128" id="emailEdit" name="email" aria-describedby="emailHelpBlock" value="{$row['email']}" required><br>
            <label for="ageSignUp">Age</label><br>
            <small id="ageHelpBlock" class="form-text text-muted">Age must be a number between 1 and 999</small>
            <input type="number" class="form-control" placeholder="e.g. 20" min="1" max="999" id="ageEdit" name="age" aria-describedby="ageHelpBlock" value="{$row['age']}" required><br>
            <label for="citySignUp">City (optional)</label><br>
            <small id="cityHelpBlock" class="form-text text-muted">City must be between 1 and 32 characters</small>
            <input type="text" class="form-control" placeholder="e.g. Manchester" minlength="1" maxlength="32" id="cityEdit" name="city" aria-describedby="cityHelpBlock" value="{$row['city']}"><br>
            <label for="countySignUp">County (optional)</label><br>
            <small id="countyHelpBlock" class="form-text text-muted">County must be between 1 and 40 characters</small>
            <input type="text" class="form-control" placeholder="e.g. Lancashire" minlength="1" maxlength="40" id="countyEdit" name="county" aria-describedby="countyHelpBlock" value="{$row['county']}"><br>
            <label for="countrySignUp">Country (optional)</label><br>
            <small id="countryHelpBlock" class="form-text text-muted">Country must be between 1 and 60 characters</small>
            <input type="text" class="form-control" placeholder="e.g. United Kingdom" minlength="1" maxlength="60" id="countryEdit" name="country" aria-describedby="countryHelpBlock" value="{$row['country']}"><br>
            <label for="phoneSignUp">Phone Number (optional)</label><br>
            <small id="cityHelpBlock" class="form-text text-muted">Phone Number must be a number between 1 and 24 characters</small>
            <input type="text" class="form-control" placeholder="e.g. 01234567890" minlength="1" maxlength="24" pattern="[0-9]{0,24}" id="phoneEdit" name="phone" aria-describedby="phoneHelpBlock" value="{$row['phone']}"><br>
            <button name='update' type="submit" class="btn btn-lg btn-primary btn-block" value="$update" >Submit</button>
        </form>
    </div>
_END;
    
    //  close the connection when finished
    mysqli_close($connection);    
}

echo $message;

require_once "footer.php";

?>