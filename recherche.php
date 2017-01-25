
<?php

require_once("DbUtils.php");

if(!empty($_GET['ville']))
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
}else {

    if(!empty($_POST['ville']))
    {
        //Remplace la valeur par defaut par celle de l'URL
        $nom = $_POST['ville'];
        $ville = $connect->findVilleByNom($nom);
        if(isset($ville)) {
            $dep = $connect->findDepById($ville->getId_Dept());
            if(isset($dep)) {
                $region = $connect->findRegionById($dep->getIdRegion());
            }
        }
    }
}

?>

<form action="#" method="post">

    <div id="recherche">
        <div class="nom">
            <label>Nom :</label>
            <input type="text" name="nom" id="nom" value="<?php echo isset($ville) ? $ville->getNom() : ""; ?>">
        </div>
        <div class="dept">
            <label>Département : </label>
            <input type="text" id="dept" name="dept" value="<?php echo isset($dep) ? $dep->getNom() : ""; ?>" />
        </div>
        <div class="region">
            <label>Région : </label>
            <input type="text" id="region" name="region" value="<?php echo isset($dep) ? $region->getNom() : ""; ?>" />
        </div>
        <input type="submit" value="Envoyer">
    </div>

</form>





<div id="resultat">

    <?php
    
    if(isset($_POST['nom'])){
        $nomville = $_POST['nom'];
     
    $villerep = $connect->FindVilleByNom($nomville);
     
    
        if(count($villerep) < 2){
    foreach($villerep as $cle => $valeur){
        foreach($villerep[$cle] as $key => $value){
            if($key == '_id_dept'){
                $dept= $connect->FindDepById($value);
            echo "<div class=\"region\">Région : ".$dept->getNom()."</div>" ;   
            }
            else {
                echo "<div class=\"$key\">$key : $value </div>";
                
            }
        }
    }
        }
        //     foreach($dept as $key1 => $value1){
         else {
             
            echo "<form action=\"#\" method=\"post\">";
             foreach($villerep as $cle => $valeur){
                 foreach($villerep[$cle] as $key => $value){
                     if($key == "nom"){
                         echo "<input type=\"radio\" name=\"choixville\" value=\"$value\">$value.</div> ";
                         
                     }
                  else if($key == "_id_dept"){
                         $dept = $connect->FindDepById($value);
                         echo "<div>Région : ".$dept->getNom()."";
                     }
                 }
             }
             
             
             
      echo "<input type=\"submit\" value=\"choisir\">";
             echo "</form>";
             
             if(isset($_POST['choixville'])){
                 $choix = $_POST['choixville'];
                 
             echo "".$_POST['choixville']."";
         }       
            
                   
               
                   
                
            
            }
    
            
            
    
        
    
    ?>
    <div class="local">
    </div>


</div>