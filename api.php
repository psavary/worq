<?php
require './lib/slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

//add meedoo
require  './lib/medoo.php';


function getData()
{
    $database = new medoo;
    $data = $database->select("students", "*");
    //@psa todo
    die (var_dump(getData()));
    return $data;
}



$app = new \Slim\Slim(array(
    'debug' => true
));

$app->get('/hello/:name', function ($name) {
    //@psa todo
    die (var_dump(getData()));

    echo '[
      {"id": "1", "studentname": "'.$name.'", "study": "Informatik", "region": "Ostschweiz"},
      {"id": "2", "studentname": "Max Muster",    "study": "Psychologie", "region": "Ostschweiz"},
      {"id": "3", "studentname": "Maya Muster", "study": "Informatik", "region": "Zentralschweiz"},
      {"id": "4", "studentname": "Melanie Müller", "study": "Wirtschaft", "region": "Westschweiz"}
    ]';
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
    
    echo '[
      {"id": "1", "name": "Studiengang"},
      {"id": "Informatik", "name": "Informatik"},
      {"id": "Psychologie", "name": "Psychologie"},
      {"id": "Wirtschaft", "name": "Wirtschaft"}
    ]';
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

$app->run();

?>