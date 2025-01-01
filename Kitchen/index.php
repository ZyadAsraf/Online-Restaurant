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

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        ?>

        <div id="clock" style="font-size: 24px; font-weight: bold;"></div>
        
        <table class="tbl-full">
            <tr>
                <th>Order ID</th>
                <th>Item name</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Payment type</th>
                <th>Actions</th>
            </tr>

            <?php
            // Query to get all categories from database
            $sql = "SELECT orders.*, customer.First_Name AS customer_firstname, customer.Last_Name AS customer_lastname, item.title AS item_name
                FROM orders
                LEFT JOIN customer ON orders.Customer_ID = customer.ID
                LEFT JOIN item ON orders.Item_ID = item.ID
                WHERE orders.Status != 'Delivered' AND orders.Status != 'Cancelled'
                ORDER BY orders.Order_Date DESC";

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
                        $item_name = $row['item_name'];
                        $total = $row['Total'];
                        $order_date = $row['Order_Date'];
                        $status = $row['Status'];
                        $quantity = $row['Quantity'];
                        $payment_type = $row['Payment_type'];
                        $customer_name = $row['customer_firstname'] . ' ' . $row['customer_lastname'];
                        ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $item_name; ?></td>
                            <td><?php echo $quantity; ?></td>
                            <td><?php echo $total; ?></td>
                            <td><?php echo $order_date; ?></td>
                            <td><?php echo $status; ?></td>
                            <td><?php echo $customer_name; ?></td>
                            <td><?php echo $payment_type; ?></td>
                            <td>
                                <!-- <a href="<?php echo HOMEURL; ?>admin/Update-category.php?ID=<?php echo $id; ?>" class="btn-secondary"><i class="fa-solid fa-pen"></i></a> -->
                                <button onclick="updateOrder(<?php echo $id; ?>, 'Ready')" class="btn-grey"><i class="fa-solid fa-utensils"></i></button>
                                <button onclick="updateOrder(<?php echo $id; ?>, 'Delivered')" class="btn-secondary " ><i class="fa-solid fa-check"></i></button>
                                <button onclick="updateOrder(<?php echo $id; ?>, 'Cancelled')" class="btn-danger" "><i class="fa-solid fa-ban"></i></button>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    // No categories found
                    echo "<tr><td colspan='6' style='color: red;'>No orders Yet</td></tr>";
                }
            } else {
                // Query failed
                echo "<tr><td colspan='6' style='color: red;'>Failed to retrieve orders. Error: " . mysqli_error($conn) . "</td></tr>";
            }
            ?>
        </table>
    </div>
</div>
<script>
        function updateTime() {
            var now = new Date();
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');
            var timeString = "Current time: " + hours + ':' + minutes + ':' + seconds;
            document.getElementById('clock').textContent = timeString;
        }
        setInterval(updateTime, 1000);
        updateTime();

    function updateOrder(orderId, action) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo HOMEURL; ?>kitchen/updateOrder.php';

        var orderIdInput = document.createElement('input');
        orderIdInput.type = 'hidden';
        orderIdInput.name = 'order_id';
        orderIdInput.value = orderId;
        form.appendChild(orderIdInput);

        var actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'status';
        actionInput.value = action;
        form.appendChild(actionInput);

        document.body.appendChild(form);
        form.submit();
    }

    const eventSource = new EventSource("sse_endpoint.php");

        eventSource.onmessage = function (event) {
            location.reload();
        };

        eventSource.onerror = function () {
            console.error('Error connecting to the SSE server.');
        };
</script>
<?php
include("Partials/Footer.php");
?>
