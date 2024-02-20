<?php
session_start();
require_once "./navbar.php";
// Check if the user is logged in, redirect to login page if not
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once "./connection/database.php";

// Retrieve the exam ID from the URL
$exam_id = $_GET['exam_id'] ?? null;

// Validate exam ID
if (!$exam_id) {
    echo "Exam ID is missing.";
    exit();
}

// Retrieve exam details from the database
$sql = "SELECT * FROM exams WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $exam_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the exam exists
if ($result->num_rows === 0) {
    echo "Exam not found.";
    exit();
}

// Fetch exam details
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/script.js"></script>
    <title><?php echo $row['name']; ?></title>
</head>
<body>
    <div class="container">
        <h1 class="text-center"><?php echo $row['name']; ?></h1>
        <div class="mr-2">
            <p>Description: <?php echo $row['description']; ?></p>
            <a href="question_list.php?exam_id=<?php echo $row['id']; ?>"><button class="btn btn-primary">View Questions</button></a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-NzMaUSCQzZJNaaMlAXUiK3gcx3F/ySkOuH3e6FThTfE+1xHVthfMWqREwh2i9szN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-vadmuIJSWUCmZIU3CJEPm8T/5xOetm2vVj3F/rV+F4IvcYo/7DlyGjO74FN/CJzO" crossorigin="anonymous"></script>
</body>
</html>