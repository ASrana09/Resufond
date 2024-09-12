<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Username cannot be blank!!";
        echo "<script type='text/javascript'>alert('$username_err');</script>";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken";
                    echo "<script type='text/javascript'>alert('$username_err');</script>"; 
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
        mysqli_stmt_close($stmt);
    }



// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
    echo "<script type='text/javascript'>alert('$password_err');</script>";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
    echo "<script type='text/javascript'>alert('$password_err');</script>";
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
    echo "<script type='text/javascript'>alert('$password_err');</script>";
}


// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
{
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

        // Set these parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: services.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <link rel="stylesheet" href="style.css">
      <title>Signup page</title>
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
         width: 350px;
         height: 290px;
         top: 40%;
         left: 50%;
         margin-top: -140px;
         margin-left: -170px;
         background: #fff;
         border-radius: 3px;
         border: 1px solid  rgb(0, 0, 0);
         box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
         }
         form {
         background-image: url("./rm.jpg");
         border: 1px solid  rgb(0, 0, 0);
         margin: 0 auto;
         margin-top: 5px;
         }
         label {
         color: rgb(255, 255, 255);
         display: inline-block;
         margin-left: 10px;
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
         color: black;
         }
         input {
         font-family: "Helvetica Neue", Helvetica, sans-serif;
         font-size: 12px;
         outline: none;
         }
         input[type=text],
         input[type=password] ,input[type=re-password],input[type=time]{
         color: rgb(214, 12, 12);
         padding-left: 10px;
         margin: 10px;
         margin-top: 12px;
         margin-left: 18px;
         width: 300px;
         height: 25px;
         border: 1px solid #c7d0d2;
         border-radius: 2px;
         box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #f5f7f8;
         -webkit-transition: all .4s ease;
         -moz-transition: all .4s ease;
         transition: all .4s ease;
         }
         input[type=text]:hover,
         input[type=password]:hover,input[type=re-password]:hover,input[type=time]:hover {
         border: 1px solid #ffffff;
         box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .7), 0 0 0 5px #f5f7f8;
         }
         input[type=text]:focus,
         input[type=password]:focus,input[type=re-password]:focus,input[type=time]:focus {
         border: 1px solid #a8103b;
         box-shadow: inset 0 1.5px 3px rgba(190, 190, 190, .4), 0 0 0 5px #e6f2f9;
         }
         #lower {
         background-image: url("./rm.jpg");
         background: #ecf2f5;
         width: 100%;
         height: 79px;
         margin-top: 20px;
         box-shadow: inset 0 1px 1px #fff;
         border-top: 1px solid #ccc;
         border-bottom-right-radius: 3px;
         border-bottom-left-radius: 3px;
         }
         input[type=submit] {
         float: right;
         margin-right: 20px;
         margin-top: 20px;
         width: 150px;
         height: 30px;
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
         input[type=submit]:hover {
         background-image: -webkit-gradient(linear, left top, left bottom, from(#b6e2ff), to(#6ec2e8));
         background-image: -moz-linear-gradient(top left 90deg, #b6e2ff 0%, #162932 100%);
         background-image: linear-gradient(top left 90deg, #b6e2ff 0%, #6ec2e8 100%);
         }
         input[type=submit]:active {
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
                      <li><a href="login.php" data-after="Service">LOGIN</a></li>
                      <li><a href="#contact" data-after="Contact">Contact</a></li>
                  </ul>
              </div>
          </div>
      </div>
  </section>
  <!-- End Header -->


  

  
      <!-- Begin Page Content -->
      <div id="container">
         <h1>Signup page</h1>
         <p><h3>Please fill in this form to create an account</h3></p>
         <form action="" method="post">
            <label for="username">Enter Username:</label>
            <input type="text" id="username" name="username">
            <label for="password">Enter Password:</label>
            <input type="password" id="password" name="password">
            <label for="re-password"> Confirm Password:</label>
            <input type="re-password" id="cf_password" name="confirm_password">
            <div id="lower">
               <input type="submit" value="SIGNUP">
            </div>
            <!--/ lower-->
         </form>
      </div>
      <!--/ container-->
      <!-- End Page Content -->
   </body>
</html>












