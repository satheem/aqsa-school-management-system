<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if a file was uploaded without errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Define allowed file extensions
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

        // Check if the file extension is allowed
        if (in_array($fileExtension, $allowedExtensions)) {
            // Create a new filename to avoid conflicts
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // Specify the directory where files should be uploaded
            $uploadFileDir = './uploads/banner/';
            $destPath = $uploadFileDir . $newFileName;

            // Move the uploaded file to the destination directory
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Prepare the image path to include the folder
                $imagePath = 'admin/uploads/banner/' . $newFileName;

                // Insert the image path into the database
                $sql = "INSERT INTO images (image_path) VALUES (:image_path)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':image_path', $imagePath, PDO::PARAM_STR); // Use $imagePath here

                if ($query->execute()) {
                    echo "<script>
                            alert('Image uploaded successfully.');
                            window.location.href='manage-banner.php';
                          </script>";
                } else {
                    echo "<script>alert('Error saving image to database.');</script>";
                }
            } else {
                echo "<script>alert('Error moving the uploaded file.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.');</script>";
        }
    } else {
        echo "<script>alert('No file uploaded or file upload error.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <!-- CSS links -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/style.css">
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
            margin-bottom: 20px;
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
                        <h3 class="page-title">Upload Image</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Upload Image</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="form-container">
                        <div class="form-wrapper">
                            <h4 class="form-title">Upload Image</h4>
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="image">Select Image</label>
                                    <input type="file" class="form-control" id="image" name="image" required>
                                </div>
                                <button type="submit" class="btn-primary">Upload Image</button>
                            </form>
                        </div>
                    </div>
                    <?php include_once('includes/footer.php'); ?>
                </div>
            </div>
        </div>
    </div>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
</body>
</html>
