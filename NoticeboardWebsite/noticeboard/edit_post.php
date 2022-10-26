<?php

require_once "header.php";
require_once "serverside_validation.php";

//  initally set forms to false
$show_editpost_form = false;
$show_admin_editpost_form = false;

$message = "";
$title = $content = $image = "";
$title_errors = $content_errors = $image_errors = "";
$errors = "";

//  if user is not logged in, block assess to the page and display message
if (!isset($_SESSION['loggedIn']))
{
    echo "<p class='text-center'>You must be logged in to view this page.</p>";
}
//  if user is logged in but not as admin, show edit form specifically for non-admin users if update button value has been posted successfully
elseif (($_SESSION['username']) != "admin")
{    
    $update = $_POST['update'];

    //  if edit button has been initialised and is not equal to an empty value, show the form to allow user to edit the post. if not, display message saying no post data was received
    if (isset($update) && $update != "")
    { 
        $show_editpost_form = true;
    }
    else
    {
        echo "<p class='text-center'>No post data was received. Go back and try again.</p>";
    }
}

//  if user is logged in as admin, show edit form specifically for admin users if update button value has been posted successfully
else
{    
    $update = $_POST['update'];

    //  if edit button has been initialised and is not equal to an empty value, show the form to allow admin to edit the post. if not, display message saying no post data was received
    if (isset($update) && $update != "")
    { 
        $show_admin_editpost_form = true;
    }
    else
    {
        echo "<p class='text-center'>No post data was received. Go back and try again.</p>";
    }
}

//  once the edit form has been submitted, go through the process of updating the details on the database
if(isset($_POST['title']))
{
    $postid = $_POST['update'];
    $title = $_POST['title'];
    $created = date('Y-m-d H:i:s');
    $content = $_POST['content'];
    $image = $_POST['image'];

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    //  gather the user entered values, sanitise and validate them using the php functions in the serverside_validation.php file. return error messages if it fails the sanitisation/validation
    $title = sanitise($title, $connection);
    $content = sanitise($content, $connection);
    $image = sanitise($image, $connection);

    $title_errors = validateString($title, 1, 120);
    $content_errors = validateString($content, 1, 800);
    $image_errors = validateString($image, 0, 64);

    $errors = $title_errors . $content_errors . $image_errors;

    //  if there are no error messages returned from the sanitisation/validation functions, go through the process of updating the details on the database. else, display an error message
    if ($errors == "")
    {
        //  tailored query to update the details if the image input has been left empty
        if ($image == "") 
        {
            $query = "UPDATE posts SET title = '$title', created = '$created', content = '$content', image = null  WHERE postid = $postid;";
            
            //  if query is successfully run, disable the forms and display the success message. else, kill the connection to the database and display the error message
            if (mysqli_query($connection, $query))
            {
                $show_editpost_form = false;
                $show_admin_editpost_form = false;
                $message = 
                "<div class='text-center' id='newpost'><h3 class='h3 mb-3 font-weight-normal text-center'>Post edited! </h3>
                <p>You have successfully edited the post on the Noticeboard.</p><p>Please <a href='index.php'>click here</a> to return the Noticeboard.</p></div><br>";

            }
            else
            {
                die("Error editing the post: " . mysqli_error($connection));
            }
        }

        //  tailored query to update the details if the image input has a value
        else
        {
            $query = "UPDATE posts SET title = '$title', created = '$created', content = '$content', image = '$image' WHERE postid = $postid;";
            
            //  if query is successfully run, disable the forms and display the success message. else, kill the connection to the database and display the error message
            if (mysqli_query($connection, $query))
            {
                $show_editpost_form = false;
                $show_admin_editpost_form = false;
                $message = 
                "<div class='text-center' id='newpost'><h3 class='h3 mb-3 font-weight-normal text-center'>Post edited! </h3>
                <p>You have successfully edited the post on the Noticeboard.</p><p>Please <a href='index.php'>click here</a> to return the Noticeboard.</p></div><br>";

            }
            else
            {
                die("Error editing the post: " . mysqli_error($connection));
            }
        }
    }
    else
    {
        echo "<p class='error'>Error editing the post, please try again.</p><br>";
    }

    //  close the connection when finished
    mysqli_close($connection);    

}

//  if the user is logged in as a non-admin, display this edit post form
if ($show_editpost_form)
{
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection)
    { 
        die("Connection failed: " . $mysqli_connect_error);
    }

    //  query to gather the already submitted values from the post the user is requesting to edit. prefill the input boxes with the values
    $query = "SELECT * FROM posts WHERE postid = $update;";

    $result = mysqli_query($connection, $query);

    $row = mysqli_fetch_assoc($result);

    echo <<<_END
    <div class="container text-center" id="editpost">
        <form class="form-group" action="edit_post.php" method="post">
            <h3 class="mb-3 font-weight-normal">Edit your post on the Noticeboard</h3>
            <label for="usernamePost">Username</label><br>
            <input type="text" class="form-control" placeholder="Username" name="username" id="usernamePost" value="{$_SESSION['username']}" disabled><br>
            <label for="titlePost">Title</label><br>
            <small id="titleHelpBlock" class="form-text text-muted">Title must be between 1 and 120 characters</small>
            <input type="text" class="form-control" placeholder="e.g. Bike for sale" size="50" minlength="1" maxlength="120" name="title" id="titlePost" aria-describedby="titleHelpBlock" value="{$row['title']}" required><br>
            <label for="contentPost">Content</label><br>
            <small id="contentHelpBlock" class="form-text text-muted">Content must be between 1 and 800 characters</small>
            <textarea class="form-control" placeholder="e.g. Used bike for sale, £200 contact me if interested" rows="6" cols="50" minlength="1" maxlength="800" name="content" id="contentPost" aria-describedby="contentHelpBlock" required>{$row['content']}</textarea><br>
            <!--Image: <input type="file" name="image" accept="image/png, image/jpeg, image/jpg"> -->
            <label for="imagePost">Image File Address (optional)</label><br>
            <small id="imageHelpBlock" class="form-text text-muted">Image File Address must be between 1 and 64 characters, must link to a .png .jpeg .jpg file and <span class="error">must link to a file already stored in the img folder of the project</span></small>
            <input type="text" class="form-control" placeholder="e.g. img/bike.jpg" size="50" maxlength="64" name="image" id="imagePost" aria-describedby="imageHelpBlock" value="{$row['image']}"><br>
            <button name='update' type="submit" class="btn btn-lg btn-primary btn-block" value="$update">Submit</button>
        </form>	
    </div>
_END;

    //  close the connection when finished
    mysqli_close($connection);
}

//  if the user is logged in an a non-admin, display this edit post form
if ($show_admin_editpost_form)
{
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    //  query to gather the already submitted values from the post the user is requesting to edit. prefill the input boxes with the values
    $query = "SELECT * FROM posts WHERE postid = $update;";

    $result = mysqli_query($connection, $query);

    $row = mysqli_fetch_assoc($result);

    echo <<<_END
    <div class="container text-center" id="editpost">
        <form class="form-group" action="edit_post.php" method="post">
            <h3 class="mb-3 font-weight-normal">Edit your post on the Noticeboard</h3>
            <label for="titlePost">Title</label><br>
            <small id="titleHelpBlock" class="form-text text-muted">Title must be between 1 and 120 characters</small>
            <input type="text" class="form-control" placeholder="e.g. Bike for sale" size="50" minlength="1" maxlength="120" name="title" id="titlePost" aria-describedby="titleHelpBlock" value="{$row['title']}" required><br>
            <label for="contentPost">Content</label><br>
            <small id="contentHelpBlock" class="form-text text-muted">Content must be between 1 and 800 characters</small>
            <textarea class="form-control" placeholder="e.g. Used bike for sale, £200 contact me if interested" rows="6" cols="50" minlength="1" maxlength="800" name="content" id="contentPost" aria-describedby="contentHelpBlock" required>{$row['content']}</textarea><br>
            <!--Image: <input type="file" name="image" accept="image/png, image/jpeg, image/jpg"> -->
            <label for="imagePost">Image File Address (optional)</label><br>
            <small id="imageHelpBlock" class="form-text text-muted">Image File Address must be between 1 and 64 characters, must link to a .png .jpeg .jpg file and <span class="error">must link to a file already stored in the img folder of the project</span></small>
            <input type="text" class="form-control" placeholder="e.g. img/bike.jpg" size="50" maxlength="64" name="image" id="imagePost" aria-describedby="imageHelpBlock" value="{$row['image']}"><br>
            <button name='update' type="submit" class="btn btn-lg btn-primary btn-block" value="$update">Submit</button>
        </form>	
    </div>
_END;

    //  close the connection when finished
    mysqli_close($connection);
}

echo $message;

require_once "footer.php";

?>