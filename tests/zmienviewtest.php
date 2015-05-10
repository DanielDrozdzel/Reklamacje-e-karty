<?php

require_once("../app/view/zmien_view.php");
require_once("View_TestCase.php");

class ZapiszViewTest extends View_TestCase {
	
	private $expected;
	private $mocked_controller;

	
	public function setUp() {
		
	   $mocked_controller = $this->getMockBuilder("\app\controller\Controller")->setMethods(array("getWynikModel", "setWynikWidok"))->getMock();
	   
	   $result = array("id"=>1, "data"=>"01-05-2015", "imie"=>"tomek", "nazwisko"=>"danielewicz",
	   "karta"=>"00000000001", "kwota"=>"8,00","stan"=>null, "miejsce"=>"Mps", "extra"=>null);
	   
	   $mocked_controller->method("getWynikModel")->willReturn($result);
	 
	   $this->mocked_controller = $mocked_controller;
 
		
		$expected = "<p>Zmieniono dane reklamacji nr. ".$result["id"]." na: </p><table><tr>";
		foreach ($result as $key=>$val) {
				$expected .= "<td><a class='hrefs' href='nr=".$result['id']."'>".strtoupper($key)." : ".ucfirst($val)."</a></td>";
			}
		$expected .= "</tr></table>";
		
		$this->expected = $expected;
	}
	
	public function testShow() {
		$zmien = new Zmien_view($this->mocked_controller);
		$this->assertEquals($this->expected, PHPUnit_Framework_Assert::readAttribute($zmien, 'wynik'));
	}
	
	public function testControllerIsUsed() {
		$controller = $this->mocked_controller;
		$this->check_controller($controller, $this->expected);
		$zmien = new Zmien_view($controller);
	}	
	
}