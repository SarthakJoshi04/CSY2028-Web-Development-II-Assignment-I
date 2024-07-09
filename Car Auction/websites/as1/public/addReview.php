<?php
// Include the dbconnect.php file which connects the webpage to the database
require('dbconnect.php');

// Start the session (check if it's already started)
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['auction-id'])) {
  $auctionId = $_POST['auction-id'];
  // Check if the review data is set in the POST request
  if (isset($_POST['review'])) {
    // Get the review text from the POST data
    $reviewText = $_SESSION['username'] . ' said: ' . $_POST['review'];

    // Get the user_id of the auction creator from the session variable
    if (isset($_SESSION['auction_creator_user_id'])) {
      $auctionCreatorUserId = $_SESSION['auction_creator_user_id'];

      // Insert the review into the database
      $sql = 'insert into review (review_text, user_id) values (:review_text, :user_id)';
      $stmt = $Connection->prepare($sql);
      $stmt->bindParam(':review_text', $reviewText, PDO::PARAM_STR);
      $stmt->bindParam(':user_id', $auctionCreatorUserId, PDO::PARAM_INT);

      // Execute the query
      if ($stmt->execute()) {
        echo '<script>alert("Review added.");
          window.location.href = "viewAuction.php?auction-id=' . $auctionId . '";
          </script>';
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Add Review</title>
  <!-- Internal CSS for Add Review page -->
  <style>
    div.add-review {
      font-family: Arial, sans-serif;
      overflow: hidden;
    }

    form#review-form {
      max-width: 400px;
      box-shadow: none;
    }

    textarea.review-text {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
      resize: none;
    }

    button.post-review {
      background-color: #007bff;
      color: #fff;
      font-weight: bold;
      padding: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      display: block;
      margin-top: 10px;
    }

    button.post-review:hover {
      background-color: #0056b3;
    }
  </style>

<body>
  <div class="add-review">
    <form action="addReview.php" method="POST" id="review-form">
      <input type="hidden" name="auction-id" value="<?php echo $auctionId; ?>">
      <textarea name="review" id="review" cols="60" rows="20" placeholder="Add review..." class="review-text"></textarea>
      <br />
      <button type="submit" class="post-review">Post Review</button>
    </form>
  </div>
</body>

</html>