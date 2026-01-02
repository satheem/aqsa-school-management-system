<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'])==0) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Subjects</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        /* Advanced styling for the widget */
        .widget-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            /* Light background color for a clean look */
        }

        .widget-card {
            background: #ffffff; /* White background for the cards */
            border-radius: 12px; /* Rounded corners */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            width: calc(33.333% - 20px);
            padding: 20px;
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.3s ease, transform 0.3s ease; /* Smooth transitions */
            text-align: center;
            border: 1px solid #e0e0e0; /* Light border for card separation */
        }

        .widget-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
            transform: translateY(-5px); /* Slight lift effect */
        }

        .widget-card h5 {
            margin: 0;
            font-size: 20px; /* Slightly larger font for headings */
            color: gray;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .widget-card .description {
            font-size: 16px; /* Larger font for description */
            color: black; /* Slightly lighter color for description */
            margin-top: 10px; /* Space between heading and description */
        }

        .widget-card .actions {
            position: absolute;
            bottom: 15px;
            right: 15px;
        }

        .widget-card .actions a {
            color: gray; /* Primary action color */
            font-size: 18px; /* Larger icons */
            margin-left: 15px;
            text-decoration: none;
        }

        .widget-card .actions a:hover {
            color: #0056b3; /* Darker color on hover */
        }

        .student-count {
            font-size: 32px; /* Larger font size for student count */
            font-weight: bold;
            color: #4CAF50; /* Green color for student count */
            margin: 15px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .student-icon {
            font-size: 50px; /* Larger icon size */
            color: #4CAF50; /* Matching icon color */
            margin-right: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <?php include_once('includes/header.php'); ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php include_once('includes/sidebar.php'); ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Manage Subjects</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Subjects</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="widget-container">
                                        <?php
                                        $sql = "SELECT ID, SubjectName, SubjectCode FROM tblsubjects";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        foreach($results as $result) {
                                        ?>
                                        <div class="widget-card">
                                            <h5><?php echo htmlentities($result->SubjectName); ?></h5>
                                            <div class="description">
                                                <?php echo htmlentities($result->SubjectCode); ?>
                                            </div>
                                            <div class="actions">
                                                <a href="edit-subject.php?id=<?php echo htmlentities($result->ID); ?>"><i class="fas fa-pencil-alt"></i></a>
                                                <a href="manage-subjects.php?delid=<?php echo htmlentities($result->ID); ?>" onclick="return confirm('Do you really want to delete this subject?');"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <?php include_once('includes/footer.php'); ?>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
</body>
</html>
<?php } ?>
