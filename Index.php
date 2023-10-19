<?php
session_start();

if (basename($_SERVER['PHP_SELF']) == "Complete.php") {
    if (isset($_SESSION['user_data'])) {
        unset($_SESSION['user_data']);
    }
}

if (basename($_SERVER['PHP_SELF']) != "Index.php" && !isset($_SESSION['agreed_to_terms'])) {
    header("Location: Disclaimer.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Algonquin Bank</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: black;
            color: #fff;
            padding: 10px;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 10px;
        }
        nav ul li a {
            text-decoration: none;
            color: #fff;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
        footer {
            background-color: #007B5E;
            color: #fff;
            text-align: center;
            padding: 10px;
            margin-top: auto;
        }
        /* Style for the text link at the bottom */
        .bottom-link {
            text-align: center;
            margin-top: 20px;
        }
        .bottom-link a {
            text-decoration: none;
            color: #007B5E;
            font-weight: bold;
        }
        .bottom-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="image.jpg" alt=""/>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="Disclaimer.php">Terms and Conditions</a></li>
                <li><a href="CustomerInfo.php">Customer Information</a></li>
                <li><a href="DepositCalculator.php">Calculator</a></li>
                <li><a href="Complete.php">Complete</a></li>
            </ul>
        </nav>
    </header>
    <div>
        <h1>Welcome to Algonquin Bank</h1>
        <p>Algonquin Bank is Algonquin College students' most loved bank. We provide a set of tools for Algonquin College students to manage their finance.</p>
        <!-- Text link to Disclaimer.php -->
        <div class="bottom-link">
            <a href="Disclaimer.php">Read our Terms and Conditions</a>
        </div>
    </div>
    <footer>
        &copy; Algonquin College 2010-2023. All Rights Reserved
    </footer>
</body>
</html>
