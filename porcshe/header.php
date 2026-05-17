<?php
 // Make sure session_start() is called in the header

if (isset($_SESSION['user_id'])) {
    // The user is logged in
    echo "Welcome, " . $_SESSION['email'];
    echo "<a href='logout.php'>Logout</a>";
} else {
    // The user is not logged in
    echo "<a href='login.php'>Login</a>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porsche Website</title>
    <style>
        /* Google Fonts */
        @import url("https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: "Quicksand", sans-serif;
            background-color: #f4f4f4;
            color: #383848;
        }

        a {
            text-decoration: none;
            color: #fff;
        }

        ul {
            list-style: none;
        }

        /* Navbar */
        #navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 50px;
            background-color: #383848;
        }

        #navbar img {
            width: 100px;
        }

        /* Sidebar */
        #sidebar {
            position: fixed;
            top: 0;
            right: -250px;
            width: 250px;
            height: 100%;
            background-color: #383848;
            padding-top: 20px;
            box-shadow: -5px 0px 15px rgba(0, 0, 0, 0.2);
            transition: right 0.3s ease-in-out;
        }

        #sidebar ul {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-left: 20px;
        }

        #sidebar ul li {
            padding: 10px;
            border-bottom: 1px solid #e4b95b;
        }

        #sidebar ul li a {
            color: #e4b95b;
            font-weight: 600;
        }

        #sidebar ul li a:hover {
            color: #fff;
        }

        /* Close Button */
        #close-btn {
            font-size: 30px;
            cursor: pointer;
            color: #e4b95b;
            background: none;
            border: none;
            position: absolute;
            top: 20px;
            left: 10px;
        }

        /* Toggle Button */
        #toggle-btn {
            font-size: 50px; /* Increased the size */
            cursor: pointer;
            color: #e4b95b;
            background: none;
            border: none;
            position: fixed;
            top: 20px; /* Position fixed at the top */
            right: 20px; /* Position fixed at the right */
            
        }

        /* Responsive Layout */
        @media (max-width: 1000px) {
            #sidebar {
                width: 200px;
            }
        }

        @media (max-width: 600px) {
            #sidebar {
                width: 150px;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
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
            <li><a href="profile">profile</a></li>
            <li><a href="index.php">Home</a></li>
            <li><a href="category.php">Category</a></li>
            <li><a href="favorite.php">favorite</a></li>
            <li><a href="news.php">News</a></li>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
        </ul>
    </div>

    <script>
        // JavaScript to toggle the sidebar visibility
        const toggleBtn = document.getElementById('toggle-btn');
        const sidebar = document.getElementById('sidebar');
        const closeBtn = document.getElementById('close-btn');

        // Open sidebar when the toggle button is clicked
        toggleBtn.addEventListener('click', () => {
            sidebar.style.right = '0';  // Open the sidebar
        });

        // Close sidebar when the close button is clicked
        closeBtn.addEventListener('click', () => {
            sidebar.style.right = '-250px';  // Close the sidebar
        });
    </script>

</body>
</html>
