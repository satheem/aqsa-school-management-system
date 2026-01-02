<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
    exit;
}

// Fetch the news item based on the id from the URL
$newsId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($newsId > 0) {
    // Prepare and execute the SQL query to get news details
    $sql = "SELECT Title, Content, Image, dateposted FROM tblnews WHERE ID = :newsId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':newsId', $newsId, PDO::PARAM_INT);
    $query->execute();
    $news = $query->fetch(PDO::FETCH_OBJ);

    if (!$news) {
        // If no news item is found, redirect or show an error message
        echo "<script>alert('News not found.');</script>";
        echo "<script>window.location.href = 'manage-news.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid news ID.');</script>";
    echo "<script>window.location.href = 'manage-news.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View News</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Custom styles -->
    <style>
        .news-detail-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
        }

        .news-image {
            width: 100%;
            max-width: 600px; /* Adjusted max width for a smaller image */
            height: auto; /* Maintain aspect ratio */
            border-bottom: 1px solid #ddd;
            border-radius: 20px;
        }

        .news-content {
            padding: 20px;
            max-width: 600px; /* Ensure content width matches image width */
            width: 100%;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .news-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .news-date {
            font-size: 16px;
            color: #999;
            margin-bottom: 20px;
        }

        .news-content-text {
            font-size: 16px;
            color: #333;
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
                        <h3 class="page-title">View News</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="manage-news.php">Manage News</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View News</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="news-detail-container">
                        <?php if ($news->Image): ?>
                            <img src="uploads/<?php echo htmlentities($news->Image); ?>" alt="News Image" class="news-image">
                        <?php else: ?>
                            <img src="images/no-image.png" alt="No Image" class="news-image">
                        <?php endif; ?>
                        <div class="news-content">
                            <h1 class="news-title"><?php echo htmlentities($news->Title); ?></h1>
                            <p class="news-date"><?php echo htmlentities($news->dateposted); ?></p>
                            <p class="news-content-text"><?php echo nl2br(htmlentities($news->Content)); ?></p>
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
</body>
</html>
