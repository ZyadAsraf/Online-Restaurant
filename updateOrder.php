<?php

include("Partials-front/navegation.php");

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
    header("Location: myorders.php");
} else {
    $_SESSION['add'] = "<div style='color: red;'>Failed to update order.</div>";
    header("Location: myorders.php");
    
}

$stmt->close();
$conn->close();
?>