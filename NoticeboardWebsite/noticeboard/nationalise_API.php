<?php

require_once "header.php";

//  initially hide the api results
$show_api_data = false;
$firstname = "";

//  if user is not logged in, block assess to the page and display message
if (!isset($_SESSION['loggedIn']))
{
    echo "<p class='text-center'>You must be logged in as the admin to view this page.</p>";
}
else
{
    $username = $_SESSION['username'];

    //  if user is logged in but not as admin, block assess to the page and display message
    if ($username != "admin")
    {
        echo "<p class='text-center'>You must be logged in as the admin to view this page.</p>";
    }

    // open page only if logged in as admin
    else
    {  
        $nationalise = $_POST['nationalise'];

        //  if nationalise api button has been initialised and is not equal to an empty value, show the results. if not, display message saying no user data was received
        if (isset($nationalise) && $nationalise != "")
        { 
            $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

            if (!$connection)
            {
                die("Connection failed: " . $mysqli_connect_error);
            }
            
            //  query to gather the firstname from the database using the uid posted from the nationalise api button
            $query = "SELECT firstname FROM users WHERE uid = {$nationalise}";

            $result = mysqli_query($connection, $query);

            $row = mysqli_fetch_assoc($result);

            $firstname = $row['firstname'];   

            $show_api_data = true;

        }
        else
        {
            echo "<p class='error'>No user data was received. Go back and try again.</p>";
        }
    }
    //  close the connection when finished
    mysqli_close($connection);
}

//  show api data when set to true
//  has jquery script which gathers the api results based on the gathered firstname
//  appends the table with rows of results
if ($show_api_data)
{
    echo <<<_END
    
    <h3 class="h3 mb-3 font-weight-normal text-center">{$firstname}</h3>
    <p class="text-center"><a href="https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Officially_assigned_code_elements">Click here to view the list of Countries for the below Country IDs</a></p>       
    <div class="table-responsive"><table table class="table table-sm table-bordered table-hover" id="APIappend">
    <tr><th id="apiTableHeader" scope="col">Country ID</th><th id="apiTableHeader" scope="col">Probability</th></tr>

    </table></div>

    <script>
    $(document).ready(function()
    {    
     getResults();
    });    

    function getResults()
    { 

        $.getJSON("https://api.nationalize.io?name={$firstname}")
            .done(function(data) {
                console.log('request successful');
                console.log(data);         
                for (var key in data.country) {
                    $('#APIappend').append($("<tr><td>" + data.country[key].country_id + "</td><td>" + (data.country[key].probability * 100).toFixed(2)+"%" + "</td></tr>"));
                }
            })            
            .fail(function(jqXHR) {
                console.log('request returned failure, HTTP status code ' + jqXHR.status);
            })
            .always(function() {
            console.log('request completed');
            })
    }
    </script>
_END;
}

require_once "footer.php";

?>