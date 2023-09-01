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
  <script src="categories.js"></script>
  <link rel="stylesheet" href="/web_database/map/admin/statistics/statistics.css">
</head>
<body>
  <!-- Εδώ ορίζουμε το menu bar της ιστοσελίδας, δηλώνοντας όλα τα πιθανά link - pages στο interface του χρήστη -->
  <div class="menu-bar">
  <ul class="Starter Buttons">
     <li><a href="/web_database/map/admin/admin_dashboard.php">Map</a></li>
     <li><a href="/web_database/map/admin/update_products.php">Update Products Data </a></li>
     <li><a href="/web_database/map/admin/update_shops.php">Update Shops Data</a></li>
     <li  class="pressed"><a href="/web_database/map/admin/statistics/statistics.php">Statistics</a></li>
     <li><a href="/web_database/map/admin/leaderboard/leaderboard.php">Leaderboard</a></li>
     <li><a href="/web_database/map/admin/show_offers/offers.php">Available Offers</a></li>
     <li><a href="/web_database/map/admin/admin_settings/adm_settings.php">Admin : <?php echo $_SESSION['user_name']; ?> <br>Settings</a></li>
    </ul>
  </div>


  
  <div class="centered">
  <h2><b>Offer Graph<b></h2>
  </div>
  <div class="form1">
    <label for="year">Select Year:</label>
    <input type="number" id="year" name="year" min="2000" max="2099" value="2023">

    <label for="month">Select Month:</label>
    <input type="number" id="month" name="month" min="1" max="12" value="8">

    
    <button type="button" onclick="updateStatistics()">Update Statistics</button>
</div>


  <div id="chart-container">
  <canvas id="offerChart"></canvas>
  </div>

  <div class="centered">
    <h2><b>Average Price Graph</b></h2>
    <div class="form">
            <div class="select-dropdown">
            <select name="category" id="categoryDropdown" onchange="fetchSubcategories(this.value);">
            <option value="" selected="selected">Choose category</option>
                </select>
            </div>
            <div class="select-dropdown">
            <select name="subcategory" id="subcategory" onchange="fetchProducts(this.value);">
                    <option value="" selected="selected">Choose subcategory</option>
                </select>
            </div>
            <button type="button" onclick="updateOffers()">Update Offers</button>
    </div>
  </div>


    <div id="chart-container_2">
		<canvas id="priceChart"></canvas>
  </div>

  
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
fetchOfferStatistics(2023, 7);
</script>

<script>
function fetchPriceStatistics(subcategoryId) {
    const chartContainer = document.getElementById('chart-container_2');
    const canvas = document.getElementById('priceChart');

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const data = JSON.parse(this.responseText);

            const labels = data.map(entry => entry.day);
            const averagePrices = data.map(entry => entry.average_price);

            new Chart(canvas, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Average Price',
                        data: averagePrices,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Average Price Statistics'
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
                                text: 'Average Price'
                            }
                        }
                    }
                }
            });
        }
    };

    xmlhttp.open("GET", `get_avg.php?subcategory_id=${subcategoryId}`, true);
    xmlhttp.send();
}
</script>

<script
  		src="https://code.jquery.com/jquery-3.6.3.min.js"
  		integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
  		crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  

<script>
function updateStatistics() {
    const year = document.getElementById('year').value;
    const month = document.getElementById('month').value;

    fetchOfferStatistics(year, month);
}
</script>

<script>
function updateOffers() {
    const year = document.getElementById('year').value;
    const month = document.getElementById('month').value;

    fetchPriceStatistics(year, month);
}
</script>


</div>
  </body>
</html>