<?php
/**

 * @category    CV
 * @package     
 * @copyright   Copyright (c) 2014 Philippe Savary
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog Search Controller
 *
 * @category   
 * @package    
 * @module     
 */
final class Dbpdo
{
    static $inst = null;
    private $dbh = null;
    private $host = 'localhost';
    private $dbname = 'cvsavary';
    private $user = 'root';
    private $pass = '';

    private  function __construct()
    {
        try
        {
            $dbh = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
        }
        catch(Exception $e)
        {
            Throw new Exception($e);
        }
    }
    
    private function __clone()
    {
        //Me not like clones! Me smash clones!
    }
    
    /**
     * Call this method to get singleton
     *
     * @return Dbpdo
     */
    public static function getInstance()
    {
        if ($inst === null) {
            $inst = new Dbpdo();
        }
        return $inst;
    }

}
?>