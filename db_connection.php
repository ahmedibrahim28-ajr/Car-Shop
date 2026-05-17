<?php
// db.php

// Function to establish a connection to the database
function get_db_connection() {
    $connection = mysqli_connect("127.0.0.1", "root", "1234", "car_brand_shop");

    // Check if the connection was successful
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    return $connection;
}

// Function to close the database connection
function close_db_connection($connection) {
    mysqli_close($connection);
}
?>