<?php
session_start();

// Restrict access to only admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require 'db.php';

// Fetch users from the database
try {
    $stmt = $pdo->query("SELECT id, user, email, role, contact_number FROM admin1");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user_id'])) {
    $deleteUserId = $_POST['delete_user_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM admin1 WHERE id = ?");
        $stmt->execute([$deleteUserId]);
        header("Location: Admin_dashboard.php");
        exit();
    } catch (PDOException $e) {
        die("Error deleting user: " . $e->getMessage());
    }
}

// Handle user addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing password
    $role = $_POST['role'];
    $contact = $_POST['contact_number'];

    try {
        $stmt = $pdo->prepare("INSERT INTO admin1 (user, email, password, role, contact_number) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$username, $email, $password, $role, $contact]);
        header("Location: Admin_dashboard.php");
        exit();
    } catch (PDOException $e) {
        die("Error adding user: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxRJkf3Hh_OcH9AJn4SVH_EXHje0n5lJFhNw&s">
    <link rel="stylesheet" href="/itonatocuescano/CSS/fonts.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to right, rgb(144, 105, 6), rgb(0, 0, 0));
        }
        nav {
            z-index: 50;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Fixed Navigation Bar -->
    <nav class="bg-stone-950 text-white fixed top-0 w-full shadow-lg">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Left Links -->
        <ul class="flex gap-6">
            <li><a href="Admin_dashboard.php" class="text-yellow-300">Home</a></li>
            <li><a href="about/Company_mission.php" class="hover:text-yellow-600">Mission</a></li>
            <li><a href="about/Company_vision.php" class="hover:text-yellow-600">Vision</a></li>
            <li><a href="about/Company_goal.php" class="hover:text-yellow-600">Goal</a></li>
        </ul>

        <!-- Center Logo -->
        <div class="flex-shrink-0">
            <a href="http://localhost/itonatocuescano/Admin_dashboard.php"><img src="images/logo.jpg" alt="Company Logo" class="mx-auto" style="width:200px;"></a>
        </div>

        <!-- Right Links -->
        <ul class="flex gap-6">
            <li><a href="logout.php" class="hover:text-yellow-600">Logout</a></li>
        </ul>
    </div>
</nav>

    <!-- Main Content -->
    <main class="mt-20 px-8 w-full">
        <h2 class="text-3xl text-white font-bold mb-4">USER MANAGEMENT</h2>

        <!-- Add User Form -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h3 class="text-xl font-bold mb-4">Add account</h3>
            <form method="POST">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="username" class="block text-gray-700">Username:</label>
                        <input type="text" name="username" id="username" required class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700">Email:</label>
                        <input type="email" name="email" id="email" required class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label for="role" class="block text-gray-700">Role:</label>
                        <input type="text" name="role" id="role" required class="w-full border p-2 rounded">
                    </div>
                    <div>
                        <label for="contact_number" class="block text-gray-700">Contact Number:</label>
                        <input type="text" name="contact_number" id="contact_number" required class="w-full border p-2 rounded">
                    </div>
                </div>
                  <div>
                    <label class="block text-gray-700">Password:</label>
                    <input type="password" name="password" required class="w-full border p-2 rounded">
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" name="add_user" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">Add User</button>
                </div>
            </form>
        </div>

        <!-- User Table -->
        <div class="overflow-x-auto">
            <table class="w-full bg-white shadow-lg rounded-lg border border-gray-200">
                <thead class="bg-stone-900 text-white text-lg">
                    <tr>
                        <th class="py-4 px-6 text-left">Username</th>
                        <th class="py-4 px-6 text-left">Email</th>
                        <th class="py-4 px-6 text-left">Role</th>
                        <th class="py-4 px-6 text-left">Contact Number</th>
                        <th class="py-4 px-6 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-4 px-6">
                            <a href="gallery.php?user=<?php echo urlencode($user['user']); ?>" class="text-black hover:underline">
                                <?php echo htmlspecialchars($user['user']); ?>
                            </a>
                        </td>
                        <td class="py-4 px-6"><?php echo htmlspecialchars($user['email']); ?></td>
                        <td class="py-4 px-6"><?php echo htmlspecialchars($user['role']); ?></td>
                        <td class="py-4 px-6"><?php echo htmlspecialchars($user['contact_number']); ?></td>
                        <td class="py-4 px-6 flex space-x-3">
                            <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600" 
                                onclick="editUser('<?php echo $user['id']; ?>', '<?php echo $user['user']; ?>', '<?php echo $user['email']; ?>', '<?php echo $user['role']; ?>', '<?php echo $user['contact_number']; ?>')">
                                Edit
                            </button>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-stone-900">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Edit User Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-lg font-bold mb-4">Edit User</h3>
            <form id="editForm" method="POST" action="update_user.php">
                <input type="hidden" id="editUserId" name="id">
                <label class="block text-gray-700">Username:</label>
                <input type="text" id="editUsername" name="username" required class="w-full border p-2 rounded mb-2">

                <label class="block text-gray-700">Email:</label>
                <input type="email" id="editEmail" name="email" required class="w-full border p-2 rounded mb-2">

                <label class="block text-gray-700">Role:</label>
                <input type="text" id="editRole" name="role" required class="w-full border p-2 rounded mb-2">

                <label class="block text-gray-700">Contact Number:</label>
                <input type="text" id="editContact" name="contact_number" required class="w-full border p-2 rounded mb-4">

                <div class="flex justify-end">
                    <button type="button" class="bg-black text-white px-4 py-2 rounded mr-2 hover:bg-stone-900" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editUser(id, username, email, role, contact) {
            document.getElementById("editUserId").value = id;
            document.getElementById("editUsername").value = username;
            document.getElementById("editEmail").value = email;
            document.getElementById("editRole").value = role;
            document.getElementById("editContact").value = contact;
            document.getElementById("editModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("editModal").classList.add("hidden");
        }
    </script>
</body>
</html>
