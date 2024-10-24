<?php
session_start();
include('db_connect.php');

// Handle deletion of orders
if (isset($_GET['delete_order']) && is_numeric($_GET['delete_order'])) {
    $order_id = $_GET['delete_order'];

    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        $message = "Order deleted successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();

    // Redirect to the same page to prevent form resubmission on refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch all orders
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
    <title>Manage Orders</title>
    <link rel="stylesheet" href="adminStyle.css">
</head>
<body>
    <div class="container">
        <h2>Manage Customer Orders</h2>

        <a href="admin.php" class="back-button">Back</a>

        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>

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
                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($order['food_name']); ?></td>
                    <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                    <td>
                        <a href="?delete_order=<?php echo $order['id']; ?>" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
