<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['username'])) {
    // If session variable 'username' is not set, redirect to login page
    header("location:loginFrontend.php");
    exit('no session');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- jQuery library is required. -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!-- Include our script file. -->
    <script type="text/javascript" src="script.js"></script>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        span {
            font-weight: bolder;
            text-align: center;
        }

        .logout-link {
            float: right;
        }

        .chat_link {
            font-size: larger;
            padding: 10px;
            margin-left: 0px;
        }

        #display {
            margin-right: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <span class="dashboard">Dashboard <?php echo $_SESSION['username']; ?></span>
        <a class="logout-link" href="http://localhost/chat/logout.php" class="logout">Logout</a>
    </div>
    <input type="text" id="search" placeholder="Search" onkeyup="filterUsers()" />

    <!-- Suggestions will be displayed in the following div. -->
    <div id="display">
        <?php
        // Define the query to select users excluding the current session user.
        $sql = "SELECT * FROM users WHERE name <> '" . $_SESSION['username'] . "'";
        $result = $conn->query($sql);

        // Check if there are results.
        if ($result->num_rows > 0) {
            // Loop through and display each user.
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="user">
                    <a class="chat_link" href="http://localhost/chat/chat.php?cid=<?php echo $row['id']; ?>">
                        <?php echo $row["name"]; ?>
                    </a>
                </div>
        <?php
            }
        }
        ?>
    </div>

    <script>
        function filterUsers() {
            var input, filter, displayDiv, users, a, i, txtValue;
            input = document.getElementById('search');
            filter = input.value.toUpperCase();
            displayDiv = document.getElementById('display');
            users = displayDiv.getElementsByClassName('user');

            for (i = 0; i < users.length; i++) {
                a = users[i].getElementsByTagName('a')[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    users[i].style.display = "";
                } else {
                    users[i].style.display = "none";
                }
            }
        }
    </script>
</body>

</html>
