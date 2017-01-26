<?php

require("DbUtils.php");

$regions = $connect->getRegions();

?>

<div id="listregions">

    <ul>
        <?php
        foreach ($regions as $region) 
        {
            echo "<li>".$region->getNom()."</li>\n";
        }

        ?>

    </ul>


</div>
    