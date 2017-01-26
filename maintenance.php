
<?php

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



<div id="listregions">

    <form action="#" method="post" id="changeregion" onsubmit="return verifchangeregion()">
        <ul>
            <?php
            foreach ($regions as $region)
            {
                echo "<li><input type='radio' name='selectregion' onclick='selectionregion(\"".htmlspecialchars(getBaseUrl().DEPBYREGION)."\");' value='".$region->getId()."'/><span>".$region->getNom()."</span></li>\n";
            }

            ?>
        </ul>

        <input type="hidden" id="idregion" name="idregion" value="" />
        <input type="text" id="nomregion" name="nomregion" value="" />
        <input type="submit" value="Modifier" />

    </form>
</div>  

<div id="listdeps">
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