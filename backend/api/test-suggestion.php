<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Auto Suggest Artist Search</title>
  <style>
    body { font-family: Arial; margin: 20px; }
    input { padding: 8px; width: 300px; }
    ul { list-style: none; padding: 0; margin-top: 10px; max-width: 400px; }
    li { padding: 6px 0; border-bottom: 1px solid #ccc; }
  </style>
</head>
<body>

<h2>Artist Auto-Suggest Search</h2>
<input type="text" id="searchInput" placeholder="Start typing artist name..." autocomplete="off">
<ul id="results"></ul>

<script>
const input = document.getElementById('searchInput');
const resultList = document.getElementById('results');

input.addEventListener('input', function () {
  const query = input.value.trim();
  if (query.length < 1) {
    resultList.innerHTML = '';
    return;
  }

  fetch(`http://localhost/Artist-Discovery-Engine/backend/api/search-api.php?q=${encodeURIComponent(query)}`)
    .then(res => res.json())
    .then(data => {
      resultList.innerHTML = '';
      data.forEach(artist => {
        const li = document.createElement('li');
        li.innerHTML = `<strong>${artist.name}</strong><br><small>${artist.genre} – ${artist.location}</small>`;
        resultList.appendChild(li);
      });
    })
    .catch(err => {
      console.error(err);
      resultList.innerHTML = '<li style="color:red;">Error fetching results</li>';
    });
});
</script>

</body>
</html>
