<?php
// Including the dbconnect.php file which connects the webpage to the database
require('dbconnect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="carbuy.css">
    <title>Carbuy Auctions</title>
    <style>
        div.search-result {
            margin: 20px;
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

        a.home:hover {
            background-color: #0056b3;
        }

        p.no-auction {
            font-family: "Arial", sans-serif;
            font-style: italic;
            font-size: 3em;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    // Include the header.php file that contains the header of the website
    require('header.php');
    ?>
    <br />
    <?php
    // If no search text is provided, redirect back to the home page
    if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST['search'])) {
        header('Location: index.php');
        exit();
    }

    // Check if the form was submitted and the search text is provided
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['search']) && isset($_POST['search'])) {
        $searchTerm = strtolower($_POST['search']);
        $title = '%' . strtolower($_POST['search']) . '%';
        // Prepare a SQL query to retrieve auction details including category name, username, and current bid (if any) for search results
        $search = $Connection->prepare('select a.auction_id, a.title, a.description, a.end_date, a.car_image, c.category_name, u.username, coalesce(MAX(b.bid_amount), 0) as current_bid
        from auction a
        left join category c on a.category_id = c.category_id
        left join user u on a.user_id = u.user_id
        left join bid b on a.auction_id = b.auction_id
        where lower(a.title) like :title
        group by a.auction_id, a.title, a.description, a.end_date, c.category_name, u.username, a.car_image');
        $search->bindParam(':title',  $title, PDO::PARAM_STR);
        $search->execute();
    }
    /// Check if the query executed successfully
    if ($search) {
        // Fetch the result rows
        $resultRows = $search->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($resultRows)) {
            echo '<div class="search-result">';
            echo '<h1>Search Results for "' . $searchTerm . '"</h1>';
            echo '<ul class="carList">';

            foreach ($resultRows as $row) {
                echo '<li>';
                // Display car image
                $imagePath = '/images/auction/' . $row['car_image'];
                $altText = $row['title'];
                // Check if the user had provided an image or not
                if (!empty($row['car_image'])) {
                    // Image path is provided, check for file existence
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
                        echo '<img src="' . $imagePath . '" alt="' . $altText . '">';
                    } else {
                        echo '<img src="/car.png" alt="Car Image">';
                    }
                } else {
                    // Image was not provided, display a placeholder
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
            echo '</div>';
        } else {
            echo '<p class = "no-auction">No auctions found for "' . $searchTerm . '".</p>';
        }
    }
    ?>
    <a href="index.php" class="home">Home &#8594; </a>
</body>

</html>