<?php
/**
 * Created by PhpStorm.
 * User: philou
 * Date: 03.12.14
 * Time: 22:27
 */

class Session {


    function __construct()
    {
        if (session_id() == "")
        {
            session_start();
            $lifetime=600;
        }
    }

    public function checkSession()
    {
        $query = "Select * from session where sessionId = ".session_id();
        $result = db::query($query, null, false, false);
        if (!$result)
        {
            $query = "Insert into session (sessionId)";
        }
        return true;

    }

}
?>