<?php
require_once("../app/controller.php");


use app\controller\Controller as uController;


class ControllerTest extends PHPUnit_Framework_TestCase {
	
	private $control;

	public function setUp() {
		$this->control = new uController("test");	
	}
	
	public function tearDown() {
		unset($this->control);
	}
	
	
	public function testRequestsNotEmpty() {
		$this->assertAttributeNotEmpty("requests", $this->control);
	}
	

	public function testRequestInstanceOf() {	
	    $this->markTestSkipped("Namespace w atrybucie #1 asercji???");
		$this->assertAttributeInstanceOf("uRequest", "requests", $this->control);
	}
	
	public function testfindDestinationPokaz() {
			$controller = new uController("pokaz");
		$check = $controller->findDestination();
		$this->assertEquals("pokaz", $check);
	}
	
	public function testGetDestinationZnajdz() {
		$controller = new uController("znajdz");
		$check = $controller->findDestination("znajdz");
		$this->assertEquals("znajdz", $check);
		unset($controller);
	}
	
	public function testGetDestinationZapisz() {
		$controller = new uController("zapisz");
		$check = $controller->findDestination("zapisz");
		$this->assertEquals("zapisz", $check);
		unset($controller);
	}
	
	public function testGetAll() {
		$controller = new uController("znajdz");
		$result = array("imie"=>"daniel", "sprawdz"=>"znajdz");
		$check = $controller->getAll();
		
		$this->assertEquals($result, $check);
		unset($controller);
	}
	
	public function testwynikModelEmpty() {
		$this->assertAttributeEmpty("wynikModel", $this->control);
	}
	
	public function testwynikWidokEmpty() {
		$this->assertAttributeEmpty("wynikWidok", $this->control);
	}
	
	public function testSetGetWynikModel() {
		$array = array("imie"=>"daniel");
		$set = $this->control->setWynikModel($array);
		$this->assertAttributeEquals($array, "wynikModel", $this->control);
		
		$get = $this->control->getWynikModel();
		$this->assertEquals($array, $get);
	}
	
	public function testSetWynikWidok() {
		$html = "Use the force";	
		$set = $this->control->setWynikWidok($html);		
		$this->assertAttributeEquals($html, "wynikWidok", $this->control);
	}	
	
	public function testGetWynikWidok() {
		$reflect = new ReflectionClass(get_class($this->control));
		$method = $reflect->getMethod('getWynikWidok');
		$method->setAccessible(true);
 
		$this->expectOutputString($method->invokeArgs($this->control, array("Use the force")));
	}
	
		
	


}
?>