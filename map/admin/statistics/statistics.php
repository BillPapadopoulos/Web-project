<?php
session_start();
//establish connection with database
    $conn = mysqli_connect('localhost','root','', 'web_database');
?>

<!DOCTYPE html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<html>
<title>Statistics</title>

<head>
  <link rel="stylesheet" href="/web_database/map/admin/adm.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
  <style type="text/css">
    #chart-container {
        width: 1280px;
        height: auto;
    }
    #chart-container_2 {
        width: 1280px;
        height: auto;
    }
</style>
</head>
<body>
  <!-- Εδώ ορίζουμε το menu bar της ιστοσελίδας, δηλώνοντας όλα τα πιθανά link - pages στο interface του χρήστη -->
  <div class="menu-bar">
  <ul class="Starter Buttons">
     <li><a href="/web_database/map/admin/admin_dashboard.php">Map</a></li>
     <li><a href="/web_database/map/admin/update_products.php">Update Products Data </a></li>
     <li><a href="/web_database/map/admin/update_shops.php">Update Shops Data</a></li>
     <li  class="pressed"><a href="/web_database/map/admin/statistics/statistics.php">Statistics</a></li>
     <li><a href=#>LeaderBoard</a></li>
     <li><a href="/web_database/map/admin/admin_settings/adm_settings.php">Admin : <?php echo $_SESSION['user_name']; ?> <br>Settings</a></li>
    </ul>
  </div>


  <form>
    <label for="year">Select Year:</label>
    <input type="number" id="year" name="year" min="2000" max="2099" value="2023">

    <label for="month">Select Month:</label>
    <input type="number" id="month" name="month" min="1" max="12" value="8">

    <button type="button" onclick="updateStatistics()">Update Statistics</button>
  </form>


  <div id="chart-container">
  <canvas id="offerChart"></canvas>
  </div>

  <?php //<div id="mapid"></div> ?>
  <script src="map.js"></script> 

  <script>
function fetchOfferStatistics(year, month) {
    const chartContainer = document.getElementById('chart-container');
    const canvas = document.getElementById('offerChart');

    
    // Create an XMLHttpRequest object
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const data = JSON.parse(this.responseText);

            const labels = Array.from({ length: new Date(year, month, 0).getDate() }, (_, i) => i + 1);
            const counts = new Array(labels.length).fill(0);

            data.forEach(entry => {
                labels[entry.day - 1] = entry.day; // Set the label for the corresponding day
                counts[entry.day - 1] = entry.count; // Set the count for the corresponding day
            });

            new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Offers',
                        data: counts,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Monthly Offer Statistics'
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Day'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Offers'
                            }
                        }
                    }
                }
            });
        }
    };

    // Fetch offer statistics data from the PHP script
    xmlhttp.open("GET", `get_offer_statistics.php?year=${year}&month=${month}`, true);
    xmlhttp.send();
}


// Call the function with the selected year and month (you need to obtain these values from the user's selection)
//fetchOfferStatistics(2023, 8);

</script>

<script
  		src="https://code.jquery.com/jquery-3.6.3.min.js"
  		integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
  		crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="./app.js"></script>

<script>
function updateStatistics() {
    const year = document.getElementById('year').value;
    const month = document.getElementById('month').value;

    fetchOfferStatistics(year, month);
}
</script>

</div>
  </body>
</html>