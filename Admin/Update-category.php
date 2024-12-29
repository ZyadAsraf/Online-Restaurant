<?php include('Partials/Navigation.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Edit Category</h1>
        <br><br>

        <?php
        // Get ID of the Category
        if (isset($_GET['ID'])) {
            $id = $_GET['ID'];

            // Create SQL Query to Get Category Details
            $sql = "SELECT * FROM category WHERE ID = $id";

            // Execute the Query
            $result = mysqli_query($conn, $sql);

            // Check if the query is executed
            if ($result == true) {
                // Check if category data is available
                $count = mysqli_num_rows($result);
                if ($count == 1) {
                    // Get Category Details
                    $row = mysqli_fetch_assoc($result);

                    $title = $row['Title'];
                    $current_image = $row['Image'];
                    $active = $row['Active'];
                    $featured = $row['Featured'];
                } else {
                    // Redirect to Manage Category Page if no category found
                    header("location:" . HOMEURL . 'admin/Manage-category.php');
                    exit;
                }
            } else {
                echo "<div style='color: red;'>Failed to fetch category details</div>";
            }
        } else {
            header("location:" . HOMEURL . 'admin/Manage-category.php');
            exit;
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php 
                        if ($current_image != "") {
                            // Display the image
                            echo "<img src='" . HOMEURL . "images/category/" . $current_image . "' width='100px'>";
                        } else {
                            echo "<div style='color: red;'>Image not added</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if ($featured == "Yes") echo "checked"; ?>> Yes
                        <input type="radio" name="featured" value="No" <?php if ($featured == "No") echo "checked"; ?>> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if ($active == "Yes") echo "checked"; ?>> Yes
                        <input type="radio" name="active" value="No" <?php if ($active == "No") echo "checked"; ?>> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    // Get all the data from the form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    // Check if a new image is selected
    if (isset($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];

        if ($image_name != "") {
            // Auto-rename the image
            $ext = end(explode('.', $image_name));
            $image_name = "Category_" . rand(000, 999) . '.' . $ext;

            // Upload the new image
            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../Images/Category/" . $image_name;

            $upload = move_uploaded_file($source_path, $destination_path);

            if ($upload == false) {
                $_SESSION['upload'] = "<div style='color: red;'>Failed to upload new image</div>";
                header("location:" . HOMEURL . 'admin/Manage-category.php');
                exit;
            }

            // Remove the current image if available
            if ($current_image != "") {
                $remove_path = "../Images/Category/" . $current_image;
                unlink($remove_path);
            }
        } else {
            $image_name = $current_image;
        }
    } else {
        $image_name = $current_image;
    }

    // Update the database
    $sql = "UPDATE category SET
            Title = '$title',
            Image = '$image_name',
            Featured = '$featured',
            Active = '$active'
            WHERE ID = $id";

    $result = mysqli_query($conn, $sql);

    // Check if the query is executed successfully
    if ($result == true) {
        $_SESSION['update'] = "<div style='color: green;'><strong><h3>Category Updated Successfully</h3></strong></div>";
        header("location:" . HOMEURL . 'admin/Manage-category.php');
        exit;
    } else {
        $_SESSION['update'] = "<div style='color: red;'>Failed to Update Category!</div>";
        header("location:" . HOMEURL . 'admin/Manage-category.php');
        exit;
    }
}
?>

<?php include('Partials/Footer.php'); ?>
