<?php

declare(strict_types=1);
 require("Coord.php");

/**
 * User short summary.
 *
 * User description.
 *
 * @version 1.0
 * @author mamar
 */
class Villes
{
    private $id;
    private $id_dept;
    private $nom;
    private $cp;
    private $pop;
    private $coord;
   

    /**
     * Default constructor
     * @param mixed $args
     *
     * 
     */
    public function __contruct($args = null)
    {
        $this->coord = new Coord();
		// Si notre paramètre est un tableau non vide.
		if(is_array($args) && !empty($args))
		{
			// Alors pour chaque clé, on récupère sa valeur.
			foreach($args as $key => $value)
			{
				// Si la propriété de la classe existe, alors on met à jour sa valeur.
				if(isset($this->$key))	$this->$key = $value;
			}
        }
    }
/**
     * Set Id
     * @param mixed $id
     */
    public function setId($id)
    {
       $this->id = $id;
    }
    /**
     * Set id_dept
     * @param mixed $id_dept
     */
    public function setId_dept($id_dept)
    {
       $this->id_dept = $id_dept;
    }
    /**
     * Set Nom
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Set cp
     * @param mixed $cp
     */
    public function setCp($cp)
    {
        $this->cp = $cp;
    }

    /**
     * Set pop
     * @param mixed $pop
     */
    public function setPop($pop)
    {
        $this->pop = $pop;
    }
    
     /**
     * Set lat
     * @param mixed $lat
     */
 public function setLat($lat)
    {
        $this->coord->lat = $lat;
    }
    
     /**
     * Set lon
     * @param mixed $lon
     */
     public function setLon($lon)
    {
        $this->coord->lon = $lon;
    }
  
    /**
     * Get id
     * @param mixed $id
     * @return mixed
     */
    public function getId() : double
    {
        return $this->id;
    }

    /**
     * Get id_dept
     * @param mixed $id_dept
     * @return mixed
     */
    public function getId_Dept() : double
    {
        return $this->id_dept;
    }


    /**
     * Get nom
     * @param mixed $nom
     * @return mixed
     */
    public function getNom() : string
    {
        return $this->nom;
    }

    /**
     * Get cp
     * @param mixed $cp
     * @return mixed
     */
    public function getCp() : string
    {
        return $this->cp;
    }

    /**
     * Get pop
     * @param mixed $pop
     * @return mixed
     */
    public function getPop() : double
    {
        return $this->pop;
    }

    /**
     * Get lat
     * @param mixed $lat
     * @return mixed
     */
    public function getLat() : double
    {
        return   $this->coord->lat;
    }
    
    /**
     * Get lon
     * @param mixed $lon
     * @return mixed
     */
    public function getLon() : double
    {
        return   $this->coord->lon;
    }
}