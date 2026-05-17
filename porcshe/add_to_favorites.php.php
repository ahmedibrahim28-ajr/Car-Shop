<?php
session_start();
include '../db_connection.php';

// Set header to return JSON
header('Content-Type: application/json');

try {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

    // Get POST data
    $car_id = isset($_POST['car_id']) ? (int)$_POST['car_id'] : null;
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : null;

    // Validate data
    if (!$car_id || !$user_id) {
        throw new Exception('Missing required data');
    }

    // Get database connection
    $conn = get_db_connection();

    // Check if already in favorites
    $check_sql = "SELECT id FROM favorites WHERE user_id = ? AND car_id = ?";
    $stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $car_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Remove from favorites
        $sql = "DELETE FROM favorites WHERE user_id = ? AND car_id = ?";
        $message = "Removed from favorites";
    } else {
        // Add to favorites
        $sql = "INSERT INTO favorites (user_id, car_id) VALUES (?, ?)";
        $message = "Added to favorites";
    }

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $car_id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode([
            'status' => 'success',
            'message' => $message
        ]);
    } else {
        throw new Exception('Database error: ' . mysqli_error($conn));
    }

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}