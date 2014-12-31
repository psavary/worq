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

    public function createSession($userId)
    {
        //$session->createSession();
        $expiretime = (date('Y-m-d G:i:s', time()+1200));
        $insert = "insert into session (sessionId, userId, sessionExpire) VALUES ('" . session_id() . "'," . $userId . ",'" . $expiretime . "')";
        $result = db::query($insert, null, false, false);

    }

    public function renewSession()
    {
        $expiretime = (date('Y-m-d G:i:s', time()+1200));
        $update = "update session set sessionExpire = '$expiretime' where sessionId = '" . session_id() . "'";
        return db::query($update, null, false, false);
    }

    public function checkSession()
    {
        $time = (date('Y-m-d G:i:s', time()));
        $select = "Select * from session where sessionId = '" . session_id() . "' and sessionExpire > '" . $time . "'";
        $result = db::query($select, null, false, false);
        if (count($result) > 0)
        {
            $this->renewSession();
            return true;
        }
        else
        {
            return false;
            //throw new Exception ('Session Expired! Please login again');

        }
        //die(var_dump($select));
        /*
        $query = "Select * from session where sessionId = ".session_id();
        $result = db::query($query, null, false, false);
        if (!$result)
        {
            $query = "Insert into session (sessionId)";
        }
        return true;
        */

    }

}
?>