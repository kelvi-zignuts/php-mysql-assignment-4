<?php
session_start();
require_once "./navbar.php";
// require_once "./js/script.js";
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

require_once "./connection/database.php";

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
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Tests</h1>
        <!-- <a href="view_test.php" class="btn btn-primary">View</a> -->
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Discription</th>
                    <th>Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["name"];?></td>
                        <td><?php echo $row["description"];?></td>
                        <td><?php echo $row["level"];?></td>
                        <td>
                            <a href="edit_test.php?id=<?php echo $row["id"];?>" class="btn btn-primary">Edit</a>
                            <form action="dashboard.php" method="post" style="display:inline;">
                                <input type="hidden" name="exam_id" value="<?php echo $row["id"];?>">
                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                <a href="view_test.php?exam_id=<?php echo $row['id'];?>" class="btn btn-primary">View</a>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile;?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-NzMaUSCQzZJNaaMlAXUiK3gcx3F/ySkOuH3e6FThTfE+1xHVthfMWqREwh2i9szN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-vadmuIJSWUCmZIU3CJEPm8T/5xOetm2vVj3F/rV+F4IvcYo/7DlyGjO74FN/CJzO" crossorigin="anonymous"></script>

</body>
</html>