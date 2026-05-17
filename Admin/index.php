<?php
include('../db_connection.php');  // Include the database connection file
$connection=get_db_connection();
// Query to get the count of users
$user_count_query = "SELECT COUNT(*) AS user_count FROM users";
$user_count_result = mysqli_query($connection, $user_count_query);
$user_count_row = mysqli_fetch_assoc($user_count_result);
$user_count = $user_count_row['user_count'];

// Query to get the number of cars in stock and their total value
$car_stock_query = "SELECT COUNT(*) AS car_count, SUM(price) AS total_value FROM car_model WHERE in_stock > 0";
$car_stock_result = mysqli_query($connection, $car_stock_query);
$car_stock_row = mysqli_fetch_assoc($car_stock_result);
$car_count = $car_stock_row['car_count'];
$total_value = $car_stock_row['total_value'];

// Query to get the top 3 cars by sales
$count_query = "SELECT COUNT(*) AS total_sales FROM receipt";
$count_result = mysqli_query($connection, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_sales = $count_row['total_sales'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Brand Shop Admin</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h2>Tables</h2>
            <ul>
                <li><a href="index.php">Dash Board</a></li>
                <li><a href="edit_table.php?table=car_model">Car Model</a></li>
                <li><a href="edit_table.php?table=color">Color</a></li>
                <li><a href="edit_table.php?table=exterior">Exterior</a></li>
                <li><a href="edit_table.php?table=favourite_list">Favourite List</a></li>
                <li><a href="edit_table.php?table=interior_color">Interior Color</a></li>
                <li><a href="edit_table.php?table=models">Models</a></li>
                <li><a href="edit_table.php?table=technology">Technology</a></li>
            </ul>
        </aside>
        <main class="content">
            <h1>Welcome to the Car Brand Shop Admin Panel</h1>
            <h2>Dashboard</h2>

            <!-- Dashboard Section -->
            <section class="dashboard">
                <div class="dashboard-item">
            
                    <p>Total Users <br><?php echo $user_count; ?></p>
                </div>
                <div class="dashboard-item">
                    
                    <p>Cars in Stock<br><?php echo $car_count; ?> cars</p>
                    <p>Total value <br> $<?php echo number_format($total_value, 2); ?></p>
                    <p>Total Sales <br> <?php echo $total_sales; ?></p>
                </div>
                
            </section>
        </main>
    </div>
</body>
</html>
