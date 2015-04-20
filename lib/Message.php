<?php
/**
 * Created by PhpStorm.
 * User: philou
 * Date: 03.12.14
 * Time: 22:27
 */

class Message {


    function __construct()
    {

    }

    public function save($post, $messageId = null)
    {
        $session = new Session;

        //@psa todo check session and insert userId into studentJobprofile.....
        $userData = $session->checkSession();

        if (!$userData)
        {
            throw new Exception ('Bitte loggen Sie sich ein um Ihre Nachricht speichern zu können!');
        }

        $userId = $userData['id'];
        $message = null;

        If (array_key_exists('message',$post)){
            $message = (array)$post['message'];


            unset($post['message']);
        }
        //die(var_dump($message));
        $messageId = self::saveMessage($message, $userId, $messageId);

        if (!is_null($messageId))
        {
            If (array_key_exists('availability',$post))
            {
                $availability = (array)$post['availability'];

                self::saveAvailability($availability,$messageId);

                unset($post['availability']);
            }
            If (array_key_exists('jobprofile',$post))
            {
                $jobprofile = (array)$post['jobprofile'];

                self::saveJobprofile($jobprofile,$messageId);

                unset($post['jobprofile']);
            }
            return $messageId;
        }
        else
        {
            throw new Exception ('Nachricht konnte nicht gespeichert werden!');
        }
    }

    private function saveMessage ($message = null, $userId, $messageId = null)
    {

        if (is_null($messageId))
        {
            $insertMessage =  $sql = "
                insert into message (companyId)
                VALUES ($userId)";
            $messageId = db::query($insertMessage, null, false, true, true);

        }
        else
        {
          // die('*'.$messageId.'*');
            $sql = "select id from message where id = $messageId and companyId = $userId";
            $response = db::query($sql, null, false);

            if(!$response)
            {
                throw new Exception ('Sie sind nicht berechtigt diese Aktion auszuführen.');
            }
            else
            {
               // die(var_dump($response));
                $messageId =  $response[0]['id'];
            }

        }
        if (!is_null($message))
        {
            foreach ($message as $key => $value)
            {

                if($value != "")
                {
                    $sqlUpdate = "update message set $key = '$value' where id = $messageId  and companyId = $userId";
                    $response = db::query($sqlUpdate, null, false, true);
                   // var_dump($sqlUpdate);


                }
            }
        }
        return $messageId;
    }


    private function saveJobprofile ($jobprofile, $messageId)
    {
        $sql = "select id from messageJobprofile where messageId = $messageId";
        $response = db::query($sql, null, false);

        if (!$response)
        {
            $sql = "insert into messageJobprofile (messageId) values ($messageId)";
            db::query($sql, null, false, true);
        }


        //@psa todo save that stuff
        foreach ($jobprofile as $key => $value)
        {

            if(!is_null($value))
            {
                $sqlUpdate = "update messageJobprofile set $key = '$value' where messageId = $messageId ";
                $response = db::query($sqlUpdate, null, false, true);

            }

        }
    }


    private function saveAvailability ($availability, $messageId)
    {
        //@psa todo save that stuff
        foreach ($availability as $day => $row)
        {
            $sql = "select id from messageAvailability where messageId = $messageId and day = '$day'";
            $response = db::query($sql, null, false);

            if (!$response)
            {
                $sql = "insert into messageAvailability (messageId, day) values ($messageId, '$day')";
                $response = db::query($sql, null, false, true);
            }

            foreach ($row as $daytime => $isTrue)
            {
                if($isTrue)
                {
                    $insertValue = 1;
                }
                else
                {
                    $insertValue = 0;

                }

                $sqlUpdate = "update messageAvailability set $daytime = $insertValue where messageId = $messageId and day = '$day' ";
                $response = db::query($sqlUpdate, null, false, true);
            }
        }
    }

}
?>