<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include("../Config/Constant.php");

// Only allow DELETE requests
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Only DELETE method is allowed"]);
    exit;
}

// Read input data (raw JSON from body)
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['id'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Missing required field: id"]);
    exit;
}

$id = intval($input['id']);

// Fetch image name
$sql = "SELECT Image FROM item WHERE ID = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) !== 1) {
    http_response_code(404);
    echo json_encode(["status" => "error", "message" => "Food item not found"]);
    exit;
}

$row = mysqli_fetch_assoc($result);
$image_name = $row['Image'];

// Delete image file if it exists
if (!empty($image_name)) {
    $image_path = "../Images/Food/" . $image_name;
    if (file_exists($image_path)) {
        unlink($image_path);
    }
}

// Delete the food item from the DB
$sql_delete = "DELETE FROM item WHERE ID = $id";
$result_delete = mysqli_query($conn, $sql_delete);

if ($result_delete) {
    http_response_code(200);
    echo json_encode(["status" => "success", "message" => "Food item deleted successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Failed to delete food item"]);
}
?>
