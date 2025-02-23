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

    <!-- Navigation Bar -->
    <nav class="bg-stone-950 text-white fixed top-0 w-full shadow-lg">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Left Links -->
        <ul class="flex gap-6">
            <li><a href="/itonatocuescano/Admin_dashboard.php" class="hover:text-yellow-600">Home</a></li>
            <li><a href="Company_mission.php" class="hover:text-yellow-600">Mission</a></li>
            <li><a href="Company_vision.php" class="hover:text-yellow-600">Vision</a></li>
            <li><a href="Company_goal.php" class="text-yellow-300">Goal</a></li>
        </ul>

        <!-- Center Logo -->
        <div class="flex-shrink-0">
            <a href="http://localhost/itonatocuescano/about/Company_goal.php"><img src="/itonatocuescano/images/logo.jpg" alt="Company Logo" class="mx-auto" style="width:200px;"></a>
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
        <h1 class="text-4xl font-extrabold text-yellow-600 mb-6 uppercase tracking-wide">Our Goal</h1>
        <p class="text-lg leading-relaxed text-justify mb-6">
            <span class="block mb-4">
                <strong>Optimize Workforce Management:</strong> Simplify the process of tracking time in and time out to enhance employee accountability and reduce administrative burden.
            </span>
            <span class="block mb-4">
                <strong>Ensure Data Accuracy:</strong> Provide a robust and secure system to minimize errors and discrepancies in daily time records (DTR).
            </span>
            <span class="block mb-4">
                <strong>Improve Decision-Making:</strong> Generate comprehensive reports and analytics to support informed managerial decisions and operational planning.
            </span>
            <span class="block mb-4">
                <strong>Enhance User Experience:</strong> Deliver an intuitive, easy-to-use interface for employees and administrators, ensuring seamless adoption and efficiency.
            </span>
            <span class="block">
                <strong>Support Growth:</strong> Scale the system to adapt to the expanding needs of Systech Integration & Security Solutions, Inc., ensuring sustained performance and reliability.
            </span>
        </p>
        <div class="mt-6">
           <a href="https://systechcorp.com.ph/services"> <button class="bg-yellow-500 text-white px-6 py-3 rounded-full font-bold shadow-md">
                Learn More
            </button></a>
        </div>
    </div>
</main>




</body>
</html>
