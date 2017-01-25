<?php
session_start();
if(!empty($_GET['page']))
{
	//Remplace la valeur par defaut par celle de l'URL
	$page = $_GET['page'];
} else
{
    $page = 'accueil';
}

?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
        <script src="js/main.js"></script>
        <title><?php $page ?></title>

    </head>

    <body>

        <?php include('header.php');?>

            <?php include('menu.php'); ?>

                <?php include('fonct.php') ?>

                    <?php include('footer.php'); ?>

    </body>

    </html>