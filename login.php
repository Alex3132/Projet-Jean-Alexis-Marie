<?php
require_once('DbUtils.php');
require_once('utils.php');
//if(isset($_POST[PSEUDO]) && isset($_POST[PWD])) {
//    try
//    {
//        $pseudo = $_POST[PSEUDO];
//        $pwd = $_POST[PWD];
//        if($pseudo != "" && $pwd != "") {
//            $user = $connect->getUser($pseudo, $pwd);
//            $_SESSION[PSEUDO] = $user->getLogin();
//            $_SESSION[PWD] = $user->getMdp();
//            $_SESSION[PROFIL] = $user->getProfil();
//            //require_once("accueil.php");
//            //exit();
//            echo '<script>setTimeout(window.location="index.php?page='.$pagesOK[INDEX].'", 500);</script>';
//        }
//    }
//    catch (Exception $exception)
//    {
//        $unknownuser = true;
//    }
//}
?>

<div class="containerform">
    <div id="errorUser" class="<?php echo (isset($unknownuser)) ? '' : 'hidden' ?>">Votre pseudo et votre mode passe ne correspondent pas.</div>
    <div class="titreform">Connexion</div>
    <form action="verif.php" onsubmit="return verifFormLogin(this)" method="post">
        <div class="pseudo">
            <label>Pseudo :</label>
            <input type="text" name="pseudo" id="pseudo" />
        </div>
        <div class="password">
            <label>Mot de passe :</label>
            <input type="password" name="pwd" id="pwd" />
        </div>
        <input type="submit" value="Envoyer" />
    </form>
</div>