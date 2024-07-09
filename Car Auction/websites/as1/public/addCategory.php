<?php
// Including the dbconnect.php file which connects the webpage to the database
require('dbconnect.php');

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare the SQL statement for inserting into the category table
    $insert = $Connection->prepare(
        'insert into category (category_name) values (:category_name)'
    );

    // Check if the required POST variables are set
    if (isset($_POST['new-category'])) {
        $criteria = [
            'category_name' => $_POST['new-category'],
        ];

        // Execute the prepared statement
        $insert->execute($criteria);

        // Display a JavaScript alert if the category is added successfully
        if ($insert) {
            echo '<script>
                alert("Category Added.");
                window.location.href = "adminCategories.php";
            </script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <!-- Internal CSS for Add Category page -->
    <style>
        main {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2.add-category {
            color: #333;
        }

        form {
            max-width: 400px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
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
    <main>
        <h2 class="add-category">Add New Category</h2>
        <form action="addCategory.php" method="POST">
            <label for="new-category">Category</label>
            <input type="text" name="new-category" id="new-category" required />
            <br />
            <button type="submit">Add Category</button>
        </form>
    </main>
</body>

</html>