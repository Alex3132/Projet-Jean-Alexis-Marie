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
    private $_id;
    private $nom;
    private $code;
    private $_id_region;
    private $contours = [];

    /**
     * Default constructor
     * @param mixed $args
     */
    public function __construct($args)
    {
        // Si notre paramÃ¨tre est un tableau non vide.
		if(null != $args)
		{
			// Alors pour chaque clé, on rÃ©cupÃ¨re sa valeur.
			foreach($args as $key => $value)
			{
				if($key == "contours") {
                    if(is_array($value) && !empty($value))
                    {
                        $this->setContours($value);
                    }

                }else {

                    // Si la propriété de la classe existe, alors on met à  jour sa valeur.
                    if(isset($this->$key) || property_exists($this, $key))	$this->$key = $value;
                }
			}
        }
    }

    /**
     * Summary of set id
     * @param int $id
     */
    public function setId(int $id) {
        $this->_id = $id;
    }

    /**
     * Summary of set nom
     * @param string $nom
     */
    public function setNom(string $nom) {
        $this->nom = $nom;
    }

    /**
     * Summary of set id region
     * @param int $idRegion
     */
    public function setIdRegion(int $idRegion) {
        $this->_id_region = $idRegion;
    }

    /**
     * Summary of set Code
     * @param int $code
     */
    public function setCode(int $code) {
        $this->code = $code;
    }

    /**
     * Summary of set Contours
     * @param array $contours
     */
    public function setContours(array $contours) {
       $this->contours = [];
       foreach($contours as $c)
       {
           if(is_array($c) && !empty($c) && count($c) == 2)
           {
               array_push($this->contours, new Coord($c[1], $c[2]));
           }
           else
           {
               $c = $contours[0];
               foreach($c as $e)
               {
                   if(is_array($e) && !empty($e) && count($e) == 2)
                   {
                       array_push($this->contours, new Coord($e[1], $e[0]));
                   }
               }

               break;
           }
       }
    }

    /**
     * Summary of get Id
     * @return integer
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Summary of get Nom
     * @return integer
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Summary of get Id Region
     * @return integer
     */
    public function getIdRegion() {
        return $this->_id_region;
    }

    /**
     * Summary of get Code
     * @return integer
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Summary of get Contours
     * @return array
     */
    public function getContours() : array{
        return $this->contours;
    }
}