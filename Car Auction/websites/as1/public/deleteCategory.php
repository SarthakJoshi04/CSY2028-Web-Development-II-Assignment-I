<?php
// Including the dbconnect.php file which connects the webpage to the database
require('dbconnect.php');
// Check if the form has been submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'selected_categories' is set and is an array
    if (isset($_POST['selected_categories']) && is_array($_POST['selected_categories'])) {
        // Retrieve the selected category IDs from the form
        $selectedCategories = $_POST['selected_categories'];

        // Prepare the SQL statement to delete categories
        $sql = 'delete from category where category_id in (' . implode(',', $selectedCategories) . ')';

        // Execute the delete query
        $deleteStatement = $Connection->prepare($sql);
        $deleteStatement->execute();

        // Redirect back to the page after deletion
        echo '<script>
            alert("Categories Removed.");
            window.location.href = "adminCategories.php";
        </script>;';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Category</title>
    <style>
        div {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            max-width: 400px;
        }

        label {
            display: inline-block;
            margin-bottom: 5px;
            color: #555;
        }

        button {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;

        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div>
        <h2>Remove Category</h2>
        <form action="deleteCategory.php" method="POST">
            <?php
            // SQL statement to select all categories
            $statement = $Connection->prepare('select * from category');
            $statement->execute();

            // Fetch the categories as an associative array
            $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Iterate through fetched categories and create checkboxes
            foreach ($categories as $category) {
                echo '<input type="checkbox" name="selected_categories[]" value="' . $category['category_id'] . '">';
                echo '<label>' . $category['category_name'] . '</label><br>';
            }
            ?>
            <br />
            <button type="submit">Remove</button>
        </form>
    </div>
</body>

</html>