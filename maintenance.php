
  <?php

  require("DbUtils.php");

  $regions = $connect->getRegions();

  ?>

<div id="listregions">

    <form>
        <ul>
            <?php
            foreach ($regions as $region)
            {
                echo "<li><input type='radio' name='selectregion' onclick='selectionregion()'; value='".$region->getNom()."'/>".$region->getNom()."</li>\n";
            }

            ?>
        </ul>

        <input type="text" id="nomregion" name="nomregion" value="" />
        <input type="submit" value="Modifier" />

    </form>

</div>  