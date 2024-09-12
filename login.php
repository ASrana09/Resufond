<?php
//This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['username']))
{
    header("location: services.php");
    exit;
}
require_once "config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password"; 
        echo "<script type='text/javascript'>alert('$err');</script>";
        
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


if(empty($err))
{
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            header("location: services.php");
                            
                        }
                    }

                }

    }
}    


}


?>









<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <link rel="stylesheet" href="style.css">
      <title>Login Page</title>
      <style>
        @import 'https://fonts.googleapis.com/css?family=Montserrat:300, 400, 700&display=swap';
* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
html {
    font-size: 10px;
    font-family: 'Montserrat', sans-serif;
    scroll-behavior: smooth;
}

a {
    text-decoration: none;
}

.brand h1 {
    font-size: 3rem;
    text-transform: uppercase;
    color: rgb(244, 5, 25);
}

.brand h1 span {
    color: rgb(9, 88, 144);
}
         /* Header section */

#header {
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100vw;
    height: auto;
}

#header .header {
    min-height: 8vh;
    background-color: rgba(31, 30, 30, 0.24);
    transition: 0.3s ease background-color;
}

#header .nav-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 100%;
    max-width: 1300px;
    padding: 0 10px;
}

#header .nav-list ul {
    list-style: none;
    position: absolute;
    background-color: rgb(31, 30, 30);
    width: 100vw;
    height: 100vh;
    left: 100%;
    top: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 1;
    overflow-x: hidden;
    transition: 0.5s ease left;
}

#header .nav-list ul.active {
    left: 0%;
}

#header .nav-list ul a {
    font-size: 2.5rem;
    font-weight: 500;
    letter-spacing: 0.2rem;
    text-decoration: none;
    color: white;
    text-transform: uppercase;
    padding: 20px;
    display: block;
}

#header .nav-list ul a::after {
    content: attr(data-after);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    color: rgba(240, 248, 255, 0.021);
    font-size: 13rem;
    letter-spacing: 50px;
    z-index: -1;
    transition: 0.3s ease letter-spacing;
}

#header .nav-list ul li:hover a::after {
    transform: translate(-50%, -50%) scale(1);
    letter-spacing: initial;
}

#header .nav-list ul li:hover a {
    color: crimson;
}

#header .hamburger {
    height: 60px;
    width: 60px;
    display: inline-block;
    border: 3px solid white;
    border-radius: 50%;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 100;
    cursor: pointer;
    transform: scale(0.8);
    margin-right: 20px;
}

#header .hamburger:after {
    position: absolute;
    content: '';
    height: 100%;
    width: 100%;
    border-radius: 50%;
    border: 3px solid white;
    animation: hamburger_puls 1s ease infinite;
}

#header .hamburger .bar {
    height: 2px;
    width: 30px;
    position: relative;
    background-color: white;
    z-index: -1;
}

#header .hamburger .bar::after,
#header .hamburger .bar::before {
    content: '';
    position: absolute;
    height: 100%;
    width: 100%;
    left: 0;
    background-color: white;
    transition: 0.3s ease;
    transition-property: top, bottom;
}

#header .hamburger .bar::after {
    top: 8px;
}

#header .hamburger .bar::before {
    bottom: 8px;
}

#header .hamburger.active .bar::before {
    bottom: 0;
}

#header .hamburger.active .bar::after {
    top: 0;
}


/* End Header section */




/* Media Query For Desktop */

@media only screen and (min-width: 1200px) {
    /* header */
    #header .hamburger {
        display: none;
    }
    #header .nav-list ul {
        position: initial;
        display: block;
        height: auto;
        width: fit-content;
        background-color: transparent;
    }
    #header .nav-list ul li {
        display: inline-block;
    }
    #header .nav-list ul li a {
        font-size: 1.8rem;
    }
    #header .nav-list ul a:after {
        display: none;
    }
    /* End header */
    #services .service-bottom .service-item {
        flex-basis: 22%;
        margin: 1.5%;
    }
}


/* End  Media Query For Desktop */

/* contact Section */

#contact .contact {
    flex-direction: column;
    max-width: 1200px;
    margin: 0 auto;
    width: 90%;
}

#contact .contact-items {
    /* max-width: 400px; */
    width: 100%;
}

#contact .contact-item {
    width: 80%;
    padding: 20px;
    text-align: center;
    border-radius: 10px;
    padding: 30px;
    margin: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    box-shadow: 0px 0px 18px 0 #0000002c;
    transition: 0.3s ease box-shadow;
}

#contact .contact-item:hover {
    box-shadow: 0px 0px 5px 0 #0000002c;
}

#contact .icon {
    width: 70px;
    margin: 0 auto;
    margin-bottom: 10px;
}

#contact .contact-info h1 {
    font-size: 2.5rem;
    font-weight: 500;
    margin-bottom: 5px;
}

#contact .contact-info h2 {
    font-size: 1.3rem;
    line-height: 2rem;
    font-weight: 500;
}


/*End contact Section */


         /* Basics */
         html, body {
         width: 100%;
         height: 100%;
         font-family: "Helvetica Neue", Helvetica, sans-serif;
         color: #444;
         -webkit-font-smoothing: antialiased;
         background-image: url("./rm.jpg");
         background-size: cover;
         background-position: top center;
         position: relative;
         z-index: 1;
         }
         #container {
         position: fixed;
         width: 340px;
         height: 280px;
         top: 30%;
         left: 50%;
         margin-top: -90px;
         margin-left: -170px;
         background: #fff;
         border-radius: 3px;
         border: 1px solid #ccc;
         box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
         }
         form {
         background-image: url("./rm.jpg");
         border: 1px solid  rgb(0, 0, 0);
         margin: 0 auto;
         margin-top: 10px;
         }
         label {
         color: rgb(255, 254, 254);
         display: inline-block;
         margin-left: 18px;
         padding-top: 10px;
         font-size: 14px;
         }
         p a {
         font-size: 11px;
         color: #aaa;
         float: right;
         margin-top: -13px;
         margin-right: 20px;
         -webkit-transition: all .4s ease;
         -moz-transition: all .4s ease;
         transition: all .4s ease;
         }
         p a:hover {
         color: #555;
         }
         input {
         font-family: "Helvetica Neue", Helvetica, sans-serif;
         font-size: 12px;
         outline: none;
         }
         input[type=text],
         input[type=password] ,input[type=time]{
         color: rgb(214, 12, 12);
         padding-left: 10px;
         margin: 10px;
         margin-top: 12px;
         margin-left: 18px;
         width: 290px;
         height: 35px;
         border: 1px solid #c7d0d2;
         border-radius: 2px;
         box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #f5f7f8;
         -webkit-transition: all .4s ease;
         -moz-transition: all .4s ease;
         transition: all .4s ease;
         }
         input[type=text]:hover,
         input[type=password]:hover,input[type=time]:hover {
         border: 1px solid #b6bfc0;
         box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .7), 0 0 0 5px #f5f7f8;
         }
         input[type=text]:focus,
         input[type=password]:focus,input[type=time]:focus {
         border: 1px solid #a8103b;
         box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #e6f2f9;
         }
         #lower {
         background-image: url("./rm.jpg");
         background: #ecf2f5;
         width: 100%;
         height: 69px;
         margin-top: 20px;
         box-shadow: inset 0 1px 1px #fff;
         border-top: 1px solid #ccc;
         border-bottom-right-radius: 3px;
         border-bottom-left-radius: 3px;
         }
         .check {
         margin-left: 3px;
         font-size: 11px;
         color: #444;
         text-shadow: 0 1px 0 #fff;
         }
         input[type=submit], input[type=submits] {
         float: right;
         margin-right: 20px;
         margin-top: 20px;
         width: 150px;
         height: 40px;
         font-size: 14px;
         font-weight: bold;
         color: #fff;
         background-color: #acd6ef; /*IE fallback*/
         background-image: -webkit-gradient(linear, left top, left bottom, from(#acd6ef), to(#6ec2e8));
         background-image: -moz-linear-gradient(top left 90deg, #acd6ef 0%, #6ec2e8 100%);
         background-image: linear-gradient(top left 90deg, #acd6ef 0%, #6ec2e8 100%);
         border-radius: 30px;
         border: 1px solid #66add6;
         box-shadow: 0 1px 2px rgba(0, 0, 0, .3), inset 0 1px 0 rgba(255, 255, 255, .5);
         cursor: pointer;
         }
         input[type=submit]:hover,  input[type=submit]:hover {
         background-image: -webkit-gradient(linear, left top, left bottom, from(#b6e2ff), to(#6ec2e8));
         background-image: -moz-linear-gradient(top left 90deg, #b6e2ff 0%, #162932 100%);
         background-image: linear-gradient(top left 90deg, #b6e2ff 0%, #6ec2e8 100%);
         }
         input[type=submit]:active,  input[type=submit]:active {
         background-image: -webkit-gradient(linear, left top, left bottom, from(#6ec2e8), to(#b6e2ff));
         background-image: -moz-linear-gradient(top left 90deg, #2e3336 0%, #205e87 100%);
         background-image: linear-gradient(top left 90deg, #25586f 0%, #3e6076 100%);
         }
      </style>
   </head>
   <body>
       <!-- Header -->
    <section id="header">
      <div class="header container">
          <div class="nav-bar">
              <div class="brand">
                  <a href="#hero">
                      <h1>RESUFOND</h1>
                  </a>
              </div>
              <div class="nav-list">
                  <div class="hamburger">
                      <div class="bar"></div>
                  </div>
                  <ul>
                      <li><a href="index.php" data-after="Home">Home</a></li>
                      <li><a href="#contact/index.php" data-after="Contact">Contact</a></li>
                  </ul>
              </div>
          </div>
      </div>
  </section>
  <!-- End Header -->
  

      <!-- Begin Page Content -->
      <div id="container">
         <h1>&ensp;Login To Access</h1>
         <h3><p>&ensp;Please login to access the account</p></h3>
         <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="user" name="username">
            <label for="password"> Password:</label>
            <input type="password" id="password" name="password">
            <div id="lower">
               <input type="submit" value="Login">
              <h2><a href="register.php" type="button"><br>&emsp;Not a user??</a></h2>
            </div>
            <!--/ lower-->
         </form>
      </div>
      <!--/ container-->
      <!-- End Page Content -->
   </body>
</html>