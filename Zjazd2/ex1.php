<!DOCTYPE html>
<html>
<head>
    <title>Calculator</title>
</head>
<body>
<h1>Calculator</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="numberA">Number 1:</label>
    <input type="number" name="numberA" id="numberA">
    <br>

    <label for="numberB">Number 2:</label>
    <input type="number" name="numberB" id="numberB">
    <br>

    <label for="operation">Operation:</label>
    <select name="operation" id="operation">
        <option value="addition">Addition</option>
        <option value="subtraction">Subtraction</option>
        <option value="multiplication">Multiplication</option>
        <option value="division">Division</option>
    </select>

    <button type="submit" name="submit">Calculate</button>
</form>
<?php
if (isset($_POST['submit'])) {
    $numberA = $_POST['numberA'];
    $numberB = $_POST['numberB'];
    $operation = $_POST['operation'];

    $result = mathematicalOperations($operation, $numberA, $numberB);
    showResult($numberB, $operation, $numberA, $result);

}

function mathematicalOperations($operation, $numberA, $numberB)
{
    switch ($operation) {
        case 'addition':
            $result = $numberA + $numberB;
            break;
        case 'subtraction':
            $result = $numberA - $numberB;
            break;
        case 'multiplication':
            $result = $numberA * $numberB;
            break;
        case 'division':
            if ($numberB == 0) {
                $result = 0;
            } else {
                $result = $numberA / $numberB;
            }
            break;
    }
    return $result;
}

function showResult($numberB, $operation, $numberA, $result)
{
    if ($numberB == 0) {
        echo "<span style=\"color: red; \">Cannot divide by zero!</span>";
    } else {
        echo "Result of $operation for numbers $numberA and $numberB is: $result";
    }
}
?>
</body>
</html>