<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href=userStyle.css>
</head>
<body>
    <div class="container">
        <div class="profile">
            <h2>User Profile</h2>
            <form action="../loginForm.php" method="POST">
                <button type="submit">Logout</button>
            </form>
        </div>
        <div class="dashboard">
            <div class="box"><a href="food.php">Add Food and Beverages</a></div>
            <div class="box"><a href="manage_users.php">Manage Users</a></div>
            <div class="box"><a href="manage_customers.php">Manage Customer Details</a></div>
            <div class="box"><a href="manage_reservations.php">Manage Reservations</a></div>
            <div class="box"><a href="parking_availability.php">View Parking Availability</a></div>
            <div class="box"><a href="view_table_reservation.php">View Table Reservation</a></div>
        </div>
        
        </div>
    </div>
</body>
</html>