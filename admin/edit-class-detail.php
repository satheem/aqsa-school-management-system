<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    // Fetch class details based on the provided id
    if (isset($_GET['id'])) {
        $class_id = intval($_GET['id']);
        $sql = "SELECT * FROM tblclass WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $class_id, PDO::PARAM_INT);
        $query->execute();
        $class = $query->fetch(PDO::FETCH_OBJ);
    }

    if (isset($_POST['submit'])) {
        $cname = $_POST['cname'];
        $section = $_POST['section'];
        $teacher = $_POST['teacher'];

        $sql = "UPDATE tblclass SET ClassName=:cname, Section=:section, TeacherID=:teacher WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cname', $cname, PDO::PARAM_STR);
        $query->bindParam(':section', $section, PDO::PARAM_STR);
        $query->bindParam(':teacher', $teacher, PDO::PARAM_INT);
        $query->bindParam(':id', $class_id, PDO::PARAM_INT);
        $query->execute();

        $msg = "Class has been updated.";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Management System || Edit Class</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- endinject -->
    <!-- Custom styles for this page -->
    <style>
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
            max-width: 500px;
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

        .form-group select {
            appearance: none;
            background-color: #f8f9fa;
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
                        <h3 class="page-title">Edit Class</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Class</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="form-container">
                        <div class="form-wrapper">
                            <h4 class="form-title">Edit Class</h4>
                            <?php if (isset($msg)) { echo "<p style='color: green;'>$msg</p>"; } ?>
                            <form method="post">
                                <div class="form-group">
                                    <label for="cname">Class Name</label>
                                    <input type="text" name="cname" id="cname" class="form-control" value="<?php echo htmlentities($class->ClassName); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="section">Section/Stream</label>
                                    <select name="section" id="section" class="form-control" required>
                                        <option value="">Choose Section/Stream</option>
                                        <option value="A" <?php if ($class->Section == "A") echo "selected"; ?>>A</option>
                                        <option value="B" <?php if ($class->Section == "B") echo "selected"; ?>>B</option>
                                        <option value="C" <?php if ($class->Section == "C") echo "selected"; ?>>C</option>
                                        <option value="D" <?php if ($class->Section == "D") echo "selected"; ?>>D</option>
                                        <option value="Bio Science" <?php if ($class->Section == "Bio Science") echo "selected"; ?>>Bio Science</option>
                                        <option value="Physical Science" <?php if ($class->Section == "Physical Science") echo "selected"; ?>>Physical Science</option>
                                        <option value="Commerce" <?php if ($class->Section == "Commerce") echo "selected"; ?>>Commerce</option>
                                        <option value="Engineering Technology" <?php if ($class->Section == "Engineering Technology") echo "selected"; ?>>Engineering Technology</option>
                                        <option value="Bio System Technology" <?php if ($class->Section == "Bio System Technology") echo "selected"; ?>>Bio System Technology</option>
                                        <option value="Arts" <?php if ($class->Section == "Arts") echo "selected"; ?>>Arts</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="teacher">Select Class Teacher</label>
                                    <select name="teacher" id="teacher" class="form-control" required>
                                        <option value="">Choose Teacher</option>
                                        <?php
                                        $sql = "SELECT id, full_name FROM tblteachers";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $teachers = $query->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($teachers as $teacher) {
                                            echo '<option value="' . htmlentities($teacher->id) . '" ' . ($teacher->id == $class->TeacherID ? 'selected' : '') . '>' . htmlentities($teacher->full_name) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit">Update</button>
                            </form>
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
    <!-- Plugin js for this page -->
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
    <!-- End custom js for this page -->
</body>

</html>
<?php } ?>
