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
class Ville
{
    public $_id;
    public $_id_dept;
    public $nom;
    public $cp;
    public $pop;
    public $lat;
    public $lon;

    /**
     * Default constructor
     * @param mixed $args
     *
     *
     */
    public function __construct($args)
    {
        // Si notre paramÃ¨tre est un tableau non vide.
		if($args != null)
		{
			// Alors pour chaque clé, on rÃ©cupÃ¨re sa valeur.
			foreach($args as $key => $value)
			{
				// Si la propriété de la classe existe, alors on met à  jour sa valeur.
				if(isset($this->$key) || property_exists($this, $key))	$this->$key = $value;
            }
        }

    }
/**
     * Set Id
     * @param mixed $id
     */
    public function setId($id)
    {
       $this->_id = $id;
    }
    /**
     * Set id_dept
     * @param mixed $id_dept
     */
    public function setId_dept($id_dept)
    {
       $this->_id_dept = $id_dept;
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
        $this->lat = $lat;
    }

     /**
     * Set lon
     * @param mixed $lon
     */
     public function setLon($lon)
    {
        $this->lon = $lon;
    }

    /**
     * Get id
     * @param mixed $id
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Get id_dept
     * @param mixed $id_dept
     * @return mixed
     */
    public function getId_Dept()
    {
        return $this->_id_dept;
    }


    /**
     * Get nom
     * @param mixed $nom
     * @return mixed
     */
    public function getNom()
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
        return   $this->lat;
    }

    /**
     * Get lon
     * @param mixed $lon
     * @return mixed
     */
    public function getLon() : double
    {
        return   $this->lon;
    }
}