<?php
/**
 * Created by PhpStorm.
 * User: philou
 * Date: 27.10.14
 * Time: 23:03
 */



class db
{

    private static function get()
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

    public static function query($sql, Array $dataArray= null, $asJson = false, $needsValidSession = true)
    {
        try
        {
            if($needsValidSession)
            {
                $session = new Session;
                $queryAllowed = $session->checkSession();

            }
            else if (!$needsValidSession)
            {
                $queryAllowed = false;
            }
            else
            {
                $queryAllowed = false;
            }

            if($queryAllowed)
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
            else
            {
                return false;
            }

        }
        catch (Exception $e)
        {
            echo $e->getMessage(). " ".$sql;
        }
    }

    private function __construct()
    {

    }

} 