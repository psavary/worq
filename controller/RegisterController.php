<?php
/**
 * User: philou
 * Date: 18.03.14
 */



class RegisterController
{

    function __construct($template)
    {



        $template->title = 'Register for WorQ';
        $template->header = 'WorQ';
        //$template->experiences = $experiences;
        // execute the template
        try
        {
            echo $template->execute();
        }
        catch (Exception $e)
        {
            echo $e;
        }
    }
}




?>
