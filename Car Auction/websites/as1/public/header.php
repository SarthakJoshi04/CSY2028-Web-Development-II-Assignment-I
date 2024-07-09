<!-- Styles for the header -->
<style>
    a.button-login,
    a.button-signup,
    a.button-logout,
    a.admin-page {
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

    a.button-login:hover,
    a.button-signup:hover,
    a.button-logout:hover,
    a.admin-page:hover {
        background-color: #0056b3;
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
</style>

<!-- Header of the website -->
<?php
// Check if a user is logged in
if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {
    if ($_SESSION['username'] === 'admin') {
        // Logged in as admin
        echo '<p class="user-display"><span class="user-image"><img src="/images/user.png" alt="User Image"></span> Welcome, ' . htmlspecialchars($_SESSION['username']) . '!</p>';
        echo '<a href="adminCategories.php" class="admin-page">Admin Page</a>';
        echo '<a href="logout.php" class="button-logout">Logout</a>';
    } else {
        // Logged in as a normal user
        echo '<p class="user-display"><span class="user-image"><img src="/images/user.png" alt="User Image"></span> Welcome, ' . htmlspecialchars($_SESSION['username']) . '!</p>';
        echo '<a href="logout.php" class="button-logout">Logout</a>';
    }
} else {
    // User not logged in
    echo '<a href="login.php" class="button-login">Login</a>';
    echo '<a href="register.php" class="button-signup">Sign Up</a>';
}
?>
<header>
    <h1><span class="C">C</span>
        <span class="a">a</span>
        <span class="r">r</span>
        <span class="b">b</span>
        <span class="u">u</span>
        <span class="y">y</span>
    </h1>

    <form action="searchAuction.php" method="POST">
        <input type="text" name="search" placeholder="Search for a car" />
        <input type="submit" name="submit" value="Search" />
    </form>
</header>

<?php
// SQL query to select all data from category table
$sql = "select * from category";

// Execute the query
$result = $Connection->query($sql);

if ($result !== false) {
    if ($result->rowCount() > 0) {
        echo '<nav>';
        echo '<ul>';
        // Loop through the fetched rows
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Generate a category link to 'showCategory.php' with the category name as a URL parameter
            echo '<li><a class="categoryLink" href="showCategory.php?category=' . urlencode($row['category_name']) . '">' . htmlspecialchars($row['category_name'], ENT_QUOTES, 'UTF-8') . '</a></li>';
        }
        echo '</ul>';
        echo '</nav>';
    }
}
?>