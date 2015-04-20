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

    public static function query($sql, Array $dataArray = null, $asJson = false, $needsValidSession = true, $returnLastInsertedId = false)
    {
        try
        {
            $queryAllowed = true;
            if($needsValidSession)
            {
                $session = new Session;
                $queryAllowed = $session->checkSession(); //@psa todo refactor
            }
            else if (!$needsValidSession)
            {
                $queryAllowed = true;
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

                if ($returnLastInsertedId)
                {
                    return $db->lastInsertId();
                }

                $results=$statement->fetchAll(PDO::FETCH_ASSOC);

                //todo add errorhandling and maybe transactions
                //return $statement->errorInfo();

                if($asJson)
                {
                    $results=json_encode($results);
                }

                return $results;
            }
            else
            {
                throw new Exception('Sitzung abgelaufen. Bitte loggen Sie sich ein um die Daten speichern zu können');
            }

        }
        catch (Exception $e)
        {
           //throw new Exception($e->getMessage(). " ".$sql);
            throw new Exception($e->getMessage());

        }
    }

    private function __construct()
    {

    }

} 