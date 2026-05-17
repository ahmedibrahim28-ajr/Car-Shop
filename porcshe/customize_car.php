<?php
include "../db_connection.php";

$conn = get_db_connection();

$car_image = isset($_GET['car_image']) ? $_GET['car_image'] : './img/default.jpg';
$car_id = isset($_GET['car_id']) ? $_GET['car_id'] : null;
$base_price = isset($_GET['price']) ? (float) $_GET['price'] : 0.0;

// Fetch colors
$colors_query = "SELECT color, hex_num, price FROM color";
$colors_result = $conn->query($colors_query);

// Fetch wheels
$wheels_query = "
    SELECT 
    wi.wheels_image AS image,
    w.wheels_type AS name,
    w.size AS size,
    w.price AS price
    FROM 
    car_brand_shop.wheels w
    JOIN 
    car_brand_shop.wheels_image wi ON w.wheels_image_id = wi.id;";
$wheels_result = $conn->query($wheels_query);

// Fetch interior colors
$interior_query = "SELECT color, hex_num, price FROM interior_color";
$interior_result = $conn->query($interior_query);

// Fetch technologies
$technologies_query = "
    SELECT technology_type AS type, price, technology_image 
    FROM technology 
    LEFT JOIN technology_image 
    ON technology.technology_image_id = technology_image.id";
$technologies_result = $conn->query($technologies_query);

// Fetch exteriors
$exteriors_query = "
    SELECT exteriortype AS type, price, exterior_image 
    FROM exterior 
    LEFT JOIN exterior_image 
    ON exterior.exterior_image_id = exterior_image.id";
$exteriors_result = $conn->query($exteriors_query);

//cas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get selected options from the form
    $car_model_id = $_POST['car_model_id'];
    $color_id = $_POST['color_id'];
    $wheel_id = $_POST['wheel_id'];
    $interior_color_id = $_POST['interior_color_id'];
    $technology_id = $_POST['technology_id'];
    $exterior_part_id = $_POST['exterior_part_id'];
    $total_price = $_POST['total_price'];

    // Insert the customization details into the database
    $query = "INSERT INTO car_customization 
              (car_model_id, color_id, wheel_id, interior_color_id, technology_id, exterior_part_id, total_price) 
              VALUES 
              ('$car_model_id', '$color_id', '$wheel_id', '$interior_color_id', '$technology_id', '$exterior_part_id', '$total_price')";
    if (mysqli_query($conn, $query)) {
        echo "Customization saved successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Customization</title>
    <link rel="stylesheet" href="customize_car.css">
    <style></style>
</head>
<header>
        <div id="navbar">
            <img src="./images/Porsche-logo.png" alt="Porsche Logo">
        </div>
        <button id="toggle-btn">&#9776;</button>
    </header>

    <!-- Toggle Button to Open Sidebar -->
    

    <!-- Sidebar -->
    <div id="sidebar">
        <button id="close-btn">&#10006;</button><br><br>
        <ul>
        <li><a href="index.php">Home</a></li>
                    <li><a href="profile.php">profile</a></li>
                    <li><a href="Category.php?user_id=<?php echo $_SESSION['user_id']; ?>">Category</a></li>
                    <li><a href="favorites.php?user_id=<?php echo $_SESSION['user_id']; ?> ">favorite</a></li>
                    <li><a href="news.php?user_id=<?php echo $_SESSION['user_id']; ?>">News</a></li>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
        </ul>
    </div>
<body>
    <div class="main-container">
        <div class="image-viewer">
            <img id="car-image" src="<?= htmlspecialchars($car_image); ?>" alt="Car">
        </div>
        <div class="selectors-container">

            <!-- Exterior Colors -->
            <div class="color-selector">
                <h2>Exterior Colours</h2>
                <div class="color-group">
                    <?php while ($row = $colors_result->fetch_assoc()): ?>
                        <div class="color-option" data-price="<?= $row['price']; ?>" onclick="selectColor(this)">
                            <div class="color-swatch" style="background-color: <?= $row['hex_num']; ?>;"></div>
                            <div class="color-name"><?= $row['color']; ?></div>
                            <span class="like-icon">♥</span>
                            <div class="price">$<?= $row['price']; ?></div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Wheel Rims -->
            <div class="rim-selector">
                <h2>Wheel Rims</h2>
                <div class="rim-group">
                    <?php while ($row = $wheels_result->fetch_assoc()): ?>
                        <div class="rim-option" data-price="<?= $row['price']; ?>" onclick="selectWheel(this)">
                            <img class="rim-image" src="./img/<?= $row['image']; ?>" alt="<?= $row['name']; ?>">
                            <div class="rim-name"><?= $row['name']; ?> (<?= $row['size']; ?>)</div>
                            <span class="like-icon">♥</span>
                            <div class="price">$<?= $row['price']; ?></div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Interior Colors -->
            <div class="interior-color-selector">
                <h2>Interior Colors</h2>
                <div class="interior-group">
                    <?php while ($row = $interior_result->fetch_assoc()): ?>
                        <div class="interior-option" data-price="<?= $row['price']; ?>" onclick="selectInterior(this)">
                            <div class="color-swatch" style="background-color: <?= $row['hex_num']; ?>;"></div>
                            <div class="color-name"><?= $row['color']; ?></div>
                            <span class="like-icon">♥</span>
                            <div class="price">$<?= $row['price']; ?></div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Technology Parts -->
            <div class="technology-selector">
                <h2>Technology Parts</h2>
                <div class="technology-group">
                    <?php while ($row = $technologies_result->fetch_assoc()): ?>
                        <div class="tech-option" data-price="<?= $row['price']; ?>" onclick="selectOption(this, 'tech')">
                            <img class="rim-image" src="./img/<?= $row['technology_image']; ?>" alt="<?= $row['type']; ?>">
                            <div class="tech-name"><?= $row['type']; ?></div>
                            <span class="like-icon">♥</span>
                            <div class="price">$<?= $row['price']; ?></div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Exterior Parts -->
            <div class="exterior-selector">
                <h2>Exterior Parts</h2>
                <div class="exterior-group">
                    <?php while ($row = $exteriors_result->fetch_assoc()): ?>
                        <div class="exterior-option" data-price="<?= $row['price']; ?>" onclick="selectOption(this, 'exterior')">
                            <img class="rim-image" src="./img/<?= $row['exterior_image']; ?>" alt="<?= $row['type']; ?>">
                            <div class="part-name"><?= $row['type']; ?></div>
                            <span class="like-icon">♥</span>
                            <div class="price">$<?= $row['price']; ?></div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <form method="POST" action="save_customization.php">
                <input type="hidden" name="car_model_id" value="<?= $car_id; ?>">
                <input type="hidden" name="total_price" id="total-price-field" value="<?= $base_price; ?>">

                <!-- Hidden fields for the selected options -->
                <input type="hidden" name="color_id" value="">
                <input type="hidden" name="wheel_id" value="">
                <input type="hidden" name="interior_color_id" value="">
                <input type="hidden" name="technology_id" value="">
                <input type="hidden" name="exterior_part_id" value="">

                <button type="submit">Save Customization</button>
            </form>

            <div id="price-summary">
                <h3 id="total-price">Total Price: $<?= $base_price; ?></h3>
            </div>
        </div>
    </div>

    <script>
        let totalPrice = <?= $base_price; ?>;
        let previousColorPrice = 0;
        let previousWheelPrice = 0;
        let previousInteriorPrice = 0;

        function updateTotalPrice() {
            document.getElementById("total-price").textContent = "Total Price: $" + totalPrice.toFixed(2);
        }

        function selectColor(element) {
            // Remove previous color's price
            if (previousColorPrice > 0) {
                totalPrice -= previousColorPrice;
            }
            const price = parseFloat(element.getAttribute("data-price"));
            previousColorPrice = price;
            totalPrice += price; // Add new color's price
            document.querySelectorAll('.color-option.selected').forEach(item => item.classList.remove('selected'));
            element.classList.add('selected');
            updateTotalPrice();
        }

        function selectWheel(element) {
            // Remove previous wheel's price
            if (previousWheelPrice > 0) {
                totalPrice -= previousWheelPrice;
            }
            const price = parseFloat(element.getAttribute("data-price"));
            previousWheelPrice = price;
            totalPrice += price; // Add new wheel's price
            document.querySelectorAll('.rim-option.selected').forEach(item => item.classList.remove('selected'));
            element.classList.add('selected');
            updateTotalPrice();
        }

        function selectInterior(element) {
            // Remove previous interior color's price
            if (previousInteriorPrice > 0) {
                totalPrice -= previousInteriorPrice;
            }
            const price = parseFloat(element.getAttribute("data-price"));
            previousInteriorPrice = price;
            totalPrice += price; // Add new interior color's price
            document.querySelectorAll('.interior-option.selected').forEach(item => item.classList.remove('selected'));
            element.classList.add('selected');
            updateTotalPrice();
        }

        function selectOption(element, type) {
            const price = parseFloat(element.getAttribute("data-price"));
            if (element.classList.contains("selected")) {
                element.classList.remove("selected");
                totalPrice -= price;
            } else {
                element.classList.add("selected");
                totalPrice += price;
            }
            updateTotalPrice();
        }
    </script>
</body>

</html>
