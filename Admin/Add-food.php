<?php
include("Partials/Navigation.php");
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
        // Query to get all categories from the `category` table
        $sql = "SELECT * FROM category WHERE Active='Yes'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $categories = [];
            echo "<div style='color: red;'>Failed to retrieve categories.</div>";
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Enter Food Title" required>
                    </td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" rows="5" placeholder="Enter Food Description" required></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" placeholder="Enter Food Price" step="0.01" required>
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category_id" required>
                            <option value="" disabled selected>Select a Category</option>
                            <?php
                            if (!empty($categories)) {
                                foreach ($categories as $category) {
                                    echo "<option value='" . $category['ID'] . "'>" . $category['Title'] . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Categories Available</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes" required> Yes
                        <input type="radio" name="active" value="No" required> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Get form data
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $active = $_POST['active'];

            // Handle image upload
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                $image_name = $_FILES['image']['name'];

                // Rename image
                $temp = explode('.', $image_name);
                $ext = end($temp);
                $image_name = "Food_Item_" . rand(000, 999) . '.' . $ext;

                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../Images/Food/" . $image_name;

                $upload = move_uploaded_file($source_path, $destination_path);

                if ($upload == false) {
                    $_SESSION['upload'] = "<div style='color: red;'>Failed to upload image.</div>";
                    header("location:" . HOMEURL . "admin/Add-food.php");
                    exit();
                }
            } else {
                $image_name = ""; // No image uploaded
            }

            // Insert into database
            $sql2 = "INSERT INTO item SET
                Title = '$title',
                Description = '$description',
                Price = $price,
                Image = '$image_name',
                Category_ID = $category_id,
                Active = '$active'";

            $result2 = mysqli_query($conn, $sql2);

            if ($result2) {
                $_SESSION['add'] = "<div style='color: green;'>Food Added Successfully.</div>";
                header("location:" . HOMEURL . "admin/Manage-food.php");
            } else {
                $_SESSION['add'] = "<div style='color: red;'>Failed to Add Food.</div>";
                header("location:" . HOMEURL . "admin/Add-food.php");
            }
        }
        ?>

    </div>
</div>

<?php
include("Partials/Footer.php");
?>
