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
        session_destroy();
        session_start();
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
        $select = "Select userId from session where sessionId = '" . session_id() . "' and sessionExpire > '" . $time . "'";
        $result = db::query($select, null, false, false);
        if (count($result) > 0)
        {
            $this->renewSession();
            $userId = $result[0]['userId'];


            $select = "select user.id, user.firstname, user.lastname from session left join user on user.id = session.userId where session.userId = " . $userId . " and  session.sessionId = '" . session_id() . "' and session.sessionExpire > '" . $time . "'";
            $result = db::query($select, null, false, false);
            //die(var_dump($result));
            $userData = $result[0];
            return $userData;
        }
        else
        {
            return false;
            //throw new Exception ('Session Expired! Please login again');

        }

    }
/*
    public function getSessionData()
    {
        $time = (date('Y-m-d G:i:s', time()));
        $select = "Select userId from session where sessionId = '" . session_id() . "' and sessionExpire > '" . $time . "'";
        $result = db::query($select, null, false, false);
        $userId = $result[0];

        $select = "select student.name from session left join students on students.id = session.userId where session.userId = " . $userId . " sessionId = '" . session_id() . "' and sessionExpire > '" . $time . "'";
        $result = db::query($select, null, false, false);
        $userName = $result[0];

        return $userName;


        // 'select * from session left join students on students.id = session.userId where session.userId = 28';
    }
*/

}
?>