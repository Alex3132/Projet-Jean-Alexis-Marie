
<?php
ini_set("display_errors",0);error_reporting(0);
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
        <fieldset>
            <legend>
                <h2>Rechercher une ville</h2></legend>
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
                <br/>
                <input type="submit" value="Envoyer">
            </div>
        </fieldset>
    </form>







<div id="resultat">
<form  action="#" method="post">
    <fieldset><legend>Résultat de la recherche</legend>
    <?php
    //en venant d'une ville choisie sur la page d'accueil.
   
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
                    
                        echo "<div class=\"departement\"><input type=\"text\" name=\"valeur[]\" value=\"dep=>".$dept->getNom()."\" hidden readonly> Département : ".$dept->getNom()."</div>\n" ; 
                        
                            $region = $connect->findRegionById($dept->getIdregion());
                            
                                echo "<div class=\"region\"><input type=\"text\" name=\"valeur[]\" value=\"reg=>".$region->getNom()."\" hidden readonly>Région : ".$region->getNom()."</div>\n";
                
                
                 }
                 else if($key != '_id') 
                 {
                
                     echo "<div class=\"$key\"><input type=\"text\" name=\"valeur[]\" value=\"$key=>".$value."\" hidden readonly>$key : $value </div>\n";
                
                 }
                   else if ($key == '_id')
                   {
                       echo "<input type=\"text\" name=\"valeur[]\" value=\"$key=>".$value."\" hidden readonly>";
                   }
               }
          }
        
      }
    
    //traitement si l'on tape soi-même une recherche
    if(isset($_POST['nom']))
    {
        $nomville = $_POST['nom'] ;
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
                    
                    echo "<div class=\"departement\"><input type=\"text\" name=\"valeur[]\" value=\"dep=>".$dept->getNom()."\" hidden readonly>Département : ".$dept->getNom()."</div>\n" ; 
                        
                $region = $connect->findRegionById($dept->getIdregion());
                            
                    echo "<div class=\"region\"><input type=\"text\" name=\"valeur[]\" value=\"reg=>".$region->getNom()."\" hidden readonly>Région : ".$region->getNom()."</div>\n";
                
                
            }
            else 
            {
                
                echo "<div class=\"$key\"><input type=\"text\" name=\"valeur[]\" value=\"$key=>".$value."\" hidden readonly>$key : $value </div>\n";
                
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
                        
                         echo "<input type=\"radio\" name=\"choixville\" value=\"".$value."\"><input type=\"text\" name=\"valeur[]\" value=\"$key=>".$value."\" hidden readonly>$value.</div>\n<br><hr> ";
                         
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
                         
                              echo "<div>Département : ".$dept->getNom().".<input type=\"radio\" name=\"choixville\" value=\"".$villerep[$cle]->nom."\"><input type=\"text\" name=\"valeur[]\" value=\"dep=>".$villerep[$cle]->nom."\" hidden readonly>".$villerep[$cle]->nom."";
                      }
                          
                     }else
                      {
                         
                          $region = $connect->findRegionById($dept->getIdregion());
                
                 
                          echo "<div class=\"region\"><input type=\"text\" name=\"valeur[]\" value=\"reg=>".$region->getNom()."\" hidden readonly>Région : ".$region->getNom()."</div>\n";
                            echo "<div class=\"dep\"><input type=\"text\" name=\"valeur[]\" value=\"dep=>".$dept->getNom()."\" hidden readonly>Département : ".$dept->getNom()." <div class=\"ville\">ville :"; 
                      }
                 }
             }
    
        }
             
             
             
      
             echo "<div><input type=\"submit\" formaction=\"#\" value=\"choisir\"></div>\n";
                echo "</form>\n";
           
         }       
            
                   
               
                   
                
            
            }elseif(isset($_POST['nom'])&& empty($_POST['nom']))
    {
                    echo "<div class=\"error\">Veuillez rentrer le nom d'une ville.</div>\n";    
    }
    
    //choix d'un bouton radio et affichage d'un résultat
    
            if(isset($_POST['choixville']))
            {    
               echo  
                $choixville=$_POST['choixville'];
                    $villerep2 = $connect->FindVilleByNomChoosen($choixville);
                        $dept= $villerep2[0]->_id_dept;
                            $findept= $connect->findDepById($dept);
                                
                                echo "<div><input type=\"text\" name=\"valeur[]\" value=\"dep=>".$findept->getNom()."\" hidden readonly>Departement : ".$findept->getNom()."</div>\n";
                                    
                                    $findregion = $connect->findRegionById($findept->getIdregion());
                                
                                echo "<div class=\"region\"><input type=\"text\" name=\"valeur[]\" value=\"reg=>".$findregion->getNom()."\" hidden readonly>Region : ".$findregion->getNom()."</div>\n";
                            echo "<div class=\"nom\">Nom : ".$villerep2[0]->nom."</div>\n";
                        
                        echo "<input type=\"text\" name=\"valeur[]\" value=\"id=>".$villerep2[0]->_id."\" hidden readonly>";
                
                if(property_exists($villerep2[0], 'pop') && $villerep2[0]->pop)
                    echo "<div class=\"pop\"><input type=\"text\" name=\"valeur[]\" value=\"pop=>".$villerep2[0]->pop."\" hidden readonly>Pop : ".$villerep2[0]->pop."</div>\n";
              
                        if($villerep2[0]->lat)
                            echo "<div class=\"lat\"><input type=\"text\" name=\"valeur[]\" value=\"lat=>".$villerep2[0]->lat."\" hidden readonly>Lat : ".$villerep2[0]->lat."</div>\n";
                
                            if($villerep2[0]->lon)
                                echo "<div class=\"lon\"><input type=\"text\" name=\"valeur[]\" value=\"lon=>".$villerep2[0]->lon."\" hidden readonly>Lon : ".$villerep2[0]->lon."</div>\n";
                
                                if($villerep2[0]->cp)
                                    echo "<div class=\"cp\"><input type=\"text\" name=\"valeur[]\" value=\"cp=>".$villerep2[0]->cp."\" hidden readonly>Code Postal : ".$villerep2[0]->cp."</div>\n";
                
                
            }
            
    
     ?>
    
    <?php   
    require_once("utils.php");
    
        $connecte = isset($_SESSION[ID]);
    
            if($connecte)
            {
                
                echo "<input type=\"submit\" formaction=\"index.php?page=maintenance\" value=\"modifier\">";
                
            }
    
        ?>
    </fieldset>
    </form>
    <div class="local">
    </div>


</div>