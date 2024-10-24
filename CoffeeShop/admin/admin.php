<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="adminStyle.css">
</head>
<body>
    <div class="container">
        <div class="profile">
            <h2>Admin Profile</h2>
            <form action="../loginForm.php" method="POST">
                <button type="submit">Logout</button>
            </form>
        </div>
        <div class="dashboard">
            <div class="box"><a href="food.php">Add Food and Beverages</a></div>
            <div class="box"><a href="manage_users.php">Manage Users</a></div>
            <div class="box"><a href="manage_admin.php">Manage Admin</a></div>
            <div class="box"><a href="manage_customers.php">Manage Customer Details</a></div>
            <div class="box"><a href="manage_reservation.php">Manage Reservations</a></div>
            <div class="box"><a href="parking_availability.php">Parking Availability</a></div>
            <div class="box"><a href="view_table_reservation.php">View Table Reservation</a></div>
        </div>
       
    </div>
</body>
</html>
