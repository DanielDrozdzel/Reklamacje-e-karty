<?php

require_once("../app/view/znajdz_view.php");
require_once("View_TestCase.php");

class ZapiszViewTest extends View_TestCase {
	
	private $expected;
	private $mocked_controller;

	
	public function setUp() {
		
	   $mocked_controller = $this->getMockBuilder("\app\controller\Controller")->setMethods(array("getAll", "getWynikModel", "setWynikWidok"))->getMock();
	   
	   $result = array("id"=>1, "data"=>"01-05-2015", "imie"=>"tomek", "nazwisko"=>"danielewicz",
	   "karta"=>"00000000001", "kwota"=>"8,00","stan"=>null, "miejsce"=>"Mps", "extra"=>null);
	   
	   $mocked_controller->method("getWynikModel")->willReturn(array($result));
	   $mocked_controller->method("getAll")->willReturn($result + array("sprawdz"=>"proba"));
	 
	   $this->mocked_controller = $mocked_controller;
 
		
		$html = "<table>";
		$html .= "<tr class='column'>";
		
		$dane = array($result);
		
		foreach($result as $key=>$val) {
			$html.= "<td>".strtoupper($key)."</td>";
		}
		$html .="</tr>";
		foreach($dane as $row) {
		$html .= '<tr class="rows">';
			foreach ($row as $key=>$val) {
				$html .= "<td><a class='hrefs' href='nr=".$row["id"]."'>".ucfirst($val)."</a></td>";
			}
		$html .= "</tr>";
		}
		$html .= "</table>";
		$this->expected = $html;
	}
	
	public function testShow() {
		$znajdz = new Znajdz_view($this->mocked_controller);
		$this->assertEquals($this->expected, PHPUnit_Framework_Assert::readAttribute($znajdz, 'wynik'));
	}
	
	public function testControllerIsUsed() {
		$controller = $this->mocked_controller;
		$this->check_controller($controller, $this->expected);
		$controller->expects($this->once())->method("getAll");
		
		$znajdz = new Znajdz_view($controller);
	}	
	
}