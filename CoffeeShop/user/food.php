<?php
session_start();
include('db_connect.php');

// Handle form submission for adding new items
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = '';

    // Handle the image upload
    if ($_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $target = 'uploads/' . basename($image);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo "Error uploading the image.";
        }
    }

    $stmt = $conn->prepare("INSERT INTO food_beverages (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $description, $price, $image);

    if ($stmt->execute()) {
        echo "New food item added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Handle form submission for updating items
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = '';

    // Handle the image upload if a new image is provided
    if ($_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $target = 'uploads/' . basename($image);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo "Error uploading the image.";
        }
    } else {
        // Keep the old image if no new image is provided
        $image = $_POST['old_image'];
    }

    $stmt = $conn->prepare("UPDATE food_beverages SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
    $stmt->bind_param("ssdsi", $name, $description, $price, $image, $id);

    if ($stmt->execute()) {
        echo "Food item updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch all food items
$query = "SELECT * FROM food_beverages";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food and Beverages</title>
    <link rel="stylesheet" href="userStyle.css">
</head>
<body>
    <div class="container">
        <h2>Add Food and Beverages</h2>
        <a href="user.php" class="back-button">Back</a>

        <form method="POST" action="" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit" name="add">Add Item</button>
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
                    <form method="POST" action="" enctype="multipart/form-data">
                        <td><input type="text" name="name" value="<?php echo $row['name']; ?>" required></td>
                        <td><textarea name="description" required><?php echo $row['description']; ?></textarea></td>
                        <td><input type="number" step="0.01" name="price" value="<?php echo $row['price']; ?>" required></td>
                        <td>
                            <?php if ($row['image']): ?>
                                <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" style="width: 100px; height: auto;">
                            <?php endif; ?>
                            <input type="file" name="image" accept="image/*">
                            <input type="hidden" name="old_image" value="<?php echo $row['image']; ?>">
                        </td>
                        <td>
                            <button type="submit" name="update">Update</button>
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        </td>
                    </form>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
