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
    private $id;
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
    public function __contruct($args = null)
    {
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
     * Set login
     * @param mixed $log
     */
    public function setLogin($log)
    {
        $this->_login = $log;
    }

    /**
     * Set mdp
     * @param mixed $mdp
     */
    public function setMdp($mdp)
    {
        $this->_mdp = $mdp;
    }

    /**
     * Set mail
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->_mail = $mail;
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

        $this->_profil = $profil;
    }

    /**
     * Get login
     * @param mixed $log
     * @return mixed
     */
    public function getLogin($log) : string
    {
        return $this->_login;
    }

    /**
     * Get mdp
     * @param mixed $mdp
     * @return mixed
     */
    public function getMdp($mdp) : string
    {
        return $this->_mdp;
    }

    /**
     * Get mail
     * @param mixed $mail
     * @return mixed
     */
    public function getMail($mail) : string
    {
        return $this->_mail;
    }

    /**
     * Get profil
     * @param mixed $profil
     * @return mixed
     */
    public function getProfil($profil) : string
    {
        return $this->_profil;
    }
}