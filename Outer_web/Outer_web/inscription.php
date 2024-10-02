<?php include("./header.php"); ?>

<body>
 
 <div class="formulaire">
        <!--<form method="post" onsubmit="return CheckNewAccountForm();" >-->
            <form action="inscription_output.php" method="post" enctype="multipart/form-data">
                <h2>Inscrivez-vous pour pouvoir poster et discuter avec les autres utilisateurs</h2>
                <label>
                    Nom : <input class="texte" type="text" name="texte_nom" id="texte_nom" placeholder ="Smith" required="required" size="30">
                </label> <br/>
                <label>
                    Prenom : <input class="texte" type="text" name="texte_prenom" id="texte_prenom" placeholder="John" required="required" size="30">
                </label><br>
                <label>
                    Surnom : <input class="texte" type="text" name="texte_surnom" id="texte_surnom" placeholder="Surnom" size="30">
                </label><br>
                <label>
                    Email : <input class="texte" type="email" name="texte_email" id="texte_email" placeholder="exemple@mail.fr" required="required" size="30">
                </label><br>
                <label>
                    Mot de Passe : <input class="texte" type="password" name="mdp" id="mdp" required="required" size="30">
                </label><br>
                
                <label for="confirm">Confirmer mot de passe :</label>
                <input class="texte" type="password" id="confirm" name="confirm">
                <br>
                <label>
                <input type="hidden" name="MAX_FILE_SIZE" value="5242880"/>
                    Ajouter une photo de profil: <input class="file" type="file" name="img" id="img" required="required">
                </label><br><br>
                <label>
                    <input type="submit" value="S'inscrire" onclick="return CheckNewAccountForm();">
                </label>
             
				<br><p>Déjà un compte? Cliquez <a class = "lien" href="login.php">Ici</a> </p>
            </form>
        </div>
</body>
</html>   