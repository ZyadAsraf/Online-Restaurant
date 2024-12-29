<?php
// Include the constant configuration file
include('../config/Constant.php');

// Check if the ID is set in the GET request
if (isset($_GET['ID'])) {
    // Get the ID of the category to be deleted
    $id = $_GET['ID'];

    // First, remove the image file if it exists
    // SQL query to get the image name for the category
    $image_query = "SELECT Image FROM category WHERE ID = $id";
    $image_result = mysqli_query($conn, $image_query);

    if ($image_result) {
        $image_row = mysqli_fetch_assoc($image_result);
        $image_name = $image_row['Image'];

        if ($image_name != "") {
            // Image exists, so delete it from the folder
            $image_path = "../Images/Category/" . $image_name;
            if (file_exists($image_path)) {
                unlink($image_path); // Delete the image file
            }
        }
    }

    // Create SQL query to delete the category
    $sql = "DELETE FROM category WHERE ID = $id";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check whether the query executed successfully
    if ($result == TRUE) {
        // Query executed successfully, category deleted
        $_SESSION['delete'] = "<div style='color: green;'><h2><strong>Category Deleted Successfully</h2></strong></div>";
    } else {
        // Failed to delete category
        $_SESSION['delete'] ="<div style='color: red;'><h2><strong>Failed to Delete Category!</h2></strong></div>";
    }
} else {
    // Redirect to Manage Category page if no ID is set
    $_SESSION['delete'] = "<div style=\"color: red\">Unauthorized Access</div>";
}

// Redirect to Manage Category page
header('location:' . HOMEURL . 'Admin/Manage-category.php');
?>
