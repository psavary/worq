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
    addStudent($post->student);
    //$result = array("status"=>"success","response"=>$response);
  //  die(var_dump($post));

    //echo json_encode($result);
});

function addStudent($student)
{

    $sql = "
    insert into students (firstname, lastname, gender,  email, password, telephone)
    VALUES (:firstname, :lastname, :gender, :email, :password, :telephone)
    ";

    $studentArray = (array) $student;
   var_dump($studentArray);

    try
    {
        $prepared = db::get()->prepare($sql);
        $prepared->execute($studentArray);
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }

}

$app->run();

?>