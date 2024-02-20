<?php
session_start();
require_once "./navbar.php";
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

require_once "./connection/database.php";

if (!isset($_GET["exam_id"]) || empty($_GET["exam_id"])) {
    header("Location: view_test.php");
    exit();
}

$exam_id = $_GET["exam_id"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $question_text = $_POST["question_text"];
    $options = $_POST["options"];
    $correct_options = $_POST["correct_options"];

    $sql_insert_question = "INSERT INTO questions(exam_id,question_text) VALUES ($exam_id,'$question_text')";
    $conn->query($sql_insert_question);

    $question_id = $conn->insert_id;

    foreach($options as $key => $option_text){
        $is_right = in_array($key,$correct_options) ? 1 :0;
        $sql_insert_option ="INSERT INTO options (question_id,option_text,is_right) VALUES ($question_id , '$option_text',$is_right)";
        $conn->query($sql_insert_option);
    }
    header("Location: question_list.php?exam_id=$exam_id");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create MCQ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/script.js"></script>
</head>
<body>
    <div class="container mt-3">
        <h1 class="text-center">Create MCQ</h1>
        <form action="create_mcq.php?exam_id=<?php echo $exam_id;?>" method="post">
            <div class="mb-3">
                <label for="questionText" class="form-label">Question Text</label>
                <textarea class="form-control" id="questionText" name="question_text" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="options" class="form-label">Options</label>
                <input type="text" class="form-control mb-2" id="option1" name="options[]" placeholder="Option 1" required>
                <input type="text" class="form-control mb-2" id="option2" name="options[]" placeholder="Option 2" required>
                <input type="text" class="form-control mb-2" id="option3" name="options[]" placeholder="Option 3" required>
                <input type="text" class="form-control mb-2" id="option4" name="options[]" placeholder="Option 4" required>
            </div>
            <div class="mb-3">
                <label for="correctOptions" class="form-label">Correct Options</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="correct1" name="correct_options[]" value="0">
                    <label class="form-check-label" for="correct1">Option 1</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="correct2" name="correct_options[]" value="1">
                    <label class="form-check-label" for="correct2">Option 2</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="correct3" name="correct_options[]" value="2">
                    <label class="form-check-label" for="correct3">Option 3</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="correct4" name="correct_options[]" value="3">
                    <label class="form-check-label" for="correct4">Option 4</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create MCQ</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-NzMaUSCQzZJNaaMlAXUiK3gcx3F/ySkOuH3e6FThTfE+1xHVthfMWqREwh2i9szN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-vadmuIJSWUCmZIU3CJEPm8T/5xOetm2vVj3F/rV+F4IvcYo/7DlyGjO74FN/CJzO" crossorigin="anonymous"></script>
</body>
</html>