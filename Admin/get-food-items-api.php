<?php
// Set headers to allow CORS and return JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include DB connection
include("../Config/Constant.php"); // Adjust this to your DB connection file

$response = [];

$sql = "SELECT item.ID, item.Title, item.Description, item.Price, item.Image, item.Active, category.Title AS CategoryTitle 
        FROM item 
        LEFT JOIN category ON item.Category_ID = category.ID";

$result = mysqli_query($conn, $sql);

if ($result) {
    $foods = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $foods[] = [
            "id" => $row['ID'],
            "title" => $row['Title'],
            "description" => $row['Description'],
            "price" => $row['Price'],
            "image" => $row['Image'],
            "category" => $row['CategoryTitle'] ? $row['CategoryTitle'] : "No Category",
            "active" => $row['Active']
        ];
    }

    echo json_encode([
        "status" => "success",
        "data" => $foods
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database query failed: " . mysqli_error($conn)
    ]);
}
?>
