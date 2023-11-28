<?php
include_once "conn.php";
include_once "fun.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update"])) {
        $email = $_POST['email'];
        $newPassword = $_POST['new_password'];

        if (empty($email) || empty($newPassword)) {
            echo "Please enter both email and new password.";
        } else {
            // Update the user's password in the database
            $sql = "UPDATE signup SET password = ? WHERE email = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $newPassword, $email);
            mysqli_stmt_execute($stmt);

            // Redirect to a login page or any other desired location
            header("Location: login.php");
            exit;
        }
    }

    if (isset($_POST["delete"])) {
        $email = $_POST['email'];

        if (empty($email)) {
            echo "Please enter an email.";
        } else {
            // Delete the user from the database
            $sql = "DELETE FROM signup WHERE email = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            // Redirect to a login page or any other desired location
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Update User Information</h1>
    <form action="update.php" method="post">
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="new_password" placeholder="New Password">
        <input type="submit" name="update" value="Update">
    </form>

    <h1>Delete User Information</h1>
    <form action="update.php" method="post">
        <input type="text" name="email" placeholder="Email">
        <input type="submit" name="delete" value="Delete">
    </form>
</body>
</html>