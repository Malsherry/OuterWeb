<?php include("./header.php");?>
<body>

 <div class="formulaire">
        <form method="post" action="./login_output.php">
            <h2>Se Connecter</h2>
            <label>
                <input class="texte" type="email" name="texte_email" id="texte_email" placeholder="Email" required="required" size="30">
            </label>
            <label>
                <input class="texte" type="password" name="mdp" id="mdp" placeholder="Mot de Passe" required="required" size="30">
            </label><br>
            <label>
                <input class="submit" type="submit" value="Se connecter">
            </label>
        </form>
    </div>
</body>
</html>