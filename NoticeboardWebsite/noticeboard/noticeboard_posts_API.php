<?php

//  this page queries the database for the posts in the table, gathers the results and displays them in JSON format
//  the JSON data is being used by a jquery script to dynamically update the index.php noticeboard page

require_once "db_credentials.php";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$connection)
{
    die("Connection failed: " . $mysqli_connect_error);
}

$query = "SELECT postid, title, created, content, image, firstname, lastname FROM posts LEFT OUTER JOIN users USING (uid)";

if(isset($_GET['orderby']))
{
    if($_GET['orderby'] == "default")
    {
        $query = $query;
    }
    if($_GET['orderby'] == "titleAZ")
    {
        $query .= " ORDER BY title ASC;";
    }
    if($_GET['orderby'] == "titleZA")
    {
        $query .= " ORDER BY title DESC;";
    }
    if($_GET['orderby'] == "contentAZ")
    {
        $query .= " ORDER BY content ASC;";
    }
    if($_GET['orderby'] == "contentZA")
    {
        $query .= " ORDER BY content DESC;";
    }
    if($_GET['orderby'] == "dateNewOld")
    {
        $query .= " ORDER BY created DESC;";
    }
    if($_GET['orderby'] == "dateOldNew")
    {
        $query .= " ORDER BY created ASC;";
    } 
}   

$result = mysqli_query($connection, $query);

$postsArray = array();

while($row = mysqli_fetch_assoc($result))
{
    $postsArray[] = $row;
}

echo json_encode($postsArray);

mysqli_close($connection);

?>