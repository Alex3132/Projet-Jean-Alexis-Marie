
<?php

require_once("DbUtils.php");

if(!empty($_GET['ville']))
{
	//Remplace la valeur par defaut par celle de l'URL
	$idville = $_GET['ville'];
    $ville = $connect->findVille($idville);
    if(isset($ville)) {
        $dep = $connect->findDep($ville->getId_Dept());
        if(isset($dep)) {
            $region = $connect->findRegion($dep->getIdRegion());
        }
    }
}

?>

<form action="#" method="post">

    <div id="recherche">
        <div class="nom">
            <label>Nom :</label>
            <input type="text" id="nom" value="<?php echo isset($ville) ? $ville->getNom() : ""; ?>">
        </div>
        <div class="dept">
            <label>Département : </label>
            <input type="text" id="dept" value="<?php echo isset($dep) ? $dep->getNom() : ""; ?>" />
        </div>
        <div class="region">
            <label>Région : </label>
            <input type="text" id="region" value="<?php echo isset($dep) ? $region->getNom() : ""; ?>" />
        </div>
        <input type="submit" value="Envoyer">
    </div>

</form>





<div id="resultat">

    <div class="local">
    </div>


</div>