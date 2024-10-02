<?php
include("./header.php");
//include("./Posts.php");
$loginStatus = CheckLogin();

//On vérifie qu'on a bien un ID
if ( isset($_GET["id"]) ){
    $query = 'SELECT * FROM `post` WHERE `id` ='.$_GET["id"]; //si on a l'ID alors on va chercher tous les posts qui ont l'id correspondante
    $result = $db->query($query);
        
    if ( $result->num_rows > 0 )
    {  //on les prend uniquement s'il y en a 
        $data = $result->fetch_assoc();
    
    

    /*Le formulaire ci-dessous nous permet de modifier les posts
    Il nous renverra sur "post_output" après validation de l'utilisateur*/

    /*L'image avant modificaton sera affichée dans le form pour permettre a l'utilisateur de ne pas l'oublier d'une page à une autre
    (cas qui m'arrivais trop souvent durant mes tests de cette page)*/

    /*Dans chaque champ, on peut voir le texte actuel et le modifier plutôt que de devoir tout retaper si on veut
    faire une simple petite modification*/

    /*Dans le champ "<input type="hidden" name="MAX_FILE_SIZE" value="31457280"/>" j'ai mis une valeur élevée pour la taille maximale
    Cependant, mettre par exemple un gif qui fait plus d'environ 3Mo ne va pas s'afficher
    Son lien sera bien envoyé dans la bdd, donc il n'est pas "trop grand" mais je ne parviens pas à régler ce problème*/

        ?>
        <form action="./post_output.php" method="POST" enctype="multipart/form-data">
        <div class=formulaire>
            <div class="formbutton">Modification d'un post</div><br>
            <div>
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="<?php echo $_GET["id"];?>"> 
                <label for="nom_post">Titre :</label><br>
                <input autofocus type="text" name="nom_post" value="<?php echo $data["nom_post"];?>">
            </div>
            <div><br>
                <input type="hidden" name="MAX_FILE_SIZE" value="31457280"/>
                Modifier une image: <input class="file" type="file" name="img" id="img" value="<?php echo $data["img"];?>"><br>
                <br><img src="<?php echo $data["img"]; ?>" lenght=300px width=300px alt="Image actuelle"/><br><br>
            </div>
            <div>
                <label for="description">Description:</label>
                <textarea name="description"><?php echo $data["description"];?></textarea>
            </div>
            <div class="formbutton"><br><br>
                <button type="submit">Modifier le post</button><br><br>
            </div>
        </form>

    <?php
    /*Le formulaire ci-dessous nous permet de supprimer un post
    Il nous renverra sur "post_output" après validation de l'utilisateur*/

    /*Il va afficher un messsage popup d'erreur qui fonctionne grâce a Javasript 
    si l'utilisateur clique dessus grâce à l'attribut "onclick" */
    ?>

        <form action="./post_output.php" method="POST">
            <div class="formbutton">Cliquez le bouton ci-dessous pour effacer le post</div>
            <div>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo $_GET["id"];?>">
            </div>
            <br><div class="formbutton">
            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?')">Supprimer le post</button>    </div>
        </div>
        </form>


<?php
    }//si il n'y a pas de post il n'y a pas de raison de le modifier
    else {
        echo "<h1>Erreur! Cette ID ne correspond à aucun post!</h1>";
    }
}
DisconnectDatabase();
?>