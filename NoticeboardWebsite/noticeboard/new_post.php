<?php

require_once "header.php";
require_once "serverside_validation.php";

//  initally set forms to false
$show_newpost_loggedin_form = false;
$show_newpost_form = false;

$message = "";
$title = $content = $image = "";
$title_errors = $content_errors = $image_errors = "";
$errors = "";

//  if user is logged in, show new post form specifically for logged in users
//  logged in users will have their posts assigned to their uid and will appear on their user_posts page
if (isset($_SESSION['loggedIn']))
{
    $show_newpost_loggedin_form = true;
    $username = $_SESSION['username'];

    //  if the form has been submitted, go through the process of inserting the information in the database
    if (isset($_POST['title']))
    {
    
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

        echo $errors;

        //  if there are no error messages returned from the sanitisation/validation functions, go through the process of inserting the details on the database. else, display an error message
        if ($errors == "")
        {
            //  query to gather the uid of the logged in user, so the post can be assigned to their uid when inserting
            $query = "SELECT uid FROM users WHERE username='$username' LIMIT 1;";
            $result = mysqli_query($connection, $query);

            $uid = "";

            foreach ($result as $row)
            {
                $uid = $row['uid'];
            }

            //  tailored query to insert the details if the image input has been left empty
            if ($image == "")
            {
                $query = "INSERT INTO posts (uid, title, created, content) VALUES ('$uid', '$title', '$created', '$content')";
                
                //  if query is successfully run, disable the forms and display the success message. else, kill the connection to the database and display the error message
                if (mysqli_query($connection, $query))
                {
                    $show_newpost_loggedin_form = false;
                    $message = 
                    "<div class='text-center' id='newpost'><h3 class='h3 mb-3 font-weight-normal text-center'>Posted!</h3>
                    <p>You have successfully added a new post to the Noticeboard.</p><p>Please <a href='index.php'>click here</a> to return the Noticeboard.</p></div>";
        
                }
                else
                {
                    die("Error creating a new post: " . mysqli_error($connection));
                }
            }

            //  tailored query to insert the details if the image input has a value
            else
            {
                $query = "INSERT INTO posts (uid, title, created, content, image) VALUES ('$uid', '$title', '$created', '$content', '$image')";
                
                //  if query is successfully run, disable the forms and display the success message. else, kill the connection to the database and display the error message
                if (mysqli_query($connection, $query))
                {
                    $show_newpost_loggedin_form = false;
                    $message = 
                    "<div class='text-center' id='newpost'><h3 class='h3 mb-3 font-weight-normal text-center'>Posted!</h3>
                    <p>You have successfully added a new post to the Noticeboard.</p><p>Please <a href='index.php'>click here</a> to return the Noticeboard.</p></div>";
        
                }
                else
                {
                    die("Error creating a new post: " . mysqli_error($connection));
                }
            }
        }
        else
        {
            echo "<p class='error'>Error creating a new post, please try again.</p><br>";
        }

        mysqli_close($connection);

    }
    
}

//  if user is not logged in, show new post form specifically for non-logged-in users
//  non-logged-in users will have their posts labeled as Anonymous User and will not be able to edit or delete their posts on the user_posts.php page
//  on the database, the uid column will be filled with NULL
elseif (!isset($_SESSION['loggedIn']))
{
    $show_newpost_form = true;

    //  if the form has been submitted, go through the process of inserting the information in the database
    if (isset($_POST['title'])) 
    {
        $uid = NULL;
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

        echo $errors;

        //  if there are no error messages returned from the sanitisation/validation functions, go through the process of inserting the details on the database. else, display an error message
        if ($errors == "")
        {
            //  tailored query to insert the details if the image input has been left empty
            if ($image == "")
            {
                $query = "INSERT INTO posts (title, created, content) VALUES ('$title', '$created', '$content')";
                
                //  if query is successfully run, disable the forms and display the success message. else, kill the connection to the database and display the error message
                if (mysqli_query($connection, $query))
                {
                    $show_newpost_form = false;
                    $message = 
                    "<div class='text-center' id='newpost'><h3 class='h3 mb-3 font-weight-normal text-center'>Posted!</h3>
                    <p>You have successfully added a new post to the Noticeboard.</p><p>Please <a href='index.php'>click here</a> to return the Noticeboard.</p></div>";
        
                }
                else
                {
                    die("Error creating a new post: " . mysqli_error($connection));
                }
            }

            //  tailored query to insert the details if the image input has a value
            else
            {
                $query = "INSERT INTO posts (title, created, content, image) VALUES ('$title', '$created', '$content', '$image')";
                
                //  if query is successfully run, disable the forms and display the success message. else, kill the connection to the database and display the error message
                if (mysqli_query($connection, $query))
                {
                    $show_newpost_form = false;
                    $message = 
                    "<div class='text-center' id='newpost'><h3 class='h3 mb-3 font-weight-normal text-center'>Posted!</h3>
                    <p>You have successfully added a new post to the Noticeboard.</p><p>Please <a href='index.php'>click here</a> to return the Noticeboard.</p></div>";
        
                }
                else
                {
                    die("Error creating a new post: " . mysqli_error($connection));
                }
            }
        }
        else
        {
            echo "<p class='error'>Error creating a new post, please try again.</p><br>";
        }

        //  close the connection when finished
        mysqli_close($connection);    
    }
}

//  if the user is logged in, display this new post form
if ($show_newpost_loggedin_form)
{
    echo <<<_END
    <div class="text-center" id="newpost">
        <form class="form-group" action="new_post.php" method="post">
            <h1 class="h3 mb-3 font-weight-normal">Create a new post on the Noticeboard</h1>
            <label for="usernamePost">Username</label><br>
            <input type="text" class="form-control" placeholder="Username" name="username" id="usernamePost" value="{$_SESSION['username']}" disabled><br>
            <label for="titlePost">Title</label><br>
            <small id="titleHelpBlock" class="form-text text-muted">Title must be between 1 and 120 characters</small>
            <input type="text" class="form-control" placeholder="e.g. Bike for sale" size="50" minlength="1" maxlength="120" name="title" id="titlePost" aria-describedby="titleHelpBlock" required><br>
            <label for="contentPost">Content</label><br>
            <small id="contentHelpBlock" class="form-text text-muted">Content must be between 1 and 800 characters</small>
            <textarea class="form-control" placeholder="e.g. Used bike for sale, £200 contact me if interested" rows="6" cols="50" minlength="1" maxlength="800" name="content" id="contentPost" aria-describedby="contentHelpBlock" required></textarea><br>
            <!--Image: <input type="file" name="image" accept="image/png, image/jpeg, image/jpg"> -->
            <label for="imagePost">Image File Address (optional)</label><br>
            <small id="imageHelpBlock" class="form-text text-muted">Image File Address must be between 1 and 64 characters, must link to a .png .jpeg .jpg file and <span class="error">must link to a file already stored in the img folder of the project</span></small>
            <input type="text" class="form-control" placeholder="e.g. img/bike.jpg" size="50" maxlength="64" name="image" id="imagePost" aria-describedby="imageHelpBlock"><br>
            <input type="submit" class="btn btn-lg btn-primary btn-block" value="Post">
        </form>	
    </div>
_END;
}

//  if the user is not logged in, display this new post form
if ($show_newpost_form)
{
    echo <<<_END
    <div class="text-center" id="newpost">
    <form class="form-group" action="new_post.php" method="post">
        <h1 class="h3 mb-3 font-weight-normal">Create a new post on the Noticeboard</h1>
        <label for="titlePost">Title</label><br>
        <small id="titleHelpBlock" class="form-text text-muted">Title must be between 1 and 120 characters</small>
        <input type="text" class="form-control" placeholder="e.g. Bike for sale" size="50" minlength="1" maxlength="120" name="title" id="titlePost" aria-describedby="titleHelpBlock" required><br>
        <label for="contentPost">Content</label><br>
        <small id="contentHelpBlock" class="form-text text-muted">Content must be between 1 and 800 characters</small>
        <textarea class="form-control" placeholder="e.g. Used bike for sale, £200 contact me if interested" rows="6" cols="50" minlength="1" maxlength="800" name="content" id="contentPost" aria-describedby="contentHelpBlock" required></textarea><br>
        <!--Image: <input type="file" name="image" accept="image/png, image/jpeg, image/jpg"> -->
        <label for="imagePost">Image File Address (optional)</label><br>
        <small id="imageHelpBlock" class="form-text text-muted">Image File Address must be between 1 and 64 characters, must link to a .png .jpeg .jpg file and <span class="error">must link to a file already stored in the img folder of the project</span></small>
        <input type="text" class="form-control" placeholder="e.g. img/bike.jpg" size="50" maxlength="64" name="image" id="imagePost" aria-describedby="imageHelpBlock"><br>
        <input type="submit" class="btn btn-lg btn-primary btn-block" value="Post">
    </form>	
    </div>
_END;
}

echo $message;

require_once "footer.php";

?>