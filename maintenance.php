<?php

require("DbUtils.php");
?>

<form action="#" method="post">
    <div id="recherche">
        <label>Ville :</label>
        <input type="text" name ="nom" id="ville">
        <label>Département : </label>
        <input type="text" name="dept" id="dept">
        <label>Régions : </label>
        <input type="text" name ="region" id="region">
    </div>
   

    <input type="submit" value="Envoyer">

</form>
<form action="#" method="post">
 <div id="resultat">
<?php
     
     if(isset($_POST['nom'])){
         $rechville= $_POST['nom'];
         
         $rechville2= $connect->findVilleByNom($rechville);
         
        print_r($rechville2);
         
     }
     
     
?>

    </div>
    <div id="modif">




    </div>
    
</form>