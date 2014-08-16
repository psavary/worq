<?php
/**
 * User: philou
 * Date: 15.05.14
 */
class Worq
{
    public $name;
	public $label;

    function __construct($name, $label=null) {
        $this->name = $name;
		$this->label = $label;
    }

}
?>
