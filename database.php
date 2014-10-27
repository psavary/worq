<?php
/**
 * Created by PhpStorm.
 * User: philou
 * Date: 27.10.14
 * Time: 23:03
 */

//add meedoo
include_once  './lib/medoo.php';


class database
{

    public static function get()
    {
        static $database = null;

        if ($database === null)
        {
            $database = new medoo;
        }
        return $database;
    }

    private function __construct()
    {

    }

} 