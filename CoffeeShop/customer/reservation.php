<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Reservation</title>
    <link rel="stylesheet" href="reservation.css">
</head>
<body>
    <h1>Reserve a Table</h1>
    <form action="../loginForm.php" method="POST">
                <button type="submit">Logout</button>
        </form>
    <form action="reservation.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required><br><br>
        
        <label for="date">Reservation Date:</label>
        <input type="date" id="date" name="date" required><br><br>
        
        <label for="time">Reservation Time:</label>
        <input type="time" id="time" name="time" required><br><br>
        
        <label for="guests">Number of Guests:</label>
        <input type="number" id="guests" name="guests" min="1" required><br><br>
        
        <input type="submit" value="Reserve">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "coffee_shop";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $guests = $_POST['guests'];

        $stmt = $conn->prepare("INSERT INTO table_reservation (name, email, phone, date, time, guests) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sssssi", $name, $email, $phone, $date, $time, $guests);

        if ($stmt->execute()) {
            echo "Reservation successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
