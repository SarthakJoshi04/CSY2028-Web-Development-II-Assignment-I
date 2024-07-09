<?php
// Starting the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Categories</title>
    <!-- Internam CSS for Admin Categories page -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        div.container {
            vertical-align: middle;
            margin: auto;
        }

        h1.admin-dashboard {
            color: #333;
            text-align: center;
        }

        p>a {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }

        p.user-display {
            display: inline-block;
            max-width: fit-content;
            font-family: 'Arial', sans-serif;
            font-style: italic;
            color: #007bff;
        }

        span.user-image {
            display: inline-block;
            height: auto;
            max-width: fit-content;
            overflow: hidden;
            vertical-align: middle;
        }

        span.user-image img {
            display: block;
            width: 20px;
            height: 20px;
        }

        a.button-logout {
            background-color: #007bff;
            text-decoration: none;
            color: #ffffff;
            font-weight: 500;
            padding: 0.3em;
            margin: 0.1em;
            border-radius: 0.3em;
            float: right;
            transition: all 0.1s ease-in-out 0s;
        }

        a.link-btn {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }

        a.edit {
            margin-left: 20px;
        }

        a.home {
            float: right;
            margin-bottom: 20px;
        }

        p>a:hover,
        a.link-btn:hover,
        a.button-logout:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1 class="admin-dashboard">Admin Dashboard</h1>
    <?php
    if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {
        // Admin is logged in
        echo '<a href="logout.php" class="button-logout">Logout</a>';
        echo '<p class="user-display"><span class="user-image"><img src="/images/user.png" alt="User Image"></span> Welcome, ' . htmlspecialchars($_SESSION['username']) . '!</p>';
    }
    ?>
    <div class="container">
        <?php
        // Includes addCategory.php file that allows the admin to add new categories
        require('addCategory.php');
        echo '<br />';
        // Includes removeCategory.php file that allows the admin to remove existing categories
        require('deleteCategory.php');
        ?>
    </div>
    <br />
    <!-- Link to editCategory.php page that allows admin to edit existing categories -->
    <a href="editCategory.php" class="edit link-btn">Edit Categories &#8594;</a>
    <br />
    <a href="index.php" class="home link-btn">Home Page &#8594; </a>
</body>

</html>