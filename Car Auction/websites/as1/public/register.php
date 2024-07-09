<?php
// Including the 'dbconnect.php' file to establish a database connection
require('dbconnect.php');

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $insert = $Connection->prepare(
    'insert into user (email, username, password) values (:email, :username, :password)'
  );

  // Check if the required POST variables are set
  if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $criteria = [
      'email'   => $_POST['email'],
      'username' => $_POST['username'],
      'password' => $hashedPassword,
    ];

    // Execute the prepared statement
    $insert->execute($criteria);

    if ($insert) {
      echo '<script>
          alert("User created. Login to continue.");
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
  <title>Sign Up</title>
  <!-- Internal CSS for Signup page -->
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 300px;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    label {
      display: block;
      margin-bottom: 5px;
      color: #333;
    }

    input {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      background-color: #007bff;
      color: #fff;
      padding: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }

    p {
      text-align: center;
      margin-top: 15px;
      color: #555;
    }

    a {
      color: #007bff;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <h1>Sign Up</h1>
  <form action="register.php" method="post">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required />
    <br />
    <label for="username">Username</label>
    <input type="text" name="username" id="username" required />
    <br />
    <label for="password">Password</label>
    <input type="password" name="password" id="password" required />
    <br />
    <button type="submit">Sign Up</button>
  </form>
  <p>Already have an account? <a href="login.php">Login to continue</a>.</p>
</body>

</html>