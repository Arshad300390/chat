<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="formDiv">
        <form action="register.php" method="post" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="file" id="img" name="img"><br><br>
            <input type="submit" value="Register" name="btnclick">
        </form>
    </div>

    <a href="http://localhost/chat/loginFrontend.php">login</a>
</body>

</html>