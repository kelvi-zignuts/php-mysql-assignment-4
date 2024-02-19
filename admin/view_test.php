<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
require_once "./navbar.php";
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}
require_once "./connection/database.php";

if(isset($_GET['id'])){
    $exam_id = $_GET['id'];

    $sql = "SELECT * FROM exams WHERE id = $exam_id";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)>0){
        $exam = mysqli_fetch_assoc($result);
    }else{
        echo "Test not found";
        exit();
    }
}
else{
    echo "test id is missing";
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/script.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1><?php echo $exam["name"]?></h1>
        <p>Description : <?php echo $exam["description"]?></p>
        <a href="question_list.php?exam_id=<?php echo $exam['id'];?>"><button class="btn btn-primary">View Questions</button></a>
    </div>
</body>
</html>