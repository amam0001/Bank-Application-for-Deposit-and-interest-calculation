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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contactTimes = isset($_POST["contactTimes"]) ? $_POST["contactTimes"] : [];

    if (empty($contactTimes)) {
        $contactTimesError = "You must select contact times for us to call you";
    } else {
        $_SESSION['contact_times'] = $contactTimes;
        $_SESSION['contact_method'] = $userData['preferredContact'];
        header("Location: DepositCalculator.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Contact Time</title>
    <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007B5E;
            color: #fff;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Select Contact Time</h1>
    <form method="post">
        <div>
            <p>When can we contact you? Check all applicable:</p>
            <?php
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

            foreach ($timeSlots as $index => $slot) {
                $isChecked = in_array($index, $contactTimes) ? 'checked' : '';
                echo "<label><input type='checkbox' name='contactTimes[]' value='$index' $isChecked>$slot</label><br>";
            }
            ?>
            <?php if (isset($contactTimesError)): ?>
                <p style="color: red;"><?php echo $contactTimesError; ?></p>
            <?php endif; ?>
        </div>
        <button type="submit" style="padding: 0px 8px; background-color: #007B5E; color: #fff; border: none; cursor: pointer;">Next</button>
    </form>
    <a href="CustomerInfo.php" style="display: inline-block; padding: 3px 5px; background-color: #007B5E; color: #fff; text-decoration: none; border: none; cursor: pointer;">Back</a>
</body>
</html>
