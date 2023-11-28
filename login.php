<?php
include_once "conn.php";
include_once "fun.php";

if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($password) || empty($email)) {
        header("Location: login.php?error=empty_input");
        exit;
    }

    // Check if the user exists in the database.
    $sql = "SELECT * FROM signup WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("Error in preparing SQL statement: " . mysqli_stmt_error($stmt));
    }
    
    mysqli_stmt_bind_param($stmt, "s", $email);

    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    // Get the result
    $result = mysqli_stmt_get_result($stmt);
    
    // If the user does not exist, redirect to the login page
    if ($result->num_rows == 0) {
        header("Location: login.php?error=user_not_found");
        exit;
    }
    
    // Get the user's password from the database
    $row = mysqli_fetch_assoc($result);
    $db_password = $row["password"];
    
    // Check if the password is correct
    if ($db_password != $password) {
        header("Location: login.php?error=incorrect_password");
        exit;
    }
    
    // Successful login, redirect to start.html
    header("Location: start.html");
    exit;
}
?>

<html>
<link rel="stylesheet" type="text/css" href="lo.css">

<body>
    <form action="login.php" method="post">
        <h1>Login</h1>
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>
