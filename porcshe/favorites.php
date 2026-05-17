<?php
// Start the session to track the user
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Include the database connection file
include '../db_connection.php';

// Fetch the user's favorites from the database
$user_id = $_SESSION['user_id']; // Get the user ID from session

// Function to fetch favorite cars for the logged-in user
function get_favorite_cars($user_id)
{
    // Get the database connection
    $connection = get_db_connection();

    // Query to select cars from the favorite_list table for the logged-in user
    $query = "SELECT cm.id, cm.car_name, cm.car_model_image
              FROM favourite_list fl
              JOIN car_model cm ON fl.car_model_car_id = cm.id
              WHERE fl.users_user_id = $user_id";

    // Execute the query
    $result = mysqli_query($connection, $query);

    // Check if the query was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    // Return the result
    return $result;
}

// Fetch the favorite cars
$favorites = get_favorite_cars($user_id);

// Close the database connection
close_db_connection(get_db_connection());
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Favorites Page</title>
  <link rel="stylesheet" href="favorites.css">
  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
    integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <!-- Header Section-->
  <header>
        <div id="navbar">
            <img src="./img/Porsche-logo.png" alt="porsche Logo">
            <nav role="navigation">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="profile.php">profile</a></li>
                    <li><a href="Category.php">Category</a></li>
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

  <!-- Favorites Section -->
  <section id="favorites">
    <h1>Favorites</h1>
    <div class="favorites-grid">
      <?php
      // Check if there are any favorite cars for the user
      if (mysqli_num_rows($favorites) > 0) {
          // Loop through the favorite cars and display each one
          while ($car = mysqli_fetch_assoc($favorites)) {
              echo "<div class='favorite-item'>";
              echo "<img src='" . $car['car_model_image'] . "' alt='" . $car['car_name'] . "'>";
              echo "<div class='details'>";
              echo "<h3>" . $car['car_name'] . "</h3>";
              echo "<button onclick='removeFavorite(" . $car['id'] . ")'>Remove from Favorites</button>";
              echo "</div>";
              echo "</div>";
          }
      } else {
          echo "<p>You don't have any favorite cars yet.</p>";
      }
      ?>
    </div>
  </section>
  <!-- Contact Section-->
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
            <p>11:00 am to 1:00 Am on Weekends</p>
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

  <!-- Footer-->
  <footer id="footer">
    <p>&copy; 2024 Porsche Official. All Rights Reserved.</p>
  </footer>

  <script src="favorites.js"></script>
</body>

</html>
