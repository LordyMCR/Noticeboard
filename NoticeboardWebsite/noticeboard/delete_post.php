<?php

require_once "header.php";

$message = "";
//  if user is not logged in, block assess to the page and display message
if (!isset($_SESSION['loggedIn']))
{
    echo "<p class='text-center'>You must be logged in to view this page.</p>";
}
else
{   
    //  gather the postid when the delete post button has been submitted
    $delete = $_POST['delete'];

    //  if delete button has been initialised and is not equal to an empty value, go through the process to delete the post. if not, display message saying no post data was received
    if (isset($delete) && $delete != "")
    { 
        $postid = $_POST['delete'];
    
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
        if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }

        //  delete the post with the matching postid
        $query = "DELETE FROM posts WHERE postid = '$postid';";

        //  if query is successfully executed, display message to user. else kill the connection and display an error message
        if (mysqli_query($connection, $query))
        {
            $message =
            "<div class='text-center' id='newpost'><h3 class='h3 mb-3 font-weight-normal text-center'>Post deleted! </h3>
            <p>You have successfully deleted the post from the Noticeboard.</p><p>Please <a href='index.php'>click here</a> to return to the Noticeboard.</p></div><br>";
        }
        else
        {
            die("Error deleting the post: " . mysqli_error($connection));
        }
    
        //  close the connection when finished
        mysqli_close($connection);    
    
    }
    else
    {
        echo "No post data was received. Go back and try again.<br>";
    }
}

echo $message;

require_once "footer.php";

?>