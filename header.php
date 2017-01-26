<div id="header">
    <header>


        <div id="image">


            <img src="img/cropped-logoldnr.png">

        </div>

        <div id="titre">

            <h1>La carte de France</h1>

        </div>

        <div id="connecter">

            <?php
            require_once('utils.php');
                $connecte= isset($_SESSION[ID]);
                    if($connecte)
                    {
                    
                
                        echo "<p>Profil de : ".$_SESSION[PSEUDO]."</p>";
            
                    }else
                    {
                        echo "Non connecté";
                    }
            ?>

        </div>

    </header>
</div>