

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Recherche</title>
 
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#recherche-form').on('submit', function(e) {
        e.preventDefault(); //on empêche la page de se reload automatiquement
        $.ajax({ //on commence la requête ajax
          url: 'recherche.php', //page qui gère la requête
          type: 'GET', //on précise qu'on utilise la méthode GET
          data: $(this).serialize(), //envoie les données à la page php
          success: function(data) { //lorsque la requête AJAX est réussie
            $('#result').html(data); //on insère les résultats de la requête dans la variable
          }
        });
      });
    });
  </script>
</head>
<body>
<div class=rechercher>
<form method="get" id="recherche-form">
    <input type="text" name="query" placeholder="Rechercher...">
  </form>
</div><br>
  <div id="result"></div>

<script>
    $(document).ready(function() {
      $('#recherche-form input[name="query"]').on('keyup', function() {
        var query = $(this).val();
        if (query.length >= 1) { // ne pas envoyer de requête si l'utilisateur n'a tapé que 2 lettres ou moins
          $.ajax({
            url: 'recherche.php',
            method: 'GET',
            data: { query: query },
            success: function(data) {
              $('#result').html(data);
            }
          });
        }
      });
    });
</script>

</body>
</html>

