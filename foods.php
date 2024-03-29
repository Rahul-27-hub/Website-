<?php include('partials-front/menu.php'); ?>

<!-- Food Search Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- Food Search Section Ends Here -->

<!-- Food Menu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php 
            // Display foods that are active
            $query = "SELECT * FROM tbl_food WHERE active='Yes'";

            // Execute the query
            $result = mysqli_query($conn, $query);

            // Count rows
            $count = mysqli_num_rows($result);

            // Check if foods are available or not
            if($count > 0) {
                // Foods available
                while($row = mysqli_fetch_assoc($result)) {
                    // Get the values
                    $foodId = $row['id'];
                    $foodTitle = $row['title'];
                    $foodDescription = $row['description'];
                    $foodPrice = $row['price'];
                    $foodImageName = $row['image_name'];
                    ?>
                    
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php 
                                // Check if image is available or not
                                if($foodImageName == "") {
                                    // Image not available
                                    echo "<div class='error'>Image not Available.</div>";
                                } else {
                                    // Image available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $foodImageName; ?>" alt="Chicken Hawaiian Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $foodTitle; ?></h4>
                            <p class="food-price">$<?php echo $foodPrice; ?></p>
                            <p class="food-detail">
                                <?php echo $foodDescription; ?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $foodId; ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
            } else {
                // Food not available
                echo "<div class='error'>Food not found.</div>";
            }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- Food Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
