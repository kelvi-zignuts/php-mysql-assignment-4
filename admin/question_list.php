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

// Check if exam_id is provided
if (!isset($_GET["exam_id"]) || empty($_GET["exam_id"])) {
    header("Location: view_test.php");
    exit();
}

$exam_id = $_GET["exam_id"];

// Retrieve questions for the selected exam from the database
$sql = "SELECT * FROM questions WHERE exam_id = $exam_id";
$result = $conn->query($sql);

// Delete question if the delete button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_question_id"])) {
    $delete_question_id = $_POST["delete_question_id"];
    $delete_sql = "DELETE FROM questions WHERE id = $delete_question_id";
    if ($conn->query($delete_sql) === TRUE) {
        $_SESSION['success_message'] = 'Question deleted successfully.';
    } else {
        $_SESSION['error_message'] = 'Failed to delete question. Please try again.';
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
    <title>View Questions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/script.js"></script></head>
<body>
    <div class="container1 mt-3">
        <h1 class="text-center">Questions</h1>
        <a href="view_test.php?exam_id=<?php echo $exam_id;?>"  class="btn btn-primary mb-3">Back to exams</a>
        <a href="create_mcq.php?exam_id=<?php echo $exam_id; ?>" class="btn btn-success mb-3">Create MCQ</a>
        <?php
        // Display success or error message if set
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
        } elseif (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Options</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["question_text"]; ?></td>
                        <td>
                            <?php
                            // Retrieve options for the current question
                            $options_sql = "SELECT * FROM options WHERE question_id = {$row['id']}";
                            $options_result = $conn->query($options_sql);
                            while ($option = $options_result->fetch_assoc()) {
                                echo "<div>";
                                echo $option["option_text"];
                                if ($option["is_right"] == 1) {
                                    echo " (Correct)";
                                }
                                echo "</div>";
                            }
                            ?>
                        </td>
                        <td>
                            <a href="edit_question.php?question_id=<?php echo $row["id"]; ?>" class="btn btn-primary">Edit</a>
                            <form action="" method="post" style="display: inline;">
                                <input type="hidden" name="delete_question_id" value="<?php echo $row["id"]; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-NzMaUSCQzZJNaaMlAXUiK3gcx3F/ySkOuH3e6FThTfE+1xHVthfMWqREwh2i9szN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-vadmuIJSWUCmZIU3CJEPm8T/5xOetm2vVj3F/rV+F4IvcYo/7DlyGjO74FN/CJzO" crossorigin="anonymous"></script>
</body>
</html>