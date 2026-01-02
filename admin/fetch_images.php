    <?php
    // fetch_news.php
    header('Content-Type: application/json');

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "studentmsdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT image_path FROM images";
    $result = $conn->query($sql);

    $imagePaths = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $imagePaths[] = $row['image_path'];
        }
    }

    echo json_encode($imagePaths);

    $conn->close();
    ?>
