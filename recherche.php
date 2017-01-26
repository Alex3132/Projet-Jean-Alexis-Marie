
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
}

?>

<form action="#" method="post">

    <div id="recherche">
        <div class="nom">
            <label>Nom :</label>
            <input type="text" name="nom" id="nom" value="<?php echo isset($ville) ? $ville->getNom() : "";?>">
        </div>
        <div class="dept">
            <label>Département : </label>
            <input type="text" id="dept" name="dept" value="<?php echo isset($dep) ? $dep->getNom() : ""; ?>" />
        </div>
        <div class="region">
            <label>Région : </label>
            <input type="text" id="region" name="region" value="<?php echo isset($dep) ? $region->getNom() : ""; ?>" />
        </div>
        <input type="reset" name="reset" value="reset"><input type="submit" value="Envoyer">
    </div>

</form>





<div id="resultat">

    <?php
    //si un nom de ville est tapé
   
    if(isset($ville) && empty($_POST['nom']))
       {
        
        $nomville = $ville->getNom();
            $villerep= $connect->FindVilleByNomChoosen($nomville);
        
        
        
           foreach($villerep as $cle => $valeur)
           {
        
               foreach($villerep[$cle] as $key => $value)
               {
            
                 if($key == '_id_dept')
                 {
                
                     $dept= $connect->FindDepById($value);
                    
                        echo "<div class=\"departement\">Département : ".$dept->getNom()."</div>" ; 
                        
                            $region = $connect->findRegionById($dept->getIdregion());
                            
                                echo "<div class=\"region\">Région : ".$region->getNom()."</div>";
                
                
                 }
                 else if($key != '_id') 
                 {
                
                     echo "<div class=\"$key\">$key : $value </div>";
                
                 }
               }
          }
        
      }
    
    
    if(isset($_GET['ville']))
    {
       isset($_POST['nom']) ?  $nomville = $_POST['nom'] : $nomville = $_GET['ville'];
            $villerep = $connect->FindVilleByNom($nomville);//nous ressort le document qui correspond
     
    
        if(count($villerep) < 2)
        {//parcours du document si il n'y a qu'une seule réponse
    foreach($villerep as $cle => $valeur)
    {
        foreach($villerep[$cle] as $key => $value)
        {
            if($key == '_id')
            {
                
            }
           elseif($key == '_id_dept')
           {
                $dept= $connect->FindDepById($value);
                    
                    echo "<div class=\"departement\">Département : ".$dept->getNom()."</div>" ; 
                        
                $region = $connect->findRegionById($dept->getIdregion());
                            
                    echo "<div class=\"region\">Région : ".$region->getNom()."</div>";
                
                
            }
            else 
            {
                
                echo "<div class=\"$key\">$key : $value </div>";
                
            }
        }
    }
        }
        //     foreach($dept as $key1 => $value1){
         else 
         {//si il y a plusieurs réponses => boutons radio de choix
             
            echo "<form action=\"#\" method=\"post\">";
             
             foreach($villerep as $cle => $valeur)
             {
                 
                 foreach($villerep[$cle] as $key => $value)
                 {
                     
                     if($key == "nom" && empty($_POST['dept']))
                     {
                        
                         echo "<input type=\"radio\" name=\"choixville\" value=\"".$value."\">$value.</div> ";
                         
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
                         
                              echo "<div>Département : ".$dept->getNom().".<input type=\"radio\" name=\"choixville\" value=\"".$villerep[$cle]->nom."\">".$villerep[$cle]->nom."";
                      }
                          
                     }else
                      {
                         
                          $region = $connect->findRegionById($dept->getIdregion());
                
                 
                          echo "<div class=\"region\">Région : ".$region->getNom()."</div>\n";
                            echo "<div>Département : ".$dept->getNom()." <div class=\"ville\">ville :"; 
                      }
                 }
             }
    
        }
             
             
             
      
             echo "<div><input type=\"submit\" value=\"choisir\"></div>\n";
                echo "</form>";
           
         }       
            
                   
               
                   
                
            
            }elseif(isset($_POST['nom'])&& empty($_POST['nom']))
    {
                    echo "<div class=\"error\">Veuillez rentrer le nom d'une ville.</div>";    
    }
    
    //choix d'un bouton radio et affichage d'un résultat
    
            if(isset($_POST['choixville']))
            {    
                
                $choixville=$_POST['choixville'];
                    $villerep2 = $connect->FindVilleByNomChoosen($choixville);
                        $dept= $villerep2[0]->_id_dept;
                            $findept= $connect->findDepById($dept);
                                
                                echo "<div>Departement : ".$findept->getNom()."</div>";
                                    
                                    $findregion = $connect->findRegionById($findept->getIdregion());
                                
                                echo "<div class=\"region\">Region : ".$findregion->getNom()."</div>";
                            echo "<div class=\"nom\">Nom : ".$villerep2[0]->nom."</div>";
                
                
                if(property_exists($villerep2[0], 'pop') && $villerep2[0]->pop)
                    echo "<div class=\"pop\">Pop : ".$villerep2[0]->pop."</div>";
              
                if($villerep2[0]->lat)
                    echo "<div class=\"lat\">Lat : ".$villerep2[0]->lat."</div>";
                
                if($villerep2[0]->lon)
                    echo "<div class=\"lon\">Lon : ".$villerep2[0]->lon."</div>";
                
                if($villerep2[0]->cp)
                    echo "<div class=\"cp\">Code Postal : ".$villerep2[0]->cp."</div>";
                
                
            }
            
    
        
    
    ?>
    <div class="local">
    </div>


</div>