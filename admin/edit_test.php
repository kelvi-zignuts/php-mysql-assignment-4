<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
require_once "./navbar.php";
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}
require_once "./connection/database.php";
// $exam = null;
if(isset($_GET["id"])){
    $exam_id = $_GET["id"];

    // $exam_id = filter_var($exam_id, FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM exams WHERE id = $exam_id";
    $result = $conn->query($sql);
    $exam = $result->fetch_assoc();

    if(!$exam){
        echo "<div class='alert alert-danger'>test not found.</div>";
        // exit();
    }

    // if($result){
    //     if($result->num_rows>0){
    //         $exam = $result->fetch_assoc();
    //     }
    //     else{
    //         "<div class='alert alert-danger'>test not found.</div>";
    //     }
    // }
    // else{
    //     "<div class='alert alert-danger'>Error</div>";
    // }
}
else{
    "<div class='alert alert-alert'>test id not provided</div>";
    // exit();
}

if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $description = $_POST["description"];
    $level = $_POST["level"];

  
    // $name = filter_var($name, FILTER_SANITIZE_STRING);
    // $description = filter_var($description, FILTER_SANITIZE_STRING);
    // $level = filter_var($level, FILTER_SANITIZE_STRING);

    // $exam_id = filter_var($exam_id, FILTER_SANITIZE_NUMBER_INT);

    $sql = "UPDATE exams SET name = '$name',description='$description',level='$level' WHERE id = $exam_id";

    if($conn->query($sql)===TRUE){
        echo "<div class='alert alert-success'>test updated successfully.</div>";
        header("Location: showTest.php");
        
    }else{
        echo "<div class='alert alert-danger'>Error uploading test : " . $conn->error . "</div>";
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
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Edit test</h1>
        <form action="edit_test.php?id=<?php echo $exam_id;?>" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" value="<?php echo $exam["name"];?>" required>
            </div><br>

            <div class="from-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description"><?php echo $exam["description"];?></textarea>
            </div><br>

            <div class="from-group">
                <label for="level">Level:</label>
                <select name="level" class="form-control">
                    <option value="High" <?php if($exam["level"]=="High") echo "selected";?>>High</option>
                    <option value="Medium" <?php if($exam["level"]=="Medium") echo "selected";?>>Medium</option>
                    <option value="Low" <?php if($exam["level"]=="Low") echo "selected";?>>Low</option>
                </select>
            </div>
            <br>

            <div class="form-btn">
                <input type="submit" value="Submit" name="submit" class="btn btn-primary">
            </div>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-NzMaUSCQzZJNaaMlAXUiK3gcx3F/ySkOuH3e6FThTfE+1xHVthfMWqREwh2i9szN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-vadmuIJSWUCmZIU3CJEPm8T/5xOetm2vVj3F/rV+F4IvcYo/7DlyGjO74FN/CJzO" crossorigin="anonymous"></script>
</body>
</html>