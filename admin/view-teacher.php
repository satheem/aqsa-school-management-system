<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
    exit;
}

// Retrieve teacher details based on viewid
if (isset($_GET['viewid'])) {
    $viewid = intval($_GET['viewid']);

    $sql = "SELECT * FROM tblteachers WHERE TeacherID = :viewid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':viewid', $viewid, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        echo "<script>alert('Invalid teacher ID.');</script>";
        echo "<script>window.location.href ='manage-teachers.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No teacher ID provided.');</script>";
    echo "<script>window.location.href ='manage-teachers.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Teacher</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Custom styles -->
    <style>
           .view-wrapper {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 800px;
        }

        .teacher-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 800px;
            margin: auto;
        }

        .teacher-photo {
            text-align: center;
            margin-bottom: 20px;
        }

        .teacher-photo img {
            border-radius: 50%;
            max-width: 150px;
            height: auto;
        }

        .teacher-details h4 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .teacher-details p {
            margin-bottom: 10px;
            font-size: 16px;
            color: #555;
        }

        .teacher-details span {
            font-weight: bold;
            color: #333;
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
                        <h3 class="page-title">View Student</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="manage-teachers.php">Manage Teachers</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Teachers</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="teacher-card">
                        <div class="teacher-photo">
                            <img src="uploads/<?php echo htmlspecialchars($result['photo']); ?>" alt="Teacher Photo">
                        </div>
                        <div class="teacher-details">
                            <h4><?php echo htmlspecialchars($result['full_name']); ?></h4>
                            <p><span>Teacher ID:</span> <?php echo htmlspecialchars($result['TeacherID']); ?></p>
                            <p><span>Gender:</span> <?php echo htmlspecialchars($result['gender']); ?></p>
                            <p><span>First Appointment:</span> <?php echo htmlspecialchars($result['first_appointment']); ?></p>
                            <p><span>Appointed This School:</span> <?php echo htmlspecialchars($result['appointed_this_school']); ?></p>
                            <p><span>Appointment Subject:</span> <?php echo htmlspecialchars($result['appointment_subject']); ?></p>
                            <p><span>Educational Qualification:</span> <?php echo htmlspecialchars($result['edu_qualify']); ?></p>
                            <p><span>Professional Qualification:</span> <?php echo htmlspecialchars($result['prof_qualify']); ?></p>
                            <p><span>Service Grade:</span> <?php echo htmlspecialchars($result['service_grade']); ?></p>
                            <p><span>Email:</span> <?php echo htmlspecialchars($result['email']); ?></p>
                        </div>
                    </div>
                </div>
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
</body>
</html>
