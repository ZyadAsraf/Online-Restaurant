<?php
include('partials-front/navegation.php');
?>

<!-- Categories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        $sql = "SELECT * FROM category WHERE Active='Yes' AND Featured='Yes' LIMIT 3";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['ID'];
                    $title = $row['Title'];
                    $image_name = $row['Image'];
                    ?>

                    <a href="category-foods.html">
                        <div class="box-3 float-container">
                            <?php
                            if ($image_name == "") {
                                echo "<div class='error'>Image not available</div>";
                            } else {
                                ?>
                                <img src="<?php echo HOMEURL; ?>Images/Category/<?php echo $image_name; ?>" class="img-responsive img-curve">
                                <?php
                            }
                            ?>
                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                        </div>
                    </a>

                    <?php
                }
            } else {
                echo "<div class='error'>Category not added</div>";
            }
        } else {
            echo "<div class='error'>Failed to execute query: " . mysqli_error($conn) . "</div>";
        }
        ?>
        
        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<!-- Food Menu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        $sql2 = "SELECT * FROM item WHERE Active='Yes' LIMIT 6";
        $result2 = mysqli_query($conn, $sql2);

        $count2 = mysqli_num_rows($result2);

            if ($count2 > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
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
                            } 
                            
                            else {
                                ?>
                                <img src="<?php echo HOMEURL; ?>Images/Food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                <?php
                            }
                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">$<?php echo $price; ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="order.html" class="btn btn-primary">Order Now</a>
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
</section>
<!-- Food Menu Section Ends Here -->

<?php
include('partials-front/footer.php');
?>