<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if the session variable is set and not empty
if (!isset($_SESSION['sturecmsaid']) || strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
    exit;
} else {
    // Handle deletion if 'delid' is set
    if (isset($_GET['delid'])) {
        $rid = $_GET['delid']; // Getting the Teacher ID
        try {
            $sql = "DELETE FROM tblteachers WHERE TeacherID = :rid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':rid', $rid, PDO::PARAM_STR);
            if ($query->execute()) {
                echo "<script>alert('Data deleted');</script>";
            } else {
                echo "<script>alert('Failed to delete data');</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
        echo "<script>window.location.href = 'manage-teachers.php';</script>";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Teacher Management System | Manage Teachers</title>
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

        .widget-card, .widget-add {
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
            cursor: pointer;
        }

        .widget-card:hover, .widget-add:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .widget-card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
            margin-bottom: 15px;
        }

        .widget-card h5 {
            margin: 0;
            font-size: 18px;
            color: gray;
        }

        .widget-card .teacher-id {
            font-size: 16px;
            color: #007BFF;
            margin-top: 10px;
            font-weight: bold;
        }

        .widget-card .actions {
            margin-top: 20px; /* Space between details and actions */
            text-align: center; /* Center align the actions */
        }

        .widget-card .actions a {
            color: gray;
            font-size: 18px;
            margin: 5px; /* Space between action icons */
            text-decoration: none;
            display: inline-block; /* Inline block for spacing */
        }

        .widget-card .actions a:hover {
            color: #0056b3;
        }

        /* Add Teacher Button */
        .widget-add {
            background: #f9f9f9;
            border: 2px dashed #d3d3d3;
            border-radius: 12px;
            width: calc(33.333% - 20px);
            padding: 20px;
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
            margin-top: 70px;
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
    <?php include_once('includes/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('includes/sidebar.php'); ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">Manage Teachers</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Teachers</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-container">
                                    <!-- Add Teacher Widget -->
                                    <div class="widget-add" onclick="window.location.href='add-teachers.php';">
                                        <i class="fas fa-plus-circle"></i>
                                        <h5>Add Teacher</h5>
                                    </div>

                                    <!-- Display Teachers -->
<?php
try {
    // SQL query to fetch all teachers
    $sql = "SELECT TeacherID, full_name AS TeacherName, photo AS Image FROM tblteachers";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        foreach ($results as $row) { ?>
            <div class="widget-card">
                <img src="uploads/<?php echo htmlentities($row->Image); ?>" alt="<?php echo htmlentities($row->TeacherName); ?>">
                <h5><?php echo htmlentities($row->TeacherName); ?></h5>
                <div class="teacher-id"><?php echo htmlentities($row->TeacherID); ?></div>
                <div class="actions">
                    <a href="view-teacher.php?viewid=<?php echo htmlentities($row->TeacherID); ?>"><i class="fas fa-eye"></i></a>
                    <a href="edit-teacher-detail.php?id=<?php echo htmlentities($row->TeacherID); ?>"><i class="fas fa-pencil-alt"></i></a>
                    <a href="manage-teachers.php?delid=<?php echo htmlentities($row->TeacherID); ?>" onclick="return confirm('Do you really want to delete this teacher?');"><i class="fas fa-trash"></i></a>
                </div>
            </div>
        <?php }
    } else { ?>
        <p>No teachers found.</p>
    <?php }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
                                    <!-- End of teacher cards -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once('includes/footer.php'); ?>
        </div>
    </div>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
</div>
</body>
</html>
<?php
}
?>
