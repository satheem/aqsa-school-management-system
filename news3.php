<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News - THE AL AQSA SCHOOL</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Tangerine" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://kit.fontawesome.com/0ca0bd90fd.js" crossorigin="anonymous"></script>
    <style>
        body{
            min-height: 0vh;
        }
        .news-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }
        .news-item {
            background: #000;
            border-radius: 10px;
            box-shadow: rgba(2, 194, 44, 0.56) 5px 5px 20px 2px;
            overflow: hidden;
            max-width: 300px;
            text-align: center;
            transition: transform 0.3s ease;
            margin: 5px;
            padding: 5px;
            z-index: 10;
            animation: autoShowAnimation2;
            animation-timeline: view(60% auto);
        
        }
        .news-item:hover {
            transform: translateY(-10px);
            box-shadow: rgba(0, 255, 106, 0.25) 0px 54px 55px, rgba(47, 255, 0, 0.12) 0px -12px 30px, rgba(9, 239, 55, 0.12) 0px 4px 6px, rgba(25, 215, 4, 0.17) 0px 12px 13px, rgba(0, 251, 84, 0.09) 0px -3px 5px;
        }
        .news-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .news-title {
            font-size: 1.2em;
            margin: 10px 0;
            color: #333;
            
        }
        .news-content {
            color: #666;
            padding: 0 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2; /* Limit to 3 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .news-date {
            display: block;
            margin: 10px 0;
            font-size: 0.8em;
            color: #999;
        }
        .heading-container {
    text-align: center;
    margin: 40px 0;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Slightly stronger shadow */
    margin-top: 25vh;
}

.heading-title {
    position: relative;
    font-size: 2.5em;
    font-weight: 700;
    background: linear-gradient(45deg, #00ff00, #000000);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin: 0;
    padding: 0;
    text-transform: uppercase;
}

.heading-title::after {
    content: "";
    display: block;
    height: 3px; /* Adjust the height of the gradient line */
    background: linear-gradient(45deg, #00ff00, #000000);
    margin: 0px auto; /* Center the line and provide spacing */
    width: 50%; /* Adjust the width of the line */
    border-radius: 5px; /* Optional: round the corners */
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
            <li><a href="news.php" class="active" id="newsLink">NEWS</a></li>
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
    <div class="heading-container">
        <h1 class="heading-title">Latest News</h1>
    </div>
    <div class="news-section">
        <div class="news-container">
            <!-- News articles will be dynamically inserted here -->
        </div>
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
            <p>Developed By<a href="#"> C4E</a></p>
        </div>
        <a href="https://web.whatsapp.com/send/?phone=94753747885" class="float" target="_blank">
            <i class="fa fa-whatsapp my-float"></i>
        </a>
    </footer>
<script src="index.js"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            fetch('fetch_news.php') // Adjust this to your news fetching endpoint
                .then(response => response.json())
                .then(data => {
                    const newsContainer = document.querySelector('.news-container');
                    data.forEach(article => {
                        const newsItem = document.createElement('div');
                        newsItem.classList.add('news-item');

                        newsItem.innerHTML = `
                            <img src="admin/uploads/${article.image}" alt="News Image" class="news-image">
                            <h3 class="news-title">${article.title}</h3>
                            <p class="news-content">${article.content}</p>
                            <span class="news-date">${article.dateposted}</span>
                        `;

                        newsContainer.appendChild(newsItem);
                    });
                })
                .catch(error => console.error('Error fetching news:', error));
        });
    </script>

</body>

</html>
