<?php

require_once("utils.php");

if(!empty($_GET['page']))
{
	//Remplace la valeur par defaut par celle de l'URL
	$page = $_GET['page'];
} else
{
    $page = 'accueil';
}

if ($page == "accueil") 
{
    include ("accueil.php");
} 
else if ($page == "recherche")
{
    
}