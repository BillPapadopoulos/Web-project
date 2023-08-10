function displayFrame(number) {
  const frameDisplay = document.getElementById('frameDisplay');
  frameDisplay.innerHTML = ''; // Clear current display
  const img = document.createElement('img');
  img.src = images/frame$(number).jpg;
  frameDisplay.appendChild(img);
}