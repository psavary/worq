<?php

spl_autoload_register('frameworkAutoload');

function frameworkAutoload($class)
{
    $includeArray = explode(':',get_include_path());

    //echo strpos(strtolower(PHP_OS), 'win');

    //explode include Path differently in case of Windows
    if (strpos(strtolower(PHP_OS), 'win') !== false)
    {
        //$includeArray = explode(';',get_include_path());
    }

    foreach($includeArray as $path)
    {
        //@psa added check for file_exists
        if (file_exists($path .'/'. $class . '.php') && !class_exists($path .'/'. $class . '.php'))
        {
            include_once $path .'/'. $class . '.php';

        }
        checkFileExists('./lib/' . $class . '.php');
        checkFileExists('./model/' . $class . '.php');
        checkFileExists('./view/' . $class . '.php');
        checkFileExists('./controller/' . $class . '.php');
    }
}

function checkFileExists($path)
{
    if (file_exists($path) && !class_exists($path))
    {
        include_once $path;

    }
    else
    {
        return false;
    }

}
?>

