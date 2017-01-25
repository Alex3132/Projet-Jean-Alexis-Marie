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
            header('Location:index.php');
        }
    }
    catch (Exception $exception)
    {
        $unknownuser = true;
    }
}

