<?php
require './lib/slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();


$app = new \Slim\Slim(array(
    'debug' => true
));

$app->get('/hello/:name', function ($name) {
    
    echo '[
      {"id": "1", "studentname": "'.$name.'", "study": "Informatik", "region": "Ostschweiz"},
      {"id": "2", "studentname": "Max Muster",    "study": "Psychologie", "region": "Ostschweiz"},
      {"id": "3", "studentname": "Maya Muster", "study": "Informatik", "region": "Zentralschweiz"},
      {"id": "4", "studentname": "Melanie M�ller", "study": "Wirtschaft", "region": "Westschweiz"}
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

$app->run();

?>