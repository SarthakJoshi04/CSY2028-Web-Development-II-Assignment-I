<?php
// Start the session (check if it's already started)
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Including the dbconnect.php file which connects the webpage to the database
require('dbconnect.php');

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Prepare the SQL statement for inserting auction data into the database
  $insert = $Connection->prepare(
    'insert into auction (user_id, category_id, title, description, end_date, car_image) values (:user_id, :category_id, :title, :description, :end_date, :image)'
  );

  // Check if the required POST variables are set
  if (isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['end-date']) && isset($_POST['car-image']) && isset($_POST['category'])) {
    // Define an associative array with criteria for the prepared statement
    $criteria = [
      'user_id' => $_SESSION['user_id'],
      'category_id' => $_POST['category'],
      'title' => $_POST['title'],
      'description' => $_POST['desc'],
      'end_date' => $_POST['end-date'],
      'image' => $_POST['car-image'],
    ];

    // Execute the prepared statement with the provided criteria
    $insert->execute($criteria);

    // Check if the insertion was successful
    if ($insert) {
      // Display a JavaScript alert if the auction is added successfully
      echo '<script>
          alert("Auction Added.");
      </script>';
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Auctions</title>
  <!-- Internal CSS for Add Auction page -->
  <style>
    div.add-auction {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    h1.add-auction {
      color: #333;
      display: inline-block;
      width: fit-content;
    }

    form#add-auction {
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
  <div class="add-auction">
    <h1 class="add-auction">Add Auction</h1>
    <a href="index.php" class="home">Home Page &#8594; </a>
    <form action="addAuction.php" method="POST" id="add-auction">
      <label for="title">Title</label>
      <input type="text" name="title" id="title" required />
      <br />
      <label for="desc">Description</label>
      <br />
      <textarea name="desc" id="desc" cols="30" rows="10" placeholder="Describe the car..." style="resize: none" required></textarea>
      <br />
      <label for="category">Category</label>
      <select name="category" id="category" required>
        <option value="" selected disabled>Select a Category</option>
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
          echo "<option value='" . $category['category_id'] . "'>" . $category['category_name'] . "</option>";
        }
        ?>
      </select>
      <br />
      <label for="end-date">End Date</label>
      <input type="date" name="end-date" id="end-date" required />
      <br />
      <label for="car-image">Image(optional)</label>
      <input type="file" name="car-image" id="car-image">
      <br />
      <button type="submit">Add Auction</button>
    </form>

  </div>
</body>

</html>