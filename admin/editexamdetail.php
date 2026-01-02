<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['update'])) {
        $examid = $_POST['examid'];
        $examname = $_POST['examname'];
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];

        $sql = "UPDATE tblexaminations SET ExamName=:examname, StartDate=:startdate, EndDate=:enddate WHERE ID=:examid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':examname', $examname, PDO::PARAM_STR);
        $query->bindParam(':startdate', $startdate, PDO::PARAM_STR);
        $query->bindParam(':enddate', $enddate, PDO::PARAM_STR);
        $query->bindParam(':examid', $examid, PDO::PARAM_STR);

        if ($query->execute()) {
            $msg = "Examination details updated successfully.";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }

    if (isset($_GET['delid'])) {
        $examid = intval($_GET['delid']);
        $sql = "DELETE FROM tblexaminations WHERE ID=:examid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':examid', $examid, PDO::PARAM_STR);

        if ($query->execute()) {
            $msg = "Examination deleted successfully.";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Examination Details</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        /* Additional styling for the form */
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .form-wrapper {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 600px;
        }

        .form-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 8px;
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ced4da;
        }

        .btn-primary {
            display: block;
            width: 100%;
            background-color: #28a745;
            color: white;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .btn-primary:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .dropdown {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 100%;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        #delete{
            background-color: red   ;
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
                        <h3 class="page-title">Edit Examination Details</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Examination</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="form-container">
                        <div class="form-wrapper">
                            <h4 class="form-title">Update Examination Details</h4>
                            <?php if (isset($msg)) { echo "<p style='color: green;'>$msg</p>"; } ?>
                            <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>

                            <form method="post">
                                <div class="form-group">
                                    <label for="examid">Select Examination</label>
                                    <div class="dropdown">
                                        <select name="examid" id="examid" class="form-control" required>
                                            <option value="">Select Examination</option>
                                            <?php
                                            $sql = "SELECT ID, ExamName FROM tblexaminations";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $exams = $query->fetchAll(PDO::FETCH_OBJ);
                                            if ($exams) {
                                                foreach ($exams as $exam) {
                                                    echo '<option value="' . htmlentities($exam->ID) . '">' . htmlentities($exam->ExamName) . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No examinations found</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="examname">Examination Name</label>
                                    <input type="text" name="examname" id="examname" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="startdate">Start Date</label>
                                    <input type="date" name="startdate" id="startdate" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="enddate">End Date</label>
                                    <input type="date" name="enddate" id="enddate" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="update">Update</button>
                            </form>
                            <hr>
                            <h4 class="form-title" style="margin-top: 30px;">Delete Examination</h4>
                            <form method="get">
                                <div class="form-group">
                                    <label for="delid">Select Examination to Delete</label>
                                    <select name="delid" id="delid" class="form-control" required>
                                        <option value="">Select Examination</option>
                                        <?php
                                        $sql = "SELECT ID, ExamName FROM tblexaminations";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $exams = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($exams) {
                                            foreach ($exams as $exam) {
                                                echo '<option value="' . htmlentities($exam->ID) . '">' . htmlentities($exam->ExamName) . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">No examinations found</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" id="delete"class="btn btn-primary">Delete</button>
                            </form>

                        </div>
                    </div>
                </div>
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
</body>

</html>
<?php } ?>
