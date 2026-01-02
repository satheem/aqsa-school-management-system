<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if user is logged in
if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
    exit;
}

// Get the Student ID from the URL parameter
$viewID = isset($_GET['viewid']) ? $_GET['viewid'] : '';

// Retrieve student data based on Student ID
$sql = "SELECT tblstudent.*, tblclass.ClassName, tblclass.Section FROM tblstudent 
        JOIN tblclass ON tblstudent.StudentClass = tblclass.ID 
        WHERE tblstudent.StuID = :viewID";
$query = $dbh->prepare($sql);
$query->bindParam(':viewID', $viewID, PDO::PARAM_STR);
$query->execute();
$student = $query->fetch(PDO::FETCH_OBJ);

if (!$student) {
    echo '<script>alert("Student not found.")</script>';
    echo "<script>window.location.href ='view-students.php'</script>";
    exit;
}

// Excel file URL from the database
$excelLink = $student->Sheets;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System || View Student</title>
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
        .view-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }

        .view-wrapper {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 800px;
        }

        .view-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .student-details img {
            display: block;
            margin: 0 auto 30px auto;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            text-align: center;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
        }

        .student-details h4 {
            margin: 10px 0;
            font-size: 20px;
            color: #333;
        }

        .student-details p {
            margin: 15px 0;
            font-size: 16px;
            color: #666;
        }

        .excel-container {
            margin-top: 30px;
            width: 100%;
            height: 600px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .embed-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .embed-link a {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #17a2b8;
            border-radius: 5px;
            text-decoration: none;
        }

        .embed-link a:hover {
            background-color: #138496;
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
                                <li class="breadcrumb-item"><a href="manage-students.php">Manage Students</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Student</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="view-container">
                        <div class="view-wrapper">
                            <h4 class="view-title">Student Details</h4>
                            <div class="student-details">
                                <img src="images/<?php echo htmlentities($student->Image); ?>" alt="Student Photo">
                                <h4><?php echo htmlentities($student->StudentName); ?></h4>
                                <p><strong>Student ID:</strong> <?php echo htmlentities($student->StuID); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlentities($student->StudentEmail); ?></p>
                                <p><strong>Class & Section:</strong> <?php echo htmlentities($student->ClassName . ' - ' . $student->Section); ?></p>
                                <p><strong>Gender:</strong> <?php echo htmlentities($student->Gender); ?></p>
                                <p><strong>Date of Birth:</strong> <?php echo htmlentities($student->DOB); ?></p>
                                <p><strong>Father's Name:</strong> <?php echo htmlentities($student->FatherName); ?></p>
                                <p><strong>Mother's Name:</strong> <?php echo htmlentities($student->MotherName); ?></p>
                                <p><strong>Contact Number:</strong> <?php echo htmlentities($student->ContactNumber); ?></p>
                                <p><strong>Alternate Contact Number:</strong> <?php echo htmlentities($student->AltenateNumber); ?></p>
                                <p><strong>Address:</strong> <?php echo htmlentities($student->Address); ?></p>
                            </div>

                            <!-- Embed Excel File -->
                            <div class="excel-container">
                                <?php if ($excelLink): ?>
                                    <iframe src="<?php echo htmlentities($excelLink); ?>/preview" width="100%" height="100%" frameborder="0">This is an embedded document.</iframe>
                                <?php else: ?>
                                    <p>No Excel file available to display.</p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Embed Link Button -->
                            <div class="embed-link">
                                <?php if ($excelLink): ?>
                                    <a href="<?php echo htmlentities($excelLink); ?>" target="_blank">Open Excel File</a>
                                <?php else: ?>
                                    <p>No Excel file link available.</p>
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
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js -->
</body>
</html>
