<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentmsdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination variables
$limit = 25; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search query
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Fetch total number of records
$sql_total = "SELECT COUNT(*) as total FROM tblteachers WHERE full_name LIKE '%$search%' OR appointment_subject LIKE '%$search%' OR edu_qualify LIKE '%$search%' OR prof_qualify LIKE '%$search%'";
$result_total = $conn->query($sql_total);
$total = $result_total->fetch_assoc()['total'];
$pages = ceil($total / $limit);

// Fetch academic staff data
$sql = "SELECT * FROM tblteachers WHERE full_name LIKE '%$search%' OR appointment_subject LIKE '%$search%' OR edu_qualify LIKE '%$search%' OR prof_qualify LIKE '%$search%' LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Staff - THE AL AQSA SCHOOL</title>
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
            background-color: #000;
            margin: 0;
        }

        .staff-container {
            max-width: 1200px;
            margin: 10px auto 10px auto;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            gap: 40px;
            font-family: "Poppins", sans-serif;
        }

        .staff-header {
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

        .search-container {
            display: flex;
            justify-content: center;
            margin: 20px auto;
        }

        .search-container form {
            display: flex;
            gap: 10px;
        }

        .search-container input {
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ddd;
            color: #333;
        }

        .search-container button {
            padding: 10px 15px;
            background-color: #00ff00;
            color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .search-container button:hover {
            background-color: #00cc00;
        }

        .staff-item {
            background-color: #000;
            border-radius: 20px;
            padding: 20px;
            box-shadow: rgba(2, 194, 44, 0.56) 1px 2px 20px 0px;
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
        }

        .staff-item img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            pointer-events: none;
        }

        .staff-item h3 {
            color: gray;
            margin-bottom: 10px;
        }

        .staff-item p {
            line-height: 1.6;
            color: #e0e0e0;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            background-color: #000;
            color: #00ff00;
            border: none;
            padding: 10px 15px;
            margin: 0 5px;
            text-decoration: none;
            font-size: 1em;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination a.active {
            background-color: #00ff00;
            color: #000;
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
            <li><a href="achievements.php" id="achievementsLink">ACHIEVEMENTS</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn active" id="staffMainLink">STAFF</a>
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

    <div class="staff-container">
        <div class="staff-header">
            <p>Academic Staff</p>
        </div>

        <!-- Search Bar -->
        <div class="search-container">
            <form action="" method="get">
                <input type="text" name="search" placeholder="Search staff..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="staff-item">
                    <img src="admin/uploads/<?php echo htmlspecialchars($row['photo']); ?>" alt="<?php echo htmlspecialchars($row['full_name']); ?>">
                    <div>
                        <h3><?php echo htmlspecialchars($row['full_name']); ?></h3>
                        <p><strong>Subject:</strong> <?php echo htmlspecialchars($row['appointment_subject']); ?></p>
                        <p><strong>Qualifications:</strong> <?php echo htmlspecialchars($row['edu_qualify']) . ', ' . htmlspecialchars($row['prof_qualify']); ?></p>
                        <p><strong>First Appointment:</strong> <?php echo htmlspecialchars(date('F j, Y', strtotime($row['first_appointment']))); ?></p>
                        <p><strong>Appointed This School:</strong> <?php echo htmlspecialchars(date('F j, Y', strtotime($row['appointed_this_school']))); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No staff members found.</p>
        <?php endif; ?>

        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>">Previous</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            <?php if ($page < $pages): ?>
                <a href="?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>">Next</a>
            <?php endif; ?>
        </div>
    </div>
    <script>document.querySelector('.navbar-menu-toggle').addEventListener('click', function() {
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
