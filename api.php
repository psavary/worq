<?php
require './lib/slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

//add meedoo
include_once 'db.php'; //@psa todo refactor with autoloader;


$app = new \Slim\Slim(array(
    'debug' => true
));


$app->get('/hello/', function () {


    $select = "Select students.id, students.firstname, students.lastname, study.study as study, region.region as region from students left join study on students.study=study.id left join region on students.region = region.id";

    $data = db::query($select);

    echo ($data);


});


$app->get('/regions/', function () {

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

    $data = db::query($select);

    echo ($data);
});

$app->get('/university/', function ()
{
    $select = "Select * from universities";

    $data = db::query($select);

    echo ($data);
});

$app->get('/languageDiploma/:id', function ($id)
{
    $select = "Select * from languageDiploma where languageId=".$id;

    $data = db::query($select);

    echo ($data);
});


$app->get('/languages/', function ()
{
    $select = "Select * from languages";

    $data = db::query($select);

    echo ($data);
});

$app->get('/industries/', function ()
{

    echo '[
      {"id": "1", "name": "Banken"},
      {"id": "2", "name": "Baubranche"},
      {"id": "3", "name": "Gastgewerbe"},
      {"id": "4", "name": "Medizin"}
    ]';
});

$app->post('/postStudent/', function () {
    //Create book
    $app = \Slim\Slim::getInstance();
    //$app = new \Slim\Slim();
    $request = $app->request();
    $body = $request->getBody();
    $post = json_decode($body);
   // $allPostVars = $app->request->post();
    $response = "irgendwas";
    //echo "hallo";
    //addStudent($post->student);
    $studentId = getStudentIdByEmail($post->student->email);
    addAddress($studentId, $post->address);
    addUniversityAndStudy($studentId, $post->university->id, $post->study->id, $post->minor->id);

    //$result = array("status"=>"success","response"=>$response);
   //die(var_dump($post));

    //echo json_encode($result);
});

function addUniversityAndStudy ($studentId, $university, $study, $minor)
{
    try
    {
        $sql = "
        update students set university=$university, study=$study, minor=$minor
        WHERE id = $studentId
        ";
        $response = db::query($sql);
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

    try
    {
        $prepared = db::get()->prepare($sql);
        $response = $prepared->execute($studentArray);
        $response = db::query($sql, $studentArray);
        //var_dump($response);
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
        $response = db::query($sql, $address);
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
        $response = db::query($sql);
       // var_dump(($response[0]['id'])); //@psa todo make sure only one email is assigned. Maybe throw error or something
        return $response[0]['id'];
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }


}

$app->run();

?>