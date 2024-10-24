<?php
session_start();
include('db_connect.php');


// Handle form submission for updating availability
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action == 'update') {
            $parking_spot = $_POST['parking_spot'];
            $is_available = isset($_POST['is_available']) ? 1 : 0;

            // Check if the parking spot exists
            $query = "SELECT * FROM parking_availability WHERE parking_spot=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $parking_spot);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Update existing parking spot
                $query = "UPDATE parking_availability SET is_available=? WHERE parking_spot=?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("is", $is_available, $parking_spot);
            } else {
                // Insert new parking spot
                $query = "INSERT INTO parking_availability (parking_spot, is_available) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("si", $parking_spot, $is_available);
            }

            if ($stmt->execute()) {
                echo "Parking availability updated successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }
        } elseif ($action == 'delete') {
            $parking_spot = $_POST['parking_spot'];

            // Delete parking spot
            $query = "DELETE FROM parking_availability WHERE parking_spot=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $parking_spot);

            if ($stmt->execute()) {
                echo "Parking spot deleted successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }
}

// Retrieve parking availability data
$query = "SELECT * FROM parking_availability";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Availability</title>
    <link rel="stylesheet" href="adminStyle.css">
</head>
<body>
    <div class="container">
        <h2>Parking Availability</h2>

                  <a href="admin.php" class="back-button">Back</a>

        <form method="POST" action="">
            <input type="text" name="parking_spot" placeholder="Parking Spot Name" required>
            <label>
                <input type="checkbox" name="is_available" value="1">
                Available
            </label>
            <input type="hidden" name="action" value="update">
            <button type="submit">Update Availability</button>
        </form>
        <h3>Current Availability</h3>
        <table>
            <thead>
                <tr>
                    <th>Parking Spot</th>
                    <th>Availability</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['parking_spot']); ?></td>
                    <td><?php echo $row['is_available'] ? 'Available' : 'Not Available'; ?></td>
                    <td><?php echo $row['updated_at']; ?></td>
                    <td>
                        <!-- Delete Form -->
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="parking_spot" value="<?php echo htmlspecialchars($row['parking_spot']); ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this parking spot?');">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
