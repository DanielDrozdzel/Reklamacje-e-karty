<?php
require_once("../../../app/model/pokaz.php");
require_once("../../../app/model/zapisz.php");
require_once("Database_con.php");

class ZapiszTest extends DatabaseCon
{
	protected $mocked_actual;
	
	
	
   public function testGo() {
	   $this->buildMocked("pokaz", array("nr"=>1));
	    $zapisz = new Zapisz($this->mocked);
		$znajdz = new Pokaz($this->mocked_actual);
		$zapytanie = $znajdz->getZapytanie();

		$queryTable = $this->getConnection()->createQueryTable("reklamacje", $zapytanie);
		$expectedTable = $this->getDataSet()->getTable("reklamacje");
	
		$this->assertTablesEqual($expectedTable, $queryTable);
   }
   
   public function testControllerIsUsed() {
		$zapisz = new Zapisz($this->mocked);
	  $this->buildMocked("pokaz", array("nr"=>1));
	   $controller = $this->mocked_actual;
	   $this->met_controller($controller, array("id"=>'1', "data"=>"01-05-2015", "imie"=>"daniel", "nazwisko"=>"danielewicz", "karta"=>"00000000001", "kwota"=>"8,00","stan"=>null, "miejsce"=>"Mps", "ekstra"=>null));
	   
	   $pokaz = new Pokaz($controller);
	   
	}
   
	
}

?>