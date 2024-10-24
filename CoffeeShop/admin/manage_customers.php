<?php
session_start();
include('db_connect.php');

// Check if the delete form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    
    // Delete the user from the database
    $delete_query = "DELETE FROM users_form WHERE id='$user_id'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<p>User deleted successfully.</p>";
    } else {
        echo "<p>Error deleting user: " . mysqli_error($conn) . "</p>";
    }
}

// Retrieve users data
$query = "SELECT * FROM users_form WHERE user_type='customer'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage users</title>
    <link rel="stylesheet" href="adminStyle.css">
</head>
<body>
    <div class="container">
        <h2>Manage Customer</h2>

          <a href="admin.php" class="back-button">Back</a>

        <h3>Current Customers</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td>
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
