<?php
include 'connect.php';
$name = $_POST['username'];
$password = $_POST['password'];
//$imgPath = $_POST['img'];
$target_dir = "img/";
$target_file = $target_dir . basename($_FILES["img"]["name"]);
echo $target_file;
if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["img"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
  $sql = "INSERT INTO users (name, password, img) VALUES ('$name', '$password', '$target_file')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
  header("location:loginFrontend.php");
?>