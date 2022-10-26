<?php

require_once "header.php";

$message = "";

//  if user is not logged in, block assess to the page and display message
if (!isset($_SESSION['loggedIn']))
{
    echo "<p class='text-center'>You must be logged in as the admin to view this page. If you require to delete your account, contact the admin.</p>";
}
else
{
    $username = $_SESSION['username'];

    //  if user is logged in but not as admin, block assess to the page and display message
    if ($username != "admin")
    {        
        echo "<p class='text-center'>You must be logged in as the admin to view this page. If you require to delete your account, contact the admin.</p>";
    }
    else
    {
        //  gather the uid when the delete post button has been submitted
        $delete = $_POST['delete'];
        
        //  if delete button has been initialised and is not equal to an empty value, go through the process to delete the user. if not, display message saying no user data was received
        if (isset($delete) && $delete != "")
        { 
            $uid = $_POST['delete'];
        
            $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        
            if (!$connection)
            {
                die("Connection failed: " . $mysqli_connect_error);
            }

            //  delete the user with the matching postid
            $query = "DELETE FROM users WHERE uid = '$uid';";

            //  if query is successfully executed, display message to user. else kill the connection and display an error message
            if (mysqli_query($connection, $query))
            {
                $message = 
                "<div class='text-center' id='newpost'><h3 class='h3 mb-3 font-weight-normal text-center'>User deleted! </h3>
                <p>You have successfully deleted the user.</p><p>Please <a href='admin_manage_users.php'>click here</a> to return to the Manage Users page.</p></div><br>";
            }
            else
            {
                die("Error deleting the user: " . mysqli_error($connection));
            }
        
            //  close the connection when finished
            mysqli_close($connection);    
        
        }
        else
        {
            echo "No user data was received. Go back and try again.<br>";
        }
    }
}

echo $message;

require_once "footer.php";

?>