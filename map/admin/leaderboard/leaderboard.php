<?php
session_start();

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 10;  // Number of users to display per page
$offset = ($page - 1) * $itemsPerPage;  // Calculate the offset

$conn = mysqli_connect('localhost', 'root', '', 'web_database');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Example query to select top users/entities for the leaderboard (adjust as needed)
$query = "SELECT user_username as user_name, total_score as user_score FROM user ORDER BY total_score DESC LIMIT $itemsPerPage OFFSET $offset";

$result = mysqli_query($conn, $query);

$leaderboardData = [];
while ($row = mysqli_fetch_assoc($result)) {
  $leaderboardData[] = $row;
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Leaderboard - e-katanalotis</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/web_database/map/admin/adm.css">

  <link rel="stylesheet" href="/web_database/map/admin/leaderboard/leaderboard_style.css">

</head>
<body>

<div class="menu-bar">
   <ul>
     <li><a href="/web_database/map/admin/admin_dashboard.php">Map</a></li>
     <li><a href="/web_database/map/admin/update_products.php">Update Products Data </a></li>
     <li><a href="/web_database/map/admin/update_shops.php">Update Shops Data</a></li>
     <li><a href="/web_database/map/admin/statistics/statistics.php">Statistics</a></li>
     <li class="pressed"><a href="/web_database/map/admin/leaderboard/leaderboard.php">Leaderboard</a></li>
     <li><a href="/web_database/map/admin/show_offers/offers.php">Available Offers</a></li>
     <li><a href="/web_database/map/admin/admin_settings/adm_settings.php">Admin : <?php echo $_SESSION['user_name']; ?> <br>Settings</a></li>
   </ul>
</div>

<div class="container">
  <h2>Leaderboard</h2>
  <br><br>
  <table>
    <thead>
      <tr>
        <th>Rank</th>
        <th>Username</th>
        <th>Score</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $rank = ($page - 1) * $itemsPerPage + 1;  // This will start from 1 on page 1, 11 on page 2, etc.

      foreach ($leaderboardData as $data) {
        echo "<tr>";
        echo "<td>{$rank}</td>";
        echo "<td>{$data['user_name']}</td>";
        echo "<td>{$data['user_score']}</td>";
        echo "</tr>";
        $rank++;
      }
      ?>
    </tbody>
  </table>
    <?php
        $totalUsers = $conn->query("SELECT COUNT(*) as count FROM user")->fetch_assoc()['count'];
        $totalPages = ceil($totalUsers / 10);

        echo '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $page) {
                 echo "<span>{$i}</span> ";  // Current page, no hyperlink
            } else {
                echo "<a href='leaderboard.php?page={$i}'>{$i}</a> ";
            }
        }
        echo '</div>';
    ?>
</div>

</body>
</html>
