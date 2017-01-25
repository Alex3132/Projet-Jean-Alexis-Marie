<?php
session_start();
require_once('DbUtils.php');
require_once('utils.php');

if(isset($_POST[PSEUDO]) && isset($_POST[PWD])) {
    try
    {
        $pseudo = $_POST[PSEUDO];
        $pwd = $_POST[PWD];
        if($pseudo != "" && $pwd != "")
        {
            $user = $connect->getUser($pseudo, $pwd);
            $_SESSION[ID] = $user->getId();
            $_SESSION[PSEUDO] = $user->getLogin();
            $_SESSION[PWD] = $user->getMdp();
            $_SESSION[PROFIL] = $user->getProfil();
            //require_once("accueil.php");
            //exit();
            //echo '<script>setTimeout(window.location="index.php?page='.$pagesOK[INDEX].'", 500);</script>';
            header('Location:index.php');
        }
    }
    catch (Exception $exception)
    {
        $unknownuser = true;
    }
}

