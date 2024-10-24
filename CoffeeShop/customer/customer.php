<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    $customer_name = $_POST['customer_name'];
    $food_id = $_POST['food_id'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("INSERT INTO orders (customer_name, food_id, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $customer_name, $food_id, $quantity);

    if ($stmt->execute()) {
        echo "Order placed successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];

    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        echo "Order deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$query = "SELECT * FROM food_beverages";
$result = mysqli_query($conn, $query);

$orders_query = "SELECT orders.id, customer_name, food_beverages.name AS food_name, quantity 
                 FROM orders 
                 JOIN food_beverages ON orders.food_id = food_beverages.id";
$orders_result = mysqli_query($conn, $orders_query);

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
        <h2>Order Food and Beverages</h2>
        <form action="../loginForm.php" method="POST">
                <button type="submit">Logout</button>
        </form>
        <h2>Available Food and Beverages</h2>
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
                            <input type="text" name="customer_name" placeholder="Your Name" required>
                            <input type="number" name="quantity" value="1" min="1" required>
                            <button type="submit" name="place_order">Place Order</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Your Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Food Item</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = mysqli_fetch_assoc($orders_result)): ?>
                <tr>
                    <td><?php echo $order['customer_name']; ?></td>
                    <td><?php echo $order['food_name']; ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <button type="submit" name="delete_order">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <p>Do you want to reserve a table? <a href="reservation.php">Reserve Now</a></p>
    </div>
</body>
</html>
