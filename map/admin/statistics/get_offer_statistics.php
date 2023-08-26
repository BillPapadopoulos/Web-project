<?php
session_start();
// Establish connection with the database
$conn = mysqli_connect('localhost', 'root', '', 'web_database');

if ($conn) {
    $year = $_GET['year'];
    $month = $_GET['month'];

    // Prepare and execute the SQL query to fetch offer statistics
    $query = "SELECT DAY(register_date) as day, COUNT(*) as count FROM offer WHERE YEAR(register_date) = $year AND MONTH(register_date) = $month GROUP BY day";
    $result = mysqli_query($conn, $query);

    $statisticsData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $statisticsData[] = $row;
    }

    // Return the statistics data as JSON
    echo json_encode($statisticsData);
} else {
    echo "Database connection error.";
}
?>
