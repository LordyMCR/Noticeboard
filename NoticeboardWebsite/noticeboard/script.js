//  two functions to display the real-time in the header of every page
function timeInterval()
{
    var refresh = 1000;
    setInterval('time()', refresh);
}

function time()
{
    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    if (month < 10) { month = "0" + month; };
    if (day < 10) { day = "0" + day; };
    var hours = d.getHours();
    var mins = d.getMinutes();
    var secs = d.getSeconds();
    if (hours < 10) { hours = "0" + hours; };
    if (mins < 10) { mins = "0" + mins; };
    if (secs < 10) { secs = "0" + secs; };

    var d1 = year + "-" + month + "-" + day + " " + hours + ":" + mins + ":" + secs;
    document.getElementById('timeReal').innerHTML = d1;
    timeInterval();
}

//  function to allow users to view their typed-in password by toggling a checkbox
function passwordToggle()
{
    var passwordSignIn = document.getElementById("passwordId");
    if (passwordSignIn.type === "password")
    {
        passwordSignIn.type = "text";
    }
    else
    {
        passwordSignIn.type = "password";
    }
}

//  checking the value of localstorage for darkmode 
let darkModeCheck = localStorage.getItem("darkModeCheck");

//  function using jquery to set the full website to lightmode when the lightmode button has been clicked in the modal
//  hidden value is changed, and localstorage has been changed - so the webpage will remember the user's selection across all pages
function lightMode()
{
    localStorage.setItem("darkModeCheck", null);
    $('#darkModeTrigger').val("disabled");
    $("link[href='styles_darkmode.css']").attr('href', 'styles.css');
    $('nav').attr('class', 'navbar navbar-expand-lg navbar-light bg-light');
    $("button[class='btn-close btn-close-white']").attr('class', 'btn-close');
    $(".cardStyle").css('background-color', '#F8F9FA');
    $(".card-title").css('font-size', '160%').css('font-weight', 'bold');
}

//  function using jquery to set the full website to darkmode when the darkmode button has been clicked in the modal
//  hidden value is changed, and localstorage has been changed - so the webpage will remember the user's selection across all pages
function darkMode()
{
    localStorage.setItem("darkModeCheck", "enabled");
    $('#darkModeTrigger').val("enabled");
    $("link[href='styles.css']").attr('href', 'styles_darkmode.css');
    $('nav').attr('class', 'navbar navbar-expand-lg navbar-dark bg-dark');
    $("button[class='btn-close']").attr('class', 'btn-close btn-close-white');
    $(".cardStyle").css('background-color', '#212529');
    $(".card-title").css('font-size', '160%').css('font-weight', 'bold');
}

//  checking the value of localstorage to initalise the webpage. will change if the user selects an option
if (darkModeCheck == "enabled")
{
    darkMode();
}

//  function using jquery to allow user to customise the interface - background color, text colour, font size and font style
//  customising various ids, classes and bootstrap classes based on the user's selection
function customise()
{
    $("#customiseTrigger").val("enabled");

    darkModeCheck == "customised";
    
    var backgroundColorSelected = $("#changeBackgroundColor").val();
    var textColorSelected = $("#changeTextColor").val();
    var fontSizeMultiplier = $("#zoomLevel").val();
    
    $("body").css("background-color", backgroundColorSelected);

    $("body").css("color", textColorSelected);
    $("h2").css("color", textColorSelected);
    $("h3").css("color", textColorSelected);
    $("h4").css("color", textColorSelected);
    $("p").css("color", textColorSelected);
    $("table").css("color", textColorSelected);
    if (darkModeCheck == null)
    {
        $(".cardStyle").removeAttr("style").css('background-color', '#F8F9FA').css("color", textColorSelected);
    }
    if (darkModeCheck == "enabled")
    {
        $(".cardStyle").removeAttr("style").css('background-color', '#212529').css("color", textColorSelected);
    }

    if(fontSizeMultiplier == -5)
    {
        $("body").css("font-size", "50%");
        $("h2").css("font-size", "150%");
        $("h3").css("font-size", "130%");
        $(".card-title").css("font-size", "110%");
    }
    if(fontSizeMultiplier == -4)
    {
        $("body").css("font-size", "60%");
        $("h2").css("font-size", "160%");
        $("h3").css("font-size", "140%");
        $(".card-title").css("font-size", "120%");
    }
    if(fontSizeMultiplier == -3)
    {
        $("body").css("font-size", "70%");
        $("h2").css("font-size", "170%");
        $("h3").css("font-size", "150%");
        $(".card-title").css("font-size", "130%");
    }
    if(fontSizeMultiplier == -2)
    {
        $("body").css("font-size", "80%");
        $("h2").css("font-size", "180%");
        $("h3").css("font-size", "160%");
        $(".card-title").css("font-size", "140%");
    }
    if(fontSizeMultiplier == -1)
    {
        $("body").css("font-size", "90%");
        $("h2").css("font-size", "190%");
        $("h3").css("font-size", "170%");
        $(".card-title").css("font-size", "150%");
    }
    if(fontSizeMultiplier == 0)
    {
        $("body").css("font-size", "100%");
        $("h2").css("font-size", "200%");
        $("h3").css("font-size", "180%");
        $(".card-title").css("font-size", "160%");
    }
    if(fontSizeMultiplier == 1)
    {
        $("body").css("font-size", "110%");
        $("h2").css("font-size", "210%");
        $("h3").css("font-size", "190%");
        $(".card-title").css("font-size", "170%");
    }
    if(fontSizeMultiplier == 2)
    {
        $("body").css("font-size", "120%");
        $("h2").css("font-size", "220%");
        $("h3").css("font-size", "200%");
        $(".card-title").css("font-size", "180%");
    }
    if(fontSizeMultiplier == 3)
    {
        $("body").css("font-size", "130%");
        $("h2").css("font-size", "230%");
        $("h3").css("font-size", "210%");
        $(".card-title").css("font-size", "190%");
    }
    if(fontSizeMultiplier == 4)
    {
        $("body").css("font-size", "140%");
        $("h2").css("font-size", "240%");
        $("h3").css("font-size", "220%");
        $(".card-title").css("font-size", "220%");
    }
    if(fontSizeMultiplier == 5)
    { 
        $("body").css("font-size", "150%");
        $("h2").css("font-size", "250%");
        $("h3").css("font-size", "230%");
        $(".card-title").css("font-size", "200%");
    }
    
    var fontStyleSelected = $("#fontChange").val();

    $("body").css("font-family", fontStyleSelected);
    $(".card-title").css("font-family", fontStyleSelected);
}

//  function using jquery to reset the users customise selections when the reset button has been clicked
function resetCustomise()
{  
    $("body").css("background-color", "");
    $("body").css("color", "");
    $("h2").css("color", "");
    $("h3").css("color", "");
    $("h4").css("color", "");
    $("p").css("color", "");
    $("table").css("color", "");
    $("body").css("font-size", "");
    $("h2").css("font-size", "");
    $("h3").css("font-size", "");
    $(".card-title").css("font-size", "");
    $("body").css("font-family", "");
    
}

//  various jquery functions
$(document).ready(function() 
{
    //  functions to change the values of buttons, allowing users to edit or delete a post/user
    $('.selectPost').click(function() {
        $('#postsRadio1V1').val($(this).val());
        $('#modalDelete').val($(this).val());
    });
    $('.selectUser').click(function() {
        $('#usersRadio1V1').val($(this).val());
        $('#usersRadio1V2').val($(this).val());
        $('#modalDelete').val($(this).val());
        $('#nationaliseBtn').val($(this).val());
    });

    //  functions to gather api results based on user's sort button selection
    $('#sortBtnV1').click(function() {
        $('#sortHidden').val($('#sortV1').val());
    });

    if ($('#sortHidden').val() == "0")
    {
        getNoticeBoardPosts("noticeboard_posts_API.php");
    }

    if ($('#sortHidden').val() == "default")
    {
        getNoticeBoardPosts("noticeboard_posts_API.php?orderby=default");
    }
    if ($('#sortHidden').val() == "titleAZ")
    {
        getNoticeBoardPosts("noticeboard_posts_API.php?orderby=titleAZ");
    }
    if ($('#sortHidden').val() == "titleZA")
    {
        getNoticeBoardPosts("noticeboard_posts_API.php?orderby=titleZA");
    }
    if ($('#sortHidden').val() == "contentAZ")
    {
        getNoticeBoardPosts("noticeboard_posts_API.php?orderby=contentAZ");
    }
    if ($('#sortHidden').val() == "contentZA")
    {
        getNoticeBoardPosts("noticeboard_posts_API.php?orderby=contentZA");
    }
    if ($('#sortHidden').val() == "dateNewOld")
    {
        getNoticeBoardPosts("noticeboard_posts_API.php?orderby=dateNewOld");
    }
    if ($('#sortHidden').val() == "dateOldNew")
    {
        getNoticeBoardPosts("noticeboard_posts_API.php?orderby=dateOldNew");
    }


});  

//  function to gather the results from the noticeboard_posts_API.php depending on the url (sort button selection)
function getNoticeBoardPosts($url) { 

    $.getJSON($url)
        .done(function(data) {       
            //  remove any old table rows:
            $(".test").remove();
        
            // loop through what we got and add it to the noticeboard index.php page
            $.each(data, function(index, value) {

                //  if post has been made by non-logged-in user, set first and last name to Anonymous User
                if ((value.firstname === null) && (value.lastname === null))
                {
                    value.firstname = "Anonymous";
                    value.lastname = "User";
                }

                //  displaying the api results depending on the value of the darkModeTrigger value
                //  results will dynamically update with the user's selection on light/dark mode
                var darkModeHidden = document.getElementById("darkModeTrigger").value;
                if (darkModeHidden == "disabled")
                {
                    lightMode();
                    if (value.image != null)
                    {
                        $("#append").append("<div class='test col-xl-3 col-lg-4 col-sm-6 d-flex align-items-stretch'><div class='cardStyle card'><img class='card-img-top' src='" + value.image + "'><div class='card-body text-center align-items-center'><p class='card-title'>" + value.title + "</p><p class='card-text'>" + value.content + "</p><p class='card-text'>Posted by " + value.firstname + " " + value.lastname + " on " + value.created + "</p></div></div></div>");
                    }
                    else if (value.image === null)
                    {
                        $("#append").append("<div class='test col-xl-3 col-lg-4 col-sm-6 d-flex align-items-stretch'><div class='cardStyle card'><div class='card-body text-center align-items-center'><p class='card-title'>" + value.title + "</p><p class='card-text'>" + value.content + "</p><p class='card-text'>Posted by " + value.firstname + " " + value.lastname + " on " + value.created + "</p></div></div></div>");
                    }
                }
                else
                {
                    darkMode();
                    if (value.image != null)
                    {
                        $("#append").append("<div class='test col-xl-3 col-lg-4 col-sm-6 d-flex align-items-stretch'><div class='cardStyle card'><img class='card-img-top' src='" + value.image + "'><div class='card-body text-center align-items-center'><p class='card-title'>" + value.title + "</p><p class='card-text'>" + value.content + "</p><p class='card-text'>Posted by " + value.firstname + " " + value.lastname + " on " + value.created + "</p></div></div></div>");
                    }
                    else if (value.image === null)
                    {
                        $("#append").append("<div class='test col-xl-3 col-lg-4 col-sm-6 d-flex align-items-stretch'><div class='cardStyle card'><div class='card-body text-center align-items-center'><p class='card-title'>" + value.title + "</p><p class='card-text'>" + value.content + "</p><p class='card-text'>Posted by " + value.firstname + " " + value.lastname + " on " + value.created + "</p></div></div></div>");
                    }
                }
            });
        })
        
        .fail(function(jqXHR) {
            console.log('request returned failure, HTTP status code ' + jqXHR.status);
        })

}      
