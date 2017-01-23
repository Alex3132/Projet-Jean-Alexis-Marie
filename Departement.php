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
				if($key == "contours") {
                    if(is_array($value) && !empty($value))
                    {
                        $this->contours = $value;
                    }
                }

                // Si la propriété de la classe existe, alors on met à  jour sa valeur.
				if(isset($this->$key))	$this->$key = $value;
			}
        }
    }

    /**
     * Summary of set id
     * @param int $id 
     */
    public function setId(int $id) {
        $this->id = $id;
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
        $this->id_region = $idRegion;
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
        $this->contours = $contours;
    }

    /**
     * Summary of get Id
     * @return integer
     */
    public function getId() : int{
        return $this->id;
    }

    /**
     * Summary of get Nom
     * @return integer
     */
    public function getNom() : string {
        return $this->id;
    }

    /**
     * Summary of get Id Region
     * @return integer
     */
    public function getIdRegion() : int{
        return $this->id_region;
    }

    /**
     * Summary of get Code
     * @return integer
     */
    public function getCode() : int{
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