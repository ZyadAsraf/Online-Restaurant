<?php
include('partials-front/navegation.php');
?>

<!-- Food Menu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        // Database connection (assuming $conn is already initialized)
        $sql = "SELECT * FROM item WHERE Active='Yes' LIMIT 6";
        $result = mysqli_query($conn, $sql);

        if ($result === false) {
            die("Error in SQL query: " . mysqli_error($conn));
        }

        $count = mysqli_num_rows($result);

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['ID'];
                $title = $row['Title'];
                $price = $row['Price'];
                $description = $row['Description'];
                $image_name = $row['Image'];
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
                        <p class="food-detail"><?php echo $description; ?></p>
                        <br>

                        <a href="<?php echo HOMEURL; ?>order.php?ID=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>

                <?php
            }
        } else {
            echo "<div class='error'>Food not available</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>

    <p class="text-center">
        <a href="foods.php">See All Foods</a>
    </p>
</section>
<!-- Food Menu Section Ends Here -->

<?php
include('partials-front/footer.php');
?>
