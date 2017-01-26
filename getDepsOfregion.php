<?php

header("Content-Type: text/xml");
header("Access-Control-Allow-Origin: *");


require_once("DbUtils.php");

if(isset($_POST['idregion'])) {
    $deps = $connect->getDepsByRegion($_POST['idregion']);
    if($deps) {
        echo "<div id='listdeps'>\n";
        echo "<ul>\n";
        foreach ($deps as $dep)
        {
            echo "<li><input type='radio' name='selectdep' onclick='selectiondep()' value='".$dep->_id."'/><span>".$dep->nom."</span></li>\n";
        }
        echo "</ul>\n";
        echo "</div>\n";
    }
}