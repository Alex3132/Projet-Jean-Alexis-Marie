<?php

declare(strict_types=1);





class Region
{
    private $_id;
    private $nom;



    public function __construct($args = null)
    {

       if($args != null)
		{
			foreach($args as $key => $value)
			{
				if(isset($this->$key) || property_exists($this, $key))	$this->$key = $value;
            }

        }
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getId()
    {
        return $this->_id;

    }

    public function getNom()
    {
        return $this->nom;
    }
}