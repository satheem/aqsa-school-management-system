<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
    exit;
}

if (isset($_POST['update'])) {
    $adminid = $_SESSION['sturecmsaid'];
    $AName = $_POST['adminname'];
    $mobno = $_POST['mobilenumber'];
    $email = $_POST['email'];

    $sql = "UPDATE tbladmin SET AdminName = :adminname, MobileNumber = :mobilenumber, Email = :email WHERE ID = :aid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':adminname', $AName, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobilenumber', $mobno, PDO::PARAM_STR);
    $query->bindParam(':aid', $adminid, PDO::PARAM_STR);
    $query->execute();

    echo '<script>alert("Your profile has been updated")</script>';
    echo "<script>window.location.href ='profile.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
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

        .btn-primary {
            display: block;
            width: 100%;
            background-color: #28a745; /* Green background */
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
            background-color: #218838; /* Darker green on hover */
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
                        <h3 class="page-title">Admin Profile</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Admin Profile</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="form-container">
                        <div class="form-wrapper">
                            <h4 class="form-title">Update Admin Profile</h4>
                            <form method="post" action="">
                                <?php
                                $sql = "SELECT * FROM tbladmin WHERE ID = :aid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':aid', $_SESSION['sturecmsaid'], PDO::PARAM_STR);
                                $query->execute();
                                $result = $query->fetch(PDO::FETCH_OBJ);
                                if ($result) {
                                ?>
                                    <div class="form-group">
                                        <label for="adminname">Admin Name</label>
                                        <input type="text" class="form-control" id="adminname" name="adminname" value="<?php echo $result->AdminName; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">User Name</label>
                                        <input type="text" class="form-control" id="username" value="<?php echo $result->UserName; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobilenumber">Contact Number</label>
                                        <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" value="<?php echo $result->MobileNumber; ?>" required maxlength="10" pattern="[0-9]+">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $result->Email; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="regdate">Admin Registration Date</label>
                                        <input type="text" class="form-control" id="regdate" value="<?php echo $result->AdminRegdate; ?>" readonly>
                                    </div>
                                <?php } ?>
                                <button type="submit" class="btn-primary" name="update">Update Profile</button>
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
