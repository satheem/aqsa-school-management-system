<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid'])==0) {
    header('location:logout.php');
} else {
    // Handle class deletion
    if (isset($_GET['delid'])) {
        $delid = intval($_GET['delid']);  // Ensure delid is an integer
        $sql = "DELETE FROM tblclass WHERE ID = :delid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':delid', $delid, PDO::PARAM_INT);
        $query->execute();
        
        // Check if deletion was successful
        if ($query->rowCount() > 0) {
            echo "<script>alert('Class deleted successfully.');</script>";
            echo "<script>window.location.href = 'manage-class.php';</script>";
        } else {
            echo "<script>alert('An error occurred. Please try again.');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Classes</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Advanced styling for the widget */
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
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            text-align: center;
            border: 1px solid #e0e0e0;
            cursor: pointer; /* Add cursor pointer to indicate clickability */
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

        .widget-card .description {
            font-size: 16px;
            color: black;
            margin-top: 10px;
        }

        .widget-card .actions {
            position: absolute;
            bottom: 15px;
            right: 15px;
            display: flex;
            gap: 10px; /* Add gap between icons */
        }

        .widget-card .actions a {
            color: gray;
            font-size: 18px;
            text-decoration: none;
        }

        .widget-card .actions a:hover {
            color: #0056b3;
        }

        .student-count {
            font-size: 32px;
            font-weight: bold;
            color: #007BFF; /* Changed color to blue */
            margin: 15px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .student-count .fa-users {
            font-size: 32px;
            color: #007BFF; /* Matching icon color */
            margin-left: 10px;
        }

        /* New widget for adding items */
        .widget-add {
            background: #ffffff; /* Set to white to match widget-card background */
            border-radius: 12px;
            width: calc(33.333% - 20px);
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0; /* Match border with widget-card */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Match box-shadow with widget-card */
            border: 2px dashed #d3d3d3;
        }

        .widget-add:hover {
            background: #f1f1f1;
            border-color: #bbb;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .widget-add i {
            font-size: 50px;
            color: #4CAF50; /* Green color for plus icon */
            margin-bottom: 10px;
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
                        <h3 class="page-title">Manage Classes</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Classes</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="widget-container">
                                        <!-- New Add Item Widget -->
                                        <div class="widget-add" onclick="window.location.href='add-class.php';">
                                            <i class="fas fa-plus-circle"></i>
                                            <h5>Add New Class</h5>
                                        </div>

                                        <?php
                                        // Display individual class widgets
                                        $sql = "SELECT tblclass.ID, tblclass.ClassName, tblclass.Section, COUNT(tblstudent.ID) AS student_count
                                                FROM tblclass
                                                LEFT JOIN tblstudent ON tblstudent.StudentClass = tblclass.ID
                                                GROUP BY tblclass.ID, tblclass.ClassName, tblclass.Section";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        foreach($results as $result) {
                                        ?>
                                        <div class="widget-card">
                                            <h5>Grade <?php echo htmlentities($result->ClassName) . ' ' . htmlentities($result->Section); ?></h5>

                                            <div class="student-count">
                                                <?php echo htmlentities($result->student_count); ?> <i class="fa-solid fa-users"></i>
                                            </div>
                                          
                                            <div class="actions">
                                                <a href="manage-students.php?class_id=<?php echo htmlentities($result->ID); ?>" title="View Class Details"><i class="fas fa-eye"></i></a>
                                                <a href="edit-class-detail.php?id=<?php echo htmlentities($result->ID); ?>" title="Edit Class Details"><i class="fas fa-pencil-alt"></i></a>
                                                <a href="manage-class.php?delid=<?php echo htmlentities($result->ID); ?>" onclick="return confirm('Do you really want to delete this class?');" title="Delete Class"><i class="fas fa-trash"></i></a>
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
