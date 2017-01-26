
  <?php

  require("DbUtils.php");

  if(isset($_POST['nomregion']) && isset($_POST['idregion'])) 
  {
          
  }


  $regions = $connect->getRegions();

?>

<div id="listregions">

    <form action="#" method="post" id="changeregion" onsubmit="return verifchangeregion()">
        <ul>
            <?php
            foreach ($regions as $region)
            {
                echo "<li><input type='radio' name='selectregion' onclick='selectionregion()'; value='".$region->getId()."'/><span>".$region->getNom()."</span></li>\n";
            }

            ?>
        </ul>

        <input type="hidden" id="idregion" name="idregion" value="" />
        <input type="text" id="nomregion" name="nomregion" value="" />
        <input type="submit" value="Modifier" />

    </form>

</div>  