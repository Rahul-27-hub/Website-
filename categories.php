<?php 
    // Include menu
    include('partials-front/menu.php');

    // Display all active categories
    $categorySql = "SELECT * FROM tbl_category WHERE active='Yes'";
    $categoryResult = mysqli_query($conn, $categorySql);
    $categoryCount = mysqli_num_rows($categoryResult);

    // Check if categories are available
    if ($categoryCount > 0) {
        // Loop through categories
        while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
            // Get category details
            $categoryId = $categoryRow['id'];
            $categoryTitle = $categoryRow['title'];
            $categoryImage = $categoryRow['image_name'];
            ?>

            <!-- Display category details -->
            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $categoryId; ?>">
                <div class="box-3 float-container">
                    <?php 
                        if ($categoryImage == "") {
                            // Image not available
                            echo "<div class='error'>Image not found.</div>";
                        } else {
                            // Image available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $categoryImage; ?>" alt="<?php echo $categoryTitle; ?>" class="img-responsive img-curve">
                            <?php
                        }
                    ?>

                    <h3 class="float-text text-white"><?php echo $categoryTitle; ?></h3>
                </div>
            </a>

            <?php
        }
    } else {
        // No categories available
        echo "<div class='error'>Category not found.</div>";
    }
?>

<!-- Include footer -->
<?php include('partials-front/footer.php'); ?>
