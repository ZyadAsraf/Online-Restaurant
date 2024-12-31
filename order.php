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
            <form action="#" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <img src="Images/Food/<?php echo htmlspecialchars($product['image'])?>" alt="<?php echo htmlspecialchars($product['name'])?>" class="img-responsive img-curve">
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo htmlspecialchars($product['name']);?></h3>
                        <p class="food-price">£<?php echo htmlspecialchars($product['price'])?></p>

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        <p class="food-description"><?php echo htmlspecialchars($product['description'])?></p>
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php
include('partials-front/footer.php')
?>