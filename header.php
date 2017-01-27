    <header id="header">

        <div id="image">
            <img src="img/cropped-logoldnr.png" alt="LDNR" />
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
                        echo "<p>Connecté sous le nom : ".$_SESSION[PSEUDO]."</p>\n<p>Statut : ".$_SESSION[PROFIL]."";
                    }
                    else
                    {
                        echo "Non connecté";
                    }
            ?>

        </div>

    </header>
