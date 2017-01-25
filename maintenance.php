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
     
    //si un nom de ville est tapé
    if(!empty($_POST['nom'])){
        $nomville = $_POST['nom'];
     
    $villerep = $connect->FindVilleByNom($nomville);//nous ressort le document qui correspond
    
    
        if(count($villerep) < 2){//parcours du document si il n'y a qu'une seule réponse
    foreach($villerep as $cle => $valeur){
        foreach($villerep[$cle] as $key => $value){
            if($key == '_id'){
                
            }
           elseif($key == '_id_dept'){
                $dept= $connect->FindDepById($value);
            echo "<div class=\"departement\">Département : ".$dept->getNom()."</div>" ; 
            $region = $connect->findRegionById($dept->getIdregion());
                
                 echo "<div class=\"region\">Région : ".$region->getNom()."</div>";
                
                
            }
            else {
                echo "<div class=\"$key\"><input type=\"checkbox\" id=\"".$value."\">$key : $value </div>";
                
            }
        }
    }
        }
        //     foreach($dept as $key1 => $value1){
         else {//si il y a plusieurs réponses => boutons radio de choix
             
            echo "<form action=\"#\" method=\"post\">";
             foreach($villerep as $cle => $valeur){
                 foreach($villerep[$cle] as $key => $value){
                     if($key == "nom" && empty($_POST['dept'])){
                        
                         echo "<input type=\"radio\" name=\"choixville\" value=\"".$value."\">$value.</div> ";
                         
                     }
                  else if($key == "_id_dept"){
                         $dept = $connect->FindDepById($value);
                     
                      if(!empty($_POST['dept'])){//si un département est tapé
                          
                        $depart = $_POST['dept'];
                      if( preg_match("/$depart/i", $dept->getNom())){//recherche en regex insensitive
                      
                          //affichage des boutons radio name = choixville
                         echo "<div>Département : ".$dept->getNom().".<input type=\"radio\" name=\"choixville\" value=\"".$villerep[$cle]->nom."\">".$villerep[$cle]->nom."";
                      }
                          
                     }else{
                         
                          $region = $connect->findRegionById($dept->getIdregion());
                
                 echo "<div class=\"region\">Région : ".$region->getNom()."</div>\n";
                          echo "<div>Département : ".$dept->getNom()." <div class=\"ville\">ville :"; 
                      }
                 }
             }}
             
             
             
      echo "<div><input type=\"submit\" value=\"choisir\"></div>\n";
             echo "</form>";
           
         }       
            
                   
               
                   
                
            echo "<input type=\"submit\" value=\"modifier\">";
            }elseif(isset($_POST['nom'])&& empty($_POST['nom'])){
    echo "<div class=\"error\">Veuillez rentrer le nom d'une ville.</div>";    
    }
    
    //choix d'un bouton radio et affichage d'un résultat
    echo "<form method\"post\" action=\"#\">";
            if(isset($_POST['choixville'])){    
                
                $choixville=$_POST['choixville'];
                 $villerep2 = $connect->FindVilleByNomChoosen($choixville);
               
                $dept= $villerep2[0]->_id_dept;
                $findept= $connect->findDepById($dept);
                echo "<div>Departement : ".$findept->getNom()."</div>";
                $findregion = $connect->findRegionById($findept->getIdregion());
                echo "<div class=\"region\">Region : ".$findregion->getNom()."</div>";
                echo "<div class=\"nom\"><input type=\"checkbox\" name=\"modif[]\" value=\"nom:".$villerep2[0]->nom."\"> Nom : ".$villerep2[0]->nom."</div>";
                if($villerep2[0]->pop)
                echo "<div class=\"pop\"><input type=\"checkbox\" name=\"modif[]\" value=\"pop:".$villerep2[0]->pop."\">Pop : ".$villerep2[0]->pop."</div>";
              if($villerep2[0]->lat)
                echo "<div class=\"lat\"><input type=\"checkbox\" name=\"modif[]\" value=\"lat:".$villerep2[0]->lat."\">Lat : ".$villerep2[0]->lat."</div>";
                if($villerep2[0]->lon)
                echo "<div class=\"lon\"><input type=\"checkbox\" name=\"modif[]\" value=\"lon:".$villerep2[0]->lon."\">Lon : ".$villerep2[0]->lon."</div>";
                if($villerep2[0]->cp)
                echo "<div class=\"cp\"><input type=\"checkbox\" name=\"modif[]\" value=\"cp:".$villerep2[0]->cp."\">Code Postal : ".$villerep2[0]->cp."</div>";
                
                echo "<input type=\"submit\" value=\"modifier\">";
            }
     echo"</form>"
;     
            if(isset($_POST['modif'])){
                
                $modif=$_POST['modif'];
                print_r($_POST['modif']);
                foreach($modif as $keymodif => $valuemodif){
                    
                }
                
                
            }
    
         
     
     
     
?>

    </div>
    <div id="modif">




    </div>
    
</form>