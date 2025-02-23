<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $contact_number = $_POST['contact_number'];

    try {
        $stmt = $pdo->prepare("INSERT INTO admin1 (user, email, password, contact_number) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user, $email, $password, $contact_number]);
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" type="image/png" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxRJkf3Hh_OcH9AJn4SVH_EXHje0n5lJFhNw&s">
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #B8860b, #000);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 10px;
        }

        /* Registration container */
        .login-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            min-width: 320px;
            text-align: center;
        }

        /* Heading */
        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        /* Input fields & Button: Same width */
        input, button {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border-radius: 8px;
            font-size: 16px;
            display: block;
            box-sizing: border-box;
        }

        /* Input field styles */
        input {
            border: 1px solid #ccc;
            background: #f9f9f9;
            width: 400px;
        }

        input:focus {
            outline: none;
            border-color: #B8860b;
            background: white;
        }

        /* Register Button */
        button {
            background: #B8860b;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background: #8B6508;
            transform: scale(1.05);
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3);
        }

        /* Links */
        p {
            font-size: 14px;
            margin-top: 15px;
        }

        a {
            color: #B8860b;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsive styling */
        @media screen and (max-width: 480px) {
            .login-container {
                width: 95%;
                min-width: 300px;
                padding: 15px;
            }

            input, button {
                font-size: 14px;
                padding: 12px;
            }

            p, a {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form action="register.php" method="post">
            <h2>Create an Account</h2>
            <?php if (isset($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>
            <input type="text" name="user" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="contact_number" placeholder="Contact Number" required>
            <button type="submit">Create Account</button>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
