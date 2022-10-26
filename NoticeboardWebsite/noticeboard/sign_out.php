<?php

require_once "header.php";

//  if user is not logged in, block assess to the page and display message
if (!isset($_SESSION['loggedIn']))
{
    echo "<p class='text-center'>You must be logged in to view this page.</p>";
}
//  if user is logged in, go through process of signing out
//  reset the session variable, reset cookies, destroy the session and display a successful message
else
{
    $_SESSION = array();

    setcookie(session_name(), "", time() - 2592000, '/');

    session_destroy();

    echo "<div class='text-center' id='signout'><h3 class='mb-3 font-weight-normal text-center'>Signed out</h3>";
    echo "You have successfully logged out, please <a href='index.php'>click here</a> to return to the Noticeboard</div><br>";

}

require_once "footer.php";

?>