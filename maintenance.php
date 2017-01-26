<?php

require("DbUtils.php");

$regions = $connect->getRegions();

echo "<div>\n<ul>\n";
foreach ($regions as $region) {
    echo "<li>".$region->getNom()."<li>\n";
}

echo "</ul></div>\n";
    