 <?php
 include_once "conn.php";
 function create_Uesr($conn,$username,$email,$password){
    
    $sql_ins="INSERT INTO signup(name,email,password) VALUES (?,?,?);";
    
    $stmt=mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql_ins)){
       
        header("Location:SignUP.php?error=sqlerror");
        exit();
    }
   
   
        mysqli_stmt_bind_param($stmt,"sss",$username,$email,$password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location:SignUP.php?error=none");
        
}

  