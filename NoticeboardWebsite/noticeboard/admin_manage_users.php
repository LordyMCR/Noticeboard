<?php

require_once "header.php";

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
        $selected1 = "";
        $selected2 = "";
        $selected3 = "";
        $selected4 = "";
        $selected5 = "";
        
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }

        $query = "SELECT uid, username, password, firstname, lastname, email, age, city, county, country, phone FROM users";
        
        //  if sort button posted, concatenate above query with the value of the select option to sort, and also keep selected value displaying in the dropdown once submitted
        if (isset($_POST['sort']))
        {
            if ($_POST['sort'] == " ORDER BY uid ASC;")
            {
                $selected2 = "selected";
                $query .= $_POST['sort'];
            }
            elseif ($_POST['sort'] == " ORDER BY uid DESC;")
            {
                $selected3 = "selected";
                $query .= $_POST['sort'];
            }
            elseif ($_POST['sort'] == " ORDER BY username ASC;")
            {
                $selected4 = "selected";
                $query .= $_POST['sort'];
            }
            elseif ($_POST['sort'] == " ORDER BY username DESC;")
            {
                $selected5 = "selected";
                $query .= $_POST['sort'];
            }
            else
            {
                $selected1 = "selected";
                $query .= ";";
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
            <h3 class="h3 mb-3 font-weight-normal text-center">Manage users</h3>       
        

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminTools" aria-controls="adminTools" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="adminTools">
                        <ul class="navbar-nav">
                            <li class="nav-item"><form action="admin_manage_users.php" method="POST">
                            <select class="btn-sm form-select w-auto" name="sort" id="sortV2">
                                <option value="" {$selected1}>Default</option>
                                <option value=" ORDER BY uid ASC;" {$selected2}>ID Ascending</option>
                                <option value=" ORDER BY uid DESC;" {$selected3}>ID Descending</option>
                                <option value=" ORDER BY username ASC;" {$selected4}>Username A-Z</option>
                                <option value=" ORDER BY username DESC;" {$selected5}>Username Z-A</option>
                            </select>
                            </li>
                            <li class="nav-item"><button type="submit" class="btn btn-sm btn-primary" name="sortBtn" id="sortBtnV2">Sort</button></form></li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                            <form method="POST" action="edit_user.php"><button type=submit class="btn btn-sm btn-primary" name="update" id="usersRadio1V2" value="">Update</button></form>
                            </li>
                            <li class="nav-item">
                            <button type=submit class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal" name="delete" id="usersRadio2V2">Delete</button>
                            </li>
                            <li class="nav-item">
                            <form method="POST" action="nationalise_API.php"><button type=submit class="btn btn-sm btn-success" name="nationalise" id="nationaliseBtn" value="">Nationalise API</button></form>    
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>


            <div class='table-responsive'><table class="table table-sm table-bordered table-hover">
            <thead><tr><th scope='col'>Select</th><th>ID</th><th scope='col'>Username</th><th scope='col'>Password</th><th scope='col'>First Name</th><th scope='col'>Last Name</th><th scope='col'>Email</th><th scope='col'>Age</th><th scope='col'>City</th><th scope='col'>County</th><th scope='col'>Country</th><th scope='col'>Phone</th></thead><tbody>
    _END;
            // loop over all rows, adding them into the table:
            for ($i=0; $i<$n; $i++)
            {
                // fetch one row as an associative array
                $row = mysqli_fetch_assoc($result);
                //  add it as a row in the table:
                echo "<tr>";
                echo '<td><input class="selectUser form-check-input" name="selectUser" type="radio" value="'.$row['uid'].'"></td>';
                echo "<td>{$row['uid']}</td><td>{$row['username']}</td><td>{$row['password']}</td><td data-bs-target='#nationaliseAPI' data-bs-toggle='modal' value='{$row['uid']}'>{$row['firstname']}</td><td>{$row['lastname']}</td><td>{$row['email']}</td><td>{$row['age']}</td><td>{$row['city']}</td><td>{$row['county']}</td><td>{$row['country']}</td><td>{$row['phone']}</td>";
                echo "</tr>";
            }
            echo "</tbody></table></div>";
        }
        else
        {
            echo "There are no accounts registered on the Noticeboard site, create a new account using the menu above.<br>";
        }

        //  close the connection when finished
        mysqli_close($connection);
    }

}
require_once "footer.php";

//  modal opens when delete button is selected
echo <<<_END
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete User?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="delete_user.php"><button type=submit class="btn btn-danger" name="delete" id="modalDelete" value="">Yes</button></form>
                </div>
            </div>
        </div>
    </div>
_END;

?>