<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reddit App</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f8fa;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #0079d3;
      color: white;
      padding: 10px;
      text-align: center;
    }

    #subreddit-list {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      margin: 20px;
    }

    .subreddit-card {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin: 10px;
      overflow: hidden;
      transition: transform 0.2s ease-in-out;
      width: 300px;
    }

    .subreddit-card:hover {
      transform: scale(1.05);
    }

    .subreddit-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 1px solid #ddd;
    }

    .subreddit-card-info {
      padding: 20px;
    }

    .subreddit-card h3 {
      margin: 0;
      font-size: 1.5em;
      margin-bottom: 10px;
    }

    .subreddit-card p {
      margin: 0;
      color: #666;
    }

    .details-button {
      background-color: #0079d3;
      color: white;
      border: none;
      padding: 10px;
      font-size: 14px;
      cursor: pointer;
      border-radius: 5px;
      margin-top: 10px;
      width: 100%;
    }

    .subreddit-details {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin: 20px;
      overflow: hidden;
      display: none;
    }

    .subreddit-details img {
      width: 100%;
      height: auto;
    }

    .back-button {
      background-color: #0079d3;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
      margin-top: 20px;
    }
  </style>
</head>
<body>

  <header>
    <h1>Reddit App</h1>
  </header>

  <div id="subreddit-list"></div>

  <div id="subreddit-details" class="subreddit-details">
    <h2 id="detail-title"></h2>
    <img id="detail-image" alt="">
    <div id="detail-content" class="subreddit-card-info"></div>
    <button class="back-button" onclick="backToList()">Volver a la lista</button>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
    $(document).ready(() => {
    
      $.get('api.php', (data) => {
        
        data.forEach((subreddit) => {
          const $subredditCard = $(`
            <div class="subreddit-card" data-id="${subreddit.id}">
              <img src="${subreddit.image_url}" alt="${subreddit.name}" onerror="setDefaultImage(this)">
              <div class="subreddit-card-info">
                <h3>${subreddit.name}</h3>
                <p>${subreddit.description}</p>
                <button class="details-button" onclick="showSubredditDetail(${subreddit.id})">Ver Detalles</button>
              </div>
            </div>
          `);

          $('#subreddit-list').append($subredditCard);
        });
      });
    });

    function showSubredditDetail(subredditId) {
      
      $.get(`api.php?id=${subredditId}`, (subreddit) => {
       
        $('#subreddit-list').hide();

    
        $('#detail-title').text(subreddit.title);
        $('#detail-image').attr('src', subreddit.image_url);

        const detailContent = `
          <h3>${subreddit.name}</h3>
          <p>${subreddit.description}</p>
          <p>Número de suscriptores: ${subreddit.subscribers}</p>
          <p><a href="${subreddit.url}" target="_blank">${subreddit.url}</a></p>
        `;

        $('#detail-content').html(detailContent);

        
        $('#subreddit-details').show();
      });
    }

    function backToList() {
      
      $('#subreddit-list').show();
      $('#subreddit-details').hide();
    }

    function setDefaultImage(imgElement) {
    if (!imgElement.errorHandled) {
    imgElement.style.display = 'none';  
    imgElement.onerror = null;  


  }
}
  </script>

</body>
</html>
