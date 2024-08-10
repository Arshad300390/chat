<?php
session_start();
include 'connect.php';
$name = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE name = '$name' AND password = '$password' LIMIT 1";

  $result = $conn->query($sql);

  // Check if a matching user was found
  if ($result->num_rows > 0) {
      // Fetch user data
      $user = $result->fetch_assoc();
      // Set session variables
      $_SESSION["username"] = $user["name"];
      $_SESSION["id"]=$user["id"];
      $_SESSION['img'] = $user['img']; // Assuming 'img' is a column in your table
      // Redirect to loginFrontend.php
      header("location:dashboard.php");
      exit();
  } else {
      // Handle login failure
      echo "Invalid username or password.";
  }
  
  $conn->close();
 
?>