<?php

require_once('../../app/baza.php');

class BazaTest extends PHPUnit_Framework_TestCase {
	private $baza;

	public function setUp() {
		$this->baza = Baza::getBaza();
	}
	
	public function testgetPDONotSame() {
		$check = $this->baza->getPDO();
		$this->assertNotSame($check, new PDO("sqlite:reklamacja.sqlite"));
	}
	
	public function testGetPDOInstance() {
		$check = $this->baza->getPDO();
		$this->assertInstanceOf('PDO', $check);
	}
	
	public function testGetPDOEquals() {
		$check = $this->baza->getPDO();
		$this->assertEquals($check, new PDO("sqlite:reklamacja.sqlite"));
	}
	
	public function testGetBazaInstance() {
		$check = $this->baza->getBaza();
		$this->assertInstanceOf('Baza', $check);
	}
	
	public function testGetBazaSame() {
		$check = $this->baza->getBaza();
		$this->assertSame($check, Baza::getBaza());
	}
	
	public function testNotEmptyBaza() {
		$check = $this->baza->getBaza();
		$this->assertAttributeNotEmpty("baza", $check);
	}
	
	
	public function testNotEmptyPDO() {
		$check = $this->baza->getBaza();
		$this->assertAttributeNotEmpty("PDO", $check);
	}
	
	public function testBazaIsStatic() {
		$this->assertClassHasStaticAttribute("baza", "Baza");
	}
	
	public function testPDoIsStatic() {
		$this->assertClassHasStaticAttribute("PDO", "Baza");
	}
	
}
	
?>