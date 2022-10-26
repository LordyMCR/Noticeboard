<?php

require_once "header.php";
require_once "serverside_validation.php";

//  initally set form to false
$show_signin_form = false;

$message = "";
$username = $password = "";
$username_errors = $password_errors = "";
$errors = "";

//  if user is already logged in, block assess to the page and display message
if (isset($_SESSION['loggedIn']))
{
    echo "<p class='error'>You are already logged in, please log out first.</p><br>";
}
//  user has attempted to log in, check form data against database
elseif (isset($_POST['username']))
{   
    $username = $_POST['username'];
    $password = $_POST['password'];

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection)
    {
        die("Connection to database failed: " . $mysqli_connect_error);
    }

    //  gather the user entered values, sanitise and validate them using the php functions in the serverside_validation.php file. return error messages if it fails the sanitisation/validation
    $username = sanitise($username, $connection);
    $password = sanitise($password, $connection);
    $username_errors = validateString($username, 1, 32);
    $password_errors = validateString($password, 1, 64);
    $errors = $username_errors . $password_errors;

    //  if there are no error messages returned from the sanitisation/validation functions, go through the process of searching the database. else, display an error message
    if ($errors == "")
    {
        //  query to check if the username and password already exist on the database
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

        $result = mysqli_query($connection, $query);

        $n = mysqli_num_rows($result);

        //  if there is a match on the query, user exists - allow login. else, display signin form again and error message
        if ($n > 0)
        {
            // set a session variable to record that this user has successfully logged in:     
            $_SESSION['loggedIn'] = true;
            // set the username into the session data for use by the other scripts
            $_SESSION['username'] = $username;

            $message = "
            <div class='text-center' id='signout'><h3 class='h3 mb-3 font-weight-normal text-center'>Signed in</h3>
            <p>Hello, $username, you have successfully logged in.</p><p>Please <a href='index.php'>click here</a> to view the Noticeboard.</p></div><br>";
        
        }
        else
        {
            $show_signin_form = true;
            $message = "<p class='error'>User credentials not found, please try again.</p><br>";
        }
    }
    else
    {
       $message = "<p class='error'>Sign in failed, please try again.</p><br>";
    }

    //  close the connection when finished
    mysqli_close($connection);
}

//  user has arrived at the sign in page for the first time, display signin form to allow attempt of login
else
{
    $show_signin_form = true;
}

//  display signin form
if ($show_signin_form)
{
    echo <<<_END
    <div class="text-center" id="signin">
        <form class="form-group" action="sign_in.php" method="post">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <label for="usernameSignIn">Username</label><br>
            <small id="usernameHelpBlock" class="form-text text-muted">Enter your account username</small>
            <input type="text" class="form-control" placeholder="Username" minlength="1" maxlength="32" name="username" aria-describedby="usernameHelpBlock" required autofocus><br>
            <label for="passwordId">Password</label><br>
            <small id="passwordHelpBlock" class="form-text text-muted">Enter your account password</small>
            <input type="password" class="form-control" placeholder="Password" minlength="1" maxlength="64" id="passwordId" name="password" required>
            <div class="checkbox mb-3"><input type="checkbox" class="form-check-input" onClick="passwordToggle()">   Show Password<br></div>
            <input type="submit" class="btn btn-lg btn-primary btn-block" value="Sign in">
        </form>
    </div>
    <br>
_END;
}

echo $message;

require_once "footer.php";

?>