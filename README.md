# Noticeboard Website
## About the Project
Website mimicing a community noticeboard, showing users and non-users posts on a dynamically updating homepage. Website also includes a login system for users and an admin - users can edit and delete their own posts, and the admin can manage posts and user accounts. Posts are retrieved dynamically from the MySQL database using jQuery AJAX requests.

This project was created to test my skills of a Full-Stack Web Developer, creating the front-end and back-end of a dynamic website.
## Built With
* HTML5
* CSS3 / Bootstrap
* JavaScript / jQuery
* PHP
* MySQL
## Installation
The applications and tools used to create and run this project are:
* [Visual Studio Code][1]
* [XAMPP (Apache and MySQL)][2]

Download the repository and place the "noticeboard" subfolder in your "htdocs" folder of your XAMPP installation location (usually *C:\username\xampp\htdocs*).

Run XAMPP and start the "Apache" and "MySQL" modules. Then locate to **http://localhost/phpmyadmin/** in your browser and import the "noticeboard.sql" file located in the repository to create the database of noticeboard posts.

Locate to **http://localhost/noticeboard/index.php** to access the homepage.
## Known Issues/Bugs
* Home Page will dynamically update if new posts are added and sort button will function for a short time - however if the page is open for too long, it will crash. This is a known issue with the jQuery constantly AJAX requesting information from the API, causing the browser to run out of memory and crash.

[1]: https://code.visualstudio.com/
[2]: https://www.apachefriends.org/
