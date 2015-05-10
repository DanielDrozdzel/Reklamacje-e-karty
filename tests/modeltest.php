<?php
require_once("../app/model/model.php");
require_once("../app/model/zapisz.php");

class ModelTest extends PHPUnit_Framework_TestCase
{
	private $mocked;
	
	public function setUp() {
		  $mocked_controller = $this->getMockBuilder("\app\controller\Controller")->setMethods(array("getAll", "findDestination", "setWynikModel"))->getMock();
		  $this->mocked = $mocked_controller;
	}
		
		
    public function testControllerIsUsed() {
       $controller = $this->mocked;
	   $controller->expects($this->once())->method("getAll");
	   
	   $zapisz = new Zapisz($controller);
	   
	}
}












?>