<?php
session_start();

// Clear specific session variables when navigating to Complete.php
if (basename($_SERVER['PHP_SELF']) == "Complete.php") {
    // Clear user data if it exists
    if (isset($_SESSION['user_data'])) {
        unset($_SESSION['user_data']);
    }
}

// Check if the user has agreed to terms and conditions
if (basename($_SERVER['PHP_SELF']) != "Disclaimer.php" && !isset($_SESSION['agreed_to_terms'])) {
    header("Location: Disclaimer.php");
    exit();
}

// Check if user data is available in the session
if (!isset($_SESSION['user_data'])) {
    header("Location: CustomerInfo.php");
    exit();
}

// Initialize variables for principal, time, and interest rate
$principal = $time = $interestRate = $total = $interest = 0;
$errors = [];

// Check if the form is submitted and the "Calculate" button is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["calculate"])) {
    // Retrieve user input (principal, time, etc.)
    $principal = isset($_POST["principal"]) ? floatval($_POST["principal"]) : 0;
    $time = isset($_POST["time"]) ? intval($_POST["time"]) : 0;

    // Validate and calculate interest and total amounts
    if ($principal > 0 && $time > 0) {
        // Calculate interest rate (you might get this from user input as well)
        $interestRate = 0.03; // 3% interest rate

        // Calculate interest and total amount
        $interest = $principal * $interestRate * $time;
        $total = $principal + $interest;
    } else {
        $errors[] = "Principal amount and time must be greater than 0.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Calculator</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
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
    <div class="container">
        <h1>Deposit Calculator</h1>
        <p>Enter principal amount and select the number of years to deposit.</p>

        <!-- Display form -->
        <form method="post">
            <div class="form-group">
                <label for="principal">Principal Amount:</label>
                <input type="text" id="principal" name="principal" value="<?= $principal ?>">
            </div>

            <div class="form-group">
                <label for="time">Years to Deposit:</label>
                <select id="time" name="time">
                    <option value="">Select...</option>
                    <?php for ($i = 1; $i <= 15; $i++): ?>
                        <option value="<?= $i ?>"<?= $i === $time ? ' selected' : '' ?>><?= $i ?> Years</option>
                    <?php endfor; ?>
                </select>
            </div>

            <input type="submit" name="calculate" value="Calculate"> <!-- Added name attribute -->
        </form>

        <!-- Display errors if any -->
        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif ($total > 0): ?>
            <h2>Results of the calculation at the current interest rate of 3%</h2>
            <table>
                <tr>
                    <th>Year</th>
                    <th>Principal at Year Start</th>
                    <th>Interest for the Year</th>
                </tr>
                <?php
                $principalAtYearStart = $principal;
                for ($year = 1; $year <= $time; $year++) {
                    $interestYear = $principalAtYearStart * $interestRate;
                    $principalAtYearStart += $interestYear;
                ?>
                <tr>
                    <td><?= $year ?></td>
                    <td>$<?= number_format($principalAtYearStart, 2) ?></td>
                    <td>$<?= number_format($interestYear, 2) ?></td>
                </tr>
                <?php } ?>
            </table>
        <?php endif; ?>

        <a href="ContactTime.php"><input type="button" value="Previous"></a>
        <?php if (empty($errors)): ?>
            <a href="Complete.php"><input type="button" value="Complete"></a>
        <?php else: ?>
            <p style="color: red;">Invalid inputs. Please correct the errors.</p>
        <?php endif; ?>
    </div>
</body>
</html>
