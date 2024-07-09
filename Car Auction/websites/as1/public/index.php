<?php
// Including the dbconnect.php file which connects the webpage to the database
require('dbconnect.php');
// Starting the session
session_start();
?>
<!DOCTYPE html>
<html>

<head>
	<title>Carbuy Auctions</title>
	<link rel="stylesheet" href="carbuy.css" />
	<style>
		a.add-auction {
			background-color: #007bff;
			text-decoration: none;
			color: #ffffff;
			font-weight: 500;
			padding: 0.3em;
			display: block;
			max-width: fit-content;
			margin: 1em;
			border-radius: 0.3em;
			transition: all 0.1s ease-in-out 0s;
		}

		a.add-auction:hover {
			background-color: #0056b3;
		}

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
	</style>
</head>

<body>
	<?php
	// Include the header.php file that contains the header of the website
	require('header.php');
	?>
	<img src="banners/2.jpg" alt="Banner" />

	<main>
		<?php
		// Select relevant data from 'auction', 'category', and 'user' tables for active auctions, ordered by end date.
		$sql = "select a.*, c.category_name, u.username, max(b.bid_amount) as current_bid
		from auction a
		join category c on a.category_id = c.category_id
		join user u on a.user_id = u.user_id
		left join bid b on a.auction_id = b.auction_id
		where a.end_date > now()
		group by a.auction_id
		order by a.auction_id desc
		limit 10;";

		// Execute the statement
		$result = $Connection->query($sql);

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
			}
		}
		?>

		<hr />
		<?php
		// Check if a user is logged in
		if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {
			echo '<a href="addAuction.php" class="add-auction">Add Auction &#8594;</a>';
		}
		?>

		<?php
		// Includes footer.php file which contains footer of the webisite
		require('footer.php');
		?>
	</main>
</body>

</html>