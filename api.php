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


$app->get('/getSession/:sessionId', function ($sessionId) {


    echo 1;
  //maybe not needed anymore

});


/*
 * check if usercredentials exist, if so, create session and save it to db
 */
$app->post('/postLogin/', function ()
{
    try {
        $session = new Session;
        $app = \Slim\Slim::getInstance();
        $request = $app->request();
        $body = $request->getBody();
        $post = (array)json_decode($body);

        $select = "Select * from students where email = :email and password = :password";
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

        echo(json_encode($result));
    }
    catch (Exception $e)
    {
        $app->halt(400, $e);

    }
});

$app->post('/postImage/:email/:file/:type', function ($email, $image, $type)
{
    $session = new Session;
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $body = $request->getBody();
    $post = (array)json_decode($body);
    $imageType = $image.'/'.$type;
    $array = array('imageType' => $imageType, 'imageData' => $body, 'email' => $email);
    //$sql = "insert into students (imageType, imageData) VALUES (:imageType, :imageData) where emai = :email";
    $sql = "update students set imageType = :imageType, imageData = :imageData where email = :email";
    $data = db::query($sql,$array, false, false);
});


//check if entered Emailaddress is unique in DB
$app->get('/getStudentEmailUnique/:email', function ($email)
{
    $select = "Select email from students where email = '$email'";
    $data = db::query($select,null, false, false);

    if (count($data) == 0)
    {
        $trueresponse = array("response" => true);
        echo json_encode($trueresponse);
    }
    else
    {
        $falseresponse = array("response" => false);
        echo json_encode($falseresponse);
    }
});

$app->get('/hello/', function ()
{

    $select = "Select students.id, students.firstname, students.lastname, study.study as study, region.region as region from students left join study on students.study=study.id left join region on students.region = region.id";

    $data = db::query($select,null,true);

    echo ($data);

});


$app->get('/regions/', function ()
{
    echo
    '[
      {"id": "1", "name": "Ostschweiz"},
      {"id": "2", "name": "Zentralschweiz"},
      {"id": "3", "name": "Westschweiz"}
    ]';
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
    //$app = new \Slim\Slim();
    $request = $app->request();
    $body = $request->getBody();
    $post = json_decode($body);

    addStudent($post->student);
    //var_dump($post->student);
    $studentId = getStudentIdByEmail($post->student->email);

    addAddress($studentId, $post->address);

    addUniversityAndStudy($studentId, $post->university->id, $post->study->id, $post->minor->id);
    var_dump($post->student);

    //$result = array("status"=>"success","response"=>$response);

});


//@psa refactor this into separate class
function addUniversityAndStudy ($studentId, $university, $study, $minor)
{
    try
    {
        $sql = "
        update students set university=$university, study=$study, minor=$minor
        WHERE id = $studentId
        ";
        $response = db::query($sql, null, false, false);
        var_dump($sql);
    }
    catch (Exception $e)
    {
        echo $e->getTraceAsString();
    }

}

function addStudent($student)
{
    $sql = "
    insert into students (firstname, lastname, gender,  email, password, telephone)
    VALUES (:firstname, :lastname, :gender, :email, :password, :telephone)
    ";

    $studentArray = (array) $student;
    //var_dump($studentArray);

    try
    {
        $response = db::query($sql, $studentArray, false, false);

        var_dump($response);
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
}

function addAddress($studentId, $address)
{   $address = (array)$address;
    $address['studentId'] = $studentId;
    $sql = "
    insert into studentAddress (studentId, street, streetno, zip, city)
    VALUES (:studentId, :street, :streetno, :zip, :city)";
    try
    {
        $response = db::query($sql, $address, false, false);
        //var_dump(($response)); //@psa todo make sure only one email is assigned. Maybe throw error or something
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
}

function getStudentIdbyEmail($email)
{
    $sql = "
    select id from students where email='$email'";
    try
    {
        $response = db::query($sql, null, false, false);
       // var_dump(($response[0]['id'])); //@psa todo make sure only one email is assigned. Maybe throw error or something
        return $response[0]['id'];
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
}


$app->post('/postJobprofile/', function () {

    $app = \Slim\Slim::getInstance();
    //$app = new \Slim\Slim();
    $request = $app->request();
    $body = $request->getBody();
    $post = (array)json_decode($body);
    //$post = json_decode(json_encode($post));
    $availability = (array)$post['availability'];
    addAvailability($availability);
    die();

    unset($post['availability']);

    $sql = "
    insert into studentJobprofile (employmentType, workloadFrom, workloadTo, commission, mobility, industry, promotion, region)
    VALUES (:employmentType, :workloadFrom, :workloadTo, :commission, :mobility, :industry, :promotion, :region)";
    try
    {

        $response = db::query($sql, $post, false, true); //@psa TODO somethings wrong here!!!!! continue work here!!!
    }
    catch (Exception $e)
    {
        $app->halt(400, $e->getMessage());
    }
die(var_dump($response));
    echo json_encode($response);

});

function addAvailability ($availability)
{
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