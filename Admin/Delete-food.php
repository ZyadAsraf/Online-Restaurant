<?php
include("Partials/Navigation.php");

// Check if the ID is set in the URL
if (isset($_GET['ID'])) {
    // Get the ID of the food to be deleted
    $id = $_GET['ID'];

    // Query to get the details of the selected food item
    $sql = "SELECT Image FROM item WHERE ID = $id";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Check whether the food item exists
        $count = mysqli_num_rows($result);

        if ($count == 1) {
            // Get the data (image name)
            $row = mysqli_fetch_assoc($result);
            $image_name = $row['Image'];

            // Remove the image file if it exists
            if ($image_name != "") {
                $image_path = "../Images/Food/" . $image_name;

                // Check if the file exists and delete it
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            // Query to delete the food item from the database
            $sql_delete = "DELETE FROM item WHERE ID = $id";
            $result_delete = mysqli_query($conn, $sql_delete);

            // Check if the query executed successfully
            if ($result_delete) {
                // Set success message
                $_SESSION['delete'] = "<div style='color: green;'>Food Item Deleted Successfully</div>";
            } else {
                // Set failure message
                $_SESSION['delete'] = "<div style='color: red;'>Failed to Delete Food Item. Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            // Set message if the food item does not exist
            $_SESSION['delete'] = "<div style='color: red;'>Food Item Not Found</div>";
        }
    } else {
        // Set failure message for the query
        $_SESSION['delete'] = "<div style='color: red;'>Failed to Retrieve Food Details. Error: " . mysqli_error($conn) . "</div>";
    }
} else {
    // Redirect if no ID is provided in the URL
    $_SESSION['delete'] = "<div style='color: red;'>Unauthorized Access</div>";
}

// Redirect to the Manage Food page
header("location:" . HOMEURL . "admin/Manage-food.php");
?>
