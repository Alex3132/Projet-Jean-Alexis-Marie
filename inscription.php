<form action="inscrit.php" onsubmit="return verifFormInscription(this)" method="post">
    <div id="inscription">

        <div class="pseudo">
            <label for="pseudo">Pseudo :</label>
            <input type="text" id="pseudo" name="pseudo">
        </div>
        <div class="password">
            <label for="mdp">Mot de passe :</label>
            <input type="password" name="mdp" id="mdp">
        </div>
        <div class="password">
            <label for="mdp2">Mot de passe :</label>
            <input type="password" name="mdp2" id="mdp2">
        </div>
        <div class="password">
            <label for="mail">Mot de passe :</label>
            <input type="password" name="mail" id="mail">
        </div>
        <input type="submit" value="Envoyer">

    </div>
</form>