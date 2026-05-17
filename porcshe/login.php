

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="login.css">
  <title>Porsche Login Page</title>
</head>

<body>
  <header id="login-header">
    <div class="content">
      <img src="./img/Porsche-logo.png" alt="Porsche Logo" class="logo">
      <h1>Welcome Back</h1>
      <p>Please login to your account</p>
    </div>
  </header>


  <section id="login-section">
    <div class="login-container">
      <form id="login-form" action="login_process.php" method="POST">
        <h2>Login</h2>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="btn btn-primary">Login</button>
        <p class="register-link">Don't have an account? <a href="sign_up.php">Sign up</a></p>
        <?php if (!empty($error_message)): ?>
          <p class="error-message" style="color: red; margin-top: 10px;">The Email or Password is wrong</p>
        <?php endif; ?>
      </form>
    </div>
  </section>

  <footer id="footer">
    <p>© 2024 Porsche Official. All Rights Reserved.</p>
  </footer>

</body>

</html>