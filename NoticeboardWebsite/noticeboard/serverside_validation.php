<?php

// function to sanitise user data:
function sanitise($str, $connection)
{
    // escape any dangerous characters, e.g. quotes:
    $str = mysqli_real_escape_string($connection, $str);
    // ensure any html code is safe by converting reserved characters to entities:
    $str = htmlentities($str);
    // return the cleaned string:
    return $str;
}

// if the data is valid return an empty string, if the data is invalid return a help message
function validateString($field, $minlength, $maxlength)
{
    if (strlen($field)<$minlength)
    {
        // wasn't a valid length, return an error essage string:
        return "Minimum length: " . $minlength;
    }
    elseif (strlen($field)>$maxlength)
    {
        // wasn't a valid length, return an error message string:
        return "Maximum length: " . $maxlength;
    }
    // data was valid, return an empty string:
    return "";
}

// if the data is valid return an empty string, if the data is invalid return a help message
function validateInt($field, $min, $max)
{
    $options = array("options" => array("min_range"=>$min,"max_range"=>$max));

    if (!filter_var($field, FILTER_VALIDATE_INT, $options))
    {
        // wasn't a valid integer, return an error message string:
        return "Not a valid number (must be whole and in the range: " . $min . " to " . $max . ")";
    }
    // data was valid, return an empty string:
    return "";
}

// if the data is valid return an empty string, if the data is invalid return a help message
function validateEmail($field)
{
    // Remove all illegal characters from email
    $field = filter_var($field, FILTER_SANITIZE_EMAIL);

    // Check to see if the email address conforms to the expected format
    if (filter_var($field, FILTER_VALIDATE_EMAIL))
    {
         // data was valid, return an empty string:
        return "";
    }
    
    // wasn't a valid email, return an error message string:
    else
    {
        return "Email address is not valid ";
    }

}

// if the data is valid return an empty string, if the data is invalid return a help message
function validatePhone($field)
{
    //  checking the inputted phone number matches the regular expression
    if(preg_match("/^[0-9]{0,24}$/", $field))
    {
        // data was valid, return an empty string:
        return "";
    }

    // wasn't a valid phone number, return an error message string:
    else
    {
        return "Not a valid phone number (must only contain numbers between 0 and 9, and between 0 and 24 characters in total)";
    }
}

?>