document.addEventListener("DOMContentLoaded", function() {
    fetch('components.html')
    .then(response => response.text())
    .then(data => {
      document.getElementById('navbar').innerHTML = data;
    });
  });

document.addEventListener("DOMContentLoaded", function() {
fetch('footers.html')
.then(response => response.text())
.then(data => {
    document.getElementById('footer').innerHTML = data;
});
});