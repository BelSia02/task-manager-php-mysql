<?php
include "db.php";

// Get task ID
if (!isset($_GET["id"])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET["id"];

// Fetch existing task
$sql = "SELECT * FROM tasks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$task = $stmt->fetch();

if (!$task) {
    header("Location: dashboard.php");
    exit;
}

// Update task when form submitted
if (isset($_POST["title"]) && isset($_POST["status"])) {
    $title = $_POST["title"];
    $status = $_POST["status"];

    $updateSql = "UPDATE tasks SET title = ?, status = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute([$title, $status, $id]);

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Task</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
  <div class="card">
    <h2>Edit Task</h2>

    <form method="post">
      <label for="title">Task Title</label>
      <input
        type="text"
        id="title"
        name="title"
        value="<?php echo htmlspecialchars($task['title']); ?>"
        required
      >

      <label for="status">Status</label>
      <select id="status" name="status">
        <option value="todo" <?php if ($task['status'] === 'todo') echo 'selected'; ?>>
          TO DO
        </option>
        <option value="done" <?php if ($task['status'] === 'done') echo 'selected'; ?>>
          DONE
        </option>
      </select>

      <div class="actions">
        <button type="submit" class="btn-primary">Update Task</button>
        <a href="dashboard.php" class="btn-secondary">Cancel</a>
      </div>
    </form>

  </div>
</div>

</body>
</html>
