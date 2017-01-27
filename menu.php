<?php

require_once("utils.php");

if(!empty($_GET['page']))
{
	//Remplace la valeur par defaut par celle de l'URL
	$page = $_GET['page'];
} 
else
{
    $page = 'accueil';
}

$connecte = isset($_SESSION[ID]);

?>

<nav id="menu">
   
            <?php
            foreach($pagesOK as $key => $pg)
            {
                if(!$connecte && ($key == EDIT))
                {
                    continue;
                }
                else if ($connecte && $key == LOGIN)
                {
                    continue;
                }

                echo '<div>';
                echo ($page == $key) ? "<a href=\"index.php?page=$key\" class=\"selected\">$pg</a>" : "<a href=\"index.php?page=$key\">$pg</a>";
                echo "</div>\n";
            }

            if($connecte) 
            {
                echo "<div><a href='".DECON.".php'>".$pagesdeco[DECON]."</a></div>";
            }

            ?>
            
</nav>

