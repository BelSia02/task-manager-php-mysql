<?php
include "db.php";

if (isset($_GET["id"]) && isset($_GET["status"])) {
    $id = $_GET["id"];
    $status = $_GET["status"];

    // Only allow valid status
    if ($status === "todo" || $status === "done") {
        $sql = "UPDATE tasks SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$status, $id]);
    }
}

header("Location: dashboard.php");
exit;
