<!DOCTYPE html>
<html lang="fr">
  <head>
    <?php include("./header.php");?>
    <meta charset="UTF-8" />
  </head>

  <body>
  <h2>Vous avez fait une erreur dans votre mail ou votre mot de passe</h2>
    <p class=error>Ce timer vous redirigera vers la page de login dans: <div id="timer"></div> </p>
    <p class=error>J'aurais pu mettre moins de temps mais on aurait pas le temps de lire les infos sur cette page</p>
    <p class=error>On peut simplement cliquer sur un onglet du menu pour aller plus vite</p>
    <p class="error"> Je voulais apprendre a faire un timer en javascript et je pense que c'est un bon endroit ou le mettre</p>
    <script src="timer.js"></script>
    <?php header ('refresh:10;url=login.php'); /*on retourne sur la page de login*/ ?>
  </body>
</html>