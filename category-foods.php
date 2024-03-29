<?php include('partials-front/menu.php'); ?>
<?php 
    // Check whether category_id is passed or not
    if(isset($_GET['category_id']))
    {
        // Category id is set, get the id
        $cat_id = $_GET['category_id'];
        // Get the category title based on the category ID
        $sql = "SELECT title FROM tbl_category WHERE id=$cat_id";
        // Execute the query
        $result = mysqli_query($conn, $sql);
        // Get the value from database
        $row = mysqli_fetch_assoc($result);
        // Get the title
        $cat_title = $row['title'];
    }
    else
    {
        // Category not passed, redirect to homepage
        header('location:'.SITEURL);
    }
?>
<!-- Food search section starts here -->
<section class="food-search text-center">
    <div class="container">
        <h2>Foods on <a href="#" class="text-white">"<?php echo $cat_title; ?>"</a></h2>
    </div>
</section>
<!-- Food search section ends here -->
<!-- Food menu section starts here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>
        <?php 
        // Create SQL query to get foods based on selected category
        $sql2 = "SELECT * FROM tbl_food WHERE category_id=$cat_id";
        // Execute the query
        $result2 = mysqli_query($conn, $sql2);
        // Count the rows
        $count2 = mysqli_num_rows($result2);
        // Check whether food is available or not
        if($count2 > 0)
        {
            // Food is available
            while($row2 = mysqli_fetch_assoc($result2))
            {
                $food_id = $row2['id'];
                $food_title = $row2['title'];
                $food_price = $row2['price'];
                $food_desc = $row2['description'];
                $food_image = $row2['image_name'];
                ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php 
                            if($food_image == "")
                            {
                                // Image not available
                                echo "<div class='error'>Image not available.</div>";
                            }
                            else
                            {
                                // Image available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $food_image; ?>" alt="Food image" class="img-responsive img-curve">
                                <?php
                            }
                        ?>
                    </div>
                    <div class="food-menu-desc">
                        <h4><?php echo $food_title; ?></h4>
                        <p class="food-price">$<?php echo $food_price; ?></p>
                        <p class="food-detail"><?php echo $food_desc; ?></p>
                        <br>
                        <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $food_id; ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
                <?php
            }
        }
        else
        {
            // Food not available
            echo "<div class='error'>Food not available.</div>";
        }
    ?>
    <div class="clearfix"></div>
</div>
</section>
<!-- Food menu section ends here -->
<?php include('partials-front/footer.php'); ?>