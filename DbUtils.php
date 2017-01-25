<?php
declare(strict_types=1);
require_once("./dbObj/Ville.php");
require_once("./dbObj/Departement.php");
require_once("./dbObj/Region.php");
require_once("./dbObj/User.php");
require_once("./dbObj/Coord.php");

// getUser(login) : User;
// existUser(login) : bool
// addUser(User user) : User;
//
// findVilleById(id) : Ville
// findVille(nom, dep, region) : Ville
// findDep(nom) :Departement
//

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

    CONST COLVILLES = "villes";
    CONST COLDEPS = "departements";
    CONST COLREGIONS = "regions";
    CONST COLUSERS = "users";


    private $jsFunc_GetNexSequence = 'function getNextSequence(%s) {
                                           var ret = db.counters.findAndModify(
                                                  {
                                                    query: { _id: %s },
                                                    update: { $inc: { seq: 1 } },
                                                    new: true
                                                  }
                                           );;

                                           return ret.seq;
                                    }"';

    // Connect to test database

    /**
     * Summary of __construct
     * @param mixed $database :  databe name
     */
    public function __construct() // Constructeur
    {
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
     * Verify if user exists
     * @param mixed $pseudo
     * @param mixed $pwd
     */
    public function getUser($pseudo, $pwd) : User {

        if($pseudo != "" && $pwd != "") {

            $filter = ['login' => $pseudo, 'mdp' => $pwd];
            $users = $this->ExecuteQueryToArray(DbUtils::COLUSERS, $filter, null);
            if(!empty($users) && count($users) == 1) {
                $user = new User($users[0]);
                return $user;
            }

            throw new Exception("unknow user");
        }

        throw new Exception("unknow user");
    }

    /**
     * Find Ville vy its id
     * @param mixed $idville
     * @return null|Ville
     */
    public function findVilleById($idville) : Ville {

        $obj = $this->findObjectById(DbUtils::COLVILLES, $idville, null);
        if(null != $obj) {

            $ville = new Ville($obj);
            //$ville = (Ville)$obj;
            return $ville;
        }

        throw new Exception("unknown ville");
    }


    /**
     * Find dep by its id
     * @param mixed $iddep
     * @return Departement|null
     */
    public function findDepById($id) : Departement {
        $obj = $this->findObjectById(DbUtils::COLDEPS, $id, null);
        if(null != $obj) {

            $dep = new Departement($obj);
            return $dep;
        }

        throw new Exception("unknown dep");
    }

    /**
     * Find region by its id
     * @param mixed $idregion
     * @return null|Region
     */
    public function findRegionById($id) : Region {
        $obj = $this->findObjectById(DbUtils::COLREGIONS, $id, null);
        if(null != $obj) {

            return new Region($obj);
        }

        throw new Exception("unknown region");
    }

    /**
     * Get current server
     * @return MongoDB\Driver\Server
     */
    public function GetServer() : MongoDB\Driver\Server {
        $readpref = new MongoDB\Driver\ReadPreference(MongoDB\Driver\ReadPreference::RP_PRIMARY);
        return $this->manager->selectServer($readpref);
    }

    public function FindVilleByNom($nom){

    if($nom){

        $filter = ['nom' =>['$regex' => new MONGODB\BSON\Regex($nom, 'i')]];
           $options = ['projection' => ['nom' => 1, 'lon' => 1, 'lat' => 1, '_id' => 0, '_id_dept' => 1, 'pop' => 1]];

    }else{

        throw new exception("no name of city written");
    }

    $array = $this->ExecuteQueryToArray('villes', $filter, $options);
    return $array;
       }

    /**
     * Find an object by its _id
     * @param mixed $colname
     * @param mixed $id
     * @throws Exception
     * @return mixed
     */
     function findObjectById($colname, $id) {

        $idint = intval($id);
        if($idint != 0) {
            $filter = ['_id' => $idint ];
        } else {
            throw new Exception("id is not an integer");
        }

        $array = $this->ExecuteQueryToArray($colname, $filter, null);
        if(!empty($array)) {
            return $array[0];
        }

        return null;
    }


    /**
     * Excecute command on current database and return a MongoDB\Driver\Cursor
     * @param mixed $cmd
     * @return MongoDB\Driver\Cursor
     */
    private function ExecuteCommand($cmd) : MongoDB\Driver\Cursor
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
    private function ExecuteCommandToArray($cmd) : array
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
    private function ExecuteAdminCommand($cmd)
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
    private function ExecuteAdminCommandToArray($cmd)
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
    private function ExecuteQuery($collection, $filter, $queryoptions) : MongoDB\Driver\Cursor
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
    private function ExecuteQueryToArray($collection, $filter, $queryoptions) : array
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