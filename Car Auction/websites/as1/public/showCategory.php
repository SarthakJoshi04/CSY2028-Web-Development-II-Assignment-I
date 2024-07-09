<?php
// This page shows all the auctions related to a specific category
// Including the dbconnect.php file which connects the webpage to the database
require('dbconnect.php');
// Start the session (check if it's already started)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="carbuy.css" />
    <title>
        <?php
        // Retrieve the category name from the URL parameter
        $categoryName = isset($_GET['category']) ? htmlspecialchars($_GET['category'], ENT_QUOTES, 'UTF-8') : 'Default Title';
        echo $categoryName;
        ?>
    </title>
    <style>
        a.ed-button {
            text-decoration: none;
            color: #ffffff;
            font-weight: 500;
            padding: 0.3em;
            margin: 0.1em;
            border-radius: 0.3em;
            transition: all 0.1s ease-in-out 0s;
        }

        a.edit {
            background-color: #007b0f;
        }

        a.delete {
            background-color: #d91818;
        }

        a.edit:hover {
            background-color: #094510;
        }

        a.delete:hover {
            background-color: #4f0202;
        }

        a.home {
            display: block;
            margin-top: 10px;
            margin-left: 71vw;
            max-width: fit-content;
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }

        p.no-auction {
            font-family: "Arial", sans-serif;
            font-style: italic;
            font-size: 3em;
            padding: 10px;
            text-align: center;
        }

        a.home:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php
    require('header.php');
    ?>
    <main>
        <?php
        // Retrieve the category ID based on the category name
        $categoryName = isset($_GET['category']) ? $_GET['category'] : '';
        $categoryName = htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8');

        // Fetch the category ID from the database
        $categoryQuery = "select category_id from category where category_name = ?";
        $categoryStatement = $Connection->prepare($categoryQuery);
        $categoryStatement->execute([$categoryName]);
        $categoryId = $categoryStatement->fetchColumn();

        if ($categoryId !== false) {
            // Select relevant data from 'auction', 'category', and 'user' tables for active auctions within a specific category, ordered by end date.
            $sql = 'select a.auction_id, a.title, a.description, a.end_date, a.car_image, c.category_name, u.username, coalesce(MAX(b.bid_amount), 0) as current_bid
                from auction a
                left join category c on a.category_id = c.category_id
                left join user u on a.user_id = u.user_id
                left join bid b on a.auction_id = b.auction_id
                where a.category_id = ?
                and a.end_date > now()
                group by a.auction_id, a.title, a.description, a.end_date, c.category_name, u.username, a.car_image
                order by a.end_date asc;';

            // Execute the statement with the category ID as a parameter
            $result = $Connection->prepare($sql);
            $result->execute([$categoryId]);

            // Check if the query execution was successful
            if ($result !== false) {
                // Check if there are rows returned by the query
                if ($result->rowCount() > 0) {
                    echo '<h1>Latest Car Listings / Search Results / Category listing</h1>';
                    echo '<ul class="carList">';

                    // Loop through the fetched rows
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<li>';
                        // Display car image
                        $imagePath = '/images/auction/' . $row['car_image'];
                        $altText = $row['title'];
                        // Check if user had provided a image or not
                        if (!empty($row['car_image'])) {
                            // Image path is provided, check for file existence
                            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
                                echo '<img src="' . $imagePath . '" alt="' . $altText . '">';
                            } else {
                                echo '<img src="/car.png" alt="Car Image">';
                            }
                        } else {
                            // Image was not provided, display placeholder
                            echo '<img src="/car.png" alt="Car Image">';
                        }
                        echo '<article>';
                        // Display auction title
                        echo '<h2><b>' . $row['title'] . '</b></h2>';
                        echo '<br />';
                        // Display category name
                        echo '<h3>Category: ' . $row['category_name'] . '</h3>';
                        echo '<br />';
                        // Display auction description
                        echo '<p>' . $row['description'] . '</p>';
                        echo '<br />';
                        // Display auction end date
                        echo '<h3>End Date: ' . $row['end_date'] . '</h3>';
                        echo '<br />';
                        // Display auction creator's username
                        echo '<p>Created by: ' . $row['username'] . '</p>';
                        // Display current bid
                        echo '<p class="price">Current Bid: £';
                        // Check if there's a current bid
                        if (isset($row['current_bid'])) {
                            echo $row['current_bid'];
                        } else {
                            echo '0'; // Display 0 if no bids yet
                        }
                        echo '</p>';
                        echo '<br />';
                        if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {
                            // User is logged in
                            if ($_SESSION['username'] === $row['username']) {
                                // Logged in user created the auction, display edit and delete link
                                echo '<a href="editAuction.php?auction-id=' . $row['auction_id'] . '" class="ed-button edit">Edit</a>';
                                // Sends auction_id to deleteAuction.php page
                                echo '<a href="deleteAuction.php?auction-id=' . $row['auction_id'] . '" class="ed-button delete">Delete</a>';
                            }
                        }
                        // Display link to view more details of the auction
                        echo '<a href="viewAuction.php?auction-id=' . $row['auction_id'] . '" class="more auctionLink">More &gt;&gt;</a>';
                        echo '</article>';
                        echo '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p class="no-auction">No auctions found.</p>';
                }
            }
        }
        ?>
        <a href="index.php" class="home">Home Page &#8594; </a>
    </main>
</body>

</html>