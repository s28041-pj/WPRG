<!DOCTYPE html>
<html>
<head>
    <title>Factorial calculate</title>
</head>
<body>
<h1>Factorial calculate</h1>

<form method = "post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="numberN">Enter the number:</label>
    <label>
        <input type="number" name="numberN" required>
    </label>
    <button type="submit">Calculate</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n = $_POST['numberN'];

    $start = microtime(true);
    $factorial_iteratively = factorial_iteratively($n);
    $end = microtime(true);
    $time_factorial_iteratively = $end - $start;


    $start2 = microtime(true);
    $factorial_recursively = factorial_recursively($n);
    $end2 = microtime(true);
    $time_factorial_recursively = $end2 - $start2;

    writeOut($n, $factorial_iteratively, $time_factorial_iteratively, $factorial_recursively, $time_factorial_recursively);

}

function factorial_recursively($n) {
    if ($n <= 1) {
        return 1;
    }
    else {
        return $n * factorial_recursively($n-1);
    }
}
function factorial_iteratively($n) {
    $result = 1;
    for ($i = 2; $i <= $n; $i++) {
        $result *= $i;
    }
    return $result;
}

function writeOut($n, $factorial_iteratively, $time_factorial_iteratively, $factorial_recursively, $time_factorial_recursively)
{

    echo "<h2>Results for number $n:</h2>";
    echo "<p>Factorial iteratively: $factorial_iteratively, time: $time_factorial_iteratively</p>";
    echo "<p>Factorial recursively: $factorial_recursively, time: $time_factorial_recursively</p>";
    if ($time_factorial_iteratively > $time_factorial_recursively) {
        $fasterTime = $time_factorial_iteratively - $time_factorial_recursively;
        echo "<p> Faster was recursively version by $fasterTime</p>";
    } elseif ($time_factorial_recursively > $time_factorial_iteratively) {
        $fasterTime = $time_factorial_recursively - $time_factorial_iteratively;
        echo "<p> Faster was iteratively version by $fasterTime</p>";
    } else {
        echo "<p> Both execute in the same time";
    }
}
?>
</body>
</html>