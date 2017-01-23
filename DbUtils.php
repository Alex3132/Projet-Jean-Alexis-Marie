<?php
declare(strict_types=1);

/**
 * DbUtils short summary.
 *
 * DbUtils description.
 *
 * @version 1.0
 * @author mamar
 */

class DbUtils{

    // Configuration
    private  $dbhost = 'localhost';
    private $dbname = 'geo_france';
    private $manager = null;
    private $command = null;


    // Connect to test database

    /**
     * Summary of __construct
     * @param mixed $database :  databe name
     */
    public function __construct($database) // Constructeur
    {
        $this->dbname = $database;
        try
        {
            $this->manager = new MongoDB\Driver\Manager("mongodb://".$this->dbhost.":27017");

        }
        catch (MongoDB\Driver\Exception\Exception $exception) {
            die(sprintf('<p class="error">Erreur PDO <em>%s</em></p>'."\n", $exception->getMessage()));
        }
    }

    /**
     * Unconnect to db
     */
    public function UnConnect(){
        unset($this->manager);
    }

    /**
     * Get current server
     * @return MongoDB\Driver\Server
     */
    public function GetServer() : MongoDB\Driver\Server {
        $readpref = new MongoDB\Driver\ReadPreference(MongoDB\Driver\ReadPreference::RP_PRIMARY);
        return $this->manager->selectServer($readpref);
    }

    /**
     * Excecute command on current database and return a MongoDB\Driver\Cursor
     * @param mixed $cmd
     * @return MongoDB\Driver\Cursor
     */
    public function ExecuteCommand($cmd) : MongoDB\Driver\Cursor
    {
        try
        {
            $command = new MongoDB\Driver\Command($cmd);
        	return $this->manager->executeCommand($this->dbname, $command);
        }
        catch (MongoDB\Driver\Exception\Exception $exception)
        {
            die(sprintf('<p class="error">Erreur PDO <em>%s</em></p>'."\n", $exception->getMessage()));
        }
    }

    /**
     * Excecute command on current database and return an array with results
     * @param mixed $cmd
     * @return array
     */
    public function ExecuteCommandToArray($cmd) : array
    {
        try
        {
            $command = new MongoDB\Driver\Command($cmd);
        	$cursor = $this->manager->executeCommand($this->dbname, $command);
            return $cursor->toArray();
        }
        catch (MongoDB\Driver\Exception\Exception $exception)
        {
            die(sprintf('<p class="error">Erreur PDO <em>%s</em></p>'."\n", $exception->getMessage()));
        }
    }

    /**
     * Excecute command on admin database and return a MongoDB\Driver\Cursor
     * @param mixed $cmd
     * @return MongoDB\Driver\Cursor
     */
    public function ExecuteAdminCommand($cmd)
    {
        try
        {
            $command = new MongoDB\Driver\Command($cmd);
        	return $this->manager->executeCommand("admin", $command);
        }
        catch (MongoDB\Driver\Exception\Exception $exception)
        {
            die(sprintf('<p class="error">Erreur PDO <em>%s</em></p>'."\n", $exception->getMessage()));
        }
    }

    /**
     * Excecute command on admin database and return an array
     * @param mixed $cmd
     * @return array
     */
    public function ExecuteAdminCommandToArray($cmd)
    {
        try
        {
            $command = new MongoDB\Driver\Command($cmd);
        	$cursor = $this->manager->executeCommand("admin", $command);
            return $cursor->toArray();
        }
        catch (MongoDB\Driver\Exception\Exception $exception)
        {
            die(sprintf('<p class="error">Erreur PDO <em>%s</em></p>'."\n", $exception->getMessage()));
        }
    }

    /**
     * Summary of ExecuteQuery
     * @param mixed $collection
     * @param mixed $filter
     * @param mixed $queryoptions
     * @return MongoDB\Driver\Cursor
     */
    public function ExecuteQuery($collection, $filter, $queryoptions) :MongoDB\Driver\Cursor
    {
        try
        {
            $command = new MongoDB\Driver\Query($filter, $queryoptions);
        	return $this->manager->executeQuery("$this->dbname.$collection", $command);
        }
        catch (MongoDB\Driver\Exception\Exception $exception)
        {
            die(sprintf('<p class="error">Erreur PDO <em>%s</em></p>'."\n", $exception->getMessage()));
        }
    }

    /**
     * Summary of ExecuteQuery
     * @param mixed $collection
     * @param mixed $filter
     * @param mixed $queryoptions
     * @return array
     */
    public function ExecuteQueryToArray($collection, $filter, $queryoptions) : array
    {
        try
        {
            $command = new MongoDB\Driver\Query($filter, $queryoptions);
            $cursor = $this->manager->executeQuery("$this->dbname.$collection", $command);
        	return $cursor->toArray();
        }
        catch (MongoDB\Driver\Exception\Exception $exception)
        {
            die(sprintf('<p class="error">Erreur PDO <em>%s</em></p>'."\n", $exception->getMessage()));
        }
    }
}

try
{
	$connect = new DbUtils("geo_france");

}
catch (Exception $exception)
{
    echo $exception->getMessage();
}