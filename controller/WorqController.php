<?php
/**
 * User: philou
 * Date: 18.03.14
 */



class WorqController
{

   function __construct($template)
   {
	


		$template->title = 'This is WorQ';
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
