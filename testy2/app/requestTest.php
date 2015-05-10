<?php 
require_once("../../app/request.php");

use app\request\Request as uRequest;

class RequestTest extends PHPUnit_Framework_TestCase 
{
	private $request;


	public function test_getPropertyTrue() {
			$check = new uRequest("zapisz");
			$result = $check->getProperty('imie');
			$this->assertEquals($result, 'daniel');
		
	}
	
	public function test_getPropertyFalse() {
			$check = new uRequest("zapisz");
			$check->getProperty('imie');
			$this->assertNotSame($check, 'damian');
	}
	
	public function test_getPropertyException() {
		try {	
			$check = new uRequest("zapisz");
			$check->getProperty('wiek');
			$this->fail("Zly parametr");
		} catch (Exception $e) {}
	}
	
	public function test_getPropertiesNull() {
		$check = new uRequest("zapisz");
		$check->getProperties();
		$this->assertNotNull($check);
	}
	
	public function test_getPropertiesException() {
		try {
			$check = new uRequest(null);
			$check->getProperties();
			$this->fail("Brak danych");
		} catch (Exception $e) {}
	}
	
	
	public function test_getDestinationPokaz() {
		$check = new uRequest("pokaz");
		$result = $check->getDestination();
		$this->assertEquals($result, 'pokaz');
	}
	
	public function test_getDestinationZmien() {
		$check = new uRequest("zmien");
		$result = $check->getDestination();
		
		$this->assertEquals($result, 'zmien');
	}
	
	public function test_getDestinationZnajdz() {
		$check = new uRequest("znajdz");
		$result = $check->getDestination();
		$this->assertEquals($result, 'znajdz');
	}		
		
		
}
	
	
	
?>
		