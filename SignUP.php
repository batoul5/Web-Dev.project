<?php
include_once 'conn.php';
include_once 'fun.php';

?>
<html>
<link rel="stylesheet" type="text/css" href="sin.css">
    <body>

<form action="SignUP.php" method="post">
  <h1>Sign Up</h1>

  <input type="text" name="username" placeholder="Username">
  <input type="text" name="email" placeholder="email">
  <input type="password" name="password" placeholder="Password">
  
  <input type="submit" name="SignUp" value="SignUp">

  <p>Already have an account? <a href="login.php">Login</a></p>
</form>
</body>
</html>
<?php
if(isset($_POST["SignUp"])){
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];

    if(empty($username)||empty($password)||empty($email)){
        return header("Location:SignUP.php?error empty input");
    }


    create_Uesr($conn,$username,$email,$password);
    header("Location:login.php?error empty input");
}

