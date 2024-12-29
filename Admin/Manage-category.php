<?php
include("Partials/Navigation.php");
?>

<style>
/* Styling for the table */
.tbl-full {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 18px;
    text-align: left;
    background-color: #f9f9f9;
}

.tbl-full th,
.tbl-full td {
   
    border: 1px solid #ddd;
}

.tbl-full th {
    background-color: #ff4d4d; /* Header background color */
    color: white;
    font-weight: bold;
    text-transform: uppercase;
}



.img-thumbnail {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
    border: 1px solid #ddd;
}

/* Center the main content */
.main-content {
    text-align: center;
    font-family: Arial, sans-serif;
}

.wrapper {
    width: 90%;
    margin: auto;
}
</style>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage-Categories</h1>
        <br><br>

        <?php
        // Display session messages if any
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        ?>

        <a href="Add-category.php" class="btn-success">Add Categ</a>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            // Query to get all categories from database
            $sql = "SELECT * FROM category";

            // Execute the query
            $result = mysqli_query($conn, $sql);

            // Check if the query execution was successful
            if ($result) {
                // Count the rows
                $count = mysqli_num_rows($result);

                if ($count > 0) {
                    // Loop through and display categories
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['ID'];
                        $title = $row['Title'];
                        $image_name = $row['Image'];
                        $featured = $row['Featured'];
                        $active = $row['Active'];
                        ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $title; ?></td>
                            <td>
                                <?php
                                if ($image_name != "") {
                                    // Display the image
                                    echo "<img src='" . HOMEURL . "images/category/$image_name' class='img-thumbnail'>";
                                } else {
                                    echo "<div style='color: red;'>Image Not Added</div>";
                                }
                                ?>
                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="#" class="btn-secondary"><i class="fa-solid fa-pen"></i></a>
                                <a href="<?php echo HOMEURL; ?>admin/Delete-category.php?ID=<?php echo $id; ?>" class="btn-danger"><i class="fa-regular fa-trash-can"></i></a>

                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    // No categories found
                    echo "<tr><td colspan='6' style='color: red;'>No Categories Added Yet</td></tr>";
                }
            } else {
                // Query failed
                echo "<tr><td colspan='6' style='color: red;'>Failed to retrieve categories. Error: " . mysqli_error($conn) . "</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php
include("Partials/Footer.php");
?>
