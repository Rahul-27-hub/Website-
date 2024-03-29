<?php 
    // Include menu
    include('partials-front/menu.php'); 
?>

<div class="main-content">
    <div class="wrapper">
        <h1 class="text-center">Order Details</h1>

        <br /><br /><br />
        <br><br>
        <center>
            <table class="content-table">
                <tr>
                    <th>Serial No. </th>
                    <th>Food Item </th>
                    <th>Price </th>
                    <th>qty </th>
                    <th>Total </th>
                    <th>Order Date </th>
                    <th>Status </th>
                </tr>
                <hr>
                <?php 
                    // Get all the orders from database for current user
                    $sql = "SELECT * FROM tbl_order WHERE u_id={$_SESSION['u_id']} ORDER BY id DESC"; // Display the Latest Order at First
                    // Execute Query
                    $result = mysqli_query($conn, $sql);
                    // Count the Rows
                    $count = mysqli_num_rows($result);

                    $serialNo = 1; // Create a Serial Number and set its initial value as 1
                 
                    if($count>0)
                    {
                        // Order Available
                        while($row=mysqli_fetch_assoc($result))
                        {
                            // Get all the order details
                            $id = $row['id'];
                            $foodItem = $row['food'];
                            $price = $row['price'];
                            $qty = $row['qty'];
                            $total = $row['total'];
                            $orderDate = $row['order_date'];
                            $status = $row['status'];

                            ?>

                            <tr>
                                <td><?php echo $serialNo++; ?>. </td>
                                <td><?php echo $foodItem; ?></td>
                                <td><?php echo $price; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td><?php echo $total; ?></td>
                                <td><?php echo $orderDate; ?></td>
                                <td>
                                    <?php 
                                        // Ordered, On Delivery, Delivered, Cancelled

                                        if($status=="Ordered")
                                        {
                                            echo "<label>$status</label>";
                                        }
                                        elseif($status=="On Delivery")
                                        {
                                            echo "<label style='color: orange;'>$status</label>";
                                        }
                                        elseif($status=="Delivered")
                                        {
                                            echo "<label style='color: green;'>$status</label>";
                                        }
                                        elseif($status=="Cancelled")
                                        {
                                            echo "<label style='color: red;'>$status</label>";
                                        }
                                    ?>
                                </td>
                            </tr>

                            <?php

                        }
                    }
                    else
                    {
                        // Order not Available
                        echo "<tr><td colspan='12' class='error'>You have not placed any orders yet!!!</td></tr>";
                    }
                ?>
            </table>
        </center>
    </div>
</div>

<?php 
    // Include footer
    include('partials-front/footer.php'); 
?> 
