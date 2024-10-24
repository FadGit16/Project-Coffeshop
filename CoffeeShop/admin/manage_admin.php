<?php
session_start();
include('db_connect.php');



// Handle form submission for adding a new admin
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action == 'add') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $user_type = $_POST['user_type'];

            // Check if the email already exists
            $query = "SELECT * FROM users_form WHERE email=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                // Insert new admin
                $query = "INSERT INTO users_form (name, email, password, user_type) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssss",$name, $email, $password, $user_type);

                if ($stmt->execute()) {
                    echo "New admin added successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }
            } else {
                echo "email already exists.";
            }
        } elseif ($action == 'delete') {
            $admin_id = $_POST['admin_id'];

            // Delete admin user
            $query = "DELETE FROM users_form WHERE id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $admin_id);

            if ($stmt->execute()) {
                echo "Admin user deleted successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }
}

// Retrieve admin users data
$query = "SELECT * FROM users_form WHERE user_type='admin'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins</title>
    <link rel="stylesheet" href="adminStyle.css">
</head>
<body>
    <div class="container">
        <h2>Manage Admins</h2>

          <a href="admin.php" class="back-button">Back</a>

        <form method="POST" action="">
            <input type="text" name="name" placeholder="name" required>
            <input type="email" name="email" placeholder="email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="user_type">
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <input type="hidden" name="action" value="add">
            <button type="submit">Add Admin</button>
        </form>

        <h3>Current Admins</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>email</th>
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
                            <input type="hidden" name="admin_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this admin?');">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
