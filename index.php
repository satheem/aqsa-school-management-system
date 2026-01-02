<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THE AL AQSA SCHOOL</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Tangerine" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://kit.fontawesome.com/0ca0bd90fd.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <a href="#" class="logo"><img src="img/logo5.png" alt="Al Aqsha School Logo"></a>
        
        <ul>
            <li><a href="index.php" class="active" id="homeLink">HOME</a></li>
            <li><a href="news.php" id="newsLink">NEWS</a></li>
            <li><a href="about.php" id="aboutLink">ABOUT</a></li>
            <li><a href="achievements.php" id="achievementsLink">ACHIEVEMENTS</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn" id="staffMainLink">STAFF</a>
                <div class="dropdown-content">
                    <a href="astaffs.html" id="staffLink">ACADEMIC STAFF</a>
                    <a href="non_academic_staff.php" id="staffLink">NON-ACADEMIC STAFF</a>
                </div>
            </li>            
            <li><a href="user/login.php" id="studentsLink">STUDENTS</a></li>
        </ul>
        
        <div class="navbar-menu-toggle">
            <i class="fa-solid fa-bars"></i>
        </div>
        <div class="side-navbar">
            <p class="close-btn" style="text-align: right;">
                <i class="fa-solid fa-xmark"></i>
            </p>
            <ul class="side-nav-link">
                <li><a href="index.php">HOME</a></li>
                <li><a href="news">NEWS</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="astaffs.php">A-STAFFS</a></li>
                <li><a href="non_academic_staff.php">NA-STAFFS</a></li>
                <li><a href="user/login.php">STUDENTS</a></li>
            </ul>
        </div>
    </header>
    <div class="slider-container" >
       <a href="news.php"><div class="slide-track">
            <!-- Images will be dynamically added here -->
        </div></a> 
    </div>

    <section>
        <div id="box" class="box">
            <div class="content">
                <div class="info">
                    
                <h1>
  <a href="" class="typewrite" data-period="2000" data-type='[ "Hey Guys,", "It&apos;s Al Aqsa NS" ]'>
    <span class="wrap"></span>
  </a>
</h1>

                </div>
            </div>
        </div>
    </section>
    
    <div class="about">
        <br><br>
        <h2>A History of Great Achievements and New Ideas.</h2><br>
        <p>At Al Aqsha School, we believe in every student's potential and are dedicated to helping you succeed. We provide the tools, inspiration, and guidance you need to achieve your goals. Our resources and advice will help you excel academically and personally. Join our community, explore our platform, and let us support you on your journey to a bright and successful future. Together, we can achieve great things!</p>
        <a href="#">Discover Life at Reid Avenue</a>
        <div class="chat-container">
            <div class="chat-message received">
                <img src="img/principal1.jpg" alt="Principal">
                <div class="chat-bubble">
                    <p>At Al Aqsha School, we believe in every student's potential and are dedicated to helping you succeed. We provide the tools, inspiration, and guidance you need to achieve your goals. Our resources and advice will help you excel academically and personally. Join our community, explore our platform, and let us support you on your journey to a bright and successful future. Together, we can achieve great things!</p>
                    <span class="principal-name">- Principal A.M.Mulawfer</span>
                </div>
            </div>

            <div class="chat-message sent">
                <div class="chat-bubble">
                    <p>Thank you, Principal. I am excited to start this journey!</p>
                </div>
            </div>

            <div class="chat-message received">
                <img src="img/principal1.jpg" alt="Principal">
                <div class="chat-bubble">
                    <p>We are excited to have you with us. Let's achieve greatness together!</p>
                    <span class="principal-name">- Principal A.M.Mulawfer</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="intro-container">
        <div class="source-container">
            <img src="img/source.jpg" alt="Development Source Code Image">
        </div>
        <p><u>Code for Everything</u></p>
        <p>At Code for Everything, we are a passionate team of developers committed to pushing the boundaries of technology. As part of the Developers Club, we create innovative solutions and dynamic digital experiences that set new standards in the tech world.</p>
        <p>Our latest project, "Al Aqsha," is a testament to our dedication to excellence and creativity. At Devaxa, we strive to transform ideas into reality and deliver cutting-edge digital solutions that lead the industry. Explore our work and join us on our journey to shape the future of technology.</p>
        <p class="source-info">Discover. Innovate. Excel.</p>
    </div>

    <footer>
        <div class="contact-container">
            <h1>Contact Us</h1>
            <form action="contact.php" method="post">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Your Name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Your Email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="4" placeholder="Your Message" required></textarea>

                <input type="submit" value="Send Message">
            </form>
            <hr>
        </div>
        <div class="social">
            <a href="https://www.facebook.com/profile.php?id=61565391322022&mibextid=LQQJ4d" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/yourinstagramprofile" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.youtube.com/youryoutubechannel" target="_blank"><i class="fab fa-youtube"></i></a>
            <a href="tel:0262236539"><i class="fas fa-phone-alt"></i></a>
            <a href="mailto:yourmail@example.com"><i class="fas fa-envelope"></i></a>
        </div>
        <div class="links">
            <ul>
            <li><a href="index.php">HOME</a></li>
                <li><a href="news">NEWS</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="astaffs.php">A-STAFFS</a></li>
                <li><a href="non_academic_staff.php">NA-STAFFS</a></li>
                <li><a href="user/login.php">STUDENTS</a></li>
            </ul>
        </div>
        <div class="credits">
            <p>© 2024 Al Aqsha</p>
            <p>Developed By<a href="#"> C4E</a></p>
        </div>
        <a href="https://web.whatsapp.com/send/?phone=94753747885" class="float" target="_blank">
            <i class="fa fa-whatsapp my-float"></i>
        </a>
    </footer> 

    <script src="index.js"></script>

</body>

</html>
