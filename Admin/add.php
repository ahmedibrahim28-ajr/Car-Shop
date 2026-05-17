<?php
include '../db_connection.php';

// Function to upload an image and return the filename
function upload_image($input_name) {
    $filename = $_FILES[$input_name]["name"];
    $tempname = $_FILES[$input_name]["tmp_name"];
    $folder = "../porcshe/images" . $filename;

    // Move the uploaded image to the "image" folder
    if (move_uploaded_file($tempname, $folder)) {
        return $filename; // Return the filename for database storage
    } else {
        echo "<h3>&nbsp; Failed to upload image!</h3>";
        return null; // Return null if the upload fails
    }
}

// Function to add a new record to the `technology` table
function technology_add() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
        $connection = get_db_connection();
        $uploaded_image = upload_image('uploadfile');
        if (!$uploaded_image) {
            return; 
        }

        $technology_type = mysqli_real_escape_string($connection, $_POST['technology_type']);
        $price = mysqli_real_escape_string($connection, $_POST['price']);

        // Step 1: Insert into `technology_image`
        $image_query = "INSERT INTO `technology_image` (technology_image) VALUES ('./images/$uploaded_image')";
        if (!mysqli_query($connection, $image_query)) {
            echo "Error inserting image: " . mysqli_error($connection);
            close_db_connection($connection);
            return;
        }

        // Step 2: Insert into `technology` with the foreign key reference
        $tech_query = "INSERT INTO `technology` (technology_type, price, technology_image_id) 
                       VALUES ('$technology_type', '$price', LAST_INSERT_ID())";
        if (mysqli_query($connection, $tech_query)) {
            echo "<script>
                    alert('Data deleted successfully!');
                    window.location.href ='edit_table.php?table=technology'
                    setTimeout(function() {
                        location.reload();  // Refresh the page after going back
                    }, 100);
                  </script>";
        } else {
            echo "Error inserting technology: " . mysqli_error($connection);
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
        <title>Add New Technology</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="formstyle.css">
    </head>
    <body>
        <div class="container">
            <main class="content">
                <h1>Add New Technology</h1>
                <form action="add.php?table=technology" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="technology_type">Technology Type</label>
                        <input type="text" name="technology_type" id="technology_type" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="uploadfile">Upload Image</label>
                        <input type="file" name="uploadfile" id="uploadfile" class="form-control" required>
                    </div>
                    <button type="submit" name="upload" class="btn-submit">Add Technology</button>
                </form>
            </main>
        </div>
    </body>
    </html>
    <?php
}

// Function to add a new record to another table, e.g., `car_model`
function car_model_add() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
        $connection = get_db_connection();

        // Get the form data
        $car_name = mysqli_real_escape_string($connection, $_POST['car_name']);
        $top_speed = mysqli_real_escape_string($connection, $_POST['top_speed']);
        $acceleration = mysqli_real_escape_string($connection, $_POST['acceleration']);
        $price = mysqli_real_escape_string($connection, $_POST['price']);
        $in_stock = mysqli_real_escape_string($connection, $_POST['in_stock']);
        $model_id = mysqli_real_escape_string($connection, $_POST['models_car_model_id']);

        // Upload the image
        $uploaded_image = upload_image('uploadfile');
        if (!$uploaded_image) {
            return; // Stop processing if image upload failed
        }

        // Step 1: Insert into `car_model_image` table
        $image_query = "INSERT INTO `car_brand_shop`.`car_model_image` (`car_model_image`) 
                        VALUES ('./images/$uploaded_image')";
        if (!mysqli_query($connection, $image_query)) {
            echo "Error inserting image: " . mysqli_error($connection);
            close_db_connection($connection);
            return;
        }

        // Step 2: Insert into `car_model` table using LAST_INSERT_ID()
        $model_query = "INSERT INTO `car_brand_shop`.`car_model` 
                        (`car_name`, `topspeed`, `accelaration`, `price`, `in_stock`, `models_car_model_id`, `car_model_images_id`) 
                        VALUES ('$car_name', $top_speed, $acceleration, $price, $in_stock, $model_id, LAST_INSERT_ID())";
        if (mysqli_query($connection, $model_query)) {
            echo "<script>
                    alert('Data deleted successfully!');
                    window.location.href ='edit_table.php?table=car_model'
                    setTimeout(function() {
                        location.reload();  // Refresh the page after going back
                    }, 100);
                  </script>";
        } else {
            echo "Error inserting car model: " . mysqli_error($connection);
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
        <title>Add New Car Model</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="formstyle.css">
    </head>
    <body>
        <div class="container">
            <main class="content">
                <h1>Add New Car Model</h1>
                <form action="add.php?table=car_model" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="uploadfile">Upload Image</label>
                        <input type="file" name="uploadfile" id="uploadfile" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="car_name">Car Name</label>
                        <input type="text" name="car_name" id="car_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="top_speed">Top Speed</label>
                        <input type="number" name="top_speed" id="top_speed" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="acceleration">Acceleration</label>
                        <input type="number" name="acceleration" id="acceleration" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="in_stock">In Stock</label>
                        <input type="number" name="in_stock" id="in_stock" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="models_car_model_id">Model ID</label>
                        <input type="number" name="models_car_model_id" id="models_car_model_id" class="form-control" required>
                    </div>
                    <button type="submit" name="upload" class="btn-submit">Add Car Model</button>
                </form>
            </main>
        </div>
    </body>
    </html>
    <?php
}

function color_add() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
        $connection = get_db_connection();

        // Capture form data
        $color = mysqli_real_escape_string($connection, $_POST['color']);
        $hex_num = mysqli_real_escape_string($connection, $_POST['hex_num']);
        $price = mysqli_real_escape_string($connection, $_POST['price']);

        // Insert into the `color` table
        $query = "INSERT INTO `color` (`color`, `hex_num`, `price`) 
                  VALUES ('$color', '$hex_num', '$price')";

        if (mysqli_query($connection, $query)) {
            echo "<script>
                    alert('Data deleted successfully!');
                     window.location.href ='edit_table.php?table=color'
                    setTimeout(function() {
                        location.reload();  // Refresh the page after going back
                    }, 100);
                  </script>";
        } else {
            echo "Error adding color: " . mysqli_error($connection);
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
        <title>Add New Color</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="formstyle.css">
    </head>
    <body>
        <div class="container">
            <main class="content">
                <h1>Add New Color</h1>
                <form action="add.php?table=color" method="POST">
                    <div class="form-group">
                        <label for="color">Color Name</label>
                        <input type="text" name="color" id="color" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="hex_num">Hex Code</label>
                        <input type="text" name="hex_num" id="hex_num" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" required>
                    </div>
                    <button type="submit" name="upload" class="btn-submit">Add Color</button>
                </form>
            </main>
        </div>
    </body>
    </html>
    <?php
}

function models_add() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
        $connection = get_db_connection();

        $model_name = mysqli_real_escape_string($connection, $_POST['model_name']);
        $release_date = mysqli_real_escape_string($connection, $_POST['release_date']);

        $query = "INSERT INTO `models` (`Model`, `date_of_releace`) 
                  VALUES ('$model_name', '$release_date')";

        if (mysqli_query($connection, $query)) {
            echo "<script>
                    alert('Data deleted successfully!');
                    window.location.href ='edit_table.php?table=models'
                    setTimeout(function() {
                        location.reload();  // Refresh the page after going back
                    }, 100);
                  </script>";
        } else {
            echo "Error adding model: " . mysqli_error($connection);
        }

        close_db_connection($connection);
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add New Model</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="formstyle.css">
    </head>
    <body>
        <div class="container">
            <main class="content">
                <h1>Add New Model</h1>
                <form action="add.php?table=models" method="POST">
                    <div class="form-group">
                        <label for="model_name">Model Name</label>
                        <input type="text" name="model_name" id="model_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="release_date">Release Date</label>
                        <input type="date" name="release_date" id="release_date" class="form-control" required>
                    </div>
                    <button type="submit" name="upload" class="btn-submit">Add Model</button>
                </form>
            </main>
        </div>
    </body>
    </html>
    <?php
}
function interior_color_add() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
        $connection = get_db_connection();

        $color = mysqli_real_escape_string($connection, $_POST['color']);
        $price = mysqli_real_escape_string($connection, $_POST['price']);

        $query = "INSERT INTO `interior_color` (color, price) 
                  VALUES ('$color', '$price')";
        if (mysqli_query($connection, $query)) {
            echo "<script>
                    alert('Data deleted successfully!');
                    window.location.href ='edit_table.php?table=interior_color'
                    setTimeout(function() {
                        location.reload();  // Refresh the page after going back
                    }, 100);
                  </script>";
        } else {
            echo "Error inserting interior color: " . mysqli_error($connection);
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
        <title>Add New Interior Color</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="formstyle.css">
    </head>
    <body>
        <div class="container">
            <main class="content">
                <h1>Add New Interior Color</h1>
                <form action="add.php?table=interior_color" method="POST">
                    <div class="form-group">
                        <label for="color">Color</label>
                        <input type="text" name="color" id="color" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                    </div>
                    <button type="submit" name="upload" class="btn-submit">Add Interior Color</button>
                </form>
            </main>
        </div>
    </body>
    </html>
    <?php
}
    
function favourite_list_add() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
        $connection = get_db_connection();

        $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
        $car_model_id = mysqli_real_escape_string($connection, $_POST['car_model_id']);

        $query = "INSERT INTO `favourite_list` (user_id, car_model_id) 
                  VALUES ('$user_id', '$car_model_id')";
        if (mysqli_query($connection, $query)) {
            echo "<script>
                    alert('Data deleted successfully!');
                    window.location.href ='edit_table.php?table=favourite_list'
                    setTimeout(function() {
                        location.reload();  // Refresh the page after going back
                    }, 100);
                  </script>;";
        } else {
            echo "Error inserting favourite list: " . mysqli_error($connection);
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
        <title>Add New Favourite List</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="formstyle.css">
    </head>
    <body>
        <div class="container">
            <main class="content">
                <h1>Add New Favourite List</h1>
                <form action="add.php?table=favourite_list" method="POST">
                    <div class="form-group">
                        <label for="user_id">User ID</label>
                        <input type="number" name="user_id" id="user_id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="car_model_id">Car Model ID</label>
                        <input type="number" name="car_model_id" id="car_model_id" class="form-control" required>
                    </div>
                    <button type="submit" name="upload" class="btn-submit">Add to Favourite List</button>
                </form>
            </main>
        </div>
    </body>
    </html>
    <?php
}

function exterior_add() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
        $connection = get_db_connection();

        // Upload the image
        $uploaded_image = upload_image('uploadfile');
        if (!$uploaded_image) {
            return; // Stop processing if image upload failed
        }

        $exterior_type = mysqli_real_escape_string($connection, $_POST['exterior_type']);
        $price = mysqli_real_escape_string($connection, $_POST['price']);

        // Step 1: Insert into `exterior_image`
        $image_query = "INSERT INTO `exterior_image` (exterior_image) VALUES ('./images/$uploaded_image')";
        if (!mysqli_query($connection, $image_query)) {
            echo "Error inserting image: " . mysqli_error($connection);
            close_db_connection($connection);
            return;
        }

        // Step 2: Insert into `exterior` with the foreign key reference
        $exterior_query = "INSERT INTO `exterior` (exteriortype, price, exterior_image_id) 
                           VALUES ('$exterior_type', '$price', LAST_INSERT_ID())";
        if (mysqli_query($connection, $exterior_query)) {
            echo "<script>
                    alert('Data deleted successfully!');
                    window.location.href='edit_table.php?table=exterior'
                    setTimeout(function() {
                        location.reload();  // Refresh the page after going back
                    }, 100);
                  </script>";;
        } else {
            echo "Error inserting exterior: " . mysqli_error($connection);
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
        <title>Add New Exterior</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="formstyle.css">
    </head>
    <body>
        <div class="container">
            <main class="content">
                <h1>Add New Exterior</h1>
                <form action="add.php?table=exterior" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exterior_type">Exterior Type</label>
                        <input type="text" name="exterior_type" id="exterior_type" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="uploadfile">Upload Image</label>
                        <input type="file" name="uploadfile" id="uploadfile" class="form-control" required>
                    </div>
                    <button type="submit" name="upload" class="btn-submit">Add Exterior</button>
                </form>
            </main>
        </div>
    </body>
    </html>
    <?php
}

if (isset($_GET['table'])) {
    $table = $_GET['table'];

    switch ($table) {
        case 'technology':
            technology_add();
            break;
        case 'car_model':
            car_model_add();
            break;
        case 'color':
            color_add();
            break;
        case 'exterior':
            exterior_add();
            break;
        case 'favourite_list':
            favourite_list_add();
            break;
        case 'interior_color':
            interior_color_add();
            break;
        case 'models':
            models_add();
            break;
        default:
            echo "Invalid table selected.";
            break;
    }
}
?>
