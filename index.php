<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>My Website</title>
</head>

<body>
    <!-- Header -->
    <section id="header">
        <div class="header container">
            <div class="nav-bar bg-dark" >
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
                        <li><a href="login.php" data-after="Login">LOGIN</a></li>
                        <li><a href="#contact" data-after="Contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- End Header -->


    <!-- Hero Section  -->
    <section id="hero">
        <div class="hero container">
            <div>
                <h1>WELCOME <span></span></h1>
                <h1>TO <span></span></h1>
                <h1>RESUFOND<span></span></h1>
                <a href="register.php" type="button" class="cta">Get Started For Free</a>
            </div>
        </div>
    </section>
    <!-- End Hero Section  -->

    <!-- Contact Section -->
    <section id="contact">
        <div class="contact container">
            <div>
                <h1 class="section-title">Contact <span>info</span></h1>
            </div>
            <div class="contact-items">
                <div class="contact-item">
                    <div class="icon"><img src="https://img.icons8.com/bubbles/100/000000/phone.png" /></div>
                    <div class="contact-info">
                        <h1>Phone</h1>
                        <h2>+91 931 588 2088</h2>
                        <h2>+91 844 771 5366</h2>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="icon"><img src="https://img.icons8.com/bubbles/100/000000/new-post.png" /></div>
                    <div class="contact-info">
                        <h1>Email</h1>
                        <h2>anurag8745@gmail.com</h2>
                        <h2>abcd@gmail.com</h2>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="icon"><img src="https://img.icons8.com/bubbles/100/000000/map-marker.png" /></div>
                    <div class="contact-info">
                        <h1>Address</h1>
                        <h2>New Delhi</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Section -->

    <!-- Footer -->
    <section id="footer">
        <div class="footer container">
            <div class="brand">
                <h1>RESUFOND</h1>
            </div>
            <h2>Your Complete Web Solution</h2>
            <div class="social-icon">
                <div class="social-item">
                    <a href="#"><img src="https://img.icons8.com/bubbles/100/000000/facebook-new.png" /></a>
                </div>
                <div class="social-item">
                    <a href="#"><img src="https://img.icons8.com/bubbles/100/000000/instagram-new.png" /></a>
                </div>
                <div class="social-item">
                    <a href="#"><img src="li.png" /></a>
                </div>
                <div class="social-item">
                    <a href="#"><img src="co.png" /></a>
                </div>
            </div>
            <p>Copyright © 2023 RESUFOND All rights reserved</p>
        </div>
    </section>
    <!-- End Footer -->
    <script src="./app.js"></script>
</body>

</html>