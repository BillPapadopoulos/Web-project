function displayFrame(category) {
  const frameDisplay = document.getElementById('frameDisplay');

  // Create an XMLHttpRequest object
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          frameDisplay.innerHTML = this.responseText;
      }
  };

  // Change the URL below to the PHP script that fetches the offers from the database
  xmlhttp.open("GET", "get_frame_offers.php?category=" + category, true);
  xmlhttp.send();
}

