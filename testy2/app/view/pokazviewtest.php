<?php

require_once("../../../app/view/pokaz_view.php");
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
 
		
		$html = "<div id='popraw'><p style='text-align:center'> REKLAMACJA NR.".$result["id"];
		$html .= "<form name='form_zmien' id='form_zmien' action='controller.php' method='POST'>";
		
		foreach($result as $key=>$val) {
			if($key === "id") {
				$html .= "<p>".strtoupper($key).": <input type='text' id='".$key."' name='".$key."' size='20' value='".$val."' readonly='readonly'/></p> ";
			} else if($key ==="ekstra") {
				$html .= "<p>Ekstra: <textarea rows='3' cols='20' name='ekstra'>".$val."</textarea><p>";
			} else {
				$key = ucfirst($key);
				$val = ucfirst($val);
				$html .= "<p>".$key.": <input type='text' class='".$key."' name='".$key."' size='20' value='".$val."' /></p> ";
			}
		}
		$html .= "<p style='text-align: center;'><input type='submit' value='Zmien' name='sprawdz'><p></form></div>";
		
		$this->expected = $html;
	}
	
	public function testShow() {
		$pokaz = new Pokaz_view($this->mocked_controller);
		$this->assertEquals($this->expected, PHPUnit_Framework_Assert::readAttribute($pokaz, 'wynik'));
	}
	
	public function testControllerIsUsed() {
		$controller = $this->mocked_controller;
		$this->check_controller($controller, $this->expected);
		$pokaz= new Pokaz_view($controller);
	}	
	
}