<!DOCTYPE html>
<html>
<head>
    <title>Number checker is prime</title>
</head>
<body>
<h2>Prime number:</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Number: <input type="number" name="number" required><br>
    <input type="submit" name="submit" value="Submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number = $_POST["number"];
    $iterations = 0;
    if (is_numeric($number) && $number > 0 && $number == round($number)) {
        $isPrime = isPrime($number);
        echo "<p>Number $number ";
        if ($isPrime) {
            echo "<span style=\"color: green; \">Is prime number</p></span>";
        } else {
            echo "<span style=\"color: red; \">Is not prime number</p></span>";
        }
        echo "<p>Iterations for result: $iterations</p>";
    } else {
        echo "<span style=\"color: red; \"><p>This number is not a positive integer!</p></span>";
    }
}

function isPrime($number) {
    if ($number <= 1) {
        return false;
    }
    for ($i = 2; $i <= sqrt($number); $i++) {
        global $iterations;
        $iterations++;
        if ($number % $i == 0) {
            return false;
        }
    }
    return true;
}
?>
</body>
</html>