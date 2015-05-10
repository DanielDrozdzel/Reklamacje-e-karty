<?php
require_once("../app/model/znajdz.php");
require_once("../app/model/zapisz.php");
require_once("Database_con.php");

class ZapiszTest extends DatabaseCon
{
	
	protected $mocked_actual;
	


   public function testGo() {
	    $this->buildMocked("znajdz", array("id"=>null, "data"=>"01-05-2015", "imie"=>"daniel", "nazwisko"=>"danielewicz", "karta"=>"00000000001", "kwota"=>"8,00","stan"=>null, "miejsce"=>"Mps", "extra"=>null)); 
		$zapisz = new Zapisz($this->mocked);
		$znajdz = new Znajdz($this->mocked_actual);
		$zapytanie = substr($znajdz->getZapytanie(), 0, -1)." limit 1";
		
		$queryTable = $this->getConnection()->createQueryTable("reklamacje", $zapytanie );
		$expectedTable = $this->getDataSet()->getTable("reklamacje");
		
		$this->assertTablesEqual($expectedTable, $queryTable);

   }
   
    public function testControllerIsUsed() {
		$zapisz = new Zapisz($this->mocked);
	   $this->buildMocked("znajdz", array("id"=>null, "data"=>"01-05-2015", "imie"=>"daniel", "nazwisko"=>"danielewicz", "karta"=>"00000000001", "kwota"=>"8,00","stan"=>null, "miejsce"=>"Mps", "extra"=>null)); 
	   $controller = $this->mocked_actual;
	   $this->met_controller($controller, array(array("id"=>'1', "data"=>"01-05-2015", "imie"=>"daniel", "nazwisko"=>"danielewicz", "karta"=>"00000000001", "kwota"=>"8,00","stan"=>null, "miejsce"=>"Mps", "ekstra"=>null)));
	   
	   $znajdz = new Znajdz($controller);
	   
	}
	
}

?>