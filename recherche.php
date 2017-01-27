
<?php
//ini_set("display_errors",0);error_reporting(0);
require_once("DbUtils.php");

// cette fonction rétablit la distance à partir des latitudes
// Les constantes LAT_MOY, TX, TY et RATIO seront définies à partir du contenu de la base de données.
function projection($lon, $lat) {
    return [RATIO*($lon+TX)*cos(LAT_MOY*(M_PI / 180)), RATIO*(-$lat+TY)];
    // le rendu réel devrait plutôt être celui produit par ce calcul
    //return [RATIO*(TX*cos(LAT_MOY*(M_PI / 180)) + $lon*cos($lat*(M_PI / 180))), RATIO*(-$lat+TY)];
}


if(!empty($_GET['ville']) && count($_POST) == 0)
{
//Remplace la valeur par defaut par celle de l'URL

$idville = $_GET['ville'];
$ville = $connect->findVilleById($idville);

if($ville != null) {
    $dep = $connect->findDepById($ville->getId_Dept());
    if(isset($dep)) {
        $region = $connect->findRegionById($dep->getIdRegion());

    }
}
}

$connecte = isset($_SESSION[ID]);

function drawCarteDep(Ville $ville, Departement$dep) {

    //en cas de réplica-set
    //$dsn='mongodb://192.168.36.100:27021,192.168.36.100:27022/?replicaSet=replica_1';
    require_once("DbUtils.php");
    $height = 700;

    $svgheader = <<<EOSVGH
<svg xmlns="http://www.w3.org/2000/svg"
     viewBox="0 0 %s %s"
     style="background:#DDD">
    <style type="text/css">
        polygon {stroke:#000;stroke-width:1px}
        polygon:hover {stroke:#FFF;fill:#000;stroke-width:2px}
        text {font-size:12px;fill:#000;alignment-baseline:middle}
        text:hover {fill:#F00;font-weight:bold}
        g circle {stroke:#F00;stroke-width:1;stroke-opacity:0.8;fill:#000;fill-opacity:0.5}
        g.cities circle {stroke:#ff0;stroke-width:1;stroke-opacity:0.8;fill:#F00;fill-opacity:0.8}
        g.cities text {fill:#F00 !important;stroke:#FF0;;stroke-width:0.5px}
        g.regions circle {stroke:#fff;stroke-width:1;stroke-opacity:0.3;fill:#000;fill-opacity:0.3}
        g.regions:hover text {fill:#fff;stroke:#000;stroke-width:0.5px}
        g.regions:hover circle {fill-opacity:0.4}
        g:hover circle {fill:#FF0;fill-opacity:1;stroke-opacity:1}
        g text {fill:#000;font-size:0px;fill-opacity:0;alignment-baseline:middle;text-anchor:middle}
        g:hover text {font-size:30px;fill:#000;font-weight:bold;fill-opacity:1}
    </style>
EOSVGH;

    $svgfooter = '</svg>';

    //header("Content-type: text/xml; charset=utf-8");

    $lon_min = 180;
    $lon_max = -180;
    $lat_max = -90;
    $lat_min = 90;
    foreach($dep->getContours() as $coord)
    {
        if ($coord->lat > $lat_max) $lat_max = $coord->lat;
        if ($coord->lon > $lon_max) $lon_max = $coord->lon;
        if ($coord->lat < $lat_min) $lat_min = $coord->lat;
        if ($coord->lon < $lon_min) $lon_min = $coord->lon;
    }

    // création des constantes (pour éviter une déclaration avec "global").
    define('RATIO', $height/($lat_max - $lat_min));
    define('LAT_MOY', ($lat_max + $lat_min)/2);
    define('TX', -$lon_min);
    define('TY', $lat_max);
    list($width,$unused) = projection($lon_max, LAT_MOY);

    printf($svgheader, $width, $height);

    // dessin de la France avec les eaux territoriales (Corse comprise)
    // commande de récupération de tous les poly de contours
    //$command = new MongoDB\Driver\Command(['find' => 'contours']); // ces lignes correspondens à l'utilisation de 'find'
    //$curseur = $mgc->executeCommand($dbname, $command);

        // si la région existe on prend la couleur attribuée sinon on génère une couleur de région aléatoire.

        // la couleur du département a une composante régionale forte + une composante départementale faible et aléatoire
        $color = "#fffff";
        printf('<polygon fill="%s" points="', $color);
        foreach ($dep->getcontours() as $co) {
            try
            {

                list($px, $py) = projection($co->lon, $co->lat);
                printf(' %d %d', $px, $py);

            }
            catch (exception $exception)
            {
                echo $exception->getmessage();
            }

        }
        echo '"/></polygone>\n';
        //}

    list($px, $py) = projection($ville->lon, $ville->lat);
    printf('<g><text x="%d" y="%d">%s</text>'."\n", $px, $py, $ville->nom);
    printf('<circle cx="%d" cy="%d" r="5"/></g>'."\n", $px, $py);

    echo $svgfooter;
}

function showResultVille($villerep, $connect, $connecte) {
    echo "<form action='#' method='post'>";
    echo "<div class='flexcolumn'>";
    //foreach($villerep as $cle => $valeur)
    //{
    echo "<ul>";
    $dept= $connect->FindDepById($villerep->_id_dept);
    $ville = new Ville($villerep);
        foreach($villerep as $key => $value)
        {
            if($key == '_id')
            {
                echo "<input type=\"text\" name=\"valeur[]\" value=\"$key=>".$value."\" hidden readonly>";
            }
            elseif($key == '_id_dept')
            {
                echo "<li class=\"departement\"><input type=\"text\" name=\"valeur[]\" value=\"dep=>".$dept->getNom()."\" hidden readonly>Département : ".$dept->getNom()."</li>\n" ;
                $region = $connect->findRegionById($dept->getIdregion());
                echo "<li class=\"region\"><input type=\"text\" name=\"valeur[]\" value=\"reg=>".$region->getNom()."\" hidden readonly>Région : ".$region->getNom()."</li>\n";
            }
            else
            {
                echo "<li class=\"$key\"><input type=\"text\" name=\"valeur[]\" value=\"$key=>".$value."\" hidden readonly>$key : $value </li>\n";
            }
        }
    //}

    if($connecte && (isset($_GET['ville']) || isset($_POST['nom'])))
    {
        echo "<input type=\"submit\" formaction=\"index.php?page=maintenance\" value=\"Modifier\">";
    }
    else if($connecte) {
        echo "<input type=\"submit\" formaction=\"index.php?page=maintenance\" value=\"Modifier\">";
    }

    echo "</div>";
    echo "</form>";
}

function showCarte(Ville $ville, Departement $dep) {
    echo "<div id='cdep' class='gridrech'>";
    drawCarteDep($ville, $dep);
    echo "</div>";
}

function showChoiceVille($villerep, $connect) {
    echo "<form action=\"#\" method=\"post\">";
    //echo "<div class='list'>";
    foreach($villerep as $cle => $valeur)
    {
        echo "<div class='less'>";
        $idville = $valeur->_id;
        $stringresult = "";
        foreach($villerep[$cle] as $key => $value)
        {
            if($key == "nom" && empty($_POST['dept']))
            {
                $stringresult = substr_replace($stringresult, "<div><input type=\"radio\" name=\"choixville\" value=\"".$idville."\"><input type=\"text\" name=\"valeur[]\" value=\"$key=>".$value."\" hidden readonly>Ville : $value</div>\n ", $stringresult, 0); ;
            }
            else if($key == "_id_dept")
            {
                $dept = $connect->FindDepById($value);
                if(!empty($_POST['dept']))
                {//si un département est tapé
                    $depart = $_POST['dept'];
                    if(preg_match("/$depart/i", $dept->getNom()))
                    {//recherche en regex insensitive
                        //affichage des boutons radio name = choixville
                        echo "<div>Département : ".$dept->getNom().".<input type=\"radio\" name=\"choixville\" value=\"".$villerep[$cle]->nom."\"><input type=\"text\" name=\"valeur[]\" value=\"dep=>".$villerep[$cle]->nom."\" hidden readonly>".$villerep[$cle]->nom."</div>";
                    }
                }else
                {
                    $region = $connect->findRegionById($dept->getIdregion());
                    $stringresult .= "<div class=\"region\"><input type=\"text\" name=\"valeur[]\" value=\"reg=>".$region->getNom()."\" hidden readonly>Région : ".$region->getNom()."</div>\n";
                    $stringresult .= "<div class=\"dep\"><input type=\"text\" name=\"valeur[]\" value=\"dep=>".$dept->getNom()."\" hidden readonly>Département : ".$dept->getNom()."</div>";
                }
            }
        }

        echo $stringresult;
        echo "</div>";
    }
    echo "<div><input type=\"submit\" formaction=\"#\" value=\"choisir\"></div>\n";
    echo "</div>";
    echo "</form>\n";
}
?>

<div class="grid2">

    <div class="containerform gridrech">
        <div class="titreform">Rechercher une ville</div>
        <form action="#" method="post">
            <div class="nom">
                <label>Nom :</label>
                <input type="text" name="nom" id="nom" value="" />
            </div>
            <div class="dept">
                <label>Département : </label>
                <input type="text" id="dept" name="dept" value="" />
            </div>
            <div class="region">
                <label>Région : </label>
                <input type="text" id="region" name="region" value="" />
            </div>
            <br />
            <div><label></label><input type="submit" value="Envoyer" /></div>
        </form>
    </div>

    <?php

    $titleserach = "";
    if(isset($ville)) {
        $titleserach = $ville->getNom();
        $dep = $connect->findDepById($ville->_id_dept);
    }
    elseif (isset($_POST['choixville'])) {
        $choixville=$_POST['choixville'];
        $villerep2 = $connect->findVilleById($choixville);
        $ville = $villerep2;
        $dep = $connect->findDepById($villerep2->_id_dept);
        $titleserach = $villerep2->getNom();
    }
    else if(isset($_POST['nom'])) {
        $titleserach = $_POST['nom'];
    }

    ?>
    <div id="resultat" class='containerform gridrech'>
        <div class='titreform'>Résultat de la recherche pour <?php echo  $titleserach ?></div>
        <!--<form action='#' method='post'>
            <div class='list'>-->
        <?php
            //en venant d'une ville choisie sur la page d'accueil.
           if(isset($_GET['ville']) || isset($_POST['nom']))
           {
                if(isset($ville) && empty($_POST['nom']))
               {
                    $nomville = $ville->getNom();
                    //$villerep= $connect->findVilleById($ville);
                    showResultVille($ville, $connect, $connecte);
                    
              }
           }
    //traitement si l'on tape soi-même une recherche
    if(isset($_POST['nom']))
    {
        if(isset($_POST['nom']))
        {
            $nomville = $_POST['nom'] ;
            $villerep = $connect->FindVilleByNom($nomville);//nous ressort le document qui correspond
            if(count($villerep) == 1)
            {//parcours du document si il n'y a qu'une seule réponse
                showResultVille($villerep[0], $connect, $connecte);
            }
            else
            {//si il y a plusieurs réponses => boutons radio de choix
                showChoiceVille($villerep, $connect);
            }
        } elseif(isset($_POST['nom'])&& empty($_POST['nom']))
        {
            echo "<div class=\"error\">Veuillez rentrer le nom d'une ville.</div>\n";
        }
    }

    //choix d'un bouton radio et affichage d'un résultat
    if(isset($_POST['choixville']))
    {
        //$choixville=$_POST['choixville'];
        //$villerep2 = $connect->FindVilleByNomChoosen($choixville);
        showResultVille($villerep2, $connect, $connecte);
        
    }
        ?>
    </div>
    </div>

    <div>
        <?php 
    if(isset($ville) && isset($dep))
        showCarte($ville, $dep);
    ?>
    </div>

