<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

require_once "./connection/database.php";

if (!isset($_GET["question_id"]) || empty($_GET["question_id"])) {
    header("Location:question_list.php");
    exit();
}

$question_id = $_GET["question_id"];

$sql = "SELECT * FROM questions WHERE id = $question_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Question not found";
    exit();
}

$row = $result->fetch_assoc();
$question_text = $row["question_text"];

$options_sql = "SELECT * FROM options WHERE question_id = $question_id";
$options_result = $conn->query($options_sql);
$options = [];

while ($option = $options_result->fetch_assoc()) {
    $options[] = $option;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $edited_question_text = $_POST["question_text"];
    $edited_options = $_POST["options"];
    $edited_correct_options = $_POST["correct_options"];

    $update_question_sql = "UPDATE questions SET question_text = '$edited_question_text' WHERE id = $question_id";
    $conn->query($update_question_sql);

    $delete_options_sql = "DELETE FROM options WHERE question_id = $question_id";
    $conn->query($delete_options_sql);

    foreach ($edited_options as $index => $option_text) {
        $is_right = in_array($index, $edited_correct_options) ? 1 : 0;
        $insert_option_sql = "INSERT INTO options (question_id, option_text, is_right) VALUES ($question_id, '$option_text', $is_right)";
        $conn->query($insert_option_sql);
    }

    header("Location:question_list.php?exam_id=" . $row['exam_id']);
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-3">
        <h1 class="text-center">Edit Question</h1>
        <form action="edit_question.php?question_id=<?php echo $question_id;?>" method="post">
            <div class="mb-3">
                <label for="questionText" class="form-label">Question Text</label>
                <textarea class="form-control" id="questionText" name="question_text" rows="3" required><?php echo $question_text; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="options" class="form-label">Options</label>
                <?php foreach ($options as $index => $option): ?>
                    <input type="text" class="form-control mb-2" name="options[]" value="<?php echo $option['option_text']; ?>" required>
                <?php endforeach; ?>
            </div>
            <div class="mb-3">
                <label for="correctOptions" class="form-label">Correct Options</label><br>
                <?php foreach ($options as $index => $option): ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="correct_options[]" value="<?php echo $index; ?>" <?php if ($option['is_right'] == 1) echo "checked"; ?>>
                        <label class="form-check-label"><?php echo $option['option_text']; ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-NzMaUSCQzZJNaaMlAXUiK3gcx3F/ySkOuH3e6FThTfE+1xHVthfMWqREwh2i9szN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-vadmuIJSWUCmZIU3CJEPm8T/5xOetm2vVj3F/rV+F4IvcYo/7DlyGjO74FN/CJzO" crossorigin="anonymous"></script>
</body>
</html>