<?php
require_once 'bootstrap.php';
require './lib/slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

//add db
require_once './lib/db.php'; //@psa todo refactor with autoloader and remove singleton pattern in favor of DI to make shit testable

//initalize Session
$session = new Session;
//initialize Timezone
date_default_timezone_set('Europe/Paris');

$app = new \Slim\Slim(array(
    'debug' => true //@psa todo production
));

//@psa todo figure this login stuff out
$app->get('/getSession/:sessionId', function () {

    $session = new Session;

    $userData = $session->checkSession();

    if($userData)
    {
        echo json_encode($userData);
    }
    else
    {
        echo 0;
    }

});


/*
 * check if usercredentials exist, if so, create session and save it to db
 */
$app->post('/postLogin/', function ()
{
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = $request->getBody();
    $post = (array)json_decode($body);

    return login($post);
});

function login ($post)
{
    try
    {
        $session = new Session;

        $select = "Select * from user where email = :email and password = :password";
        $qresult = db::query($select, $post, false, false);


        if (count($qresult) >= 1)
        {
            $hasSession = $session->checkSession();
            if (!$hasSession)
            {
                $userId = $qresult[0]['id'];
                $session->createSession($userId);
                $result = array("status" => "success", "response" => "Login Success, new Session");
            }
            else if ($hasSession)
            {
                $session->renewSession();
                // die(var_dump($update)); //@psa todo here is something wrong....continue work here!!

                $result = array("status" => "success", "response" => "Login Success, renew Session");
            }
        }
        else
        {
            $result = array("status" => "error", "response" => "Login Failed");
        }

        return json_encode($result);
    }
    catch (Exception $e)
    {
        $app->halt(400, $e);

    }
}


$app->post('/postImage/:email/:userType/:file/:type', function ($email, $userType, $image, $type)
{
    try
    {
        //@psa todo: make sure, the image only gets uploaded if no image exists already (security!)
        $session = new Session;
        $app = \Slim\Slim::getInstance();
        $request = $app->request();
        $body = $request->getBody();
        $post = (array)json_decode($body);
        $imageType = $image . '/' . $type;
        $array = array('imageType' => $imageType, 'imageData' => $body, 'email' => $email, 'userType' => $userType);
        $sql = "update user set imageType = :imageType, imageData = :imageData where email = :email and type = :userType";
        $data = db::query($sql, $array, false, false);
    }
    catch (Exception $e)
    {
        $app->halt(400, $e);

    }
});


//check if entered Emailaddress is unique in DB type 0 is student
$app->get('/getStudentEmailUnique/:email', function ($email)
{
    echo checkEmailUnique($email, 0);
});


//check if entered Emailaddress is unique in DB, type 1 is company
$app->get('/getCompanyEmailUnique/:email', function ($email)
{
    echo checkEmailUnique($email, 1);
});


function checkEmailUnique ($email, $userType = 0)
{
    $select = "Select email from user where email = '$email' and type = $userType";
    $data = db::query($select,null, false, false);
    if (count($data) == 0)
    {
        $trueresponse = array("response" => true);
        return json_encode($trueresponse);
    }
    else
    {
        $falseresponse = array("response" => false);
        return json_encode($falseresponse);
    }
}


$app->get('/hello/', function () //todo refactor this api function name
{
    try
    {
        //todo continue here with this sql
        $select = "Select user.id, user.firstname, user.lastname, study.name as study, region.region as region, user.imageData as image from user left join studentStudy on user.id=studentStudy.studentId left join study on studentStudy.study=study.id left join region on user.region = region.id ";

        $data = db::query($select,null,false);

        //psa todo experimental code to refactor at some point due to performance concerns
        $count = 0;
        foreach ($data as $entry)
        {
            $data[$count]['image'] = base64_encode($entry['image']);
            $count++;
        }
        $data = json_encode($data);

        echo $data;

    }
    catch (Exception $e)
    {
        $app = \Slim\Slim::getInstance();

        $app->halt(400, $e->getMessage());
    }
});


$app->get('/regions/', function ()
{
    $select = "Select * from region";

    $data = db::query($select,null,true, false);

    echo ($data);

});


$app->get('/study/', function ()
{
    $select = "Select * from study";

    $data = db::query($select,null,true, false);

    echo ($data);
});


$app->get('/university/', function ()
{
    $select = "Select * from universities";

    $data = db::query($select,null,true, false);

    echo ($data);
});


$app->get('/languageDiploma/:id', function ($id)
{
    $select = "Select * from languageDiploma where languageId=".$id;

    $data = db::query($select,null,true, false);

    echo ($data);
});


$app->get('/employmenttypes/', function ()
{
    $select = "Select * from employmenttypes";

    $data = db::query($select,null,true, false);

    echo ($data);
});


$app->get('/workloads/', function ()
{
    $select = "Select * from workloads";

    $data = db::query($select,null,true, false);

    echo ($data);
});

$app->get('/mobility/', function ()
{
    $select = "Select * from mobility";

    $data = db::query($select,null,true, false);

    echo ($data);
});

$app->get('/languages/', function ()
{
    $select = "Select * from languages";

    $data = db::query($select,null,true, false);

    echo ($data);
});

$app->get('/industries/', function ()
{

    $select = "Select * from industry";

    $data = db::query($select,null,true, false);

    echo ($data);

});

$app->post('/postStudent/', function () {

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = $request->getBody();
    $post = json_decode($body);

    try {

        addStudent($post->student);
        //var_dump($post->student);
        $studentId = getStudentIdByEmail($post->student->email);

        addAddress($studentId, $post->address);

        addUniversityAndStudy($studentId, $post->university->id, $post->study->id, $post->minor->id);

        //todo add languages
        addLanguages($studentId, $post->language);

        sendConfirmationMail($post->student->email, $studentId);

       // $app->redirect('/#/confirmation');
    }
    catch (Exception $e)
    {
        $app->halt(400, $e->getMessage());
    }
});

$app->post('/postCompany/', function () {

    $app = \Slim\Slim::getInstance();
    //$app = new \Slim\Slim();
    $request = $app->request();
    $body = $request->getBody();
    $post = json_decode($body);

    try
    {
        addCompany($post->company);

        $userId = getCompanyIdByEmail($post->company->email);

        addAddress($userId, $post->address);

        sendConfirmationMail($post->company->email, $userId);
    }
    catch (Exception $e)
    {
        $app->halt(400, $e->getMessage());
    }
});


/*
 * creates hash value for confirmation by user
 */
function sendConfirmationMail($email, $studentId)
{
    $hash = md5($email.$studentId);

    $array = array('email' => $email, 'studentId' => $studentId, 'hash' => $hash);
    //var_dump($array);
    $sql = "
    insert into studentConfirmation (email, studentId, hashValue)
    VALUES (:email, :studentId, :hash)
    ";

    try
    {
        $response = db::query($sql, $array, false, false);

        $confirmationUrl = $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/api.php/confirmRegistration/$hash";
        $text = "Hallo, bitte bestätige Deine Registrierung bei worq, indem Du folgendem Link folgst: <a href=\"$confirmationUrl\">$confirmationUrl</a>";
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <webmaster@worq.com>' . "\r\n";
        mail('philou.savary@gmail.com', 'Bitte Registrierung bei Worq bestätigen', $text, $headers);
    }
    catch (Exception $e)
    {
        throw new Exception ($e);
    }
}

/*
 * Link the User follows to complete Registration
 *
 */
$app->get('/confirmRegistration/:hash', function ($hash)
{
    try
    {
        $select = "Select * from studentConfirmation where hashValue = '$hash'";

        $data = db::query($select,null,false, false);

        if (count($data) > 0)
        {
            $array = array('studentId' => (int)$data[0]['studentId']);

            $update = "Update user set isConfirmed = 1, isActive = 1 where Id = :studentId";
            $data = db::query($update,$array,false, false);

            $selectUser = "Select email, password from user where id = :studentId";
            $userCredentials = db::query($selectUser,$array,false, false);

            $userCredentials = $userCredentials[0];


            login($userCredentials);

            $selectUser = "Select type from user where id = :studentId";
            $userType = db::query($selectUser,$array,false, false);

            $userType = (int) $userType[0]['type'];

            $app = \Slim\Slim::getInstance();

            if ($userType == 1)
            {
                $app->redirect('/#/');
            }
            else
            {
                $app->redirect('/#/jobprofile');
            }
        }
    }
    catch (Exception $e)
    {
        throw new Exception ($e);
    }
});


//@psa refactor this into separate class
function addUniversityAndStudy ($studentId, $university, $study, $minor)
{
    try
    {
        $array = array ('studentId' => $studentId, 'university' => $university, 'study' => $study, 'minor' => $minor);

        $sql = "
                insert into studentStudy (studentId, university, study,  minor)
                VALUES (:studentId, :university, :study, :minor)
        ";

        $response = db::query($sql, $array, false, false);
    }
    catch (Exception $e)
    {
        throw new Exception ($e);
    }

}

function addLanguages($studentId, $languagesArray)
{
    try{

        foreach($languagesArray as $row)
        {
            //not really pretty.....
            if(is_null($row->language) || is_null($row->languageDiploma) || $row->languageOral->id == "")
            {
                continue;
            }

            $idArray = array();

            $idArray['studentId'] = $studentId;
            /*
            $idArray['language'] = $row['language']['id'];
            $idArray['languageDiploma'] = $row['languageDiploma']['id'];
            $idArray['languageOral'] = $row['languageOral']['id'];
            */

            $idArray['language'] = (int)$row->language->id;
            $idArray['languageDiploma'] = (int)$row->languageDiploma->id;
            $idArray['languageOral'] = (int)$row->languageOral->id;
            var_dump($idArray);

            $sql =
            "
                insert into studentLanguages (studentId, languageId, languageDiplomaId,  languageOralId)
                VALUES (:studentId, :language, :languageDiploma, :languageOral)
            ";

            $response = db::query($sql, $idArray, false, false);
        }
    }
    catch (Exception $e)
    {
        throw new Exception ($e);

    }
}


function addStudent($student)
{
    $sql = "
    insert into user (firstname, lastname, gender,  email, password, telephone, type)
    VALUES (:firstname, :lastname, :gender, :email, :password, :telephone, :type)
    "; //todo add birthdate

    $studentArray = (array) $student;
    $studentArray['type'] = 0;

    try
    {
        $response = db::query($sql, $studentArray, false, false);
    }
    catch (Exception $e)
    {
        throw new Exception ($e);
    }
}

function addCompany($company)
{
    $sql = "
    insert into user (company, firstname, lastname, gender,  email, password, telephone, type)
    VALUES (:company, :firstname, :lastname, :gender, :email, :password, :telephone, :type)
    ";

    $companyArray = (array) $company;
    $companyArray['type'] = 1;

    try
    {
        $response = db::query($sql, $companyArray, false, false);
    }
    catch (Exception $e)
    {
        throw new Exception ($e);
    }
}




function addAddress($userId, $address)
{   $address = (array)$address;
    $address['userId'] = $userId;
    $sql = "
    insert into address (userId, street, streetno, zip, city)
    VALUES (:userId, :street, :streetno, :zip, :city)";
    try
    {
        $response = db::query($sql, $address, false, false);
        //var_dump(($response)); //@psa todo make sure only one email is assigned. Maybe throw error or something
    }
    catch (Exception $e)
    {
        throw new Exception ($e);
    }
}


function getStudentIdbyEmail($email)
{
    return getUserIdByEmailAndType($email, 0);
}


function getCompanyIdbyEmail($email)
{
    return getUserIdByEmailAndType($email, 1);
}


function getUserIdByEmailAndType ($email, $type)
{
    $sql = "
    select id from user where email='$email' and type = $type";
    try
    {
        $response = db::query($sql, null, false, false);
        // var_dump(($response[0]['id'])); //@psa todo make sure only one email is assigned. Maybe throw error or something
        return $response[0]['id'];
    }
    catch (Exception $e)
    {
        throw new Exception ($e);
    }


}


$app->post('/postJobprofile/', function () {
    try
    {
        $app = \Slim\Slim::getInstance();
        $session = new Session;

        //$app = new \Slim\Slim();
        $request = $app->request();
        $body = $request->getBody();
        $post = (array)json_decode($body);
        //$post = json_decode(json_encode($post));
        $availability = (array)$post['availability'];


        //@psa todo check session and insert userId into studentJobprofile.....
        $userData = $session->checkSession();

        if (!$userData)
        {
            throw new Exception ('Bitte loggen Sie sich ein um Ihr Jobprofil speichern zu können!');
        }
            echo "hallo?";//todo remove
        var_dump($userData); //todo remove
        die(); //todo remove

        addAvailability($availability);

        unset($post['availability']);


        $sql = "
        insert into studentJobprofile (employmentType, workloadFrom, workloadTo, commission, mobility, industry, promotion, region)
        VALUES (:employmentType, :workloadFrom, :workloadTo, :commission, :mobility, :industry, :promotion, :region)";

        $response = db::query($sql, $post, false, true); //@psa TODO somethings wrong here!!!!! continue work here!!!
    }
    catch (Exception $e)
    {
        $app->halt(400, $e->getMessage());
    }
    echo json_encode($response);

});


function addAvailability ($availability)
{
    //@psa todo save that stuff
    foreach ($availability as $day => $daytime)
    {
        var_dump($day);
        var_dump((array)$daytime);
    }

}

/*
 * @param: contains the result of the request
 */
function validate($sqlResult, $errorMessage = null)
{
    $app->halt(400, "do tell the user why it is not working");
}

$app->run();

?>