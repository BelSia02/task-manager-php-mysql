<?php
include "db.php";

if (isset($_GET['search']) && $_GET['search'] !== '') {
    $search = '%' . $_GET['search'] . '%';
    $sql = "SELECT * FROM tasks WHERE title LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$search]);
    $tasks = $stmt->fetchAll();
} else {
    $sql = "SELECT * FROM tasks";
    $result = $conn->query($sql);
    $tasks = $result->fetchAll();
}

$no = 1;
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>
<body>

<h1>My Task List</h1>

<br>

<form method="get" class="search-form">
  <input
    type="text"
    name="search"
    placeholder="Search tasks..."
    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
  >
  
  <button type="submit" class="btn-submit">Search</button>
  <a href="dashboard.php" class="btn-reset">Reset</a>
</form>

<br><br>
<a href="addTask.php" class="btn-add">Add Task</a>
<br><br><br>

        <?php if (isset($_GET['msg'])): ?>
        <div id="flash-message">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
        <?php endif; ?>

<table border="1" cellpadding="10">
  <tr>
    <th>No</th>
    <th>Title</th>
    <th>Status</th>
    <th>Action</th>
  </tr>

  <?php if (count($tasks) > 0): ?>
    <?php foreach ($tasks as $task): ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $task["title"]; ?></td>
        <td class="<?php echo $task['status']; ?>">
            <?php
                if ($task['status'] === 'todo') {
                    echo 'TO DO';
                } else {
                    echo 'DONE';
                }
            ?>
        </td>
        <td>
            <?php if ($task['status'] === 'todo'): ?>
                <a href="updateStatus.php?id=<?php echo $task['id']; ?>&status=done"
                onclick="return confirmStatus();">
                Mark <b>Done</b>
                </a>
            <?php else: ?>
                <a href="updateStatus.php?id=<?php echo $task['id']; ?>&status=todo"
                onclick="return confirmStatus();">
                Mark <b>To Do</b>
                </a>
            <?php endif; ?>
            |
            <a href="editTask.php?id=<?php echo $task['id']; ?>">Edit</a>
            |
            <a href="deleteTask.php?id=<?php echo $task['id']; ?>"
                onclick="return confirm('Delete this task?')">
                Delete
            </a>
        </td>
      </tr>
      <?php $no++; ?>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="4">No tasks found</td>
    </tr>
  <?php endif; ?>

</table>

<script>
  function confirmStatus() {
    return confirm('Are you sure you want to change the task status?');
  }
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.search-form input');
    if (searchInput) {
      searchInput.focus();
    }
  });
</script>

<script>
  const flash = document.getElementById('flash-message');
  if (flash) {
    setTimeout(() => {
      flash.style.display = 'none';
    }, 3000);
  }
</script>

</body>
</html>
