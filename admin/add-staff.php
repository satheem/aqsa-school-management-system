<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staffID = $_POST['staffID'];
    $fullName = $_POST['full_name'];
    $gender = $_POST['gender'];
    $firstAppointment = $_POST['first_appointment'];
    $appointedThisSchool = $_POST['appointed_this_school'];
    $appointmentSubject = $_POST['appointment_subject'];
    $eduQualify = $_POST['edu_qualify'];
    $profQualify = $_POST['prof_qualify'];
    $serviceGrade = $_POST['service_grade'];
    $email = $_POST['email'];

    // Default photo
    $photo = 'staff.jpg'; // Set default image

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileSize = $_FILES['photo']['size'];
        $fileType = $_FILES['photo']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Check if the file has a valid extension
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileExtension, $allowedExtensions)) {
            // Define a new name for the file and move it to the upload directory
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = './uploads/';
            $destPath = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $photo = $newFileName; // Update photo if upload is successful
            } else {
                echo "<script>alert('Error uploading photo.');</script>";
            }
        } else {
            echo "<script>alert('Invalid photo file type.');</script>";
        }
    }

    // Prepare and execute the SQL query to insert staff into the database
    $sql = "INSERT INTO tblstaff (StaffID, full_name, gender, first_appointment, appointed_this_school, appointment_subject, edu_qualify, prof_qualify, service_grade, email, photo) 
            VALUES (:staffID, :full_name, :gender, :first_appointment, :appointed_this_school, :appointment_subject, :edu_qualify, :prof_qualify, :service_grade, :email, :photo)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':staffID', $staffID, PDO::PARAM_STR);
    $query->bindParam(':full_name', $fullName, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':first_appointment', $firstAppointment, PDO::PARAM_STR);
    $query->bindParam(':appointed_this_school', $appointedThisSchool, PDO::PARAM_STR);
    $query->bindParam(':appointment_subject', $appointmentSubject, PDO::PARAM_STR);
    $query->bindParam(':edu_qualify', $eduQualify, PDO::PARAM_STR);
    $query->bindParam(':prof_qualify', $profQualify, PDO::PARAM_STR);
    $query->bindParam(':service_grade', $serviceGrade, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':photo', $photo, PDO::PARAM_STR);

    if ($query->execute()) {
        echo "<script>alert('Staff added successfully.');</script>";
        echo "<script>window.location.href ='manage-staff.php';</script>";
    } else {
        echo "<script>alert('Error adding staff.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css">
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

        .form-group select, 
        .form-group textarea,
        .form-group input[type="text"], 
        .form-group input[type="file"] {
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
        <?php include_once('includes/header.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once('includes/sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Add Staff</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Staff</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="form-container">
                        <div class="form-wrapper">
                            <h4 class="form-title">Add Non-Academic Staff</h4>
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="staffID">Staff ID</label>
                                    <input type="text" class="form-control" id="staffID" name="staffID" required>
                                </div>
                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="first_appointment">First Appointment</label>
                                    <input type="date" class="form-control" id="first_appointment" name="first_appointment" required>
                                </div>
                                <div class="form-group">
                                    <label for="appointed_this_school">Appointed This School</label>
                                    <input type="date" class="form-control" id="appointed_this_school" name="appointed_this_school" required>
                                </div>
                                <div class="form-group">
                                    <label for="appointment_subject">Appointment Subject</label>
                                    <input type="text" class="form-control" id="appointment_subject" name="appointment_subject" required>
                                </div>
                                <div class="form-group">
                                    <label for="edu_qualify">Educational Qualification</label>
                                    <input type="text" class="form-control" id="edu_qualify" name="edu_qualify" required>
                                </div>
                                <div class="form-group">
                                    <label for="prof_qualify">Professional Qualification</label>
                                    <input type="text" class="form-control" id="prof_qualify" name="prof_qualify" required>
                                </div>
                                <div class="form-group">
                                    <label for="service_grade">Service Grade</label>
                                    <input type="text" class="form-control" id="service_grade" name="service_grade" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" >
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input type="file" class="form-control" id="photo" name="photo">
                                </div>
                                <button type="submit" class="btn-primary">Add Staff</button>
                            </form>
                        </div>
                    </div>
                    <?php include_once('includes/footer.php'); ?>
                </div>
            </div>
        </div>
    </div>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
</body>
</html>
