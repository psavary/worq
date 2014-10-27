<?php
require './lib/slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

//add meedoo
include_once  'database.php'; //@psa todo refactor with autoloader;


$app = new \Slim\Slim(array(
    'debug' => true
));

$app->get('/hello/', function () {
    //@psa todo

    $data = database::get()->select("students", "*");

    //@psa todo
    die (var_dump(json_encode($data)));

   /* echo '[
      {"id": "1", "studentname": "dddd", "study": "Informatik", "region": "Ostschweiz"},
      {"id": "2", "studentname": "Max Muster",    "study": "Psychologie", "region": "Ostschweiz"},
      {"id": "3", "studentname": "Maya Muster", "study": "Informatik", "region": "Zentralschweiz"},
      {"id": "4", "studentname": "Melanie Müller", "study": "Wirtschaft", "region": "Westschweiz"}
    ]';*/
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