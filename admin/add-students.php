<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $stuname = $_POST['stuname'];
        $stuemail = $_POST['stuemail'];
        $stuclass = $_POST['stuclass'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $stuid = $_POST['stuid'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $connum = $_POST['connum'];
        $altconnum = $_POST['altconnum'];
        $address = $_POST['address'];
        $uname = $_POST['uname'];
        $password = md5($_POST['password']);
        $whatsapp = $_POST['whatsapp'];
        $sheets = $_POST['sheets'];
        
        // Handle Image Upload
        $image = $_FILES["image"]["name"];
        if (empty($image)) {
            $image = 'student.png'; // Default image if no file is uploaded
        } else {
            $extension = substr($image, strlen($image) - 4, strlen($image));
            $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");
            if (!in_array($extension, $allowed_extensions)) {
                $error = "Image has an invalid format. Only jpg/jpeg/png/gif format allowed";
            } else {
                $image = md5($image) . time() . $extension;
                move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $image);
            }
        }

        if (!isset($error)) {
            $ret = "SELECT UserName FROM tblstudent WHERE UserName = :uname OR StuID = :stuid";
            $query = $dbh->prepare($ret);
            $query->bindParam(':uname', $uname, PDO::PARAM_STR);
            $query->bindParam(':stuid', $stuid, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() == 0) {
                $sql = "INSERT INTO tblstudent (StudentName, StudentEmail, StudentClass, Gender, DOB, StuID, FatherName, MotherName, ContactNumber, AltenateNumber, Address, UserName, Password, Whatsapp, Image, sheets) VALUES (:stuname, :stuemail, :stuclass, :gender, :dob, :stuid, :fname, :mname, :connum, :altconnum, :address, :uname, :password, :whatsapp, :image, :sheets)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':stuname', $stuname, PDO::PARAM_STR);
                $query->bindParam(':stuemail', $stuemail, PDO::PARAM_STR);
                $query->bindParam(':stuclass', $stuclass, PDO::PARAM_STR);
                $query->bindParam(':gender', $gender, PDO::PARAM_STR);
                $query->bindParam(':dob', $dob, PDO::PARAM_STR);
                $query->bindParam(':stuid', $stuid, PDO::PARAM_STR);
                $query->bindParam(':fname', $fname, PDO::PARAM_STR);
                $query->bindParam(':mname', $mname, PDO::PARAM_STR);
                $query->bindParam(':connum', $connum, PDO::PARAM_STR);
                $query->bindParam(':altconnum', $altconnum, PDO::PARAM_STR);
                $query->bindParam(':address', $address, PDO::PARAM_STR);
                $query->bindParam(':uname', $uname, PDO::PARAM_STR);
                $query->bindParam(':password', $password, PDO::PARAM_STR);
                $query->bindParam(':whatsapp', $whatsapp, PDO::PARAM_STR);
                $query->bindParam(':image', $image, PDO::PARAM_STR);
                $query->bindParam(':sheets', $sheets, PDO::PARAM_STR);
                $query->execute();
                $LastInsertId = $dbh->lastInsertId();
                if ($LastInsertId > 0) {
                    $msg = "Student has been added.";
                } else {
                    $error = "Something went wrong. Please try again.";
                }
            } else {
                $error = "Username or Student ID already exists. Please try again.";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
                        <h3 class="page-title">Add Students</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Students</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="form-container">
                        <div class="form-wrapper">
                            <h4 class="form-title">Add Students</h4>
                            <?php if (isset($msg)) { echo "<p style='color: green;'>$msg</p>"; } ?>
                            <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
                            <form class="forms-sample" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="stuname">Student Name</label>
                                    <input type="text" name="stuname" id="stuname" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="stuemail">Student Email</label>
                                    <input type="text" name="stuemail" id="stuemail" class="form-control">
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
                                            echo '<option value="' . htmlentities($row1->ID) . '">' . htmlentities($row1->ClassName) . ' ' . htmlentities($row1->Section) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="">Choose Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" name="dob" id="dob" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="stuid">Student ID</label>
                                    <input type="text" name="stuid" id="stuid" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="fname">Father's Name</label>
                                    <input type="text" name="fname" id="fname" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="mname">Mother's Name</label>
                                    <input type="text" name="mname" id="mname" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="connum">Contact Number</label>
                                    <input type="text" name="connum" id="connum" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="altconnum">Alternate Contact Number</label>
                                    <input type="text" name="altconnum" id="altconnum" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="whatsapp">WhatsApp Number</label>
                                    <input type="text" name="whatsapp" id="whatsapp" class="form-control" maxlength="11" pattern="[0-9]+">
                                </div>
                                <div class="form-group">
                                    <label for="sheets">Google Sheet Link</label>
                                    <input type="text" name="sheets" id="sheets" class="form-control">
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="uname">Username</label>
                                    <input type="text" name="uname" id="uname" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="image">Profile Image</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Add Student</button>
                            </form>
                        </div><script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
                    </div>
                </div>
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php } ?>
