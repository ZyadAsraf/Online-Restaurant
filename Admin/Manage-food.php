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
    padding: 10px;
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
        <h1>Manage Food</h1>
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

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>

        <a href="Add-food.php" class="btn-success">Add Food</a>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Category</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            // Query to get all food items and their categories
            $sql = "SELECT item.ID, item.Title, item.Description, item.Price, item.Image, item.Active, category.Title AS CategoryTitle 
                    FROM item 
                    LEFT JOIN category ON item.Category_ID = category.ID";

            // Execute the query
            $result = mysqli_query($conn, $sql);

            // Check if the query execution was successful
            if ($result) {
                // Count the rows
                $count = mysqli_num_rows($result);

                if ($count > 0) {
                    // Loop through and display food items
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['ID'];
                        $title = $row['Title'];
                        $description = $row['Description'];
                        $price = $row['Price'];
                        $image_name = $row['Image'];
                        $category_title = $row['CategoryTitle'] ? $row['CategoryTitle'] : "No Category";
                        $active = $row['Active'];
                        ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $title; ?></td>
                            <td><?php echo $description; ?></td>
                            <td>$<?php echo $price; ?></td>
                            <td>
                                <?php
                                if ($image_name != "") {
                                    // Display the image
                                    echo "<img src='" . HOMEURL . "images/food/$image_name' class='img-thumbnail'>";
                                } else {
                                    echo "<div style='color: red;'>Image Not Added</div>";
                                }
                                ?>
                            </td>
                            <td><?php echo $category_title; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?php echo HOMEURL; ?>admin/Update-food.php?ID=<?php echo $id; ?>" class="btn-secondary"><i class="fa-solid fa-pen"></i></a>
                                <a href="<?php echo HOMEURL; ?>admin/Delete-food.php?ID=<?php echo $id; ?>" class="btn-danger"><i class="fa-regular fa-trash-can"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    // No food items found
                    echo "<tr><td colspan='8' style='color: red;'>No Food Items Added Yet</td></tr>";
                }
            } else {
                // Query failed
                echo "<tr><td colspan='8' style='color: red;'>Failed to retrieve food items. Error: " . mysqli_error($conn) . "</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php
include("Partials/Footer.php");
?>
