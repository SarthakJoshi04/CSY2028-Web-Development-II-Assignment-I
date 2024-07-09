<?php
// Including the dbconnect.php file which connects the webpage to the database
require('dbconnect.php');
// Starting the session
session_start();
// Check if the auction ID is provided in the URL
if (isset($_GET['auction-id'])) {

    $auctionId = $_GET['auction-id'];

    // Fetch detailed information about the auction
    $sql = 'select a.*, c.category_name, u.username, max(b.bid_amount) as current_bid 
            from auction a
            join category c on a.category_id = c.category_id
            join user u on a.user_id = u.user_id
            left join bid b on a.auction_id = b.auction_id
            where a.auction_id = :auction_id';

    $stmt = $Connection->prepare($sql);
    $stmt->bindParam(':auction_id', $auctionId, PDO::PARAM_INT);
    $stmt->execute();

    $auctionDetails = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="carbuy.css">
    <title>View Auction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 20px;
        }

        .car-img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-width: 80%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .auction-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .car-category {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .car-desc {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .auction-end {
            font-size: 16px;
            font-style: italic;
            margin-bottom: 10px;
        }

        .price {
            font-size: 16px;
            font-weight: bold;
        }

        .username {
            font-size: 16px;
            font-style: italic;
            margin-bottom: 20px;
        }

        a.home {
            position: relative;
            bottom: 1em;
            right: 1em;
            float: right;
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            margin-top: 1.5em;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }

        p.no-review {
            font-style: italic;
            color: #888;
            margin: 10px 0;
        }

        ul.review-list {
            list-style-type: none;
            padding: 0;
            margin: 10px 0;
        }

        li.review-content {
            margin-bottom: 10px;
        }

        a.home:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php
    // Include the header.php file that contains the header of the website
    require('header.php');
    ?>
    <div class="container">
        <?php
        if ($auctionDetails) {
            // Set a session variable with the user_id of the auction creator
            $_SESSION['auction_creator_user_id'] = $auctionDetails['user_id'];
            // Display car image
            $imagePath = '/images/auction/' . $auctionDetails['car_image'];
            $altText = $auctionDetails['title'];
            // Check if user had provided a image or not
            if (!empty($auctionDetails['car_image'])) {
                // Image path is provided, check for file existence
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
                    echo '<img src="' . $imagePath . '" alt="' . $altText . '" class="car-img">';
                } else {
                    echo '<img src="/car.png" alt="Car Image" class="car-img">';
                }
            } else {
                // Image was not provided, display placeholder
                echo '<img src="/car.png" alt="Car Image">';
            }
            echo '<h2 class="auction-title">' . $auctionDetails['title'] . '</h2>';
            echo '<h3 class="car-category">Category: ' . $auctionDetails['category_name'] . '</h3>';
            echo '<p class="car-desc">' . $auctionDetails['description'] . '</p>';
            echo '<p class="auction-end">End Date: ' . $auctionDetails['end_date'] . '</p>';
            echo '<p class="username">Created by: ' . $auctionDetails['username'] . '</p>';
            echo '<p class="price">Current Bid: £';
            // Check if there's a current bid
            if (isset($auctionDetails['current_bid'])) {
                echo $auctionDetails['current_bid'];
            } else {
                echo '0'; // Display 0 if no bids yet
            }
            echo '</p>';
        }
        ?>
        <?php
        if ($auctionDetails) {
            echo '<h2>User Reviews For ' . $auctionDetails['username'] . '</h2>';

            // Fetch reviews related to the user who created the auction
            $reviewSql = 'select * from review where user_id = :user_id';
            $reviewStmt = $Connection->prepare($reviewSql);
            $reviewStmt->bindParam(':user_id', $auctionDetails['user_id'], PDO::PARAM_INT);
            $reviewStmt->execute();

            $reviews = $reviewStmt->fetchAll(PDO::FETCH_ASSOC);

            // Display each review
            if ($reviews) {
                echo '<ul class="review-list">';
                foreach ($reviews as $review) {
                    echo '<li class="review-content">' . $review['review_text'] . '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p class="no-review">No reviews available.</p>';
            }
        }
        ?>

        <?php
        // Check if a user is logged in
        if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {
            // Check if the logged in user is the creator of the auction
            if ($_SESSION['user_id'] !== $auctionDetails['user_id']) {
                echo '<h2>Place Bid</h2>';
                require('addBid.php');
                echo '<br />';
                echo '<h2>Add Review</h2>';
                require('addReview.php');
            }
        }
        ?>
    </div>

    <a href="index.php" class="home">Return &#8594; </a>
</body>

</html>