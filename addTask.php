<?php
include "db.php";

if (isset($_POST['title'])) {
    $title = trim($_POST['title']);

    if ($title !== '') {
        $sql = "INSERT INTO tasks (title, status) VALUES (?, 'todo')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$title]);

        header("Location: dashboard.php?msg=Task added successfully");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Task</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
  <div class="card">
    <h2>Add New Task</h2>

    <form method="post" onsubmit="return validateForm();">
      <label for="title">Task Title</label>
      <input
        type="text"
        id="title"
        name="title"
        placeholder="Enter task title"
        required
      >

      <div class="actions">
        <button type="submit" class="btn-primary">Add Task</button>
        <a href="dashboard.php" class="btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>

<script>
  function validateForm() {
    const input = document.getElementById('title');

    if (!input.value.trim()) {
      alert('Task title cannot be empty.');
      input.focus();
      return false;
    }

    return true;
  }
</script>

</body>
</html>
