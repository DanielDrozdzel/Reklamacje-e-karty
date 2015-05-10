<?php

require_once('../app/error/error.php');

class ErrorTest extends PHPUnit_Framework_TestCase {
	private $error;

	public function setUp() {
		$this->error = new Error(new Exception());
	}
	
	public function testErrorLogTrue() {
		$this->assertTrue($this->error->errorLog());
	}
	
		
	
	
	
}
	
	
	
?>
		