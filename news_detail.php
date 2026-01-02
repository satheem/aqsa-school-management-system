<?php
session_start();
include('admin/includes/dbconnection.php');

// Fetch the news item based on the id from the URL
$newsId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($newsId > 0) {
    // Prepare and execute the SQL query to get news details
    $sql = "SELECT Title, Content, Image, dateposted FROM tblnews WHERE ID = :newsId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':newsId', $newsId, PDO::PARAM_INT);
    $query->execute();
    $news = $query->fetch(PDO::FETCH_OBJ);

    if (!$news) {
        // If no news item is found, redirect or show an error message
        echo "<script>alert('News not found.');</script>";
        echo "<script>window.location.href = 'manage-news.php';</script>";
        exit;
    }

    // Define variables from the fetched data
    $title = htmlspecialchars($news->Title);
    $content = nl2br(htmlspecialchars($news->Content));
    $image = htmlspecialchars($news->Image);
    $date = htmlspecialchars($news->dateposted);
} else {
    echo "<script>alert('Invalid news ID.');</script>";
    echo "<script>window.location.href = 'manage-news.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - THE AL AQSA SCHOOL</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Tangerine" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://kit.fontawesome.com/0ca0bd90fd.js" crossorigin="anonymous"></script>
    <style>
        body {
            min-height: 0vh;
            font-family: 'Merriweather', serif;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
    max-width: 900px;
    margin: 30px auto; /* Center horizontally and add vertical margin */
    margin-top: 160px;  
    padding: 20px;
    background-color: #111;
    border-radius: 20px;
    box-shadow: rgba(0, 255, 106, 0.25) 0px 54px 55px, rgba(47, 255, 0, 0.12) 0px -12px 30px, rgba(9, 239, 55, 0.12) 0px 4px 6px, rgba(25, 215, 4, 0.17) 0px 12px 13px, rgba(0, 251, 84, 0.09) 0px -3px 5px;
    margin-bottom: 80px;
}
        .news-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .news-title {
            font-size: 2em;
            margin: 0;
            color: #00ff00;
        }
        .news-content {
            font-size: 1.2em;
            color: #ccc;
            line-height: 1.6;
        }
        .news-date {
            display: block;
            margin: 10px 0;
            font-size: 1em;
            color: #888;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 1em;
            color: #00ff00;
            background: #000;
            border: 1px solid #00ff00;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
        }
        .back-button:hover {
            background: #00ff00;
            color: #000;
        }
        footer{
            
        }
        footer .credits{
            display: block;
        }
    </style>
</head>

<body>
    <header>
        <a href="#" class="logo"><img src="img/logo5.png" alt="Al Aqsha School Logo"></a>
        <ul>
            <li><a href="index.php" id="homeLink">HOME</a></li>
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

    <div class="container">
        <img src="admin/uploads/<?php echo $image; ?>" alt="<?php echo $title; ?>" class="news-image">
        <h1 class="news-title"><?php echo $title; ?></h1>
        <span class="news-date"><?php echo $date; ?></span>
        <div class="news-content">
            <?php echo $content; ?>
        </div>
        <a href="news.php" class="back-button">Back to News</a>
    </div>

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
            <p>© 2024 Al Aqsha</p><br>
            <p>Developed By <a href="#"> C4E</a></p>
        </div>
        <a href="https://web.whatsapp.com/send/?phone=94753747885" class="float" target="_blank">
            <i class="fa fa-whatsapp my-float"></i>
        </a>
        <script src="index.js"></script>
    </footer>
</body>

</html>
