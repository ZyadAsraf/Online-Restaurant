<?php
include('partials-front/navegation.php')
?>
<?php
// Check if the ID is set in the URL
if (isset($_GET['ID'])) {
    // Get the ID from the URL
    $id = $_GET['ID'];

    // Query to get the product details
    $sql = "SELECT item.Title AS name, item.Description AS description, item.Price AS price, category.Title AS category, item.Image AS image 
            FROM item 
            LEFT JOIN category ON item.Category_ID = category.ID 
            WHERE item.ID = $id";

    // Execute the query
    $result = mysqli_query($conn, $sql);
    // Check if the query execution was successful
    if ($result) {
        // Check if the product exists
        if (mysqli_num_rows($result) == 1) {
            // Fetch the product details
            $product = mysqli_fetch_assoc($result);
        } else {
            // Redirect to the home page if the product does not exist
            header('location: ' . HOMEURL . 'index.php');
            exit();
        }
    } else {
        // Query failed
        echo "<div style='color: red;'>Failed to retrieve product details. Error: " . mysqli_error($conn) . "</div>";
    }
} else {
    // Redirect to the home page if the ID is not set
    header('location: ' . HOMEURL . 'index.php');
    exit();
}
?>
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            <form action="" method="POST">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <img src="Images/Food/<?php echo htmlspecialchars($product['image'])?>" alt="<?php echo htmlspecialchars($product['name'])?>" class="img-responsive img-curve">
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo htmlspecialchars($product['name']);?></h3>
                        <p class="food-price">£<?php echo htmlspecialchars($product['price'])?></p>
                        <p class="food-detail">
                            <?php echo htmlspecialchars($product['description'])?>
                        <div class="order-label">Quantity</div>
                        <input type="number" name="quantity" class="input-responsive" value="1" required>
                        
                    </div>
                    <input type="hidden" name="item_id" value="<?php echo $id; ?>" required>
                    <input type="hidden" name="customer" value="<?php echo $_SESSION['UID']; ?>" required>
                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>
                
            </form>
            
        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->
    <?php

// Check if the submit button is clicked
if (isset($_POST['submit'])) {
    

    // Get the data from the form
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $total = $product['price'] * $quantity;
    $date = date('Y-m-d H:i:s');
    $status = "pending";
    $customer_id = $_POST['customer'];

    // Execute the Query
    $sql2 = "INSERT INTO `order` SET
                Item_ID = '$item_id',
                Quantity = '$quantity',
                Total = '$total',
                Order_Date = '$date',
                Status = '$status',
                Customer_ID = '$customer_id'";

            $result2 = mysqli_query($conn, $sql2);

            if ($result2) {
                $_SESSION['add'] = "<div style='color: green;'>Order placed Successfully.</div>";
                header("location:" . HOMEURL . "order.php?ID=$id");
            } else {
                $_SESSION['add'] = "<div style='color: red;'>Failed to place order.</div>";
                header("location:" . HOMEURL . "order.php?ID=$id");
            }
}

?>
    <?php
include('partials-front/footer.php')
?>