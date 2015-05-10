<?php

require_once("../app/view/zapisz_view.php");
require_once("View_TestCase.php");

class ZapiszViewTest extends View_TestCase {
	
	private $expected;
	private $mocked_controller;

	
	public function setUp() {
		
	   $mocked_controller = $this->getMockBuilder("\app\controller\Controller")->setMethods(array("getWynikModel", "setWynikWidok"))->getMock();
	   
	   $result = array("id"=>1, "data"=>"01-05-2015", "imie"=>"daniel", "nazwisko"=>"danielewicz",
	   "karta"=>"00000000001", "kwota"=>"8,00","stan"=>null, "miejsce"=>"Mps", "extra"=>null);
	   
	   $mocked_controller->method("getWynikModel")->willReturn($result);
	 
	   $this->mocked_controller = $mocked_controller;
 
		
		$expected = "Zapisano następujące dane: <table><tr class='rows'>";
		foreach ($result as $key=>$val) {
				$expected .= "<td><a class='hrefs' href='nr=".$result['id']."'>".strtoupper($key)." : ".ucfirst($val)."</a></td>";
			}
		$expected .= "</tr></table>";
		
		$this->expected = $expected;
	}
	
	public function testShow() {
		$zapisz = new Zapisz_view($this->mocked_controller);
		$this->assertEquals($this->expected, PHPUnit_Framework_Assert::readAttribute($zapisz, 'wynik'));
	}
	
	public function testControllerIsUsed() {
		$controller = $this->mocked_controller;
		$this->check_controller($controller, $this->expected);
		$zapisz = new Zapisz_view($controller);
	}	
	
}