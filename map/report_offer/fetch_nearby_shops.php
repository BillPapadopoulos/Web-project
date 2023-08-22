<?php
header('Content-Type: application/json');
$conn = mysqli_connect('localhost','root','', 'web_database');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['lat']) && isset($_GET['lng'])) {
    $lat = mysqli_real_escape_string($conn, $_GET['lat']);
    $lng = mysqli_real_escape_string($conn, $_GET['lng']);

    $query = "SELECT lat, lon, shop_name, shop_id 
            FROM shop 
            WHERE SQRT(POWER((lat - $lat) * 111.12, 2) + POWER((lon - $lng) * 85.39, 2)) < 1.5;
            ";

    $result = $conn->query($query);
     // Add debug logging after query execution
     if (!$result) {
        error_log("Error executing query: " . $conn->error);
        echo json_encode(["error" => "Error executing query."]);
        exit;
    }
    error_log("Latitude: $lat, Longitude: $lng");

    $shops = [];
    
    while($row = $result->fetch_assoc()) {
        $shops[] = array("lat"=>$row["lat"], "lon"=>$row["lon"], "Details"=>$row['shop_name'], "ID"=>$row["shop_id"]);
    }

    error_log(print_r($shops, true));
    
    echo json_encode($shops);
} else {
    echo json_encode([]);
    
}

// Close the database connection
mysqli_close($conn);
?>
