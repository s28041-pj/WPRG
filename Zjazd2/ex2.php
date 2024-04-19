<!DOCTYPE html>
<html>
<head>
    <title>Hotel reservation</title>
</head>
<body>
<h1>Hotel reservation form</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="num_of_guests">Number of guests:</label>
    <input type="number" name="num_of_guests" id="num_of_guests">
    <br>

    <label for="first_name">First name:</label>
    <input type="text" id="first_name" name="first_name" required>
    <br>

    <label for="last_name">Last name:</label>
    <input type="text" id="last_name" name="last_name" required>
    <br>

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required>
    <br>

    <label for="credit_card">Credit card number:</label>
    <input type="text" id="credit_card" name="credit_card" required>
    <br>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required>
    <br>

    <label for="start_date">Start reservation date:</label>
    <input type="date" id="start_date" name="start_date" min="<?php echo date('Y-m-d'); ?>" required>
    <br>

    <label for="end_date">End reservation date:</label>
    <input type="date" id="end_date" name="end_date" min="<?php echo date('Y-m-d'); ?>" required>
    <br>

    <label for="child_bed">Bed for child:</label>
    <input type="checkbox" id="child_bed" name="child_bed">
    <br>

    <label for="amenities">Amenities:</label>
    <select id="amenities" name="amenities[]" multiple>
        <option value="airConditioning">Air conditioning</option>
        <option value="tv">TV</option>
        <option value="wifi">WiFi</option>
        <option value="minibar">MiniBar</option>
    </select>
    <br>

    <input type="submit" value="Sent">
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $error = validations();

    showReservationSummary($error);

}

function validations()
{
    $error = "";

    if (empty($_POST["num_of_guests"])) {
        $error .= "Number of guests are required<br>";
    }

    if (empty($_POST["first_name"])) {
        $error .= "First name is required<br>";
    }

    if (empty($_POST["last_name"])) {
        $error .= "Last name is required<br>";
    }

    if (empty($_POST["address"])) {
        $error .= "Address is required<br>";
    }

    if (empty($_POST["credit_card"])) {
        $error .= "Number of credit card i required<br>";
    }

    if (empty($_POST["email"])) {
        $error .= "E-mail is required<br>";
    } else {
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error .= "Invalidate of email format<br>";
        }
    }

    if (empty($_POST["start_date"]) || empty($_POST["end_date"])) {
        $error .= "Reservation date is required<br>";
    }

    $current_date = date('Y-m-d 00:00:00');
    if (strtotime($_POST["start_date"]) < strtotime($current_date)) {
        $error .= "Cannot add start date before today<br>";
    }

    if (strtotime($_POST["end_date"]) < strtotime($_POST["start_date"])
        && date('Y-m-d', strtotime($_POST["end_date"])) != date('Y-m-d', strtotime($_POST["start_date"]))) {
        $error .= "End date cannot be before start day<br>";
    }

    return $error;
}

function showReservationSummary($error)
{
    if ($error == "") {
        echo "<h2>Reservation summary:</h2>";
        echo "<p>Guest number: " . $_POST["num_of_guests"] . "</p>";
        echo "<p>First name: " . $_POST["first_name"] . "</p>";
        echo "<p>Last name: " . $_POST["last_name"] . "</p>";
        echo "<p>Address: " . $_POST["address"] . "</p>";
        echo "<p>Credit card number: " . $_POST["credit_card"] . "</p>";
        echo "<p>E-mail: " . $_POST["email"] . "</p>";
        echo "<p>Reservation start date: " . $_POST["start_date"] . "</p>";
        echo "<p>Reservation end date: " . $_POST["end_date"] . "</p>";
        if (isset($_POST["child_bed"])) {
            echo "<p>Bed for child: yes</p>";
        } else {
            echo "<p>Bed for child: no</p>";
        }
        if (isset($_POST["amenities"])) {
            echo "<p>Amentities: " . implode(", ", $_POST["amenities"]) . "</p>";
        } else {
            echo "<p>Amentities: none</p>";
        }
    } else {
        echo "<span style=\"color: red; \"><h2>Errors:</h2></span>";
        echo "<span style=\"color: red; \"><p>$error</p></span>";
    }
}
?>
</body>
</html>