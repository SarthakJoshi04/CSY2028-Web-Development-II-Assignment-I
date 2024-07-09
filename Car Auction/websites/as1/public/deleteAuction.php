<?php
// Including the dbconnect.php file which connects the webpage to the database
require('dbconnect.php');
// Starting the session
session_start();

if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) {
    // Check if the auction ID is provided in the URL
    if (isset($_GET['auction-id'])) {
        $auctionId = $_GET['auction-id'];

        // Delete associated bids first
        $sqlDeleteBids = 'delete from bid where auction_id = :auction_id';
        $stmtDeleteBids = $Connection->prepare($sqlDeleteBids);
        $stmtDeleteBids->bindParam(':auction_id', $auctionId, PDO::PARAM_INT);

        if ($stmtDeleteBids->execute()) {
            // Bids successfully deleted, now delete the auction
            $sqlDeleteAuction = 'delete from auction where auction_id = :auction_id';
            $stmtDeleteAuction = $Connection->prepare($sqlDeleteAuction);
            $stmtDeleteAuction->bindParam(':auction_id', $auctionId, PDO::PARAM_INT);

            if ($stmtDeleteAuction->execute()) {
                // Auction successfully deleted, redirect to the homepage
                header('Location: index.php');
                exit();
            } else {
                // Handle auction deletion error
                echo '<script>alert("Error deleting auction")</script>';
            }
        } else {
            // Handle bid deletion error
            echo '<script>alert("Error deleting bids")</script>';
        }
    }
}
