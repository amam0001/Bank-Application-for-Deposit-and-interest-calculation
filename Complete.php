<?php
session_start();

if (!isset($_SESSION['agreed_to_terms']) || !$_SESSION['agreed_to_terms']) {
    header("Location: Disclaimer.php");
    exit();
}

if (!isset($_SESSION['user_data'])) {
    header("Location: CustomerInfo.php");
    exit();
}

$userData = $_SESSION['user_data'];

$contactTimes = isset($_SESSION['contact_times']) ? $_SESSION['contact_times'] : [];
$contactMethod = isset($_SESSION['contact_method']) ? $_SESSION['contact_method'] : "";
$timeSlots = [
    "9am - 10am",
    "10:00am - 11:00am",
    "11:00am - 12:00pm",
    "1:00pm - 2:00pm",
    "2:00pm - 3:00pm",
    "3:00pm - 4:00pm",
    "4:00pm - 5:00pm",
    "5:00pm - 6:00pm",
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Complete</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="image.jpg" alt="Algonquin College Logo">
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

    <div class="container">
        <h1>Complete</h1>

        <?php if (empty($contactTimes)): ?>
            <div class="complete-message">
                <h2>Thank you, <?= $userData['name'] ? $userData['name'] : 'User' ?>, for using our deposit calculation tool.</h2>
                <p>You did not select any contact times, so we will not be able to call you.</p>
            </div>
        <?php else: ?>
            <div class="complete-message">
                <h2>Thank you, <?= $userData['name'] ? $userData['name'] : 'User' ?>, for using our deposit calculation tool.</h2>
                <?php if ($contactMethod === 'phone'): ?>
                    <p>Our customer service department will contact you via phone at <?= $userData['phoneNumber'] ?> during the following times:</p>
                <?php elseif ($contactMethod === 'email'): ?>
                    <p>Our customer service department will contact you via email at <?= $userData['email'] ?> during the following times:</p>
                <?php endif; ?>
                <ul>
                    <?php foreach ($contactTimes as $index): ?>
                        <?php if (isset($timeSlots[$index])): ?>
                            <li><?= $timeSlots[$index] ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
            // Clear session data
            session_unset();
            session_destroy();
            ?>
        <?php endif; ?>
    </div>
</body>
</html>
