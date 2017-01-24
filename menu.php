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

?>

<div id="menu">
    <nav>
        <ul>

<?php
            foreach($pagesOK as $key => $pg) 
            {
                echo ($page == $key) ? "<li><a href='index.php?page=$key' class='selected'>$pg</a>" : "<a href='index.php?page=$key'>$pg</a></li>";
            }
?>
            
        </ul>

    </nav>

</div>
