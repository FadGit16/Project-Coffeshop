<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservations</title>
    <link rel="stylesheet" href="reservations.css">
</head>
<body>
    <h1>Reservation Details</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Time</th>
                <th>Guests</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "coffee_shop";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if (isset($_GET['delete'])) {
                $id = intval($_GET['delete']);
                $deleteSql = "DELETE FROM table_reservation WHERE id=?";
                $stmt = $conn->prepare($deleteSql);
                $stmt->bind_param("i", $id);

                if ($stmt->execute()) {
                    echo "<p>Reservation deleted successfully.</p>";
                } else {
                    echo "<p>Error deleting reservation: " . $stmt->error . "</p>";
                }

                $stmt->close();
            }

            $sql = "SELECT id, name, email, phone, date, time, guests FROM table_reservation";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["date"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["time"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["guests"]) . "</td>";
                    echo "<td><a href='view_table_reservation.php?delete=" . urlencode($row["id"]) . "' class='delete-btn'>Delete</a></td>";
                    echo "</tr>";     
           }
            } else {
                echo "<tr><td colspan='7'>No reservations found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
