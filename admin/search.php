<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
}

$msg = '';
$error = '';

// Handle search functionality
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];
    $searchBy = $_POST['searchBy'];

    $sql = "SELECT * FROM tblstudent WHERE ";
    
    if ($searchBy == 'name') {
        $sql .= "StudentName LIKE :searchTerm";
    } elseif ($searchBy == 'class') {
        $sql .= "StudentClass LIKE :searchTerm";
    } elseif ($searchBy == 'contact') {
        $sql .= "ContactNumber LIKE :searchTerm";
    }
    
    $query = $dbh->prepare($sql);
    $query->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $query->execute();
    $students = $query->fetchAll(PDO::FETCH_OBJ);
    
    if (empty($students)) {
        $msg = "No students found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System || Search Students</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- inject:css -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- Custom styles -->
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
            max-width: 800px;
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

        .search-bar {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar select,
        .search-bar input {
            margin-right: 10px;
        }

        .btn-primary {
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

        .search-results {
            margin-top: 30px;
        }

        .student-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .student-card img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 20px;
        }

        .student-card .details {
            flex: 1;
        }

        .student-card h5 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .student-card p {
            margin: 5px 0;
            color: #555;
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
                        <h3 class="page-title">Search Students</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Search Students</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="form-container">
                        <div class="form-wrapper">
                            <h4 class="form-title">Search Students</h4>
                            <?php if ($msg): ?>
                                <p style='color: green;'><?php echo htmlentities($msg); ?></p>
                            <?php endif; ?>
                            <?php if ($error): ?>
                                <p style='color: red;'><?php echo htmlentities($error); ?></p>
                            <?php endif; ?>
                            <form class="forms-sample" method="post">
                                <div class="search-bar">
                                    <select name="searchBy" class="form-control" required>
                                        <option value="">Select Search Criterion</option>
                                        <option value="name">Student Name</option>
                                        <option value="class">Class</option>
                                        <option value="contact">Contact Number</option>
                                    </select>
                                    <input type="text" name="searchTerm" class="form-control" placeholder="Enter search term" required>
                                    <button type="submit" class="btn btn-primary" name="search">Search</button>
                                </div>
                            </form>

                            <div class="search-results">
                                <?php if (isset($students) && count($students) > 0): ?>
                                    <?php foreach ($students as $student): ?>
                                        <div class="student-card">
                                            <?php if (!empty($student->Image)): ?>
                                                <img src="<?php echo htmlentities($student->Image); ?>" alt="Student Image">
                                            <?php endif; ?>
                                            <div class="details">
                                                <h5><?php echo htmlentities($student->StudentName); ?></h5>
                                                <p>Class: <?php echo htmlentities($student->StudentClass); ?></p>
                                                <p>Contact: <?php echo htmlentities($student->ContactNumber); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No students found.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>
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
</body>
</html>
