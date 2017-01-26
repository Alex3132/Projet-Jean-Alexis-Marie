<?php

// declaration des pages

const INDEX = 'accueil';
const EDIT = 'maintenance';
const LOGIN = 'login';
const SEARCH = 'recherche';
//const INSCR = 'inscription';
const DECON = 'deconnection';

//Tableau des pages autorisées à l'include
$pagesOK[INDEX] = 'Accueil';
$pagesOK[SEARCH] = 'Recherche';
$pagesOK[LOGIN] = 'Identification';
//$pagesOK[INSCR] = 'Inscription';
$pagesOK[EDIT] = 'Maintenance';

$pagesdeco[DECON] = 'Déconnexion';

// declaration des variable de session utile
const PSEUDO = 'pseudo';
const PWD = 'pwd';
const PROFIL = 'profil';
const ID = '_id';

const DEPBYREGION = "getDepsOfregion.php";


function getBaseUrl()
{
    $pageURL = 'http';
    //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/";
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"]."/";
    }
    return $pageURL;
}