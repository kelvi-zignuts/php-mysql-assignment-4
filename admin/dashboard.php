<?php
session_start();
require_once "./navbar.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
require_once "./connection/database.php";

if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $description = $_POST["discription"];
    $level=$_POST["level"];

    $sql = "INSERT INTO exams (name, description, level) VALUES ('$name','$description','$level')";

    if($conn->query($sql)===True){
        echo "<div class='alert alert-success'>test ctreated successfully.</div>";
    }
    else{
        echo "<div class='alert alert-danger'>Error creating test: " . $conn->error . "</div>";
    }
}
if(isset($_POST["delete"])){
    $exam_id = $_POST["exam_id"];
     
    $sql = "DELETE FROm exams WHERE id = '$exam_id'";

    if($conn->query($sql)===True){
        echo "<div class='alert alert-success'>Test deleted successfully.</div>";
    }
    else{
        echo "<div class='alert alert-danger'>Error deleting test: " . $conn->error . "</div>";
    }
}
$sql = "SELECT * FROM exams";
$result = $conn->query($sql);
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
    <title>Admin - Dashboard</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Create Test</h1>
        <form action="dashboard.php" method="post">
            <div class="from-group">
                <label for="name">Name:</label>
                <textarea type="text" class="form-control" name="name"></textarea>
            </div><br>

            <div class="from-group">
                <label for="description">Description:</label>
                <textarea type="text" class="form-control" name="discription"></textarea>
            </div><br>

            <div class="from-group">
                <label for="level">Level:</label>
                <select name="level" class="form-control">
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
            </div>
            <br>

            <div class="form-btn">
                <input type="submit" value="Submit" name="submit" class="btn btn-primary">
            </div>
            <!-- <a href="logout.php"></a> -->
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-NzMaUSCQzZJNaaMlAXUiK3gcx3F/ySkOuH3e6FThTfE+1xHVthfMWqREwh2i9szN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-vadmuIJSWUCmZIU3CJEPm8T/5xOetm2vVj3F/rV+F4IvcYo/7DlyGjO74FN/CJzO" crossorigin="anonymous"></script>
</body>
</html>