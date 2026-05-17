<?php
include '../db_connection.php';

// Function to upload an image and return the filename
function upload_image($input_name) {
    $filename = $_FILES[$input_name]["name"];
    $tempname = $_FILES[$input_name]["tmp_name"];
    $folder = "./images/" . $filename;

    // Move the uploaded image to the "image" folder
    if (move_uploaded_file($tempname, $folder)) {
        return $filename; // Return the filename for database storage
    } else {
        echo "<h3>&nbsp; Failed to upload image!</h3>";
        return null; // Return null if the upload fails
    }
}

// Function to edit a record in the `technology` table
function technology_edit($id) {
    $connection = get_db_connection();

    // Retrieve the current data for the technology with the given ID
    $query = "SELECT * FROM `technology` WHERE `id` = '$id'";
    $result = mysqli_query($connection, $query);
    $technology = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
        // Get form data
        $technology_type = mysqli_real_escape_string($connection, $_POST['technology_type']);
        $price = mysqli_real_escape_string($connection, $_POST['price']);
        $uploaded_image = null;

        // Check if image is uploaded
        if ($_FILES['uploadfile']['name'] != '') {
            $uploaded_image = upload_image('uploadfile');
        } else {
            // If no new image is uploaded, keep the existing one
            $uploaded_image = $technology['technology_image'];
        }

        // Update the image in the `technology_image` table if a new image is uploaded
        if ($uploaded_image != $technology['technology_image']) {
            $image_query = "UPDATE `technology_image` SET `technology_image` = '$uploaded_image' WHERE `id` = '{$technology['technology_image_id']}'";
            if (!mysqli_query($connection, $image_query)) {
                echo "Error updating image: " . mysqli_error($connection);
            }
        }

        // Update the `technology` table
        $tech_query = "UPDATE `technology` SET `technology_type` = '$technology_type', `price` = '$price', `technology_image_id` = (SELECT id FROM `technology_image` WHERE `technology_image` = '$uploaded_image' LIMIT 1) WHERE `id` = '$id'";
        if (mysqli_query($connection, $tech_query)) {
            echo "<h3>&nbsp; Technology record updated successfully!</h3>";
        } else {
            echo "Error updating technology: " . mysqli_error($connection);
        }

        close_db_connection($connection);
    }

    // Display the form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Technology</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="formstyle.css">
    </head>
    <body>
        <div class="container">
            <main class="content">
                <h1>Edit Technology</h1>
                <form action="edit.php?table=technology&id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="technology_type">Technology Type</label>
                        <input type="text" name="technology_type" id="technology_type" class="form-control" value="<?php echo $technology['technology_type']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" value="<?php echo $technology['price']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="uploadfile">Upload New Image (Leave blank to keep existing)</label>
                        <input type="file" name="uploadfile" id="uploadfile" class="form-control">
                    </div>
                    <button type="submit" name="upload" class="btn-submit">Update Technology</button>
                </form>
            </main>
        </div>
    </body>
    </html>
    <?php
}

// Function to edit a record in the `car_model` table
function car_model_edit($id) {
    $connection = get_db_connection();

    // Retrieve the current data for the car model with the given ID
    $query = "SELECT * FROM `car_model` WHERE `id` = '$id'";
    $result = mysqli_query($connection, $query);
    $car_model = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
        // Get form data
        $car_name = mysqli_real_escape_string($connection, $_POST['car_name']);
        $top_speed = mysqli_real_escape_string($connection, $_POST['top_speed']);
        $acceleration = mysqli_real_escape_string($connection, $_POST['acceleration']);
        $price = mysqli_real_escape_string($connection, $_POST['price']);
        $in_stock = mysqli_real_escape_string($connection, $_POST['in_stock']);
        $model_id = mysqli_real_escape_string($connection, $_POST['models_car_model_id']);
        $uploaded_image = null;

        // Check if image is uploaded
        if ($_FILES['uploadfile']['name'] != '') {
            $uploaded_image = upload_image('uploadfile');
        } else {
            // If no new image is uploaded, keep the existing one
            $uploaded_image = $car_model['car_model_image'];
        }

        // Update the image in the `car_model_image` table if a new image is uploaded
        if ($uploaded_image != $car_model['car_model_image']) {
            $image_query = "UPDATE `car_model_image` SET `car_model_image` = '$uploaded_image' WHERE `id` = '{$car_model['car_model_images_id']}'";
            if (!mysqli_query($connection, $image_query)) {
                echo "Error updating image: " . mysqli_error($connection);
            }
        }

        // Update the `car_model` table
        $model_query = "UPDATE `car_model` SET `car_name` = '$car_name', `topspeed` = $top_speed, `accelaration` = $acceleration, `price` = $price, `in_stock` = $in_stock, `models_car_model_id` = $model_id, `car_model_images_id` = (SELECT id FROM `car_model_image` WHERE `car_model_image` = '$uploaded_image' LIMIT 1) WHERE `id` = '$id'";
        if (mysqli_query($connection, $model_query)) {
            echo "<h3>&nbsp; Car model record updated successfully!</h3>";
        } else {
            echo "Error updating car model: " . mysqli_error($connection);
        }

        close_db_connection($connection);
    }

    // Display the form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Car Model</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="formstyle.css">
    </head>
    <body>
        <div class="container">
            <main class="content">
                <h1>Edit Car Model</h1>
                <form action="edit.php?table=car_model&id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="car_name">Car Name</label>
                        <input type="text" name="car_name" id="car_name" class="form-control" value="<?php echo $car_model['car_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="top_speed">Top Speed</label>
                        <input type="number" name="top_speed" id="top_speed" class="form-control" value="<?php echo $car_model['topspeed']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="acceleration">Acceleration</label>
                        <input type="number" name="acceleration" id="acceleration" class="form-control" value="<?php echo $car_model['accelaration']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" value="<?php echo $car_model['price']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="in_stock">In Stock</label>
                        <input type="number" name="in_stock" id="in_stock" class="form-control" value="<?php echo $car_model['in_stock']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="models_car_model_id">Model ID</label>
                        <input type="number" name="models_car_model_id" id="models_car_model_id" class="form-control" value="<?php echo $car_model['models_car_model_id']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="uploadfile">Upload New Image (Leave blank to keep existing)</label>
                        <input type="file" name="uploadfile" id="uploadfile" class="form-control">
                    </div>
                    <button type="submit" name="upload" class="btn-submit">Update Car Model</button>
                </form>
            </main>
        </div>
    </body>
    </html>
    <?php
}

// Main logic for choosing which edit function to run based on the table
if (isset($_GET['table'])) {
    $table = $_GET['table'];
    $id = $_GET['id'];

    if ($table == 'technology') {
        technology_edit($id);
    } elseif ($table == 'car_model') {
        car_model_edit($id);
    }
    // Add other cases for other tables (color, models, etc.)
} else {
    echo "<h3>&nbsp; No table selected!</h3>";
}
?>
