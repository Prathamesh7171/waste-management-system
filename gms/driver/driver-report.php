<?php
// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=waste_management;charset=utf8mb4', 'username', 'password');

// Handle form submission
if (isset($_POST['submit'])) {
    // Get the form data
    $driver_id = $_POST['driver_id'];
    $report_time = $_POST['report_time'];

    // Insert the data into the database
    $stmt = $db->prepare('INSERT INTO driver_report_times (driver_id, report_time) VALUES (:driver_id, :report_time)');
    $stmt->bindParam(':driver_id', $driver_id, PDO::PARAM_INT);
    $stmt->bindParam(':report_time', $report_time, PDO::PARAM_STR);
    $stmt->execute();

    // Redirect back to the driver list page
    header('Location: driver-list.php');
    exit;
}

// Include the driver list page
include 'driver-list.php';

// Show the add form
echo '<h2>Add Driver Report Time</h2>';
echo '<form method="post" action="add-driver-report-time.php" class="driver-form">';
echo '<label for="driver_id">Driver:</label>';
echo '<select name="driver_id" class="driver-select">';
// Get the list of drivers from the database
$stmt = $db->query('SELECT id, name FROM drivers');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
}
echo '</select>';
echo '<label for="report_time">Report Time:</label>';
echo '<input type="time" name="report_time" required class="report-time-input">';
echo '<input type="submit" name="submit" value="Add" class="add-button">';
echo '</form>';