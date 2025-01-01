<?php
include('partials-front/navegation.php');
?>

<!-- Food Menu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">My orders</h2>

        <?php
        // Database connection (assuming $conn is already initialized)
        $sql = "SELECT orders.*, customer.First_Name AS customer_firstname, customer.Last_Name AS customer_lastname, item.title AS item_name, item.Image AS image_name
            FROM orders
            LEFT JOIN customer ON orders.Customer_ID = customer.ID
            LEFT JOIN item ON orders.Item_ID = item.ID
            WHERE orders.Customer_ID = {$_SESSION['UID']}
            ORDER BY orders.Order_Date DESC
            LIMIT 6";
        $result = mysqli_query($conn, $sql);

        if ($result === false) {
            die("Error in SQL query: " . mysqli_error($conn));
        }

        $count = mysqli_num_rows($result);

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['ID'];
                $title = $row['item_name'];
                $price = $row['Total'];
                $order_date = $row['Order_Date'];
                $status = $row['Status'];
                $quantity = $row['Quantity'];
                $image_name = $row['image_name'];
                ?>

                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php
                        if ($image_name == "") {
                            echo "<div class='error'>Image not available</div>";
                        } else {
                            ?>
                            <img src="<?php echo HOMEURL; ?>Images/Food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                            <?php
                        }
                        ?>
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $title; ?></h4>
                        <p class="food-price">$<?php echo $price; ?></p>
                        <p class="food-detail"><?php echo "Quantity: ".$quantity; ?></p>
                        <?php if ($status == "Ready") {
                            echo '<p class="food-detail" style="color: green;"> Ready For pickup</p>';
                        }else if ($status == "Cancelled"){
                            echo '<p class="food-detail" style="color: red;">'.$status.'</p>';
                        }else if ($status == "Delivered"){
                            echo '<p class="food-detail"">'.$status.'</p>';
                        }else {
                            echo '<p class="food-detail" style="color: blue;">'. $status .'</p>';
                        }?>
                        <br>
                        <?php
                        if ($status == "Pending") {
                            echo '<form method="POST" action="updateOrder.php">
                            <input type="hidden" name="order_id" value="<?php echo $id; ?>">
                            <input type="hidden" name="order_id" value="Cancelled">
                            <input type="submit" value="Cancel order" class="btn btn-primary">
                        </form>';
                        }
                        ?>
                    </div>
                </div>

                <?php
            
        }} else {
            echo "<div class='error'>Food not available</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- Food Menu Section Ends Here -->

<?php
include('partials-front/footer.php');
?>
