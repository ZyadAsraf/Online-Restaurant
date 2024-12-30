<?php
include("Partials/Navigation.php");
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <?php
        // Check if ID is set in the URL
        if (isset($_GET['ID'])) {
            $id = $_GET['ID'];

            // Query to get details of the selected food
            $sql = "SELECT * FROM item WHERE ID = $id";
            $result = mysqli_query($conn, $sql);

            // Check if the query executed successfully
            if ($result && mysqli_num_rows($result) == 1) {
                // Get the data
                $row = mysqli_fetch_assoc($result);
                $title = $row['Title'];
                $description = $row['Description'];
                $price = $row['Price'];
                $current_image = $row['Image'];
                $category_id = $row['Category_ID'];
                $active = $row['Active'];
            } else {
                // Redirect if no food is found
                $_SESSION['update'] = "<div style='color: red;'>Food Not Found!</div>";
                header("location:" . HOMEURL . "admin/Manage-food.php");
                die();
            }
        } else {
            // Redirect if no ID is provided
            header("location:" . HOMEURL . "admin/Manage-food.php");
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            echo "<img src='" . HOMEURL . "Images/Food/$current_image' width='150'>";
                        } else {
                            echo "<div style='color: red;'>Image Not Added</div>";
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
                    <td>Category:</td>
                    <td>
                        <select name="category_id">
                            <?php
                            // Query to get all active categories
                            $sql_category = "SELECT * FROM category WHERE Active = 'Yes'";
                            $result_category = mysqli_query($conn, $sql_category);

                            if ($result_category && mysqli_num_rows($result_category) > 0) {
                                while ($row_category = mysqli_fetch_assoc($result_category)) {
                                    $category_id_option = $row_category['ID'];
                                    $category_title = $row_category['Title'];
                                    ?>
                                    <option value="<?php echo $category_id_option; ?>" <?php if ($category_id_option == $category_id) echo "selected"; ?>>
                                        <?php echo $category_title; ?>
                                    </option>
                                    <?php
                                }
                            } else {
                                echo "<option value='0'>No Categories Found</option>";
                            }
                            ?>
                        </select>
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
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Food">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Get the data from the form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $current_image = $_POST['current_image'];
            $active = $_POST['active'];

            // Check if a new image is uploaded
            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];

                if ($image_name != "") {
                    // Auto Rename Image
                    $temp = explode('.', $image_name);
                    $ext = end($temp);
                    $image_name = "Food_Item_" . rand(000, 999) . '.' . $ext;

                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../Images/Food/" . $image_name;

                    // Upload the new image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    if ($upload == false) {
                        $_SESSION['upload'] = "<div style='color: red;'>Failed to Upload New Image!</div>";
                        header("location:" . HOMEURL . "admin/Manage-food.php");
                        die();
                    }

                    // Remove the current image if it exists
                    if ($current_image != "") {
                        $remove_path = "../Images/Food/" . $current_image;
                        if (file_exists($remove_path)) {
                            unlink($remove_path);
                        }
                    }
                } else {
                    $image_name = $current_image;
                }
            } else {
                $image_name = $current_image;
            }

            // Update the food in the database
            $sql_update = "UPDATE item SET 
                Title = '$title',
                Description = '$description',
                Price = '$price',
                Image = '$image_name',
                Category_ID = '$category_id',
                Active = '$active'
                WHERE ID = $id";

            $result_update = mysqli_query($conn, $sql_update);

            // Redirect with success or failure message
            if ($result_update) {
                $_SESSION['update'] = "<div style='color: green;'>Food Updated Successfully</div>";
            } else {
                $_SESSION['update'] = "<div style='color: red;'>Failed to Update Food!</div>";
            }

            header("location:" . HOMEURL . "admin/Manage-food.php");
        }
        ?>
    </div>
</div>

<?php
include("Partials/Footer.php");
?>
