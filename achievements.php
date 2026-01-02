<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achievements - THE AL AQSA SCHOOL</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://kit.fontawesome.com/0ca0bd90fd.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            color: #fff;
            background-color: #000; /* Keeping the black background consistent */
        }

        .achievements-container {
            max-width: 1200px;
            margin: 10px auto;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .achievements-header {
            text-align: center;
            font-size: 2.8em;
            background: linear-gradient(to right, #00ff00, #ffffff, #000000);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            border-radius: 50px;
            margin-top: 80px;
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .achievement-item {
            background-color: #000;
            border-radius: 10px;
            padding: 20px;
            box-shadow: rgba(2, 194, 44, 0.56) 5px 5px 20px 2px;
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .achievement-item h3 {
            color: gray;
            margin-bottom: 10px;
        }

        .achievement-item p {
            line-height: 1.6;
            color: #e0e0e0;
        }
    </style>
</head>

<body>
    <header>
        <script src="index.js"></script>
        <a href="#" class="logo"><img src="img/logo5.png" alt="Al Aqsa School Logo"></a>
        <ul>
            <li><a href="index.php" id="homeLink">HOME</a></li>
            <li><a href="news.php" id="newsLink">NEWS</a></li>
            <li><a href="about.php" id="aboutLink">ABOUT</a></li>
            <li><a href="achievements.php" class="active" id="achievementsLink">ACHIEVEMENTS</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn" id="staffMainLink">STAFF</a>
                <div class="dropdown-content">
                    <a href="astaffs.php" id="staffLink">ACADEMIC STAFF</a>
                    <a href="non_academic_staff.php" id="staffLink">NON-ACADEMIC STAFF</a>
                </div>
            </li>
            <li><a href="user/dashboard.php" id="studentsLink">STUDENTS</a></li>
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
                <li><a href="news.php">NEWS</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="astaffs.php">STAFFS</a></li>
                <li><a href="#">STUDENTS</a></li>
            </ul>
        </div>
    </header>

    <div class="achievements-container">
        <!-- Achievements Header -->
        <div class="achievements-header">
            <p>Our Achievements</p>
        </div>

        <!-- Achievement Items -->
        <div class="achievement-item">
            <h3>Achievement Title 1</h3>
            <p>Description of the achievement. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tempus turpis in facilisis varius.</p>
        </div>

        <div class="achievement-item">
            <h3>Achievement Title 2</h3>
            <p>Description of the achievement. Sed ac nisl vitae lorem blandit varius. Vivamus lacinia odio vitae vestibulum vestibulum.</p>
        </div>

        <div class="achievement-item">
            <h3>Achievement Title 3</h3>
            <p>Description of the achievement. Cras vehicula, libero eget dignissim consequat, sapien orci fermentum erat, ut sollicitudin eros magna non erat.</p>
        </div>

        </div>
    </div>

    <script>
        document.querySelector('.navbar-menu-toggle').addEventListener('click', function() {
            document.querySelector('.side-navbar').classList.toggle('active');
        });

        document.querySelector('.side-navbar .close-btn').addEventListener('click', function() {
            document.querySelector('.side-navbar').classList.remove('active');
        });
    </script>

    <footer>
        <div class="social">
            <a href="https://www.facebook.com/profile.php?id=61565391322022&mibextid=LQQJ4d" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://www.instagram.com/yourinstagramprofile" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.youtube.com/youryoutubechannel" target="_blank"><i class="fab fa-youtube"></i></a>
            <a href="tel:0262236539"><i class="fas fa-phone-alt"></i></a>
            <a href="mailto:yourmail@example.com"><i class="fas fa-envelope"></i></a>
        </div>
        <div class="links">
            <ul>
                <li><a href="#">HOME</a></li>
                <li><a href="#">NEWS</a></li>
                <li><a href="#">ABOUT</a></li>
                <li><a href="#">CONTACT</a></li>
                <li><a href="#">GALLERY</a></li>
            </ul>
        </div>
        <div class="credits">
            <p>&copy; <?php echo date('Y'); ?> Al Aqsa School. All Rights Reserved.</p>
            <p>Developed By<a href="#"> C4E</a></p>
        </div>
        <a href="https://web.whatsapp.com/send/?phone=94753747885" class="float" target="_blank">
            <i class="fa fa-whatsapp my-float"></i>
        </a>
    </footer>
</body>

</html>
