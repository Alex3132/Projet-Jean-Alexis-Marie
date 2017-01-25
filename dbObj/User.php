<?php

declare(strict_types=1);

/**
 * User short summary.
 *
 * User description.
 *
 * @version 1.0
 * @author mamar
 */
class User
{
    private $_id;
    private $login;
    private $mdp;
    private $mail;
    private $profil;

    /**
     * Default constructor
     * @param mixed $args
     *
     * $args = array();
     * $args['login'] = "C'est mon login";
     * $args['mdp'] = "C'est mon mdp";
     *
     */
    public function __construct($args = null)
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
     * Set id
     * @param mixed $id
     */
    public function setID($id) {
        $this->_id = $id;
    }

    /**
     * Set login
     * @param mixed $log
     */
    public function setLogin($log)
    {
        $this->login = $log;
    }

    /**
     * Set mdp
     * @param mixed $mdp
     */
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;
    }

    /**
     * Set mail
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Set mail
     * @param mixed $profil
     */
    public function setProfil($profil)
    {
        if($profil != "admin" && $profil != "edit")
        {
            throw new Exception("Bad profil");
        }

        $this->profil = $profil;
    }

    /**
     * Get id
     * @param mixed $log
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Get login
     * @param mixed $log
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Get mdp
     * @param mixed $mdp
     * @return mixed
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * Get mail
     * @param mixed $mail
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Get profil
     * @param mixed $profil
     * @return mixed
     */
    public function getProfil()
    {
        return $this->profil;
    }
}