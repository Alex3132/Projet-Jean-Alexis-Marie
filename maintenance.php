
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
<form action="#" method="post">
    <fieldset><legend>Modifier la ville</legend>
<?php

        
        $vals=[];
        $idv="";
        
if(isset($_POST['valeur']))
{
    $valeurs=$_POST['valeur'];
        
        foreach($valeurs as $key => $val)
        {
            $vals[$key]=explode("=>", $valeurs[$key]);
                
        }
    
    
 
    
    foreach($vals as $key1 => $value1)
    {
       
        if($value1[0] !== "dep" && $value1[0] !== "reg" && $value1[0] !== "_id" && $value1[0] !== "nom")
        
            echo"<div><label>$value1[0] : <input type=\"text\" id=\"$value1[0]\" name=\"$value1[0]\" value=\"$value1[1]\"></label></div>\n";    
        
                if($value1[0] == '_id')
                {
                    
                    $idv="".$value1[1];
                    echo $idv;
                }
                if($value1[0] == 'nom')
                {
                    echo "<h2 id=\"nomville\">$value1[1]</h2\n>";
                }

    }
    
}
    if(isset($_POST['cp'])){
        echo $idv;
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
        
        
        

        ?>
        <input type="submit" formaction="#" value="modifier">
    </fieldset>
</form>
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