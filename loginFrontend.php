<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<div class="formDiv">
        <form action="loginBackend.php" method="post" >
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login" name="btnclick">
        </form>
    </div>
    <a href="http://localhost/chat">Register</a>

</body>
</html>