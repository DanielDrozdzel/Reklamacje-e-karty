<?php
require_once("../../../app/model/zmien.php");
require_once("../../../app/model/zapisz.php");
require_once("Database_con.php");

class ZapiszTest extends DatabaseCon
{
	protected $mocked_actual;
	

	
   public function testGo() {
	    $this->buildMocked("zmien", array("id"=>1, "data"=>"01-05-2015", "imie"=>"tomek", "nazwisko"=>"danielewicz", "karta"=>"00000000001", "kwota"=>"8,00","stan"=>null, "miejsce"=>"Mps", "extra"=>null));
		$zapisz = new Zapisz($this->mocked);
		$znajdz = new Zmien($this->mocked_actual);

		$queryTable = $this->getConnection()->createQueryTable("reklamacje", "select * from reklamacje");
		$expectedTable = $this->createXMLDataset("rek_zmien.xml")->getTable("reklamacje");
		
		$this->assertTablesEqual($expectedTable, $queryTable);
   }
   
   public function testControllerIsUsed() {
	   $this->buildMocked("zmien", array("id"=>1, "data"=>"01-05-2015", "imie"=>"tomek", "nazwisko"=>"danielewicz", "karta"=>"00000000001", "kwota"=>"8,00","stan"=>null, "miejsce"=>"Mps", "extra"=>null));
	   $controller = $this->mocked_actual;
	   $this->met_controller($controller, array("id"=>1, "data"=>"01-05-2015", "imie"=>"tomek", 
	   "nazwisko"=>"danielewicz", "karta"=>"00000000001", "kwota"=>"8,00","stan"=>null, "miejsce"=>"Mps"));
	   
	   $zmien = new Zmien($controller);
	   
	}
   
   
 
}

?>