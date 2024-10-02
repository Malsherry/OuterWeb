<?php include("./header.php"); ?>
<body>


 <div class="formulaire">
            <form action="post_output.php" method="post" enctype="multipart/form-data"><h2>Nouveau post</h2><br>
                <label>
                <input type="hidden" name="action" value="new">
                    Intitulé du post : <input class="texte" type="text" name="nom_post" id="nom_post" placeholder ="Nom de post" required="required" size="30">
                </label> <br>
                <label>
                <input type="hidden" name="MAX_FILE_SIZE" value="31457280"/>
                    Ajouter une photo: <input class="file" type="file" name="img" id="img">
                </label><br>
                <label class="description">
                    Description du post:<input class="bigTexte" type="text" name="description" id="description" placeholder="Une belle journée sur Âtrebois" required="required" size="30">
                </label><br> 
                <label>
                    <input class = "submit" type="submit" value="Poster">
                </label>
            </form>
        </div>

</body>
</html>

