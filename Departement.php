<?php

/**
 * Departement short summary.
 *
 * Departement description.
 *
 * @version 1.0
 * @author mamar
 */
class Departement
{
    private $id;
    private $nom;
    private $code;
    private $id_region;
    private $contours;

    /**
     * Default constructor
     * @param mixed $args
     */
    public function __contruct($args =null)
    {
        // Si notre paramÃ¨tre est un tableau non vide.
		if(is_array($args) && !empty($args))
		{
			// Alors pour chaque clé, on rÃ©cupÃ¨re sa valeur.
			foreach($args as $key => $value)
			{
				// Si la propriété de la classe existe, alors on met à  jour sa valeur.
				if(isset($this->$key))	$this->$key = $value;
			}
        }
    }
}