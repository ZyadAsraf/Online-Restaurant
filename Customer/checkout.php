<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <h2>Welcome, name</h2>
        
        <h3>Your Cart</h3>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- <?php foreach ($cart_items as $item): ?> -->
                <tr>
                    <!-- <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($item['price']); ?></td>
                    <td><?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td> -->
                </tr>
                <!-- <?php endforeach; ?> -->
            </tbody>
        </table>
        <!-- <h3>Total Price: $<?php echo htmlspecialchars($total_price); ?></h3> -->

        <form action="process_checkout.php" method="POST">
            <label for="address">Shipping Address:</label>
            <input type="text" id="address" name="address" required>
            <button type="submit">Place Order</button>
        </form>
    </div>
</body>
</html> 