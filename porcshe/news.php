<?php
// Include database connection
include '../db_connection.php';
$conn=get_db_connection();

// Query to get news from the database
$sql = "SELECT n.header, n.article, n.date, ni.news_image FROM news n
        LEFT JOIN news_image ni ON n.news_image_id = ni.id
        ORDER BY n.date DESC"; // Order by date, newest first
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porsche News</title>
    <link rel="stylesheet" href="news.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
  integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Header Start -->
    <header>
        <div id="navbar">
            <img src="./img/Porsche-logo.png" alt="Porsche Logo">
            <nav role="navigation">
                <ul>
                <li><a href="index.php">Home</a></li>
                    <li><a href="profile.php">profile</a></li>
                    <li><a href="Category.php?user_id=<?php echo $_SESSION['user_id']; ?>">Category</a></li>
                    <li><a href="favorites.php">favorite</a></li>
                    <li><a href="news.php">News</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <header>
        <h1>Porsche News</h1>
    </header>

    <div class="container">
        <?php
        // Loop through the news results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="news-item">';
                echo '<h2>' . htmlspecialchars($row['header']) . '</h2>';
                echo '<img src="' . htmlspecialchars($row['news_image']) . '" alt="Porsche News Image" style="width:100%; border-radius: 5px;">';
                echo '<p>' . nl2br(htmlspecialchars($row['article'])) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No news available.</p>';
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Porsche News. All rights reserved.</p>
    </footer>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
