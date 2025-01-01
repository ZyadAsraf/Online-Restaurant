<?php

include("Partials/Navigation.php");
include("sse_function.php");

// Get incoming data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
}else{
    $_SESSION['add'] = "<div style='color: red;'>Failed to update order.</div>";
    header("Location: index.php");
}

// Update query
$sql = "UPDATE orders SET Status=? WHERE ID=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $order_id);

if ($stmt->execute()) {
    $_SESSION['add'] = "<div style='color: green;'>Order updated successfully.</div>";
    updateDatabaseAndNotifyClients();
    header("Location: index.php");
} else {
    $_SESSION['add'] = "<div style='color: red;'>Failed to update order.</div>";
    header("Location: index.php");
}

$stmt->close();
$conn->close();
?>