<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    // Fetch student data if editing an existing student
    if (isset($_GET['id'])) {
        $studentId = $_GET['id'];
        $sql = "SELECT * FROM tblstudent WHERE StuID = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $studentId, PDO::PARAM_STR);
        $query->execute();
        $student = $query->fetch(PDO::FETCH_OBJ);

        if (!$student) {
            $error = "Student not found.";
        }
    } else {
        $error = "No student ID provided.";
    }

    if (isset($_POST['submit'])) {
        // Handle image upload
        $image = $_FILES["image"]["name"];
        if (empty($image)) {
            $image = $student->Image; // Keep existing image if no new file is uploaded
        } else {
            $extension = substr($image, strlen($image) - 4, strlen($image));
            $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");
            if (!in_array($extension, $allowed_extensions)) {
                $error = "Image has an invalid format. Only jpg/jpeg/png/gif formats are allowed";
            } else {
                $image = md5($image) . time() . $extension;
                move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $image);
            }
        }

        if (!isset($error)) {
            $sql = "UPDATE tblstudent SET StudentName = :stuname, StudentEmail = :stuemail, StudentClass = :stuclass, Gender = :gender, DOB = :dob, FatherName = :fname, MotherName = :mname, ContactNumber = :connum, AltenateNumber = :altconnum, Address = :address, UserName = :uname, Whatsapp = :whatsapp, Sheets = :sheets, Image = :image WHERE StuID = :stuid";
            $query = $dbh->prepare($sql);

            // Bind parameters
            $query->bindParam(':stuname', $_POST['stuname'], PDO::PARAM_STR);
            $query->bindParam(':stuemail', $_POST['stuemail'], PDO::PARAM_STR);
            $query->bindParam(':stuclass', $_POST['stuclass'], PDO::PARAM_STR);
            $query->bindParam(':gender', $_POST['gender'], PDO::PARAM_STR);
            $query->bindParam(':dob', $_POST['dob'], PDO::PARAM_STR);
            $query->bindParam(':fname', $_POST['fname'], PDO::PARAM_STR);
            $query->bindParam(':mname', $_POST['mname'], PDO::PARAM_STR);
            $query->bindParam(':connum', $_POST['connum'], PDO::PARAM_STR);
            $query->bindParam(':altconnum', $_POST['altconnum'], PDO::PARAM_STR);
            $query->bindParam(':address', $_POST['address'], PDO::PARAM_STR);
            $query->bindParam(':uname', $_POST['uname'], PDO::PARAM_STR);
            $query->bindParam(':whatsapp', $_POST['whatsapp'], PDO::PARAM_STR);
            $query->bindParam(':image', $image, PDO::PARAM_STR);
            $query->bindParam(':stuid', $studentId, PDO::PARAM_STR);
            $query->bindParam(':sheets', $_POST['sheets'], PDO::PARAM_STR);
            $query->execute();

            if ($query->rowCount() > 0) {
                $msg = "Student details have been updated.";
                header("Location: manage-students.php"); // Redirect to the previous page after successful update
                exit();
            } else {
                $error = "Something went wrong. Please try again.";
                header("Location: manage-students.php");
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System || Add Students</title>
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
        <?php include_once('includes/header.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once('includes/sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Edit Student</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="form-container">
                        <div class="form-wrapper">
                            <h4 class="form-title">Edit Student</h4>
                            <?php if (isset($msg)) { echo "<p style='color: green;'>$msg</p>"; } ?>
                            <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
                            <form class="forms-sample" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="stuname">Student Name</label>
                                    <input type="text" name="stuname" id="stuname" class="form-control" required value="<?php echo htmlentities($student->StudentName); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="stuemail">Student Email</label>
                                    <input type="text" name="stuemail" id="stuemail" class="form-control" value="<?php echo htmlentities($student->StudentEmail); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="stuclass">Student Class</label>
                                    <select name="stuclass" id="stuclass" class="form-control" required>
                                        <option value="">Select Class</option>
                                        <?php
                                        $sql2 = "SELECT * FROM tblclass";
                                        $query2 = $dbh->prepare($sql2);
                                        $query2->execute();
                                        $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($result2 as $row1) {
                                            $selected = ($row1->ID == $student->StudentClass) ? "selected" : "";
                                            echo '<option value="' . htmlentities($row1->ID) . '" ' . $selected . '>' . htmlentities($row1->ClassName) . ' ' . htmlentities($row1->Section) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="">Choose Gender</option>
                                        <option value="Male" <?php echo ($student->Gender == "Male") ? "selected" : ""; ?>>Male</option>
                                        <option value="Female" <?php echo ($student->Gender == "Female") ? "selected" : ""; ?>>Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" name="dob" id="dob" class="form-control" required value="<?php echo htmlentities($student->DOB); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="stuid">Student ID</label>
                                    <input type="text" name="stuid" id="stuid" class="form-control" required value="<?php echo htmlentities($student->StuID); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="fname">Father's Name</label>
                                    <input type="text" name="fname" id="fname" class="form-control" required value="<?php echo htmlentities($student->FatherName); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="mname">Mother's Name</label>
                                    <input type="text" name="mname" id="mname" class="form-control" required value="<?php echo htmlentities($student->MotherName); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="connum">Contact Number</label>
                                    <input type="text" name="connum" id="connum" class="form-control" required value="<?php echo htmlentities($student->ContactNumber); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="altconnum">Alternate Contact Number</label>
                                    <input type="text" name="altconnum" id="altconnum" class="form-control" value="<?php echo htmlentities($student->AltenateNumber); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control" rows="3" required><?php echo htmlentities($student->Address); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="whatsapp">WhatsApp Number</label>
                                    <input type="text" name="whatsapp" id="whatsapp" class="form-control" maxlength="11" pattern="[0-9]+" value="<?php echo htmlentities($student->Whatsapp); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="sheets">Google Sheet Link</label>
                                    <input type="text" name="sheets" id="sheets" class="form-control">
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="uname">Username</label>
                                    <input type="text" name="uname" id="uname" class="form-control" required value="<?php echo htmlentities($student->UserName); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="image">Student Image</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                    <?php if (!empty($student->Image)): ?>
                                        <img src="images/<?php echo htmlentities($student->Image); ?>" alt="Student Image" style="width:100px;">
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>
                            </form>
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
