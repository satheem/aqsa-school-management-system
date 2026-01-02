<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Exams</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styling for the widget container */
        .widget-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        .widget-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            width: calc(33.333% - 20px);
            padding: 20px;
            height: 200px; /* Increased height */
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            text-align: center;
            border: 1px solid #e0e0e0;
            cursor: pointer;
            text-decoration: none; /* Ensures no underline on click */
        }

        .widget-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .widget-card h5 {
            margin: 0;
            font-size: 20px;
            color: gray;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .widget-card .actions {
            position: absolute;
            bottom: 15px;
            right: 15px;
        }

        .widget-card .actions a {
            color: gray;
            font-size: 18px;
            margin-left: 15px;
            text-decoration: none;
        }

        .widget-card .actions a:hover {
            color: #0056b3;
        }

        /* New widget for adding items */
        .widget-add {
            background: #f9f9f9;
            border: 2px dashed #d3d3d3;
            border-radius: 12px;
            width: calc(33.333% - 20px);
            padding: 20px;
            height: 200px; /* Increased height */
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .widget-add:hover {
            background: #f1f1f1;
            border-color: #bbb;
        }

        .widget-add i {
            font-size: 50px;
            color: #4CAF50; /* Green color for plus icon */
            margin-bottom: 10px;
            margin-top: 25px;
        }

        .widget-add h5 {
            margin: 0;
            font-size: 20px;
            color: #4CAF50; /* Green color for text */
        }
    </style>
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
                        <h3 class="page-title">Manage Exams</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Exams</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="widget-container">
                                        <!-- Add Exam Widget -->
                                        <div class="widget-add" onclick="window.location.href='add-exam.php';">
                                            <i class="fas fa-plus-circle"></i>
                                            <h5>Add New Exam</h5>
                                        </div>

                                        <?php
                                        // Fetch exams from the database
                                        $sql = "SELECT ID, ExamName FROM tblexaminations";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        foreach($results as $result) {
                                        ?>
                                        <a href="manage-marks.php?exam_id=<?php echo htmlentities($result->ID); ?>" class="widget-card">
                                            <h5><?php echo htmlentities($result->ExamName); ?></h5>
                                            <div class="actions">
                                                <a href="edit-exam.php?id=<?php echo htmlentities($result->ID); ?>"><i class="icon-pencil"></i></a>
                                                <a href="process_marks.php?delid=<?php echo htmlentities($result->ID); ?>" onclick="return confirm('Do you really want to delete this exam?');"><i class="icon-trash"></i></a>
                                            </div>
                                        </a>
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
