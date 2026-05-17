<?php
session_start();
require "../db_connection.php";
$target_dir = "../porcshe/images";


function upload_image($input_name) {
    $filename = $_FILES[$input_name]["name"];
    $tempname = $_FILES[$input_name]["tmp_name"];
    $target_dir = "../porcshe/images" . $filename;

    if(move_uploaded_file($tempname, $target_dir)) {
        return $filename;
    } else {
         echo "<h3> Failed to upload Image! </h3>";
         return null;
    }
} 

if(isset($_POST['post-title'], $_POST['upload'])) {
    $title = $_POST['post-title'];
    $desc = $_POST['desc'];
    $uploaded_image = upload_image('img');
    $conn = get_db_connection();
    $news_img_stmt = "INSERT INTO news_image  (news_image) VALUES ('../porcshe/images/.$uploaded_image')";
    
    if (!mysqli_query($conn, $news_img_stmt)) {
        echo "Error inserting image: " . mysqli_error($connection);
        close_db_connection($connection);
        return;
    }
    $news_stmt = "INSERT INTO news (header, article, date, news_image_id) VALUES ('$title', '$desc',now(), LAST_INSERT_ID())";
    if (mysqli_query($conn, $news_stmt)) {
        echo "<h1> FORM UPDATED SUCCESSFULLY</h1>";
        header('Location: ../porcshe/news.php');
    }
}
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add News</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="formstyle.css">
    </head>
    <body>
        <div class="container">
            <main class="content">
                <h1>Add  News</h1>
                <form action="add_news.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="post-title">Title:</label>
                        <input type="text" name="post-title" id="post-title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="desc">Article:</label>
                        <textarea name="desc" id="desc" rows="5" cols="40" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="img">image upload</label>
                        <input type="file" name="img" id="img" accept="image/*" class="form-control" required>
                    </div>
                    <button type="submit" name="upload" class="btn-submit">Publish</button>
                </form>

            </main>
        </div>
    </body>
</html>

