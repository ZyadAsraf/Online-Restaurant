<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include DB connection
include("../Config/Constant.php");

// Only accept PUT
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Only PUT method allowed"]);
    exit;
}
    
// Read raw input
$input = json_decode(file_get_contents("php://input"), true);

// Validate required fields
$required = ['id', 'title', 'description', 'price', 'category_id', 'active'];
foreach ($required as $field) {
    if (!isset($input[$field])) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Missing required field: $field"]);
        exit;
    }
}

// Sanitize
$id = intval($input['id']);
$title = mysqli_real_escape_string($conn, $input['title']);
$description = mysqli_real_escape_string($conn, $input['description']);
$price = floatval($input['price']);
$category_id = intval($input['category_id']);
$active = $input['active'] === 'Yes' ? 'Yes' : 'No';
$image = mysqli_real_escape_string($conn, $input['image'] ?? ''); // Optional image filename

// Update query
$sql = "UPDATE item SET 
    Title = '$title',
    Description = '$description',
    Price = $price,
    Image = '$image',
    Category_ID = $category_id,
    Active = '$active'
    WHERE ID = $id";

$result = mysqli_query($conn, $sql);

if ($result) {
    http_response_code(200);
    echo json_encode(["status" => "success", "message" => "Food item updated successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Failed to update food item: " . mysqli_error($conn)]);
}
?>
