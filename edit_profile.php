<?php
session_start();
require 'db.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details from the session
$user_id = $_SESSION['user_id'];

// Fetch user's current data
$stmt = $pdo->prepare("SELECT user, email, contact_number, photo FROM admin1 WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $password = $_POST['password'];

    // Update photo if provided
    if (!empty($_FILES['photo']['name'])) {
        $photoPath = 'uploads/profile_' . $user_id . '_' . time() . '.' . pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);
    } else {
        $photoPath = $user['photo']; // Keep the current photo if no new one is uploaded
    }

    // Hash password if provided
    if (!empty($password)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $passwordHash = null; // Don't update the password if it's not provided
    }

    // Update user details
    $stmt = $pdo->prepare(
        "UPDATE admin1 SET user = ?, email = ?, contact_number = ?, photo = ?" .
        ($passwordHash ? ", password = ?" : "") .
        " WHERE id = ?"
    );

    $params = [$name, $email, $contact_number, $photoPath];
    if ($passwordHash) {
        $params[] = $passwordHash;
    }
    $params[] = $user_id;

    if ($stmt->execute($params)) {
        $_SESSION['success'] = "Profile updated successfully.";
        header("Location: user_profile.php");
        exit();
    } else {
        $error = "Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="/itonatocuescano/CSS/fonts.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to right, #B8860B, #000);
            color: white;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            color: black;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input[type="file"] {
            padding: 3px;
        }
        .form-group button {
            background-color: #B8860B;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #B88600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>

        <?php if (isset($error)): ?>
            <div class="text-red-500 mb-4"> <?php echo $error; ?> </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['user']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="contact_number">Contact No:</label>
                <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($user['contact_number']); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password (leave blank to keep current):</label>
                <input type="password" id="password" name="password">
            </div>

            <div class="form-group">
                <label for="photo">Profile Photo:</label>
                <input type="file" id="photo" name="photo">
            </div>

            <div class="form-group">
                <button type="submit">Save Changes</button>
            </div>
            <div class="form-group">
            <a href="user_profile.php"><button>Go Back</button></a>
            </div>
        </form>
    </div>
</body>
</html>
