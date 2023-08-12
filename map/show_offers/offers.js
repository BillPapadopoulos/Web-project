//fetches the offers from the database and displays them in frameDisplay. It also tries to display the corresponding button for the category.
function displayFrame(category) {
    const frameDisplayTable = document.getElementById('frameDisplayTable');
    const frameDisplay = document.getElementById('frameDisplay');
    const buttons = document.querySelectorAll('.shop-button');

    // Hide all shop buttons first
    buttons.forEach(button => button.style.display = 'none');

    // Fade out the current table
    frameDisplayTable.style.opacity = 0;

    // Wait for the fade out transition to complete, then load new content
    setTimeout(() => {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                frameDisplayTable.innerHTML = this.responseText;

                // Fade in the new table
                frameDisplayTable.style.opacity = 1;

                // Show the shop button for the clicked category
                const button = frameDisplay.querySelector(`button[onclick="redirectToFilteredMap('${category}')"]`);
                if (button) button.style.display = 'block';
            }
        };

        // Send request to get offers
        xmlhttp.open("GET", "get_frame_offers.php?category=" + category, true);
        xmlhttp.send();

    }, 250); //   the duration of the fade out, should match the CSS transition duration

}

function redirectToFilteredMap(category){
    window.location.href = `/web_database/map/show_offers/filteredmap.php?category=${category}`;
}


  




