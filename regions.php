<?php

declare(strict_types=1);





class Regions
{
    private $id;
    private $nom;
   
    
    
    public function __construct($args == null)
    {
        
       if(is_array($args) && !empty($args))
		{	
			foreach($args as $key => $value)
			{
				if(isset($this->$key))	$this->$key = $value;
            }
    
        }
    }
    
    public function setId($id) 
    {
        $this->id = $id;
    }
    
    public function setNom($nom) 
    {
        $this->nom = $nom;
    }
    
    public function getId() : double
    {
        return $this->id;
        
    }
    
    public function getNom() : string
    {
        return $this->nom;
    }
}