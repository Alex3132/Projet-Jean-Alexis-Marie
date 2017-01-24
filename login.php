
<?php
require_once('DbUtils.php');

if(isset($_POST['pseudo']) && isset($_POST['pwd'])) {
    try
    {
        if($pseudo != "" && $pwd != "") {
            $user = $connect->getUser($_POST['pseudo'], $_POST['pwd']);
        }
    }
    catch (Exception $exception)
    {
        $unknownuser = true;
    }
}

?>


<div id="errorUser" class="<?php echo (isset($unknownuser)) ? '' : 'hidden' ?>">Votre pseudo et votre mode passe ne correspondent pas.</div>

<form action="#" method="post">
    <div id="connection">
        <div class="pseudo">
            <label>Pseudo :</label>
            <input type="text" name="pseudo" id="pseudo">
        </div>
        <div class="password">
            <label>Mot de passe :</label>
            <input type="password" name="pwd" id="pws">
        </div>
        <input type="submit" value="Envoyer">
    </div>
</form>