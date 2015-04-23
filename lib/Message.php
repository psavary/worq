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

    public function sendMessage ($message)
    {
       // die(var_dump($message));
        $messageId = $message['id'];
        $receiverId = $message['receiverId'];
        $userId = self::getUserId();
        $sql = "insert into messageSent (messageId, receiverId)
                VALUES ($messageId, $receiverId)";
        $response = db::query($sql, null, false, true);

    }

    public function saveContact ($contactId)
    {
        $userId = self::getUserId();
        $sql = "insert into userContacts (userId, contactId)
                VALUES ($userId, $contactId)";
        //die($sql);

        $response = db::query($sql, null, false, true);

    }

    public function getUserContacts()
    {
        $userId = self::getUserId();
        $sql = "select  user.id as id, user.firstname as firstname, user.lastname as lastname from userContacts left  join user on userContacts.contactId = user.Id where userContacts.userId = $userId";
        $response = db::query($sql, null, false, true);
        return $response;

    }

    private function getUserId ()
    {
        $session = new Session;

        $userData = $session->checkSession();

        if (!$userData)
        {
            throw new Exception ('Bitte loggen Sie sich ein um Ihre Nachricht speichern zu können!');
        }

        return $userData['id'];

    }

    public function save($post, $messageId = null)
    {


        $userId = self::getUserId();

        $message = null;

        If (array_key_exists('message',$post)){
            $message = (array)$post['message'];


            unset($post['message']);
        }
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


    public function get ($messageId)
    {
        if (!$messageId)
        {
            throw new Exception ('Aktion kann nicht ausgeführt werden');
        }

        //todo check if the user is allowed to see this message
        $returnArray = array();
        $returnArray['message'] = self::getMessage($messageId);
        $returnArray['jobprofile'] = self::getJobprofile($messageId);
        $returnArray['availability'] = self::getAvailability($messageId);

        return $returnArray;
    }

    public function getDraftList()
    {


        $userId = self::getUserId();

        $sql = "select * from message where companyId = $userId"; //todo remove

        $response = db::query($sql, null, false, false);

        return $response;

    }


    public function getOpenList()
    {


        $userId = self::getUserId();

        $sql = "select * from messageSent left join message on message.id =  messageSent.messageId   where message.companyId = $userId and messageSent.status <= 1"; //todo remove

        $response = db::query($sql, null, false, false);

        return $response;

    }

    private function getMessage ($messageId = null, $userId = null)
    {
        // $sql = "select header, message from message where id = $messageId and companyId = $userId";
        $sql = "select header, message from message where id = $messageId"; //todo remove

        $response = db::query($sql, null, false, true);

        // die(var_dump($sql));
        if(!$response)
        {
            throw new Exception ('Sie sind nicht berechtigt diese Aktion auszuführen.');
        }
        else
        {
            return  $response[0];
        }
    }


    private function getJobprofile ($messageId)
    {
        $sql = "select employmentType, workloadFrom, workloadTo, availableFrom, availableTo, commission, replyDate, region from messageJobprofile where messageId = $messageId";
        $response = db::query($sql, null, false, true);
        return $response[0];



    }


    private function getAvailability ($messageId)
    {
        $sql = "select day, morning, afternoon, evening, night from messageAvailability where messageId = $messageId";
        $response = db::query($sql, null, false, true);

            $availabilities = array();

        foreach ($response as $arrayKey => $row)
        {
            $day = $row['day'];
            unset($row['day']);

            foreach ($row as $daytime => $isTrue)
            {
                $availabilities[$day][$daytime] = (bool)$isTrue;
            }
        }
        return $availabilities;
    }


    private function saveMessage ($message = null, $userId, $messageId = null)
    {

        if (is_null($messageId))
        {
            $insertMessage =  $sql = "
                insert into message (companyId, status)
                VALUES ($userId, 0)";
            $messageId = db::query($insertMessage, null, false, true, true);

        }
        else
        {
            $sql = "select id from message where id = $messageId and companyId = $userId";
            $response = db::query($sql, null, false);

            if(!$response)
            {
                throw new Exception ('Sie sind nicht berechtigt diese Aktion auszuführen.');
            }
            else
            {
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
            $response = db::query($sql, null, false, true);

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