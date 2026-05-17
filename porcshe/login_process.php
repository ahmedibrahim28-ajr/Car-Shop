<?php

session_start();
include "../db_connection.php";
$conn = get_db_connection();


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];
  

  if (!empty($email) && !empty($password)) {
    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      // Save session
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['role'] = $user['role'];
      
      header("Location: index.php");
      exit();
    } else {
      echo "<script>alert('The Email or Password is wrong'); window.location.href = 'login.php';</script>";
    }

    $stmt->close();
  } else {
    echo "Please fill in both fields.";
  }
}

$conn->close();
?>