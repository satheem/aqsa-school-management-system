<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
    exit;
}

// Handle news deletion
if (isset($_GET['delid'])) {
    $newsId = $_GET['delid'];
    
    // Retrieve the image name to delete it from the server
    $sql = "SELECT Image FROM tblnews WHERE ID = :newsId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':newsId', $newsId, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    
    if ($result && $result->Image) {
        $imagePath = "./uploads/" . $result->Image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Delete the news item from the database
    $sql = "DELETE FROM tblnews WHERE ID = :newsId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':newsId', $newsId, PDO::PARAM_INT);
    
    if ($query->execute()) {
        echo "<script>alert('News deleted successfully.');</script>";
        echo "<script>window.location.href ='manage-news.php';</script>";
    } else {
        echo "<script>alert('Error deleting news.');</script>";
    }
}

// Fetch news items
$sql = "SELECT ID, Title, Content, Image, dateposted FROM tblnews ORDER BY ID DESC";
$query = $dbh->prepare($sql);
$query->execute();
$newsItems = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage News</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Custom styles -->
    <style>
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .news-widget {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
            position: relative;
            cursor: pointer;
        }

        .news-widget:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .news-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .news-content {
            padding: 15px;
        }

        .news-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .news-snippet {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        .news-date {
            font-size: 12px;
            color: #999;
            margin-bottom: 15px;
        }

        .news-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .news-actions a {
            color: #007bff; /* Default link color */
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }
        .news-widget a:hover{
            text-decoration:none;
        }
        .news-actions a:hover {
            background-color: #f0f0f0;
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
                        <h3 class="page-title">Manage News</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage News</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="news-grid">
                        <?php
                        if ($query->rowCount() > 0) {
                            foreach ($newsItems as $news) {
                                ?>
                                <div class="news-widget">
                                    <a href="view-news.php?id=<?php echo $news->ID; ?>" class="news-link" style="display: block;">
                                        <?php if ($news->Image): ?>
                                            <img src="uploads/<?php echo htmlentities($news->Image); ?>" alt="News Image" class="news-image">
                                        <?php else: ?>
                                            <img src="images/no-image.png" alt="No Image" class="news-image">
                                        <?php endif; ?>
                                        <div class="news-content">
                                            <h4 class="news-title"><?php echo htmlentities($news->Title); ?></h4>
                                            <p class="news-snippet"><?php echo htmlentities(substr($news->Content, 0, 100)) . '...'; ?></p>
                                            <p class="news-date"><?php echo htmlentities($news->dateposted ?? 'Date not available'); ?></p>
                                        </div>
                                    </a>
                                    <div class="news-actions">
                                        <a href="edit-news.php?id=<?php echo $news->ID; ?>" class="btn-edit">
                                            <i class="icon-pencil"></i>
                                        </a>
                                        <a href="manage-news.php?delid=<?php echo $news->ID; ?>" onclick="return confirm('Do you really want to delete this news?');" class="btn-delete">
                                            <i class="icon-trash"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php }
                        } else { ?>
                            <p>No news found</p>
                        <?php } ?>
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
