<?php
/**
 * Created by PhpStorm.
 * User: philou
 * Date: 27.10.14
 * Time: 23:03
 */



class db
{

    public static function get()
    {
        static $database = null;

        if ($database === null)
        {
            $servername = "127.0.0.1";
            $username = "root";
            $password = "";

            try
            {
                $database = new PDO("mysql:host=$servername;dbname=worq", $username, $password);
                //echo "Connected successfully";
            }
            catch (PDOException $e)
            {
                echo $e->getMessage();
            }
        }
        return $database;
    }

    public static function query($sql, Array $dataArray= null, $asJson = false)
    {
        $db = self::get();
        $statement=$db->prepare($sql);
        $statement->execute($dataArray);
        $results=$statement->fetchAll(PDO::FETCH_ASSOC);
        if($asJson)
        {
            $results=json_encode($results);
        }

        return $results;
    }

    private function __construct()
    {

    }

} 