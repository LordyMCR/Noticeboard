<?php

require_once "header.php";
//  if user is not logged in, block assess to the page and display message
if (!isset($_SESSION['loggedIn']))
{
    echo "<p class='text-center'>You must be logged in as the admin to view this page. You can manage your own posts on the Noticeboard when you are logged in to your own account. If you need to report another post on the Noticeboard, contact the admin.</p>";
}
else 
{
    $username = $_SESSION['username'];
    //  if user is logged in but not as admin, block assess to the page and display message
    if ($username != "admin")
    {
        echo "<p class='text-center'>You must be logged in as the admin to view this page. You can manage your own posts on the Noticeboard when you are logged in to your own account. If you need to report another post on the Noticeboard, contact the admin.</p>";

    }
    //  open page only if logged in as admin
    else
    {
        $selected1 = "";
        $selected2 = "";
        $selected3 = "";
        $selected4 = "";
        $selected5 = "";
        $selected6 = "";
        $selected7 = "";
        
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }

        $query = "SELECT postid, title, created, content, image FROM posts LEFT OUTER JOIN users USING (uid)";
        //  if sort button posted, concatenate above query with the value of the select option to sort, and also keep selected value displaying in the dropdown once submitted
        if (isset($_POST['sort']))
        {
            if ($_POST['sort'] == " ORDER BY title ASC;")
            {
                $selected2 = "selected";
                $query .= $_POST['sort'];
            }
            elseif ($_POST['sort'] == " ORDER BY title DESC;")
            {
                $selected3 = "selected";
                $query .= $_POST['sort'];
            }
            elseif ($_POST['sort'] == " ORDER BY content ASC;")
            {
                $selected4 = "selected";
                $query .= $_POST['sort'];
            }
            elseif ($_POST['sort'] == " ORDER BY content DESC;")
            {
                $selected5 = "selected";
                $query .= $_POST['sort'];
            }
            elseif ($_POST['sort'] == " ORDER BY created DESC;")
            {
                $selected6 = "selected";
                $query .= $_POST['sort'];
            }
            elseif ($_POST['sort'] == " ORDER BY created ASC;")
            {
                $selected7 = "selected";
                $query .= $_POST['sort'];
            }
            else
            {
                $selected1 = "selected";
                $query .= $_POST['sort'];
            }
        }

        //  gather the results from the query
        $result = mysqli_query($connection, $query);

        //  gather the number of rows in the results
        $n = mysqli_num_rows($result);

        //  if number of rows in the results are above zero, display them along with the sort dropdown, delete and update buttons. else, display a message saying there are no posts
        if ($n > 0)
        {
            echo <<<_END
            <h3 class="h3 mb-3 font-weight-normal text-center">Manage posts</h3>
            <div id="updateDelete">
                <button type=submit class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePostModal" name="delete" id="postsRadio2V1">Delete</button>
                <form method="POST" action="edit_post.php"><button type=submit class="btn btn-sm btn-primary" name="update" id="postsRadio1V1" value="">Update</button></form>
            </div>
            <form action="admin_manage_posts.php" method="POST">
            <select class="btn-sm form-select w-auto" name="sort" id="sortV1">
                <option value=" ORDER BY postid ASC;" {$selected1}>Default</option>
                <option value=" ORDER BY title ASC;" {$selected2}>Title A-Z</option>
                <option value=" ORDER BY title DESC;" {$selected3}>Title Z-A</option>
                <option value=" ORDER BY content ASC;" {$selected4}>Content A-Z</option>
                <option value=" ORDER BY content DESC;" {$selected5}>Content Z-A</option>
                <option value=" ORDER BY created DESC;" {$selected6}>Date New-Old</option>
                <option value=" ORDER BY created ASC;" {$selected7}>Date Old-New</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary" name="sortBtn" id="sortBtnV1">Sort</button>
            </form>
            <br>
            <div class="table-responsive"><table class="table table-sm table-bordered table-hover">
            <thead><tr><th scope="col">Select</th><th scope="col">Title</th><th scope="col">Created</th><th scope="col">Content</th><th scope="col">Image</th></tr></thead><tbody>
    _END;
            //  loop over all rows, adding them into the table:
            for ($i=0; $i<$n; $i++)
            {
                //  fetch one row as an associative array
                $row = mysqli_fetch_assoc($result);
                //  add it as a row in the table:
                echo "<tr>";
                echo '<td><input class="selectPost form-check-input" name="selectPost" type="radio" value="'.$row['postid'].'"></td>';
                echo "<td>{$row['title']}</td><td>{$row['created']}</td><td>{$row['content']}</td><td class='tableImgCell'><img id='tableImg' src='{$row['image']}'></td>";
                echo "</tr>";
            }
                echo "</tbody></table></div>";
        }
        else
        {
            echo "There are no posts on the Noticeboard, create a new post using the menu above.<br>";
        }
        //  close the connection when finished
        mysqli_close($connection);
    }
}

require_once "footer.php";
//  modal opens when delete button is selected
echo <<<_END
    <div class="modal fade" id="deletePostModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Post?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this post? This action cannot be undone.</p>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="delete_post.php"><button type=submit class="btn btn-danger" name="delete" id="modalDelete" value="">Yes</button></form>
            </div>
        </div>
    </div>
_END;

?>

