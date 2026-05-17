<?php

session_start();
include '../db_connection.php';
if (!isset($_SESSION['user_id'])) {
  // Redirect to the login page if not logged in
  header("Location: login.php");
  exit();
}


// Function to fetch car models
function get_car_models()
{
    // Get the database connection
    $connection = get_db_connection();

    // Query to select car models from the database
    $query = "SELECT cm.id, cm.car_name, cm.topspeed, cm.horsepower, cm.price, cm.in_stock, mi.car_model_image
              FROM car_model cm
              LEFT JOIN car_model_image mi ON cm.car_model_images_id = mi.id";

    // Execute the query
    $result = mysqli_query($connection, $query);

    // Check if the query was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    // Return the result
    return $result;
}

// Fetch the car models
$cars = get_car_models();

// Close the database connection
close_db_connection(get_db_connection());
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porsche Car Categories</title>
    <link rel="stylesheet" href="category.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

<header>
    <div id="navbar">
        <img src="./img/Porsche-logo.png" alt="porsche Logo">
        <nav role="navigation">
            <ul>
            <li><a href="index.php">Home</a></li>
                    <li><a href="profile.php">profile</a></li>
                    <li><a href="Category.php?user_id=<?php echo $_SESSION['user_id']; ?>">Category</a></li>
                    <li><a href="favorites.php">favorite</a></li>
                    <li><a href="news.php">News</a></li>
                <ul>
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </ul>
        </nav>
    </div>
</header>

<!-- Car Categories Section -->
<section id="categories">
    <h1>Car Categories</h1>
    <div class="car-category">
        <?php
        // Loop through the cars and display each one
        while ($car = mysqli_fetch_assoc($cars)) {
            echo "<div class='car'>";
            echo "<img src='" . $car['car_model_image'] . "' alt='" . $car['car_name'] . "'>";
            echo "<h3>" . $car['car_name'] . "</h3>";
            echo "<p>Top Speed: " . $car['topspeed'] . " km/h</p>";
            echo "<p>Horsepower: " . $car['horsepower'] . " HP</p>";
            echo "<p>Price: $" . $car['price'] . "</p>";
            echo "<p>In Stock: " . $car['in_stock'] . "</p>";
            // Add the favorite heart icon with an onclick event
            echo "<a href='customize_car.php?car_image=" . urlencode($car['car_model_image']) . "&car_id=" . $car['id'] . "&price=" . $car['price'] . "' class='btn btn-customize'>Customize</a>";
            echo "<br><br><i class='fa-regular fa-heart favorite-heart' onclick='toggleFavorite(" . $car['id'] . ")'></i>";
            echo "</div>";
        }
        ?>
    </div>
</section>

<!-- Contact Section -->
<section id="contact">
    <div class="container">
        <div class="contact-content">
            <div class="contact-info">
                <div>
                    <h3>ADDRESS</h3>
                    <p><i class="fa-solid fa-location-dot"></i> Dr. Ing. h.c. F. Porsche AG, Porscheplatz 1</p>
                    <p><i class="fa-solid fa-phone"></i> Phone: (0711) 911 - 0</p>
                    <p><i class="fa-regular fa-envelope"></i> porsche@official.com</p>
                </div>
                <div>
                    <h3>WORKING HOURS</h3>
                    <p>8:00 am to 11:00 pm on Weekdays</p>
                    <p>11:00 am to 1:00 am on Weekends</p>
                </div>
                <div>
                    <h3>FOLLOW US</h3>
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
            <form>
                <input type="text" name="Name" id="name" placeholder="Full Name">
                <input type="email" name="email" id="email" placeholder="Email Address">
                <input type="text" name="subject" id="subject" placeholder="Subject">
                <textarea name="message" id="message" cols="30" rows="5" placeholder="Message"></textarea>
                <button type="submit" class="btn btn-third">SEND US!</button>
            </form>
        </div>
    </div>
</section>

<footer id="footer">
    <p>&copy; 2024 Porsche Official. All Rights Reserved.</p>
</footer>

<script>
const userId = <?php echo $_SESSION['user_id']; ?>;

function toggleFavorite(carId) {
    // Send an AJAX request to add the car to the user's favorites
    fetch('add_to_favorites.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            car_id: carId,
            user_id: userId  // Add the user_id to the request
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            // Optionally change the heart icon to filled
            event.target.classList.toggle('fa-solid');
            event.target.classList.toggle('fa-regular');
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing your request.');
    });
}

</script>

</body>
</html>
