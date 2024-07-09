<?php
// Including the dbconnect.php file which connects the webpage to the database
require('dbconnect.php');

// Check if the session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Check if the user has already placed a bid for this auction
if (isset($auctionId) && isset($_SESSION['user_id'])) {
    $checkBid = $Connection->prepare('select bid_amount from bid where auction_id = :auction_id and user_id = :user_id');
    $checkBid->bindParam(':auction_id', $auctionId, PDO::PARAM_INT);
    $checkBid->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $checkBid->execute();
    $existingBid = $checkBid->fetch(PDO::FETCH_ASSOC);

    if ($existingBid) {
        // User has already placed a bid, pre-fill the bid amount in the form
        $preFilledBidAmount = $existingBid['bid_amount'];
    }
}
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['auction-id'])) {
    $auctionId = $_POST['auction-id'];

    // Check if the user has already placed a bid for this auction
    if (isset($auctionId) && isset($_SESSION['user_id'])) {
        $checkBid = $Connection->prepare('select bid_id from bid where auction_id = :auction_id and user_id = :user_id');
        $checkBid->bindParam(':auction_id', $auctionId, PDO::PARAM_INT);
        $checkBid->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $checkBid->execute();
        $existingBidId = $checkBid->fetchColumn();

        if ($existingBidId) {
            // User has already placed a bid, update the existing bid with the new bid amount
            $update = $Connection->prepare('update bid set bid_amount = :bid_amount where bid_id = :bid_id');
            $update->bindParam(':bid_amount', $_POST['bid-amount'], PDO::PARAM_INT);
            $update->bindParam(':bid_id', $existingBidId, PDO::PARAM_INT);
            $success = $update->execute();

            // Display a JavaScript alert based on the operation
            if ($success) {
                echo '<script>
                    alert("Bid Updated");
                    window.location.href = "viewAuction.php?auction-id=' . $auctionId . '";
                </script>';
            }
        } else {
            // User has not placed a bid yet, insert a new bid
            $insert = $Connection->prepare('insert into bid (bid_amount, auction_id, user_id) values (:bid_amount, :auction_id, :user_id)');
            $insert->bindParam(':bid_amount', $_POST['bid-amount'], PDO::PARAM_INT);
            $insert->bindParam(':auction_id', $auctionId, PDO::PARAM_INT);
            $insert->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $success = $insert->execute();

            // Display a JavaScript alert based on the operation
            if ($success) {
                echo '<script>
                    alert("Bid Placed");
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bid</title>
    <style>
        div.add-bid {
            font-family: Arial, sans-serif;
        }

        form#add-bid {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: none;
        }

        input[type="number"] {
            width: fit-content;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #3498db;
            color: #fff;
            font-weight: bold;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .existing-bid {
            font-weight: bold;
            color: #27ae60;
            margin: 10px 0;
        }
    </style>

</head>

<body>
    <div class="add-bid">
        <form action="addBid.php" method="POST" id="add-bid">
            <input type="hidden" name="auction-id" value="<?php echo $auctionId; ?>">
            <?php echo isset($preFilledBidAmount) ? '<p class="existing-bid">Your Bid: £' . $preFilledBidAmount . '</p>' : ''; ?>
            <input type="number" name="bid-amount" id="bid-amount" placeholder="Enter bid" value="<?php echo isset($preFilledBidAmount) ? $preFilledBidAmount : ''; ?>">
            <button type="submit"><?php echo isset($preFilledBidAmount) ? 'Update Bid' : 'Place Bid'; ?></button>
        </form>
    </div>
</body>

</html>