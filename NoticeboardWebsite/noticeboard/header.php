<?php
ob_start();

//  set the detault timezone to London, so the real-time clock will display the correct time and the submitted posts will display the submitted time in London-time
date_default_timezone_set('Europe/London');

require_once "db_credentials.php";

//  start the session so users can log in, and stores the details in the session/cookies
session_start();

//  display the beginning parts of the header, including jquery/bootstrap/custom css links
//  start the body element and display the real-time at the right of every page
echo <<<_END

	<!DOCTYPE html>
	<html lang="en">
    <head>
        <title>Lordys Community Noticeboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="styles.css">
	</head>

    <body onload=time();>
    <div class="container">
        <div id="header">
            <span class="p" id="timeReal"></span>  
            <h2>Lordys Community Noticeboard</h2>
        </div>

_END;

//  if user is logged in, display custom navigation bar with menu options only logged in users can see
if (isset($_SESSION['loggedIn']))
{
    $username = $_SESSION['username'];

    //  if user is logged in as admin, display admin custom navigation bar with menu options only the admin can see
    if ($username == "admin")
    {
        echo <<<_END

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="index.php">Noticeboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="user_posts.php">Your Posts</a></li>
                        <li class="nav-item"><a class="nav-link" href="new_post.php">Create a New Post</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin_manage_posts.php">Manage Posts</a></li>
                        <li class="nav-item"><a class="nav-link" href="admin_manage_users.php">Manage Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="sign_out.php">Sign Out ({$username})</a></li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <span>
                                <a class="nav-link" href="" data-bs-target="#lightDarkModal" data-bs-toggle="modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-half" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                                    </svg>  Light/Dark Mode
                                </a>
                            </span>
                        </li>
                        <li class="nav-item">
                            <span>
                                <a class="nav-link" href="" data-bs-target="#customiseModal" data-bs-toggle="modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wrench-adjustable" viewBox="0 0 16 16">
                                        <path d="M16 4.5a4.492 4.492 0 0 1-1.703 3.526L13 5l2.959-1.11c.027.2.041.403.041.61Z"/>
                                        <path d="M11.5 9c.653 0 1.273-.139 1.833-.39L12 5.5 11 3l3.826-1.53A4.5 4.5 0 0 0 7.29 6.092l-6.116 5.096a2.583 2.583 0 1 0 3.638 3.638L9.908 8.71A4.49 4.49 0 0 0 11.5 9Zm-1.292-4.361-.596.893.809-.27a.25.25 0 0 1 .287.377l-.596.893.809-.27.158.475-1.5.5a.25.25 0 0 1-.287-.376l.596-.893-.809.27a.25.25 0 0 1-.287-.377l.596-.893-.809.27-.158-.475 1.5-.5a.25.25 0 0 1 .287.376ZM3 14a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                    </svg>  Customise
                                </a>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
_END;
    }

    //  if user is logged in as non-admin, display custom navigation bar with menu options only a logged in user can see
    else
    {
        echo <<<_END

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="index.php">Noticeboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="user_posts.php">Your Posts</a></li>
                        <li class="nav-item"><a class="nav-link" href="new_post.php">Create a New Post</a></li>
                        <li class="nav-item"><a class="nav-link" href="sign_out.php">Sign Out ({$username})</a></li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <span>
                                <a class="nav-link" href="" data-bs-target="#lightDarkModal" data-bs-toggle="modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-half" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                                    </svg>  Light/Dark Mode
                                </a>
                            </span>
                        </li>
                        <li class="nav-item">
                            <span>
                                <a class="nav-link" href="" data-bs-target="#customiseModal" data-bs-toggle="modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wrench-adjustable" viewBox="0 0 16 16">
                                        <path d="M16 4.5a4.492 4.492 0 0 1-1.703 3.526L13 5l2.959-1.11c.027.2.041.403.041.61Z"/>
                                        <path d="M11.5 9c.653 0 1.273-.139 1.833-.39L12 5.5 11 3l3.826-1.53A4.5 4.5 0 0 0 7.29 6.092l-6.116 5.096a2.583 2.583 0 1 0 3.638 3.638L9.908 8.71A4.49 4.49 0 0 0 11.5 9Zm-1.292-4.361-.596.893.809-.27a.25.25 0 0 1 .287.377l-.596.893.809-.27.158.475-1.5.5a.25.25 0 0 1-.287-.376l.596-.893-.809.27a.25.25 0 0 1-.287-.377l.596-.893-.809.27-.158-.475 1.5-.5a.25.25 0 0 1 .287.376ZM3 14a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                    </svg>  Customise
                                </a>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
_END;
    }
}

//  if user is not logged in, display custom navigation bar with menu options only a non-logged-in user can see

else
{
    echo <<<_END

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Noticeboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="new_post.php">Create a New Post</a></li>
                    <li class="nav-item"><a class="nav-link" href="sign_in.php">Sign In</a></li>
                    <li class="nav-item"><a class="nav-link" href="sign_up.php">Sign Up</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span>
                            <a class="nav-link" href="" data-bs-target="#lightDarkModal" data-bs-toggle="modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-half" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                                </svg>  Light/Dark Mode
                            </a>
                        </span>
                    </li>
                    <li class="nav-item">
                        <span>
                            <a class="nav-link" href="" data-bs-target="#customiseModal" data-bs-toggle="modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wrench-adjustable" viewBox="0 0 16 16">
                                    <path d="M16 4.5a4.492 4.492 0 0 1-1.703 3.526L13 5l2.959-1.11c.027.2.041.403.041.61Z"/>
                                    <path d="M11.5 9c.653 0 1.273-.139 1.833-.39L12 5.5 11 3l3.826-1.53A4.5 4.5 0 0 0 7.29 6.092l-6.116 5.096a2.583 2.583 0 1 0 3.638 3.638L9.908 8.71A4.49 4.49 0 0 0 11.5 9Zm-1.292-4.361-.596.893.809-.27a.25.25 0 0 1 .287.377l-.596.893.809-.27.158.475-1.5.5a.25.25 0 0 1-.287-.376l.596-.893-.809.27a.25.25 0 0 1-.287-.377l.596-.893-.809.27-.158-.475 1.5-.5a.25.25 0 0 1 .287.376ZM3 14a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                </svg>  Customise
                            </a>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        </nav>    
        <br>
_END;
}

//  modal opens when dark/light mode button has bee clicked
echo <<<_END
<input type="hidden" id="darkModeTrigger" value="disabled">
<div id="lightDarkModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="myModalLabel">Toggle Light/Dark Mode</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <p>Click below to select Light Mode or Dark Mode</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" id="lightButton" data-bs-dismiss="modal" aria-hidden="true" onclick="lightMode()">Light Mode</button>
                <button class="btn btn-dark" id="darkButton" data-bs-dismiss="modal" aria-hidden="true" onclick="darkMode()">Dark Mode</button>
            </div>
        </div>
    </div>
</div>
_END;

//  modal opens when customise button has bee clicked
//  allow users to customise the interface - change background colour, text colour, font size and font style
echo <<<_END
<div id="customiseModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="myModalLabel">Customise Interface</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <label for="changeBackgroundColor">Change Background Colour</label>
                <input type="color" class="form-control" name="changeBackgroundColor" id="changeBackgroundColor" value="#ffffff"><br>
                <label for="changeTextColor">Change Text Colour</label>
                <input type="color" class="form-control" name="changeTextColor" id="changeTextColor"><br>
                <label for="increaseDecreaseFontSize">Decrease/Increase Font Size</label><br>
                <input type=range name="zoomLevel" id="zoomLevel" min="-5" max="5" value="0" oninput="zoomLevelOutput.value = zoomLevel.value">
                <output name="zoomLevelOutput" id="zoomLevelOutput">0</output><br><br>
                <label for="changeFontStyle">Change Font Style</label><br>
                <select class="form-select w-auto> name="fontChange" id="fontChange">
                    <option value="">Default</option>
                    <option id="fontSerif" value="'Times New Roman', serif">Serif</option>
                    <option id="fontMonospace" value="'Lucida Console', monospace">Monospace</option>
                    <option id="fontCursive" value="cursive">Cursive</option>
                    <option id="fontFantasy" value="fantasy">Fantasy</option>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal" aria-hidden="true" onclick="resetCustomise()">Reset to Default</button>
                <button class="btn btn-primary" data-bs-dismiss="modal" aria-hidden="true" onclick="customise()">Submit</button>
                <input type="hidden" id="customiseTrigger" value="disabled">
            </div>
        </div>
    </div>
</div>
_END;

?>