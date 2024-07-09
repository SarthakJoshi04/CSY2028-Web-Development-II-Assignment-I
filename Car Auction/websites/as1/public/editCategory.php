<?php
// Including the dbconnect.php file which connects the webpage to the database
require('dbconnect.php');
// Check if the form has been submitted using POST method and if the 'save_changes' button is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_changes'])) {
    // Retrieve the submitted category names from the form
    $categoryNames = $_POST['category_name'];
    // Iterate through each category ID and its corresponding name
    foreach ($categoryNames as $categoryId => $categoryName) {
        // Prepare an SQL query to update the category name in the database
        $query = "update category set category_name = :categoryName where category_id = :categoryId";
        // Prepare and execute the SQL query using a prepared statement
        $update = $Connection->prepare($query);
        $update->bindParam(':categoryName', $categoryName);
        $update->bindParam(':categoryId', $categoryId);
        $update->execute();

        // Display a JavaScript alert if the changes were saved successfully
        echo '<script>
            alert("Changes Saved.");
            window.location.href = "editCategory.php";
        </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <!-- Internal CSS for Edit Category page -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1.edit-category {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        a.admin {
            float: right;
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }

        a.admin:hover {
            background-color: #0056b3;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1 class="edit-category">Edit Categories</h1>
    <a href="adminCategories.php" class="admin">Dashboard &#8594; </a>
    <form action="editCategory.php" method="POST">
        <?php
        // Select all categories from the database
        $query = "select * from category";
        $result = $Connection->query($query);
        // Iterate through the fetched categories
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Output an input field for each category with its ID as the array key and the current category name as the default value
            echo "<input type='text' name='category_name[{$row['category_id']}]' value='{$row['category_name']}'>";
        }
        ?>
        <button type="submit" name="save_changes">Save Changes</button>
    </form>
</body>

</html>