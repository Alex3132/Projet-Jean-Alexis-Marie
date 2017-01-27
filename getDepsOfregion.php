<?php

header("Content-Type: text/xml");
header("Access-Control-Allow-Origin: *");


require_once("DbUtils.php");

if(isset($_POST['idregion'])) {
    $deps = $connect->getDepsByRegion($_POST['idregion']);
    if($deps) {
        echo "<div id='listdeps' class='list'>\n";
        foreach ($deps as $dep)
        {
            echo "<div>\n";
            echo "<input type='radio' name='selectdep' onclick='selectiondep()' value='".$dep->_id."'/>";
            echo "<span>".$dep->nom."</span>\n";
            echo "</div>\n";
        }
        echo "</div>\n";
    }
}