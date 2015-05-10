<?php
require_once("../../../app/model/zapisz.php");
require_once("Database_con.php");

class ZapiszTest extends DatabaseCon
{
		
   public function testGo() {
	    $reklamacje = new Zapisz($this->mocked);

		$queryTable = $this->getConnection()->createQueryTable("reklamacje", "select * from reklamacje where id=1");
		$expectedTable = $this->getDataSet()->getTable("reklamacje");
		
		$this->assertTablesEqual($expectedTable, $queryTable);
   }
   
	public function testControllerIsUsed() {
	   $controller = $this->mocked;
	   $this->met_controller($controller, array("id"=>'1', "data"=>"01-05-2015", "imie"=>"daniel", 
	   "nazwisko"=>"danielewicz", "karta"=>"00000000001", "kwota"=>"8,00","stan"=>null, "miejsce"=>"Mps"));
	   
	   $zapisz = new Zapisz($controller);
	   
	}
	
}

?>