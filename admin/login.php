<?php
session_start();
require_once "./navbar.php";
if(isset($_SESSION["user"])){
    header("Location: dashboard.php");
    exit();
}
if(isset($_POST["login"])){
    require_once "./connection/database.php";

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM admin WHERE  email = '$email'";
    $result = mysqli_query($conn , $sql);

    if($user = $result->fetch_assoc()){
        if($password === $user["password"]){
            $_SESSION["user"] = "yes";
            header("Location: dashboard.php");
            exit();
        }
        else{
            echo "<div class='alert alert-danger'>Password does not match.</div>";
        }
    }
    else{
        echo "<div class='alert alert-danger'>Email does not exist.</div>";
    }
}
?>

<!-- <script>
    setTimeout(function(){
        let alertMessage  = document.querySelectorAll('.alert');
        alertMessage.forEach(function(message){
            message.style.display='none';
        });
    },2000);
</script> -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/script.js"></script>
    <title>Admin - Login</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Admin Login Form</h1>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" class="from-control" name ="email" placeholder="Email">
            </div>

            <div class="form-group">
                <input type="password" class="from-control" name ="password" placeholder="Password">
            </div>

            <div class="form-btn">
                <input type="submit" class="btn btn-primary" name ="login" value="Login">
            </div>
        </form>
    </div>
</body>
</html>