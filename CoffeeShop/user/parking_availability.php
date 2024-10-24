<?php
session_start();
include('db_connect.php');




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
    <link rel="stylesheet" href="userStyle.css">
</head>
<body>
    <div class="container">
        <h2>Parking Availability</h2>

                  <a href="user.php" class="back-button">Back</a>

        <h3>Current Availability</h3>
        <table>
            <thead>
                <tr>
                    <th>Parking Spot</th>
                    <th>Availability</th>
                    <th>Last Updated</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['parking_spot']); ?></td>
                    <td><?php echo $row['is_available'] ? 'Available' : 'Not Available'; ?></td>
                    <td><?php echo $row['updated_at']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
