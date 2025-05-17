<?php
// Allow cross-origin and JSON response
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include DB connection (adjust path)
include("../Config/Constant.php");

// Handle POST request only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["status" => "error", "message" => "Only POST method allowed"]);
    exit;
}

// Check if required fields are set
if (!isset($_POST['title'], $_POST['description'], $_POST['price'], $_POST['category_id'], $_POST['active'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

// Sanitize input
$title = mysqli_real_escape_string($conn, $_POST['title']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$price = floatval($_POST['price']);
$category_id = intval($_POST['category_id']);
$active = $_POST['active'] === 'Yes' ? 'Yes' : 'No';

// Handle image upload (optional)
$image_name = "";

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $file_tmp = $_FILES['image']['tmp_name'];
    $original_name = $_FILES['image']['name'];
    $ext = pathinfo($original_name, PATHINFO_EXTENSION);

    $image_name = "Food_Item_" . rand(100, 999) . '.' . $ext;
    $destination = "../Images/Food/" . $image_name;

    if (!move_uploaded_file($file_tmp, $destination)) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Failed to upload image"]);
        exit;
    }
}

// Insert into DB
$sql = "INSERT INTO item SET
        Title = '$title',
        Description = '$description',
        Price = $price,
        Image = '$image_name',
        Category_ID = $category_id,
        Active = '$active'";

$result = mysqli_query($conn, $sql);

if ($result) {
    http_response_code(201);
    echo json_encode(["status" => "success", "message" => "Food item added successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Failed to add food item: " . mysqli_error($conn)]);
}
?>
