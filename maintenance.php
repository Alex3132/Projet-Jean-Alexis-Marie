
<?php
if(!isset($_SESSION[PROFIL])){
    header("Location: index.php");
    http_response_code(303);
}
require("DbUtils.php");

if(isset($_POST['nomregion']) && isset($_POST['idregion'])) {
    try
    {
        $connect->modifyRegion($_POST['idregion'], $_POST['nomregion']);
    }
    catch (Exception $exception)
    {
        echo $exception->getMessage();
    }
} else if(isset($_POST['modifregion']) && isset($_POST['selectdep'])) {

    $connect->modifyDepIdRegion($_POST['modifregion'], $_POST['selectdep']);
}

$regions = $connect->getRegions();

?>

<div class="containerform <?php if(!isset($_POST['valeur'])) echo " hidden"; ?> ">
    <div class="titreform">Modifier la ville</div>
    <form action="#" method="post">
        <?php
        if($_SESSION[PROFIL]=='edit' || $_SESSION[PROFIL]=='admin')
        {
            $vals=[];
            if(isset($_POST['valeur']))
            {
                $valeurs=$_POST['valeur'];
                foreach($valeurs as $key => $val)
                {
                    $vals[$key]=explode("=>", $valeurs[$key]);
                }
                foreach($vals as $key1 => $value1)
                {
                    if($value1[0] !== "dep" && $value1[0] !== "reg" && $value1[0] !== "_id" && $value1[0] !== "nom" && $value1[0] !== "lat" && $value1[0] !== "lon")
                        echo"<div><label>$value1[0] : <input type=\"text\" id=\"$value1[0]\" name=\"$value1[0]\" value=\"$value1[1]\"></label></div>\n";
                    if($value1[0] == '_id')
                    {
                        echo "<input type=\"text\" name=\"id\" value=\"$value1[1]\" hidden>";
                    }
                    if($value1[0] == 'nom')
                    {
                        echo "<h2 id=\"nomville\">$value1[1]</h2\n>";
                    }
                }
            }
            if(isset($_POST['id']))
            {
                $idv=$_POST['id'];
                if(isset($_POST['cp']))
                {
                    $valeurcp=$_POST['cp'];
                    try
                    {
                        $connect->UpdateProperty($idv, 'cp', $valeurcp);
                    }
                    catch (Exception $exception)
                    {
                        echo $exception->getMessage();
                    }
                }
            }
            if(isset($_POST['id']))
            {
                $idv=$_POST['id'];
                if(isset($_POST['pop']))
                {
                    $valeurpop=$_POST['pop'];
                    try
                    {
                        $connect->UpdateProperty($idv, 'pop', $valeurpop);
                    }
                    catch (Exception $exception)
                    {
                        echo $exception->getMessage();
                    }
                }
            }
        }

        ?>
        <input type="submit" formaction="#" value="Modifier" />
      </form>
</div>


<div id="listregions" class="containerform">
    <div class="titreform">Modifier le nom des régions</div>
    <form action="#" method="post" id="changeregion" onsubmit="return verifchangeregion()" <?php echo ($_SESSION[PROFIL] == 'admin')? "" : "hidden";?>>
        <div class="list">
            <?php
                foreach ($regions as $region)
                {
                    echo "<div>";
                    echo "<input type='radio' name='selectregion' onclick='selectionregion(\"".htmlspecialchars(getBaseUrl().DEPBYREGION)."\")' value='".$region->getId()."' />";
                    echo "<span>".$region->getNom()."</span>";
                    echo "</div>\n";
                }
            ?>
        </div>

        <input type="hidden" id="idregion" name="idregion" value="" />
        <input type="hidden" id="nreg" name="nreg" value="" />
        <input type="text" id="nomregion" name="nomregion" value="" />
        <input type="submit" value="Modifier" />

    </form>
</div>  

<div id="ldpeps" class="containerform hidden">
    <div class="titreform">Département de la région <span id="nomtitreregion"></span> </div>
    <form id="changedep" action="#" method="post">

        <div id="listdep"></div>

        <div id="divmodifregion" class="hidden">
            <select name="modifregion" id="modifregion" onchange="changeRegion(<?php $region->getId() ?>);">
                <?php
            foreach ($regions as $region)
            {
                echo "<option value='".$region->getId();
                if(isset($_POST['idregion']))
                {
                    if(intval($_POST['idregion']) == $region->getId())
                    {
                        echo " selected";
                    }
                }
                echo "'>".$region->getNom()."</option>\n";
            }
                ?>
            </select>
            <input type="submit" value="Modifier" id="btModifRegion" disabled />
        </div>
    </form>
</div>