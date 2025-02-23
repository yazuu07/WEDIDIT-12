<?php
session_start();

// Restrict access to only admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/itonatocuescano/CSS/fonts.css">
    <link rel="icon" type="image/png" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxRJkf3Hh_OcH9AJn4SVH_EXHje0n5lJFhNw&s">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to right, rgb(144, 105, 6), rgb(0, 0, 0)); /* Gradient background */
            padding-top: 4rem; /* Offset for fixed navbar */
        }
        nav ul li a:hover {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100">

<nav class="bg-stone-950 text-white fixed top-0 w-full shadow-lg">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Left Links -->
        <ul class="flex gap-6">
            <li><a href="/itonatocuescano/Admin_dashboard.php" class="hover:text-yellow-600">Home</a></li>
            <li><a href="Company_mission.php" class="hover:text-yellow-600">Mission</a></li>
            <li><a href="Company_vision.php" class="text-yellow-300">Vision</a></li>
            <li><a href="Company_goal.php" class="hover:text-yellow-600">Goal</a></li>
        </ul>

        <!-- Center Logo -->
        <div class="flex-shrink-0">
            <a href="http://localhost/itonatocuescano/about/Company_vision.php"><img src="/itonatocuescano/images/logo.jpg" alt="Company Logo" class="mx-auto" style="width:200px;"></a>
        </div>

        <!-- Right Links -->
        <ul class="flex gap-6">
            <li><a href="/itonatocuescano/logout.php" class="hover:text-yellow-600">Logout</a></li>
        </ul>
    </div>
</nav>


     
        <!-- Main Content -->
        <main class="flex-1 p-8">
    <div class="max-w-4xl mx-auto text-center bg-white text-gray-800 p-10 rounded-lg shadow-xl border-t-4 border-yellow-500">
        <h1 class="text-4xl font-extrabold text-yellow-600 mb-6 uppercase tracking-wide">Our Vision</h1>
        <p class="text-lg leading-relaxed text-justify mb-6">
            Our vision is to be the leading provider of innovative and efficient attendance monitoring solutions that empower organizations to achieve seamless workforce management, fostering productivity and operational excellence. Through our commitment to cutting-edge technology and exceptional service, we aim to revolutionize how businesses track and optimize their workforce.
        </p>
        <div class="mt-6">
            <a href="https://systechcorp.com.ph/home"><button class="bg-yellow-500 text-white px-6 py-3 rounded-full font-bold shadow-md hover:bg-yellow-600 transition duration-300">
                Learn More
            </button></a>
        </div>
    </div>
</main>

    </div>
    </div>
</body>
</html>
