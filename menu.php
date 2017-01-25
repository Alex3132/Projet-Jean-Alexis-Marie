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

$connecte = isset($_SESSION[PSEUDO]);

?>

<div id="menu">
    <nav>
        <ul>

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

                echo '<li>';
                echo ($page == $key) ? "<a href=\"index.php?page=$key\" class=\"selected\">$pg</a>" : "<a href=\"index.php?page=$key\">$pg</a>";
                echo "</li>\n";
            }

            if($connecte) 
            {
                echo "<a href='".DECON.".php'>".$pagesdeco[DECON]."</a>";
            }

            ?>
            
        </ul>

    </nav>

</div>
