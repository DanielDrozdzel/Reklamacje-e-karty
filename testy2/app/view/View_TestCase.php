<?php

abstract class View_TestCase extends PHPUnit_Framework_TestCase {
	public function check_controller($controller, $wynik){
	 $controller->expects($this->once())->method("getWynikModel");
	 $controller->expects($this->once())->method("setWynikWidok")->with($this->equalTo($wynik));
   }
	
	
}







?>