<?php
session_start();
include('includes/dbconnection.php');

// Check if user is logged in
if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
    exit;
}

// Handle image deletion from the database
if (isset($_GET['delete'])) {
    $imageId = intval($_GET['delete']);
    
    // Delete the record from the database
    $sql = "DELETE FROM images WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $imageId, PDO::PARAM_INT);
    if ($query->execute()) {
        echo "<script>alert('Image deleted successfully.'); window.location.href='manage-banner.php';</script>";
    } else {
        echo "<script>alert('Error deleting the image record.'); window.location.href='manage-banner.php';</script>";
    }
}

// Fetch all images from the database
$sql = "SELECT * FROM images";
$query = $dbh->prepare($sql);
$query->execute();
$images = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Banner Images</title>
    <!-- CSS links -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/style.css">
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
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
            margin-bottom: 15px;
        }

        .widget-card h5 {
            margin: 0;
            font-size: 18px;
            color: gray;
        }

        .widget-card .actions {
            margin-top: 10px; /* Space between details and actions */
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

        /* Add New Image Button */
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
            margin-top: 80px;
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
                        <h3 class="page-title">Manage Banner Images</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage Banner Images</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="widget-container">
                                        <!-- Add Image Widget -->
                                        <div class="widget-add" onclick="window.location.href='add-news-banner.php';">
                                            <i class="fas fa-plus-circle"></i>
                                            <h5>Add Image</h5>
                                        </div>

                                        <!-- Display Images -->
                                        <?php if (empty($images)): ?>
                                            <p>No images found.</p>
                                        <?php else: ?>
                                            <?php foreach ($images as $image): ?>
                                                <div class="widget-card">
                                                    <img src="uploads/banner/<?php echo htmlspecialchars(basename($image['image_path'])); ?>" alt="Image">
                                                    <div class="actions">
                                                        <a href="?delete=<?php echo htmlspecialchars($image['id']); ?>" onclick="return confirm('Are you sure you want to delete this image record?');"><i class="fas fa-trash"></i></a>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once('includes/footer.php'); ?>
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
