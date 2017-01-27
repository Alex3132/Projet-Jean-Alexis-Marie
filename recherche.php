
<?php
//ini_set("display_errors",0);error_reporting(0);
require_once("DbUtils.php");

// cette fonction rétablit la distance à partir des latitudes
// Les constantes LAT_MOY, TX, TY et RATIO seront définies à partir du contenu de la base de données.
function projection($lon, $lat) {
    return [RATIO*($lon+TX)*cos(LAT_MOY*(M_PI / 180)), RATIO*(-$lat+TY)];
    // le rendu réel devrait plutôt être celui produit par ce calcul
    // return [RATIO*(TX*cos(LAT_MOY*(M_PI / 180)) + $lon*cos($lat*(M_PI / 180))), RATIO*(-$lat+TY)];
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
        if ($coord->lat < $lon_max) $lat_max = $coord->lat;
        if ($coord->lon < $lon_max) $lon_max = $coord->lon;
        if ($coord->lat > $lat_min) $lat_min = $coord->lat;
        if ($coord->lon < $lon_min) $lon_min = $coord->lon;
    }

    // récupération des informations globales pour définir l'image à partir de la base de données


    // récupération de la box contenant les contours à visualiser
    // cette requête extrait les "box" à partir des polygones de contours de la France + la Corse et les limites sont
    // déterminées par fonction d'agrégation sur les coordonnées des points déterminant ces "box".
    //    $map = <<<EOJSBOXMAP
    //  function() {
    //    var res = [180, -180, 90, -90];
    //    for (i=0; i<this.poly.length; i++) {
    //      if (res[0] > this.poly[0][0][0]) res[0] = this.poly[0][0][0];
    //      if (res[1] < this.poly[0][0][0]) res[1] = this.poly[0][0][0];
    //      if (res[2] > this.poly[0][0][1]) res[2] = this.poly[0][0][1];
    //      if (res[3] < this.poly[0][0][1]) res[3] = this.poly[0][0][1];
    //    }
    //    emit(1, res);
    //  }
    //EOJSBOXMAP;

    //    $reduce = <<<EOJSBOXRED
    //  function(key, vals) {
    //    var res = [180, -180, 90, -90];
    //   vals.forEach(function(val) {
    //      if (res[0] > val[0]) res[0] = val[0];
    //      if (res[1] < val[1]) res[1] = val[1];
    //      if (res[2] > val[2]) res[2] = val[2];
    //      if (res[3] < val[3]) res[3] = val[3];
    //   });
    //   return {minmax: res};
    //  }
    //EOJSBOXRED;

    //    // préparation de la commande et récupération des résultats dans l'unique valeur de retour
    //    $boxCmd = new MongoDB\Driver\Command([
    //      'mapreduce' => 'departements',
    //      'map' => $map,
    //      'reduce' => $reduce,
    //      'out' => ['inline' => 1]]);
    //    $box = $mgc->executeCommand($dbname, $boxCmd)->toArray()[0];

    //foreach($dep->)

    //$minmax = $box->results[0]->value->minmax;

    //list($lon_min, $lon_max, $lat_min, $lat_max) = $minmax;
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

    //foreach($dep->getContours() as $coord) {
    //    echo '<polygon style="fill:#CCF" points="'."\n";
    //    //$contour = $doc->poly;
    //    //foreach ($contour as $ptb) {
    //    list($px, $py) = projection($coord->lon, $coord->lat);
    //    printf(' %d %d', $px, $py);
    //}

    //echo '"/>'."\n";

    //// dessin des contours des départements qui peuvent être multiples (îles, enclaves)
    //// Il est plus habile de placer d'abord les départements à contour simple puis ceux à contours doubles, puis triples...
    //// afin de ne pas masquer les enclaves telles que celles qui apparaissent entre les Pyrénées-Atlantiques et les Hautes-Pyrénées.
    //// Pour s'en rendre compte il suffit d'inverser l'ordre de sortie en changeant le signe de 'contours' dans l'appel de 'sort'
    //// ce qui aura pour effet de retourner l'ordre de tri fixé ici en ordre croissant et dépendant du nombre de polygones par contour
    //// et par conséquent d'augmenter la probabilité de faire disparaître certaines enclaves.

    //// commande de récupération de tous les contours de l'ensemble de départements

    //$filter = ['contours' => ['$exists' => true]]; // on veut que le département présente bien un contour
    //$options = [
    //  'projection' => ['contours' => 1, '_id_region' => 1, '_id' => 0],  // on ne veut que ces colonnes sans l'identifiant
    //  'sort'       => ['contours' => 1],                                 // triées selon le nombre de contours ordre croissant
    //];

    //$query = new MongoDB\Driver\Query($filter, $options);
    //$curseur = $mgc->executeQuery($dbname.'.departements', $query);

    //foreach($curseur as $crs) {   // boucle sur l'ensemble des résultats
    //    // si la région existe on prend la couleur attribuée sinon on génère une couleur de région aléatoire.
    //    $idr = $crs->_id_region;
    //    if (empty($colr[$idr])) {
    //        $colr[$idr] = [rand(5,14), rand(5,14), rand(5,14)];
    //    }
    //    // la couleur du département a une composante régionale forte + une composante départementale faible et aléatoire
    //    $color = sprintf('#%1x%1x%1x', rand(0,1)+$colr[$idr][0], rand(0,1)+$colr[$idr][1], rand(0,1)+$colr[$idr][2]);
    //    foreach ($crs->contours as $contour) {
    //        printf('<polygon fill="%s" points="'."\n", $color);
    //        foreach ($contour as $ptb) {
    //            list($lon, $lat) = $ptb;
    //            list($px, $py) = projection($lon, $lat);
    //            printf(' %d %d', $px, $py);
    //        }
    //        echo '"/>'."\n";
    //    }
    //}

    //// affichage les noms des régions centrés dans l'espace occupé par chacune d'elles
    //// utilisation de la technique map/reduce pour récupérer le rectangle englobant chaque région
    //// création de la fonction de mapping
    //$map_funct = <<<'EOMAP'
    //function() {
    //    var res = {
    //      minlon: 180,
    //      maxlon: -180,
    //      minlat: 90,
    //      maxlat: -90
    //    }
    //    for (i=0; i<this.contours.length; i++) {
    //      for (j=0; j<this.contours[i].length; j++) {
    //        if (res.minlon > this.contours[i][j][0]) res.minlon = this.contours[i][j][0];
    //        if (res.maxlon < this.contours[i][j][0]) res.maxlon = this.contours[i][j][0];
    //        if (res.minlat > this.contours[i][j][1]) res.minlat = this.contours[i][j][1];
    //        if (res.maxlat < this.contours[i][j][1]) res.maxlat = this.contours[i][j][1];
    //      }
    //    }
    //    emit(1, res);
    //  }
    //EOMAP;

    //// création de la fonction de réduction
    //$reduce_funct = <<<'EORED'
    //function(key, vals) {
    //  var res = {
    //    minlon: 180,
    //    maxlon: -180,
    //    minlat: 90,
    //    maxlat: -90
    //  }
    //  vals.forEach(function(val) {
    //    if (res.minlon > val.minlon) res.minlon = val.minlon;
    //    if (res.maxlon < val.maxlon) res.maxlon = val.maxlon;
    //    if (res.minlat > val.minlat) res.minlat = val.minlat;
    //    if (res.maxlat < val.maxlat) res.maxlat = val.maxlat;
    //  });
    //  return {minmax: res};
    //}
    //EORED;

    // boucle sur les régions
    // astuce pour éviter d'utiliser la commande 'find' non suportée avant mongodb 3.2
    //$curseur = $mgc->executeQuery($dbname.'.regions', new MongoDB\Driver\Query(['_id' => ['$gt' => 0]]));
    ////$curseur = $mgc->executeCommand($dbname, new MongoDB\Driver\Command(['find' => 'regions']));
    //foreach($curseur as $doc) {
    //    // préparation de la requête utilisant les fonctions précédemment définies sur la région courante.
    //    $command = new MongoDB\Driver\Command([
    //      'mapreduce' => 'departements',
    //      'map' => $map_funct,
    //      'reduce' => $reduce_funct,
    //      'query' => ['contours' => ['$exists' => true], '_id_region' => $doc->_id],
    //      'out' => ['inline' => 1],
    //    ]);
    //    $cbox = $mgc->executeCommand($dbname, $command)->toArray()[0];
    //    if (isset($cbox->results[0])) {
    //        $box = $cbox->results[0]->value->minmax;
    //        $lat = ($box->maxlat + $box->minlat)/2;
    //        $lon = ($box->maxlon + $box->minlon)/2;
    //        list($px, $py) = projection($lon, $lat);
    //        printf('<g class="regions"><text x="%d" y="%d">%s</text>'."\n", $px, $py, $doc->nom);
    //        printf('<circle cx="%d" cy="%d" r="15"/></g>'."\n", $px, $py);
    //    }
    //    //print_r($cbox);exit;

    //    //// récupération du résultat utile
    //    //// var box = res.results[0].value.minmax;
    //}

    // affichage des villes les plus importantes de chaque département mais de population < 200000 habitants
    // commande de récupération des coordonnées, population et nom par agrégation
    //$command = new MongoDB\Driver\Command(['aggregate' => 'villes',                                    // le choix de l'opération, ici 'aggregate'
    //                       'pipeline'=> [['$sort' => ['_id_dept' => 1, 'pop' => 1]],   // on trie sur ces deux colonnes
    //                             ['$group' => ['_id' => '$_id_dept',           // groupement par départements
    //                                   'pop' => ['$last' => '$pop'],   // on ne retient que la dernière population
    //                                   'nom' => ['$last' => '$nom'],   //                   le dernier nom
    //                                   'lon' => ['$last' => '$lon'],   //                   la dernière longitude
    //                                   'lat' => ['$last' => '$lat']]], //                et la dernière latitude
    //                             ['$match' => ['pop' => ['$lt' => $min_pop_cities]]], // on élimine les villes >= 200000 habitants
    //                       ]]);
    //$cities = $mgc->executeCommand($dbname, $command)->toArray()[0];

    //foreach($curseur as $crs) {   // boucle sur l'ensemble des résultats
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

    //foreach($cities->result as $doc) {
    //    list($px, $py) = projection($doc->lon, $doc->lat);
    //    printf('<g  class="cities"><text x="%d" y="%d">%s</text>'."\n", $px, $py, $doc->nom);
    //    printf('<circle cx="%d" cy="%d" r="5"/></g>'."\n", $px, $py);
    //}

    //// affichage de toutes les villes de population >= 200000 habitants
    //$filter = ['pop' => ['$gte' => $min_pop_cities]];
    //$options = ['projection' => ['nom' => 1, 'lon' => 1, 'lat' => 1, '_id' => 0]];  // on ne veut que ces colonnes sans l'identifiant
    //$query = new MongoDB\Driver\Query($filter, $options);
    //$curseur = $mgc->executeQuery($dbname.'.villes', $query);

    //foreach($curseur as $doc) {
    //    list($px, $py) = projection($doc->lon, $doc->lat);
    //    printf('<g class="cities"><text x="%d" y="%d">%s</text>'."\n", $px, $py, $doc->nom);
    //    printf('<circle cx="%d" cy="%d" r="4"/></g>'."\n", $px, $py);
    //}

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

    echo "</div>";
    echo "</form>";

    showCarte($ville, $dept);
}

function showCarte(Ville $ville, Departement $dep) {
    echo "<div>";
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
    }
    elseif (isset($_POST['choixville'])) {
        $choixville=$_POST['choixville'];
        $villerep2 = $connect->findVilleById($choixville);
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
        //$dept= $villerep2[0]->_id_dept;
        //$findept= $connect->findDepById($dept);
        //echo "<div><input type=\"text\" name=\"valeur[]\" value=\"dep=>".$findept->getNom()."\" hidden readonly>Departement : ".$findept->getNom()."</div>\n";
        //$findregion = $connect->findRegionById($findept->getIdregion());
        //echo "<div class=\"region\"><input type=\"text\" name=\"valeur[]\" value=\"reg=>".$findregion->getNom()."\" hidden readonly>Region : ".$findregion->getNom()."</div>\n";
        //echo "<div class=\"nom\"><input type=\"text\" name=\"valeur[]\" value=\"nom=>".$villerep2[0]->nom."\" hidden readonly>Nom : ".$villerep2[0]->nom."</div>\n";
        //echo "<input type=\"text\" name=\"valeur[]\" value=\"_id=>".$villerep2[0]->_id."\" hidden readonly>";
        //if(property_exists($villerep2[0], 'pop') && $villerep2[0]->pop)
        //    echo "<div class=\"pop\"><input type=\"text\" name=\"valeur[]\" value=\"pop=>".$villerep2[0]->pop."\" hidden readonly>Pop : ".$villerep2[0]->pop."</div>\n";
        //if($villerep2[0]->lat)
        //    echo "<div class=\"lat\"><input type=\"text\" name=\"valeur[]\" value=\"lat=>".$villerep2[0]->lat."\" hidden readonly>Lat : ".$villerep2[0]->lat."</div>\n";
        //if($villerep2[0]->lon)
        //    echo "<div class=\"lon\"><input type=\"text\" name=\"valeur[]\" value=\"lon=>".$villerep2[0]->lon."\" hidden readonly>Lon : ".$villerep2[0]->lon."</div>\n";
        //if($villerep2[0]->cp)
        //    echo "<div class=\"cp\"><input type=\"text\" name=\"valeur[]\" value=\"cp=>".$villerep2[0]->cp."\" hidden readonly>Code Postal : ".$villerep2[0]->cp."</div>\n";
    }
        ?>
    </div>
    </div>

