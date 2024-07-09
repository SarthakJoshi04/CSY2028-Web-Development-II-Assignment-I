<?php
// Including the dbconnect.php file which connects the webpage to the database
require('dbconnect.php');

// Check if the form is submitted and the update_auction button is clicked
if (isset($_POST['update_auction'])) {
    // Sanitize and retrieve the form data
    $auction_id = htmlspecialchars($_POST['auction-id']);
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['desc']);
    $category_id = htmlspecialchars($_POST['category']);
    $end_date = htmlspecialchars($_POST['end-date']);

    // Prepare a SQL statement to update the auction information
    $statement = $Connection->prepare('update auction set title = :title, description = :description, category_id = :category_id, end_date = :end_date where auction_id = :auction_id');

    // Bind the parameters
    $statement->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $statement->bindParam(':end_date', $end_date, PDO::PARAM_STR);

    // Execute the prepared SQL statement
    $result = $statement->execute();

    // Check if the update was successful
    if ($result) {
        // Display a JavaScript alert if the changes were saved successfully
        echo '<script>alert("Auction Updated.");
        window.location.href = "index.php";
        </script>';
    }
}
?>

<?php
//PHP code to get auction information of the related auction from the database
$auction = [];
// Check if auction_id is set in the URL
if (isset($_GET['auction-id'])) {
    // Sanitize the input to prevent SQL injection
    $auction_id = htmlspecialchars($_GET['auction-id']);

    // Prepare a SQL statement to select auction details based on auction_id
    $statement = $Connection->prepare('select * from auction where auction_id = :auction_id');
    // Bind the parameter
    $statement->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);
    // Execute the prepared SQL statement
    $statement->execute();

    // Fetch the auction details as an associative array
    $auction = $statement->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Auction</title>
    <!-- Internal CSS for Edit Auction page -->
    <style>
        main {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1.edit-auction {
            color: #333;
            display: inline-block;
            width: fit-content;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        textarea,
        select,
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            /* Removes the default dropdown arrow */
            appearance: none;
            /* Adds new dropdown arrow from external source */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23555%5D%5D"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 8px top 50%;
        }

        label[for="image"] {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            display: inline-block;
        }

        input[type="file"]+label {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
        }

        input[type="file"]+label:hover {
            background-color: #0056b3;
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

        a.home {
            float: right;
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }

        a.home:hover,
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <main>
        <h1 class="edit-auction">Edit Auction</h1>
        <a href="index.php" class="home">Home Page &#8594; </a>
        <form action="editAuction.php" method="POST">
            <!-- Checks if the variable $auction is not empty before proceeding with the enclosed code block. -->
            <?php if (!empty($auction)) : ?>
                <input type="hidden" name="auction-id" value="<?php echo $auction['auction_id']; ?>">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?php echo $auction['title']; ?>" required />
                <br />
                <label for="desc">Description</label>
                <textarea name="desc" id="desc" cols="30" rows="10" style="resize: none" required><?php echo $auction['description']; ?></textarea>
                <br />
                <label for="category">Category</label>
                <select name="category" id="category" required>
                    <!-- PHP code to fetch categories from category table and represent them as options for select element -->
                    <?php
                    // Prepare a SQL statement to select categories
                    $statement = $Connection->prepare('select * from category');
                    // Execute the prepared SQL statement
                    $statement->execute();

                    // Fetch the categories as an associative array
                    $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

                    // Iterate through fetched categories and create options
                    foreach ($categories as $category) {
                        // Output each category as an option in HTML select element
                        // Display the selected category as default value
                        $selected = ($category['category_id'] == $auction['category_id']) ? 'selected' : '';
                        echo "<option value='" . $category['category_id'] . "' $selected>" . $category['category_name'] . "</option>";
                    }
                    ?>
                </select>
                <br />
                <label for="end-date">End Date</label>
                <input type="date" name="end-date" id="end-date" value="<?php echo $auction['end_date'] ?>" />
                <br />
            <?php endif; ?>
            <button type="submit" name="update_auction">Update Auction</button>
        </form>
    </main>
</body>

</html>