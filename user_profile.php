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
    die("User not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $contact_number = trim($_POST['contact_number']);
    $password = trim($_POST['password']);

    // Update photo if provided
    if (!empty($_FILES['photo']['name'])) {
        $photo_ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photoPath = 'uploads/profile_' . $user_id . '_' . time() . '.' . $photo_ext;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
            // Delete old photo if it exists
            if (!empty($user['photo']) && file_exists($user['photo'])) {
                unlink($user['photo']);
            }
        }
    } else {
        $photoPath = $user['photo']; // Keep current photo
    }

    // Hash password if provided
    $passwordHash = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;

    // Build SQL query dynamically
    $query = "UPDATE admin1 SET user = ?, email = ?, contact_number = ?, photo = ?";
    $params = [$name, $email, $contact_number, $photoPath];

    if ($passwordHash) {
        $query .= ", password = ?";
        $params[] = $passwordHash;
    }

    $query .= " WHERE id = ?";
    $params[] = $user_id;

    // Execute update query
    $stmt = $pdo->prepare($query);
    if ($stmt->execute($params)) {
        $_SESSION['success'] = "Profile updated successfully.";
        header("Location: user_profile.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to update profile.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="/itonatocuescano/CSS/fonts.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to right, #B8860B, #000);
            color: black;
        }
        .container {
            max-width: 400px;
            margin: 80px auto; /* Centered */
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .profile-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
        }
        .profile-detail {
            text-align: center;
            margin-bottom: 10px;
        }
        .profile-detail label {
            font-weight: bold;
            font-size: 1.1rem;
        }
        .edit-button button {
            background-color: #B8860B;
            transition: 0.3s ease;
        }
        .edit-button button:hover {
            background-color: #DAA520;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="bg-black shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 relative">
            <!-- Dropdown Menu -->
            <div class="absolute left-0 top-0 p-4">
                <button id="menuButton" class="text-white text-xl">☰</button>
                <div id="menuDropdown" class="absolute mt-2 w-48 bg-stone-800 text-white rounded shadow-lg hidden">
                    <a href="camera.php" class="block px-4 py-2 text-white hover:bg-stone-700">Camera</a>
                    <a href="user_profile.php" class="block px-4 py-2 text-white hover:bg-stone-700">Profile</a>
                    <a href="user_gallery.php" class="block px-4 py-2 text-white hover:bg-stone-700">Gallery</a>
                    <a href="logout.php" class="block px-4 py-2 text-white hover:bg-stone-700">Logout</a>
                </div>
            </div>

            <!-- Logo in the Center -->
            <div class="mx-auto">
                <a href="camera.php">
                    <img src="images/logo.jpg" alt="Logo" class="h-10">
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Profile Content -->
<div class="container w-80 p-6 bg-white shadow-lg rounded-lg">

    <?php if (isset($_SESSION['error'])): ?>
        <div class="text-red-500 mb-4 text-center"> <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?> </div>
    <?php elseif (isset($_SESSION['success'])): ?>
        <div class="text-green-500 mb-4 text-center"> <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?> </div>
    <?php endif; ?>

    <div class="text-center">
    <img src="<?= !empty($user['photo']) ? htmlspecialchars($user['photo']) : 'images/noprofile.jpg' ?>" 
         alt="Profile Photo" 
         class="profile-photo border-2 border-gray-400 rounded-full w-32 h-32 object-cover">
</div>


    <div class="profile-detail mt-4">
        <h2 class="text-lg font-semibold"><label>Name:</label></h2>
        <p class="text-gray-700"><?= htmlspecialchars($user['user']); ?></p>
    </div>

    <div class="profile-detail mt-2">
        <h2 class="text-lg font-semibold"><label>Email:</label></h2>
        <p class="text-gray-700"><?= htmlspecialchars($user['email']); ?></p>
    </div>

    <div class="profile-detail mt-2">
        <h2 class="text-lg font-semibold"><label>Contact No:</label></h2>
        <p class="text-gray-700"><?= htmlspecialchars($user['contact_number']); ?></p>
    </div>

    <div class="text-center mt-4">
        <button onclick="window.location.href='edit_profile.php'" 
                class="px-4 py-2 bg-yellow-600 rounded text-white hover:bg-yellow-700 transition">
            Edit Profile
        </button>
    </div>
</div>

<script>
document.getElementById("menuButton").addEventListener("click", function () {
    var dropdown = document.getElementById("menuDropdown");
    dropdown.classList.toggle("hidden");
});

// Close dropdown when clicking outside
document.addEventListener("click", function (event) {
    var dropdown = document.getElementById("menuDropdown");
    var button = document.getElementById("menuButton");

    if (!dropdown.contains(event.target) && !button.contains(event.target)) {
        dropdown.classList.add("hidden");
    }
});
</script>

</body>
</html>
