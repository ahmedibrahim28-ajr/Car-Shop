<?php
// Include the database connection file
include "../db_connection.php"; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number']; 
    $address = $_POST['address']; 

    // Check if the user already exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);  // Use email as the identifier
    $stmt->execute();
    $result = $stmt->get_result();

    // If the user exists, show an error message
    if ($result->num_rows > 0) {
        echo "<script>alert('User with this email already exists.');</script>";
    } else {
        // Hash the password for security
        $hashedPassword = md5($password); // Replace with password_hash() in production

        // Insert new user into the database
        $query = "INSERT INTO users (name, email, password, phone_number, address,rule) VALUES (?, ?, ?, ?, ?,user)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $name, $email, $hashedPassword, $phone_number, $address);

        if ($stmt->execute()) {
            echo "<script>alert('Account created successfully!'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Error in account creation.');</script>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="sign_up.css">
  <title>Porsche Sign-Up Page</title>
</head>

<body>
  <header id="signup-header">
    <div class="content">
      <img src="./Porsche-logo.png" alt="Porsche Logo" class="logo">
      <h1>Create an Account</h1>
      <p>Join us by creating a new account</p>
    </div>
  </header>

  <section id="signup-section">
    <div class="signup-container">
      <form id="signup-form" method="POST" action="">
        <h2>Sign Up</h2>

        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="phone_number">Phone Number</label>
        <input type="tel" id="phone_number" name="phone_number"  placeholder="123-456-7890">

        <label for="address">Address</label>
        <input id="address" name="address"  placeholder="Enter your address"></input>

        <button type="submit" class="btn btn-primary">Sign Up</button>
        <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
      </form>
    </div>
  </section>

  <footer id="footer">
    <p>© 2024 Porsche Official. All Rights Reserved.</p>
  </footer>
</body>

</html>
