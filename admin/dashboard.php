<?php
session_start();
error_reporting(E_ALL); // Enable all errors for debugging
ini_set('display_errors', 1);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    try {
        // Fetching counts from the database for the dashboard
        $totalStudents = $dbh->query("SELECT COUNT(*) FROM tblstudent")->fetchColumn();
        $totalTeachers = $dbh->query("SELECT COUNT(*) FROM tblteachers")->fetchColumn();
        $totalClasses = $dbh->query("SELECT COUNT(*) FROM tblclass")->fetchColumn();
        $totalNews = $dbh->query("SELECT COUNT(*) FROM tblnews")->fetchColumn();
        $totalStaff = $dbh->query("SELECT COUNT(*) FROM tblstaff")->fetchColumn(); // Assuming 'tblstaff' table exists
    } catch (PDOException $e) {
        // Display error message if there is an issue with the database queries
        echo "Error: " . $e->getMessage();
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Management System | Dashboard</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="./vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="./vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Widget Styles */
        .widget-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            justify-content: center; /* Center items horizontally */
        }

        .widget-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            width: calc(25% - 20px);
            padding: 20px;
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            text-align: center;
            border: 1px solid #e0e0e0;
            cursor: pointer;
            text-decoration: none; /* Remove underline from links */
            color: inherit; /* Inherit text color */
        }

        .widget-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
            text-decoration: none; 
        }

        .widget-card .icon {
            font-size: 50px;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .widget-card h5 {
            margin: 0;
            font-size: 18px;
            color: gray;
        }

        .widget-card .count {
            font-size: 28px;
            color: #007BFF;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container-scroller">
    <?php include_once('includes/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('includes/sidebar.php'); ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">Dashboard</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-container">
                                    <!-- Total Students Widget -->
                                    <a href="manage-students.php" class="widget-card">
                                        <div class="icon"><i class="fas fa-user-graduate"></i></div>
                                        <h5>Total Students</h5>
                                        <div class="count"><?php echo $totalStudents; ?></div>
                                    </a>

                                    <!-- Total Teachers Widget -->
                                    <a href="manage-teachers.php" class="widget-card">
                                        <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                                        <h5>Total Teachers</h5>
                                        <div class="count"><?php echo $totalTeachers; ?></div>
                                    </a>

                                    <!-- Total Classes Widget -->
                                    <a href="manage-class.php" class="widget-card">
                                        <div class="icon"><i class="fas fa-school"></i></div>
                                        <h5>Total Classes</h5>
                                        <div class="count"><?php echo $totalClasses; ?></div>
                                    </a>
                                    <!-- Total Staff Widget -->
                                    <a href="manage-staff.php" class="widget-card">
                                        <div class="icon"><i class="fas fa-users"></i></div>
                                        <h5>Total Staff</h5>
                                        <div class="count"><?php echo $totalStaff; ?></div>
                                    </a>
                                    <!-- Total News Widget -->
                                    <a href="manage-news.php" class="widget-card">
                                        <div class="icon"><i class="fas fa-newspaper"></i></div>
                                        <h5>Total News</h5>
                                        <div class="count"><?php echo $totalNews; ?></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>
</div>
<script src="vendors/js/vendor.bundle.base.js"></script>
<script src="js/off-canvas.js"></script>
<script src="js/hoverable-collapse.js"></script>
<script src="js/misc.js"></script>
<script src="js/settings.js"></script>
<script src="js/todolist.js"></script>
</body>
</html>
<?php } ?>
