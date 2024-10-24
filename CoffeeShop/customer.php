<?php
session_start();
include('db_connect.php');


$query = "SELECT * FROM food_beverages";
$result = mysqli_query($conn, $query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Food and Beverages</title>
    <link rel="stylesheet" href="customerStyle.css">
</head>
<body>
    <div class="container">
        <h2>Available Food and Beverages Order Now</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><img src="uploads/<?php echo $row['image']; ?>" height =100 width = 100 alt=""></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="food_id" value="<?php echo $row['id']; ?>">
                            <a href="loginForm.php" class="PlaceOrder_btn">Place Order</a>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <p>Do you want to reserve a table? <a href="loginForm.php">Reserve Now</a></p>

    </div>
</body>
</html>
