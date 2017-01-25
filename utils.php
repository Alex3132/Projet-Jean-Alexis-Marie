<?php

// declaration des pages

const INDEX = 'accueil ';
const EDIT = 'maintenance ';
const LOGIN = 'login';
const SEARCH = 'recherche';
const INSCR = 'inscription';
const DECON = 'deconnection';

//Tableau des pages autorisées à l'include
$pagesOK[INDEX] = 'Accueil';
$pagesOK[SEARCH] = 'Recherche';
$pagesOK[LOGIN] = 'Identification';
$pagesOK[INSCR] = 'Inscription';
$pagesOK[EDIT] = 'Maintenance';

$pagesdeco[DECON] = 'Déconnexion';

// declaration des variable de session utile
const PSEUDO = 'pseudo';
const PWD = 'pwd';
const PROFIL = 'profil';
const ID = '_id';

