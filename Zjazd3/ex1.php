<!DOCTYPE html>
<html>
<head>
    <title>Date of birth</title>
</head>
<body>
<h1>Date of birth</h1>

<form method = "get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label>Enter your birth of day:</label>
    <label>
        <input type="date" name="date_of_birthday" required>
    </label>
    <br>
    <br>
    <input type="submit" value="Send">
</form>

<?php
if (isset($_GET['date_of_birthday'])) {
    $date_of_birthday = $_GET['date_of_birthday'];
    $age = floor((time() - strtotime($date_of_birthday)) / 31556926);
    $today = date('Y-m-d');
    $next_birthday = date('Y-m-d', strtotime($date_of_birthday . $age));
    $day_of_week = date('l', strtotime($date_of_birthday));

    $day_count = calculateDayDifference($next_birthday, $today, $age, $date_of_birthday);

    writeOut($day_of_week, $age, $day_count);
}

function calculateDayDifference($next_birthday, $today, $age, $date_of_birthday)
{
    $day_difference = strtotime($next_birthday) - strtotime($today);
    if ($day_difference < 0) {
        $next_birthday = date('Y-m-d', strtotime($date_of_birthday . " +" . ($age +1 ) . " year"));
        $day_difference = strtotime($next_birthday) - strtotime($today);
    }
    return round($day_difference / (60 * 60 * 24));
}

function writeOut($day_of_week, $age, $day_count)
{
    echo "<h2>Day of the week of your birth:</h2><h1>$day_of_week</h1>";
    echo "<h2>Your age:</h2><h1>$age</h1>";
    echo "<h2>Days until your next birthday:</h2><h1>$day_count</h1>";
}
?>
</body>
</html>