<?php
include("Partials/Navigation.php");
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

<style>
/* Styling for the product details */
.product-details {
    width: 80%;
    margin: auto;
    text-align: center;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.product-details img {
    width: 300px;
    height: 300px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #ddd;
    margin: 20px 0;
}

.product-details h1 {
    color: #ff4d4d;
}

.product-details p {
    font-size: 18px;
    color: #333;
}

.product-details a {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #ff4d4d;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.product-details a:hover {
    background-color: #e60000;
}
</style>

<div class="product-details">
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    <p><?php echo htmlspecialchars($product['description']); ?></p>
    <p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>
    <p>Category: <?php echo htmlspecialchars($product['category']); ?></p>
    <?php
    echo '<img src="' . HOMEURL . 'images/food/' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '">';
    ?>
    <a href="order.php?ID=<?php echo $id; ?>">Order Now</a>
    <a href="addtocart.php?ID=<?php echo $id; ?>">Add to cart</a>
    <a href="menu.php">Back to Products</a>
</div>

<?php
include("Partials/Footer.php");
?>