<?php
include('partials-front/navegation.php');
?>

<!-- Categories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        $sql = "SELECT * FROM category WHERE Active='Yes'";

        $result = mysqli_query($conn, $sql);

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
        ?>
        
        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<?php
include('partials-front/footer.php');
?>
